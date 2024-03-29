<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;

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
            $filter->equal('user_id', __('admin.user_name'))
                ->select($this->getUserSelectOptions());
            $filter->like('post.title', __('admin.post_title'));
            $filter->like('content', __('admin.comment_content'));
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('admin.created_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('updated_at', __('admin.updated_at'))->display(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        $grid->column('user.name', __('admin.user_name'))
            ->display(function ($value) {
                $href = route('admin.users.show', [
                    'user' => $this->user_id,
                ]);
                return "<a href='$href' target='_blank'>$value</a>";
            })->sortable();
        $grid->column('post.title', __('admin.post_title'))->limit(50)
            ->display(function ($value) {
                $href = route('admin.posts.show', [
                    'post' => $this->post_id,
                ]);
                return "<a href='$href' target='_blank'>$value</a>";
            })->sortable();
        $grid->column('content', __('admin.comment_content'))->limit(30)->sortable();
        $grid->column('images', __('admin.comment_images'))->display(function ($filePaths) {
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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));
        $show->field('user.name', __('admin.user_name'));
        $show->field('post.title', __('admin.post_title'));
        $show->field('content', __('admin.comment_content'));
        $show->field('images', __('admin.comment_images'))->image();

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
        $comment = $form->model()->find(request()->route('comment'));
        if ($form->isEditing()) {
            $form->multipleImage('images', __('admin.comment_images'))
                ->move("comments/{$comment->id}")
                ->uniqueName()
                ->options([
                    'showClose' => false,
                ]);
        }

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
