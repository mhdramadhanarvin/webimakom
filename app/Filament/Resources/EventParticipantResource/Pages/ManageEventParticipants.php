<?php

namespace App\Filament\Resources\EventParticipantResource\Pages;

use App\Filament\Resources\EventParticipantResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\URL;

class ManageEventParticipants extends ManageRecords
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Scan Tiket Kehadiran')
                ->url(URL::signedRoute('event.ticket.check'))
                ->extraAttributes([
                    'target' => '_blank',
                ])
        ];
    }
}
