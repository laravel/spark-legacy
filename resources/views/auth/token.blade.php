@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('spark::app.auth.2fa') }}</div>

                <div class="panel-body">
                    @include('spark::shared.errors')

                    <form class="form-horizontal" role="form" method="POST" action="/login/token">
                        {{ csrf_field() }}

                        <!-- Token -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ __('spark::app.auth.authentication-token') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="token" autofocus>
                            </div>
                        </div>

                        <!-- Verify Button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('spark::app.auth.verify') }}
                                </button>

                                <a class="btn btn-link" href="{{ url('login-via-emergency-token') }}">
                                    {{ __('spark::app.auth.lost-device') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
