<?php

namespace App\Domains\Content\Policies;

use App\Domains\Content\Models\Article;

class ArticlePolicy
{

    public function view(\App\Models\User $user, Article $Article)
    {
        return $user->organisation_id === $Article->organisation_id;
    }

    public function create(\App\Models\User $user, Article $Article)
    {
        return $user->organisation_id === $Article->organisation_id;
    }

    public function update(\App\Models\User $user, Article $Article)
    {
        return $user->organisation_id === $Article->organisation_id;
    }

    public function delete(\App\Models\User $user, Article $Article)
    {
        return $user->organisation_id === $Article->organisation_id;
    }

}