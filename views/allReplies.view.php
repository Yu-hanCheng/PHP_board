<html lang="en">
<head>
    <meta charset="utf-8">
    <title>allReplies</title>
    <style>
        table, tr, td {
            border: 0.5px solid gray;
        }
    </style>
    <script>
        // When the user clicks on div, open the popup
        function myFunction($rid) { 
            var popup = document.getElementById("myPopup");
            var input = document.createElement("input");
                input.name = "reply_id";
                input.type = "hidden";
                input.value= $rid;
            popup.appendChild(input);
            popup.classList.toggle("show");
        }
    </script>
    <style>
        .popup {
            display: inline-block;
        }
        .popup .popuptext {
            visibility: hidden;
            width: 160px;
            background-color: #b1b1b1;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 20px;
            position:relative;
            top:50px;
            right:150px;
        }
        .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s;
        }
    </style>
</head>
<body style="text-align:center">
    <div class="popup">
        <form class="popuptext" action="storeReply" method="post" id="myPopup">
            <input type="hidden" name="type" value="1"></input>
            <input type="text" name="content"/>
            <input type="submit" value="Reply">
        </form>
    </div>
    <table>
        <tr>
            <th>Post</th>
            <th><?= $replies[0]->pcontent ?></th>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <th>Name</th>
            <th>Reply content</th>
        </tr>
        <?php foreach ($replies as $reply) : ?>
        <tr>
            <td><?= $reply->rname ?></td>
            <td><?= $reply->rcontent ?></td>
            <td>
            <div onclick=<?= "myFunction(".$reply->rid.")"?>>Reply
            </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>