<?php

namespace App\Http\Livewire\Backend\Reader;

use App\Models\ArticleRecord;
use App\Models\SaveArticle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Library extends Component
{
    use WithPagination;
    
    public $paginate= 10;
    public $sortBy = 'article_records.id';
    public $search = '';
    public $sortDirection = 'asc';

    
    public function render()
    {
        $articles = ArticleRecord::query()->search($this->search)
        ->join('save_articles', 'save_articles.article_id', '=', 'article_records.id')->where('user_id', Auth::user()->id)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);  


        return view('livewire.backend.reader.library', compact('articles'))
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

    public function deleteArticle($id)
    {
        SaveArticle::findOrFail($id)->delete();

        $this->alert('success', 'Article Deleted Successfully', [
            'position' =>  'center', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Close', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  false, 
            'cancelButtonColor' => '#EF4444'
        ]);
    }

    public function newArticle()
    {
        return redirect()->route('articles');
    }
}
