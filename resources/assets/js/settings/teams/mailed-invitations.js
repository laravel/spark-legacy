module.exports = {
    props: ['team', 'invitations'],


    methods: {
        /**
         * Cancel the sent invitation.
         */
        cancel(invitation) {
            this.$http.delete(`/settings/invitations/${invitation.id}`)
                .then(function() {
                    this.$parent.$emit('updateInvitations');
                });

            this.invitations = _.reject(
                this.invitations, i => i.id === invitation.id
            );
        }
    }
};
