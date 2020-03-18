<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require 'vendor/autoload.php';
class QueryBuilder
{
    protected $user_id;
    public function createStatement()
    {
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('password');
            $table->timestamps();
        });

        Capsule::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Capsule::schema()->create('comments', function ($table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('content');
            $table->timestamps();
        });

        Capsule::schema()->create('replies', function ($table) {
            $table->increments('id');
            $table->integer('comment_id')->unsigned();
            $table->foreign('comment_id')->references('id')->on('comments');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('content');
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
        $posts = Post::with(['likes' => function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        },'comments'])->orderBy('created_at','desc')->get();
        return $posts;
    }

    public function storePost($post)
    {
        $post = Post::create(
            array('user_id' => $post['user_id'],
                'content' => $post['content'],
                'created_at' => $post['created_at']));
    }

    public function storeComment($comment)
    {
        $comment= Comment::create(
            array('post_id' => $comment['post_id'],
                'user_id' => $comment['user_id'],
                'content' => $comment['content'],
                'created_at' => $comment['created_at']));
    }

    public function storeReply($reply)
    {
        $rereply = Reply::create(
            array('comment_id' => $reply['comment_id'],
                'user_id' => $reply['user_id'],
                'content' => $reply['content'],
                'created_at' => $reply['created_at']));
    }

    public function showComments($post_id)
    {
        $postAll = Post::with(['comments' => function ($query) use ($post_id) {
            $query->with('user','replies')->where('post_id',$post_id)->orderBy('created_at','desc');
        },'likes'])->where('id',$post_id)->first();
        $response['post'] = $postAll->only('id','content');
        $response['likes'] = $postAll->likes;
        $response['Allcomments'] = $postAll->comments;
        return $response;
    }

    public function storeUser($user)
    {
        $isUnique = Capsule::table('users')->where('name',$user['name'])->exists();
        if ($isUnique) {
            return false;
        } else {
            $user = User::create(
                array('name' => $user['name'],
                'password' => $user['password'],
                'created_at' => $user['created_at']));
            return true;
        }
    }

    public function isUser($name, $password)
    {
          $user = User::where('name', $name)->first();
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
        $hasA = Like::where([['user_id','=',$like['user_id']],['post_id','=', $like['post_id']]])->exists();
        if ($hasA) {
            return false;
        } else {
            $user = Like::create(
                array('post_id' => $like['post_id'],
                'user_id' => $like['user_id'],
                'created_at' => $like['created_at']));
            return true;
        }
    }

    public function removeLike($like)
    {
        $hasA = Like::where([['user_id','=',$like['user_id']],['post_id','=', $like['post_id']]])->delete();
    }
}
?>