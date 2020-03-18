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
            <div><a>Name</a> <?= $post->name; ?></div>
            <div><a>Created time</a> <?= substr($post->created_at, 0, strlen($post->created_at)-3); ?></div>
            <div><a>Content</a> <?= $post->content; ?></div>
            <form action="storeLike" method="post">
                <input type="hidden" name="post_id" value="<?= $post->id; ?>"></input>
                <?php if(!$post->like): ?>
                    <input type="submit" value="Like" enabled/>
                <?php else: ?>
                    <input type="submit" value="Liked" disabled />
                <?php endif; ?>
            </form> 
            <form action="showReply" method="post">
                <input type="hidden" name="post_id" value="<?= $post->id; ?>"></input>
                <input type="submit" value="All Replies -->">
            </form> 
            <form action="storeReply" method="post">
                <input type="hidden" name="post_id" value="<?= $post->id; ?>"></input>
                <input type="hidden" name="type" value="0"></input>
                <input type="text" id="content" name="content"><br><br>
                <input type="submit" value="Reply">
            </form> 
        </li>
            <?php endforeach; ?>
    </ul>
</body>
</html> 
