<spark-create-token :available-abilities="availableAbilities" inline-template>
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

                    <!-- Mass Ability Assignment / Removal -->
                    <div class="form-group" v-if="availableAbilities.length > 0">
                        <label class="col-md-4 control-label">&nbsp;</label>

                        <div class="col-md-6">
                            <button class="btn btn-default" @click.prevent="assignAllAbilities" v-if=" ! allAbilitiesAssigned">
                                <i class="fa fa-btn fa-check"></i>Assign All Abilities
                            </button>

                            <button class="btn btn-default" @click.prevent="removeAllAbilities" v-if="allAbilitiesAssigned">
                                <i class="fa fa-btn fa-times"></i>Remove All Abilities
                            </button>
                        </div>
                    </div>

                    <!-- Token Abilities -->
                    <div class="form-group" :class="{'has-error': form.errors.has('abilities')}" v-if="availableAbilities.length > 0">
                        <label class="col-md-4 control-label">Token Can</label>

                        <div class="col-md-6">
                            <div v-for="ability in availableAbilities">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                            @click="toggleAbility(ability.value)"
                                            :checked="abilityIsAssigned(ability.value)">

                                            @{{ ability.name }}
                                    </label>
                                </div>
                            </div>

                            <span class="help-block" v-show="form.errors.has('abilities')">
                                @{{ form.errors.get('abilities') }}
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

                        <textarea id="api-token" class="form-control"
                                  @click="selectToken"
                                  rows="5">@{{ showingToken }}</textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="selectToken">
                        <span v-if="copyCommandSupported">Copy To Clipboard</span>
                        <span v-else>Select All</span>
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-create-token>
