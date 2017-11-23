<spark-tokens :tokens="tokens" :available-abilities="availableAbilities" inline-template>
    <div>
        <div>
            <div class="card card-default" v-if="tokens.length > 0">
                <div class="card-header">{{__('API Tokens')}}</div>

                <div class="table-responsive">
                    <table class="table table-valign-middle mb-0">
                        <thead>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Created')}}</th>
                            <th>{{__('Last Used')}}</th>
                            <th>&nbsp;</th>
                        </thead>

                        <tbody>
                        <tr class="reveal" v-for="token in tokens">
                            <!-- Name -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ token.name }}
                                </div>
                            </td>

                            <!-- Created At -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ token.created_at | datetime }}
                                </div>
                            </td>

                            <!-- Last Used At -->
                            <td>
                                <div class="btn-table-align">
                                        <span v-if="token.last_used_at">
                                            @{{ token.last_used_at | datetime }}
                                        </span>

                                        <span v-else>
                                            {{__('Never')}}
                                        </span>
                                </div>
                            </td>

                            <!-- Edit Button -->
                            <td class="td-fit">
                                <div class="reveal-target text-right ">
                                    <button class="btn-reset" @click="editToken(token)">
                                        <svg class="icon-20 icon-sidenav " xmlns="http://www.w3.org/2000/svg ">
                                            <path fill="#95A2AE" d="M12.3 3.7L0 16v4h4L16.3 7.7l-4-4zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
                                        </svg>
                                    </button>

                                    <button class="btn-reset" @click="approveTokenDelete(token)">
                                        <svg class="icon-20 icon-sidenav " xmlns="http://www.w3.org/2000/svg ">
                                            <path fill="#95A2AE " d="M4 2l2-2h4l2 2h4v2H0V2h4zM1 6h14l-1 14H2L1 6zm5 2v10h1V8H6zm3 0v10h1V8H9z " />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Update Token Modal -->
        <div class="modal" id="modal-update-token" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" v-if="updatingToken">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Edit Token')}} (@{{ updatingToken.name }})
                        </h5>
                    </div>

                    <div class="modal-body">
                        <!-- Update Token Form -->
                        <form role="form">
                            <!-- Token Name -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__('Token Name')}}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="updateTokenForm.name" :class="{'is-invalid': updateTokenForm.errors.has('name')}">

                                    <span class="invalid-feedback" v-show="updateTokenForm.errors.has('name')">
                                        @{{ updateTokenForm.errors.get('name') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Token Abilities -->
                            <div class="form-group row" v-if="availableAbilities.length > 0">
                                <label class="col-md-4 col-form-label">{{__('Token Can')}}</label>

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

                                    <span class="invalid-feedback" v-show="updateTokenForm.errors.has('abilities')">
                                        @{{ updateTokenForm.errors.get('abilities') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>

                        <button type="button" class="btn btn-primary" @click="updateToken" :disabled="updateTokenForm.busy">
                        {{__('Update')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Token Modal -->
        <div class="modal" id="modal-delete-token" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingToken">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Delete Token')}} (@{{ deletingToken.name }})
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('Are you sure you want to delete this token? If deleted, API requests that attempt to authenticate using this token will no longer be accepted.')}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-danger" @click="deleteToken" :disabled="deleteTokenForm.busy">
                        {{__('Yes, Delete')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-tokens>
