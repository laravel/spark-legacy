<div class="modal fade" id="modal-show-two-factor-reset-code" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">
                    Two-Factor Authentication Reset Code
                </h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning">
                    If you lose your two-factor authentication device, you may use this
                    emergency reset token to disable two-factor authentication on your account.
                    <strong>This is the only time this token will be displayed, so be sure not
                    to lose it!</strong>
                </div>

                <pre><code>@{{ twoFactorResetCode }}</code></pre>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
