{{__('Hi!')}}

<br><br>

{{__(':userName has invited you to join their :teamString', ['userName' => $invitation->team->owner->name, 'teamString' => __(Spark::teamString())])}}

<br><br>

{{__('Since you already have an account, you may accept the invitation from your account settings screen.')}}

<br><br>

{{__('See you soon!')}}
