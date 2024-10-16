<?php

namespace App\DataTables;

use App\Models\User;
// use App\Models\UserResendEmailVerify;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserResendEmailVerifyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $counter = 1;
        return datatables()
            ->eloquent($query)
            ->addColumn('no', function () use (&$counter) {
                return $counter++;
            })
            // ->filter(function ($query) {
            //     if ($this->request->has('search')) {
            //         $keyword = $this->request->get('search');
            //         $keyword = $keyword['value'];
            //         $query->where(function ($q) use ($keyword) {
            //             $q->where('firstname', 'LIKE', "%{$keyword}%")
            //                 ->orWhere('lastname', 'LIKE', "%{$keyword}%");
            //         });
            //     }
            // })
            ->addColumn('profile', function ($row) {

                if (trim($row->profile) != "" || trim($row->profile) != NULL) {
                    // if (Storage::disk('public')->exists('profile/' . $row->profile)) {
                    $imageUrl = asset('storage/profile/' . $row->profile);
                    // } else {
                    //     $imageUrl = asset('storage/no_profile.png');
                    // }
                } else {
                    $imageUrl = asset('storage/no_profile.png');
                }
                return '<div class="symbol-label">
                <img src="' . $imageUrl . '" alt="No Image" class="w-50">
            </div>';
            })
            ->addColumn('username', function ($row) {
                return $row->firstname . ' ' . $row->lastname;
            })
            ->addColumn('resend_mail', function ($row) {
                return '<button class="btn-btn danger">Send Mail</button>';
            })

            ->rawColumns(['profile', 'app_user']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return  User::where(['account_type' => '0'])->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('userresendemailverify-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('no')->title('#')->render('meta.row + meta.settings._iDisplayStart + 1;'),
            Column::make('profile'),
            Column::make('username'),
            Column::make('resend_mail')->title('Resend Email'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserResendEmailVerify_' . date('YmdHis');
    }
}
