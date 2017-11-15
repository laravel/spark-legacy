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
    mounted() {
        var self = this;

        this.getPlans();

        this.$on('showPlanDetails', function (plan) {
            self.showPlanDetails(plan);
        });
    },


    methods: {
        /**
         * Get the active plans for the application.
         */
        getPlans() {
            axios.get('/spark/plans')
                .then(response => {
                    this.plans = this.billingUser
                                    ? _.filter(response.data, {type: "user"})
                                    : _.filter(response.data, {type: "team"});
                });
        }
    }
};
