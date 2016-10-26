module.exports = {
    props: ['user', 'team', 'billableType'],


    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../../mixins/braintree')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({
                braintree_type: '',
                braintree_token: '',
            })
        };
    },


    /**
     * Prepare the component.
     */
    mounted() {
        this.braintree(
            'braintree-payment-method-container',
            this.braintreeCallback
        );
    },


    methods: {
        /**
         * Update the entity's card information.
         */
        update() {
            Spark.put(this.urlForUpdate, this.form)
                .then(() => {
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeam');

                    this.resetBraintree(
                        'braintree-payment-method-container',
                        this.braintreeCallback
                    );
                });
        },


        /**
         * The Braintree payment method received callback.
         */
        braintreeCallback(response) {
            this.form.braintree_type = response.type;
            this.form.braintree_token = response.nonce;

            this.update();
        }
    },


    computed: {
        /**
         * Get the URL for the payment method update.
         */
        urlForUpdate() {
            return this.billingUser
                            ? '/settings/payment-method'
                            : `/settings/${Spark.pluralTeamString}/${this.team.id}/payment-method`;
        },


        /**
         * Get the proper brand icon for the customer's credit card.
         */
        cardIcon() {
            if (! this.billable.card_brand) {
                return 'fa-credit-card';
            }

            switch (this.billable.card_brand) {
                case 'American Express':
                    return 'fa-cc-amex';
                case 'Diners Club':
                    return 'fa-cc-diners-club';
                case 'Discover':
                    return 'fa-cc-discover';
                case 'JCB':
                    return 'fa-cc-jcb';
                case 'MasterCard':
                    return 'fa-cc-mastercard';
                case 'Visa':
                    return 'fa-cc-visa';
                default:
                    return 'fa-credit-card';
            }
        }
    }
};
