module.exports = {
    props: [
        'user', 'teams', 'currentTeam',
        'hasUnreadNotifications', 'hasUnreadAnnouncements'
    ],


    methods: {
         /**
          * Show the user's notifications.
          */
         showNotifications() {
            this.$dispatch('showNotifications');
        },


        /**
         * Show the customer support e-mail form.
         */
        showSupportForm() {
            this.$dispatch('showSupportForm');
        }
    }
};
