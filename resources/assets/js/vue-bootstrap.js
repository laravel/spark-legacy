/*
 * Load Vue & Vue-Resource.
 *
 * Vue is the JavaScript framework used by Spark.
 */
if (window.Vue === undefined) {
    window.Vue = require('vue');

    window.Bus = new Vue();
}

require('vue-resource');

/**
 * Load Vue HTTP Interceptors.
 */
Vue.http.interceptors.push(require('./interceptors'));

/**
 * Load Vue Global Mixin.
 */
Vue.mixin(require('./mixin'));

/**
 * Define the Vue filters.
 */
require('./filters');

/**
 * Load the Spark form utilities.
 */
require('./forms/bootstrap');
