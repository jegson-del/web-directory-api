<?php

namespace App\Services;

use App\Contracts\WebsiteListingInterface;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WebsiteListingService implements WebsiteListingInterface
{
    public function listwebsites($searchTerm, $sortDirection, $perPage)
    {
        $query = Category::join('category_website', 'categories.id', '=', 'category_website.category_id')
        ->join('websites', 'category_website.website_id', '=', 'websites.id')
        ->leftJoin('votes', 'websites.id', '=', 'votes.website_id')
        ->select('categories.name as category_name')
        ->selectRaw('websites.*, COUNT(votes.id) as votes_count')
        ->groupBy('categories.id', 'websites.id')
        ->orderBy('websites.ranking', 'desc'); // Order by highest ranking by default

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('websites.name', 'LIKE', "%$searchTerm%")
                ->orWhere('categories.name', 'LIKE', "%$searchTerm%");
            });
        }

        // Validate sort direction if both params was presented
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc'; // use default DESC
        }

        // Order by votes or ranking
        if ($sortDirection === 'asc') {
            $query->orderBy('votes_count', 'asc')
              ->orderBy('websites.ranking', 'asc');
        } else {
            $query->orderByDesc('votes_count')
              ->orderByDesc('websites.ranking');
        }

        return $query->paginate($perPage);
    }

    public function voteWebsites(Model $model, $website_id)
    {
        $user = Auth::user();
        $already_voted_website = $model->where('website_id', $website_id)->where('user_id', $user->id)->first();
        if ($already_voted_website) {
            return false;
        }

        // Create a new vote record
        $vote = new Vote();
        $vote->user_id = $user->id;
        $vote->website_id = $website_id;
        $vote->save();

        return $vote;
    }

    public function removeVote(Model $model, $website_id)
    {
        $user = Auth::user();
        $vote = $model->where('website_id', $website_id)->where('user_id', $user->id)->first();
        if ($vote) {
            $vote->delete();

            return true;
        }

        return false;
    }
}
