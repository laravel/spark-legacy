@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">{{ __('spark::app.auth.wheres-your-team', ['team' => Spark::teamString()]) }}</div>

                <div class="panel-body">
                    {{ __('spark::app.auth.missing-team-create-settings', ['team' => Spark::teamString(), 'settings' => '<a href="/settings#/{{ str_plural(Spark::teamString()) }}">'.__('spark::app.auth.settings).'</a>']) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
