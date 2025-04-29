<?php

namespace App\Http\Controllers;

use App\Models\DiscountCoupon;
use App\Http\Requests\DiscountCouponsRequest\StoreDiscountCouponsRequest;
use App\Http\Requests\DiscountCouponsRequest\UpdateDiscountCouponsRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class DiscountCouponController extends Controller
{
    // Mostra todos os coupons disponíveis
    public function index()
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $coupons = DiscountCoupon::all();
            return response()->json($coupons, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar cupons de desconto: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao listar cupons de desconto'], 500);
        }
    }

    // Cria um cupom
    public function store(StoreDiscountCouponsRequest $request)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();

            $coupon = DiscountCoupon::create([
                'code' => $validated['code'],
                'discount' => $validated['discount'],
                'max_uses' => $validated['max_uses'],
                'expires_at' => $validated['expires_at'],
            ]);

            return response()->json($coupon, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar cupom de desconto: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao criar cupom de desconto'], 500);
        }
    }

    // Mostra um cupom específico
    public function show(DiscountCoupon $coupon)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            return response()->json($coupon, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Cupom de desconto não encontrado: ' . $e->getMessage());
            return response()->json(['error' => 'Cupom de desconto não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao mostrar cupom de desconto: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao mostrar cupom de desconto'], 500);
        }
    }

    // Atualiza um cupom
    public function update(UpdateDiscountCouponsRequest $request, DiscountCoupon $coupon)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $validated = $request->validated();
            $coupon->update($validated);

            return response()->json($coupon, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos', 'details' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            Log::error('Cupom de desconto não encontrado para atualização: ' . $e->getMessage());
            return response()->json(['error' => 'Cupom de desconto não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar cupom de desconto: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao atualizar cupom de desconto'], 500);
        }
    }

    // Excluindo o cupom
    public function destroy(DiscountCoupon $coupon)
    {
        try {
            if (!auth()->user()->can('gerenciar eventos')) {
                return response()->json(['error' => 'Acesso negado'], 403);
            }

            $coupon->delete();
            return response()->json(['message' => 'Cupom de desconto deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Cupom de desconto não encontrado para exclusão: ' . $e->getMessage());
            return response()->json(['error' => 'Cupom de desconto não encontrado'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir cupom de desconto: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir cupom de desconto'], 500);
        }
    }
}
