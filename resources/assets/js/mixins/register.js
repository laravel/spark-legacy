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

            this.$http.get('/spark/plans')
                .then(function(response) {
                    var plans = response.data;

                    this.plans = _.where(plans, {type: "user"}).length > 0
                                    ? _.where(plans, {type: "user"})
                                    : _.where(plans, {type: "team"});

                    this.selectAppropriateDefaultPlan();
                });
        },


        /**
         * Get the invitation specified in the query string.
         */
        getInvitation() {
            this.$http.get(`/invitations/${this.query.invitation}`)
                .then(function(response) {
                    this.invitation = response.data;
                })
                .catch(function(response) {
                    this.invalidInvitation = true;
                });
        },


        /**
         * Select the appropriate default plan for registration.
         */
        selectAppropriateDefaultPlan() {
            if (this.monthlyPlans.length == 0 && this.yearlyPlans.length > 0) {
                this.showYearlyPlans();
            }

            if (this.query.plan) {
                this.selectPlanByName(this.query.plan);
            } else if (this.query.invitation) {
                this.selectFreePlan();
            } else if (this.paidPlansForActiveInterval.length > 0) {
                this.selectPlan(this.paidPlansForActiveInterval[0]);
            } else {
                this.selectFreePlan();
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
         * Select the plan with the given name.
         */
        selectPlanByName(name) {
            _.each(this.plans, plan => {
                if (plan.name == name) {
                    this.selectPlan(plan);
                }
            });
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
    }
};
