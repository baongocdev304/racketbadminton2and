<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Marketing & Nội Dung';

    protected static ?string $modelLabel = 'Bài Viết';

    protected static ?string $pluralModelLabel = 'Tin Tức & Kiến Thức Vợt';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nội Dung Bài Viết')
                    ->schema([
                        Hidden::make('user_id')
                            ->default(fn () => Auth::id()),

                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Tiêu đề bài viết')
                                ->placeholder('VD: Hướng dẫn phân biệt vợt cầu lông Yonex thật và giả')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Post::class, 'slug', ignoreRecord: true),
                        ]),

                        Grid::make(2)->schema([
                            DateTimePicker::make('published_at')
                                ->label('Thời gian xuất bản')
                                ->default(now()),

                            Toggle::make('is_published')
                                ->label('Công khai bài viết')
                                ->default(true),
                        ]),

                        FileUpload::make('thumbnail')
                            ->label('Ảnh đại diện bài viết')
                            ->image()
                            ->directory('posts')
                            ->imageEditor(),

                        Textarea::make('summary')
                            ->label('Tóm tắt ngắn (Trích dẫn SEO)')
                            ->rows(3),

                        RichEditor::make('content')
                            ->label('Nội dung chi tiết')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Ảnh bìa')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder-post.png'),

                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->wrap()
                    ->weight('bold'),

                TextColumn::make('author.name')
                    ->label('Tác giả')
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_published')
                    ->label('Đã xuất bản')
                    ->boolean(),

                TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
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
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
