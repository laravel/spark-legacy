window.braintreeCheckout = [];

module.exports = {
    methods: {
        /**
         * Configure the Braintree container.
         */
        braintree(containerName, callback) {
            braintree.setup(Spark.braintreeToken, 'dropin', {
                container: containerName,
                paypal: {
                    singleUse: false,
                    locale: 'en_us',
                    enableShippingAddress: false
                },
                dataCollector: {
                    paypal: true
                },
                onReady(checkout) {
                    window.braintreeCheckout[containerName] = checkout;
                },
                onPaymentMethodReceived: callback
            });
        },


        /**
         * Reset the Braintree container.
         */
        resetBraintree(containerName, callback) {
            window.braintreeCheckout[containerName].teardown(() => {
                window.braintreeCheckout[containerName] = null;

                this.braintree(containerName, callback);
            });
        }
    }
};
