<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface WebsiteListingInterface
{
    public function listwebsites($searchTerm, $sortDirection, $perPage);

    public function voteWebsites(Model $model, $website_id);

    public function removeVote(Model $model, $website_id);
}
