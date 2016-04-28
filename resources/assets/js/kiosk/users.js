module.exports = {
    props: ['user'],


    /**
     * The component's data.
     */
    data() {
        return {
            plans: [],

            searchForm: new SparkForm({
                query: ''
            }),

            searching: false,
            noSearchResults: false,
            searchResults: [],

            showingUserProfile: false
        };
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getPlans();
    },


    events: {
        /**
         * Show the search results and hide the user profile.
         */
        showSearch() {
            this.navigateToSearch();
        },


        /**
         * Handle the Spark tab changed event.
         */
        sparkHashChanged(hash, parameters) {
            if (hash != 'users') {
                return true;
            }

            if (parameters && parameters.length > 0) {
                this.loadProfile({ id: parameters[0] });
            } else {
                this.showSearch();
            }

            return true;
        }
    },


    methods: {
        /**
         * Get all of the available subscription plans.
         */
        getPlans() {
            this.$http.get('/spark/plans')
                .then(function(response) {
                    this.plans = response.data;
                });
        },


        /**
         * Perform a search for the given query.
         */
        search() {
            this.searching = true;
            this.noSearchResults = false;

            this.$http.post('/spark/kiosk/users/search', JSON.stringify(this.searchForm))
                .then(response => {
                    this.searchResults = response.data;
                    this.noSearchResults = this.searchResults.length === 0;

                    this.searching = false;
                });
        },


        /**
         * Show the search results and update the browser history.
         */
        navigateToSearch() {
            history.pushState(null, null, '#/users');

            this.showSearch();
        },


        /**
         * Show the search results.
         */
        showSearch() {
            this.showingUserProfile = false;

            Vue.nextTick(function () {
                $('#kiosk-users-search').focus();
            });
        },


        /**
         * Show the user profile for the given user.
         */
        showUserProfile(user) {
            history.pushState(null, null, '#/users/' + user.id);

            this.loadProfile(user);
        },


        /**
         * Load the user profile for the given user.
         */
        loadProfile(user) {
            this.$broadcast('showUserProfile', user.id);

            this.showingUserProfile = true;
        }
    }
};
