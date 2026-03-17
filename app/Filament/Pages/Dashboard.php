<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationLabel = 'Menú principal';
    
    // We override title so it also reflects in the browser tab
    protected static ?string $title = 'Menú principal';
}
