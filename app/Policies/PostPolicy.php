<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Update policy
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    /**
     * Destroy policy
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function destroy(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    /**
     * Users cannot like their own posts, They only can like someone else posts
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function like(User $user, Post $post)
    {
        return ! $user->ownsPost($post);
    }
}
