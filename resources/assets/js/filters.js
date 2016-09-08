/**
 * Format the given date.
 */
Vue.filter('date', value => {
    return moment.utc(value).local().format('MMMM Do, YYYY')
});


/**
 * Format the given date as a timestamp.
 */
Vue.filter('datetime', value => {
    return moment.utc(value).local().format('MMMM Do, YYYY h:mm A');
});


/**
 * Format the given date into a relative time.
 */
Vue.filter('relative', value => {
    return moment.utc(value).local().locale('en-short').fromNow();
});
