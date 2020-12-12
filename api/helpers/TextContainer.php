<?php
/**
 * Created by PhpStorm.
 * Date: 19/12/10
 * Time: 15:49
 */

namespace api\helpers;


class TextContainer
{

    const TPL_PAY_CENTER_TIPS = 800;


    public static $textDes = [
        self::TPL_PAY_CENTER_TIPS => '%s充值（1元=%d%s）',

    ];

    /**
     * 取文本
     * @param $tplId
     * @return string
     */
    public static function getText($tplId) {
        if (!isset(self::$textDes[$tplId])) {
            return '';
        }

        $argv = func_get_args();

        $text = self::$textDes[$tplId];

        if (!empty($argv[1])) {
            array_splice($argv, 0, 1, $text);
            $text = call_user_func_array('sprintf', $argv);
        }

        return $text;
    }

}