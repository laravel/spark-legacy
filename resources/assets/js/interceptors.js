module.exports = {
    /**
     * Intercept the outgoing requests.
     *
     * Set common headers on the request.
     */
    request(request) {
        request.headers['X-XSRF-TOKEN'] = Cookies.get('XSRF-TOKEN');

        return request;
    },


    /**
     * Intercept the incoming responses.
     *
     * Handle any unexpected HTTP errors and pop up modals, etc.
     */
    response(response) {
        switch (response.status) {
            case 401:
                Vue.http.get('/logout');
                $('#modal-session-expired').modal('show');
                break;

            case 402:
                window.location = '/settings#/subscription';
                break;
        }

        return response;
    }
};
