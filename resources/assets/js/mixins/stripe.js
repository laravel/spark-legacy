module.exports = {
    /**
     * The mixin's data.
     */
    data() {
        return {
            stripe: Stripe(Spark.stripeKey)
        }
    },


    methods: {
        /**
         * Create a Stripe Card Element.
         */
        createCardElement(container){
            var card = this.stripe.elements().create('card', {
                hideIcon: true,
                hidePostalCode: true,
                style: {
                    base: {
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    }
                }
            });

            card.mount(container);

            return card;
        }
    },
};
