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
                input.name = "comment_id";
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
        <form class="popuptext" action="storeComment" method="post" id="myPopup">
            <input type="hidden" name="type" value="1"></input>
            <input type="text" name="content"/>
            <input type="submit" value="Reply">
        </form>
    </div>
    <div>
        <button onclick="location.href='http://localhost:8888/board'">BOARD</button>
    </div>
    <table>
        <tr>
            <th>Post</th>
            <th><?= $replies['post']['content']; ?></th>
        </tr>
        <tr>Who likes: 
            <?php foreach ($replies['likes'] as $like){
                        echo $like['user']['name'].', ';
                    }
            ?>
        </tr>
        <tr>
        <div>
            <form action="storeComment" method="post">
                <input type="hidden" name="post_id" value="<?= $replies['post']['id']; ?>"></input>
                <input type="hidden" name="type" value="0"></input>
                <input type="text" id="content" name="content"><br><br>
                <input type="submit" value="Comment">
            </form> 
        </div>
        </tr>
    </table>
    <br>    
    <table>
        <tr>
            <th>Name</th>
            <th>Reply content</th>
        </tr>
        <?php foreach ($replies['Allcomments'] as $comment) : ?>
        <tr>
            <td><?= $comment['user']['name'] ?></td>
            <td><?= $comment['content'] ?></td>
            <td><table bordercolor=green>
                <?php foreach ($comment['replies'] as $reply) : ?>
                    <tr>
                        <td><?= $reply['user']['name'] ?></td>
                        <td><?= $reply['content'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            </td>
            <td>
            <div onclick=<?= "myFunction(".$comment['id'].")"?>>Reply
            </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>