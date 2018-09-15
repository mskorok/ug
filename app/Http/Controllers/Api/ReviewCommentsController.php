<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Reviews\Review;
use App\Models\Reviews\ReviewComment;
use App\Models\Users\BlockedUsers;
use Request;

/**
 * Class ReviewCommentsController
 * @package App\Http\Controllers\Api
 */
class ReviewCommentsController extends Controller
{
    /**
     *
     * @param ReviewComment $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function like(ReviewComment $post)
    {

        if (Request::ajax()) {
            if (\Auth::check()) {
                $user = $post->user;
                $id = \Auth::id();
                /*
                $blocked = BlockedUsers::where('user_id', '=', $user->id)
                    ->where('blocked_user_id', '=', \Auth::id())->get();
                if ($blocked->count() > 0) {
                    return json_encode(['result' => false, 'message' => 'Blocked user can`t like this review']);
                }
                */

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
                    'result' => true,
                    'message' => 'Like from user added',
                    'count' => count($liked),
                    'id' => $post->id
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
                    $post = ReviewComment::find((int)$id);
                    if (!$post) {
                        return json_encode(['result' => false, 'message' => 'Post not found']);
                    }
                    if ($post->parent_id) {
                        return json_encode(['result' => false, 'message' => 'User can reply only first line post']);
                    }
                }

                $params = Request::input();
                $review = null;

                if (array_key_exists('review_id', $params) && !empty($params['review_id'])) {
                    $review = Review::find((int)$params['review_id']);
                } else {
                    return json_encode(['result' => false, 'message' => 'Post  can`t be without review']);
                }

//                $blocked = BlockedUsers::where('user_id', '=', $review->user->id)
//                    ->where('blocked_user_id', '=', \Auth::id())->get();
//                if ($blocked->count() > 0) {
//                    return json_encode(['result' => false, 'message' => 'Blocked user can`t post this review']);
//                }

                $validator = \Validator::make($params, ReviewComment::VALIDATION_RULES);

                if ($validator->passes()) {
                    $reply = new ReviewComment($params);
                    $reply->parent_id = ($post) ? $post->id : null;
                    $reply->user_id = \Auth::id();
                    $reply->like_count = 0;
                    $reply->reply_count = 0;
                    $reply->liked = json_encode([]);


                    $reply->save();

                    if ($review instanceof Review) {
                        $review->comments_count++;
                        $review->save();
                    }
                    $new = true;
                    $count = null;
                    if ($post instanceof ReviewComment) {
                        $post->reply_count++;
                        $post->save();
                        $new = false;
                        $count = $post->reply_count;
                    }

                    $replyTitleHtml = view(
                        'app._partials.response_title',
                        ['model' => $reply->review, 'comment' => $reply]
                    )->render();
                    $html = view('app.reviews.post_block', ['post' => $reply, 'review' => $reply->review])->render();


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

    /**
     * @param Request $request
     * @param ReviewComment $reviewComment
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function deleteReply(Request $request, ReviewComment $reviewComment)
    {
        if (Request::ajax()) {
            if ($reviewComment->user->id == \Auth::id() || \Auth::guard('admin')->check()) {
                $reviewComment->delete();
                return json_encode(['result' => true, 'message' => 'Post deleted']);
            } else {
                return json_encode(['result' => false, 'message' => 'Post test can be deleted only by user or admin']);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }
    }
}
