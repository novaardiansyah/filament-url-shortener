<?php

namespace App\Filament\Resources\UrlResource\Pages;

use App\Filament\Resources\UrlResource;
use App\Models\Url;
use Filament\Actions;
use Filament\Notifications\Notification;
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
          $original_url = $data['original_url'];

          $hasUrl = Url::where('user_id', auth()->user()->id)
            ->where('original_url', $original_url)
            ->first();

          if ($hasUrl) {
            if ($hasUrl->deleted_at) {
              $data['code_url'] = $hasUrl->code_url;
              $hasUrl->delete();
            } else {
              Notification::make()
                ->title('Proses gagal!')
                ->body('URL sudah pernah dibuat sebelumnya.')
                ->danger()
                ->send();

              $this->halt();
            }
          }

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
