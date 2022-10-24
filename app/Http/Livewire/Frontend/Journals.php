<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Repository;
use Livewire\Component;
use Livewire\WithPagination;

class Journals extends Component
{
    use WithPagination;
    public $paginate = 10;
    public $sortBy = 'repoTitle';
    public $search = '';
    public $sortDirection = 'asc';
    
    public function render()
    {
        $repositories = Repository::query()->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.frontend.journals', compact('repositories'))
        ->extends('layouts.app')
        ->section('content');
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

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
