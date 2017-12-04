module.exports = {
    props: ['user', 'team', 'billableType'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({ vat_id: '' })
        };
    },


    /**
     * Bootstrap the component.
     */
    mounted() {
        this.form.vat_id = this.billable.vat_id;
    },


    methods: {
        /**
         * Update the customer's VAT ID.
         */
        update() {
            Spark.put(this.urlForUpdate, this.form);
        }
    },


    computed: {
        /**
         * Get the URL for the VAT ID update.
         */
        urlForUpdate() {
            return this.billingUser
                            ? '/settings/payment-method/vat-id'
                            : `/settings/${Spark.teamsPrefix}/${this.team.id}/payment-method/vat-id`;
        }
    }
}
