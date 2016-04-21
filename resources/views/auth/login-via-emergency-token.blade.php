@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login Via Emergency Token</div>

                <div class="panel-body">
                    @include('spark::shared.errors')

                    <!-- Warning Message -->
                    <div class="alert alert-warning">
                        After logging in via your emergency token, two-factor authentication will be
                        disabled for your account. If you would like to maintain two-factor
                        authentication security, you should re-enable it after logging in.
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action="/login-via-emergency-token">
                        {{ csrf_field() }}

                        <!-- Emergency Token -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">Emergency Token</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="token" autofocus>
                            </div>
                        </div>

                        <!-- Emergency Token Login Button -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
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
