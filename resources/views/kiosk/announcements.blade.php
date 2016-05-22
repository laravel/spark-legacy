<spark-kiosk-announcements inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Create Announcement</div>

            <div class="panel-body">
                <div class="alert alert-info">
                    Announcements you create here will be sent to the "Product Announcements" section of
                    the notifications modal window, informing your users about new features and improvements
                    to your application.
                </div>

                <form class="form-horizontal" role="form">
                    <!-- Announcement -->
                    <div class="form-group" :class="{'has-error': createForm.errors.has('body')}">
                        <label class="col-md-4 control-label">Announcement</label>

                        <div class="col-md-6">
                            <textarea class="form-control" name="announcement" rows="7" v-model="createForm.body" style="font-family: monospace;">
                            </textarea>

                            <span class="help-block" v-show="createForm.errors.has('body')">
                                @{{ createForm.errors.get('body') }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Text -->
                    <div class="form-group" :class="{'has-error': createForm.errors.has('action_text')}">
                        <label class="col-md-4 control-label">Action Button Text</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="action_text" v-model="createForm.action_text">

                            <span class="help-block" v-show="createForm.errors.has('action_text')">
                                @{{ createForm.errors.get('action_text') }}
                            </span>
                        </div>
                    </div>

                    <!-- Action URL -->
                    <div class="form-group" :class="{'has-error': createForm.errors.has('action_url')}">
                        <label class="col-md-4 control-label">Action Button URL</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="action_url" v-model="createForm.action_url">

                            <span class="help-block" v-show="createForm.errors.has('action_url')">
                                @{{ createForm.errors.get('action_url') }}
                            </span>
                        </div>
                    </div>

                    <!-- Create Button -->
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-6">
                            <button type="submit" class="btn btn-primary"
                                    @click.prevent="create"
                                    :disabled="createForm.busy">

                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Announcements List -->
        <div class="panel panel-default" v-if="announcements.length > 0">
            <div class="panel-heading">Recent Announcements</div>

            <div class="panel-body">
                <table class="table table-borderless m-b-none">
                    <thead>
                        <th></th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                    </thead>

                    <tbody>
                        <tr v-for="announcement in announcements">
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

                            <!-- Edit Button -->
                            <td>
                                <button class="btn btn-primary" @click="editAnnouncement(announcement)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </td>

                            <!-- Delete Button -->
                            <td>
                                <button class="btn btn-danger-outline" @click="approveAnnouncementDelete(announcement)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Announcement Modal -->
        <div class="modal fade" id="modal-update-announcement" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" v-if="updatingAnnouncement">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Update Announcement
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Update Announcement -->
                        <form class="form-horizontal" role="form">
                            <!-- Announcement -->
                            <div class="form-group" :class="{'has-error': updateForm.errors.has('body')}">
                                <label class="col-md-4 control-label">Announcement</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" rows="7" v-model="updateForm.body" style="font-family: monospace;">
                                    </textarea>

                                    <span class="help-block" v-show="updateForm.errors.has('body')">
                                        @{{ updateForm.errors.get('body') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Text -->
                            <div class="form-group" :class="{'has-error': updateForm.errors.has('action_text')}">
                                <label class="col-md-4 control-label">Action Button Text</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="action_text" v-model="updateForm.action_text">

                                    <span class="help-block" v-show="updateForm.errors.has('action_text')">
                                        @{{ updateForm.errors.get('action_text') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action URL -->
                            <div class="form-group" :class="{'has-error': updateForm.errors.has('action_url')}">
                                <label class="col-md-4 control-label">Action Button URL</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="action_url" v-model="updateForm.action_url">

                                    <span class="help-block" v-show="updateForm.errors.has('action_url')">
                                        @{{ updateForm.errors.get('action_url') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update" :disabled="updateForm.busy">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Announcement Modal -->
        <div class="modal fade" id="modal-delete-announcement" tabindex="-1" role="dialog">
            <div class="modal-dialog" v-if="deletingAnnouncement">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Delete Announcement
                        </h4>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this announcement?
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                        <button type="button" class="btn btn-danger" @click="delete" :disabled="deleteForm.busy">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-kiosk-announcements>
