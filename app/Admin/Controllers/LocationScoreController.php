<?php

namespace App\Admin\Controllers;

use App\Models\Location;
use App\Models\LocationScore;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LocationScoreController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'LocationScore';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LocationScore());

        $grid->filter(function ($filter) {
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->equal('user_id', __('admin.user_name'))
                ->select(User::pluck('name', 'id'));
            $filter->equal('location_id', __('admin.location_name'))
                ->select(Location::pluck('name', 'id'));
            $filter->between('score', __('admin.location_score'));
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('admin.created_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('user.name', __('admin.user_name'))->display(function($value) {
            $href = route('admin.users.show', [
                'user' => $this->user_id,
            ]);
            return "<a href='$href' target='_blank'>$value</a>";
        })->sortable();
        $grid->column('location.name', __('admin.location_name'))->display(function($value) {
            $href = route('admin.locations.show', [
                'location' => $this->location_id,
            ]);
            return "<a href='$href' target='_blank'>$value</a>";
        })->sortable();
        $grid->column('score', __('admin.location_score'))->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(LocationScore::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('user.name', __('admin.user_name'));
        $show->field('location.name', __('admin.location_name'));
        $show->field('score', __('admin.location_score'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new LocationScore());

        $form->select('user_id', __('admin.user_name'))
            ->options(User::pluck('name', 'id'))
            ->config('allowClear', false)
            ->rules('required');
        $form->select('location_id', __('admin.location_name'))
            ->options(Location::pluck('name', 'id'))
            ->config('allowClear', false)
            ->rules('required');
        $form->decimal('score', __('admin.location_score'))
            ->rules('required|numeric|between:0.5,5')
            ->default(0.5);

        return $form;
    }
}
