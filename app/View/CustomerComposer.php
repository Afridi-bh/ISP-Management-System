<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CustomerComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $customer = Auth::guard('customer')->user();
        $view->with('customer', $customer);
    }
}