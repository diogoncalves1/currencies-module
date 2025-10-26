<?php

namespace Modules\Currency\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\App;

class CurrencyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        $locale = in_array(App::getLocale(), config('languages')) ? App::getLocale() : 'en';

        return [
            'id' => $this->id,
            'name' => json_decode($this->name)->$locale,
            'symbol' => $this->symbol,
            'rate' => $this->rate
        ];
    }
}
