<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Repositories\CurrencyRepository;

class CurrencyController extends AppController
{
    private CurrencyRepository $repository;

    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function dataTable(Request $request)
    {
        // $this->allowedAction('getCurrencies');

        $data = $this->repository->dataTable($request);

        return response()->json($data);
    }
}