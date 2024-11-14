<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
  protected static ?string $model = Permission::class;

  protected static ?string $navigationIcon  = 'heroicon-o-shield-check';
  protected static ?string $navigationLabel = 'Permission';
  protected static ?string $modelLabel      = 'Permission';
  protected static ?string $navigationGroup = 'Hak Akses';
  protected static ?int $navigationSort     = 20;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make()
          ->schema([
            Forms\Components\TextInput::make('name')
              ->required()
              ->maxLength(255)
              ->label('Nama Permission'),
            Forms\Components\Hidden::make('guard_name')
              ->required()
              ->default('web')
              ->label('Nama Guard'),
            Forms\Components\Select::make('roles')
              ->relationship('roles', 'name')
              ->multiple()
              ->preload()
              ->label('Akses Role'),
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
          ->label('Nama Permission'),
        Tables\Columns\TextColumn::make('guard_name')
          ->label('Nama Guard')
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('roles_count')
          ->counts('roles')
          ->sortable()
          ->label('Jumlah Akses Role')
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
      ->defaultSort('id', 'desc')
      ->recordAction(null)
      ->recordUrl(null)
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\EditAction::make()
            ->color('primary')
            ->modalWidth(MaxWidth::Large),

          Tables\Actions\DeleteAction::make()
            ->color('danger')
            ->before(function (Tables\Actions\DeleteAction $action, Permission $record) {
              $roles = $record->roles()->count();

              if ($roles > 0) {
                $message = 'Permission ini memiliki akses role, tidak dapat dihapus!';

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
      'index' => Pages\ListPermissions::route('/'),
      // 'create' => Pages\CreatePermission::route('/create'),
      // 'edit' => Pages\EditPermission::route('/{record}/edit'),
    ];
  }
}
