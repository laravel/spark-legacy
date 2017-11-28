<spark-payment-method-braintree :user="user" :team="team" :billable-type="billableType" inline-template>
    <div>
        <!-- Current Discount -->
        <div class="alert alert-success" v-if="currentDiscount">
            <span v-if="currentDiscount.duration=='repeating' && currentDiscount.duration_in_months > 1">@{{ __("You currently receive a discount of :discountAmount for all invoices during the next :months billing cycles.", {discountAmount: formattedDiscount(currentDiscount), months: currentDiscount.duration_in_months}) }}</span>
            <span v-if="currentDiscount.duration=='repeating' && currentDiscount.duration_in_months == 1">@{{ __("You currently receive a discount of :discountAmount for all invoices during the next billing cycle.", {discountAmount: formattedDiscount(currentDiscount)}) }}</span>
            <span v-if="currentDiscount.duration=='forever'">@{{ __("You currently receive a discount of :discountAmount forever.", {discountAmount: formattedDiscount(currentDiscount)}) }}</span>
            <span v-if="currentDiscount.duration=='once'">@{{ __("You currently receive a discount of :discountAmount for a single invoice.", {discountAmount: formattedDiscount(currentDiscount)}) }}</span>
        </div>

        <!-- Update Card -->
        @include('spark::settings.payment-method.update-payment-method-braintree')

        <div>
            <div v-if="billable.current_billing_plan">
                <!-- Redeem Coupon -->
                @include('spark::settings.payment-method.redeem-coupon')
            </div>
        </div>
    </div>
</spark-payment-method-braintree>
