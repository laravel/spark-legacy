module.exports = {
    props: ['user', 'teamId'],


    /**
     * Load mixins for the component.
     */
    mixins: [require('./../../mixins/tab-state')],


    /**
     * The component's data.
     */
    data() {
        return {
            billableType: 'team',
            team: null
        };
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getTeam();
    },


    /**
     * Prepare the component.
     */
    ready() {
        this.usePushStateForTabs('.spark-settings-tabs');
    },


    events: {
        /**
         * Update the team being managed.
         */
        updateTeam() {
            this.getTeam();
        }
    },


    methods: {
        /**
         * Get the team being managed.
         */
        getTeam() {
            this.$http.get(`/${Spark.pluralTeamString}/${this.teamId}`)
                .then(response => {
                    this.team = response.data;
                });
        }
    }
};
