<?php
namespace Modules\Currency\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Modules\Language\Repositories\LanguageRepository;

class CurrencyResource extends JsonResource
{
    protected LanguageRepository $languageRepository;

    public function __construct($resource, ?LanguageRepository $languageRepository = new LanguageRepository())
    {
        $this->resource           = $resource;
        $this->languageRepository = $languageRepository;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $locale = in_array(App::getLocale(), $this->languageRepository->allCodes()) ? App::getLocale() : 'en';

        return [
            'id'     => $this->id,
            'name'   => $this->name->{$locale},
            'symbol' => $this->symbol,
            'rate'   => (float) $this->rate,
            'code'   => $this->code,
        ];
    }
}
