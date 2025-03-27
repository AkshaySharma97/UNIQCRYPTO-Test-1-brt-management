<?php

namespace App\Filament\Admin\Resources\BRTResource\Pages;

use App\Filament\Admin\Resources\BRTResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBRTS extends ListRecords
{
    protected static string $resource = BRTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
