<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventParticipantResource\Pages;
use App\Filament\Resources\EventParticipantResource\RelationManagers;
use App\Models\EventParticipant;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventParticipantResource extends Resource
{
    protected static ?string $model = EventParticipant::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationGroup = 'Event';

    public static function getPluralLabel(): string
    {
        return __('Peserta Event');
    }

    public static function getModelLabel(): string
    {
        return __('Peserta Event');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->readOnly()
                    ->required(),
                TextInput::make('phone_number')
                    ->label('Nomor Whatsapp')
                    ->required(),
                TextInput::make('institusion')
                    ->label('Asal Instansi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone_number')->label('Nomor Whatsapp')->searchable(),
                TextColumn::make('institusion')->label('Asal Instansi'),
                CheckboxColumn::make('is_attended')->label('Status Kehadiran')
            ])
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
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEventParticipants::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
