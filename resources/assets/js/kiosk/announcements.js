var announcementsCreateForm = function () {
    return {
        body: '',
        action_text: '',
        action_url: ''
    };
};

module.exports = {
    /**
     * The component's data.
     */
    data() {
        return {
            announcements: [],
            updatingAnnouncement: null,
            deletingAnnouncement: null,

            createForm: new SparkForm(announcementsCreateForm()),
            updateForm: new SparkForm(announcementsCreateForm()),

            deleteForm: new SparkForm({})
        };
    },


    events: {
        /**
         * Handle this component becoming the active tab.
         */
        sparkHashChanged: function (hash) {
            if (hash == 'announcements' && this.announcements.length === 0) {
                this.getAnnouncements();
            }
        }
    },


    methods: {
        /**
         * Get all of the announcements.
         */
        getAnnouncements() {
            this.$http.get('/spark/kiosk/announcements')
                .then(response => {
                    this.announcements = response.data;
                });
        },


        /**
         * Create a new announcement.
         */
        create() {
            Spark.post('/spark/kiosk/announcements', this.createForm)
                .then(() => {
                    this.createForm = new SparkForm(announcementsCreateForm());

                    this.getAnnouncements();
                });
        },


        /**
         * Edit the given announcement.
         */
        editAnnouncement(announcement) {
            this.updatingAnnouncement = announcement;

            this.updateForm.icon = announcement.icon;
            this.updateForm.body = announcement.body;
            this.updateForm.action_text = announcement.action_text;
            this.updateForm.action_url = announcement.action_url;

            $('#modal-update-announcement').modal('show');
        },


        /**
         * Update the specified announcement.
         */
        update() {
            Spark.put('/spark/kiosk/announcements/' + this.updatingAnnouncement.id, this.updateForm)
                .then(() => {
                    this.getAnnouncements();

                    $('#modal-update-announcement').modal('hide');
                });
        },


        /**
         * Show the approval dialog for deleting an announcement.
         */
        approveAnnouncementDelete(announcement) {
            this.deletingAnnouncement = announcement;

            $('#modal-delete-announcement').modal('show');
        },


        /**
         * Delete the specified announcement.
         */
        delete() {
            Spark.delete('/spark/kiosk/announcements/' + this.deletingAnnouncement.id, this.deleteForm)
                .then(() => {
                    this.getAnnouncements();

                    $('#modal-delete-announcement').modal('hide');
                });
        }
    }
};
