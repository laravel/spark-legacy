@extends('spark::layouts.app')

@section('content')
<div class="container">
    <!-- Application Dashboard -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Terms Of Service</div>

                <div class="panel-body terms-of-service">
                    {!! $terms !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
