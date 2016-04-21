<?php

namespace Laravel\Spark\Http\Requests\Settings\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Coupon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Spark\Contracts\Repositories\CouponRepository;

class CreateSubscriptionRequest extends FormRequest
{
    use DeterminesPlanEligibility;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validate the coupon on the request.
     *
     * @param  \Illuminate\Validation\Validator  $valdiator
     * @return void
     */
    protected function validateCoupon($validator)
    {
        if (! app(CouponRepository::class)->valid($this->coupon)) {
            $validator->errors()->add('coupon', 'This coupon code is invalid.');
        }
    }
}
