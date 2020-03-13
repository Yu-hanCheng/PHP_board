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
        $statement = $this->pdo->prepare("INSERT INTO rereplies (reply_id, name, content, created_at) VALUES ('{$reply['post_id']}', '{$reply['name']}', '{$reply['content']}', '{$reply['created_at']}')");
        $statement->execute();
    }
    public function showReplies($post)
    {
        $statement = $this->pdo->prepare("select * from posts where id= $post");
        $statement->execute();
    }
}
?>