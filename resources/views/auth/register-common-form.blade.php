<form class="form-horizontal" role="form">
    @if (Spark::usesTeams() && Spark::onlyTeamPlans())
        <!-- Team Name -->
        <div class="form-group" :class="{'has-error': registerForm.errors.has('team')}" v-if=" ! invitation">
            <label class="col-md-4 control-label">{{ __('spark::app.auth.team-name', ['team' => Spark::teamString()]) }}</label>

            <div class="col-md-6">
                <input type="name" class="form-control" name="team" v-model="registerForm.team" autofocus>

                <span class="help-block" v-show="registerForm.errors.has('team')">
                    @{{ registerForm.errors.get('team') }}
                </span>
            </div>
        </div>

        @if (Spark::teamsIdentifiedByPath())
            <!-- Team Slug (Only Shown When Using Paths For Teams) -->
            <div class="form-group" :class="{'has-error': registerForm.errors.has('team_slug')}" v-if=" ! invitation">
                <label class="col-md-4 control-label">{{ __('spark::app.auth.team-slug', ['team' => Spark::teamString()]) }}</label>

                <div class="col-md-6">
                    <input type="name" class="form-control" name="team_slug" v-model="registerForm.team_slug" autofocus>

                    <p class="help-block" v-show=" ! registerForm.errors.has('team_slug')">
                        {{ __('spark::app.auth.team-slug-description') }}
                    </p>

                    <span class="help-block" v-show="registerForm.errors.has('team_slug')">
                        @{{ registerForm.errors.get('team_slug') }}
                    </span>
                </div>
            </div>
        @endif
    @endif

    <!-- Name -->
    <div class="form-group" :class="{'has-error': registerForm.errors.has('name')}">
        <label class="col-md-4 control-label">{{ __('spark::app.auth.name') }}</label>

        <div class="col-md-6">
            <input type="name" class="form-control" name="name" v-model="registerForm.name" autofocus>

            <span class="help-block" v-show="registerForm.errors.has('name')">
                @{{ registerForm.errors.get('name') }}
            </span>
        </div>
    </div>

    <!-- E-Mail Address -->
    <div class="form-group" :class="{'has-error': registerForm.errors.has('email')}">
        <label class="col-md-4 control-label">{{ __('spark::app.auth.email') }}</label>

        <div class="col-md-6">
            <input type="email" class="form-control" name="email" v-model="registerForm.email">

            <span class="help-block" v-show="registerForm.errors.has('email')">
                @{{ registerForm.errors.get('email') }}
            </span>
        </div>
    </div>

    <!-- Password -->
    <div class="form-group" :class="{'has-error': registerForm.errors.has('password')}">
        <label class="col-md-4 control-label">{{ __('spark::app.auth.password') }}</label>

        <div class="col-md-6">
            <input type="password" class="form-control" name="password" v-model="registerForm.password">

            <span class="help-block" v-show="registerForm.errors.has('password')">
                @{{ registerForm.errors.get('password') }}
            </span>
        </div>
    </div>

    <!-- Password Confirmation -->
    <div class="form-group" :class="{'has-error': registerForm.errors.has('password_confirmation')}">
        <label class="col-md-4 control-label">{{ __('spark::app.auth.confirm-password') }}</label>

        <div class="col-md-6">
            <input type="password" class="form-control" name="password_confirmation" v-model="registerForm.password_confirmation">

            <span class="help-block" v-show="registerForm.errors.has('password_confirmation')">
                @{{ registerForm.errors.get('password_confirmation') }}
            </span>
        </div>
    </div>

    <!-- Terms And Conditions -->
    <div v-if=" ! selectedPlan || selectedPlan.price == 0">
        <div class="form-group" :class="{'has-error': registerForm.errors.has('terms')}">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="terms" v-model="registerForm.terms">
                        {{ __('spark::app.billing.accept-the-terms, ['terms' => '<a href="/terms" target="_blank">'.__('spark::app.billing.terms-of-service').'</a>']) }}
                    </label>

                    <span class="help-block" v-show="registerForm.errors.has('terms')">
                        @{{ registerForm.errors.get('terms') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-primary" @click.prevent="register" :disabled="registerForm.busy">
                    <span v-if="registerForm.busy">
                        <i class="fa fa-btn fa-spinner fa-spin"></i>{{ __('spark::app.auth.registering') }}
                    </span>

                    <span v-else>
                        <i class="fa fa-btn fa-check-circle"></i>{{ __('spark::app.auth.register') }}
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
