module.exports = {
    props: ['user', 'team', 'plans', 'billableType'],

    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../../mixins/plans'),
        require('./../../mixins/subscriptions')
    ],


    /**
     * Prepare the component.
     */
    ready() {
        if (this.onlyHasYearlyPlans) {
            this.showYearlyPlans();
        }
    },


    methods: {
        /**
         * Show the plan details for the given plan.
         *
         * We'll ask the parent subscription component to display it.
         */
        showPlanDetails(plan) {
            this.$dispatch('showPlanDetails', plan);
        },


        /**
         * Get the plan price with the applicable VAT.
         */
        priceWithTax(plan) {
            return plan.price + (plan.price * (this.billable.tax_rate / 100));
        }
    }
};
