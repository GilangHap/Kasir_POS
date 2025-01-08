<?php

namespace App\Filament\Resources\TransactionsResource\Pages;

use App\Filament\Resources\TransactionsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionsResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.resources.transaction-items.create', ['transaction_id' => $this->record->id]);
    }
}