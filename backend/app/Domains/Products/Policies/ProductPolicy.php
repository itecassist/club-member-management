<?php

namespace App\Domains\Products\Policies;

use App\Domains\Products\Models\Product;

class ProductPolicy
{

    public function view(\App\Models\User $user, Product $Product)
    {
        return $user->organisation_id === $Product->organisation_id;
    }

    public function create(\App\Models\User $user, Product $Product)
    {
        return $user->organisation_id === $Product->organisation_id;
    }

    public function update(\App\Models\User $user, Product $Product)
    {
        return $user->organisation_id === $Product->organisation_id;
    }

    public function delete(\App\Models\User $user, Product $Product)
    {
        return $user->organisation_id === $Product->organisation_id;
    }

}