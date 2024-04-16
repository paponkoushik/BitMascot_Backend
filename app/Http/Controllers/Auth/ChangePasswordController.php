<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    protected $service;

    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->service
            ->setAttrs($request->only('currentPassword', 'newPassword'))
            ->changePassword();
    }
}
