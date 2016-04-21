@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">Where's Your Team?</div>

                <div class="panel-body">
                    It looks like you're not part of a team! You can create one in your
                    <a href="/settings#/teams">settings</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
