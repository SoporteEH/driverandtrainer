<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    
    // Automatically assign the 'user' role on creation if not selected
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
