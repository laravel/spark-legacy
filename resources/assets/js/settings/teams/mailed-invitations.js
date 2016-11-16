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
        }
    }
};
