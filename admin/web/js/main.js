$(function() {
    // 频道、分类联动 wmF7kPQru
    var $channel = $("#channel_id");
    var $cid1    = $("#cid1");
    var $cid2    = $("#cid2");

    var _init = function($cid, pid) {
        $cid.children("option:gt(0)").remove();
        if (pid) {
            $cid.append($cid.find("optgroup[label=" + pid + "]").find("option").clone());
        }
    }

    $cid1.bind("init", function() {
        _init($cid1, $channel.val());
    });
    $cid2.bind("init", function() {
        _init($cid2, $cid1.val());
    });
    $cid1.find("optgroup").hide().end().trigger("init");
    $cid2.find("optgroup").hide().end().trigger("init");

    $channel.change(function() {
        $cid1.trigger("init");
        $cid2.trigger("init");
    });
    $cid1.change(function() {
        $cid2.trigger("init");
    });

});

