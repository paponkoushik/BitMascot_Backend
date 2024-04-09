<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function login(array $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $this->model = Auth::user();
            $this->setAttrs([
                'otp_code' => mt_rand(100000, 999999),
                'otp_expires_at' => Carbon::now()->addMinutes(5)
            ]);
            $this->model->fill($this->getAttrs())->save();

            event(new SendOTPEvent($user, $otp));

            return response()->json(['message' => 'OTP sent to your email']);

            $token = JWTAuth::fromUser(Auth::user());
            return response()->json(compact('token'));
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function verifyOTP(): JsonResponse
    {
        if ($this->model->otp_code === $this->getAttr('otp') && now()->lt($this->model->otp_expires_at)) {
            $this->mergeAttrs(['otp_code'=> null, 'otp_expires_at' => null]);
            $this->model->fill($this->getAttrs())->save();

            $token = JWTAuth::fromUser($this->model);

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Invalid OTP'], 401);
    }

    public function findUser(string $email): JsonResponse|static
    {
        $this->model = User::query()
            ->where('email', $email)
            ->first();

        if (!$this->model) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return $this;
    }
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json(['success'=> true, 'token' => $token, 'status' => 'New'], 200);
    }
    public function signup(): JsonResponse
    {
        $user = User::query()->create([
            'name' => $this->getAttr('name'),
            'email' => $this->getAttr('email'),
            'password' => bcrypt($this->getAttr('password'))
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User Registered Successfully',
            'token' => $token
        ], 200);
    }

    public function refreshAuthUserToken(): JsonResponse
    {
        $newToken = JWTAuth::refresh();
        return $this->respondWithToken($newToken);
    }
}
