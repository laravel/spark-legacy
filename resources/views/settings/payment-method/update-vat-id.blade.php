<spark-update-vat-id :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="card card-default">
        <div class="card-header">Update VAT ID</div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your VAT ID has been updated!
            </div>

            <form role="form">
                <!-- VAT ID -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">VAT ID</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="vat_id" v-model="form.vat_id" :class="{'is-invalid': form.errors.has('vat_id')}">

                        <span class="invalid-feedback" v-show="form.errors.has('vat_id')">
                            @{{ form.errors.get('vat_id') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group row">
                    <div class="offset-md-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> Updating
                            </span>

                            <span v-else>
                                Update
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-vat-id>
