/*
 * This mixin is primarily used to share code for the "interval" selector
 * on the registration and subscription screens, which is used to show
 * all of the various subscription plans offered by the application.
 */
module.exports = {
    data() {
        return {
            selectedPlan: null,
            detailingPlan: null,

            showingMonthlyPlans: true,
            showingYearlyPlans: false
        };
    },


    methods: {
        /**
         * Switch to showing monthly plans.
         */
        showMonthlyPlans() {
            this.showingMonthlyPlans = true;

            this.showingYearlyPlans = false;
        },


        /**
         * Switch to showing yearly plans.
         */
        showYearlyPlans() {
            this.showingMonthlyPlans = false;

            this.showingYearlyPlans = true;
        },


        /**
         * Show the plan details for the given plan.
         */
        showPlanDetails(plan) {
            this.detailingPlan = plan;

            $('#modal-plan-details').modal('show');
        }
    },


    computed: {
        /**
         * Get the active "interval" being displayed.
         */
        activeInterval() {
            return this.showingMonthlyPlans ? 'monthly' : 'yearly';
        },


        /**
         * Get all of the plans for the active interval.
         */
        plansForActiveInterval() {
            return _.filter(this.plans, plan => {
                return plan.active && (plan.price == 0 || plan.interval == this.activeInterval);
            });
        },


        /**
         * Get all of the paid plans.
         */
        paidPlans() {
            return _.filter(this.plans, plan => {
                return plan.active && plan.price > 0;
            });
        },


        /**
         * Get all of the paid plans for the active interval.
         */
        paidPlansForActiveInterval() {
            return _.filter(this.plansForActiveInterval, plan => {
                return plan.active && plan.price > 0;
            });
        },


        /**
         * Determine if both monthly and yearly plans are available.
         */
        hasMonthlyAndYearlyPlans() {
            return this.monthlyPlans.length > 0 && this.yearlyPlans.length > 0;
        },

        /**
         * Determine if both monthly and yearly plans are available.
         */
        hasMonthlyAndYearlyPaidPlans() {
            return _.where(this.paidPlans, {interval: 'monthly'}).length > 0 &&
                   _.where(this.paidPlans, {interval: 'yearly'}).length > 0;
        },


        /**
         * Determine if only yearly plans are available.
         */
        onlyHasYearlyPlans() {
            return this.monthlyPlans.length == 0 && this.yearlyPlans.length > 0;
        },

        /**
         * Determine if both monthly and yearly plans are available.
         */
        onlyHasYearlyPaidPlans() {
            return _.where(this.paidPlans, {interval: 'monthly'}).length == 0 &&
                   _.where(this.paidPlans, {interval: 'yearly'}).length > 0;
        },


        /**
         * Get all of the monthly plans.
         */
        monthlyPlans() {
            return _.filter(this.plans, plan => {
                return plan.active && plan.interval == 'monthly';
            });
        },


        /**
         * Get all of the yearly plans.
         */
        yearlyPlans() {
            return _.filter(this.plans, plan => {
                return plan.active && plan.interval == 'yearly';
            });
        }
    }
};
