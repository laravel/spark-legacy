@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">@lang('Where\'s Your :Team?', ['team' => Spark::teamString()])</div>

                <div class="panel-body">
                    @lang('It looks like you\'re not part of any :teams! You can create one in your :settings.', ['teams' => Spark::teamString(), 'settings' => '<a href="/settings#/'.str_plural(Spark::teamString()).'">'.__('Settings').'</a>'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
