<?php

namespace App\Http\Livewire\Frontend;

use App\Models\ArticleRecord;
use App\Models\Author;
use App\Models\Popular;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Repository;
use Stevebauman\Location\Facades\Location;

class Welcome extends Component
{
    public function render()
    {
        $articles = ArticleRecord::orderBy('date', 'desc')->take(15)->get();
        $articleRecord = ArticleRecord::count();
        $subjects = Subject::count();
        $authors = Author::count();
        $popular = Popular::count();
        $repositories = Repository::all();
        return view('livewire.frontend.welcome', compact('repositories','articleRecord','articles', 'subjects', 'authors', 'popular'))
            ->extends('layouts.app')
                ->section('content');
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
