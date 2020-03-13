
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Board</title>
    <style>
        header { 
            background: #e3e3e3;
            padding: 2em;
            text-align: center;
        }
    </style>
</head>
<body>
        <input>Leave a msg</input>
    <ul>
        <?php foreach ($board as $post) : ?>
        <li>
            <?= $post->name; ?>
            <?= $post->content; ?>
        </li>
            <?php endforeach; ?>
    </ul>
</body>
</html> 
