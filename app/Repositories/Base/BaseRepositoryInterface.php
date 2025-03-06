<?php

namespace App\Repositories\Base;

interface BaseRepositoryInterface
{
    public function getAll();

    public function find($id);

    public function firstOrCreate($data = [], $attributes = []);

    public function create($attributes = []);

    public function insert(array $data);

    public function update($id, $attributes = []);

    public function delete($id);

    public function deleteByIds(array $ids);

    public function deleteByCvId($id);

    public function deleteWhere(array $conditions);
}
