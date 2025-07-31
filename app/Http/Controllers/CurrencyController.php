<?php

namespace App\Http\Controllers;

use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    private CurrencyRepository $repository;

    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
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
    }

    public function store(Request $request)
    {
        // $this->allowedAction('getCurrencies');
    }

    public function show(string $id)
    {
        // $this->allowedAction('getCurrencies');
    }

    public function edit(string $id)
    {
        // $this->allowedAction('getCurrencies');
    }

    public function update(Request $request, string $id)
    {
        // $this->allowedAction('getCurrencies');
    }

    public function destroy(string $id)
    {
        // $this->allowedAction('getCurrencies');
    }
}