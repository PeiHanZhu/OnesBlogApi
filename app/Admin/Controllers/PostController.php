<?php

namespace App\Admin\Controllers;

use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;

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
                ->select(User::pluck('name', 'id'));
            $filter->like('location.name', __('admin.location_name'));
            $filter->equal('location.category_id', __('admin.location_category_id'))
                ->select(__('admin.location_category_options'));
            $filter->like('title', __('admin.post_title'));
            $filter->between('published_at', __('admin.post_published_at'))->datetime();
            $filter->equal('active', __('admin.post_active'))->radio(__('admin.post_active_options'));
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
        $grid->column('location.name', __('admin.location_name'))->sortable();
        $grid->column('location.category_id', __('admin.location_category_id'))
            ->using(__('admin.location_category_options'))
            ->dot([
                1 => 'warning',
                2 => 'success',
                3 => 'danger',
            ])->sortable();
        $grid->column('title', __('admin.post_title'))->limit(50);
        $grid->column('published_at', __('admin.post_published_at'));
        $grid->column('active', __('admin.post_active'))
            ->using(__('admin.post_active_options'))
            ->label([
                0 => 'danger',
                1 => 'success',
            ]);
        $grid->column('images', __('admin.post_images'))->display(function ($filePaths) {
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
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('user.name', __('admin.user_name'));
        $show->field('location.name', __('admin.location_name'));
        $show->field('location.category_id', __('admin.location_category_id'))->using(__('admin.location_category_options'));
        $show->field('title', __('admin.post_title'));
        $show->field('content', __('admin.post_content'));
        $show->field('published_at', __('admin.post_published_at'));
        $show->field('active', __('admin.post_active'))->using(__('admin.post_active_options'));
        $show->field('slug', __('admin.slug'));
        $show->field('images', __('admin.post_images'))->image();

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

        if ($form->isEditing()) {
            $form->display('user.name', __('admin.user_name'));
            $form->display('location.name', __('admin.location_name'));
            $form->display('location.category_id', __('admin.location_category_id'))
                ->with(function ($value) {
                    return __('admin.location_category_options')[$value];
                });
        } else {
            $form->select('user_id', __('admin.user_name'))
                ->options(User::pluck('name', 'id'))
                ->load('location_id', route('admin.api.locations.index.without-user'), 'id', 'name', false)
                ->config('allowClear', false)
                ->rules('required');
            $form->select('location_id', __('admin.location_name'))->rules('required');
        }
        $form->text('title', __('admin.post_title'))->rules('required');
        $form->textarea('content', __('admin.post_content'));
        $form->datetime('published_at', __('admin.post_published_at'))->default(date('Y-m-d H:i:s'));
        $form->switch('active', __('admin.post_active'))->states([
            'on' => ['value' => 1, 'text' => __('admin.post_active_options.1'), 'color' => 'success'],
            'off' => ['value' => 0, 'text' => __('admin.post_active_options.0'), 'color' => 'danger'],
        ]);
        $post = $form->model()->find(request()->route('post'));
        if ($form->isEditing()) {
            $form->display('slug', __('admin.slug'));
            $form->multipleImage('images', __('admin.post_images'))
                ->move("posts/{$post->id}")
                ->uniqueName()
                ->options([
                    'showClose' => false,
            ]);
        }

        return $form;
    }

    /**
     * @api Get all the locations without the specified user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function indexLocationsWithoutUser()
    {
        return Location::where([
            ['user_id', '!=', request()->query('q')],
        ])->get(['id', 'name']);
    }
}
