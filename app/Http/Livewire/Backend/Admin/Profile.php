<?php

namespace App\Http\Livewire\Backend\Admin;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.profile')
        ->extends('layouts.Be')
        ->section('content');
    }
}
