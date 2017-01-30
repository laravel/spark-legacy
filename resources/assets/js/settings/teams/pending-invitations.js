module.exports = {
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
        this.getPendingInvitations();
    },


    methods: {
        /**
         * Get the pending invitations for the user.
         */
        getPendingInvitations() {
            axios.get('/settings/invitations/pending')
                .then(response => {
                    this.invitations = response.data;
                });
        },


        /**
         * Accept the given invitation.
         */
        accept(invitation) {
            axios.post(`/settings/invitations/${invitation.id}/accept`)
                .then(() => {
                    Bus.$emit('updateTeams');

                    this.getPendingInvitations();
                });

            this.removeInvitation(invitation);
        },


        /**
         * Reject the given invitation.
         */
        reject(invitation) {
            axios.post(`/settings/invitations/${invitation.id}/reject`)
                .then(() => {
                    this.getPendingInvitations();
                });

            this.removeInvitation(invitation);
        },


        /**
         * Remove the given invitation from the list.
         */
        removeInvitation(invitation) {
            this.invitations = _.reject(this.invitations, i => i.id === invitation.id);
        }
    }
};
