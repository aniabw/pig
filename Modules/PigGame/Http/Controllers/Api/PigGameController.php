<?php

namespace Modules\PigGame\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers;
use Modules\PigGame\Entities\PigGame;

class PigGameController extends Controller
{
    public function index(Request $request, PigGame $pigGame)
    {
        $player = $request->input('player');

        $score = rand(1,6);
        $dice = Helpers::spellout($score);

        $result['disabled'] = '';
        if($score == 1) {
            if($player == 1) $pigGame->resetScores($request, 'player1RoundScore');
            if($player == 2) $pigGame->resetScores($request, 'player2RoundScore');
            $result['disabled'] = "disabled{$player}";
        }
        else {
            if($player == 1) {
                $player1RoundScore = $pigGame->setRoundScores($request,'player1',$score);
            }

            if($player == 2) {
                $player2RoundScore = $pigGame->setRoundScores($request,'player2',$score);
            }
        }

        $playerRound = $request->session()->get('playerRound');
        $request->session()->put('playerRound', $player);

        if(isset($playerRound) AND ($player != $playerRound)) {

            if($player == 1) {
                $result['player2TotalScore'] = $pigGame->setTotalScores($request,'player2');
                $pigGame->resetScores($request, 'player2RoundScore');
            }

            if($player == 2) {
                $result['player1TotalScore'] = $pigGame->setTotalScores($request,'player1');
                $pigGame->resetScores($request, 'player1RoundScore');
            }
        }

        $message = $pigGame->checkWinner($request);
        if(isset($message)) {
            $result['disabledAll'] = true;
            $result['message'] = $message;
        }

        $result['player'] = $player;
        $result['dice'] = $dice;
        $result['player1RoundScore'] = isset($player1RoundScore) ? $player1RoundScore : 0;
        $result['player2RoundScore'] = isset($player2RoundScore) ? $player2RoundScore : 0;

        return json_encode($result);
    }
}
