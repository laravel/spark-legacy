module.exports = {
    /**
     * The component's data.
     */
    data() {
        return {
            plans: [],

            form: new SparkForm({
                name: '',
                slug: ''
            })
        };
    },


    computed: {
        /**
         * Get the active subscription instance.
         */
        activeSubscription() {
            if ( ! this.$parent.billable) {
                return;
            }

            const subscription = _.find(
                this.$parent.billable.subscriptions,
                subscription => subscription.name == 'default'
            );

            if (typeof subscription !== 'undefined') {
                return subscription;
            }
        },


        /**
         * Get the active plan instance.
         */
        activePlan() {
            if (this.activeSubscription) {
                return _.find(this.plans, (plan) => {
                    return plan.id == this.activeSubscription.provider_plan;
                });
            }
        },


        /**
         * Check if there's a limit for the number of teams.
         */
        hasTeamLimit() {
            if (! this.activePlan) {
                return false;
            }

            return !! this.activePlan.attributes.teams;
        },


        /**
         *
         * Get the remaining teams in the active plan.
         */
        remainingTeams() {
            return this.activePlan
                    ? this.activePlan.attributes.teams - this.$parent.teams.length
                    : 0;
        },


        /**
         * Check if the user can create more teams.
         */
        canCreateMoreTeams() {
            if (! this.hasTeamLimit) {
                return true;
            }
            return this.remainingTeams > 0;
        }
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getPlans();
    },


    events: {
        /**
         * Handle the "activatedTab" event.
         */
        activatedTab(tab) {
            if (tab === Spark.pluralTeamString) {
                Vue.nextTick(() => {
                    $('#create-team-name').focus();
                });
            }

            return true;
        }
    },


    watch: {
        /**
         * Watch the team name for changes.
         */
        'form.name': function (val, oldVal) {
            if (this.form.slug == '' ||
                this.form.slug == oldVal.toLowerCase().replace(/[\s\W-]+/g, '-')
            ) {
                this.form.slug = val.toLowerCase().replace(/[\s\W-]+/g, '-');
            }
        }
    },


    methods: {
        /**
         * Create a new team.
         */
        create() {
            Spark.post('/settings/'+Spark.pluralTeamString, this.form)
                .then(() => {
                    this.form.name = '';
                    this.form.slug = '';

                    this.$dispatch('updateUser');
                    this.$dispatch('updateTeams');
                });
        },


        /**
         * Get all the plans defined in the application.
         */
        getPlans() {
            this.$http.get('/spark/plans')
                .then(response => {
                    this.plans = response.data;
                });
        }
    }
};
