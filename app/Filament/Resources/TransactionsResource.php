<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\transactions;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\TransactionsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionsResource extends Resource
{
    protected static ?string $model = transactions::class;
    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationIcon = 'heroicon-s-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->numeric()
                    ->required(),
                TextInput::make('discount')
                    ->label('Diskon')
                    ->numeric(),
                TextInput::make('final_price')
                    ->label('Harga Akhir')
                    ->numeric()
                    ->required(),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Cash',
                        'digital' => 'Digital',
                    ])
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'completed' => 'Completed',
                        'pending' => 'Pending',
                        'failed' => 'Failed',
                    ]),
                Select::make('user_id')
                    ->label('Customer')
                    ->relationship('loyalty_program', 'customer_name')
                    ->nullable()
                    ->required(),
                Select::make('promotion_id')
                    ->label('Promotion')
                    ->nullable()
                    ->relationship('promotion', 'name'), // Relasi ke promotion
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('discount')
                    ->label('Diskon')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('final_price')
                    ->label('Harga Akhir + PPN')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('loyalty_program.customer_name')
                //     ->label('Customer') // Menampilkan nama dari relasi loyalty_program
                //     ->sortable()
                //     ->searchable(),
                TextColumn::make('promotion.name')
                    ->label('Promotion') // Menampilkan nama dari relasi promotion
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime('F j, Y, g:i a')
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }
}

