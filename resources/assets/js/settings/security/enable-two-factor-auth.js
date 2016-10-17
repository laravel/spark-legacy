module.exports = {
	props: ['user'],

    /**
     * The component's data.
     */
	data() {
		return {
			form: new SparkForm({
				country_code: '',
				phone: ''
			})
		}
	},


    /**
     * Prepare the component.
     */
	mounted() {
		this.form.country_code = this.user.country_code;
		this.form.phone = this.user.phone;
	},


	methods: {
		/**
		 * Enable two-factor authentication for the user.
		 */
		enable() {
			Spark.post('/settings/two-factor-auth', this.form)
				.then(code => {
					this.$parent.$emit('receivedTwoFactorResetCode', code);

					Bus.$emit('updateUser');
				});
		}
	}
};
