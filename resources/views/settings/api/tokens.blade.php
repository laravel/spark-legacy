<spark-tokens :tokens="tokens" :scopes="scopes" inline-template>
    <div>
        <div>
            <div class="panel panel-default" v-if="tokens.length > 0">
                <div class="panel-heading">API Tokens</div>

                <div class="panel-body">
                    <table class="table table-borderless m-b-none">
                        <thead>
                            <th>Name</th>
                            <th>Last Used</th>
                            <th></th>
                        </thead>

                        <tbody>
                            <tr v-for="token in tokens">
                                <!-- Name -->
                                <td>
                                    <div class="btn-table-align">
                                        @{{ token.name }}
                                    </div>
                                </td>

                                <!-- Last Used At -->
                                <td>
                                    <div class="btn-table-align">
                                        <span v-if="token.last_used_at">
                                            @{{ token.last_used_at | datetime }}
                                        </span>

                                        <span v-else>
                                            Never
                                        </span>
                                    </div>
                                </td>

                                <!-- Delete Button -->
                                <td>
                                    <button class="btn btn-danger-outline" @click="approveTokenRevoke(token)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Revoke Token Modal -->
        <div class="modal fade" id="modal-revoke-token" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="revokingToken">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Delete Token (@{{ revokingToken.name }})
                        </h4>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this token? If deleted, API requests that attempt to
                        authenticate using this token will no longer be accepted.
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                        <button type="button" class="btn btn-danger" @click="revokeToken" :disabled="revokeTokenForm.busy">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-tokens>
