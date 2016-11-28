<?php

namespace Laravel\Spark\Http\Controllers\Kiosk;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Contracts\Http\Requests\Kiosk\CreateUserRequest;
use Laravel\Spark\Contracts\Repositories\PerformanceIndicatorsRepository;

class ProfileController extends Controller
{
    /**
     * The performance indicators repository instance.
     *
     * @var PerformanceIndicatorsRepository
     */
    protected $indicators;

    /**
     * Create a new controller instance.
     *
     * @param  PerformanceIndicatorsRepository  $indicators
     * @return void
     */
    public function __construct(PerformanceIndicatorsRepository $indicators)
    {
        $this->indicators = $indicators;

        $this->middleware('auth');
        $this->middleware('dev');
    }

    /**
     * Get the user to be displayed on the user profile screen.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $user = Spark::call(UserRepository::class.'@find', [$id]);

        return response()->json([
            'user' => $user,
            'revenue' => $this->indicators->totalRevenueForUser($user),
        ]);
    }

    /**
     * Create a new user profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(CreateUserRequest $request)
    {
        $data = $request->all();

        $data['password'] = str_random();

        $user = Spark::interact(UserRepository::class.'@create', [$data]);

        return response()->json([
            'user' => $user,
            'password' => $data['password'],
        ]);
    }
}
