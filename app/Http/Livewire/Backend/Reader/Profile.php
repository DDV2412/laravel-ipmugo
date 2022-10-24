<?php

namespace App\Http\Livewire\Backend\Reader;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.backend.reader.profile')
        ->extends('layouts.Be')
        ->section('content');
    }
}
