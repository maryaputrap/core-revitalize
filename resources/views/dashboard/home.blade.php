@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <div id="chart" style="max-width: 400px;">
        {!! $chart->container() !!}
    </div>
@endsection

@section('script')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endsection
