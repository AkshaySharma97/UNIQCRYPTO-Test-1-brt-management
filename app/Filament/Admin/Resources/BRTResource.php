<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BRTResource\Pages;
use App\Models\BRT;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BRTResource extends Resource
{
    protected static ?string $model = BRT::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('brt_code')
                ->label('BRT Code')
                ->required()
                ->columnSpan(2),

            Forms\Components\TextInput::make('reserved_amount')
                ->label('Reserved Amount')
                ->required()
                ->numeric()
                ->columnSpan(2),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'expired' => 'Expired',
                ])
                ->required()
                ->columnSpan(2),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('brt_code')
                    ->label('BRT Code')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                Tables\Columns\TextColumn::make('reserved_amount')
                    ->label('Reserved Amount')
                    ->sortable()
                    ->money('USD')
                    ->color('success'),

                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->status === 'active' ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('User Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime('M d, Y h:i A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'active' => 'Active',
                        'expired' => 'Expired',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBRTS::route('/'),
            'create' => Pages\CreateBRT::route('/create'),
            'edit' => Pages\EditBRT::route('/{record}/edit'),
        ];
    }
}