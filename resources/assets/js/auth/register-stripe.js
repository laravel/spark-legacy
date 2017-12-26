module.exports = {
    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../mixins/register'),
        require('./../mixins/plans'),
        require('./../mixins/vat'),
        require('./../mixins/stripe')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            query: null,

            cardElement: null,

            coupon: null,
            invalidCoupon: false,

            country: null,
            taxRate: 0,

            registerForm: $.extend(true, new SparkForm({
                stripe_token: '',
                plan: '',
                team: '',
                team_slug: '',
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                address: '',
                address_line_2: '',
                city: '',
                state: '',
                zip: '',
                country: 'US',
                vat_id: '',
                terms: false,
                coupon: null,
                invitation: null
            }), Spark.forms.register),

            cardForm: new SparkForm({
                name: '',
                number: '',
                cvc: '',
                month: '',
                year: '',
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

            this.refreshTaxRate(this.registerForm);
        },


        /**
         * Watch the team name for changes.
         */
        'registerForm.team': function (val, oldVal) {
            if (this.registerForm.team_slug == '' ||
                this.registerForm.team_slug == oldVal.toLowerCase().replace(/[\s\W-]+/g, '-')
            ) {
                this.registerForm.team_slug = val.toLowerCase().replace(/[\s\W-]+/g, '-');
            }
        },


        /**
         * Watch for changes on the selected plan.
         */
        selectedPlan(val){
            if (!val || val.price == 0) {
                this.cardElement = null;
                return;
            }

            if (!this.cardElement) {
                this.$nextTick(()=> {
                    this.cardElement = this.createCardElement('#card-element');
                });
            }
        }
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getPlans();

        this.guessCountry();

        this.query = URI(document.URL).query(true);

        if (this.query.coupon) {
            this.getCoupon();

            this.registerForm.coupon = this.query.coupon;
        }

        if (this.query.invitation) {
            this.getInvitation();

            this.registerForm.invitation = this.query.invitation;
        }
    },


    methods: {
        /**
         * Attempt to guess the user's country.
         */
        guessCountry() {
            axios.get('/geocode/country')
                .then(response => {
                    if (response.data != 'ZZ') {
                        this.registerForm.country = response.data;
                    }
                })
                .catch (response => {
                    //
                });
        },


        /**
         * Get the coupon specified in the query string.
         */
        getCoupon() {
            axios.get('/coupon/' + this.query.coupon)
                .then(response => {
                    this.coupon = response.data;
                })
                .catch(response => {
                    this.invalidCoupon = true;
                });
        },


        /**
         * Attempt to register with the application.
         */
        register() {
            this.cardForm.errors.forget();

            this.registerForm.busy = true;
            this.registerForm.errors.forget();

            if ( ! Spark.cardUpFront || this.selectedPlan.price == 0) {
                return this.sendRegistration();
            }

            // Here we will build out the payload to send to Stripe to obtain a card token so
            // we can create the actual subscription. We will build out this data that has
            // this credit card number, CVC, etc. and exchange it for a secure token ID.
            const payload = {
                name: this.cardForm.name,
                address_line1: this.registerForm.address || '',
                address_line2: this.registerForm.address_line_2 || '',
                address_city: this.registerForm.city || '',
                address_state: this.registerForm.state || '',
                address_zip: this.registerForm.zip || '',
                address_country: this.registerForm.country || '',
            };

            this.stripe.createToken(this.cardElement, payload).then(response => {
                if (response.error) {
                    this.cardForm.errors.set({card: [
                        response.error.message
                    ]});

                    this.registerForm.busy = false;
                } else {
                    this.registerForm.stripe_token = response.token.id;

                    this.sendRegistration();
                }
            });
        },

        /*
         * After obtaining the Stripe token, send the registration to Spark.
         */
        sendRegistration() {
            Spark.post('/register', this.registerForm)
                .then(response => {
                    window.location = response.redirect;
                });
        }
    },


    computed: {
        /**
         * Determine if the selected country collects European VAT.
         */
        countryCollectsVat()  {
            return this.collectsVat(this.registerForm.country);
        },


        /**
         * Get the displayable discount for the coupon.
         */
        discount() {
            if (this.coupon) {
                if (this.coupon.percent_off) {
                    return this.coupon.percent_off + '%';
                } else {
                    return Vue.filter('currency')(this.coupon.amount_off / 100);
                }
            }
        },


        /**
         * Get the current billing address from the register form.
         *
         * This used primarily for wathcing.
         */
        currentBillingAddress() {
            return this.registerForm.address +
                   this.registerForm.address_line_2 +
                   this.registerForm.city +
                   this.registerForm.state +
                   this.registerForm.zip +
                   this.registerForm.country +
                   this.registerForm.vat_id;
        }
    }
};
