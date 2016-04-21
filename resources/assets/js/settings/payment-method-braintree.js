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
     * Prepare the component.
     */
    ready() {
        this.getCurrentDiscountForBillable(this.billableType, this.billable);
    },


    events: {
        /**
         * Update the discount for the current entity.
         */
        updateDiscount() {
            this.getCurrentDiscountForBillable(this.billableType, this.billable);

            return true;
        }
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
