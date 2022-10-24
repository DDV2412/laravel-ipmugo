<?php

namespace App\Http\Livewire\Backend\Admin;

use App\Models\ArticleRecord;
use App\Models\CiteArticle;
use App\Models\DownArticle;
use App\Models\Popular;
use App\Models\Repository;
use App\Models\SaveArticle;
use App\Models\ShareArticle;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $users;
    public $cite;
    public $download;
    public $share;

    public function mount()
    {
        $this->users = User::count();
        $this->cite = CiteArticle::count();
        $this->download = DownArticle::count();
        $this->share = ShareArticle::count();
    }
    public function render()
    {
        $articles = ArticleRecord::join('repositories', 'repoId', '=', 'repositories.id')
        ->select('repoId', 'abbreviation', DB::raw('COUNT(*) as `count`'))
        ->groupBy('repoId', 'abbreviation')
        ->orderBy('count')
        ->havingRaw('COUNT(*) > 1')->get();      


        $chart = (new LarapexChart)->areaChart()
            ->setTitle('Repository Records')
            ->setSubtitle(Carbon::now())
            ->addData('Articles', $articles->pluck('count')->toArray())
            ->setXAxis($articles->pluck('abbreviation')->toArray());

        $popular = Popular::select('article_id', DB::raw('COUNT(*) as `count`'))
        ->groupBy('article_id')
        ->orderBy('count')
        ->havingRaw('COUNT(*) > 1')->take(10)->get();

        $downloads = DownArticle::select('article_id', DB::raw('COUNT(*) as `count`'))
        ->groupBy('article_id')
        ->orderBy('count')
        ->havingRaw('COUNT(*) > 1')->take(10)->get();

        $chartDown = (new LarapexChart)->radialChart()
        ->setTitle('Top Articles')
        ->setSubtitle('Download, Share, Cite, Save')
        ->addData([DownArticle::count(), ShareArticle::count(), CiteArticle::count(), SaveArticle::count()])
        ->setLabels(['Download', 'Share', 'Cite', 'Save'])
        ->setColors(['#0EA5E9', '#6366F1', '#F59E0B', '#84CC16']);

        return view('livewire.backend.admin.dashboard', compact('popular', 'downloads', 'chart', 'chartDown'))
        ->extends('layouts.Be')
        ->section('content');
    }
}
