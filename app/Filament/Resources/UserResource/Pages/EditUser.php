<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class EditUser extends ListRecords
{
    protected static string $resource = UserResource::class;
}
