<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::all();

        return $this->sendResponse(ResourcesUser::collection($users), 'Users retrieved successfully.');
    }

    public function show($param)
    {
        $user = User::where('name', '=', $param)->firstOrFail();
        dd($user);
        return $this->sendResponse(ResourcesUser::collection($user), 'User ok');
    }

    public function update(Request $request, $param)
    {
        // $data = $request->validate(['email' => 'required|email']);

        if (is_numeric($param))
            $user = User::findOrFail($param);
        else
            $user = User::where('name', 'like', '%'.$param.'%')
                            ->when($request->has("email"), function ($query) use ($request) {
                                $query->where('email', 'like', '%'.$request->email.'%');
                            })
                            ->firstOrFail();

        dd($user);
        // return $this->sendResponse(ResourcesUser::collection($user), 'User ok');
    }
}
