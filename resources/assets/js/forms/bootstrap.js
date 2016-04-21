/**
 * Initialize the Spark form extension points.
 */
Spark.forms = {
    register: {},
    updateContactInformation: {},
    updateTeamMember: {}
};

/**
 * Load the SparkForm helper class.
 */
require('./form');

/**
 * Define the SparkFormError collection class.
 */
require('./errors');

/**
 * Add additional HTTP / form helpers to the Spark object.
 */
$.extend(Spark, require('./http'));
