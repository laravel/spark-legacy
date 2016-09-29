<spark-create-team inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">Create {{ucfirst(Spark::teamString())}}</div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" v-if="canCreateMoreTeams">
                <!-- Name -->
                <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                    <label class="col-md-4 control-label">{{ ucfirst(Spark::teamString()) }} Name</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-name" class="form-control" name="name" v-model="form.name">
                        <span class="help-block" v-if="hasTeamLimit">
                            You currently have @{{ remainingTeams }} teams remaining.
                        </span>
                        <span class="help-block" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                <!-- Create Button -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="create"
                                :disabled="form.busy">

                            Create
                        </button>
                    </div>
                </div>
            </form>

            <div v-else>
                <span class="text-danger">
                    Your current plan doesn't allow you to create more teams, please <a href="{{ url('/settings#/subscription') }}">upgrade your subscription</a>.
                </span>
            </div>
        </div>
    </div>
</spark-create-team>
