module.exports = {
    props: ['tokens', 'availableAbilities'],


    /**
     * The component's data.
     */
    data() {
        return {
            updatingToken: null,
            deletingToken: null,

            updateTokenForm: new SparkForm({
                name: '',
                abilities: []
            }),

            deleteTokenForm: new SparkForm({})
        }
    },


    methods: {
        /**
         * Show the edit token modal.
         */
        editToken(token) {
            this.updatingToken = token;

            this.initializeUpdateFormWith(token);

            $('#modal-update-token').modal('show');
        },


        /**
         * Initialize the edit form with the given token.
         */
        initializeUpdateFormWith(token) {
            this.updateTokenForm.name = token.name;

            this.updateTokenForm.abilities = token.metadata.abilities;
        },


        /**
         * Update the token being edited.
         */
        updateToken() {
            Spark.put(`/settings/api/token/${this.updatingToken.id}`, this.updateTokenForm)
                .then(response => {
                    this.$parent.$emit('updateTokens');

                    $('#modal-update-token').modal('hide');
                })
        },


        /**
         * Toggle the ability on the current token being edited.
         */
        toggleAbility(ability) {
            if (this.abilityIsAssigned(ability)) {
                this.updateTokenForm.abilities = _.reject(
                    this.updateTokenForm.abilities, a => a == ability
                );
            } else {
                this.updateTokenForm.abilities.push(ability);
            }
        },


        /**
         * Determine if the ability has been assigned to the token being edited.
         */
        abilityIsAssigned(ability) {
            return _.contains(this.updateTokenForm.abilities, ability);
        },


        /**
         * Get user confirmation that the token should be deleted.
         */
        approveTokenDelete(token) {
            this.deletingToken = token;

            $('#modal-delete-token').modal('show');
        },


        /**
         * Delete the specified token.
         */
        deleteToken() {
            Spark.delete(`/settings/api/token/${this.deletingToken.id}`, this.deleteTokenForm)
                .then(() => {
                    this.$parent.$emit('updateTokens');

                    $('#modal-delete-token').modal('hide');
                });
        }
    }
};
