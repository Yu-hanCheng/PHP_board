<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Board</title>
</head>
<body>
    <form action="storePost" method="post">
        <a>Leave a msg</a>
        <input type="text" id="content" name="content"><br><br>
        <input type="submit" value="Submit">
    </form> 
    <ul>
        <?php foreach ($board as $post) : ?>
        <li>
            <div><a>Name</a> <?= $post->user_name; ?></div>
            <div><a>Created time</a> <?= substr($post->created_at, 0, strlen($post->created_at)-3); ?></div>
            <div><a>Content</a> <?= $post->content; ?></div>
            <form action="storeLike" method="post">
                <input type="hidden" name="post_id" value="<?= $post->id; ?>"></input>
                <?php if(count($post->likes) == 0): ?>
                    <input type="hidden" name="isStore" value=1></input>
                    <input type="submit" value="Like"/>
                <?php else: ?>
                    <img src="views/src/like.png" width="20px" height="20px">
                    <input type="hidden" name="isStore" value=0></input>
                    <input type="submit" value="Unlike"/>
                <?php endif; ?>
            </form> 
            <form action="showComment" method="post">
                <input type="hidden" name="post_id" value="<?= $post->id; ?>"></input>
                <input type="submit" value="All Replies -->">
            </form> 
            <form action="storeComment" method="post">
                <input type="hidden" name="post_id" value="<?= $post->id; ?>"></input>
                <input type="hidden" name="type" value="0"></input>
                <input type="text" id="content" name="content"><br><br>
                <input type="submit" value="Comment">
            </form> 
        </li>
            <?php endforeach; ?>
    </ul>
</body>
</html> 
