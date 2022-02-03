<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Epresence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApprovePresence extends Controller
{
    public function getUserPresence()
    {
        $user = User::with('epresences')
            ->where('npp_supervisor', auth()->user()->npp)
            ->get();

        return response()->json([
            'message' => 'Succes get data',
            'data' => $user
        ], 200);
    }

    public function approvePresence(Request $request, $epresence)
    {

        $epresence = Epresence::find($epresence);

        if (!$epresence) {
            return response()->json(['message' => 'Data presence tidak ditemukan'], 400);
        }

        if ($epresence->user->npp_supervisor !== auth()->user()->npp) {
            return response()->json(['message' => 'unautorized'], 401);
        }

        $epresence->update([
            'is_approve' => true,
        ]);

        return response()->json([
            'message' => 'Approve success',
            'data' => $epresence
        ]);


    }
}
