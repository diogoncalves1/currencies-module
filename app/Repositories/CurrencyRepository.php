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

    public function update(Request $request, string $id)
    {
        try {
        } catch (\Exception $e) {
        }
    }

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

    public function dataTable(Request $request)
    {
        $query = Currency::query();
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where("name", 'like', "{$search}%")
                    ->orWhere("code", 'like', "{$search}%")
                    ->orWhere("symbol", 'like', "{$search}%");
            });
        }

        $orderColumnIndex = $request->input('order.0.column');
        $orderColumn = $request->input("columns.$orderColumnIndex.data");
        $orderDir = $request->input('order.0.dir');
        if ($orderColumn && $orderDir) {
            $query->orderBy($orderColumn, $orderDir);
        }

        $total = $query->count();

        $users = $query->offset($request->start)
            ->limit($request->length)
            ->get();

        foreach ($users as &$user) {
            $user->actions = "<div class='btn-group'>
                            <a type='button' href='" . route('admin.currencies.edit', $user->id) . "' class='btn mr-1 btn-default'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <button type='button' onclick='modalDelete({$user->id})' class='btn btn-default'>
                                <i class='fas fa-trash'></i>
                            </button>
                        </div>";
        }

        $data = [
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $users
        ];

        return $data;
    }
}