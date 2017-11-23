@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">{{__('Login')}}</div>

                <div class="card-body">
                    @include('spark::shared.errors')

                    <form role="form" method="POST" action="/login">
                        {{ csrf_field() }}

                        <!-- E-Mail Address -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-md-right">{{__('E-Mail')}}</label>

                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-md-right">{{__('Password')}}</label>

                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group row">
                            <div class="col-sm-6 offset-sm-3">
                                <div class="form-check-label">
                                    <label>
                                        <input type="checkbox" name="remember" class="form-check-input"> {{__('Remember Me')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="form-group row mb-0">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Login')}}
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">{{__('Forgot Your Password?')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
