<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Quản lý Cửa Hàng';

    protected static ?string $modelLabel = 'Đơn Hàng';

    protected static ?string $pluralModelLabel = 'Quản Lý Đơn Hàng';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // THÔNG TIN KHÁCH HÀNG & GIAO HÀNG
                Section::make('Thông Tin Người Nhận & Giao Hàng')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('order_code')
                                ->label('Mã đơn hàng')
                                ->disabled()
                                ->required(),

                            TextInput::make('customer_name')
                                ->label('Họ tên khách hàng')
                                ->required(),

                            TextInput::make('customer_phone')
                                ->label('Số điện thoại')
                                ->tel()
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('customer_email')
                                ->label('Email liên hệ')
                                ->email(),

                            TextInput::make('shipping_address')
                                ->label('Địa chỉ giao hàng')
                                ->required(),
                        ]),

                        Grid::make(3)->schema([
                            TextInput::make('shipping_city')->label('Tỉnh / Thành phố'),
                            TextInput::make('shipping_district')->label('Quận / Huyện'),
                            TextInput::make('shipping_ward')->label('Phường / Xã'),
                        ]),

                        Textarea::make('note')
                            ->label('Ghi chú của khách')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                // DANH SÁCH VỢT 2HAND ĐƯỢC ĐẶT MUA
                Section::make('Chi Tiết Sản Phẩm Đặt Mua')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                TextInput::make('product_name')
                                    ->label('Tên sản phẩm')
                                    ->disabled()
                                    ->columnSpan(2),

                                TextInput::make('product_sku')
                                    ->label('Mã SKU')
                                    ->disabled()
                                    ->columnSpan(1),

                                TextInput::make('price')
                                    ->label('Giá chốt (VND)')
                                    ->numeric()
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => number_format((int)$state, 0, ',', '.') . 'đ')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->addable(false)
                            ->deletable(false)
                            ->columnSpanFull(),
                    ]),

                // TÀI CHÍNH & TRẠNG THÁI
                Section::make('Thanh Toán & Trạng Thái Xử Lý')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('total_amount')
                                ->label('Tổng tiền hàng (VND)')
                                ->numeric()
                                ->disabled()
                                ->formatStateUsing(fn ($state) => number_format((int)$state, 0, ',', '.') . 'đ'),

                            TextInput::make('shipping_fee')
                                ->label('Phí vận chuyển (VND)')
                                ->numeric()
                                ->default(0),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('payment_method')
                                ->label('Phương thức thanh toán')
                                ->options([
                                    'cod'     => 'Thanh toán khi nhận hàng (COD)',
                                    'banking' => 'Chuyển khoản ngân hàng (QR Code)',
                                    'vnpay'   => 'Cổng thanh toán VNPay',
                                ])
                                ->required(),

                            Select::make('payment_status')
                                ->label('Trạng thái thanh toán')
                                ->options([
                                    'unpaid'   => 'Chưa thanh toán',
                                    'paid'     => 'Đã thanh toán',
                                    'refunded' => 'Đã hoàn tiền',
                                ])
                                ->required(),

                            Select::make('status')
                                ->label('Trạng thái đơn hàng')
                                ->options([
                                    'pending'   => 'Chờ xử lý (Pending)',
                                    'confirmed' => 'Đã xác nhận (Confirmed)',
                                    'shipping'  => 'Đang giao hàng (Shipping)',
                                    'completed' => 'Hoàn tất (Completed)',
                                    'cancelled' => 'Đã hủy (Cancelled)',
                                ])
                                ->required(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_code')
                    ->label('Mã Đơn')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('customer_name')
                    ->label('Khách hàng')
                    ->searchable(),

                TextColumn::make('customer_phone')
                    ->label('Số điện thoại')
                    ->searchable(),

                TextColumn::make('total_amount')
                    ->label('Tổng tiền')
                    ->formatStateUsing(fn ($state) => number_format((int)$state, 0, ',', '.') . 'đ')
                    ->weight('bold')
                    ->color('danger')
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Thanh toán')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid'     => 'success',
                        'unpaid'   => 'warning',
                        'refunded' => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid'     => 'Đã thanh toán',
                        'unpaid'   => 'Chưa trả tiền',
                        'refunded' => 'Đã hoàn tiền',
                        default    => $state,
                    }),

                TextColumn::make('status')
                    ->label('Trạng thái đơn')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'confirmed' => 'info',
                        'shipping'  => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'   => 'Chờ xử lý',
                        'confirmed' => 'Đã xác nhận',
                        'shipping'  => 'Đang giao',
                        'completed' => 'Hoàn tất',
                        'cancelled' => 'Đã hủy',
                        default     => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Thời gian đặt')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái đơn hàng')
                    ->options([
                        'pending'   => 'Chờ xử lý',
                        'confirmed' => 'Đã xác nhận',
                        'shipping'  => 'Đang giao',
                        'completed' => 'Hoàn tất',
                        'cancelled' => 'Đã hủy',
                    ]),

                SelectFilter::make('payment_status')
                    ->label('Trạng thái thanh toán')
                    ->options([
                        'unpaid'   => 'Chưa thanh toán',
                        'paid'     => 'Đã thanh toán',
                        'refunded' => 'Đã hoàn tiền',
                    ]),
            ])
            ->actions([
                // 1. Chuyển trạng thái: Pending -> Confirmed
                Action::make('confirm')
                    ->label('Xác nhận')
                    ->icon('heroicon-m-check')
                    ->color('info')
                    ->visible(fn (Order $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận đơn hàng')
                    ->modalDescription('Bạn có chắc chắn muốn xác nhận đơn hàng này để chuẩn bị đóng gói?')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()->title('Đã xác nhận đơn hàng thành công')->success()->send();
                    }),

                // 2. Chuyển trạng thái: Confirmed -> Shipping
                Action::make('ship')
                    ->label('Giao hàng')
                    ->icon('heroicon-m-truck')
                    ->color('primary')
                    ->visible(fn (Order $record) => $record->status === 'confirmed')
                    ->requiresConfirmation()
                    ->modalHeading('Bắt đầu giao hàng')
                    ->modalDescription('Chuyển đơn hàng sang trạng thái Đang giao?')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'shipping']);
                        Notification::make()->title('Đơn hàng đã được chuyển cho đơn vị vận chuyển')->success()->send();
                    }),

                // 3. Chuyển trạng thái: Shipping -> Completed
                Action::make('complete')
                    ->label('Hoàn tất')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->visible(fn (Order $record) => $record->status === 'shipping')
                    ->requiresConfirmation()
                    ->modalHeading('Hoàn tất giao hàng')
                    ->modalDescription('Khách hàng đã nhận được vợt và thanh toán đủ tiền?')
                    ->action(function (Order $record) {
                        $record->update([
                            'status'         => 'completed',
                            'payment_status' => 'paid',
                        ]);

                        // Đảm bảo đánh dấu vợt 2hand này chính thức là 'sold'
                        foreach ($record->items as $item) {
                            Product::where('id', $item->product_id)->update(['status' => 'sold']);
                        }

                        Notification::make()->title('Đơn hàng đã hoàn tất thành công')->success()->send();
                    }),

                // 4. Hủy đơn hàng: Pending/Confirmed -> Cancelled
                Action::make('cancel')
                    ->label('Hủy đơn')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->visible(fn (Order $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->requiresConfirmation()
                    ->modalHeading('Hủy đơn hàng')
                    ->modalDescription('Cảnh báo: Hủy đơn sẽ mở khóa lại cây vợt 2hand sang trạng thái Có sẵn (available) để khách khác có thể đặt mua.')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'cancelled']);

                        // Nhả lại cây vợt 2hand sang 'available'
                        foreach ($record->items as $item) {
                            Product::where('id', $item->product_id)->update(['status' => 'available']);
                        }

                        Notification::make()->title('Đã hủy đơn hàng và hoàn trả vợt về kho')->warning()->send();
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
