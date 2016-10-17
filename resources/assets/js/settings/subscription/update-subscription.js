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
     * The component's data.
     */
    data() {
        return {
            confirmingPlan: null
        };
    },


    /**
     * Prepare the component.
     */
    mounted() {
        this.selectActivePlanInterval();

         // We need to watch the activePlan computed property for changes so we can select
         // the proper active plan on the plan interval button group. So, we will watch
         // this property and fire off a method anytime it changes so it can sync up.
        this.$watch('activePlan', value => {
            this.selectActivePlanInterval();
        });

        if (this.onlyHasYearlyPlans) {
            this.showYearlyPlans();
        }
    },


    methods: {
        /**
         * Confirm the plan update with the user.
         */
        confirmPlanUpdate(plan) {
            this.confirmingPlan = plan;

            $('#modal-confirm-plan-update').modal('show');
        },


        /**
         * Approve the plan update.
         */
        approvePlanUpdate() {
            $('#modal-confirm-plan-update').modal('hide');

            this.updateSubscription(this.confirmingPlan);
        },


        /**
         * Select the active plan interval.
         */
        selectActivePlanInterval() {
            if (this.activePlanIsMonthly || this.yearlyPlans.length == 0) {
                this.showMonthlyPlans();
            } else {
                this.showYearlyPlans();
            }
        },


        /**
         * Show the plan details for the given plan.
         *
         * We'll ask the parent subscription component to display it.
         */
        showPlanDetails(plan) {
            this.$parent.$emit('showPlanDetails', plan);
        },


        /**
         * Get the plan price with the applicable VAT.
         */
        priceWithTax(plan) {
            return plan.price + (plan.price * (this.billable.tax_rate / 100));
        }
    }
};
