@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{__('Two-Factor Authentication')}}</div>

                <div class="card-body">
                    @include('spark::shared.errors')

                    <form role="form" method="POST" action="/login/token">
                        {{ csrf_field() }}

                        <!-- Token -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Authentication Token')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="token" autofocus>
                            </div>
                        </div>

                        <!-- Verify Button -->
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Verify')}}
                                </button>

                                <a class="btn btn-link" href="{{ url('login-via-emergency-token') }}">
                                    {{__('Lost Your Device?')}}
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
