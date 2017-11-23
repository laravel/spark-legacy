@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{__('Login Via Emergency Token')}}</div>

                <div class="card-body">
                    @include('spark::shared.errors')

                    <!-- Warning Message -->
                    <div class="alert alert-warning">
                        {{__('After logging in via your emergency token, two-factor authentication will be disabled for your account. If you would like to maintain two-factor authentication security, you should re-enable it after logging in.')}}
                    </div>

                    <form role="form" method="POST" action="/login-via-emergency-token">
                        {{ csrf_field() }}

                        <!-- Emergency Token -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Emergency Token')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="token" autofocus>
                            </div>
                        </div>

                        <!-- Emergency Token Login Button -->
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Login')}}
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
