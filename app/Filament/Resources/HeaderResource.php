<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderResource\Pages;
use App\Models\Header;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class HeaderResource extends Resource
{
    protected static ?string $model = Header::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'CMS';

    public static function getPluralLabel(): string
    {
        return __('Header');
    }

    public static function getModelLabel(): string
    {
        return __('Header');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make('')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required(),
                        TextInput::make('url')
                            ->label('URL')
                            ->prefix(route('home') . '/')
                            ->required(),
                        TextInput::make('rank')
                            ->label('Rank')
                            ->integer()
                            ->required()
                    ]),
                Toggle::make('is_highlight')
                    ->label('Is Highlight')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul'),
                TextColumn::make('url')
                    ->label('URL')
                    ->prefix(route('home') . '/'),
                TextColumn::make('rank')->label('Rank'),
                ToggleColumn::make('is_highlight')->label('Is Highlight')
            ])
            ->defaultSort('rank', 'asc')
            ->filters([
                //
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
            'index' => Pages\ManageHeaders::route('/'),
        ];
    }
}
