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
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('location.name', __('admin.location_name'));
        $grid->column('login_type_id', __('admin.login_type_id'))->using(__('admin.login_type_options'))->label([
            1 => 'danger',
            2 => 'success',
        ])->sortable();

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
            ->default(date('Y-m-d H:i:s'));
        $form->password('password', __('admin.password'))->creationRules('required');
        !$form->isEditing() ?: $form->display('location.name', __('admin.location_name'));
        $form->saving(function (Form $form) {
            !is_null($form->login_type_id) ?: $form->login_type_id = 1;
            $form->password = Hash::make($form->password ?? $form->model()->password);
        });

        return $form;
    }
}
