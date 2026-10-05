<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Quản lý Cửa Hàng';

    protected static ?string $modelLabel = 'Thương Hiệu';

    protected static ?string $pluralModelLabel = 'Thương Hiệu';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông Tin Thương Hiệu')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Tên thương hiệu')
                                ->placeholder('VD: Yonex, Victor, Lining...')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Brand::class, 'slug', ignoreRecord: true),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('website')
                                ->label('Website chính thức')
                                ->url()
                                ->placeholder('https://www.yonex.com'),

                            Toggle::make('is_active')
                                ->label('Kích hoạt hiển thị')
                                ->default(true),
                        ]),

                        FileUpload::make('logo')
                            ->label('Logo thương hiệu')
                            ->image()
                            ->directory('brands')
                            ->imageEditor(),

                        Textarea::make('description')
                            ->label('Mô tả thương hiệu')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder-brand.png'),

                TextColumn::make('name')
                    ->label('Tên hãng')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->color('gray'),

                TextColumn::make('products_count')
                    ->label('Số lượng vợt')
                    ->counts('products')
                    ->badge()
                    ->color('info'),

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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit'   => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
