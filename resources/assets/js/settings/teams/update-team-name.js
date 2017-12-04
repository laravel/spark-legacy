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
    mounted() {
        this.form.name = this.team.name;
    },


    methods: {
        /**
         * Update the team name.
         */
        update() {
            Spark.put(`/settings/${Spark.teamsPrefix}/${this.team.id}/name`, this.form)
                .then(() => {
                    Bus.$emit('updateTeam');
                    Bus.$emit('updateTeams');
                });
        }
    }
};
