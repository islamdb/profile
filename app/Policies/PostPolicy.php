<?php

namespace App\Policies;

use \App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class PostPolicy
{
    use HandlesAuthorization;

    public $prefix = '';

    public function __construct()
    {
        $this->prefix = str_replace('Policy', '', static::class);
        $this->prefix = str_replace('App\Policies\\', '', $this->prefix);
        $this->prefix = Str::snake($this->prefix, '-') . '.';
    }

    /**
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        return $user->hasAccess($this->prefix . 'menu');
    }

        /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAccess($this->prefix.'browse');
    }

    /**
     * Determine whether the user can view the Post.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function view(User $user, Post  $post)
    {
        return $user->hasAccess($this->prefix.'read');;
    }

    /**
     * Determine whether the user can create Post.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess($this->prefix.'add');;
    }

    /**
     * Determine whether the user can update the Post.
     *
     * @param User $user
     * @param  Post  $post
     * @return mixed
     */
    public function update(User $user, Post  $post)
    {
        return $user->hasAccess($this->prefix.'edit');;
    }

    /**
     * Determine whether the user can delete the Post.
     *
     * @param User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function delete(User $user, Post  $post)
    {
        return $user->hasAccess($this->prefix.'delete');
    }

    /**
     * Determine whether the user can force delete the Post.
     *
     * @param User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post  $post)
    {
        return $user->hasAccess($this->prefix.'force-delete');
    }

    /**
     * Determine whether the user can restore the Post.
     *
     * @param User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function restore(User $user, Post  $post)
    {
        return $user->hasAccess($this->prefix.'restore');
    }


}
