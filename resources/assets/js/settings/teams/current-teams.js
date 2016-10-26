module.exports = {
    props: ['user', 'teams'],


    /**
     * The component's data.
     */
    data() {
        return {
            leavingTeam: null,
            deletingTeam: null,

            leaveTeamForm: new SparkForm({}),
            deleteTeamForm: new SparkForm({})
        };
    },


    /**
     * Prepare the component.
     */
    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
    },


    methods: {
        /**
         * Approve leaving the given team.
         */
        approveLeavingTeam(team) {
            this.leavingTeam = team;

            $('#modal-leave-team').modal('show');
        },


        /**
         * Leave the given team.
         */
        leaveTeam() {
            Spark.delete(this.urlForLeaving, this.leaveTeamForm)
                .then(() => {
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeams');

                    $('#modal-leave-team').modal('hide');
                });
        },


        /**
         * Approve the deletion of the given team.
         */
        approveTeamDelete(team) {
            this.deletingTeam = team;

            $('#modal-delete-team').modal('show');
        },


        /**
         * Delete the given team.
         */
        deleteTeam() {
            Spark.delete(`/settings/${Spark.pluralTeamString}/${this.deletingTeam.id}`, this.deleteTeamForm)
                .then(() => {
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeams');

                    $('#modal-delete-team').modal('hide');
                });
        }
    },


    computed: {
        /**
         * Get the URL for leaving a team.
         */
        urlForLeaving() {
            return `/settings/${Spark.pluralTeamString}/${this.leavingTeam.id}/members/${this.user.id}`;
        }
    }
};
