<?php

namespace App\DataTables;

use App\Tweet;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TweetsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->setRowClass(function ($tweet) {
                return $tweet->ignore ? 'text-ignore2' : '';
            })
            ->addColumn('id', function ($tweet) {
                return '<a href="https://twitter.com/xxxxxxxxxx/status/'.$tweet->twitter_id.'" target="_blank">'.$tweet->id.'</a>';
            })
            ->addColumn('actions', function ($tweet) {
                $actions = '<a href="javascript:;" class="btn-edit" data-toggle="modal" data-target="#exampleModalCenter">Edit</a> | ';
                if( $tweet->ignore ) {
                    $actions .= '<a href="' . route('tweet.unignore', $tweet->id) . '" class="btn-unignore text-warning">Unignore</a>';
                } else {
                    $actions .= '<a href="' . route('tweet.ignore', $tweet->id) . '" class="btn-ignore text-warning">Ignore</a>';
                }
                $actions .= ' | <a href="' . route('tweet.destroy', $tweet->id) . '" class="btn-destroy text-danger">Delete</a>';
                return $actions;
            })
            ->rawColumns(['id', 'actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Tweet $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tweet $model)
    {
        return $model->orderBy('id','desc')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('tweets-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->pageLength(200)
                    ->buttons(
                        Button::make('create')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('id')
                ->title('#')
                ->addClass('text-center'),
            Column::make('message'),
            Column::computed('actions')
                ->title('')
                ->width(200)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    // protected function filename()
    // {
    //     return 'Tweets_' . date('YmdHis');
    // }
}
