<div class="modal" id="modal-plan-details" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" v-if="detailingPlan">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    @{{ detailingPlan.name }}
                </h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <ul class="plan-feature-list p-0 m-0">
                    <li v-for="feature in detailingPlan.features">
                        @{{ feature }}
                    </li>
                </ul>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
