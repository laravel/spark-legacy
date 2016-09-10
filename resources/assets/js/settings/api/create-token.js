module.exports = {
    props: ['scopes'],


    /**
     * The component's data.
     */
    data() {
        return {
            showingToken: null,
            allScopesAssigned: false,

            form: new SparkForm({
                name: '',
                scopes: []
            })
        };
    },


    watch: {
        /**
         * Watch the scopes for changes.
         */
        scopes() {
            if (this.scopes.length > 0) {
                this.assignDefaultScopes();
            }
        }
    },


    methods: {
        /**
         * Assign all of the default scopes.
         */
        assignDefaultScopes() {
            var defaults = _.filter(this.scopes, s => s.default);

            this.form.scopes = _.pluck(defaults, 'id');
        },


        /**
         * Enable all the scopes for the given token.
         */
        assignAllScopes() {
            this.allScopesAssigned = true;

            this.form.scopes = _.pluck(this.scopes, 'id');
        },


        /**
         * Remove all of the scopes from the token.
         */
        removeAllScopes() {
            this.allScopesAssigned = false;

            this.form.scopes = [];
        },


        /**
         * Toggle the given scope in the list of assigned scopes.
         */
        toggleScope(scope) {
            if (this.scopeIsAssigned(scope)) {
                this.form.scopes = _.reject(this.form.scopes, s => s == scope);
            } else {
                this.form.scopes.push(scope);
            }
        },


        /**
         * Determine if the given scope has been assigned to the token.
         */
        scopeIsAssigned(scope) {
            return _.contains(this.form.scopes, scope);
        },


        /**
         * Create a new API token.
         */
        create() {
            Spark.post('/oauth/personal-access-tokens', this.form)
                .then(response => {
                    this.showToken(response.accessToken);

                    this.resetForm();

                    this.$dispatch('updateTokens');
                });
        },


        /**
         * Display the token to the user.
         */
        showToken(token) {
            this.showingToken = token;

            $('#modal-show-token').modal('show');
        },


        /**
         * Reset the token form back to its default state.
         */
        resetForm() {
            this.form.name = '';

            this.assignDefaultScopes();

            this.allScopesAssigned = false;
        }
    }
};
