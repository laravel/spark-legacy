module.exports = {
    props: ['user', 'team'],

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


    /**
     * Prepare the component.
     */
    ready() {
        this.form.name = this.team.name;
    },


    methods: {
        /**
         * Update the team name.
         */
        update() {
            Spark.put(`/settings/${Spark.pluralTeamString}/${this.team.id}/name`, this.form)
                .then(() => {
                    this.$dispatch('updateTeam');
                    this.$dispatch('updateTeams');
                });
        }
    }
};
