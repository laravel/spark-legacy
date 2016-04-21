
/**
 * Layout Components...
 */
require('./navbar/navbar');
require('./notifications/notifications');

/**
 * Authentication Components...
 */
require('./auth/register-stripe');
require('./auth/register-braintree');

/**
 * Settings Component...
 */
require('./settings/settings');

/**
 * Profile Settings Components...
 */
require('./settings/profile');
require('./settings/profile/update-profile-photo');
require('./settings/profile/update-contact-information');

/**
 * Teams Settings Components...
 */
require('./settings/teams');
require('./settings/teams/create-team');
require('./settings/teams/pending-invitations');
require('./settings/teams/current-teams');
require('./settings/teams/team-settings');
require('./settings/teams/team-profile');
require('./settings/teams/update-team-photo');
require('./settings/teams/update-team-name');
require('./settings/teams/team-membership');
require('./settings/teams/send-invitation');
require('./settings/teams/mailed-invitations');
require('./settings/teams/team-members');

/**
 * Security Settings Components...
 */
require('./settings/security');
require('./settings/security/update-password');
require('./settings/security/enable-two-factor-auth');
require('./settings/security/disable-two-factor-auth');

/**
 * API Settings Components...
 */
require('./settings/api');
require('./settings/api/create-token');
require('./settings/api/tokens');

/**
 * Subscription Settings Components...
 */
require('./settings/subscription');
require('./settings/subscription/subscribe-stripe');
require('./settings/subscription/subscribe-braintree');
require('./settings/subscription/update-subscription');
require('./settings/subscription/resume-subscription');
require('./settings/subscription/cancel-subscription');

/**
 * Payment Method Components...
 */
require('./settings/payment-method-stripe');
require('./settings/payment-method-braintree');
require('./settings/payment-method/update-vat-id');
require('./settings/payment-method/update-payment-method-stripe');
require('./settings/payment-method/update-payment-method-braintree');
require('./settings/payment-method/redeem-coupon');

/**
 * Billing History Components...
 */
require('./settings/invoices');
require('./settings/invoices/update-extra-billing-information');
require('./settings/invoices/invoice-list');

/**
 * Kiosk Components...
 */
require('./kiosk/kiosk');
require('./kiosk/announcements');
require('./kiosk/metrics');
require('./kiosk/users');
require('./kiosk/profile');
require('./kiosk/add-discount');
