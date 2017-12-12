<spark-send-invitation :user="user" :team="team" :billable-type="billableType" default-role="{{Spark::defaultRole()}}" inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Send Invitation')}}</div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('The invitation has been sent!')}}
            </div>

            <form role="form" v-if="canInviteMoreTeamMembers">
                <!-- E-Mail Address -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('E-Mail Address')}}</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" v-model="form.email" :class="{'is-invalid': form.errors.has('email')}">
                        <span class="invalid-feedback" v-if="hasTeamMembersLimit">
                            <?php echo __('teams.you_have_x_invitations_remaining', ['count' => '{{ remainingTeamMembers }}']); ?>
                        </span>
                        <span class="invalid-feedback" v-show="form.errors.has('email')">
                            @{{ form.errors.get('email') }}
                        </span>
                    </div>
                </div>

                <!-- Role -->
                <div class="form-group row" v-if="roles.length > 0">
                    <label class="col-md-4 col-form-label text-md-right">Role</label>

                    <div class="col-md-6">
                        <select class="form-control" v-model="form.role" :class="{'is-invalid': form.errors.has('role')}" >
                            <option v-for="role in roles" :value="role.value">@{{ role.text }}</option>
                        </select>
                        <span class="invalid-feedback" v-show="form.errors.has('role')">
                            @{{ form.errors.get('role') }}
                        </span>
                    </div>
                </div>

                <!-- Send Invitation Button -->
                <div class="form-group row mb-0">
                    <div class="offset-md-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="send"
                                :disabled="form.busy">

                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Sending')}}
                            </span>

                            <span v-else>
                                {{__('Send Invitation')}}
                            </span>
                        </button>
                    </div>
                </div>
            </form>

            <div v-else>
                <span class="text-danger">
                    {{__('Your current plan doesn\'t allow you to invite more members, please upgrade your subscription.')}}
                </span>
            </div>
        </div>
    </div>
</spark-send-invitation>
