<?php

namespace Modules\Currency\Http\Controllers;

use Modules\Currency\Repositories\CurrencyRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AppController;

class CurrencyController extends AppController
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function index()
    {
        // $this->allowedAction('viewCurrency');

        Session::flash('page', 'currencies');

        return view('currency::index');
    }

    public function create()
    {
        // $this->allowedAction('createCurrency');

        Session::flash('page', 'currencies');

        $languages = config('languages');

        return view('currency::create', compact('languages'));
    }

    public function edit(string $id)
    {
        // $this->allowedAction('editCurrency');

        Session::flash('page', 'currencies');

        $currency = $this->currencyRepository->show($id);
        $languages = config('languages');

        return view('currency::create', compact('currency', 'languages'));
    }
}
