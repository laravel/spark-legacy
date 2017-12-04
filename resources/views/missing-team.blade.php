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
                    {{__('teams.wheres_your_team')}}
                </h4>
                <p class="intro-copy">
                    {{__('teams.looks_like_you_are_not_part_of_team')}}
                </p>
                <div class="intro-btn">
                    <a href="/settings#/{{ Spark::teamsPrefix() }}" class="btn btn-outline-dark">
                        {{__('teams.create_team')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
