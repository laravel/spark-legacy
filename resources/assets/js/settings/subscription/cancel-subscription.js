module.exports = {
    props: ['user', 'team', 'billableType'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({})
        };
    },


    methods: {
        /**
         * Confirm the cancellation operation.
         */
        confirmCancellation() {
            $('#modal-confirm-cancellation').modal('show');
        },


        /**
         * Cancel the current subscription.
         */
        cancel() {
            Spark.delete(this.urlForCancellation, this.form)
                .then(() => {
                    this.$dispatch('updateUser');
                    this.$dispatch('updateTeam');

                    $('#modal-confirm-cancellation').modal('hide');
                });
        }
    },


    computed: {
        /**
         * Get the URL for the subscription cancellation.
         */
        urlForCancellation() {
            return this.billingUser
                            ? '/settings/subscription'
                            : `/settings/${Spark.pluralTeamString}/${this.team.id}/subscription`;
        }
    }
};
