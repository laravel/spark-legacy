Hi!

<br><br>

{{ $invitation->team->owner->name }} has invited you to join their {{ Spark::teamString() }}! If you do not already have an account,
you may click the following link to get started:

<br><br>

<a href="{{ url('register?invitation='.$invitation->token) }}">{{ url('register?invitation='.$invitation->token) }}</a>

<br><br>

See you soon!
