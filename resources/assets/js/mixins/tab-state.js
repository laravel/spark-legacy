module.exports = {
    pushStateSelector: null,


    methods: {
        /**
         * Initialize push state handling for tabs.
         */
        usePushStateForTabs(selector) {
            this.pushStateSelector = selector;

            this.registerTabClickHandler();

            window.addEventListener('popstate', e => {
                this.activateTabForCurrentHash();
            });

            if (window.location.hash) {
                this.activateTabForCurrentHash();
            } else {
                this.activateFirstTab();
            }
        },


        /**
         * Register the click handler for all of the tabs.
         */
        registerTabClickHandler() {
            const self = this;

            $(`${this.pushStateSelector} a[data-toggle="tab"]`).on('click', function(e) {
                self.removeActiveClassFromTabs();

                history.pushState(null, null, '#/' + $(this).attr('href').substring(1));

                self.broadcastTabChange($(this).attr('href').substring(1));
            });
        },


        /**
         * Activate the tab for the current hash in the URL.
         */
        activateTabForCurrentHash() {
            var hash = window.location.hash.substring(2);

            var parameters = hash.split('/');

            hash = parameters.shift();

            this.removeActiveClassFromTabs();

            const tab = $(`${this.pushStateSelector} a[href="#${hash}"][data-toggle="tab"]`);

            if (tab.length > 0) {
                tab.tab('show');
            }

            this.broadcastTabChange(hash, parameters);
        },


        /**
         * Activate the first tab in a list.
         */
        activateFirstTab() {
            const tab = $(`${this.pushStateSelector} a[data-toggle="tab"]`).first();

            tab.tab('show');

            this.broadcastTabChange(tab.attr('href').substring(1));
        },


        /**
         * Remove the active class from the tabs.
         */
        removeActiveClassFromTabs() {
            $(`${this.pushStateSelector} li`).removeClass('active');
        },


        /**
         * Broadcast that a tab change happened.
         */
        broadcastTabChange(hash, parameters) {
            this.$dispatch('sparkHashChanged', hash, parameters);
            this.$broadcast('sparkHashChanged', hash, parameters);
        }
    }
};
