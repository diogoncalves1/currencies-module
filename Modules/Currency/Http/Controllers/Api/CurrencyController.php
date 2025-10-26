<?php

namespace Modules\Currency\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Currency\Http\Requests\CurrencyRequest;
use Modules\Currency\Http\Resources\CurrencyResource;

class CurrencyController extends ApiController
{
    private CurrencyRepository $repository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->repository = $currencyRepository;
    }

    /**
     * Store a newly created resource in storage.
     * @param CurrencyRequest $request
     * @return JsonResponse
     */
    public function store(CurrencyRequest $request): JsonResponse
    {
        try {
            $this->allowedAction('createCurrency');

            $currency = $this->repository->store($request);

            return $this->ok(new CurrencyResource($currency), "Moeda adicionada com sucesso");
        } catch (\Exception $e) {
            Log::error($e);
            return $this->fail('Erro ao tentar adicionar uma nova moeda', $e, $e->getCode());
        }
    }

    public function update(CurrencyRequest $request, string $id)
    {
        $this->allowedAction('editCurrency');

        $response = $this->repository->update($request, $id);

        return $response;
    }

    public function destroy(string $id)
    {
        $this->allowedAction('destroyCurrency');

        $response = $this->repository->destroy($id);

        return $response;
    }

    public function checkCode(Request $request)
    {
        $this->allowedAction('viewCurrency');

        $request->validate([
            "id" => "nullable",
            "code" => "required|string|size:3",
        ]);

        $response = $this->repository->checkCode($request);

        return  $response;
    }

    public function updateRates()
    {
        $this->allowedAction('updateRates');

        Artisan::call('currency:fetch-daily');

        return response()->json([
            'success' => true,
            'message' => 'Taxas atualizadas com sucesso',
        ]);
    }

    public function dataTable(Request $request)
    {
        // $this->allowedAction('viewCurrency');

        $data = $this->repository->dataTable($request);

        return response()->json($data);
    }
}
