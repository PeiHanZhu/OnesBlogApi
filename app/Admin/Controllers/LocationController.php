<?php

namespace App\Admin\Controllers;

use App\Models\City;
use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LocationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Location';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Location());

        $grid->filter(function ($filter) {
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->equal('user_id', __('admin.user_name'))
                ->select(User::pluck('name', 'id'));
            $filter->equal('cityArea.city_area', __('admin.location_area'))
                ->select(CityArea::pluck('city_area', 'id'));
            $filter->equal('category_id', __('admin.category_id'))
                ->select(__('admin.category_options'));
            $filter->like('name', __('admin.location_name'));
            $filter->like('address', __('admin.location_address'));
            $filter->like('phone', __('admin.location_phone'));
            $filter->between('avgScore', __('admin.location_avgScore'));
            $filter->like('introduction', __('admin.location_introduction'));
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('admin.created_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });
        $grid->column('user.name', __('admin.user_name'))->display(function ($value) {
            $href = route('admin.users.show', [
                'user' => $this->user_id,
            ]);
            return "<a href='$href' target='_blank'>$value</a>";
        })->sortable();
        $grid->column('cityArea.city_area', __('admin.location_area'))->sortable();
        $grid->column('category_id', __('admin.category_id'))
            ->using(__('admin.category_options'))
            ->dot([
                1 => 'warning',
                2 => 'success',
                3 => 'danger',
            ])->sortable();
        $grid->column('name', __('admin.location_name'))->sortable();
        $grid->column('address', __('admin.location_address'));
        $grid->column('phone', __('admin.location_phone'));
        $grid->column('avgScore', __('admin.location_avgScore'))->sortable();
        $grid->column('introduction', __('admin.location_introduction'))->limit(50);

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
        $show = new Show(Location::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('user.name', __('admin.user_name'));
        $show->field('cityArea.city_area', __('admin.location_area'));
        $show->field('category_id', __('admin.category_id'))->using(__('admin.category_options'));
        $show->field('name', __('admin.location_name'));
        $show->field('address', __('admin.location_address'));
        $show->field('phone', __('admin.location_phone'));
        $show->field('avgScore', __('admin.location_avgScore'));
        $show->field('introduction', __('admin.location_introduction'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Location());

        if ($form->isCreating()) {
            $users = User::doesntHave('location')->pluck('name', 'id');
            $cityId = null;
        } else {
            $location = $form->model()->find(request()->route('location'));
            $users = User::doesntHave('location')->orWhere('id', $location->user_id)->pluck('name', 'id');
            $cityId = $location->cityArea->city->id ?? null;
        }
        $form->select('user_id', __('admin.user_name'))
            ->options($users)
            ->config('allowClear', false)
            ->rules('required');
        $form->ignore('city_id')
            ->select('city_id', __('admin.location_city'))
            ->options(City::pluck('city', 'id'))
            ->config('allowClear', false)
            ->default($cityId)
            ->load('city_area_id', route('admin.api.city-areas.index.belong-to-city'), 'id', 'city_area', false)
            ->rules('required');
        $form->select('city_area_id', __('admin.location_area'))
            ->rules('required');
        $form->select('category_id', __('admin.category_id'))
            ->options(__('admin.category_options'))
            ->config('allowClear', false)
            ->rules('required');
        $form->text('name', __('admin.location_name'))->rules('required');
        $form->text('address', __('admin.location_address'))->rules('required');
        $form->mobile('phone', __('admin.location_phone'))->rules('required');
        $form->isCreating() ?: $form->display('avgScore', __('admin.location_avgScore'));
        $form->hidden('avgScore', __('admin.location_avgScore'))->default(0);
        $form->textarea('introduction', __('admin.location_introduction'));
        if ($form->isEditing()) {
            Admin::script(
                <<<SCRIPT
                $('select.city_id').trigger('change');
SCRIPT
            );
        }

        return $form;
    }

    /**
     * @api Get all the city areas which belong to the specified city.
     *
     * @return \Illuminate\Support\Collection
     */
    public function indexCityAreasBelongToCity()
    {
        return(CityArea::where([
            ['city_id', request()->query('q')],
        ])->get(['id', 'city_area']));
    }
}
