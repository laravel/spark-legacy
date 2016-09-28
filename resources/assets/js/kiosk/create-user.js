module.exports = {
    props: ['user'],


    /**
     * The component's data.
     */
    data() {
        return {
            userCreated: false,

            password: null,

            form: new SparkForm({
                name: '',
                email: ''
            })
        };
    },


    methods: {
        /**
         * Attempt to create a new user profile.
         */
        createUser() {
            this.form.startProcessing();

            Spark.post('/spark/kiosk/users/create', this.form)
                .then(response => {
                    this.userCreated = true;

                    this.password = response.password;

                    this.form.finishProcessing();

                    this.form.name = '';
                    this.form.email = '';
                });
        }
    }
};
