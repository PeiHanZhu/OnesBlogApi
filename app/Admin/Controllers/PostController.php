<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Models\User;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Post';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post());

        $grid->filter(function ($filter) {
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->equal('user_id', __('admin.user_name'))
                ->select(($users = User::get(['id', 'name', 'is_store']))->pluck('name', 'id'));
            $filter->like('store_id', __('admin.store_name'))
                ->select($users->where('is_store', 1)->pluck('name', 'id'));
            $filter->equal('category_id', __('admin.category_id'))
                ->select(__('admin.category_options'));
            $filter->equal('title', __('admin.post_title'));
            $filter->between('published_at', __('admin.published_at'))->datetime();
            $filter->equal('active', __('admin.active'))->radio(__('admin.active_options'));
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('admin.created_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });
        $grid->column('user.name', __('admin.user_name'))->sortable();
        $grid->column('store.name', __('admin.store_name'))->sortable();
        $grid->column('category_id', __('admin.category_id'))
            ->using(__('admin.category_options'))
            ->dot([
                1 => 'warning',
                2 => 'success',
                3 => 'danger',
            ])->sortable();
        $grid->column('title', __('admin.post_title'))->limit(50);
        $grid->column('published_at', __('admin.published_at'));
        $grid->column('active', __('admin.active'))
            ->using(__('admin.active_options'))
            ->label([
                0 => 'danger',
                1 => 'success',
            ]);

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
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('user.name', __('admin.user_name'));
        $show->field('store.name', __('admin.store_name'));
        $show->field('category_id', __('admin.category_id'))->using(__('admin.category_options'));
        $show->field('title', __('admin.post_title'));
        $show->field('content', __('admin.post_content'));
        $show->field('published_at', __('admin.published_at'));
        $show->field('active', __('admin.active'))->using(__('admin.active_options'));
        $show->field('slug', __('admin.slug'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Post());
        $form->select('user_id', __('admin.user_name'))
            ->options(User::pluck('name', 'id'))
            ->load('store_id', route('admin.stores.without.user'), 'id', 'name', false)
            ->config('allowClear', false)
            ->rules('required');
        $form->select('store_id', __('admin.store_name'))->rules('required');
        $form->select('category_id', __('admin.category_id'))
            ->options(__('admin.category_options'))
            ->config('allowClear', false)
            ->rules('required');
        $form->text('title', __('admin.post_title'))->rules('required');
        $form->textarea('content', __('admin.post_content'));
        $form->datetime('published_at', __('admin.published_at'))->default(date('Y-m-d H:i:s'));
        $form->switch('active', __('admin.active'))->states([
            'on' => ['value' => 1, 'text' => __('admin.active_options.1'), 'color' => 'success'],
            'off' => ['value' => 2, 'text' => __('admin.active_options.0'), 'color' => 'danger'],
        ]);
        if ($form->isEditing()) {
            $form->display('slug', __('admin.slug'));
            Admin::script(
                <<<SCRIPT
                $('select.user_id').trigger('change');
SCRIPT
            );
        }

        return $form;
    }

    /**
     * @api Get all the stores without the specified user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function indexStoresWithoutUser()
    {
        return User::where([
            ['id', '!=', request()->query('q')],
            ['is_store', 1],
        ])->get(['id', 'name']);
    }
}
