<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                'success' => true,
                'message' => 'Daftar semua user berhasil diambil.',
                'data' => $users
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/users/{id}
    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail user berhasil diambil.',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/users
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required|string',
                'email' => 'required|email|unique:users,email',
            ]);

            $user = User::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan.',
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                ], 404);
            }

            $validated = $request->validate([
                'name'  => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
            ]);

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui.',
                'data' => $user
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus.'
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
