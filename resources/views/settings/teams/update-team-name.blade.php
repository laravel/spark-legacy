<spark-update-team-name :user="user" :team="team" inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">@lang('Update :Team Name', ['team' => Spark::teamString()])</div>

        <div class="panel-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                @lang('Your :team name has been updated!', ['team' => Spark::teamString()])
            </div>

            <form class="form-horizontal" role="form">
                <!-- Name -->
                <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                    <label class="col-md-4 control-label">@lang('Name')</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" v-model="form.name">

                        <span class="help-block" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            @lang('Update')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-team-name>
