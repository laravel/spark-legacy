@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('spark::app.auth.login-emergency-token') }}</div>

                <div class="panel-body">
                    @include('spark::shared.errors')

                    <!-- Warning Message -->
                    <div class="alert alert-warning">
                        {{ __('spark::app.auth.emergency-token-warning') }}
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action="/login-via-emergency-token">
                        {{ csrf_field() }}

                        <!-- Emergency Token -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ __('spark::app.auth.emergency-token') }}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="token" autofocus>
                            </div>
                        </div>

                        <!-- Emergency Token Login Button -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>{{ __('spark::app.auth.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
