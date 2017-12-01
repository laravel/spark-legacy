<spark-update-team-name :user="user" :team="team" inline-template>
    <div class="card card-default">
        <div class="card-header">
            {{__('teams.update_team_name')}}
        </div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('teams.team_name_was_updated')}}
            </div>

            <form role="form">
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Name')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">

                        <span class="invalid-feedback" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="offset-md-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-team-name>
