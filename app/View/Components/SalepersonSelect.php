<?php

namespace App\View\Components;

use App\Models\SalesPerson;
use Auth;
use Illuminate\View\Component;

class SalepersonSelect extends Component
{
    public $selectedid;
    public $salesperson;
    public function __construct($selectedid = '')
    {
        $salesperson = SalesPerson::where('business_id', Auth::user()->business->id)->get();
        $this->salesperson = $salesperson;
        $this->selectedid = $selectedid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.saleperson-select');
    }
}
