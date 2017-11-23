<spark-update-extra-billing-information :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Extra Billing Information')}}</div>

        <div class="card-body">
            <!-- Information Message -->
            <div class="alert alert-info">
                {{__('This information will appear on all of your receipts, and is a great place to add your full business name, VAT number, or address of record. Do not include any confidential or financial information such as credit card numbers.')}}
            </div>

            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('Your billing information has been updated!')}}
            </div>

            <!-- Extra Billing Information -->
            <form role="form">
                <div class="form-group row">
                    <div class="col-md-12">
                        <textarea class="form-control" rows="7" v-model="form.information" style="font-family: monospace;" :class="{'is-invalid': form.errors.has('information')}"></textarea>

                        <span class="invalid-feedback" v-show="form.errors.has('information')">
                            @{{ form.errors.get('information') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="offset-md-4 col-md-8 text-right">
                        <button type="submit" class="btn btn-primary" @click.prevent="update" :disabled="form.busy">
                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-extra-billing-information>
