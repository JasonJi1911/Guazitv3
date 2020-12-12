<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<style>
    .info-box {
        display: block;
        min-height: 90px;
        background: #f9f8f8;
        width: 100%;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-bottom: 15px;
        display: flex;
    }
    .home-block-left {
        width:5px;
        background:  #a9c6e0;
        /*border-radius: 2px;*/
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .home-block-right {
        flex: 2;
        line-height: 1.7;
        padding-left: 10px;
        font-size: 18px;
    }
    .home-block-right .sum_pay_by_time {
        margin-top: .7rem;
    }
    .home-block-right .sum_pay_by_time div{
        font-size: 22px;
    }
    .home-block-right {
        flex: 2;
        line-height: 1.7;
    }
    .home-block-right ul {
        margin: 7px 0 5px 0;
        padding: 0;
    }
    .home-block-right ul li {
        list-style: none;
        display: inline-block;
        font-size: 13px;
        margin-left: 0;
        width: 47%;
    }
    .home-block-right ul li div b {
        color: #1654CC;
        font-weight: 400;
    }
    .home-block-right ul li div {
        font-size: 14px;
    }
    .home-block-right ul li span {
        color: #8a6d3b;
        padding: 0 4px;
    }
    .text-warning {
        color: #8a6d3b;
    }
    .userSex {
        font-size: 13px;
        margin: 2px 0px;
        font-weight: 300;
    }
    .userPay {
        font-size: 14px;
        font-weight: 300;
    }
</style>

