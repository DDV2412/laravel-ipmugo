<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

class SearchBar extends Component
{
    public $search = '';

    public function render()
    {
        if(!empty($this->search))
        {
            $this->search = Request::query('query');
        }

        return view('livewire.frontend.search-bar')
        ->extends('layouts.app')
                ->section('content');
    }
}
