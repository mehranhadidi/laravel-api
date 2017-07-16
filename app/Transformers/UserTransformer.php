<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Single user transformer
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => $user->avatar()
        ];
    }
}
