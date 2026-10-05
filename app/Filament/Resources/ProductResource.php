<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Quản lý Cửa Hàng';

    protected static ?string $modelLabel = 'Vợt Cầu Lông';

    protected static ?string $pluralModelLabel = 'Danh Sách Vợt 2Hand';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // SECTION 1: THÔNG TIN CHUNG
                Section::make('Thông Tin Chung')
                    ->description('Tên vợt, mã SKU định danh độc bản, thương hiệu và danh mục')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('name')
                                ->label('Tên cây vợt')
                                ->placeholder('VD: Vợt Cầu Lông Yonex Astrox 88D Pro')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Set $set, ?string $state, ?string $operation) {
                                    if ($operation === 'create' && filled($state)) {
                                        $set('slug', Str::slug($state) . '-' . strtolower(Str::random(4)));
                                    }
                                })
                                ->columnSpan(2),

                            TextInput::make('sku')
                                ->label('Mã định danh SKU (Độc bản)')
                                ->default(fn () => '2H-' . strtoupper(Str::random(6)))
                                ->unique(Product::class, 'sku', ignoreRecord: true)
                                ->required()
                                ->columnSpan(1),
                        ]),

                        Grid::make(3)->schema([
                            TextInput::make('slug')
                                ->label('Đường dẫn URL (Slug)')
                                ->required()
                                ->unique(Product::class, 'slug', ignoreRecord: true)
                                ->columnSpan(1),

                            Select::make('brand_id')
                                ->label('Thương hiệu')
                                ->relationship('brand', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->columnSpan(1),

                            Select::make('category_id')
                                ->label('Danh mục')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->columnSpan(1),
                        ]),

                        RichEditor::make('description')
                            ->label('Bài viết mô tả chi tiết & Cảm nhận thực tế')
                            ->placeholder('Mô tả lối chơi, cảm giác cầm, công nghệ nổi bật...')
                            ->columnSpanFull(),
                    ]),

                // SECTION 2: THÔNG SỐ KỸ THUẬT
                Section::make('Thông Số Kỹ Thuật Chuyên Sâu')
                    ->description('Trọng lượng, độ cứng đũa, chu vi cán và sức căng của vợt')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('weight_class')
                                ->label('Trọng lượng')
                                ->options([
                                    '2U' => '2U (90 - 94g)',
                                    '3U' => '3U (85 - 89g)',
                                    '4U' => '4U (80 - 84g)',
                                    '5U' => '5U (75 - 79g)',
                                ])
                                ->default('4U')
                                ->required(),

                            Select::make('grip_size')
                                ->label('Chu vi cán cầm')
                                ->options([
                                    'G3' => 'G3 (Chu vi lớn)',
                                    'G4' => 'G4',
                                    'G5' => 'G5 (Chuẩn phổ biến nhất)',
                                    'G6' => 'G6 (Cán nhỏ cho tay bé)',
                                ])
                                ->default('G5')
                                ->required(),

                            TextInput::make('balance')
                                ->label('Điểm cân bằng')
                                ->placeholder('VD: Nặng đầu (~305mm)')
                                ->required(),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('flex')
                                ->label('Độ cứng đũa')
                                ->options([
                                    'Siêu cứng (Extra Stiff)'   => 'Siêu cứng (Extra Stiff)',
                                    'Cứng (Stiff)'             => 'Cứng (Stiff)',
                                    'Cứng vừa (Medium Stiff)'  => 'Cứng vừa (Medium Stiff)',
                                    'Trung bình (Medium)'      => 'Trung bình (Medium)',
                                    'Dẻo (Flexible)'           => 'Dẻo (Flexible)',
                                ])
                                ->default('Cứng (Stiff)')
                                ->required(),

                            TextInput::make('max_tension_lbs')
                                ->label('Mức căng tối đa')
                                ->numeric()
                                ->suffix('LBS (~kg)')
                                ->default(28)
                                ->required(),

                            TextInput::make('year')
                                ->label('Năm sản xuất / Ra mắt')
                                ->numeric()
                                ->default(date('Y')),
                        ]),

                        KeyValue::make('specifications')
                            ->label('Thông số mở rộng (Nếu có)')
                            ->keyLabel('Tên thuộc tính')
                            ->valueLabel('Giá trị')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                // SECTION 3: TÌNH TRẠNG 2HAND (ĐẶC THÙ HÀNG CŨ)
                Section::make('Tình Trạng Vợt 2Hand (Hàng Độc Bản)')
                    ->description('Đánh giá phân hạng, độ mới % và chi tiết vết xước thực tế')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('condition_grade')
                                ->label('Phân hạng chất lượng')
                                ->options([
                                    'A' => 'Hạng A: Siêu lướt (95% - 99%)',
                                    'B' => 'Hạng B: Đẹp keng (88% - 94%)',
                                    'C' => 'Hạng C: Vết xước chiến đấu (80% - 87%)',
                                ])
                                ->required()
                                ->native(false),

                            TextInput::make('condition_percent')
                                ->label('Độ mới thực tế (%)')
                                ->numeric()
                                ->minValue(50)
                                ->maxValue(100)
                                ->suffix('%')
                                ->required(),

                            Select::make('status')
                                ->label('Trạng thái sản phẩm')
                                ->options([
                                    'available' => 'Còn hàng (Available)',
                                    'reserved'  => 'Đang giữ hàng (Reserved)',
                                    'sold'      => 'Đã bán (Sold)',
                                ])
                                ->default('available')
                                ->required()
                                ->native(false),
                        ]),

                        Toggle::make('is_clearance')
                            ->label('Đánh dấu: Hàng xả kho giá sốc (Clearance Sale)')
                            ->default(false),

                        Textarea::make('condition_note')
                            ->label('Ghi chú tình trạng thực tế chi tiết')
                            ->placeholder('VD: Xước nhẹ góc 11h do cọ thảm, gen zin 100% chưa lún, cam kết khung nguyên thủy không nứt hàn nhiệt...')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                // SECTION 4: GIÁ BÁN & KHUYẾN MÃI
                Section::make('Giá Bán (VND)')
                    ->description('Thiết lập giá bán thực tế và giá tham chiếu so sánh')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('price')
                                ->label('Giá bán thực tế (VND)')
                                ->numeric()
                                ->suffix('đ')
                                ->helperText('Mỗi cây vợt là độc bản, khi khách đặt hàng sẽ giữ hoặc chốt bán cây này.')
                                ->required(),

                            TextInput::make('original_price')
                                ->label('Giá niêm yết tham chiếu (VND)')
                                ->numeric()
                                ->suffix('đ')
                                ->helperText('Giá vợt mới trên thị trường để hệ thống tự động tính % tiết kiệm cho khách.'),
                        ]),
                    ]),

                // SECTION 5: UPLOAD NHIỀU ẢNH CÓ SẮP XẾP
                Section::make('Hình Ảnh Thực Tế Của Cây Vợt')
                    ->description('Tải lên nhiều ảnh chụp thật mọi góc cạnh (khung, chụp mũ, cán cầm, tem chính hãng) và kéo thả sắp xếp')
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images')
                            ->label('Danh sách ảnh chụp thực tế')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Tệp ảnh chụp')
                                    ->image()
                                    ->directory('products')
                                    ->imageEditor()
                                    ->required(),

                                TextInput::make('alt_text')
                                    ->label('Mô tả ảnh (SEO / Chú thích)')
                                    ->placeholder('VD: Cận cảnh vết xước vành góc 2h'),

                                Toggle::make('is_primary')
                                    ->label('Ảnh đại diện chính')
                                    ->default(false),

                                TextInput::make('sort_order')
                                    ->label('Thứ tự hiển thị')
                                    ->numeric()
                                    ->default(1),
                            ])
                            ->orderColumn('sort_order')
                            ->defaultItems(1)
                            ->collapsible()
                            ->grid(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('primaryImage.image_path')
                    ->label('Ảnh')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder-racket.png'),

                TextColumn::make('sku')
                    ->label('Mã SKU')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('Tên cây vợt')
                    ->searchable()
                    ->wrap()
                    ->limit(40),

                TextColumn::make('brand.name')
                    ->label('Hãng')
                    ->sortable()
                    ->badge(),

                TextColumn::make('condition_grade')
                    ->label('Hạng')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($record) => "Hạng {$record->condition_grade} ({$record->condition_percent}%)"),

                TextColumn::make('price')
                    ->label('Giá bán')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . 'đ')
                    ->weight('bold')
                    ->color('danger'),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'reserved'  => 'warning',
                        'sold'      => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Còn hàng',
                        'reserved'  => 'Đang giữ',
                        'sold'      => 'Đã bán',
                        default     => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // FILTER THEO THƯƠNG HIỆU
                SelectFilter::make('brand_id')
                    ->label('Thương hiệu')
                    ->relationship('brand', 'name')
                    ->preload(),

                // FILTER THEO TRẠNG THÁI (AVAILABLE / RESERVED / SOLD)
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'available' => 'Còn hàng (Available)',
                        'reserved'  => 'Đang giữ hàng (Reserved)',
                        'sold'      => 'Đã bán (Sold)',
                    ]),

                // FILTER THEO PHÂN HẠNG VỢT (A / B / C)
                SelectFilter::make('condition_grade')
                    ->label('Phân hạng vợt')
                    ->options([
                        'A' => 'Hạng A: Siêu lướt (95-99%)',
                        'B' => 'Hạng B: Đẹp keng (88-94%)',
                        'C' => 'Hạng C: Vết xước chiến đấu (80-87%)',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
