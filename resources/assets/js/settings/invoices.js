module.exports = {
	props: ['user', 'team', 'billableType'],

	/**
	 * The component's data.
	 */
	data() {
		return {
			invoices: []
		};
	},


	/**
	 * Prepare the component.
	 */
	mounted() {
		this.getInvoices();
	},


	methods: {
		/**
		 * Get the user's billing invoices
		 */
		getInvoices() {
			axios.get(this.urlForInvoices)
				.then(response => {
					this.invoices = _.filter(response.data, invoice => {
						return invoice.total != '$0.00';
					});
				});
		}
	},


	computed: {
		/**
		 * Get the URL for retrieving the invoices.
		 */
		urlForInvoices() {
			return this.billingUser
							? '/settings/invoices'
							: `/settings/${Spark.teamsPrefix}/${this.team.id}/invoices`;
		}
	}
};
