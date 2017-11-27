<spark-redeem-coupon :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Redeem Coupon')}}</div>

        <div class="card-body">
            <div class="alert alert-success" v-if="form.successful">
                {{__('Coupon accepted! The discount will be applied to your next invoice.')}}
            </div>

            <form role="form">
                <!-- Coupon Code -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Coupon Code')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="coupon" v-model="form.coupon" :class="{'is-invalid': form.errors.has('coupon')}">

                        <span class="invalid-feedback" v-show="form.errors.has('coupon')">
                            @{{ form.errors.get('coupon') }}
                        </span>
                    </div>
                </div>

                <!-- Redeem Button -->
                <div class="form-group row mb-0">
                    <div class="offset-md-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="redeem"
                                :disabled="form.busy">

                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Redeeming')}}
                            </span>

                            <span v-else>
                                {{__('Redeem')}}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-redeem-coupon>
