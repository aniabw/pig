<?php

namespace Modules\PigGame\Entities;

class PigGame
{
    protected $winningScore = 100;

    public function resetScores($request, $scores) {

        return $request->session()->put("{$scores}", 0);
    }

    public function getScores($request, $whichOne) {

        return $request->session()->get("{$whichOne}");
    }

    public function setTotalScores($request,$player) {

        $playerTotalScore = $request->session()->get("{$player}RoundScore") + $request->session()->get("{$player}TotalScore");
        $request->session()->put("{$player}TotalScore", $playerTotalScore);
        return $request->session()->get("{$player}TotalScore");
    }

    public function setRoundScores($request,$player,$score) {

        $playerRoundScore = $request->session()->get("{$player}RoundScore");
        $playerRoundScore = $score + (int)$playerRoundScore;
        $request->session()->put("{$player}RoundScore", $playerRoundScore);
        return $request->session()->get("{$player}RoundScore");
    }

    public function checkWinner($request) {
        $message = null;

        if($request->session()->get('player1TotalScore') >= $this->winningScore) {
            $message = 'Player 1 won the game!!';
        }

        if($request->session()->get('player2TotalScore') >= $this->winningScore) {
            $message = 'Player 2 won the game!!';
        }

        return $message;
    }
}