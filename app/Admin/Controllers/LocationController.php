<?php

namespace App\Admin\Controllers;

use App\Enums\UserLoginTypeIdEnum;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\Storage;

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
        $grid->model()->with(['locationServiceHours', 'cityArea.city']);

        $grid->filter(function ($filter) {
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->equal('user_id', __('admin.user_name'))
                ->select(User::pluck('name', 'id'));
            $filter->equal('cityArea.city_area', __('admin.location_area'))
                ->select(CityArea::pluck('city_area', 'id'));
            $filter->equal('category_id', __('admin.location_category_id'))
                ->select(__('admin.location_category_options'));
            $filter->like('name', __('admin.location_name'));
            $filter->like('address', __('admin.location_address'));
            $filter->like('phone', __('admin.location_phone'));
            $filter->between('avgScore', __('admin.location_avgScore'));
            $filter->like('introduction', __('admin.location_introduction'));
            $filter->equal('active', __('admin.location_active'))->radio(__('admin.location_active_options'));
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('admin.created_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('user.name', __('admin.user_name'))->display(function ($value) {
            $href = route('admin.users.show', [
                'user' => $this->user_id,
            ]);
            return "<a href='$href' target='_blank'>$value</a>";
        })->sortable();
        $grid->column(__('admin.location_city'))->display(function () {
            return $this->cityArea->city->city;
        });
        $grid->column('cityArea.city_area', __('admin.location_area'))->sortable();
        $grid->column('category_id', __('admin.location_category_id'))
            ->using(__('admin.location_category_options'))
            ->dot([
                1 => 'warning',
                2 => 'success',
                3 => 'danger',
            ])->sortable();
        $grid->column('name', __('admin.location_name'))->sortable()->expand(function ($location) {
            return new Table(
                ['id', __('admin.location_service_hour_weekday'), __('admin.location_service_hour_opened_at'), __('admin.location_service_hour_closed_at')],
                $location->locationServiceHours->sortBy('weekday')->map(function ($locationServiceHour) {
                    return tap($locationServiceHour->only(['id', 'weekday', 'opened_at', 'closed_at']), function (&$columns) {
                        foreach (['opened_at', 'closed_at'] as $field) {
                            $columns[$field] = date('H:i', strtotime($columns[$field]));
                        }
                        return $columns;
                    });
                })->values()->toArray()
            );
        });
        $grid->column('address', __('admin.location_address'));
        $grid->column('phone', __('admin.location_phone'));
        $grid->column('avgScore', __('admin.location_avgScore'))->sortable();
        $grid->column('introduction', __('admin.location_introduction'))->limit(50);
        $grid->column('active', __('admin.location_active'))
            ->using(__('admin.location_active_options'))
            ->label([
                0 => 'danger',
                1 => 'success',
            ]);
        $grid->column('images', __('admin.location_images'))->display(function ($filePaths) {
            return !empty($filePaths) ? Storage::url(head($filePaths)) : '';
        })->image(config('app.url'), 64, 64);

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
        $show->field('category_id', __('admin.location_category_id'))->using(__('admin.location_category_options'));
        $show->field('name', __('admin.location_name'));
        $show->field('address', __('admin.location_address'));
        $show->field('phone', __('admin.location_phone'));
        $show->field('avgScore', __('admin.location_avgScore'));
        $show->field('introduction', __('admin.location_introduction'));
        $show->field('active', __('admin.location_active'))->using(__('admin.location_active_options'));
        $show->field('images', __('admin.location_images'))->image();

        return $show;
    }

    /**
     * Make a form builder.
     * // TODO: 若店家身份被審核，要寄信通知店家的使用者
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
        $form->select('category_id', __('admin.location_category_id'))
            ->options(__('admin.location_category_options'))
            ->config('allowClear', false)
            ->rules('required');
        $form->text('name', __('admin.location_name'))->rules('required');
        $form->text('address', __('admin.location_address'))->rules('required');
        $form->mobile('phone', __('admin.location_phone'))->rules('required');
        $form->isCreating() ?: $form->display('avgScore', __('admin.location_avgScore'));
        $form->hidden('avgScore', __('admin.location_avgScore'))->default(0);
        $form->textarea('introduction', __('admin.location_introduction'));
        $form->switch('active', __('admin.location_active'))->states([
            'on' => ['value' => 1, 'text' => __('admin.location_active_options.1'), 'color' => 'success'],
            'off' => ['value' => 0, 'text' => __('admin.location_active_options.0'), 'color' => 'danger'],
        ]);

        if ($form->isEditing()) {
            $form->multipleImage('images', __('admin.location_images'))
                ->move("locations/{$location->id}")
                ->uniqueName()
                ->options([
                    'showClose' => false,
                ]);
            Admin::script(
                <<<SCRIPT
                $('select.city_id').trigger('change');
SCRIPT
            );
        }

        $form->saving(function ($form) {
            if ($form->model()->active and $form->active === 'off') {
                $form->model()->user()->update([
                    'login_type_id' => UserLoginTypeIdEnum::USER,
                ]);
            }
        });

        if ($form->isCreating()) {
            $form->saved(function ($form) {
                $form->model()->user()->update([
                    'location_applied_at' => now(),
                ]);
            });
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
        return CityArea::where([
            ['city_id', request()->query('q')],
        ])->get(['id', 'city_area']);
    }
}
