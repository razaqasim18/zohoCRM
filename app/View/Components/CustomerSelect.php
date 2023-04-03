<?php

namespace App\View\Components;

use App\Models\Customer as CustomerModel;
use Auth;
use Illuminate\View\Component;

class CustomerSelect extends Component
{
    public $selectedid;
    public $customer;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selectedid = '')
    {
        $customer = CustomerModel::where('business_id', Auth::user()->business->id)->get();
        $this->customer = $customer;
        $this->selectedid = $selectedid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer-select');
    }
}
