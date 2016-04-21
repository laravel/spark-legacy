module.exports = {
    props: ['user', 'team'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({
                email: ''
            })
        };
    },


    methods: {
        /**
         * Send a team invitation.
         */
        send() {
            Spark.post(`/settings/teams/${this.team.id}/invitations`, this.form)
                .then(() => {
                    this.form.email = '';

                    this.$dispatch('updateInvitations');
                });
        }
    }
};
