module.exports = (request, next) => {

    if (Cookies.get('XSRF-TOKEN') !== undefined) {
        request.headers.set('X-XSRF-TOKEN', Cookies.get('XSRF-TOKEN'));
    }

    request.headers.set('X-CSRF-TOKEN', Spark.csrfToken);

    /**
     * Intercept the incoming responses.
     *
     * Handle any unexpected HTTP errors and pop up modals, etc.
     */
    next(response => {
        switch (response.status) {
            case 401:
                Vue.http.get('/logout');
                $('#modal-session-expired').modal('show');
                break;

            case 402:
                window.location = '/settings#/subscription';
                break;
        }

    });
};
