<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\menus;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\menu_categories;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\MenuResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = menus::class;
    protected static ?string $navigationGroup = 'Menu';
    protected static ?string $navigationIcon = 'heroicon-s-circle-stack';
    protected static ?string $modelLabel = 'Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Menu')
                    ->required(),
                TextInput::make('price')
                    ->numeric()
                    ->label('Harga')
                    ->required(),
                Select::make('category_id')
                    ->label('Kategori')
                    ->options(menu_categories::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('description')
                    ->label('Deskripsi')
                    ->required(),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->directory('images')
                    ->disk('public')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Menu')
                    ->searchable(),
                TextColumn::make('formatted_price')
                    ->label('Harga')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->Url(fn($record) => asset('storage/' . $record->image)),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
