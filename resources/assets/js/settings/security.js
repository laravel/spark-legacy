module.exports = {
    props: ['user'],


    /**
     * The component's data.
     */
    data() {
        return {
            twoFactorResetCode: null
        };
    },


    events: {
        /**
         * Display the received two-factor authentication code.
         */
        receivedTwoFactorResetCode(code) {
            this.twoFactorResetCode = code;

            $('#modal-show-two-factor-reset-code').modal('show');
        }
    }
};
