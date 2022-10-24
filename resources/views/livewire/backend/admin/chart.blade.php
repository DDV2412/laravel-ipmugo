@section('title', 'Charts')
<div class="px-2 pt-1 mb-8">
    <div class="mt-1 rounded-md shadow-md pt-2">
        {!! $chart->container() !!}
    </div>
</div>

<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
