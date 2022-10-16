<?php

namespace App\Admin\Controllers;

use App\Models\City;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class CityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'City';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new City());
        $grid->model()->with('cityAreas');

        $grid->filter(function ($filter) {
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->like('city', __('admin.location_city'));
            $filter->where(function ($query) {
                $query->whereHas('cityAreas', function ($query) {
                    $query->where('city_area', 'like', "%{$this->input}%")->orWhere('zip_code', 'like', "%{$this->input}%");
                });
            }, __('admin.city_area_zip_code'), 'city_area_zip_code');
        });

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('admin.created_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('city', __('admin.location_city'))->expand(function ($city) {
            return new Table(
                ['id', __('admin.location_area'), __('admin.city_zip_code')],
                $city->cityAreas->map(function ($cityArea) {
                    return $cityArea->only(['id', 'city_area', 'zip_code']);
                })->when(request()->query('city_area_zip_code'), function ($cityAreas, $queryCityAreaZipCode) {
                    return $cityAreas->filter(function ($cityArea) use ($queryCityAreaZipCode) {
                        return str_contains($cityArea['city_area'], $queryCityAreaZipCode)
                            or str_contains($cityArea['zip_code'], $queryCityAreaZipCode);
                    });
                })->values()->toArray()
            );
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->disableActions();

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
        $show = new Show(City::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new City());

        return $form;
    }
}
