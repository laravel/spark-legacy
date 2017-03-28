<spark-enable-two-factor-auth :user="user" inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">@lang('Two-Factor Authentication')</div>

        <div class="panel-body">
            <!-- Information Message -->
            <div class="alert alert-info">
                @lang('In order to use two-factor authentication, you <strong>must</strong> install the :app application on your smartphone. :app is available for iOS and Android.', [
                    'app' => '<strong><a href="https://authy.com" target="_blank">Authy</a></strong>'
                ])
            </div>

            <form class="form-horizontal" role="form">
                <!-- Country Code -->
                <div class="form-group" :class="{'has-error': form.errors.has('country_code')}">
                    <label class="col-md-4 control-label">@lang('Country Code')</label>

                    <div class="col-md-6">
                        <input type="number" class="form-control" name="country_code" v-model="form.country_code">

                        <span class="help-block" v-show="form.errors.has('country_code')">
                            @{{ form.errors.get('country_code') }}
                        </span>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="form-group" :class="{'has-error': form.errors.has('phone')}">
                    <label class="col-md-4 control-label">@lang('Phone Number')</label>

                    <div class="col-md-6">
                        <input type="tel" class="form-control" name="phone" v-model="form.phone">

                        <span class="help-block" v-show="form.errors.has('phone')">
                            @{{ form.errors.get('phone') }}
                        </span>
                    </div>
                </div>

                <!-- Enable Button -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="enable"
                                :disabled="form.busy">

                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>@lang('Enabling')
                            </span>

                            <span v-else>
                                @lang('Enable')
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-enable-two-factor-auth>
