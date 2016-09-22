module.exports = {
    props: ['user', 'team', 'plans', 'billableType'],

    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../../mixins/braintree'),
        require('./../../mixins/plans'),
        require('./../../mixins/subscriptions')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({
                braintree_type: '',
                braintree_token: '',
                plan: '',
                coupon: null
            })
        };
    },


    /**
     * Prepare the component.
     */
    ready() {
         // If only yearly subscription plans are available, we will select that interval so that we
         // can show the plans. Then we'll select the first available paid plan from the list and
         // start the form in a good default spot. The user may then select another plan later.
        if (this.onlyHasYearlyPaidPlans) {
            this.showYearlyPlans();
        }

         // Next, we will configure the braintree container element on the page and handle the nonce
         // received callback. We'll then set the nonce and fire off the subscribe method so this
         // nonce can be used to create the subscription for the billable entity being managed.
        this.braintree('braintree-subscribe-container', response => {
            this.form.braintree_type = response.type;
            this.form.braintree_token = response.nonce;

            this.subscribe();
        });
    },


    methods: {
        /**
         * Mark the given plan as selected.
         */
        selectPlan(plan) {
            this.selectedPlan = plan;

            this.form.plan = this.selectedPlan.id;
        },


        /**
         * Subscribe to the specified plan.
         */
        subscribe() {
            Spark.post(this.urlForNewSubscription, this.form)
                .then(response => {
                    this.$dispatch('updateUser');
                    this.$dispatch('updateTeam');
                });
        },


        /**
         * Show the plan details for the given plan.
         *
         * We'll ask the parent subscription component to display it.
         */
        showPlanDetails(plan) {
            this.$dispatch('showPlanDetails', plan);
        }
    },


    computed: {
        /**
         * Get the URL for subscribing to a plan.
         */
        urlForNewSubscription() {
            return this.billingUser
                            ? '/settings/subscription'
                            : `/settings/${Spark.pluralTeamString}/${this.team.id}/subscription`;
        }
    }
};
