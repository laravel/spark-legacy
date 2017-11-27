<spark-kiosk-announcements inline-template>
    <div>
        <div class="card card-default">
            <div class="card-header">{{__('Create Announcement')}}</div>

            <div class="card-body">
                <div class="alert alert-info">
                    {{__('Announcements you create here will be sent to the "Product Announcements" section of the notifications modal window, informing your users about new features and improvements to your application.')}}
                </div>

                <form role="form">
                    <!-- Announcement -->
                    <div class="form-group row" :class="{'is-invalid': createForm.errors.has('body')}">
                        <label class="col-md-4 col-form-label text-md-right">{{__('Announcement')}}</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="announcement" rows="7" v-model="createForm.body" style="font-family: monospace;">
                            </textarea>

                            <span class="invalid-feedback" v-show="createForm.errors.has('body')">
                                @{{ createForm.errors.get('body') }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Text -->
                    <div class="form-group row" :class="{'is-invalid': createForm.errors.has('action_text')}">
                        <label class="col-md-4 col-form-label text-md-right">{{__('Action Button Text')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="action_text" v-model="createForm.action_text">

                            <span class="invalid-feedback" v-show="createForm.errors.has('action_text')">
                                @{{ createForm.errors.get('action_text') }}
                            </span>
                        </div>
                    </div>

                    <!-- Action URL -->
                    <div class="form-group row" :class="{'is-invalid': createForm.errors.has('action_url')}">
                        <label class="col-md-4 col-form-label text-md-right">{{__('Action Button URL')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="action_url" v-model="createForm.action_url">

                            <span class="invalid-feedback" v-show="createForm.errors.has('action_url')">
                                @{{ createForm.errors.get('action_url') }}
                            </span>
                        </div>
                    </div>

                    <!-- Create Button -->
                    <div class="form-group row">
                        <div class="offset-md-4 col-md-6">
                            <button type="submit" class="btn btn-primary"
                                    @click.prevent="create"
                                    :disabled="createForm.busy">

                                {{__('Create')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Announcements List -->
        <div class="card card-default" v-if="announcements.length > 0">
            <div class="card-header">{{__('Recent Announcements')}}</div>

            <div class="table-responsive">
                <table class="table table-valign-middle mb-0">
                    <thead>
                        <th class="th-fit"></th>
                        <th>{{__('Date')}}</th>
                        <th>{{__('Announcement')}}</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        <tr class="reveal" v-for="announcement in announcements">
                            <!-- Photo -->
                            <td>
                                <img :src="announcement.creator.photo_url" class="spark-profile-photo">
                            </td>

                            <!-- Date -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ announcement.created_at | datetime }}
                                </div>
                            </td>

                            <!-- Body -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ _.truncate(announcement.body, {length: 45}) }}
                                </div>
                            </td>

                            <!-- Edit Button -->
                            <td class="td-fit">
                                <div class="reveal-target text-right">
                                    <button class="btn-reset" @click="editAnnouncement(announcement)">
                                        <svg class="icon-20 icon-sidenav " xmlns="http://www.w3.org/2000/svg ">
                                            <path fill="#95A2AE" d="M12.3 3.7L0 16v4h4L16.3 7.7l-4-4zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/>
                                        </svg>
                                    </button>

                                    <button class="btn-reset" @click="approveAnnouncementDelete(announcement)">
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

        <!-- Edit Announcement Modal -->
        <div class="modal" id="modal-update-announcement" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" v-if="updatingAnnouncement">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Update Announcement')}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <!-- Update Announcement -->
                        <form role="form">
                            <!-- Announcement -->
                            <div class="form-group row" :class="{'is-invalid': updateForm.errors.has('body')}">
                                <label class="col-md-4 col-form-label text-md-right">{{__('Announcement')}}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" rows="7" v-model="updateForm.body" style="font-family: monospace;">
                                    </textarea>

                                    <span class="invalid-feedback" v-show="updateForm.errors.has('body')">
                                        @{{ updateForm.errors.get('body') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Text -->
                            <div class="form-group row" :class="{'is-invalid': updateForm.errors.has('action_text')}">
                                <label class="col-md-4 col-form-label text-md-right">{{__('Action Button Text')}}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="action_text" v-model="updateForm.action_text">

                                    <span class="invalid-feedback" v-show="updateForm.errors.has('action_text')">
                                        @{{ updateForm.errors.get('action_text') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action URL -->
                            <div class="form-group row" :class="{'is-invalid': updateForm.errors.has('action_url')}">
                                <label class="col-md-4 col-form-label text-md-right">{{__('Action Button URL')}}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="action_url" v-model="updateForm.action_url">

                                    <span class="invalid-feedback" v-show="updateForm.errors.has('action_url')">
                                        @{{ updateForm.errors.get('action_url') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>

                        <button type="button" class="btn btn-primary" @click="update" :disabled="updateForm.busy">
                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Announcement Modal -->
        <div class="modal" id="modal-delete-announcement" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingAnnouncement">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Delete Announcement')}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{__('Are you sure you want to delete this announcement?')}}
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-danger" @click="deleteAnnouncement" :disabled="deleteForm.busy">
                            {{__('Yes, Delete')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-kiosk-announcements>
