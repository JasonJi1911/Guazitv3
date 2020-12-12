<?php
namespace api\controllers;

use api\dao\ActorDao;

class ActorController extends BaseController
{
    /**
     * 演员参演的影片
     */
    public function actionVideos()
    {
        $actorId = $this->getParamOrFail('actor_id');

        //获取缓存信息
        $actorDao = new ActorDao();
        return $actorDao->actorVideo($actorId);
    }

    /**
     * 演员列表首页,根据地域分组
     */
    public function actionListIndex()
    {
        $actorDao = new ActorDao();
        $allArea = $actorDao->allActorArea();

        //循环演员列表,复制地域信息
        foreach ($allArea as &$area) {
            $actors = $actorDao->actorsByArea($area['area_id']); //获取演员信息,返回第一页数据
            $area['actors'] = $actors['list'];
        }
        $data['list'] = $allArea;

        return $data;
    }

    /**
     * 演员列表详情,返回此地域下所有演员
     */
    public function actionListDetail()
    {
        $areaId   = $this->getParamOrFail('area_id');
        $pageNum  = $this->getParam('page_num', 1);
        $pageSize = $this->getParam('page_size', DEFAULT_PAGE_SIZE);

        $actorDao = new ActorDao();
        return $actorDao->actorsByArea($areaId, $pageNum, $pageSize);
    }
}
