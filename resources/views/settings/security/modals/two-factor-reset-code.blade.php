<div class="modal" id="modal-show-two-factor-reset-code" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{__('Two-Factor Authentication Reset Code')}}
                </h5>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning">
                    {{__('If you lose your two-factor authentication device, you may use this emergency reset token to disable two-factor authentication on your account.')}}
                    <strong>{{__('This is the only time this token will be displayed, so be sure not to lose it!')}}</strong>
                </div>

                <pre><code>@{{ twoFactorResetCode }}</code></pre>
            </div>

            <!-- Modal Actions -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
