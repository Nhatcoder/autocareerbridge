<?php

namespace App\Repositories\User;

use App\Repositories\Base\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel();
    public function getUsers(array $filters);
    public function getUserById($id);
    public function updateToggleStatus(int $id, array $data);
    public function getAdmin();
}
