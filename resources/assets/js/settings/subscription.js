module.exports = {
    props: ['user', 'team', 'billableType'],

    /**
     * Load mixins for the component.
     */
    mixins: [
        require('./../mixins/plans'),
        require('./../mixins/subscriptions')
    ],


    /**
     * The component's data.
     */
    data() {
        return {
            plans: []
        };
    },


    /**
     * Prepare the component.
     */
    ready() {
        this.getPlans();
    },


    events: {
        /**
         * Show the details for the given plan.
         */
        showPlanDetails(plan) {
            this.showPlanDetails(plan);
        }
    },


    methods: {
        /**
         * Get the active plans for the application.
         */
        getPlans() {
            this.$http.get('/spark/plans')
                .then(response => {
                    this.plans = this.billingUser
                                    ? _.where(response.data, {type: "user"})
                                    : _.where(response.data, {type: "team"});
                });
        }
    }
};
