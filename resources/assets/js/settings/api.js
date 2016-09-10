module.exports = {
    /**
     * The component's data.
     */
    data() {
        return {
            tokens: [],
            scopes: []
        };
    },


    /**
     * Prepare the component.
     */
    ready() {
        this.getTokens();
        this.getScopes();
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
            this.$http.get('/oauth/personal-access-tokens')
                    .then(function(response) {
                        this.tokens = response.data;
                    });
        },


        /**
         * Get all of the available token abilities.
         */
        getScopes() {
            this.$http.get('/oauth/scopes')
                .then(function(response) {
                    this.scopes = response.data;
                });
        }
    }
};
