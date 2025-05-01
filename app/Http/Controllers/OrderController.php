<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class OrderController extends Controller
{
    /**
     * Get all orders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $orders = Order::all();
            return response()->json([
                'success' => true,
                'message' => 'Data semua order berhasil diambil.',
                'data' => $orders
            ], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show specific order by ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $order = Order::find($id);

            return $order
                ? response()->json(['success' => true, 'data' => $order])
                : response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validasi input yang masuk
            $validated = $request->validate([
                'user_id'    => 'required|integer',
                'console_id' => 'required|integer',
                'start_time' => 'required|date',
                'end_time'   => 'required|date|after:start_time',
            ]);

            // Simpan order ke database
            $order = Order::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat.',
                'data' => $order
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
                'message' => 'Gagal membuat order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
