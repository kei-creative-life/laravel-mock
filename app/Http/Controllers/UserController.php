<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com'],
        ['id' => 3, 'name' => 'Bob Smith', 'email' => 'bob@example.com'],
    ];

    public function index(): JsonResponse
    {
        return response()->json($this->users);
    }

    public function show($id): JsonResponse
    {
        $user = collect($this->users)->firstWhere('id', (int)$id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}