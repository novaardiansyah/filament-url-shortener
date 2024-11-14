<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class RoleResource extends Resource
{
  protected static ?string $model = Role::class;

  protected static ?string $navigationIcon  = 'heroicon-o-shield-check';
  protected static ?string $navigationLabel = 'Role';
  protected static ?string $modelLabel      = 'Role';
  protected static ?string $navigationGroup = 'Hak Akses';
  protected static ?int $navigationSort     = 10;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make()
          ->schema([
            Forms\Components\TextInput::make('name')
              ->required()
              ->maxLength(255)
              ->label('Nama Role'),
            Forms\Components\Hidden::make('guard_name')
              ->required()
              ->default('web')
              ->label('Nama Guard'),
            Forms\Components\Select::make('permissions')
              ->relationship('permissions', 'name')
              ->multiple()
              ->preload(false)
              ->label('Akses'),
            Forms\Components\Select::make('users')
              ->relationship('users', 'email')
              ->multiple()
              ->preload(false)
              ->label('Pengguna'),
          ])
          ->columns(1)
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
          ->label('Nama Role'),
        Tables\Columns\TextColumn::make('guard_name')
          ->label('Nama Guard')
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('permissions_count')
          ->counts('permissions')
          ->sortable()
          ->label('Jumlah Hak Akses')
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('users_count')
          ->counts('users')
          ->sortable()
          ->label('Jumlah Pengguna')
          ->toggleable(isToggledHiddenByDefault: false),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime('d M Y, H:i')
          ->sortable()
          ->label('Dibuat Pada')
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime('d M Y, H:i')
          ->sortable()
          ->label('Diubah Pada')
          ->toggleable(isToggledHiddenByDefault: false),
      ])
      ->filters([
        //
      ])
      ->defaultSort('name', 'asc')
      ->recordAction(null)
      ->recordUrl(null)
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\EditAction::make()
            ->color('primary')
            ->modalWidth(MaxWidth::Large),

          Tables\Actions\DeleteAction::make()
            ->color('danger')
            ->before(function (Tables\Actions\DeleteAction $action, Role $record) {
              $permissions = $record->permissions()->count();
              $users       = $record->users()->count();

              if ($permissions > 0 || $users > 0) {
                $message = $permissions > 0
                  ? 'Role ini memiliki hak akses, tidak dapat dihapus!'
                  : 'Role ini memiliki pengguna, tidak dapat dihapus!';

                Notification::make()
                    ->body($message)
                    ->danger()
                    ->send();

                $action->cancel();
              }
            }),
        ])
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          // Tables\Actions\DeleteBulkAction::make(),
        ]),
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
      'index' => Pages\ListRoles::route('/'),
      // 'create' => Pages\CreateRole::route('/create'),
      // 'edit' => Pages\EditRole::route('/{record}/edit'),
    ];
  }
}
