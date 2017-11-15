<spark-cancel-subscription :user="user" :team="team" :billable-type="billableType" inline-template>
    <div>
        <div class="card card-default">
            <div class="card-body">
                <button class="btn btn-outline-danger"
                @click="confirmCancellation"
                :disabled="form.busy">

                Cancel Subscription
                </button>
            </div>
        </div>

        <!-- Confirm Cancellation Modal -->
        <div class="modal" id="modal-confirm-cancellation" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Cancel Subscription
                        </h5>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to cancel your subscription?
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                        <button type="button" class="btn btn-danger" @click="cancel" :disabled="form.busy">
                        <span v-if="form.busy">
                            <i class="fa fa-btn fa-spinner fa-spin"></i> Cancelling
                        </span>

                        <span v-else>
                            Yes, Cancel
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-cancel-subscription>
