<?php
namespace wap\controllers;

use api\helpers\ErrorCode;
use common\models\BookChapter;
use common\models\AdvertPosition;
use common\models\UserAuth;
use common\helpers\Tool;
use common\models\WxSetting;
use Yii;
use yii\helpers\Url;
use yii\web\Cookie;
use common\models\Activity;
use common\models\ActivityLog;


class VideoController extends BaseController
{
    /**
     * 视频首页
     */
    public function actionIndex()
    {
        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id]);

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        if(!$data) {
            return $this->redirect('/site/error');
        }

        return $this->render('index',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id
        ]);
    }

    /**
     * 搜索页
     */
    public function actionSearch()
    {
        //搜索首页信息
        $data = Yii::$app->api->get('/search/hot-word');

        return $this->render('search', [
            'data' => $data
        ]);
    }

    /**
     * 搜索结果页
     */
    public function actionSearchResult()
    {
        //获取搜索关键字、频道
        $keyword = Yii::$app->request->get('keyword');

        //搜索首页信息
        $data = Yii::$app->api->get('/search/result', ['keyword' => $keyword]);

        return $this->render('search-result', [
            'data'      => $data,
            'keyword'   => $keyword
        ]);
    }

    /**
     * 根据频道、关键字进行搜索
     */
    public function actionSearchResultMore()
    {
        //获取搜索关键字、频道
        $keyword = Yii::$app->request->get('keyword');
        $channel_id = Yii::$app->request->get('channel_id', 1);

        //搜索首页信息
        $data = Yii::$app->api->get('/search/result', ['keyword' => $keyword, 'channel_id' => $channel_id]);

        return Tool::responseJson(0, '操作成功', $data);
    }

    /**
     * 视频播放详情页
     */
    public function actionDetail()
    {
        //获取影片系列、剧集、源信息
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', '');
        $source_id = Yii::$app->request->get('source_id', '');

        //请求视频信息
        $info = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id]);

        if(!$info) {
            return $this->redirect('/site/error');
        }

        return $this->render('detail', [
            'info'      => $info,
            'source_id' => $source_id
        ]);
    }

    /**
     * 视频列表页
     */
    public function actionList()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $tag = Yii::$app->request->get('tag', '');

        //请求影片筛选信息
        $info = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'page_size' => 12]);

        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('list', [
            'info'          => $info,
            'channel_id'    => $channel_id,
            'tag'           => $tag,
            'hot'           => $hot
        ]);
    }

    /**
     * 换一换
     */
    public function actionRefresh()
    {
        //获取频道、标签信息
        $recommend_id = Yii::$app->request->get('recommend_id', 0);

        //请求换一换信息信息
        $data = Yii::$app->api->get('/video/refresh', ['recommend_id' => $recommend_id]);

        return Tool::responseJson(0, '操作成功', $data);
    }


    /**
     * 视频筛选接口
     */
    public function actionRefreshCate()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', '');
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $page_num = Yii::$app->request->get('page_num', 1);

        //请求影片筛选信息
        $data = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area, 'year' => $year, 'page_num' => $page_num, 'page_size' => 12]);


        return Tool::responseJson(0, '操作成功', $data);
    }


    /**
     * 切换下一集
     */
    public function actionSwitchVideo()
    {
        //获取影片系列、剧集、源信息
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', '');
        $source_id = Yii::$app->request->get('source_id', '');

        //请求视频信息
        $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id]);

        return Tool::responseJson(0, '操作成功', $data );
    }
}
