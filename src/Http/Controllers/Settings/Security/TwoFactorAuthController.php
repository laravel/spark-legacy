<?php

namespace Laravel\Spark\Http\Controllers\Settings\Security;

use Exception;
use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Controller;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Laravel\Spark\Http\Requests\Settings\Security\EnableTwoFactorAuthRequest;
use Laravel\Spark\Contracts\Interactions\Settings\Security\EnableTwoFactorAuth;
use Laravel\Spark\Contracts\Interactions\Settings\Security\DisableTwoFactorAuth;

class TwoFactorAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Enable two-factor authentication for the user.
     *
     * @param  EnableTwoFactorAuthRequest  $request
     * @return Response
     */
    public function enable(EnableTwoFactorAuthRequest $request)
    {
        try {
            Spark::interact(EnableTwoFactorAuth::class, [
                $request->user(), $request->country_code, $request->phone
            ]);

            return $this->storeTwoFactorInformation($request);
        } catch (Exception $e) {
            app(ExceptionHandler::class)->report($e);

            return response()->json([
                'errors' => [
                    'phone' => [
                        __('We were not able to enable two-factor authentication for this phone number.')
                    ]
                ]
            ], 422);
        }
    }

    /**
     * Store the two-factor authentication information on the user instance.
     *
     * @param  EnableTwoFactorAuthRequest  $request
     * @return string
     */
    protected function storeTwoFactorInformation($request)
    {
        $request->user()->forceFill([
            'uses_two_factor_auth' => true,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'two_factor_reset_code' => bcrypt($code = str_random(40)),
        ])->save();

        return $code;
    }

    /**
     * Disable two-factor authentication for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function disable(Request $request)
    {
        Spark::interact(DisableTwoFactorAuth::class, [$request->user()]);

        $request->user()->forceFill([
            'uses_two_factor_auth' => false,
        ])->save();
    }
}
