<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar';

    protected static ?string $navigationGroup = 'Event';

    public static function getPluralLabel(): string
    {
        return __('Event');
    }

    public static function getModelLabel(): string
    {
        return __('Event');
    }

    private static function getDateFormat($date): string
    {
        return (new DateTime($date))->format("d F Y H:i");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('event_name')
                    ->label('Judul')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state, $context, Get $get) {
                        if ($context === 'create') $set('link_registration', Str::slug($state) . rand(1, 99));
                        if ($get('is_registration_open') == false) $set('link_registration', null);
                    })
                    ->required(),
                TextInput::make('location')
                    ->label('Tempat Pelaksanaan')
                    ->required(),
                Grid::make(2)->schema([
                    DateTimePicker::make('event_start')
                        ->label('Tanggal Mulai Kegiatan')
                        ->required(),
                    DateTimePicker::make('event_end')
                        ->label('Tanggal Berakhir Kegiatan')
                        ->helperText('Kosongkan bila kegiatan hanya satu hari'),
                ]),
                Grid::make(2)->schema([
                    Toggle::make('is_registration_open')
                        ->label('Buka Pendaftaran Peserta?')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, $state, $context, Get $get) {
                            if ($context === 'create' && $state == true) $set('link_registration', Str::slug($get('event_name')) . rand(0, 99));
                            if ($state == false) $set('link_registration', null);
                        }),
                    TextInput::make('link_registration')
                        ->prefix(route('event.form', ''))
                        ->label('Link Pendaftaran')
                        ->readonly()
                        ->nullable(),
                ]),
                Grid::make(2)->schema([
                    DateTimePicker::make('open_registration_date')
                        ->label('Tanggal Pendaftaran Dibuka')
                        ->required(fn(Get $get) => $get('is_registration_open')),
                    DateTimePicker::make('close_registration_date')
                        ->label('Tanggal Pendaftaran Ditutup')
                        ->required(fn(Get $get) => $get('is_registration_open')),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event_name')->label('Nama Event')->searchable(),
                TextColumn::make('participants_attended_count')
                    ->label('Peserta Hadir')
                    ->getStateUsing(fn($record) => $record->participants()->where('is_attended', true)->count() . '/' . $record->participants()->count()),
                TextColumn::make('event_start')
                    ->label('Tgl Pelaksanaan')
                    ->getStateUsing(function (Model $record) {
                        return
                            self::getDateFormat($record->event_start)
                            . ' - ' .
                            self::getDateFormat($record->event_end);
                    }),
                TextColumn::make('open_registration_date')
                    ->label('Tgl Pendaftaran')
                    ->getStateUsing(function (Model $record) {
                        return
                            self::getDateFormat($record->open_registration_date)
                            . ' - ' .
                            self::getDateFormat($record->close_registration_date);
                    }),
                TextColumn::make('link_registration')
                    ->label('Link Pendaftaran')
                    ->copyable()
                    ->getStateUsing(fn(Model $model): string => $model->link_registration == null ? 'BELUM ADA' : 'KLIK DISINI')
                    ->copyMessage('Link copied')
                    ->copyableState(fn(Model $model): string => route('event.form', $model->link_registration ?? ''))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEvents::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
