<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\CrudServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CrudService implements CrudServiceInterface
{
    public function create(array $data, Model $model)
    {
        if (method_exists($model, 'user_id')) {
            $data['user_id'] = $data['user_id'] ?? auth()->id();
        }

        // Create the model
        $createdModel = $model::create($data);

        // Attach categories if applicable
        if (isset($data['categories']) && method_exists($model, 'categories')) {
            $createdModel->categories()->attach($data['categories']);
        }

        return $createdModel;
    }

    public function view(Model $model)
    {
        try {
            // Increment the ranking count
            $model->increment('ranking');

            return $model;
        } catch (ModelNotFoundException $e) {
            Log::error('Website not found: '.$e->getMessage());

            return null;
        } catch (\Exception $e) {
            Log::error('Error viewing website: '.$e->getMessage());

            return null;
        }
    }

    public function deleteModel(Model $model)
    {
        $model->delete();

        return true;
    }
}
