module.exports = (request, next) => {
    console.log(request.headers);
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

        if (response.headers.get('content-type') === 'application/json') {
            response.json().then(data => {
                response.data = data;
            });
        } else {
            response.text().then(data => {
                response.data = data;
            });
        }
    });
};
