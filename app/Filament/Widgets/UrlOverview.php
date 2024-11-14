<?php

namespace App\Filament\Widgets;

use App\Models\Url;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UrlOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $parent = new Url();
    $user = auth()->user();

    if (!$user->checkPermissionTo('*')) $parent = $parent->where('user_id', $user->id);

    return [
      Stat::make('Total URL', $parent->count())
        ->description('Total URL yang telah dibuat')
        ->descriptionIcon('heroicon-s-link')
        ->color('info'),
      Stat::make('Total Klik', $parent->sum('click_count'))
        ->description('Total klik yang telah dilakukan')
        ->descriptionIcon('heroicon-s-arrow-trending-up')
        ->color('success'),
      Stat::make('Rata-rata Klik', (int) $parent->avg('click_count'))
        ->description('Rata-rata klik per URL')
        ->descriptionIcon('heroicon-s-arrow-trending-up')
        ->color('primary'),
    ];
  }
}
