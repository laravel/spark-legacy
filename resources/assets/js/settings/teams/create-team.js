module.exports = {
    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({
                name: ''
            })
        };
    },


    events: {
        /**
         * Handle the "activatedTab" event.
         */
        activatedTab(tab) {
            if (tab === Spark.teamStringPlural) {
                Vue.nextTick(() => {
                    $('#create-team-name').focus();
                });
            }

            return true;
        }
    },


    methods: {
        /**
         * Create a new team.
         */
        create() {
            Spark.post('/settings/'+Spark.teamStringPlural, this.form)
                .then(() => {
                    this.form.name = '';

                    this.$dispatch('updateUser');
                    this.$dispatch('updateTeams');
                });
        }
    }
};
