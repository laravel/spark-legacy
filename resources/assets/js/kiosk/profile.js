module.exports = {
    props: ['user', 'plans'],


    /**
     * The component's data.
     */
    data() {
        return {
            loading: false,
            profile: null,
            revenue: 0
        };
    },

    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        this.$parent.$on('showUserProfile', function(id) {
            self.getUserProfile(id);
        });
    },


    /**
     * Prepare the component.
     */
    mounted() {
        Mousetrap.bind('esc', e => this.showSearch());
    },


    methods: {
        /**
         * Get the profile user.
         */
        getUserProfile(id) {
            this.loading = true;

            axios.get('/spark/kiosk/users/' + id + '/profile')
                .then(response => {
                    this.profile = response.data.user;
                    this.revenue = response.data.revenue;

                    this.loading = false;
                });
        },


        /**
         * Impersonate the given user.
         */
        impersonate(user) {
            window.location = '/spark/kiosk/users/impersonate/' + user.id;
        },


        /**
         * Show the discount modal for the given user.
         */
        addDiscount(user) {
            Bus.$emit('addDiscount', user);
        },


        /**
         * Get the plan the user is actively subscribed to.
         */
        activePlan(billable) {
            if (this.activeSubscription(billable)) {
                var activeSubscription = this.activeSubscription(billable);

                return _.find(this.plans, (plan) => {
                    return plan.id == activeSubscription.provider_plan;
                });
            }
        },


        /**
         * Get the active, valid subscription for the user.
         */
        activeSubscription(billable) {
            var subscription = this.subscription(billable);

            if ( ! subscription ||
                    (subscription.ends_at &&
                     moment.utc().isAfter(moment.utc(subscription.ends_at)))) {
                return;
            }

            return subscription;
        },


        /**
         * Get the active subscription instance.
         */
        subscription(billable) {
            if ( ! billable) {
                return;
            }

            const subscription = _.find(
                billable.subscriptions,
                subscription => subscription.name == 'default'
            );

            if (typeof subscription !== 'undefined') {
                return subscription;
            }
        },


        /**
         * Get the customer URL on the billing provider's website.
         */
        customerUrlOnBillingProvider(billable) {
            if (! billable) {
                return;
            }

            if (this.spark.usesStripe) {
                return 'https://dashboard.stripe.com/customers/' + billable.stripe_id;
            } else {
                var domain = Spark.env == 'production' ? '' : 'sandbox.';

                return 'https://' + domain + 'braintreegateway.com/merchants/' +
                        Spark.braintreeMerchantId +
                        '/customers/' +
                        billable.braintree_id;
            }
        },


        /**
         * Show the search results and hide the user profile.
         */
        showSearch() {
            this.$parent.$emit('showSearch');

            this.profile = null;
        }
    }
};
