<spark-create-token :scopes="scopes" inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Create API Token
            </div>

            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <!-- Token Name -->
                    <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                        <label class="col-md-4 control-label">Token Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" v-model="form.name">

                            <span class="help-block" v-show="form.errors.has('name')">
                                @{{ form.errors.get('name') }}
                            </span>
                        </div>
                    </div>

                    <!-- Mass Scope Assignment / Removal -->
                    <div class="form-group" v-if="scopes.length > 0">
                        <label class="col-md-4 control-label">&nbsp;</label>

                        <div class="col-md-6">
                            <button class="btn btn-default" @click.prevent="assignAllScopes" v-if=" ! allScopesAssigned">
                                <i class="fa fa-btn fa-check"></i>Assign All Scopes
                            </button>

                            <button class="btn btn-default" @click.prevent="removeAllScopes" v-if="allScopesAssigned">
                                <i class="fa fa-btn fa-times"></i>Remove All Scopes
                            </button>
                        </div>
                    </div>

                    <!-- Token Scopes -->
                    <div class="form-group" :class="{'has-error': form.errors.has('scopes')}" v-if="scopes.length > 0">
                        <label class="col-md-4 control-label">Token Can</label>

                        <div class="col-md-6">
                            <div v-for="scope in scopes">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                            @click="toggleScope(scope.id)"
                                            :checked="scopeIsAssigned(scope.id)">

                                            @{{ scope.description }}
                                    </label>
                                </div>
                            </div>

                            <span class="help-block" v-show="form.errors.has('scopes')">
                                @{{ form.errors.get('scopes') }}
                            </span>
                        </div>
                    </div>

                    <!-- Create Button -->
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-6">
                            <button type="submit" class="btn btn-primary"
                                    @click.prevent="create"
                                    :disabled="form.busy">

                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Show Token Modal -->
        <div class="modal fade" id="modal-show-token" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="showingToken">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            API Token
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-warning">
                            Here is your new API token. <strong>This is the only time the token will ever
                            be displayed, so be sure not to lose it!</strong> You may revoke the token
                            at any time from your API settings.
                        </div>

                        <pre><code id="api-token">@{{ showingToken }}</code></pre>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-create-token>
