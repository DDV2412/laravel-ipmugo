<?php

namespace App\Http\Livewire\Frontend;

use App\Models\ArticleRecord;
use App\Models\Author;
use App\Models\CiteArticle;
use App\Models\DownArticle;
use App\Models\Repository;
use App\Models\SaveArticle;
use App\Models\ShareArticle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class ArticleDetail extends Component
{
    public $article;
    public $citeThis = false;

    public function mount($abbreviation, $id)
    {
        $repository = Repository::where(['abbreviation' => $abbreviation])->first();
        $this->article = ArticleRecord::where(['id' => $id, 'repoId' => $repository->id])->first();
    }
    public function render()
    {
        $authors = Author::where('article_id', $this->article->id)->get();
        return view('livewire.frontend.article-detail', compact('authors'))
        ->extends('layouts.app')
        ->section('content');
    }

    public function saveInLibrary($id)
    {
        $save = SaveArticle::where(['article_id' =>$this->article->id, 'user_id' =>  Auth::user()->id])->first();


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
                    'article_id' =>$this->article->id,
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

    public function citeNow()
    {
        $this->citeThis = true;
    }


    public function citeCopy()
    {
        $position = Location::get();
        $cite = CiteArticle::where(['article_id' => $this->article->id, 'address' =>   $position->ip])->first();
        if(!empty($cite))
        {

        }else{
            CiteArticle::create([
                'article_id' =>$this->article->id,
                'address' => $position->ip,
                'countryName' => $position->countryName,
            ]);
        }
    }
    
    public function downloadArticle()
    {
        $position = Location::get();
        $down = DownArticle::where(['article_id' => $this->article->id, 'address' =>  $position->ip])->first();
        if(!empty($down))
        {

        }else{
            DownArticle::create([
                'article_id' =>$this->article->id,
                'address' => $position->ip,
                'countryName' => $position->countryName,
            ]);
        }        
    }

    public function shareOnFacebook()
    {
        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' =>$this->article->id, 'address' =>   $position->ip, 'sosial' => 'Facebook'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' =>$this->article->id,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Facebook',
            ]);
            
        }
    }
    public function shareOnTwitter()
    {
        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' =>$this->article->id, 'address' =>   $position->ip, 'sosial' => 'Twitter'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' =>$this->article->id,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Twitter',
            ]);
        }
    }
    public function shareOnWhatsapp()
    {
        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' =>$this->article->id, 'address' =>   $position->ip, 'sosial' => 'Whatsapp'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' =>$this->article->id,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Whatsapp',
            ]);
        }
    }
    public function shareOnMail()
    {
        $position = Location::get();
        $shareOn = ShareArticle::where(['article_id' =>$this->article->id, 'address' =>   $position->ip, 'sosial' => 'Google'])->first();
        if(!empty($shareOn))
        {

        }else{
            ShareArticle::create([
                'article_id' =>$this->article->id,
                'address' => $position->ip,
                'countryName' => $position->countryName,
                'sosial' => 'Mail',
            ]);
        }
    }

    public function back()
    {
        return redirect()->route('articles');
    }
}
