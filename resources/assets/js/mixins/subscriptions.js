/*
 * This mixin is used by most of the subscription related screens to select plans
 * and send subscription plan changes to the server. This contains helpers for
 * the active subscription, trial information and other convenience helpers.
 */
module.exports = {
    /**
     * The mixin's data.
     */
    data() {
        return {
            selectingPlan: null,

            planForm: new SparkForm({})
        }
    },


    methods: {
        /**
         * Update the subscription to the given plan.
         *
         * Used when updating or resuming the subscription plan.
         */
        updateSubscription(plan) {
            this.selectingPlan = plan;

            this.planForm.errors.forget();

             // Here we will send the request to the server to update the subscription plan and
             // update the user and team once the request is complete. This method gets used
             // for both updating subscriptions plus resuming any cancelled subscriptions.
            axios.put(this.urlForPlanUpdate, {"plan": plan.id})
                .then(() => {
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeam');
                })
                .catch(response => {
                    this.planForm.errors.set({plan: ["We were unable to update your subscription. Please contact customer support."]});
                })
                .finally(() => {
                    this.selectingPlan = null;
                });
        },


        /**
         * Determine if the given plan is selected.
         */
        isActivePlan(plan) {
            return this.activeSubscription &&
                   this.activeSubscription.provider_plan == plan.id;
        }
    },


    computed: {
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
         * Determine if the active plan is a monthly plan.
         */
        activePlanIsMonthly() {
            return this.activePlan && this.activePlan.interval == 'monthly';
        },


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
         * Determine if the current subscription is active.
         */
        subscriptionIsActive() {
            return this.activeSubscription && ! this.activeSubscription.ends_at;
        },


        /**
         * Determine if the billable entity is on a generic trial.
         */
        onGenericTrial() {
            return this.billable.trial_ends_at &&
                   moment.utc(this.billable.trial_ends_at).isAfter(moment.utc());
        },


        /**
         * Determine if the current subscription is active.
         */
        subscriptionIsOnTrial() {
            if (this.onGenericTrial) {
                return true;
            }

            return this.activeSubscription &&
                   this.activeSubscription.trial_ends_at &&
                   moment.utc().isBefore(moment.utc(this.activeSubscription.trial_ends_at));
        },


        /**
         * Get the formatted trial ending date.
         */
        trialEndsAt() {
            if ( ! this.subscriptionIsOnTrial) {
                return;
            }

            if (this.onGenericTrial) {
                return moment.utc(this.billable.trial_ends_at)
                                        .local().format('MMMM Do, YYYY');
            }

            return moment.utc(this.activeSubscription.trial_ends_at)
                            .local().format('MMMM Do, YYYY');
        },


        /**
         * Determine if the current subscription is active.
         */
        subscriptionIsOnGracePeriod() {
            return this.activeSubscription &&
                   this.activeSubscription.ends_at &&
                   moment.utc().isBefore(moment.utc(this.activeSubscription.ends_at));
        },


        /**
         * Determine if the billable entity has no active subscription.
         */
        needsSubscription() {
            return ! this.activeSubscription ||
                    (this.activeSubscription.ends_at &&
                     moment.utc().isAfter(moment.utc(this.activeSubscription.ends_at)));
        },


        /**
         * Get the URL for the subscription plan update.
         */
        urlForPlanUpdate() {
            return this.billingUser
                            ? '/settings/subscription'
                            : `/settings/${Spark.pluralTeamString}/${this.team.id}/subscription`;
        }
    }
};
