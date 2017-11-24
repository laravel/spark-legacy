@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="intro mt-5">
                <div class="intro-img">
                    <img src="{{asset('/img/create-team.svg')}}" class="h-90">
                </div>
                <h4>
                    {{__('Where\'s your :teamString?', ['teamString' => ucfirst(__(Spark::teamString()))])}}
                </h4>
                <p class="intro-copy">
                    {{__('It looks like you\'re not part of any :teamString!', ['teamString' => ucfirst(__(Spark::teamString()))])}}
                </p>
                <div class="intro-btn">
                    <a href="/settings#/{{ str_plural(Spark::teamString()) }}" class="btn btn-outline-dark">
                        {{__('Create :teamString', ['teamString' => ucfirst(__(Spark::teamString()))])}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
