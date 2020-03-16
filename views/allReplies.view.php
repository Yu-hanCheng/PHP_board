<html lang="en">
<head>
    <meta charset="utf-8">
    <title>allReplies</title>
</head>
<body>
    <table>
        <tr>
            <th>Post</th>
            <th><?= $replies[0]->pcontent ?></th>
        </tr>
        <?php foreach ($replies as $reply) : ?>
        <tr>
            <td><?= $reply->rname ?></td>
            <td><?= $reply->rcontent ?></td>
            <td>
                <form action="storeReply" method="post">
                    <input type="hidden" name="reply_id" value="<?= $reply->rid; ?>"></input>
                    <input type="hidden" name="type" value="1"></input>
                    <input type="submit" value="Reply">
                </form> 
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>