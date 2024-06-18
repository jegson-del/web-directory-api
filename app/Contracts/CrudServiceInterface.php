<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CrudServiceInterface
{
    public function create(array $data, Model $model);

    public function view(Model $model);

    public function deleteModel(Model $model);
}
