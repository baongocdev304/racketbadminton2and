<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Marketing & Nội Dung';

    protected static ?string $modelLabel = 'Banner Quảng Cáo';

    protected static ?string $pluralModelLabel = 'Banner Quảng Cáo';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông Tin Banner')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Tiêu đề Banner')
                                ->placeholder('VD: Xả kho vợt cũ đón hè - Giảm tới 40%')
                                ->required(),

                            TextInput::make('link_url')
                                ->label('Đường link chuyển hướng (URL)')
                                ->placeholder('/vot-cau-long-yonex.html hoặc https://...'),
                        ]),

                        Grid::make(3)->schema([
                            Select::make('position')
                                ->label('Vị trí hiển thị')
                                ->options([
                                    'home_hero'   => 'Slider chính đầu trang chủ',
                                    'home_middle' => 'Banner ngang giữa trang chủ',
                                    'sidebar'     => 'Banner thanh bên',
                                ])
                                ->default('home_hero')
                                ->required(),

                            TextInput::make('sort_order')
                                ->label('Thứ tự sắp xếp')
                                ->numeric()
                                ->default(1),

                            Toggle::make('is_active')
                                ->label('Kích hoạt hiển thị')
                                ->default(true),
                        ]),

                        FileUpload::make('image_path')
                            ->label('Hình ảnh Banner')
                            ->image()
                            ->directory('banners')
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Hình ảnh')
                    ->width(120)
                    ->height(60),

                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('position')
                    ->label('Vị trí')
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'home_hero'   => 'Slider đầu trang',
                        'home_middle' => 'Banner giữa trang',
                        'sidebar'     => 'Thanh bên',
                        default       => $state,
                    }),

                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean(),
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
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit'   => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
