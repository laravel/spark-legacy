<spark-kiosk-add-discount inline-template>
    <div>
        <div class="modal fade" id="modal-add-discount" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="discountingUser">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            @lang('Add Discount') (@{{ discountingUser.name }})
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Current Discount -->
                        <div class="alert alert-success" v-if="currentDiscount">
                            @lang('This user has a discount of :discount for :duration.', ['discount' => '@{{ formattedDiscount(currentDiscount) }}', 'duration' => '@{{ formattedDiscountDuration(currentDiscount) }}'])
                        </div>

                        <!-- Add Discount Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Discount Type -->
                            <div class="form-group" :class="{'has-error': form.errors.has('type')}">
                                <label class="col-sm-4 control-label">@lang('Discount Type')</label>

                                <div class="col-sm-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="amount" v-model="form.type">&nbsp;&nbsp;@lang('Amount')
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="percent" v-model="form.type">&nbsp;&nbsp;@lang('Percentage')
                                        </label>
                                    </div>

                                    <span class="help-block" v-show="form.errors.has('type')">
                                        @{{ form.errors.get('type') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Discount Value -->
                            <div class="form-group" :class="{'has-error': form.errors.has('value')}">
                                <label class="col-md-4 control-label">
                                    <span v-if="form.type == 'percent'">@lang('Percentage')</span>

                                    <span v-if="form.type == 'amount'">@lang('Amount')</span>
                                </label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="form.value">

                                    <span class="help-block" v-show="form.errors.has('value')">
                                        @{{ form.errors.get('value') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Discount Duration -->
                            <div class="form-group" :class="{'has-error': form.errors.has('duration')}">
                                <label class="col-sm-4 control-label">@lang('Discount Duration')</label>

                                <div class="col-sm-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="once" v-model="form.duration">&nbsp;&nbsp;@lang('Once')
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="forever" v-model="form.duration">&nbsp;&nbsp;@lang('Forever')
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="repeating" v-model="form.duration">&nbsp;&nbsp;@lang('Multiple Months')
                                        </label>
                                    </div>

                                    <span class="help-block" v-show="form.errors.has('duration')">
                                        @{{ form.errors.get('duration') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Duration Months -->
                            <div class="form-group" :class="{'has-error': form.errors.has('months')}" v-if="form.duration == 'repeating'">
                                <label class="col-md-4 control-label">
                                    @lang('Months')
                                </label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="form.months">

                                    <span class="help-block" v-show="form.errors.has('months')">
                                        @{{ form.errors.get('months') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>

                        <button type="button" class="btn btn-primary" @click="applyDiscount" :disabled="form.busy">
                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>@lang('Applying')
                            </span>

                            <span v-else>
                                @lang('Apply Discount')
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-kiosk-add-discount>
