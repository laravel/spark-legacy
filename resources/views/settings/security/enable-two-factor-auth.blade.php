<spark-enable-two-factor-auth :user="user" inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Two-Factor Authentication')}}</div>

        <div class="card-body">
            <!-- Information Message -->
            <div class="alert alert-info">
                {{__('In order to use two-factor authentication, you must install the :authyLink application on your smartphone. Authy is available for iOS and Android.', ['authyLink' => '<strong><a href="https://authy.com" target="_blank">Authy</a></strong>'])}}
            </div>

            <form role="form">
                <!-- Country Code -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{__('Country Code')}}</label>

                    <div class="col-md-6">
                        <input type="number" class="form-control" name="country_code" v-model="form.country_code" :class="{'is-invalid': form.errors.has('country_code')}">

                        <span class="invalid-feedback" v-show="form.errors.has('country_code')">
                            @{{ form.errors.get('country_code') }}
                        </span>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{__('Phone Number')}}</label>

                    <div class="col-md-6">
                        <input type="tel" class="form-control" name="phone" v-model="form.phone" :class="{'is-invalid': form.errors.has('phone')}">

                        <span class="invalid-feedback" v-show="form.errors.has('phone')">
                            @{{ form.errors.get('phone') }}
                        </span>
                    </div>
                </div>

                <!-- Enable Button -->
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="enable"
                                :disabled="form.busy">

                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Enabling')}}
                            </span>

                            <span v-else>
                                {{__('Enable')}}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-enable-two-factor-auth>
