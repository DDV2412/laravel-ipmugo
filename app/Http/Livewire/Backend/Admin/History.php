<?php

namespace App\Http\Livewire\Backend\Admin;

use App\Models\History as ModelsHistory;
use Livewire\Component;
use App\Models\Repository;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;
    
    public $paginate= 10;
    public $sortBy = 'id';
    public $search = '';
    public $sortDirection = 'asc';
    public $repositoryId;

    public function mount($abbreviation)
    {
        $repository = Repository::where('abbreviation', $abbreviation)->first();
        $this->repositoryId = $repository->id;
    }

    public function render()
    {
        $histories = ModelsHistory::query()->search($this->search)->where('repoId', $this->repositoryId)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);

        return view('livewire.backend.admin.history', compact('histories'))
        ->extends('layouts.Be')
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
