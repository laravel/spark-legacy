<spark-disable-two-factor-auth :user="user" inline-template>
    <div class="panel panel-default">
        <div class="panel-body">
            <button class="btn btn-danger-outline" @click="disable" :disabled="form.busy">
                <span v-if="form.busy">
                    <i class="fa fa-btn fa-spinner fa-spin"></i>Disabling
                </span>

                <span v-else>
                    Disable Two-Factor Authentication
                </span>
            </button>
        </div>
    </div>
</spark-disable-two-factor-auth>
