module.exports = {
    props: ['user'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: $.extend(true, new SparkForm({
                name: '',
                email: ''
            }), Spark.forms.updateContactInformation)
        };
    },


    /**
     * Bootstrap the component.
     */
    ready() {
        this.form.name = this.user.name;
        this.form.email = this.user.email;
    },


    methods: {
        /**
         * Update the user's contact information.
         */
        update() {
            Spark.put('/settings/contact', this.form)
                .then(() => {
                    this.$dispatch('updateUser');
                });
        }
    }
};
