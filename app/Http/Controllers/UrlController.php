<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Support\Facades\Log;

class UrlController extends Controller
{
  public function shortenLink($shortener_url)
  {
    $find = Url::where('code_url', $shortener_url)->first();
    if (!$find) abort(404);

    $find->click_count++;
    $find->save();

    return redirect($find->original_url);
  }
}
