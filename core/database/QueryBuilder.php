<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class QueryBuilder
{
    protected $user_id;
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

    public function selectAll($table, $user_id)
    {
        $this->user_id = $user_id;
        $post = Capsule::table($table)
            ->leftJoin('likes', function($join){
                $join->where('likes.user_id','=', $this->user_id)
                ->on('posts.id', '=', 'likes.post_id');})
            ->select('posts.*','likes.id as like')
            ->orderBy('created_at','desc')->get();
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
        $rereply = Capsule::table('rereplies')->insertGetId(
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
        $userLikes = Capsule::table('likes')
            ->join('users', 'users.id', 'likes.user_id')
            ->select('users.name as name')->where('post_id',$post_id)->get();
        $response['post'] = $post[0];
        $response['likes'] = $userLikes;
        $response['AllReplies'] = $results;
        return $response;
    }

    public function storeUser($user)
    {
        $isUnique = Capsule::table('users')->where('name',$user['name'])->exists();
        if ($isUnique) {
            return false;
        } else {
            $user = Capsule::table('users')->insertGetId(
                array('name' => $user['name'],
                'password' => $user['password'],
                'created_at' => $user['created_at']));
            return true;
        }
    }

    public function isUser($name, $password)
    {
          $user = Capsule::table('users')->where('name', $name)->first();
          if ($user) {
              if ($password == $user->password) {
                $user = json_decode(json_encode($user), true);
                return [1, $user];
              } else {
                  return [0, "Password does not match"];
              }
          } else {
              return [0, "User does not exist"];
          }
    }

    public function storeLike($like)
    {
        $hasA = Capsule::table('likes')->where([['user_id','=',$like['user_id']],['post_id','=', $like['post_id']]])->exists();
        if ($hasA) {
            return false;
        } else {
            $user = Capsule::table('likes')->insertGetId(
                array('post_id' => $like['post_id'],
                'user_id' => $like['user_id'],
                'created_at' => $like['created_at']));
            return true;
        }
    }

    public function removeLike($like)
    {
        $hasA = Capsule::table('likes')->where([['user_id','=',$like['user_id']],['post_id','=', $like['post_id']]])->delete();
    }
}
?>