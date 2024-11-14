<?php

namespace App\Filament\Resources\UrlResource\Pages;

use App\Filament\Resources\UrlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ListUrls extends ListRecords
{
  protected static string $resource = UrlResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->modalWidth(MaxWidth::Medium)
        ->mutateFormDataUsing(function (array $data) {
          $url = url($data['code_url']);

          $response = Http::withToken(env('TINYURL_API_KEY'))->post('https://api.tinyurl.com/create', [
            'url'         => $url,
            'domain'      => 'tinyurl.com',
            'description' => $data['code_url'],
          ]);

          if ($response->ok()) {
            $data['shortener_url'] = $response->json()['data']['tiny_url'];
          }
        
          $data['user_id'] = auth()->user()->id;

          return $data;
        }),
    ];
  }
}
