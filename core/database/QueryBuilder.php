<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function createStatement()
    {

        $statement = $this->pdo->prepare("create table posts(
            id INT(10) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(12) NOT NULL,
            content VARCHAR(255) NOT NULL,
            created_at DATETIME
        );");
        echo $statement->execute();

        $statement = $this->pdo->prepare("create table replies(
            id INT(10) AUTO_INCREMENT PRIMARY KEY,
            post_id INT NOT NULL,
            FOREIGN KEY (post_id) REFERENCES posts(id),
            name VARCHAR(12) NOT NULL,
            content VARCHAR(255) NOT NULL,
            created_at DATETIME
        );");
        echo $statement->execute();

        $statement = $this->pdo->prepare("create table rereplies(
            id INT(10) AUTO_INCREMENT PRIMARY KEY,
            reply_id INT NOT NULL,
            FOREIGN KEY (reply_id) REFERENCES replies(id),
            name VARCHAR(12) NOT NULL,
            content VARCHAR(255) NOT NULL,
            created_at DATETIME
        );");
        echo $statement->execute();
    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from $table ORDER BY created_at desc");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
    public function storePost($post)
    {
        $statement = $this->pdo->prepare("INSERT INTO posts (name, content, created_at) VALUES ('{$post['name']}', '{$post['content']}', '{$post['created_at']}')");
        $statement->execute();
    }
    public function storeReply($reply)
    {
        $statement = $this->pdo->prepare("INSERT INTO replies (post_id, name, content, created_at) VALUES ('{$reply['post_id']}', '{$reply['name']}', '{$reply['content']}', '{$reply['created_at']}')");
        $statement->execute();
    }
    public function storeReReply($reply)
    {
        $statement = $this->pdo->prepare("INSERT INTO rereplies (reply_id, name, content, created_at) VALUES ('{$reply['reply_id']}', '{$reply['name']}', '{$reply['content']}', '{$reply['created_at']}')");
        $statement->execute();
    }
    public function showReplies($post_id)
    {
        $statement = $this->pdo->prepare("select 
            r.id as rid, 
            r.name as rname, 
            r.content as rcontent, 
            r.created_at as rcreated
            from replies as r 
            where r.post_id = $post_id 
            ORDER BY r.created_at desc");
        $statement->execute();
        $AllReplies = $statement->fetchAll(PDO::FETCH_CLASS);
        $statementPost = $this->pdo->prepare("SELECT * FROM posts where id = $post_id");
        $statementPost->execute();
        $results = [];
        foreach ($AllReplies as $reply) {
            $statementrere = $this->pdo->prepare("SELECT name, content FROM rereplies where reply_id = $reply->rid ORDER BY created_at desc");
            $statementrere->execute();
            $reply = json_decode(json_encode($reply), true);
            $reply['rere'] = $statementrere->fetchAll();
            array_push($results,$reply);
        }
        $post = $statementPost->fetchAll(PDO::FETCH_CLASS);
        $response['post'] = $post[0];
        $response['AllReplies'] = $results;
        // var_dump($response);
        // foreach ($posts as $post) {
        // }
        // $rerestatement = $this->pdo->prepare("select * from rereplies where reply_id = id");
        return $response;
    }
    public function showReReplies($reply_id)
    {
        $statement = $this->pdo->prepare("select * from rereplies as rr where rr.reply_id = $reply_id ORDER BY rr.created_at desc");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}
?>