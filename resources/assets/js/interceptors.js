module.exports = (request, next) => {
    request.headers.set('X-XSRF-TOKEN', Cookies.get('XSRF-TOKEN'));

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
