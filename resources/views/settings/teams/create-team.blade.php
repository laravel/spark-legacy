<spark-create-team inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Create :teamString', ['teamString' => ucfirst(__(Spark::teamString()))])}}</div>

        <div class="card-body">
            <form role="form" v-if="canCreateMoreTeams">
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__(':teamString Name', ['teamString' => ucfirst(__(Spark::teamString()))])}}</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-name" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">

                        <span class="invalid-feedback" v-if="hasTeamLimit">
                            <?php echo __('You currently have :teamCount :teamsString remaining.', ['teamCount' => '{{ remainingTeams }}', 'teamsString' => __(str_plural(Spark::teamString()))]); ?>
                        </span>

                        <span class="invalid-feedback" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                @if (Spark::teamsIdentifiedByPath())
                <!-- Slug (Only Shown When Using Paths For Teams) -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__(':teamString Slug', ['teamString' => ucfirst(__(Spark::teamString()))])}}</label>

                    <div class="col-md-6">
                        <input type="text" id="create-team-slug" class="form-control" name="slug" v-model="form.slug" :class="{'is-invalid': form.errors.has('slug')}">

                        <small class="form-text text-muted" v-show=" ! form.errors.has('slug')">
                            {{__('This slug is used to identify your team in URLs.')}}
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

                            {{__('Create')}}
                        </button>
                    </div>
                </div>
            </form>

            <div v-else>
                <span class="text-danger">
                    {{__('Your current plan doesn\'t allow you to create more teams')}},
                    <a href="{{ url('/settings#/subscription') }}">{{__('please upgrade your subscription')}}</a>.
                </span>
            </div>
        </div>
    </div>
</spark-create-team>
