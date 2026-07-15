<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ActivityLog;
use App\Services\UserService;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index()
    {
        $users = $this->userService->getPaginatedUsers(10);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        ActivityLog::record('create_user', "Menambahkan pengguna: {$user->name} ({$user->role})");

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = $this->userService->getUserDetail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $this->userService->updateUser($id, $request->validated());

        $user = $this->userService->getUserDetail($id);
        ActivityLog::record('update_user', "Mengubah data pengguna: {$user->name}");

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        try {
            $user = $this->userService->getUserDetail($id);
            ActivityLog::record('delete_user', "Menghapus pengguna: {$user->name}");

            $this->userService->deleteUser($id);
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (ValidationException $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }
}