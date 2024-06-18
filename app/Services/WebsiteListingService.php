<?php

namespace App\Services;

use App\Contracts\WebsiteListingInterface;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WebsiteListingService implements WebsiteListingInterface
{
    public function listwebsites($searchTerm = null, $sortDirection, $perPage = null)
    {
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        $categories = Category::with(['websites' => function ($query) use ($sortDirection, $searchTerm) {
            $query->when($searchTerm, function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                      ->orWhere('description', 'like', '%'.$searchTerm.'%');
            })
                ->orderBy('ranking', $sortDirection);
        }])
        ->orderBy('name', 'asc')
        ->get();

        $formattedCategories = $categories->map(function ($category) {
            return [
            'category_name' => $category->name,
            'websites' => $category->websites->map(function ($website) {
                return [
                    'name' => $website->name,
                    'description' => $website->description,
                    'url' => $website->url,
                    'ranking' => $website->ranking,
                    'votes_count' => $website->votes()->count(),
                ];
            })->toArray(),
        ];
        })->toArray();

        return $formattedCategories;
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
