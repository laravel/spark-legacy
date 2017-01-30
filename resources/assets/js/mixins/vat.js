module.exports = {
    methods: {
        /**
         * Determine if the given country collects European VAT.
         */
        collectsVat(country) {
            return Spark.collectsEuropeanVat ? _.contains([
                'BE', 'BG', 'CZ', 'DK', 'DE',
                'EE', 'IE', 'GR', 'ES', 'FR',
                'HR', 'IT', 'CY', 'LV', 'LT',
                'LU', 'HU', 'MT', 'NL', 'AT',
                'PL', 'PT', 'RO', 'SI', 'SK',
                'FI', 'SE', 'GB',
            ], country) : false;
        },


        /**
         * Refresh the tax rate using the given form input.
         */
        refreshTaxRate(form) {
            axios.post('/tax-rate', JSON.stringify(form))
                .then(response => {
                    this.taxRate = response.data.rate;
                });
        },


        /**
         * Get the tax amount for the selected plan.
         */
        taxAmount(plan) {
            return plan.price * (this.taxRate / 100);
        },


        /**
         * Get the total plan price including the applicable tax.
         */
        priceWithTax(plan) {
            return plan.price + this.taxAmount(plan);
        }
    }
};
