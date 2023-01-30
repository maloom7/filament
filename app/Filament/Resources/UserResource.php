<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
// use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Settings';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
               

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')

                    ->maxLength(255),
                // Forms\Components\Textarea::make('two_factor_secret')
                //     ->maxLength(65535),
                // Forms\Components\Textarea::make('two_factor_recovery_codes')
                //     ->maxLength(65535),
                // Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
                // Forms\Components\TextInput::make('current_team_id'),
                // Forms\Components\TextInput::make('profile_photo_path')
                //     ->maxLength(2048),
                ])->columns(2)
  
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()->sortable(),
                // Tables\Columns\TextColumn::make('two_factor_secret'),
                // Tables\Columns\TextColumn::make('two_factor_recovery_codes'),
                // Tables\Columns\TextColumn::make('two_factor_confirmed_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('current_team_id'),
                // Tables\Columns\TextColumn::make('profile_photo_path'),
                 Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),

               ]) 
               
            
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
}
