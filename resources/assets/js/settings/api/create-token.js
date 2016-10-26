module.exports = {
    props: ['availableAbilities'],


    /**
     * The component's data.
     */
    data() {
        return {
            showingToken: null,
            allAbilitiesAssigned: false,

            form: new SparkForm({
                name: '',
                abilities: []
            })
        };
    },


    computed: {
        copyCommandSupported() {
            return document.queryCommandSupported('copy');
        }
    },


    watch: {
        /**
         * Watch the available abilities for changes.
         */
        availableAbilities() {
            if (this.availableAbilities.length > 0) {
                this.assignDefaultAbilities();
            }
        }
    },


    methods: {
        /**
         * Assign all of the default abilities.
         */
        assignDefaultAbilities() {
            var defaults = _.filter(this.availableAbilities, a => a.default);

            this.form.abilities = _.pluck(defaults, 'value');
        },


        /**
         * Enable all the available abilities for the given token.
         */
        assignAllAbilities() {
            this.allAbilitiesAssigned = true;

            this.form.abilities = _.pluck(this.availableAbilities, 'value');
        },


        /**
         * Remove all of the abilities from the token.
         */
        removeAllAbilities() {
            this.allAbilitiesAssigned = false;

            this.form.abilities = [];
        },


        /**
         * Toggle the given ability in the list of assigned abilities.
         */
        toggleAbility(ability) {
            if (this.abilityIsAssigned(ability)) {
                this.form.abilities = _.reject(this.form.abilities, a => a == ability);
            } else {
                this.form.abilities.push(ability);
            }
        },


        /**
         * Determine if the given ability has been assigned to the token.
         */
        abilityIsAssigned(ability) {
            return _.contains(this.form.abilities, ability);
        },


        /**
         * Create a new API token.
         */
        create() {
            Spark.post('/settings/api/token', this.form)
                .then(response => {
                    this.showToken(response.token);

                    this.resetForm();

                    this.$parent.$emit('updateTokens');
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
         * Select the token and copy to Clipboard.
         */
        selectToken() {
            $('#api-token').select();

            if (this.copyCommandSupported) {
                document.execCommand("copy");
            }
        },


        /**
         * Reset the token form back to its default state.
         */
        resetForm() {
            this.form.name = '';

            this.assignDefaultAbilities();

            this.allAbilitiesAssigned = false;
        }
    }
};
