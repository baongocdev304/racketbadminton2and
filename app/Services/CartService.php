<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Lấy danh sách toàn bộ các cây vợt trong giỏ hàng hiện tại (kèm thông tin ảnh và thương hiệu)
     *
     * @return Collection<int, Product>
     */
    public function getCartProducts(): Collection
    {
        $productIds = $this->getProductIds();

        if (empty($productIds)) {
            return new Collection();
        }

        return Product::with(['brand', 'primaryImage'])
            ->whereIn('id', $productIds)
            ->get();
    }

    /**
     * Lấy mảng ID sản phẩm trong giỏ hàng
     *
     * @return array<int>
     */
    public function getProductIds(): array
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        return session('cart', []);
    }

    /**
     * Thêm cây vợt vào giỏ hàng (kiểm tra trạng thái available và đảm bảo độc bản không trùng)
     *
     * @throws \Exception
     */
    public function add(int $productId): Product
    {
        $product = Product::with(['brand', 'primaryImage'])->findOrFail($productId);

        // Kiểm tra trạng thái vợt 2hand
        if ($product->status !== 'available') {
            throw new \Exception("Cây vợt \"{$product->name}\" hiện không còn sẵn để mua (đã bán hoặc đang giữ hàng).");
        }

        if (Auth::check()) {
            CartItem::firstOrCreate([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
            ]);
        } else {
            $cart = session('cart', []);
            if (!in_array($productId, $cart)) {
                $cart[] = $productId;
                session(['cart' => $cart]);
            }
        }

        return $product;
    }

    /**
     * Xóa một cây vợt khỏi giỏ hàng
     */
    public function remove(int $productId): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session('cart', []);
            $cart = array_values(array_filter($cart, fn ($id) => (int)$id !== $productId));
            session(['cart' => $cart]);
        }
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        }

        session()->forget('cart');
    }

    /**
     * Đếm số lượng sản phẩm trong giỏ hàng
     */
    public function count(): int
    {
        return count($this->getProductIds());
    }

    /**
     * Tính tổng tiền các cây vợt trong giỏ hàng (VND)
     */
    public function total(): int
    {
        return (int) $this->getCartProducts()->sum('price');
    }

    /**
     * Gộp giỏ hàng từ Session vào Database khi người dùng đăng nhập
     */
    public function mergeSessionToDatabase(User $user): void
    {
        $sessionProductIds = session('cart', []);

        if (!empty($sessionProductIds)) {
            // Lấy danh sách sản phẩm còn available để lưu vào database
            $validProducts = Product::whereIn('id', $sessionProductIds)
                ->where('status', 'available')
                ->pluck('id');

            foreach ($validProducts as $productId) {
                CartItem::firstOrCreate([
                    'user_id'    => $user->id,
                    'product_id' => $productId,
                ]);
            }

            // Xóa session giỏ hàng sau khi đã gộp thành công vào DB
            session()->forget('cart');
        }
    }
}
