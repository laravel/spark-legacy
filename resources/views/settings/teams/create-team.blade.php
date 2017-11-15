<spark-create-team inline-template>
    <div class="card card-default">
        <div class="card-header">Create {{ucfirst(Spark::teamString())}}</div>

        <div class="card-body">
            <form role="form" v-if="canCreateMoreTeams">
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{ ucfirst(Spark::teamString()) }} Name</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-name" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">

                        <span class="invalid-feedback" v-if="hasTeamLimit">
                            You currently have @{{ remainingTeams }} {{ str_plural(Spark::teamString()) }} remaining.
                        </span>

                        <span class="invalid-feedback" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                @if (Spark::teamsIdentifiedByPath())
                <!-- Slug (Only Shown When Using Paths For Teams) -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{ ucfirst(Spark::teamString()) }} Slug</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-slug" class="form-control" name="slug" v-model="form.slug" :class="{'is-invalid': form.errors.has('slug')}">

                        <small class="form-text text-muted" v-show=" ! form.errors.has('slug')">
                            This slug is used to identify your team in URLs.
                        </small>

                        <span class="invalid-feedback" v-show="form.errors.has('slug')">
                            @{{ form.errors.get('slug') }}
                        </span>
                    </div>
                </div>
                @endif

                <!-- Create Button -->
                <div class="form-group row">
                    <div class="offset-md-4 col-md-6">
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
