<?php

namespace App\Http\Controllers\User;

use App\Filters\User\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserInfo\UserInfoResource;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index(UserFilter $filter)
    {
        $users = User::query()->filter($filter)->paginate(10);

        return response()->json(['users' => $users], 200);
//        return UserInfoResource::collection(
//            User::query()
//                ->where('id', '!=' $user->id)
//                ->get()
//        );
//        return $this->service->searchUsers($request);
    }

    public function show(User $user): AnonymousResourceCollection
    {
        return UserInfoResource::collection(
            User::query()
                ->where('id', $user->id)
                ->get()
        );

    }
}
