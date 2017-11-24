<spark-payment-method-stripe :user="user" :team="team" :billable-type="billableType" inline-template>
    <div>
        <!-- Current Discount -->
        <div class="card card-success" v-if="currentDiscount">
            <div class="card-header">{{__('Current Discount')}}</div>

            <div class="card-body">
                <?php echo __('You currently receive a discount of :amount for :duration.', ['amount' => '{{ formattedDiscount(currentDiscount) }}', 'duration' => '@{{ formattedDiscountDuration(currentDiscount) }}']); ?>
            </div>
        </div>

        <!-- Update VAT ID -->
        @if (Spark::collectsEuropeanVat())
            @include('spark::settings.payment-method.update-vat-id')
        @endif

        <!-- Update Card -->
        @include('spark::settings.payment-method.update-payment-method-stripe')

        <div>
            <div v-if="billable.stripe_id">
                <!-- Redeem Coupon -->
                @include('spark::settings.payment-method.redeem-coupon')
            </div>
        </div>
    </div>
</spark-payment-method-stripe>
