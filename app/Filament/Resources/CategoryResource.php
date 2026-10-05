<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Quản lý Cửa Hàng';

    protected static ?string $modelLabel = 'Danh Mục';

    protected static ?string $pluralModelLabel = 'Danh Mục Sản Phẩm';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông Tin Danh Mục')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Tên danh mục')
                                ->placeholder('VD: Vợt cầu lông, Giày, Phụ kiện...')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Category::class, 'slug', ignoreRecord: true),
                        ]),

                        Grid::make(2)->schema([
                            Select::make('parent_id')
                                ->label('Danh mục cha (nếu có)')
                                ->relationship('parent', 'name')
                                ->searchable()
                                ->preload(),

                            Toggle::make('is_active')
                                ->label('Kích hoạt hiển thị')
                                ->default(true),
                        ]),

                        FileUpload::make('image')
                            ->label('Ảnh đại diện danh mục')
                            ->image()
                            ->directory('categories'),

                        Textarea::make('description')
                            ->label('Mô tả danh mục')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Ảnh')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder-category.png'),

                TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->color('gray'),

                TextColumn::make('parent.name')
                    ->label('Danh mục cha')
                    ->badge()
                    ->color('secondary')
                    ->placeholder('Là cấp cao nhất'),

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
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
