module.exports = {
    props: ['user', 'team', 'billableType'],


    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../mixins/discounts')
    ],


    /**
     * The componetn's data.
     */
    data() {
        return {
            currentDiscount: null,
            loadingCurrentDiscount: false
        };
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        this.$on('updateDiscount', function(){
            self.getCurrentDiscountForBillable(self.billableType, self.billable);

            return true;
        })
    },


    /**
     * Prepare the component.
     */
    mounted() {
        this.getCurrentDiscountForBillable(this.billableType, this.billable);
    },


    methods: {
        /**
         * Calculate the amount off for the given discount amount.
         */
        calculateAmountOff(amount) {
            return amount;
        },


        /**
         * Get the formatted discount duration for the given discount.
         */
        formattedDiscountDuration(discount) {
            if ( ! discount) {
                return;
            }

            switch (discount.duration) {
                case 'forever':
                    return 'for all future invoices';
                case 'once':
                    return 'a single invoice';
                case 'repeating':
                    if (discount.duration_in_months === 1) {
                        return 'all invoices during the next billing cycle';
                    } else {
                        return `all invoices during the next ${discount.duration_in_months} billing cycles`;
                    }
            }
        }
    }
};
