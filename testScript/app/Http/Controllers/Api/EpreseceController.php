<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Epresence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EpreseceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        date_default_timezone_set('Asia/Jakarta');

        $presences = Epresence::where('user_id', auth()->user()->id)
            ->whereDate('waktu', Carbon::now())->get();

        // return $presences->count();

        if ($presences->count() >= 2) {
            return response()->json([
                'message' => 'Anda sudah melakuka absen 2 kali, silahkan lakukan lagi besok!'
            ], 400);
        }

        if (!$presences->count()) {
            $presence = Epresence::create([
                'user_id' => auth()->user()->id,
                'type' => 'IN',
            ]);
        }else {
            $presence = Epresence::create([
                'user_id' => auth()->user()->id,
                'type' => 'OUT',
            ]);
        }


        $data['presence'] = $presence;

        return response()->json([
            "type" => $presence->type,
            "waktu" => $presence->waktu->format('y-m-d h:i:s'),
        ]);
    }
}
