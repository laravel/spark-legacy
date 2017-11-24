<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams\Subscription;

use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Spark\Contracts\Repositories\CouponRepository;

class CreateSubscriptionRequest extends FormRequest
{
    use DeterminesTeamPlanEligibility;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->ownsTeam($this->route('team'));
    }

    /**
     * Get the validator instance for the request.
     *
     * @param  array  $rules
     * @return \Illuminate\Validation\Validator
     */
    public function baseValidator(array $rules)
    {
        $validator = Validator::make($this->all(), array_merge([
            'plan' => 'required|in:'.Spark::activeTeamPlanIdList()
        ], $rules));

        return $validator->after(function ($validator) {
            $this->validatePlanEligibility($validator);

            if ($this->coupon) {
                $this->validateCoupon($validator);
            }
        });
    }

    /**
     * Validate the coupon on the request.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateCoupon($validator)
    {
        if (! app(CouponRepository::class)->valid($this->coupon)) {
            $validator->errors()->add('coupon', __('This coupon code is invalid.'));
        }
    }

    /**
     * Get the Spark plan associated with the request.
     *
     * @return \Laravel\Spark\Plan
     */
    public function plan()
    {
        return Spark::teamPlans()->where('id', $this->plan)->first();
    }
}
