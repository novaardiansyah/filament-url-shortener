<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UrlResource\Pages;
use App\Models\Url;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UrlResource extends Resource
{
  protected static ?string $model = Url::class;

  protected static ?string $navigationIcon  = 'heroicon-o-link';
  protected static ?string $navigationLabel = 'URL Shortener';
  protected static ?string $modelLabel      = 'URL Shortener';
  protected static ?int $navigationSort     = 2;

  public static function getEloquentQuery(): Builder
  {
    $user = auth()->user();
    $parent = parent::getEloquentQuery();
    if (!$user->checkPermissionTo('*')) $parent->where('user_id', $user->id);
    return $parent;
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('')
          ->schema([
            Forms\Components\TextInput::make('code_url')
              ->label('Referal Code')
              ->default(Str::orderedUuid()->toString())
              ->readOnly(),
            Forms\Components\Textarea::make('original_url')
              ->required()
              ->label('Original URL')
              ->maxLength(255)
              ->rows(3)
              ->placeholder('https://example.com/'),
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
        Tables\Columns\TextColumn::make('user.name')
          ->searchable()
          ->sortable()
          ->label('Pengguna')
          ->toggleable()
          ->visible(fn (): bool => auth()->user()->checkPermissionTo('*')),
        Tables\Columns\TextColumn::make('code_url')
          ->searchable()
          ->sortable()
          ->label('Referal Code')
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('original_url')
          ->searchable()
          ->sortable()
          ->label('Original URL')
          ->toggleable(isToggledHiddenByDefault: true)
          ->copyable(),
        Tables\Columns\TextColumn::make('shortener_url')
          ->searchable()
          ->sortable()
          ->label('Shortener URL')
          ->toggleable()
          ->copyable(),
        Tables\Columns\TextColumn::make('click_count')
          ->sortable()
          ->label('Total Klik')
          ->badge()
          ->toggleable(),
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
      ->recordAction(null)
      ->recordUrl(null)
      ->defaultSort('id', 'desc')
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\DeleteAction::make()
            ->color('danger'),
        ])
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
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
      'index' => Pages\ListUrls::route('/'),
      // 'create' => Pages\CreateUrl::route('/create'),
      // 'edit' => Pages\EditUrl::route('/{record}/edit'),
    ];
  }
}
