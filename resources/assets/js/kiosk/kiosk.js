module.exports = {
    props: ['user'],


    /**
     * Load mixins for the component.
     */
    mixins: [require('./../mixins/tab-state')],


    /**
     * Prepare the component.
     */
    mounted() {
        this.usePushStateForTabs('.spark-settings-tabs');
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        Bus.$on('sparkHashChanged', function (hash, parameters) {
            if (hash == 'users') {
                setTimeout(() => {
                    $('#kiosk-users-search').focus();
                }, 150);
            }

            return true;
        });
    }
};
