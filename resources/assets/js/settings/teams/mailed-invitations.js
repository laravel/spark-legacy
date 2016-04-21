module.exports = {
    props: ['team', 'invitations'],


    methods: {
        /**
         * Cancel the sent invitation.
         */
        cancel(invitation) {
            this.$http.delete(`/settings/invitations/${invitation.id}`)
                .then(function() {
                    this.$dispatch('updateInvitations');
                });

            this.invitations = _.reject(
                this.invitations, i => i.id === invitation.id
            );
        }
    }
};
