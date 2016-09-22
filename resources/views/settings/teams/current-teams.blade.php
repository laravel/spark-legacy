<spark-current-teams :user="user" :teams="teams" inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Current {{ ucfirst(str_plural(Spark::teamString())) }}</div>

            <div class="panel-body">
                <table class="table table-borderless m-b-none">
                    <thead>
                        <th></th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th></th>
                        <th></th>
                    </thead>

                    <tbody>
                        <tr v-for="team in teams">
                            <!-- Photo -->
                            <td>
                                <img :src="team.photo_url" class="spark-team-photo">
                            </td>

                            <!-- Team Name -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ team.name }}
                                </div>
                            </td>

                            <!-- Owner Name -->
                            <td>
                                <div class="btn-table-align">
                                    <span v-if="user.name == team.owner.name">
                                        You
                                    </span>

                                    <span v-else>
                                        @{{ team.owner.name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Edit Button -->
                            <td>
                                <a href="/settings/{{str_plural(Spark::teamString())}}/@{{ team.id }}">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                </a>
                            </td>

                            <!-- Leave Button -->
                            <td>
                                <button class="btn btn-warning" @click="approveLeavingTeam(team)"
                                    data-toggle="tooltip" title="Leave Team"
                                    v-if="user.id !== team.owner_id">
                                    <i class="fa fa-sign-out"></i>
                                </button>
                            </td>

                            <!-- Delete Button -->
                            <td>
                                <button class="btn btn-danger-outline" @click="approveTeamDelete(team)" v-if="user.id === team.owner_id">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Leave Team Modal -->
        <div class="modal fade" id="modal-leave-team" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="leavingTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Leave {{ ucfirst(Spark::teamString()) }} (@{{ leavingTeam.name }})
                        </h4>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to leave this {{ Spark::teamString() }}?
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                        <button type="button" class="btn btn-warning" @click="leaveTeam" :disabled="leaveTeamForm.busy">
                            Yes, Leave
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Team Modal -->
        <div class="modal fade" id="modal-delete-team" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Delete {{ ucfirst(Spark::teamString()) }} (@{{ deletingTeam.name }})
                        </h4>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this {{ Spark::teamString() }}? If you choose to delete the {{ Spark::teamString() }}, all of the
                        {{ Spark::teamString() }}'s data will be permanently deleted.
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                        <button type="button" class="btn btn-danger" @click="deleteTeam" :disabled="deleteTeamForm.busy">
                            <span v-if="deleteTeamForm.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>Deleting
                            </span>

                            <span v-else>
                                Yes, Delete
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-current-teams>
