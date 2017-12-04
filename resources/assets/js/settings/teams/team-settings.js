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
        var self = this;

        this.getTeam();

        Bus.$on('updateTeam', function () {
            self.getTeam();
        });
    },


    /**
     * Prepare the component.
     */
    mounted() {
        this.usePushStateForTabs('.spark-settings-tabs');
    },


    methods: {
        /**
         * Get the team being managed.
         */
        getTeam() {
            axios.get(`/settings/${Spark.teamsPrefix}/json/${this.teamId}`)
                .then(response => {
                    this.team = response.data;
                });
        }
    }
};
