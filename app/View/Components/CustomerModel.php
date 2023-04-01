<?php

namespace App\View\Components;

use App\Models\Salutation;
use Illuminate\View\Component;

class CustomerModel extends Component
{
    public $salutation;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->salutation = Salutation::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer-model');
    }
}
