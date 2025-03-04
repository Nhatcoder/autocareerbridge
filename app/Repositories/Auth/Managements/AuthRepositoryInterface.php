<?php

namespace App\Repositories\Auth\Managements;

use App\Repositories\Base\BaseRepositoryInterface;

interface AuthRepositoryInterface extends BaseRepositoryInterface
{
    public function userConfirm($token);
    public function login($data);
    public function checkForgotPassword($email);

    /**
     * Find a user by email.
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param string $email
     * @return \App\Models\User|null
     */
    public function findbyEmail($email);
}
