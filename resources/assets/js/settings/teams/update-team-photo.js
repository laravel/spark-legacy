module.exports = {
    props: ['user', 'team'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({})
        };
    },


    methods: {
        /**
         * Update the team's photo.
         */
        update(e) {
            e.preventDefault();

            this.form.startProcessing();

            // We need to gather a fresh FormData instance with the profile photo appended to
            // the data so we can POST it up to the server. This will allow us to do async
            // uploads of the profile photos. We will update the user after this action.
            this.$http.post(this.urlForUpdate, this.gatherFormData())
                .then(response => {
                    this.$dispatch('updateTeam');
                    this.$dispatch('updateTeams');

                    this.form.finishProcessing();
                })
                .catch(function(response) {
                    this.form.setErrors(response.data);
                });
        },


        /**
         * Gather the form data for the photo upload.
         */
        gatherFormData() {
            const data = new FormData();

            data.append('photo', this.$els.photo.files[0]);

            return data;
        }
    },


    computed: {
        /**
         * Get the URL for updating the team photo.
         */
        urlForUpdate() {
            return `/settings/teams/${this.team.id}/photo`;
        },


        /**
         * Calculate the style attribute for the photo preview.
         */
        previewStyle() {
            return `background-image: url(${this.team.photo_url})`;
        }
    }
};
