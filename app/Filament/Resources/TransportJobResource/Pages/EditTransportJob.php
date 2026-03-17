<?php

namespace App\Filament\Resources\TransportJobResource\Pages;

use App\Filament\Resources\TransportJobResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransportJob extends EditRecord
{
    protected static string $resource = TransportJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
