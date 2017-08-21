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
        var self = this;

        this.getPlans();

        this.$on('showSearch', function(){
            self.navigateToSearch();
        });

        Bus.$on('sparkHashChanged', function (hash, parameters) {
            if (hash != 'users') {
                return true;
            }

            if (parameters && parameters.length > 0) {
                self.loadProfile({ id: parameters[0] });
            } else {
                self.showSearch();
            }

            return true;
        });
    },


    methods: {
        /**
         * Get all of the available subscription plans.
         */
        getPlans() {
            axios.get('/spark/plans')
                .then(response => {
                    this.plans = response.data;
                });
        },


        /**
         * Perform a search for the given query.
         */
        search() {
            this.searching = true;
            this.noSearchResults = false;

            axios.post('/spark/kiosk/users/search', this.searchForm)
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
            this.$emit('showUserProfile', user.id);

            this.showingUserProfile = true;
        }
    }
};
