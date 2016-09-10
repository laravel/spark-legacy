module.exports = {
    props: ['tokens', 'scopes'],


    /**
     * The component's data.
     */
    data() {
        return {
            revokingToken: null,

            revokeTokenForm: new SparkForm({})
        }
    },


    methods: {

        /**
         * Get user confirmation that the token should be revoked.
         */
        approveTokenRevoke(token) {
            this.revokingToken = token;

            $('#modal-revoke-token').modal('show');
        },


        /**
         * Delete the specified token.
         */
        revokeToken() {
            Spark.delete(`/oauth/personal-access-tokens/${this.revokingToken.id}`, this.revokeTokenForm)
                .then(() => {
                    this.$dispatch('updateTokens');

                    $('#modal-revoke-token').modal('hide');
                });
        }
    }
};
