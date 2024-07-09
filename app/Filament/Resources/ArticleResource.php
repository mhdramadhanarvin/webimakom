<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Article;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\ArticleResource\Pages;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'CMS';

    public static function getPluralLabel(): string
    {
        return __('Artikel');
    }

    public static function getModelLabel(): string
    {
        return __('Artikel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state, $context) {
                        if ($context === 'create') $set('slug', Str::slug($state) . rand(1,99));
                    })
                    ->maxLength(200)
                    ->required(),
                Select::make('article_category_id')
                    ->label('Kategori Artikel')
                    ->relationship(name: 'article_category', titleAttribute: 'name')
                    ->required(),
                Grid::make(2)
                    ->schema([
                        TextInput::make('slug')
                            ->readonly()
                            ->prefix(route('article') . '/')
                            ->maxLength(200)
                            ->required(),
                        TagsInput::make('keyword')
                            ->label('Kata Kunci')
                            ->placeholder('Kata kunci baru')
                            ->splitKeys(['Tab', ' '])
                    ]),
                Grid::make(2)
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->optimize('webp')
                            ->resize(50)
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->required(),
                    ]),
                Grid::make(1)
                    ->schema([
                        RichEditor::make('content')
                            ->fileAttachmentsDirectory('attachments')
                            ->fileAttachmentsVisibility('public')
                            ->required()
                    ]),
                Toggle::make('status')->label('Publish')
                    ->onColor('success')
                    ->inline()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->words(10)
                    ->searchable(),
                TextColumn::make('article_category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('thumbnail'),
                ToggleColumn::make('status')
                    ->label('Publish')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Dibuat Pada')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                CopyAction::make('Link')
                    ->copyable(fn ($record) => route('article.detail', ['slug' => $record->slug]))
                    ->icon('heroicon-o-link'),
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
            // 'index' => Pages\ListArticle::route('/'),
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
