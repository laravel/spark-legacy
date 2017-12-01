<spark-team-members :user="user" :team="team" inline-template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                {{__('teams.team_members')}} (@{{ team.users.length }})
            </div>

            <div class="table-responsive">
                <table class="table table-valign-middle mb-0">
                    <thead>
                        <th class="th-fit"></th>
                        <th>{{__('Name')}}</th>
                        <th v-if="roles.length > 1">{{__('Role')}}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        <tr v-for="member in team.users">
                            <!-- Photo -->
                            <td>
                                <img :src="member.photo_url" class="spark-profile-photo">
                            </td>

                            <!-- Name -->
                            <td>
                                <span v-if="member.id === user.id">
                                    {{__('You')}}
                                </span>

                                <span v-else>
                                    @{{ member.name }}
                                </span>
                            </td>

                            <!-- Role -->
                            <td v-if="roles.length > 0">
                                @{{ teamMemberRole(member) }}
                            </td>

                            <td class="td-fit">
                                <button class="btn btn-outline-primary" @click="editTeamMember(member)" v-if="roles.length > 1 && canEditTeamMember(member)">
                                    <i class="fa fa-cog"></i>
                                </button>

                                <button class="btn btn-outline-danger" @click="approveTeamMemberDelete(member)" v-if="canDeleteTeamMember(member)">
                                <i class="fa fa-remove"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Update Team Member Modal -->
        <div class="modal" id="modal-update-team-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="updatingTeamMember">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('teams.edit_team_member')}} (@{{ updatingTeamMember.name }})
                        </h5>
                    </div>

                    <div class="modal-body">
                        <!-- Update Team Member Form -->
                        <form role="form">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">
                                    {{__('Role')}}
                                </label>

                                <div class="col-md-6">
                                    <select class="form-control" v-model="updateTeamMemberForm.role" :class="{'is-invalid': updateTeamMemberForm.errors.has('role')}">
                                        <option v-for="role in roles" :value="role.value">
                                            @{{ role.text }}
                                        </option>
                                    </select>

                                    <span class="invalid-feedback" v-if="updateTeamMemberForm.errors.has('role')">
                                        @{{ updateTeamMemberForm.errors.get('role') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>

                        <button type="button" class="btn btn-primary" @click="update" :disabled="updateTeamMemberForm.busy">
                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Team Member Modal -->
        <div class="modal" id="modal-delete-member" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingTeamMember">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('teams.remove_team_member')}} (@{{ deletingTeamMember.name }})
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('teams.are_you_sure_you_want_to_delete_member')}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-danger" @click="deleteMember" :disabled="deleteTeamMemberForm.busy">
                            {{__('Yes, Remove')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-team-members>
