<spark-current-teams :user="user" :teams="teams" inline-template>
    <div>
        <div class="card card-default">
            <div class="card-header">{{__('Current :teamString', ['teamString' => ucfirst(__(Spark::teamString()))])}}</div>

            <div class="table-responsive">
                <table class="table table-valign-middle mb-0">
                    <thead>
                        <th class="th-fit"></th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Owner')}}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        <tr class="reveal" v-for="team in teams">
                            <!-- Photo -->
                            <td>
                                <img :src="team.photo_url" class="spark-profile-photo">
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
                                    <span v-if="user.id == team.owner.id">
                                        {{__('You')}}
                                    </span>

                                    <span v-else>
                                        @{{ team.owner.name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Edit Button -->
                            <td class="td-fit">
                                <div class="reveal-target text-right">
                                    <a :href="'/settings/{{str_plural(Spark::teamString())}}/'+team.id">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                    </a>

                                    <button class="btn btn-warning" @click="approveLeavingTeam(team)"
                                            data-toggle="tooltip" title="Leave Team"
                                            v-if="user.id !== team.owner_id">
                                        <i class="fa fa-sign-out"></i>
                                    </button>

                                    @if (Spark::createsAdditionalTeams())
                                        <button class="btn btn-danger-outline" @click="approveTeamDelete(team)" v-if="user.id === team.owner_id">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Leave Team Modal -->
        <div class="modal" id="modal-leave-team" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="leavingTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Leave :teamString', ['teamString' => ucfirst(__(Spark::teamString()))])}} (@{{ leavingTeam.name }})
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('Are you sure you want to leave this :teamString?', ['teamString' => __(Spark::teamString())])}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-warning" @click="leaveTeam" :disabled="leaveTeamForm.busy">
                            {{__('Yes, Leave')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Team Modal -->
        <div class="modal" id="modal-delete-team" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Delete :teamString', ['teamString' => ucfirst(__(Spark::teamString()))])}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('Are you sure you want to delete this :teamString?', ['teamString' => __(Spark::teamString())])}}
                        {{__('If you choose to delete the :teamString all data will be permanently deleted.', ['teamString' => __(Spark::teamString())])}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-danger" @click="deleteTeam" :disabled="deleteTeamForm.busy">
                            <span v-if="deleteTeamForm.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Deleting')}}
                            </span>

                            <span v-else>
                                {{__('Yes, Delete')}}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-current-teams>
