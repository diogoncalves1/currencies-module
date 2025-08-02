<?php

namespace App\Http\Controllers;

use App\Enums\Language;
use App\Repositories\CurrencyRepository;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function index()
    {
        // $this->allowedAction('getCurrencies');

        Session::flash('page', 'currencies');

        return view('admin.currencies.index');
    }

    public function create()
    {
        // $this->allowedAction('getCurrencies');

        $languages = Language::cases();

        return view('admin.currencies.form', compact('languages'));
    }

    // public function show(string $id)
    // {
    //     // $this->allowedAction('getCurrencies');
    // }

    public function edit(string $id)
    {
        // $this->allowedAction('getCurrencies');

        $currency = $this->currencyRepository->show($id);
        $languages = Language::cases();

        return view('admin.currencies.form', compact('currency', 'languages'));
    }
}
