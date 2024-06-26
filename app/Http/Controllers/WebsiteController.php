<?php

namespace App\Http\Controllers;

use App\Contracts\CrudServiceInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\WebsiteRequest;
use App\Http\Requests\WebsiteShowRequest;
use App\Models\Website;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    protected $crudService;

    public function __construct(CrudServiceInterface $crudService)
    {
        $this->crudService = $crudService;
    }

    public function create(WebsiteRequest $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return ResponseHelper::error(false, 'Unauthorized', 401);
            }
            // Prepare the data including user_id
            $data = array_merge($request->validated(), ['user_id' => $user->id]);

            $website = $this->crudService->create($data, new Website());

            return ResponseHelper::success(true, 'Website added to directory succesuflly', $website, 201);
        } catch (\Exception $e) {
            return ResponseHelper::error(false, 'Unable to create website, please try again', 500);
        }
    }

    public function view(WebsiteShowRequest $request)
    {
        $model = Website::find($request->id);

        $data = $this->crudService->view($model);

        return ResponseHelper::success(true, 'successfully fecthed data', $data, 200);
    }

    public function delete(WebsiteShowRequest $request)
    {
        $model = Website::find($request->id);

        if ($model) {
            $this->crudService->deleteModel($model);

            return ResponseHelper::success(true, 'deleted succesfully', null, 204);
        }

        return ResponseHelper::error(false, 'model not found', 401);
    }
}
