<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyRepository implements RepositoryInterface
{
    public function all()
    {
        Currency::all();
    }

    public function store(Request $request)
    {
        try {
        } catch (\Exception $e) {
        }
    }

    public function update(Request $request, string $id) {}

    public function destroy(string $id)
    {
        try {
        } catch (\Exception $e) {
        }
    }

    public function show(string $id)
    {
        Currency::find($id);
    }

    public function dataTable(Request $request) {}
}