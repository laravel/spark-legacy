module.exports = {
    props: ['user', 'team'],

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
        this.getInvitations();
    },


    events: {
        /**
         * Update the team's invitations.
         */
        updateInvitations() {
            this.getInvitations();
        }
    },


    methods: {
        /**
         * Get all of the invitations for the team.
         */
        getInvitations() {
            this.$http.get(`/settings/${Spark.pluralTeamString}/${this.team.id}/invitations`)
                .then(response => {
                    this.invitations = response.data;
                });
        }
    }
};
