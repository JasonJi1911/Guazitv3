<?php
namespace api\controllers;

use api\dao\AnswerDao;
use api\logic\AnswerLogic;

/**
 * 帮助问题
 */
class AnswerController extends BaseController
{
    /**
     * 帮助问题列表
     */
    public function actionList()
    {
        $answerDao = new AnswerDao();
        return ['help_list' => $answerDao->answerList()];
    }

    /**
     * 提交意见反馈
     */
    public function actionPostFeedback()
    {
        $content = $this->getParamOrFail('content');
        $contact = $this->getParamOrFail('contact', '');
        $imgs    = trim($this->getParam('imgs', ''));

        $answerLogic = new AnswerLogic();
        $answerLogic->addFeedback($content, $contact, $imgs);

        return [];
    }

    /**
     * 我的反馈列表
     */
    public function actionFeedbackList()
    {
        $answerDao = new AnswerDao();
        return $answerDao->feedbackList();
    }

}
