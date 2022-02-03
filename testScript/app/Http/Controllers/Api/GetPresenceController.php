<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Epresence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetPresenceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $presencesIN = Epresence::where('user_id', auth()->user()->id)
            ->where('type', 'IN')
            ->get();

        $presencesOUT = Epresence::where('user_id', auth()->user()->id)
            ->where('type', 'OUT')
            ->get();

        $dataPresence = collect([]);

        foreach ($presencesIN as $key1 => $presenceIN) {
            foreach ($presencesOUT as $key2 => $presenceOUT) {
                if ($presenceIN->date == $presenceOUT->date) {
                    $dataPresence->push([
                        'id_user' => $presenceIN->user_id,
                        'user' => $presenceIN->user->name,
                        'tanggal' => $presenceIN->date,
                        'waktu_masuk' => Carbon::parse($presenceIN->waktu)->format('H:i:s'),
                        'waktu_pulang' => Carbon::parse($presenceOUT->waktu)->format('H:i:s'),
                        'status_masuk' => $presenceIN->is_approve ? "APPROVE" : "REJECT",
                        'status_pulang' => $presenceOUT->is_approve ? "APPROVE" : "REJECT",
                    ]);
                    unset($presencesIN[$key1]);
                }
            }
        }

        $presencesIN->map(fn($item) =>
            $dataPresence->push([
                'id_user' => $item->user_id,
                'user' => $item->user->name,
                'tanggal' => $item->date,
                'waktu_masuk' => Carbon::parse($item->waktu)->format('H:i:s'),
                'waktu_pulang' => "",
                'status_masuk' => $item->is_approve ? "APPROVE" : "REJECT",
                'status_pulang' => "",
            ])
        );

        return response()->json([
            'message' => 'Success get data',
            'data' => $dataPresence->sortByDesc('tanggal')  
        ]); 
    }
}
