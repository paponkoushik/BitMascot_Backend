<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserInfo\UserInfoResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }
    public function login(LoginRequest $request): JsonResponse
    {
        return $this
            ->service
            ->login($request->only('email', 'password'));
    }
    public function verify(OtpRequest $request): JsonResponse
    {
        return $this->service
            ->setAttrs($request->only('email', 'otp'))
            ->findUser($this->service->getAttr('email'))
            ->verifyOTP();
    }
    public function signup(SignupRequest $request): JsonResponse
    {
        return $this
            ->service
            ->setAttrs(
                $request->only('first_name', 'last_name', 'email', 'password', 'address', 'phone', 'date_of_birth', 'id_verification')
            )
            ->signup();
    }
    public function refresh(): JsonResponse
    {
        return $this->service->refreshAuthUserToken();
    }
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function myself(): AnonymousResourceCollection
    {
        return UserInfoResource::collection(
            User::query()
                ->where('id', auth()->user()->id)
                ->get()
        );
    }
}
