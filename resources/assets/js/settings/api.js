module.exports = {
    /**
     * The component's data.
     */
    data() {
        return {
            tokens: [],
            availableAbilities: []
        };
    },


    /**
     * Prepare the component.
     */
    ready() {
        this.getTokens();
        this.getAvailableAbilities();
    },


    events: {
        /**
         * Broadcast that child components should update their tokens.
         */
        updateTokens() {
            this.getTokens();
        }
    },


    methods: {
        /**
         * Get the current API tokens for the user.
         */
        getTokens() {
            this.$http.get('/settings/api/tokens')
                    .then(function(response) {
                        this.tokens = response.data;
                    });
        },


        /**
         * Get all of the available token abilities.
         */
        getAvailableAbilities() {
            this.$http.get('/settings/api/token/abilities')
                .then(function(response) {
                    this.availableAbilities = response.data;
                });
        }
    }
};
