<spark-update-extra-billing-information :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">Extra Billing Information</div>

        <div class="panel-body">
            <!-- Information Message -->
            <div class="alert alert-info">
                This information will appear on all of your receipts, and is a great place to add your full
                business name, VAT number, or address of record. Do not include any confidential or
                financial information such as credit card numbers.
            </div>

            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your billing information has been updated!
            </div>

            <!-- Extra Billing Information -->
            <form class="form-horizontal" role="form">
                <div class="form-group" :class="{'has-error': form.errors.has('information')}">
                    <div class="col-md-12">
                        <textarea class="form-control" rows="7" v-model="form.information" style="font-family: monospace;"></textarea>

                        <span class="help-block" v-show="form.errors.has('information')">
                            @{{ form.errors.get('information') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group m-b-none">
                    <div class="col-md-offset-4 col-md-8 text-right">
                        <button type="submit" class="btn btn-primary" @click.prevent="update" :disabled="form.busy">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-extra-billing-information>
