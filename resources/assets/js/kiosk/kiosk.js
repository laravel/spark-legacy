module.exports = {
    props: ['user'],


    /**
     * Load mixins for the component.
     */
    mixins: [require('./../mixins/tab-state')],


    /**
     * Prepare the component.
     */
    ready() {
        this.usePushStateForTabs('.spark-settings-tabs');
    },


    events: {
        /**
         * Handle the Spark tab changed event.
         */
        sparkHashChanged(hash) {
            if (hash == 'users') {
                setTimeout(() => {
                    $('#kiosk-users-search').focus();
                }, 150);
            }

            return true;
        }
    }
};
