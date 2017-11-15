module.exports = {
    /**
     * The mixin's data.
     */
    data() {
        return {
            plans: [],
            selectedPlan: null,

            invitation: null,
            invalidInvitation: false
        };
    },


    methods: {
        /**
         * Get the active plans for the application.
         */
        getPlans() {
            if ( ! Spark.cardUpFront) {
                return;
            }

            axios.get('/spark/plans')
                .then(response => {
                    var plans = response.data;

                    this.plans = _.filter(plans, {type: "user"}).length > 0
                                    ? _.filter(plans, {type: "user"})
                                    : _.filter(plans, {type: "team"});

                    this.selectAppropriateDefaultPlan();
                });
        },


        /**
         * Get the invitation specified in the query string.
         */
        getInvitation() {
            axios.get(`/invitations/${this.query.invitation}`)
                .then(response => {
                    this.invitation = response.data;
                })
                .catch(response => {
                    this.invalidInvitation = true;
                });
        },


        /**
         * Select the appropriate default plan for registration.
         */
        selectAppropriateDefaultPlan() {
            if (this.query.plan) {
                this.selectPlanById(this.query.plan) || this.selectPlanByName(this.query.plan);
            } else if (this.query.invitation) {
                this.selectFreePlan();
            } else if (this.paidPlansForActiveInterval.length > 0) {
                this.selectPlan(this.paidPlansForActiveInterval[0]);
            } else {
                this.selectFreePlan();
            }

            if (this.shouldShowYearlyPlans()) {
                this.showYearlyPlans();
            }
        },


        /**
         * Select the free plan.
         */
        selectFreePlan() {
            const plan = _.find(this.plans, plan => plan.price === 0);

            if (typeof plan !== 'undefined') {
                this.selectPlan(plan);
            }
        },


        /**
         * Select the plan with the given id.
         */
        selectPlanById(id) {
            _.each(this.plans, plan => {
                if (plan.id == id) {
                    this.selectPlan(plan);
                }
            });

            return this.selectedPlan;
        },


        /**
         * Select the plan with the given name.
         */
        selectPlanByName(name) {
            _.each(this.plans, plan => {
                if (plan.name == name) {
                    this.selectPlan(plan);
                }
            });

            return this.selectedPlan;
        },


        /**
         * Determine if the given plan is selected.
         */
        isSelected(plan) {
            return this.selectedPlan && plan.id == this.selectedPlan.id;
        },


        /**
         * Select the given plan.
         */
        selectPlan(plan) {
            this.selectedPlan = plan;

            this.registerForm.plan = plan.id;
        },


        /**
         * Determine if we should show the yearly plans.
         */
        shouldShowYearlyPlans(){
            return (this.monthlyPlans.length == 0 && this.yearlyPlans.length > 0) ||
                this.selectedPlan.interval == 'yearly'
        }
    }
};
