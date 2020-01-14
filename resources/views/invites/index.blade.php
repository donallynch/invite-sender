@extends('layouts.map')

@section('top-nav-bar')
    @parent
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" crossorigin="anonymous">
@endsection

@section('content')
    <div class="row p-6">
        <div class="col-12">
            <div class="page-title">
                <h1>{!! __('messages.assignment') !!}</h1>
                <h5>{!! __('messages.instructions') !!}</h5>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" id="get-json" class="btn btn-sm btn-secondary">{!! __('messages.upload-json-file') !!}</button>
                </div>
            </div>
            <div id="renderer"></div>
        </div>
    </div>
@endsection

@section('footer-nav')
    @parent
@endsection

@section('js')
    @parent()
    <script src="{{ asset('js/inviter.js') }}"></script>
@endsection
