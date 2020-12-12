<?php
namespace api\controllers;

use api\logic\CommentLogic;
use Yii;
use api\models\video\CommentLike;

class CommentController extends BaseController
{
    /**
     *  点赞
     */
    public function actionLike()
    {
        $commentId = $this->getParamOrFail('comment_id');
        $uid = Yii::$app->user->id;

        $commentLogic = new CommentLogic();
        $status = $commentLogic->like($uid, $commentId);

        return [
            'status' =>  $status == CommentLike::STATUS_YES ? 1 : 0,
        ];
    }

    /**
     * 提交影片评论
     */
    public function actionPostComment()
    {
        $content    = trim($this->getParamOrFail('content'));
        $videoId    = $this->getParamOrFail('video_id');
        $chapterId  = $this->getParam('chapter_id');
        $commentPid = $this->getParam('comment_id', 0);

        $uid = Yii::$app->user->id;

        $commentLogic = new CommentLogic();
        $res = $commentLogic->postComment($uid, $content, $videoId, $chapterId, $commentPid);

        return [
            'display' => $res['is_review'] ? 1 : 0,
            'data'    => $res['data'],
            'message' => $res['is_review'] ? '评论成功' : '评论成功,等待审核',
        ];
    }

    /**
     * 评论列表
     */
    public function actionList()
    {
        $videoId    = $this->getParamOrFail('video_id');
        $chapterId  = $this->getParam('chapter_id');
        $pageNum    = $this->getParam('page_num');

        $comment = new CommentLogic();
        return $comment->commentList($videoId, $chapterId, $pageNum);
    }
}