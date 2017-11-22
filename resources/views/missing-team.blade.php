@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="intro">
                <div class="intro-img">
                    <img src="{{asset('/img/create-team.svg')}}" class="h-90">
                </div>
                <h2 class="intro-headline">
                    Where's Your {{ ucfirst(Spark::teamString()) }}?
                </h2>
                <p class="intro-copy">
                    It looks like you're not part of any {{ Spark::teamString() }}!
                </p>
                <div class="intro-btn">
                    <a href="/settings#/{{ str_plural(Spark::teamString()) }}" class="btn btn-outline-dark">Create {{ Spark::teamString() }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
