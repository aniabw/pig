<?php

namespace Modules\PigGame\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PigGame\Entities\PigGame;

class PigGameController extends Controller
{
    public function index(Request $request, PigGame $pigGame)
    {
        $pigGame->resetScores($request, 'player1RoundScore');
        $pigGame->resetScores($request, 'player2RoundScore');
        $pigGame->resetScores($request, 'player1TotalScore');
        $pigGame->resetScores($request, 'player2TotalScore');
        $request->session()->forget('playerRound');

        return view('piggame::index');
    }
}
