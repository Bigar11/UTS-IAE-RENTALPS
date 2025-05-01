<?php

namespace App\Http\Controllers;

use App\Models\GameConsole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class ConsoleController extends Controller
{
    public function index()
    {
        try {
            $consoles = GameConsole::all();
            return response()->json([
                'success' => true,
                'message' => 'Data semua console berhasil diambil.',
                'data' => $consoles
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data console.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $console = GameConsole::find($id);
            if (!$console) {
                return response()->json([
                    'success' => false,
                    'message' => 'Console tidak ditemukan.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail console berhasil diambil.',
                'data' => $console
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail console.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'brand' => 'required|string',
                'model' => 'required|string',
                'available' => 'boolean',
            ]);

            $console = GameConsole::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Console berhasil ditambahkan.',
                'data' => $console
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
                'message' => 'Gagal menambahkan console.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $console = GameConsole::find($id);
            if (!$console) {
                return response()->json([
                    'success' => false,
                    'message' => 'Console tidak ditemukan.',
                ], 404);
            }

            $validated = $request->validate([
                'brand' => 'sometimes|required|string',
                'model' => 'sometimes|required|string',
                'available' => 'sometimes|boolean',
            ]);

            $console->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Console berhasil diperbarui.',
                'data' => $console
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
                'message' => 'Gagal memperbarui console.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $console = GameConsole::find($id);
            if (!$console) {
                return response()->json([
                    'success' => false,
                    'message' => 'Console tidak ditemukan.',
                ], 404);
            }

            $console->delete();

            return response()->json([
                'success' => true,
                'message' => 'Console berhasil dihapus.'
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus console.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
