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
         * Update the discount for the current user.
         */
        updateDiscount() {
            this.getCurrentDiscountForBillable(this.billableType, this.billable);

            return true;
        }
    }
};
