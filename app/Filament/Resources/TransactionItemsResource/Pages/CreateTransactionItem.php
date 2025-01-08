<?php

namespace App\Filament\Resources\TransactionItemsResource\Pages;

use App\Filament\Resources\TransactionItemsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactionItem extends CreateRecord
{
    protected static string $resource = TransactionItemsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['transaction_id'] = request()->get('transaction_id');
        return $data;
    }
}