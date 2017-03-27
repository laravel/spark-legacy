@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>{{ __('spark::app.general.whoops') }}</strong> {{ __('spark::app.general.something-went-wrong') }}
        <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
