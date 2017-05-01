<spark-team-members :user="user" :team="team" inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">@lang(':Team Members', ['team' => Spark::teamString()]) (@{{ team.users.length }})</div>

            <div class="panel-body">
                <table class="table table-borderless m-b-none">
                    <thead>
                        <th></th>
                        <th>@lang('Name')</th>
                        <th v-if="roles.length > 1">@lang('Role')</th>
                        <th v-if="roles.length > 1"><!-- Edit Team Member Button --></th>
                        <th></th>
                    </thead>

                    <tbody>
                        <tr v-for="member in team.users">
                            <!-- Photo -->
                            <td>
                                <img :src="member.photo_url" class="spark-profile-photo">
                            </td>

                            <!-- Name -->
                            <td>
                                <div class="btn-table-align">
                                    <span v-if="member.id === user.id">
                                        @lang('You')
                                    </span>

                                    <span v-else>
                                        @{{ member.name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Role -->
                            <td v-if="roles.length > 0">
                                <div class="btn-table-align">
                                    @{{ teamMemberRole(member) }}
                                </div>
                            </td>

                            <!-- Edit Button -->
                            <td v-if="roles.length > 0">
                                <button class="btn btn-primary"
                                    @click="editTeamMember(member)"
                                    v-if="canEditTeamMember(member)">

                                    <i class="fa fa-pencil"></i>
                                </button>
                            </td>

                            <!-- Delete Button -->
                            <td>
                                <button class="btn btn-danger-outline"
                                    @click="approveTeamMemberDelete(member)"
                                    v-if="canDeleteTeamMember(member)">

                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Update Team Member Modal -->
        <div class="modal fade" id="modal-update-team-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="updatingTeamMember">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            @lang('Edit :Team Member', ['team' => Spark::teamString()]) (@{{ updatingTeamMember.name }})
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Update Team Member Form -->
                        <form class="form-horizontal" role="form">
                            <div class="form-group" :class="{'has-error': updateTeamMemberForm.errors.has('role')}">
                                <label class="col-md-4 control-label">@lang(':Team Member Role', ['team' => Spark::teamString()])</label>

                                <div class="col-md-6">
                                    <select class="form-control" v-model="updateTeamMemberForm.role">
                                        <option v-for="role in roles" :value="role.value">
                                            @{{ role.text }}
                                        </option>
                                    </select>

                                    <span class="help-block" v-if="updateTeamMemberForm.errors.has('role')">
                                        @{{ updateTeamMemberForm.errors.get('role') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>

                        <button type="button" class="btn btn-primary" @click="update" :disabled="updateTeamMemberForm.busy">
                            @lang('Update')
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Team Member Modal -->
        <div class="modal fade" id="modal-delete-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingTeamMember">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            @lang('Remove :Team Member', ['team' => Spark::teamString()]) (@{{ deletingTeamMember.name }})
                        </h4>
                    </div>

                    <div class="modal-body">
                        @lang('Are you sure you want to remove this :team member?', ['team' => Spark::teamString()])
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('No, Go Back')</button>

                        <button type="button" class="btn btn-danger" @click="deleteMember" :disabled="deleteTeamMemberForm.busy">
                            @lang('Yes, Remove')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-team-members>
