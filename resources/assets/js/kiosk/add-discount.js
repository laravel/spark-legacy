function kioskAddDiscountForm () {
    return {
        type: 'amount',
        value: null,
        duration: 'once',
        months: null
    };
}

module.exports = {
    mixins: [require('./../mixins/discounts')],


    /**
     * The component's data.
     */
    data() {
        return {
            loadingCurrentDiscount: false,
            currentDiscount: null,

            discountingUser: null,
            form: new SparkForm(kioskAddDiscountForm())
        };
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        Bus.$on('addDiscount', function (user) {
            self.form = new SparkForm(kioskAddDiscountForm());

            self.setUser(user);

            $('#modal-add-discount').modal('show');
        });
    },


    methods: {
        /**
         * Set the user receiving teh discount.
         */
        setUser(user) {
            this.discountingUser = user;

            this.getCurrentDiscountForUser(user);
        },


        /**
         * Apply the discount to the user.
         */
        applyDiscount() {
            Spark.post('/spark/kiosk/users/discount/' + this.discountingUser.id, this.form)
                .then(() => {
                    $('#modal-add-discount').modal('hide');
                });
        },
    }
};
