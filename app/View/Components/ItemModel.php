<?php

namespace App\View\Components;

use Auth;
use App\Models\Unit;
use App\Models\AccountType;
use App\Models\Tax;
use Illuminate\View\Component;

class ItemModel extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $unit;
    public $account;
    public $tax;
    public function __construct()
    {
        $unit = Unit::all();
        $account = AccountType::all();
        $tax = Tax::where('business_id', Auth::guard('web')->user()->business->id)->get();
        $this->unit = $unit;
        $this->account = $account;
        $this->tax = $tax;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item-model');
    }
}
