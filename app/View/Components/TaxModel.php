<?php

namespace App\View\Components;

use App\Models\Tax;
use Auth;
use Illuminate\View\Component;

class TaxModel extends Component
{
    public $tax;
    public function __construct()
    {
        $tax = Tax::where('business_id', Auth::guard('web')->user()->business->id)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tax-model');
    }
}
