<?php

namespace Modules\Permissions\DataTables;

use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Product;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{

    protected $type = null;

    public function setType(string $type)
    {
        $this->type = $type;
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $user = Auth::user();
        $canEdit = $user->can('authorization', 'editProduct');
        $canDestroy = $user->can('authorization', 'destroyProduct');

        return datatables()
            ->eloquent($query)
            ->addColumn('input', function (Product $product) {
                return '<div class="icheck-danger d-inline">
                        <input type="checkbox" class="checkRowBtn" onclick="selectRow(this)" id="product-' . $product->id . '" value="' .  $product->id . '">
                        <label for="product-' .  $product->id . '"></label>
                      </div>';
            })
            ->editColumn('image', function (Product $product) {
                if ($product->image)
                    return '<div> <img src="' . $product->image . '" alt="Image" style="width: 100%" /></div>';
                return null;
            })
            // ->editColumn('number_schools', function (Product $product) {
            //     return $county->schoolsWithClasses()->count() . ' / ' . $county->number_schools;
            // })
            // ->editColumn('number_students_registered', function (CountyInfoView $county) {
            //     return $county->number_students_registered . ' / ' . ($county->classes()->count() > 0 ? $county->classes()->sum('number_students') : 0);
            // })
            ->addColumn('action', function (Product $product) use ($canEdit, $canDestroy) {
                $btn = ' <div class="btn-group">
                            <a title="View"
                                data-toggle="tooltip" data-placement="top"
                                class="btn btn-default mr-1"
                                {{--                                   target="_blank"--}}
                                href="' . route('products.show', [$product->id]) . '">
                                <span class="m-l-5"><i class="fa fa-eye"></i></span></a>
                            <a title="Print"
                                data-toggle="tooltip" data-placement="top"
                                class="btn btn-default mr-1"
                                target="_blank"
                                href="' . route('products.print', ['ids' => [$product->id]]) . '">
                                <span class="m-l-5"><i class="fa fa-print"></i></span></a>';
                if ($canEdit) {
                    $btn .= '<a title=\'Editar\'
                data-toggle="tooltip" data-placement="top"
                class="btn btn-default mr-1"
                href="' . route("products.edit", [$product->id, $product->type]) . '">
                    <span class="m-l-5"><i class="fa fa-pencil-alt"></i></span></a>';
                }
                if ($canDestroy) {
                    $btn .= '<a title=\'Remover\'
                data-toggle="tooltip" data-placement="top"
                class="btn btn-times btn-default mr-1"
                onclick="deleteInfo(' . $product->id . ')">
                    <span class="m-l-5"><i class="fa fa-trash"></i></span></a>';
                }

                $btn .= '</div>';

                return $btn;
            })
            ->rawColumns(['action', 'image', 'input']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param County $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        $query = $model->newQuery();

        if ($this->type)
            $query->where('type', $this->type);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->postAjax()
            ->language('/vendor/datatables-portuguese.json')
            ->orderBy(1, 'asc')
            ->dom('Blfrtip')
            ->parameters([
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "Todos"]],

                'buttons' => ['pageLength', 'excel'],
            ])
            ->drawCallback(" function () {
                    $('[data-toggle=\"tooltip\"]').tooltip();

                    document.querySelectorAll('.checkRowBtn').forEach((btn) => {
                    if(ids.includes(btn.value))
                    btn.checked = true;
                    });

                    checkSelectAllRowsBtn();
                }   
                 ");
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('input')
                ->exportable(false)
                ->printable(false)
                ->width(65)
                ->title('<div class="icheck-danger d-inline">
                        <input type="checkbox" id="selectAllRowsBtn" onclick="selectAllRows()">
                        <label for="selectAllRowsBtn">
                        </label>
                      </div> All'),
            Column::make('id')->title('ID'),
            Column::computed('image')->width(80)->title('Image'),
            Column::make('name')->title('Name'),
            Column::make('quality')->title('Quality'),
            Column::make('print')->title('Print'),
            Column::make('finishing')->title('Finishing'),
            Column::make('weight')->title('Width'),
            Column::make('grammage')->title('Grammage'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(55)
                ->title('Actions'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    // protected function filename()
    // {
    //     return 'Counties_' . date('YmdHis');
    // }
}
