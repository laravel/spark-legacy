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
    mounted() {
        this.getTokens();
        this.getAvailableAbilities();
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        this.$on('updateTokens', function(){
            self.getTokens();
        });
    },


    methods: {
        /**
         * Get the current API tokens for the user.
         */
        getTokens() {
            axios.get('/settings/api/tokens')
                .then(response => this.tokens = response.data);
        },


        /**
         * Get all of the available token abilities.
         */
        getAvailableAbilities() {
            axios.get('/settings/api/token/abilities')
                .then(response => this.availableAbilities = response.data);
        }
    }
};
