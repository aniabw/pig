@extends('piggame::layouts.master')

@section('content')

    <div id="message"></div>

    <div class="game">

        <div id="player">
            Player 1:  <button onclick="showResult(1)" id="buttonPlayer1"> Roll </button><br /><br />
            <div id="resultAreaPlayer1"></div> <div id="currentResultPlayer1"></div>
        </div>

        <div id="player">
            Player 2:  <button onclick="showResult(2)" id="buttonPlayer2"> Roll </button><br /><br />
            <div id="resultAreaPlayer2"></div> <div id="currentResultPlayer2"></div>
        </div>

        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <input type="hidden" name="player1RoundScore" id="player1RoundScore" value="">
        <input type="hidden" name="player2RoundScore" id="player2RoundScore" value="">

    </div>


    <div class="results">

        <div class="div-table">
            <div class="div-table-row">
                <div class="div-table-col title">Player 1</div>
                <div  class="div-table-col title">Player 2</div>
            </div>
            <div class="div-table-row">
                <div class="div-table-col" id="player1TotalScore"></div>
                <div class="div-table-col" id="player2TotalScore"></div>
            </div>

        </div>
    </div>

    <hr />

    <button onclick="location.href='/laravel/pig/public/piggame';" id="buttonPlayer1"> New game </button>
    <button onclick="location.href='https://en.wikipedia.org/wiki/Pig_(dice_game)';" id="buttonPlayer1"> Rules </button>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript">

        function showResult(player)
        {
            var jsonData = '';
            jsonData = { "player1RoundScore":$('input[name="player1RoundScore"]').attr('value'),"player2RoundScore":$('input[name="player2RoundScore"]').attr('value'), "player":player};

            let headers = {"X-CSRF-Token": $('input[name="_token"]').attr('value')};

            $( '#resultAreaPlayer1' ).html('');
            $( '#currentResultPlayer1' ).html('');
            $( '#resultAreaPlayer2' ).html('');
            $( '#currentResultPlayer2' ).html('');
            $( '#buttonPlayer1' ).attr('disabled', false);
            $( '#buttonPlayer2' ).attr('disabled', false);

            $.ajax({
                url: '/laravel/pig/public/api/result',
                type: 'post',
                dataType: 'json',
                data: jsonData,
                headers: headers,
                dataType: 'html',
                success: function (data) {
                    var resultData = JSON.parse(data);

                    if (resultData.player == 1) {
                        $('#resultAreaPlayer1').append('<i class="fas fa-dice-'+ resultData.dice +' fa-4x"></i>');
                        $('#currentResultPlayer1').append('&pound;'+resultData.player1RoundScore);
                        $("#player1RoundScore").val(resultData.player1RoundScore);
                    }

                    if (resultData.player == 2) {
                        $('#resultAreaPlayer2').append('<i class="fas fa-dice-'+ resultData.dice +' fa-4x"></i>');
                        $('#currentResultPlayer2').append('&pound;'+resultData.player2RoundScore);
                        $("#player2RoundScore").val(resultData.player2RoundScore);
                    }

                    if (typeof resultData.player1TotalScore !== 'undefined') {
                        $('#player1TotalScore').html('');
                        $('#player1TotalScore').append('&pound;' + resultData.player1TotalScore);
                    }

                    if (typeof resultData.player2TotalScore !== 'undefined') {
                        $('#player2TotalScore').html('');
                        $('#player2TotalScore').append('&pound;' + resultData.player2TotalScore);
                    }

                    if(resultData.disabled == 'disabled1') {
                        $( '#buttonPlayer1' ).attr('disabled', true);
                    }

                    if(resultData.disabled == 'disabled2') {
                        $( '#buttonPlayer2' ).attr('disabled', true);
                    }

                    if(resultData.disabledAll == true) {
                        $( '#buttonPlayer2' ).attr('disabled', true);
                        $( '#buttonPlayer1' ).attr('disabled', true);
                    }

                    $('#message').append(resultData.message);
                }
            });
        }
    </script>
@stop
