<?php

namespace App\Http\Livewire\Frontend;

use App\Models\ArticleRecord;
use App\Models\Popular;
use App\Models\Repository;
use App\Models\SaveArticle;
use App\Models\ShareArticle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Stevebauman\Location\Facades\Location;

class JournalDetail extends Component
{
    use WithPagination;

    public $repository;
    public $paginate = 50;
    public $sortBy = 'date';
    public $search = '';
    public $sortDirection = 'asc';
    public $repositoryId;
    public $years;
    public $issueOriginal;
    public $articleId;

    public function mount($abbreviation)
    {
        $this->repository = Repository::where('abbreviation' , $abbreviation)->first();
    }

    public function render()
    {
        $sortByYears = ArticleRecord::where(['repoId' => $this->repository->id])->select('year', DB::raw('COUNT(*) as `count`'))
        ->groupBy('year')
        ->havingRaw('COUNT(*) > 1')->get();

        $articleIssue = ArticleRecord::where(['repoId' => $this->repository->id])->select('issue', DB::raw('COUNT(*) as `count`'))
        ->groupBy('issue')
        ->orderBy('issue', 'asc')
        ->havingRaw('COUNT(*) > 1')->get();

        foreach($sortByYears as $year){
            if($sortByYears->last() == $year) {
                $lastYear = $year->year;
            }

            if($sortByYears->first() == $year) {
                $firstYear = $year->year;
            }
        }

        if($this->issueOriginal)
        {
            $articles = ArticleRecord::query()->search($this->search)->where(['repoId' => $this->repository->id, 'issue' => $this->issueOriginal])->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);

        }elseif($this->years)
        {
            $articles = ArticleRecord::query()->search($this->search)->where(['repoId' => $this->repository->id, 'year' => $this->years])->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        }else{
            $articles = ArticleRecord::query()->search($this->search)->where(['repoId' => $this->repository->id])->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        }
        return view('livewire.frontend.journal-detail', compact('articles', 'lastYear', 'firstYear', 'articleIssue'))
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

    public function saveInLibrary($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;

        $save = SaveArticle::where(['article_id' => $this->articleId, 'user_id' =>  Auth::user()->id])->first();


        if(!empty($save)){
            $this->alert('success', 'Article Ready In Your Library', [
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
        }else{
            if ($position = Location::get()) {
                SaveArticle::create([
                    'article_id' => $this->articleId,
                    'user_id' => Auth::user()->id,
                    'address' => $position->ip,
                    'countryName' => $position->countryName,
                ]);
            } 
            $this->alert('success', 'Article Saved In Your Library Successfully', [
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

        
    }

    public function shareOnFacebook($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;

        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' => $this->articleId, 'address' =>   $position->ip, 'sosial' => 'Facebook'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' => $this->articleId,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Facebook',
            ]);
            
        }
    }
    public function shareOnTwitter($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;

        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' => $this->articleId, 'address' =>   $position->ip, 'sosial' => 'Twitter'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' => $this->articleId,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Twitter',
            ]);
        }
    }
    public function shareOnWhatsapp($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;

        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' => $this->articleId, 'address' =>   $position->ip, 'sosial' => 'Whatsapp'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' => $this->articleId,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Whatsapp',
            ]);
        }
    }
    public function shareOnMail($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;

        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' => $this->articleId, 'address' =>   $position->ip, 'sosial' => 'Google'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' => $this->articleId,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Mail',
            ]);
        }
    }

    public function viewPopular($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;

        $position = Location::get();
        $viewOn = Popular::where(['article_id' => $this->articleId, 'address' => $position->ip])->first();
        if(!empty($viewOn))
        {

        }else{
            Popular::create([
                'article_id' => $this->articleId,
                'address' => $position->ip,
                'countryName' => $position->countryName,
            ]);
        }

    }
}
