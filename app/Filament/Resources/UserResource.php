<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role')
                    ->options([
                        'driver' => 'Driver',
                        'supervisor_driver' => 'Supervisor Driver',
                        'vehicle_admin' => 'Vehicle Admin',
                        'supervisor_admin' => 'Supervisor Admin',
                    ])
                    ->required()
                    ->visible(fn($livewire) => auth()->user()->role === 'supervisor_admin'),

                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name')
                    ->required(),

                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),

                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->required(fn(string $operation): bool => $operation === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'supervisor_admin' => 'danger',
                        'vehicle_admin' => 'warning',
                        'supervisor_driver' => 'success',
                        'driver' => 'info',
                    }),
                Tables\Columns\TextColumn::make('region.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'driver' => 'Driver',
                        'supervisor_driver' => 'Supervisor Driver',
                        'vehicle_admin' => 'Vehicle Admin',
                        'supervisor_admin' => 'Supervisor Admin',
                    ]),
                Tables\Filters\SelectFilter::make('region')
                    ->relationship('region', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Jika user adalah supervisor driver, hanya tampilkan driver di region-nya
        if (auth()->user()->role === 'supervisor_driver') {
            return $query->where('region_id', auth()->user()->region_id)
                ->where('role', 'driver');
        }

        return $query;
    }
}
