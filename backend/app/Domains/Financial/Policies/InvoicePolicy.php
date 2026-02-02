<?php

namespace App\Domains\Financial\Policies;

use App\Domains\Financial\Models\Invoice;

class InvoicePolicy
{

    public function view(\App\Models\User $user, Invoice $Invoice)
    {
        return $user->organisation_id === $Invoice->organisation_id;
    }

    public function create(\App\Models\User $user, Invoice $Invoice)
    {
        return $user->organisation_id === $Invoice->organisation_id;
    }

    public function update(\App\Models\User $user, Invoice $Invoice)
    {
        return $user->organisation_id === $Invoice->organisation_id;
    }

    public function delete(\App\Models\User $user, Invoice $Invoice)
    {
        return $user->organisation_id === $Invoice->organisation_id;
    }

}