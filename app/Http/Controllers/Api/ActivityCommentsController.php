<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Adventures\ActivityComment;
use App\Models\Adventures\Adventure;
use Request;

/**
 * Class ActivityCommentsController
 * @package App\Http\Controllers\Api
 */
class ActivityCommentsController extends Controller
{
    /**
     *
     * @param ActivityComment $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function like(ActivityComment $post)
    {

        if (Request::ajax()) {
            if (\Auth::check()) {
                $user = $post->user;
                $id = \Auth::id();
                if ($id == $user->id) {
                    return json_encode(['result' => false, 'message' => 'Post owner can`t like post']);
                }
                $liked = ($post->liked) ? json_decode($post->liked, true) : [];
                if (!in_array($id, $liked)) {
                    $liked[] = $id;
                }
                $post->liked = json_encode($liked);
                $post->like_count = count($liked);
                $post->save();
                return json_encode([
                    'result'  => true,
                    'message' => 'Like from user added',
                    'count'   => count($liked),
                    'id'      => $post->id
                ]);
            } else {
                return json_encode(['result' => false, 'message' => 'Guest can`t like post']);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }
    }


    /**
     *
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function reply($id)
    {

        if (Request::ajax()) {
            if (\Auth::check()) {
                $post = false;
                if (is_numeric($id)) {
                    $post = ActivityComment::find((int)$id);
                    if (!$post) {
                        return json_encode(['result' => false, 'message' => 'Post not found']);
                    }
                    if ($post->parent_id) {
                        return json_encode(['result' => false, 'message' => 'User can reply only first line post']);
                    }
                }

                $params = Request::input();
                $adventure = null;
                if (array_key_exists('adventure_id', $params)   && !empty($params['adventure_id'])) {
                    $adventure = Adventure::find((int) $params['adventure_id']);
                } else {
                    return json_encode(['result' => false, 'message' => 'Post  can`t be without activity']);
                }

                $validator = \Validator::make($params, ActivityComment::VALIDATION_RULES);

                if ($validator->passes()) {
                    $reply = new ActivityComment($params);
                    $reply->parent_id = ($post) ? $post->id : null;
                    $reply->user_id = \Auth::id();
                    $reply->like_count = 0;
                    $reply->reply_count = 0;
                    $reply->liked = json_encode([]);


                    $reply->save();
                    if ($adventure instanceof Adventure) {
                        $adventure->comments_count++;
                        $adventure->save();
                    }
                    $new = true;
                    $count = null;
                    if ($post instanceof ActivityComment) {
                        $post->reply_count++;
                        $post->save();
                        $new = false;
                        $count = $post->reply_count;
                    }
                    $activity = $reply->adventure;

                    $replyTitleHtml = view(
                        'app._partials.response_title',
                        ['model' => $activity, 'comment' => $reply]
                    )->render();
                    $html = view('app.activities.post_block', ['post' => $reply, 'activity' => $activity])->render();


                    return json_encode([
                        'result' => true,
                        'message' => 'Reply from user added',
                        'html' => $html,
                        'count' => $count,
                        'newPost' => $new,
                        'postId' => $reply->id,
                        'replyTitleHtml'  => $replyTitleHtml
                    ]);
                } else {
                    return json_encode(['result' => false, 'message' => 'Post test can`t be empty']);
                }
            } else {
                return json_encode(['result' => false, 'message' => 'Guest can`t reply post']);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }

    }
}
