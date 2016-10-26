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


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        this.$on('receivedTwoFactorResetCode', function (code) {
            self.twoFactorResetCode = code;

            $('#modal-show-two-factor-reset-code').modal('show');
        });
    }
};
