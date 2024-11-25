<script type='text/javascript' src='js/form_home.js'></script>

<div id='formEmaContainer'>
    <div class='ui active inverted dimmer'>
        <div class='ui text loader'>Loading...</div>
    </div>
</div>
<?
//include(__DIR__ . "/../config.inc.php");
exit;
?>


<br>
<div class="ui stackable grid" style='max-width: 1200px; text-align:left;'>
    <div class="six wide column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header">Current DAX Value</div>
                <div class="description">
                    <p>Dax: <span id='daxValue'>Waiting for data...</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">$(document).ready(function () {
        var socket = new WebSocket('ws://194.164.204.188:6969/ws');

        socket.onopen = function (event) {
            console.log('WebSocket connection established.');
        }

            ;

        socket.onmessage = function (event) {
            updateDaxValue(event.data);
        }

            ;

        socket.onclose = function (event) {
            console.log('WebSocket connection closed.');
        }

            ;

        socket.onerror = function (error) {
            console.error('WebSocket error:', error);
        }

            ;
    });
</script>