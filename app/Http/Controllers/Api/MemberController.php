<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\Responses;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function bonus(): \Illuminate\Http\JsonResponse
    {
        $username = request('username');
        $user = User::where('username', $username)->first();

        if (!$user) {
            return Responses::error('User not found', 404);
        }

        $userId = $user->id;

        // User data based on userId as parent_id
        $users2 = User::where('parent_id', $userId)->get();

        // Initial Bonus Amount : Lv. 2
        $bonuses = count($users2);

        // Loop lv.2 to get lv. 3
        // Because this is a binary tree, we only need to loop through the first two users
        foreach ($users2 as $user) {
            $users3 = User::where('parent_id', $user->id)->get();
            // Example if got 3 users in lv. 3, per user is 0.5 bonus
            $bonuses += count($users3) * 0.5;
        }

        $res = [
            'username' => $username,
            'bonus' => $bonuses,
        ];

        return Responses::Success('Success', $res);
    }

    public function getTree(): \Illuminate\Http\JsonResponse
    {
        $users = User::all();
        $tree = [];
        foreach ($users as $user) {
            $tree[$user->id] = [
                'id' => $user->id,
                'username' => $user->username,
                'parent_id' => $user->parent_id,
                'children' => []
            ];
        }

        foreach ($tree as $id => &$node) {
            if ($node['parent_id'] && isset($tree[$node['parent_id']])) {
                $tree[$node['parent_id']]['children'][] = &$node;
            }
        }

        // Only return the root nodes
        $tree = array_filter($tree, function ($node) {
            return $node['parent_id'] === null;
        });

        // Remove data key
        $tree = array_values($tree);

        return Responses::Success('Success', $tree);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'parent_id' => 'nullable|exists:users,id'
        ]);

        $user = User::create($request->all());

        return Responses::Success('Success', $user);
    }

    public function move(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'parent_id' => 'nullable|exists:users,id'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return Responses::error('User not found', 404);
        }

        $user->parent_id = $request->parent_id;
        $user->save();

        return Responses::Success('Success', $user);
    }
}
