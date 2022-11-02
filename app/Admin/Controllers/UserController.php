<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->equal('id', __('admin.name'))->select(User::pluck('name', 'id'));
            $filter->like('email', __('admin.email'));
            $filter->between('location_applied_at', __('admin.location_applied_at'))->datetime();
            $filter->where(function ($query) {
                $query->whereHas('location', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, __('admin.location_name'));
            $filter->equal('login_type_id', __('admin.login_type_id'))
                ->select(__('admin.login_type_options'));
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('admin.created_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('name', __('admin.name'))->sortable();
        $grid->column('email', __('admin.email'));
        $grid->column('email_verified_at', __('admin.email_verified_at'))->display(function ($value) {
            return !is_null($value) ? date('Y-m-d H:i:s', strtotime($value)) : $value;
        });
        $grid->column('location_applied_at', __('admin.location_applied_at'))->display(function ($value) {
            return !is_null($value) ? date('Y-m-d H:i:s', strtotime($value)) : $value;
        });
        $grid->column('location', __('admin.location_name'))->display(function ($location) {
            return !is_null($location) ? sprintf(
                '<span class="text-%s">%s</span>',
                $location['active'] ? 'green' : 'red',
                $location['name']
            ) : '';
        });
        $grid->column('login_type_id', __('admin.login_type_id'))->display(function ($loginTypeId) {
            return __("admin.login_type_options.$loginTypeId");
        });

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('name', __('admin.name'));
        $show->field('email', __('admin.email'));
        $show->field('email_verified_at', __('admin.email_verified_at'));
        $show->field('location_applied_at', __('admin.location_applied_at'));
        $show->field('login_type_id', __('admin.login_type_id'))->using(__('admin.login_type_options'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('admin.name'))->rules('required');
        $form->email('email', __('admin.email'))->rules('required');
        $form->datetime('email_verified_at', __('admin.email_verified_at'))
            ->default(!is_null($form->email_verified_at) ? date('Y-m-d H:i:s') : null);
        $form->display('location_applied_at', __('admin.location_applied_at'));
        $form->password('password', __('admin.password'))->creationRules('required');
        if ($form->isEditing()) {
            $user = $form->model()->find(request()->route('user'));
            if (!is_null($user->location) and $user->location->active) {
                $form->switch('login_type_id', __('admin.login_type_id'))->states([
                    'on' => ['value' => 1, 'text' => __('admin.login_type_options.1'), 'color' => 'success'],
                    'off' => ['value' => 2, 'text' => __('admin.login_type_options.2'), 'color' => 'danger'],
                ]);
                $form->display('location.name', __('admin.location_name'));
            }
        }
        $form->saving(function (Form $form) {
            !is_null($form->login_type_id) ?: $form->login_type_id = 1;
            $form->password = Hash::make($form->password ?? $form->model()->password);
        });

        return $form;
    }
}
