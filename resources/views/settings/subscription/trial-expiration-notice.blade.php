<div class="alert alert-warning mb-4" v-if="subscriptionIsOnTrial">
    <?php echo __('You are currently within your free trial period. Your trial will expire on :date.', ['date' => '<strong>{{ trialEndsAt }}</strong>']); ?>
</div>
