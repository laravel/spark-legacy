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
	ready() {
		this.getInvoices();
	},


	methods: {
		/**
		 * Get the user's billing invoices
		 */
		getInvoices() {
			this.$http.get(this.urlForInvoices)
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
							: `/settings/${Spark.pluralTeamString}/${this.team.id}/invoices`;
		}
	}
};
