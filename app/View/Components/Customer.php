<?php

namespace App\View\Components;

use App\Models\Customer as CustomerModel;
use Auth;
use Illuminate\View\Component;

class Customer extends Component
{
    public $customer;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $customer = CustomerModel::where('business_id', Auth::user()->business->id)->get();
        $this->customer = $customer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer');
    }
}
