module.exports = {
    props: ['user', 'team', 'billableType'],

    /**
     * The component's data.
     */
    data() {
        return {
            invitations: []
        };
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        this.getInvitations();

        this.$on('updateInvitations', function () {
            self.getInvitations();
        });
    },


    methods: {
        /**
         * Get all of the invitations for the team.
         */
        getInvitations() {
            axios.get(`/settings/${Spark.teamsPrefix}/${this.team.id}/invitations`)
                .then(response => {
                    this.invitations = response.data;
                });
        }
    }
};
