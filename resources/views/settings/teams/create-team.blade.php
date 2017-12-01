<spark-create-team inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('teams.create_team')}}</div>

        <div class="card-body">
            <form role="form" v-if="canCreateMoreTeams">
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('teams.team_name')}}</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-name" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">

                        <span class="invalid-feedback" v-if="hasTeamLimit">
                            <?php echo __('teams.you_have_x_teams_remaining', ['teamCount' => '{{ remainingTeams }}']); ?>
                        </span>

                        <span class="invalid-feedback" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                @if (Spark::teamsIdentifiedByPath())
                <!-- Slug (Only Shown When Using Paths For Teams) -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('teams.team_slug')}}</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-slug" class="form-control" name="slug" v-model="form.slug" :class="{'is-invalid': form.errors.has('slug')}">

                        <small class="form-text text-muted" v-show=" ! form.errors.has('slug')">
                            {{__('teams.slug_input_explanation')}}
                        </small>

                        <span class="invalid-feedback" v-show="form.errors.has('slug')">
                            @{{ form.errors.get('slug') }}
                        </span>
                    </div>
                </div>
                @endif

                <!-- Create Button -->
                <div class="form-group row mb-0">
                    <div class="offset-md-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="create"
                                :disabled="form.busy">

                            {{__('Create')}}
                        </button>
                    </div>
                </div>
            </form>

            <div v-else>
                <span class="text-danger">
                    {{__('teams.plan_allows_no_more_teams')}},
                    <a href="{{ url('/settings#/subscription') }}">{{__('please upgrade your subscription')}}</a>.
                </span>
            </div>
        </div>
    </div>
</spark-create-team>
