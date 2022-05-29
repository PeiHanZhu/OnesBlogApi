<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->filter(function ($filter) {
            $filter->between('created_at', __('admin.created_at'))->datetime();
            $filter->between('updated_at', __('admin.updated_at'))->datetime();
            $filter->like('user_id', __('admin.user_name'))
                ->select($this->getUserSelectOptions());
            $filter->like('title', __('admin.post_title'));
            $filter->between('published_at', __('admin.published_at'))->datetime();
            $filter->like('content', __('admin.comment_content'));
        });

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('admin.created_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });;
        $grid->column('updated_at', __('admin.updated_at'))->display(function () {
            return date('Y-m-d H:i:s');
        });;
        $grid->column('user.name', __('admin.user_name'));
        $grid->column('post.title', __('admin.post_title'))->limit(50)
            ->display(function ($value) {
                $href = route('admin.posts.show', [
                    'post' => $this->post_id,
                ]);
            return "<a href='$href' target='_blank'>$value</a>";
        });
        $grid->column('content', __('admin.comment_content'))->limit(30);

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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('user.name', __('admin.user_name'));
        $show->field('post.title', __('admin.post_title'));
        $show->field('content', __('admin.comment_content'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment());

        $form->select('user_id', __('admin.user_name'))
            ->rules('required')
            ->options($this->getUserSelectOptions())
            ->config('allowClear', false);
        $form->select('post_id', __('admin.post_title'))
            ->rules('required')
            ->options(Post::pluck('title', 'id'))
            ->config('allowClear', false);
        $form->textarea('content', __('admin.comment_content'))->rules('required');

        return $form;
    }

    /**
     * Get select options of all the users.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getUserSelectOptions()
    {
        return User::pluck('name', 'id');
    }
}
