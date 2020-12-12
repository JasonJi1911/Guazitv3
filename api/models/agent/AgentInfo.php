<?php
namespace api\models\agent;

class AgentInfo extends \common\models\agent\AgentInfo
{
    public function fields()
    {
        return [
            'admin_id',
            'agent_admin_pid',
            'drp_url',
            'auth_url',
            'final_url'
        ];
    }
}
