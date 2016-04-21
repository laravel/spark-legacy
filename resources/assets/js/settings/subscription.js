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
            this.$http.get(this.urlForPlans)
                .then(response => {
                    this.plans = response.data;
                });
        }
    },


    computed: {
        /**
         * Get the URL for retrieving the application's plans.
         */
        urlForPlans() {
            return this.billingUser ? '/spark/plans' : '/spark/team-plans';
        }
    }
};
