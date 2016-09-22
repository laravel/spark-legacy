module.exports = {
    props: ['user', 'team', 'plans', 'billableType'],

    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../../mixins/plans'),
        require('./../../mixins/subscriptions'),
        require('./../../mixins/vat')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            taxRate: 0,

            form: new SparkForm({
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
                name: '',
                number: '',
                cvc: '',
                month: '',
                year: '',
                zip: ''
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
    ready() {
        Stripe.setPublishableKey(Spark.stripeKey);

        this.initializeBillingAddress();

         // If only yearly subscription plans are available, we will select that interval so that we
         // can show the plans. Then we'll select the first available paid plan from the list and
         // start the form in a good default spot. The user may then select another plan later.
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

             // Here we will build out the payload to send to Stripe to obtain a card token so
             // we can create the actual subscription. We will build out this data that has
             // this credit card number, CVC, etc. and exchange it for a secure token ID.
            const payload = {
                name: this.cardForm.name,
                number: this.cardForm.number,
                cvc: this.cardForm.cvc,
                exp_month: this.cardForm.month,
                exp_year: this.cardForm.year,
                address_line1: this.form.address,
                address_line2: this.form.address_line_2,
                address_city: this.form.city,
                address_state: this.form.state,
                address_zip: this.form.zip,
                address_country: this.form.country
            };

             // Next, we will send the payload to Stripe and handle the response. If we have a
             // valid token we can send that to the server and use the token to create this
             // subscription on the back-end. Otherwise, we will show the error messages.
            Stripe.card.createToken(payload, (status, response) => {
                if (response.error) {
                    this.cardForm.errors.set({number: [
                        response.error.message
                    ]})

                    this.form.busy = false;
                } else {
                    this.createSubscription(response.id);
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
                            : `/settings/${Spark.pluralTeamString}/${this.team.id}/subscription`;
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
