<spark-kiosk-create-user :user="user" inline-template>
    <!-- Billing Information -->
    <div class="panel panel-default">
        <div class="panel-heading">Create new User</div>

        <div class="panel-body">

            <div class="alert alert-success" v-if="userCreated">
                A user was created successfully.
                <br>
                Password for the first sign in: <strong>@{{ password }}</strong>
            </div>

            <form class="form-horizontal" role="form">
                <!-- Name -->
                <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                    <label class="col-md-4 control-label">Name</label>

                    <div class="col-md-6">
                        <input type="name" class="form-control" name="name" v-model="form.name" autofocus>

                        <span class="help-block" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                <!-- E-Mail Address -->
                <div class="form-group" :class="{'has-error': form.errors.has('email')}">
                    <label class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" v-model="form.email">

                        <span class="help-block" v-show="form.errors.has('email')">
                            @{{ form.errors.get('email') }}
                        </span>
                    </div>
                </div>

                <!-- Subscribe Button -->
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary" @click.prevent="createUser" :disabled="form.busy">
                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>Registering
                            </span>

                            <span v-else>
                                Register
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-kiosk-create-user>
