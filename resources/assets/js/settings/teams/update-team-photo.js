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

            var self = this;

            this.form.startProcessing();

            // We need to gather a fresh FormData instance with the profile photo appended to
            // the data so we can POST it up to the server. This will allow us to do async
            // uploads of the profile photos. We will update the user after this action.
            $.ajax({
                url: this.urlForUpdate,
                data: this.gatherFormData(),
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                headers: {
                    'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
                },
                success: function () {
                    self.$dispatch('updateTeam');
                    self.$dispatch('updateTeams');

                    self.form.finishProcessing();
                },
                error: function (error) {
                    self.form.setErrors(error.responseJSON);
                }
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
            return `/settings/${Spark.pluralTeamString}/${this.team.id}/photo`;
        },


        /**
         * Calculate the style attribute for the photo preview.
         */
        previewStyle() {
            return `background-image: url(${this.team.photo_url})`;
        }
    }
};
