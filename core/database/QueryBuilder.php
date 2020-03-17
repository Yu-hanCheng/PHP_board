<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class QueryBuilder
{
    public function createStatement()
    {
        Capsule::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('content');
            $table->timestamps();
        });

        Capsule::schema()->create('replies', function ($table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');
            $table->string('name');
            $table->string('content');
            $table->timestamps();
        });

        Capsule::schema()->create('rereplies', function ($table) {
            $table->increments('id');
            $table->integer('reply_id')->unsigned();
            $table->foreign('reply_id')->references('id')->on('replies');
            $table->string('name');
            $table->string('content');
            $table->timestamps();
        });

        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('password');
            $table->timestamps();
        });

        Capsule::schema()->create('likes', function ($table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function selectAll($table)
    {
        $post = Capsule::table($table)->orderBy('created_at','desc')->get();
        return $post;
    }

    public function storePost($post)
    {
        $post = Capsule::table('posts')->insertGetId(
            array('name' => $post['name'],
                'content' => $post['content'],
                'created_at' => $post['created_at']));
    }

    public function storeReply($reply)
    {
        $reply = Capsule::table('replies')->insertGetId(
            array('post_id' => $reply['post_id'],
                'name' => $reply['name'],
                'content' => $reply['content'],
                'created_at' => $reply['created_at']));
    }

    public function storeReReply($reply)
    {
        $reply = Capsule::table('rereplies')->insertGetId(
            array('reply_id' => $reply['reply_id'],
                'name' => $reply['name'],
                'content' => $reply['content'],
                'created_at' => $reply['created_at']));
    }

    public function showReplies($post_id)
    {
        $allReplies = Capsule::table('replies')->select(
            'id as rid',
            'name as rname',
            'content as rcontent',
            'created_at as rcreated'
            )->where('post_id',$post_id)->orderBy('created_at','desc')->get();
        $post = Capsule::table('posts')->where('id', $post_id)->get();
        $results = [];
        foreach ($allReplies as $reply) {
            $rereplies = Capsule::table('rereplies')->where('reply_id', $reply->rid)->orderBy('created_at','desc')->get();
            $reply = json_decode(json_encode($reply), true);
            $reply['rere'] = $rereplies;
            array_push($results,$reply);
        }
        $response['post'] = $post[0];
        $response['AllReplies'] = $results;
        return $response;
    }
}
?>