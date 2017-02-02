module.exports = {
    props: ['team', 'invitations'],


    methods: {
        /**
         * Cancel the sent invitation.
         */
        cancel(invitation) {
            axios.delete(`/settings/invitations/${invitation.id}`)
                .then(() => {
                    this.$parent.$emit('updateInvitations');
                });
        }
    }
};
