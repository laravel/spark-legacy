@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('Login')</div>

                <div class="panel-body">
                    @include('spark::shared.errors')

                    <form class="form-horizontal" role="form" method="POST" action="/login">
                        {{ csrf_field() }}

                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('E-Mail Address')</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('Password')</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa m-r-xs fa-sign-in"></i>@lang('Login')
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">@lang('Forgot Your Password?')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
