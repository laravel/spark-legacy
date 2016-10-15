module.exports = {
    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../mixins/braintree'),
        require('./../mixins/plans'),
        require('./../mixins/register')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            query: null,

            coupon: null,
            invalidCoupon: false,

            registerForm: $.extend(true, new SparkForm({
                braintree_type: '',
                braintree_token: '',
                plan: '',
                team: '',
                team_slug: '',
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
                coupon: null,
                invitation: null
            }), Spark.forms.register)
        };
    },


    watch: {
        /**
         * Watch the team name for changes.
         */
        'registerForm.team': function (val, oldVal) {
            if (this.registerForm.team_slug == '' ||
                this.registerForm.team_slug == oldVal.toLowerCase().replace(/[\s\W-]+/g, '-')
            ) {
                this.registerForm.team_slug = val.toLowerCase().replace(/[\s\W-]+/g, '-');
            }
        }
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getPlans();

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


    /**
     * Prepare the component.
     */
    ready() {
        this.configureBraintree();
    },


    methods: {
        configureBraintree() {
            if ( ! Spark.cardUpFront) {
                return;
            }

            this.braintree('braintree-container', response => {
                this.registerForm.braintree_type = response.type;
                this.registerForm.braintree_token = response.nonce;

                this.register();
            });
        },


        /**
         * Get the coupon specified in the query string.
         */
        getCoupon() {
            this.$http.get('/coupon/' + this.query.coupon)
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
            Spark.post('/register', this.registerForm)
                .then(response => {
                    window.location = response.redirect;
                });
        }
    },


    computed: {
        /**
         * Get the displayable discount for the coupon.
         */
        discount() {
            if (this.coupon) {
                return Vue.filter('currency')(this.coupon.amount_off, Spark.currencySymbol);
            }
        }
    }
};
