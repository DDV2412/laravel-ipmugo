<?php

namespace App\Http\Livewire\Backend\Admin;

use App\Models\ArticleRecord;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Chart extends Component
{
    public function render()
    {
        $articles = ArticleRecord::select('year', DB::raw('COUNT(*) as `count`'))
        ->groupBy('year')
        ->havingRaw('COUNT(*) > 1')->get();

        foreach($articles as $year){
            if($articles->last() == $year) {
                $lastYear = $year->year;
            }

            if($articles->first() == $year) {
                $firstYear = $year->year;
            }
        }

        $chart = (new LarapexChart)->areaChart()
            ->setTitle('Article Records')
            ->setSubtitle($firstYear.' - '.$lastYear)
            ->addData('Articles',$articles->pluck('count')->toArray())
            ->setXAxis($articles->pluck('year')->toArray());

        return view('livewire.backend.admin.chart', compact('chart'))
        ->extends('layouts.Be')
        ->section('content');
    }
}
