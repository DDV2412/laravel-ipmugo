<?php

namespace App\Http\Livewire\Frontend;

use App\Models\ContactUs;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class Contact extends Component
{
    public $name;
    public $email;
    public $massage;

    public function render()
    {
        return view('livewire.frontend.contact')
        ->extends('layouts.app')
        ->section('content');
    }

    public function getMassage()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'massage' => ['required'],
        ]);

        $position = Location::get();

        ContactUs::create([
            'name' => $this->name,
            'email' => $this->email,
            'massage' => $this->massage,
            'address' => $position->ip,
            'countryName' => $position->countryName,
        ]);
    }
}
