<?php

namespace App\Http\Controllers;

use App\Models\BRT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Pusher\Pusher;

class BRTController extends Controller {
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index() {
        return response()->json(Auth::user()->brts);
    }

    public function store(Request $request) {
        $request->validate([
            'reserved_amount' => 'required|numeric|min:1',
            'status' => 'in:active,expired'
        ]);

        $brt = BRT::create([
            'user_id' => Auth::id(),
            'brt_code' => strtoupper(Str::random(10)),
            'reserved_amount' => $request->reserved_amount,
            'status' => $request->status ?? 'active'
        ]);

        // $this->sendNotification('BRT Created', $brt);

        return response()->json($brt, 201);
    }

    public function show($id) {
        return response()->json(BRT::where('user_id', Auth::id())->findOrFail($id));
    }

    public function update(Request $request, $id) {
        $brt = BRT::where('user_id', Auth::id())->findOrFail($id);
        $brt->update($request->only('reserved_amount', 'status'));

        // $this->sendNotification('BRT Updated', $brt);

        return response()->json($brt);
    }

    public function destroy($id) {
        $brt = BRT::where('user_id', Auth::id())->findOrFail($id);
        $brt->delete();

        // $this->sendNotification('BRT Deleted', $brt);

        return response()->json(['message' => 'BRT deleted']);
    }

    private function sendNotification($event, $brt) {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);
        $pusher->trigger('brt-channel', 'brt-event', ['event' => $event, 'brt' => $brt]);
    }
}
