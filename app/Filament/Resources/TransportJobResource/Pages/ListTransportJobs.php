<?php

namespace App\Filament\Resources\TransportJobResource\Pages;

use App\Filament\Resources\TransportJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransportJobs extends ListRecords
{
    protected static string $resource = TransportJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
