<div class="panel panel-warning" v-if="subscriptionIsOnTrial">
    <div class="panel-heading">
        <i class="fa fa-btn fa-clock-o"></i>@lang('Free Trial')
    </div>

    <div class="panel-body">
        @lang('You are currently within your free trial period. Your trial will expire on :date.', ['date' => '<strong>@{{ trialEndsAt }}</strong>'])
    </div>
</div>
