<!DOCTYPE html>
<html>

<head>
    <title>Astrocode Book Car</title>
    <style language="text/css">
        input#wisdom {
            padding: 4px;
            font-size: 1em;
            width: 400px
        }

        input::placeholder {
            color: #ccc;
            font-style: italic;
        }

        p.userRequest {
            margin: 4px;
            padding: 4px 10px 4px 10px;
            border-radius: 4px;
            min-width: 50%;
            max-width: 85%;
            float: left;
            background-color: #7d7;
        }

        p.lexResponse {
            margin: 4px;
            padding: 4px 10px 4px 10px;
            border-radius: 4px;
            text-align: right;
            min-width: 50%;
            max-width: 85%;
            float: right;
            background-color: #bbf;
            font-style: italic;
        }

        p.lexError {
            margin: 4px;
            padding: 4px 10px 4px 10px;
            border-radius: 4px;
            text-align: right;
            min-width: 50%;
            max-width: 85%;
            float: right;
            background-color: #f77;
        }
    </style>
</head>

<body>
<h1 style="text-align:  left">Astrocode BookCar</h1>
<p style="width: 400px">
    Get your best rent car with interactive bot in here
</p>
<div id="conversation" style="width: 400px; height: 400px; border: 1px solid #ccc; background-color: #eee; padding: 4px; overflow: scroll"></div>
<form id="chatform" style="margin-top: 10px" onsubmit="return pushChat();">
    <input type="text" id="wisdom" size="80" value="" placeholder="Test!">
</form>
<script type="text/javascript">
    document.getElementById("wisdom").focus();

    var lexUserId = 'chatbot-demo' + Date.now();

    function pushChat() {
        var wisdomText = document.getElementById('wisdom');
        if (wisdomText && wisdomText.value && wisdomText.value.trim().length > 0) {

            var wisdom = wisdomText.value.trim();
            wisdomText.value = '...';
            wisdomText.locked = true;

            showRequest(wisdom);
            const http = new XMLHttpRequest()
            http.open('POST', '/api/bot')
            http.setRequestHeader('Content-type', 'application/json')
            http.send(JSON.stringify({"inputText": wisdom, "userId": lexUserId}))
            http.onload = function() {
                wisdomText.value = '';
                wisdomText.locked = false;
                showResponse(http.responseText);
            }
        }
        return false;
    }

    function showRequest(daText) {

        var conversationDiv = document.getElementById('conversation');
        var requestPara = document.createElement("P");
        requestPara.className = 'userRequest';
        requestPara.appendChild(document.createTextNode(daText));
        conversationDiv.appendChild(requestPara);
        conversationDiv.scrollTop = conversationDiv.scrollHeight;
    }

    function showError(daText) {

        var conversationDiv = document.getElementById('conversation');
        var errorPara = document.createElement("P");
        errorPara.className = 'lexError';
        errorPara.appendChild(document.createTextNode(daText));
        conversationDiv.appendChild(errorPara);
        conversationDiv.scrollTop = conversationDiv.scrollHeight;
    }

    function showResponse(response) {

        var conversationDiv = document.getElementById('conversation');
        var responsePara = document.createElement("P");
        responsePara.className = 'lexResponse';
        responsePara.appendChild(document.createTextNode(response));
        responsePara.appendChild(document.createElement('br'));
        conversationDiv.appendChild(responsePara);
        conversationDiv.scrollTop = conversationDiv.scrollHeight;
    }
</script>
</body>

</html>
