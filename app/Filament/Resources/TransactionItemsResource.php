<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\menus;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Transaction_items;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\TransactionItemsResource\Pages;

class TransactionItemsResource extends Resource
{
    protected static ?string $model = transaction_items::class;
    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('transaction_id')
                    ->label('Transaction')
                    ->relationship('transaction', 'id')
                    ->required(),
                Select::make('menu_id')
                    ->label('Menu')
                    ->relationship('menu', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $menu = menus::find($state);
                        if ($menu) {
                            $set('price', $menu->price);
                        }
                    }),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $price = $get('price');
                        $set('total_price', $price * $state);
                    }),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
                    ->readOnly(),
                TextInput::make('total_price')
                    ->label('Total Price')
                    ->numeric()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('transaction.id')
                    ->label('Transaction ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('menu.name')
                    ->label('Menu')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactionItems::route('/'),
            'create' => Pages\CreateTransactionItems::route('/create'),
            'edit' => Pages\EditTransactionItems::route('/{record}/edit'),
        ];
    }
}
