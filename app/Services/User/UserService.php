<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserService
{
    public function searchUsers($request): JsonResponse
    {
        $query = $request->input('query');
//        dd($query);
//      $test = User::query()->get();
//      dd($test);

        $results = User::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->get();

        return response()->json($results);
    }
}
