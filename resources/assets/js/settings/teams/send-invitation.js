module.exports = {
    props: ['user', 'team', 'billableType', 'defaultRole'],

    /**
     * The component's data.
     */
    data() {
        return {
            plans: [],

            roles: [],

            form: new SparkForm({
                email: '',
                role: this.defaultRole
            })
        };
    },


    computed: {
        /**
         * Get the active subscription instance.
         */
        activeSubscription() {
            if ( ! this.billable) {
                return;
            }

            const subscription = _.find(
                this.billable.subscriptions,
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
         * Check if there's a limit for the number of team members.
         */
        hasTeamMembersLimit() {
            if (! this.activePlan) {
                return false;
            }

            return !! this.activePlan.attributes.teamMembers;
        },


        /**
         *
         * Get the remaining team members in the active plan.
         */
        remainingTeamMembers() {
            return this.activePlan
                    ? this.activePlan.attributes.teamMembers - this.$parent.team.users.length
                    : 0;
        },


        /**
         * Check if the user can invite more team members.
         */
        canInviteMoreTeamMembers() {
            if (! this.hasTeamMembersLimit) {
                return true;
            }
            return this.remainingTeamMembers > 0;
        }
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getPlans();

        this.getRoles();
    },


    methods: {
        /**
         * Send a team invitation.
         */
        send() {
            Spark.post(`/settings/${Spark.teamsPrefix}/${this.team.id}/invitations`, this.form)
                .then(() => {
                    this.form.email = '';
                    this.role.email = Spark.defaultRole;

                    this.$parent.$emit('updateInvitations');
                });
        },

        /**
         * Get all the plans defined in the application.
         */
        getPlans() {
            axios.get('/spark/plans')
                .then(response => {
                    this.plans = response.data;
                });
        },

        /**
         * Get the available member roles.
         */
        getRoles() {
            axios.get(`/settings/${Spark.teamsPrefix}/roles`)
                .then(response => {
                    this.roles = response.data;
                });
        }
    }
};
