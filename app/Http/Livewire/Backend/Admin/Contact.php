<?php

namespace App\Http\Livewire\Backend\Admin;

use App\Models\ContactUs;
use Livewire\Component;
use Livewire\WithPagination;

class Contact extends Component
{
    use WithPagination;
    public $paginate= 10;
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $search = '';

    public function render()
    {
        $contacs = ContactUs::query()->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.backend.admin.contact', compact('contacs'))
        ->extends('layouts.Be')
        ->section('content');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if($this->sortDirection == 'asc'){
            $this->sortDirection = 'desc';
        } else{
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }
}
