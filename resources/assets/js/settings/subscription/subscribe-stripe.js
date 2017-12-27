module.exports = {
    props: ['user', 'team', 'plans', 'billableType'],

    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../../mixins/plans'),
        require('./../../mixins/subscriptions'),
        require('./../../mixins/vat'),
        require('./../../mixins/stripe')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            taxRate: 0,

            cardElement: null,

            form: new SparkForm({
                use_exiting_payment_method: this.hasPaymentMethod() ? '1' : '0',
                stripe_token: '',
                plan: '',
                coupon: null,
                address: '',
                address_line_2: '',
                city: '',
                state: '',
                zip: '',
                country: 'US',
                vat_id: ''
            }),

            cardForm: new SparkForm({
                name: ''
            })
        };
    },


    watch: {
        /**
         * Watch for changes on the entire billing address.
         */
        'currentBillingAddress': function (value) {
            if ( ! Spark.collectsEuropeanVat) {
                return;
            }

            this.refreshTaxRate(this.form);
        }
    },


    /**
     * Prepare the component.
     */
    mounted() {
        this.cardElement = this.createCardElement('#card-element');

        this.initializeBillingAddress();

        if (this.onlyHasYearlyPaidPlans) {
            this.showYearlyPlans();
        }
    },


    methods: {
        /**
         * Initialize the billing address form for the billable entity.
         */
        initializeBillingAddress() {
            this.form.address = this.billable.billing_address;
            this.form.address_line_2 = this.billable.billing_address_line_2;
            this.form.city = this.billable.billing_city;
            this.form.state = this.billable.billing_state;
            this.form.zip = this.billable.billing_zip;
            this.form.country = this.billable.billing_country || 'US';
            this.form.vat_id = this.billable.vat_id;
        },


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
            this.cardForm.errors.forget();

            this.form.startProcessing();

            if (this.form.use_exiting_payment_method == '1') {
                return this.createSubscription();
            }

             // Here we will build out the payload to send to Stripe to obtain a card token so
             // we can create the actual subscription. We will build out this data that has
             // this credit card number, CVC, etc. and exchange it for a secure token ID.
            const payload = {
                name: this.cardForm.name,
                address_line1: this.form.address || '',
                address_line2: this.form.address_line_2 || '',
                address_city: this.form.city || '',
                address_state: this.form.state || '',
                address_zip: this.form.zip || '',
                address_country: this.form.country || ''
            };

             // Next, we will send the payload to Stripe and handle the response. If we have a
             // valid token we can send that to the server and use the token to create this
             // subscription on the back-end. Otherwise, we will show the error messages.
            this.stripe.createToken(this.cardElement, payload).then(response => {
                if (response.error) {
                    this.cardForm.errors.set({card: [
                        response.error.message
                    ]});

                    this.form.busy = false;
                } else {
                    this.createSubscription(response.token.id);
                }
            });
        },


        /*
         * After obtaining the Stripe token, create subscription on the Spark server.
         */
        createSubscription(token) {
            this.form.stripe_token = token;

            Spark.post(this.urlForNewSubscription, this.form)
                .then(response => {
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeam');
                });
        },


        /**
         * Determine if the user has subscribed to the given plan before.
         */
        hasSubscribed(plan) {
            return !!_.filter(this.billable.subscriptions, {provider_plan: plan.id}).length
        },


        /**
         * Show the plan details for the given plan.
         *
         * We'll ask the parent subscription component to display it.
         */
        showPlanDetails(plan) {
            this.$parent.$emit('showPlanDetails', plan);
        },


        /**
         * Determine if the user/team has a payment method defined.
         */
        hasPaymentMethod() {
            return this.team ? this.team.card_last_four : this.user.card_last_four;
        }
    },


    computed: {
        /**
         * Get the billable entity's "billable" name.
         */
        billableName() {
            return this.billingUser ? this.user.name : this.team.owner.name;
        },


        /**
         * Determine if the selected country collects European VAT.
         */
        countryCollectsVat()  {
            return this.collectsVat(this.form.country);
        },


        /**
         * Get the URL for subscribing to a plan.
         */
        urlForNewSubscription() {
            return this.billingUser
                            ? '/settings/subscription'
                            : `/settings/${Spark.teamsPrefix}/${this.team.id}/subscription`;
        },


        /**
         * Get the current billing address from the subscribe form.
         *
         * This used primarily for wathcing.
         */
        currentBillingAddress() {
            return this.form.address +
                   this.form.address_line_2 +
                   this.form.city +
                   this.form.state +
                   this.form.zip +
                   this.form.country +
                   this.form.vat_id;
        }
    }
};
