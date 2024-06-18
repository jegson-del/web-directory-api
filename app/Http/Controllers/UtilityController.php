<?php

namespace App\Http\Controllers;

use App\Contracts\WebsiteListingInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\VoteRequest;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UtilityController extends Controller
{
    protected $listingService;

    public function __construct(WebsiteListingInterface $listingService)
    {
        $this->listingService = $listingService;
    }

    public function listing(Request $request)
    {
        $perpage = 50;
        $searchTerm = $request->search;
        $sortDirection = $request->sort_direction;
        try {
            $data = $this->listingService->listwebsites($searchTerm, $sortDirection, $perpage);
            if ($data) {
                return ResponseHelper::success(true, ' data fetched succesfully', $data, 200);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching website listings: '.$e->getMessage());

            return ResponseHelper::error(false, 'Failed to fetch data', 500);
        }
    }

    public function vote(VoteRequest $request)
    {
        $model = new Vote();
        $website_id = $request->website_id;
        $data = $this->listingService->voteWebsites($model, $website_id);

        if (!$data) {
            return ResponseHelper::error(false, 'You already voted this website', 401);
        }

        return ResponseHelper::success(true, 'vote added successfully', $data, 201);
    }

    public function unvote(VoteRequest $request)
    {
        $model = new Vote();
        $website_id = $request->website_id;
        $data = $this->listingService->removeVote($model, $website_id);
        if ($data) {
            return ResponseHelper::success(true, ' you have unvote website succesfully', $data, 200);
        }

        return ResponseHelper::error(false, 'something went wrong', 500);
    }
}
