<div class="panel panel-warning" v-if="subscriptionIsOnTrial">
    <div class="panel-heading">
        <i class="fa fa-btn fa-clock-o"></i>Free Trial
    </div>

    <div class="panel-body">
        You are currently within your free trial period. Your trial will expire on <strong>@{{ trialEndsAt }}</strong>.
    </div>
</div>
