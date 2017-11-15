<!-- Customer Support -->
<div class="modal" id="modal-support" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-b-none">
                <form role="form">
                    <!-- From -->
                    <div class="form-group" :class="{'is-invalid': supportForm.errors.has('from')}">
                        <input id="support-from" type="text" class="form-control" v-model="supportForm.from" placeholder="Your Email Address">

                        <span class="invalid-feedback" v-show="supportForm.errors.has('from')">
                            @{{ supportForm.errors.get('from') }}
                        </span>
                    </div>

                    <!-- Subject -->
                    <div class="form-group" :class="{'is-invalid': supportForm.errors.has('subject')}">
                        <input id="support-subject" type="text" class="form-control" v-model="supportForm.subject" placeholder="Subject">

                        <span class="invalid-feedback" v-show="supportForm.errors.has('subject')">
                            @{{ supportForm.errors.get('subject') }}
                        </span>
                    </div>

                    <!-- Message -->
                    <div class="form-group m-b-none" :class="{'is-invalid': supportForm.errors.has('message')}">
                        <textarea class="form-control" rows="7" v-model="supportForm.message" placeholder="Message"></textarea>

                        <span class="invalid-feedback" v-show="supportForm.errors.has('message')">
                            @{{ supportForm.errors.get('message') }}
                        </span>
                    </div>
                </form>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer border-none">
                <button type="button" class="btn btn-primary" @click.prevent="sendSupportRequest" :disabled="supportForm.busy">
                    <i class="fa fa-btn fa-paper-plane"></i> Send
                </button>
            </div>
        </div>
    </div>
</div>
