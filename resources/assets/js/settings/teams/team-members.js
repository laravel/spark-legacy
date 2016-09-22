module.exports = {
    props: ['user', 'team'],


    /**
     * The component's data.
     */
    data() {
        return {
            roles: [],

            updatingTeamMember: null,
            deletingTeamMember: null,

            updateTeamMemberForm: $.extend(true, new SparkForm({
                role: ''
            }), Spark.forms.updateTeamMember),

            deleteTeamMemberForm: new SparkForm({})
        }
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        this.getRoles();
    },


    methods: {
        /**
         * Get the available team member roles.
         */
        getRoles() {
            this.$http.get(`/settings/${Spark.pluralTeamString}/roles`)
                .then(response => {
                    this.roles = response.data;
                });
        },


        /**
         * Edit the given team member.
         */
        editTeamMember(member) {
            this.updatingTeamMember = member;
            this.updateTeamMemberForm.role = member.pivot.role;

            $('#modal-update-team-member').modal('show');
        },


        /**
         * Update the team member.
         */
        update() {
            Spark.put(this.urlForUpdating, this.updateTeamMemberForm)
                .then(() => {
                    this.$dispatch('updateTeam');

                    $('#modal-update-team-member').modal('hide');
                });
        },


        /**
         * Display the approval modal for the deletion of a team member.
         */
        approveTeamMemberDelete(member) {
            this.deletingTeamMember = member;

            $('#modal-delete-member').modal('show');
        },


        /**
         * Delete the given team member.
         */
        delete() {
            Spark.delete(this.urlForDeleting, this.deleteTeamMemberForm)
                .then(() => {
                    this.$dispatch('updateTeam');

                    $('#modal-delete-member').modal('hide');
                });
        },


        /**
         * Determine if the current user can edit a team member.
         */
        canEditTeamMember(member) {
            return this.user.id === this.team.owner_id && this.user.id !== member.id
        },


        /**
         * Determine if the current user can delete a team member.
         */
        canDeleteTeamMember(member) {
            return this.user.id === this.team.owner_id && this.user.id !== member.id
        },


        /**
         * Get the displayable role for the given team member.
         */
        teamMemberRole(member) {
            if (this.roles.length == 0) {
                return '';
            }

            if (member.pivot.role == 'owner') {
                return 'Owner';
            }

            const role = _.find(this.roles, role => role.value == member.pivot.role);

            if (typeof role !== 'undefined') {
                return role.text;
            }
        }
    },


    computed: {
        /**
         * Get the URL for updating a team member.
         */
        urlForUpdating: function () {
            return `/settings/${Spark.pluralTeamString}/${this.team.id}/members/${this.updatingTeamMember.id}`;
        },


        /**
         * Get the URL for deleting a team member.
         */
        urlForDeleting() {
            return `/settings/${Spark.pluralTeamString}/${this.team.id}/members/${this.deletingTeamMember.id}`;
        }
    }
};
