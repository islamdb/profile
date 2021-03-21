<?php

namespace App\Orchid\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class DeleteAction extends Action
{
    /**
     * The button of the action.
     *
     * @return Button
     */
    public function button(): Button
    {
        return Button::make('Delete Selected')
            ->icon('trash')
            ->confirm(__('Are you sure you want to delete these resources?'));
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Illuminate\Support\Collection $models
     */
    public function handle(Collection $models)
    {
        DB::beginTransaction();

        $models->each(function ($model) {
            $model->delete();
        });

        DB::commit();

        Toast::message('Deleted!');
    }
}
