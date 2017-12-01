<spark-update-team-photo :user="user" :team="team" inline-template>
    <div class="card card-default" v-if="user">
        <div class="card-header">
            {{__('teams.team_photo')}}
        </div>

        <div class="card-body">
            <div class="alert alert-danger" v-if="form.errors.has('photo')">
                @{{ form.errors.get('photo') }}
            </div>

            <form role="form">
                <div class="form-group row justify-content-center">
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="image-placeholder mr-4">
                            <span role="img" class="profile-photo-preview" :style="previewStyle"></span>
                        </div>
                        <div class="spark-uploader mr-4">
                            <input ref="photo" type="file" class="spark-uploader-control" name="photo" @change="update" :disabled="form.busy">
                            <div class="btn btn-outline-dark">{{__('Update Photo')}}</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-team-photo>
