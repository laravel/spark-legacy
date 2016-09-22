<spark-pending-invitations inline-template>
    <div>
        <div class="panel panel-default" v-if="invitations.length > 0">
            <div class="panel-heading">Pending Invitations</div>

            <div class="panel-body">
                <table class="table table-borderless m-b-none">
                    <thead>
                        <th>{{ ucfirst(Spark::teamString()) }}</th>
                        <th></th>
                        <th></th>
                    </thead>

                    <tbody>
                        <tr v-for="invitation in invitations">
                            <!-- Team Name -->
                            <td>
                                <div class="btn-table-align">
                                    @{{ invitation.team.name }}
                                </div>
                            </td>

                            <!-- Accept Button -->
                            <td>
                                <button class="btn btn-success" @click="accept(invitation)">
                                    <i class="fa fa-check"></i>
                                </button>
                            </td>

                            <!-- Reject Button -->
                            <td>
                                <button class="btn btn-danger-outline" @click="reject(invitation)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</spark-pending-invitations>
