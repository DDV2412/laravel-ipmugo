<?php

namespace App\Http\Livewire\Backend\Reader;

use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class Dashboard extends Component
{
    public function render()
    {
        $posision = Location::get();
        return view('livewire.backend.reader.dashboard', compact('posision'))
        ->extends('layouts.Be')
        ->section('content');
    }
}
