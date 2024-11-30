<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon  = 'heroicon-o-user-group';
  protected static ?string $navigationLabel = 'Daftar Pengguna';
  protected static ?string $modelLabel      = 'Daftar Pengguna';
  protected static ?int $navigationSort     = 3;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('')
          ->schema([
            Forms\Components\TextInput::make('name')
              ->required()
              ->maxLength(255)
              ->label('Nama Lengkap'),
            Forms\Components\TextInput::make('email')
              ->email()
              ->required()
              ->maxLength(255)
              ->unique(ignorable: fn ($record) => $record)
              ->label('Alamat Email'),
            Forms\Components\TextInput::make('password')
              ->password()
              ->required(fn (string $operation): string => $operation === 'create')
              ->maxLength(255)
              ->label('Kata Sandi'),
            Forms\Components\Select::make('roles')
              ->relationship('roles', 'name')
              ->preload()
              ->searchable()
              ->native(false)
              ->label('Hak Akses'),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('index')
          ->rowIndex()
          ->label('#'),
        Tables\Columns\TextColumn::make('name')
          ->searchable()
          ->sortable()
          ->toggleable()
          ->label('Nama Lengkap'),
        Tables\Columns\TextColumn::make('email')
          ->searchable()
          ->sortable()
          ->toggleable()
          ->label('Alamat Email'),
        Tables\Columns\TextColumn::make('roles.name')
          ->searchable()
          ->sortable()
          ->toggleable()
          ->label('Hak Akses'),
        Tables\Columns\TextColumn::make('created_at')
          ->since()
          ->sortable()
          ->label('Pengguna Sejak')
      ])
      ->filters([
        //
      ])
      ->recordAction(null)
      ->recordUrl(null)
      ->defaultSort('name', 'asc')
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\EditAction::make()
            ->mutateFormDataUsing(function (array $data, User $record): array {
              if (empty($data['password'])) unset($data['password']);
              $record->roles()->sync($data['roles']);
              return $data;
            })
            ->modalWidth(MaxWidth::Medium)
            ->color('primary'),

          Tables\Actions\DeleteAction::make()
            ->color('danger'),
        ])
      ])
      ->bulkActions([
        // Tables\Actions\BulkActionGroup::make([
        //   Tables\Actions\DeleteBulkAction::make(),
        // ]),
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
      // 'create' => Pages\CreateUser::route('/create'),
      // 'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
