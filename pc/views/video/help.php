<?php

use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '吉祥视频';
NewIndexStyleAsset::register($this);
$name = LOGONAME . '视频';
$logo = LOGONAME;
?>
<style>
    .ADbzhidden {
        display: none;
    }

    body{
        background-color: #F9F9F9;
    }
</style>
<input id="helptab" type="hidden" value="<?= $helptab ?>"/>
<div class="help-box">
    <!--排行榜标题-->
    <div class="RANbox-help-title">
        <div class="RANbox-help-title-name">
            <img src="/images/Index/help.png"/><span>帮助中心</span>
        </div>
    </div>
    <ul class="RANbox-help-tab">
        <!--        class="act"-->
        <li class="c_question">
            <div class="help-img-icon">
                <img class="J_per_tab_img" src="/images/Index/changjianwenti.png" style="display:none;">
                <img class="J_per_tab_img_c" src="/images/Index/changjianwenti_c.png">
            </div>
            常见问题
        </li>
<!--        <li>-->
<!--            <div class="help-img-icon"><img src="/images/Index/shangchuan-2.png"></div>-->
<!--            视频上传-->
<!--        </li>-->
<!--        <li class="c_feedback">-->
<!--            <div class="help-img-icon"><img src="/images/Index/icon-zaixianfankui.png"></div>-->
<!--            在线反馈-->
<!--        </li>-->
        <li class="c_pwd">
            <div class="help-img-icon">
                <img class="J_per_tab_img" src="/images/Index/wangjimima.png">
                <img class="J_per_tab_img_c" src="/images/Index/wangjimima_c.png" style="display:none;">
            </div>
            忘记密码
        </li>
        <li class="c_aboutUs">
            <div class="help-img-icon">
                <img class="J_per_tab_img" src="/images/Index/guanyuwomen.png">
                <img class="J_per_tab_img_c" src="/images/Index/guanyuwomen_c.png" style="display:none;">
            </div>
            关于我们
        </li>
        <li class="c_terms">
            <div class="help-img-icon">
                <img class="J_per_tab_img" src="/images/Index/xieyiyaoqingx.png">
                <img class="J_per_tab_img_c" src="/images/Index/xieyiyaoqingx_c.png" style="display:none;">
            </div>
            用户协议
        </li>
        <li class="c_contact">
            <div class="help-img-icon">
                <img class="J_per_tab_img" src="/images/Index/lianxiwomen.png">
                <img class="J_per_tab_img_c" src="/images/Index/lianxiwomen_c.png" style="display:none;">
            </div>
            联系我们
        </li>
        <li class="c_appdownload">
            <div class="help-img-icon">
                <img class="J_per_tab_img" src="/images/Index/xiazai-3.png">
                <img class="J_per_tab_img_c" src="/images/Index/xiazai-3_c.png" style="display:none;">
            </div>
            app下载
        </li>
    </ul>

    <div class="RANbox-help">
        <!--常见问题 act-->
        <div class="helpbox01 c_question">

            <ul class="hlptab-a" name="zt">
                <li class="act">访问须知</li>
                <li>无法打开网站</li>
                <li>注册和登录相关问题</li>
                <li>影片播放相关问题</li>
                <li>视频下载相关问题</li>
            </ul>
            <div class="hlptab-box" name="zt" >
                <!--访问须知-->
                <div class="hlp-w act">
                    <div class="hlp-text">
                        <div class="hlp-text01" style="">
                            可访问本平台的国家和地区
                        </div>
                        <div class="hlp-text02">
                            本平台只对海外用户服务，中国大陆地区无法访问。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            设备内干净无毒
                        </div>
                        <div class="hlp-text02">
                            确保您的设备干净无毒，出于安全考虑，本站防火墙会封锁带毒设备的IP地址。并建议打开系统自带安全软件或启动其他的安全软件。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            由当地网络运营商直接提供的上网环境
                        </div>
                        <div class="hlp-text02">
                            建议使用从当地网络运营商接入的家用/办公网络，不推荐使用：1.附近的未加密WIFI；2.有流量限制的手机4G网络；3.校园网，大部分校园网会封锁各种端口，包括本平台的播放器；4.网吧环境，某些网吧的管理系统也会屏蔽播放器端口。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            本站对访问设备和浏览器有何要求？
                        </div>
                        <div class="hlp-text02">
                            本站支持绝大多数电子产品包括：PC、MAC、iPad、iPhone6或以上机型、安卓手机等。
                            本站支持的浏览器：Chrome、EDGE、IE11、360浏览器、SAFARI。请确保您的浏览器没有阻止cookies！<br/><br/>
                        </div>
                    </div>
                </div>
                <!--无法打开网站-->
                <div class="hlp-w">
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            出现“/”应用程序中的服务器错误
                        </div>
                        <div class="hlp-text02">
                            网站正在维护中，通常不会超过30分钟，如果长时间一直提示该错误，请立即联系客服！
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            提示“403-禁止访问：访问被拒绝”
                        </div>
                        <div class="hlp-text02">
                            1.您可能身在中国大陆或本站禁止访问的地区。<br/><br/> 2.您的电脑感染木马，已被本站防火墙封锁IP。
                            <br/><br/> 3.您在网站上有违规行为，已被管理员封锁IP。
                            <br/><br/>
                        </div>
                    </div>
                </div>
                <!--注册和登录相关问提-->
                <div class="hlp-w">
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            注册或登录时总是提示“验证码错误或已过期！”
                        </div>
                        <div class="hlp-text02">
                            请先清除浏览器cookies和历史记录再尝试登录
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            提示“检测到您的帐号在别处登录”然后自动退出登录
                        </div>
                        <div class="hlp-text02">
                            1.多人共用一个VIP帐号。请勿将VIP帐号告诉其他人，以免影响您的使用。 升级为情侣会员，即可2人同时登录。<br/><br/> 2.您的VIP帐号已被盗。请立即联系客服解决此问题！
                            <br/><br/> 3.请先清除浏览器cookies和历史记录再尝试登录
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            登录时提示“账号已被冻结”
                        </div>
                        <div class="hlp-text02">
                            1.您使用信用卡开通VIP后，信用卡额度不够导致拒付或您人为进行了信用卡拒付操作。<br/><br/>
                            2.您发表了不恰当的言论，违反了平台规定，如：宣传同类平台、发布广告、挂马网站、反动、欺诈内容、辱骂管理员等。
                            <br/><br/>
                        </div>
                    </div>
                </div>
                <!--影片播放相关问题-->
                <div class="hlp-w">
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            为什么看不到播放列表？
                        </div>
                        <div class="hlp-text02">
                            1.您使用的浏览器不支持本站<br/><br/> 2.您的浏览器安装了广告过滤插件，请先卸载此类插件
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            播完广告之后提示“加载失败”，或者没有提示，影片没有开始播放
                        </div>
                        <div class="hlp-text02">
                            1.如果某个视频黑屏无法播放，说明该视频上传用户进行上传视频时发生某种错误，请立即联系客服进行处理。<br/><br/> 2
                            您电脑上的某些安全软件的设置造成了屏蔽各种游戏、视频网站的端口等防护措施，如McAfee、诺顿、瑞星等。请先检查这些防火墙的设置以及进行相关操作。<br/><br/>
                            3.您的网络上可能设置了防火墙，请联系您的网络运营商，或咨询专业的电脑维修人士解决。
                            <br/><br/> 4. 您可能处于校园网或某企业内网，此类网络大多会屏蔽各种游戏、视频网站的端口。<br/><br/>
                            5.某些网吧的管理系统会屏蔽本站播放器端口，请联系网吧管理员。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            可访问本平台的国家和地区
                        </div>
                        <div class="hlp-text02">
                            本平台只对海外用户服务，中国大陆地区无法访问。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            Mac电脑全屏播放时候会闪屏
                        </div>
                        <div class="hlp-text02">
                            请尝试更换浏览器打开本站进行观看。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            iPhone或iPad使用safari浏览器，播放器中间是一个禁止播放的按钮。
                        </div>
                        <div class="hlp-text02">
                            可选择[兼容]和[流畅]两种播放模式，一种方式无法播放请尝试切换另一种。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            影片音量较小该怎么办？
                        </div>
                        <div class="hlp-text02">
                            使用桌面版播放器，内置有扩大音量设置。可尝试点击键盘的向上方向键（⬆）即可扩大音量至大于100%。
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            我安装了广告过滤插件，视频无法播放了
                        </div>
                        <div class="hlp-text02">
                            部分恶意广告屏蔽插件，会破坏整个页面元素。本站广告已经过初步筛选，并根据算法针对个人情况进行推荐，如广告不会打扰到您，请关闭广告屏蔽插件！<br/>
                            由于广告合作伙伴的支持，本网站才可以为您提供免费的视频服务。
                            <br/> 如果您使用了浏览器的广告过滤功能或工具，请在您的浏览器设置中停用该功能或取消对相关网址的屏蔽。<br/>如果您使用的是遨游浏览器，请点击右下角的“广告猎手”，然后选择“编辑过滤规则”：<br/><br/>

                            <img src="/images/newindex/ad_01.gif"/><br/><br/> 然后在弹出来的对话框中清除所有规则，使其保持为空：
                            <br/><br/>
                            <img src="/images/newindex/ad_02.gif"/><br/><br/> 最后点击“完成”按钮。
                            <br/> 如果您使用的是360网盾，请点击360网盾中“广告过滤”功能按钮：
                            <br/><br/>
                            <img src="/images/newindex/ad_03.gif"/><br/><br/> 将其中的有关规则关闭。
                            <br/> 如果您使用的是金山毒霸，请依次点击金山毒霸中的“百宝箱”——“广告过滤”，然后切换到“全部规则细节”选项卡：
                            <br/><br/>
                            <img src="/images/newindex/ad_04.gif"/><br/><br/> 选中其中所有有关的规则，点击“删除”。
                            <br/> 如果你使用了谷歌的chrome浏览器，请检查是否安装并使用了广告屏蔽插件如“Adblock 、Adblock plus或者adkill"等插件<br/><br/>
                            <img src="/images/newindex/ad_05.gif"/><br/><br/> 此时可以在“设置-扩展程序”中，点击取消“已启用”即可
                            <br/><br/>
                            <img src="/images/newindex/ad_06.gif"/><br/><br/>
                            如果您曾经修改过hosts文件，则请用记事本打开c:\windows\system32\drivers\etc\hosts，删除掉有含有相关网址的行，然后保存即可。
                            <br/> 如果您使用的是Windows Vista或Windows 7，则可能需要以管理员身份运行记事本，其方法是：在记事本上单击右键，选择 <br/><br/>
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            播放器右上角一直显示广告剩余XX秒，倒计时结束后视频却无法播放。
                        </div>
                        <div class="hlp-text02">
                            1.您使用的浏览器不支持本站，请尝试更换浏览器进行观看。<br/><br/> 2.您的浏览器安装了广告过滤插件，请先卸载此类插件。
                            <br/><br/>
                        </div>
                    </div>
                </div>
                <!--视频下载相关问题-->
                <div class="hlp-w">
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            如何下载网站上的视频？
                        </div>
                        <div class="hlp-text02">
                            请下载移动端APP或PC客户端进行下载，不支持网页端下载。<br/><br/> 开通VIP才能够拥有下载视频的权限。
                            <br/>
                        </div>
                    </div>
                    <div class="hlp-text">
                        <div class="hlp-text01">
                            为什么下载速度特别慢，或速度为0？
                        </div>
                        <div class="hlp-text02">
                            1.您电脑上的某些安全软件的设置造成了屏蔽各种游戏、视频网站的端口等防护措施，如McAfee、诺顿、瑞星等。请先检查这些防火墙的设置以及进行相关操作。<br/><br/>
                            2.您的网络上可能设置了防火墙，请联系您的网络运营商，或咨询专业的电脑维修人士解决。
                            <br/><br/> 3.您可能处于校园网或某企业内网，此类网络大多限制下载软件使用或限制速度。
                            <br/><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--视频上传-->
        <!--<div class="helpbox01">
            <div class="hlp-box02" name="zt">
                <p> 您制作、评论、发布、传播的信息（包括但不限于随拍或上传至“<?= $name ?>”平台的未公开的私密视频）应自觉遵守社会公共秩序、道德风尚和信息真实性等要求，否则<?= $name ?>
                    有权立即采取相应处理措施。您应不制作、复制、发布、传播下列信息： </p>
                <ul>
                    <li>（1）反对宪法确定的基本原则的；</li>
                    <li>（2）危害国家安全，泄露国家秘密的；</li>
                    <li>（3）颠覆国家政权，推翻社会主义制度，煽动分裂国家，破坏国家统一的；</li>
                    <li>（4）损害国家荣誉和利益的；</li>
                    <li>（5）宣扬恐怖主义、极端主义的；</li>
                    <li>（6）宣扬民族仇恨、民族歧视，破坏民族团结的；</li>
                    <li>（7）煽动地域歧视、地域仇恨的；</li>
                    <li>（8）破坏国家宗教政策，宣扬邪教和封建迷信的；</li>
                    <li>（9）编造、散布谣言、虚假信息，扰乱经济秩序和社会秩序、破坏社会稳定的；</li>
                    <li>（10）散布、传播淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</li>
                    <li>（11）危害网络安全、利用网络从事危害国家安全、荣誉和利益的；</li>
                    <li>（12）侮辱或者诽谤他人，侵害他人合法权益的；</li>
                    <li>（13）对他人进行暴力恐吓、威胁，实施人肉搜索的；</li>
                    <li>（14）涉及他人隐私、个人信息或资料的；</li>
                    <li>（15）散布污言秽语，损害社会公序良俗的；</li>
                    <li>（16）侵犯他人隐私权、名誉权等权益内容的；</li>
                    <li>（17）散布商业广告，或类似的商业招揽信息、过度营销信息及垃圾信息；</li>
                    <li>（18）使用本网站常用语言文字以外的其他语言文字评论的；</li>
                    <li>（19）与所评论的信息毫无关系的；</li>
                    <li>（20）所发表的信息毫无意义的，或刻意使用字符组合以逃避技术审核的；</li>
                    <li>（21）侵害未成年人合法权益或者损害未成年人身心健康的；</li>
                    <li>（22）未获他人允许，偷拍、偷录他人，侵害他人合法权利的；</li>
                    <li>（23）包含恐怖、暴力血腥、高危险性、危害表演者自身或他人身心健康内容的，包括但不限于以下情形：
                        <ul>
                            <li>i. 任何暴力和/或自残行为内容；</li>
                            <li>ii. 任何威胁生命健康、利用刀具等危险器械表演的危及自身或他人人身及/或财产权利的内容；</li>
                            <li>iii.怂恿、诱导他人参与可能会造成人身伤害或导致死亡的危险或违法活动的内容；</li>
                        </ul>
                    </li>
                    <li>（24）其他含有公序良俗、干扰“<?= $name ?>”正常运营或侵犯其他用户或第三方合法权益内容的信息。</li>
                </ul>
                <p>
                    您制作、发布、传播的内容需遵守规定，不得利用基于深度学习、虚拟现实等的新技术新应用制作、发布、传播虚假新闻信息。您在发布或传播利用基于深度学习、虚拟现实等的新技术新应用制作的非真实音视频信息时，应当以显著方式予以标识。 </p>
                <p> <?= $name ?>设立公众投诉、举报平台，您可按照公示的投诉举报制度，投诉、举报各类违规行为、违规传播活动、有害信息等内容，<?= $name ?>
                    将及时受理和处理您的投诉举报，以共同营造风清气正的网络空间。 </p>
            </div>
        </div>-->
        <!--在线反馈-->
        <!--<div class="helpbox01 c_feedback">
            <div class="hlp-kf" name="zt">
                <div class="hlp-kf-l">
                    <img src="/images/newindex/kefu.png"/>
                    <div>
                        <div>
                            智能在线客服
                        </div>
                        <div>
                            周一至周日9:00～24:00
                        </div>
                    </div>
                </div>
                <a class="hlp-kf-R" href="https://t.me/joinchat/9Wel0AHM2nkxY2Q1" target="_blank">
                    立即联系
                </a>
            </div>
            <div class="hlp-bd" name="zt">
                <div class="hlp-t03" name="zt">
                    在线反馈<span class="font-color-FF556E" id="v_feedback_login">(您需要先登录才能提交反馈)</span>
                </div>
                <ul class="hlp-bd-box" name="zt">
                    <li>
                        <div><span class="font-color-FF556E">*</span>您所在的国家：</div>
                        <div><span class="font-color-FF556E">*</span>您的上网环境：</div>
                        <div><span class="font-color-FF556E">*</span>您使用的设备和系统：</div>
                        <div><span class="font-color-FF556E">*</span>您使用的浏览器：</div>
                        <div><span class="font-color-FF556E">*</span>问题描述：</div>
                    </li>
                    <li>
                        <div class="seekbox-ipt">
                            <input type="text" name="zt" id="v_country" placeholder="输入国家" value="" />
                        </div>
                        <div>
                            <select class="seek-slk" name="zt" id="v_country">
                                <?php if (!empty($feedbackinfo['country'])) : ?>
                                    <?php foreach ($feedbackinfo['country'] as $internet): ?>
                                        <option value="<?= $internet['country_id'] ?>"><?= $internet['country_name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <select class="seek-slk" name="zt" id="v_internet">
                                <?php if (!empty($feedbackinfo['internet'])) : ?>
                                    <?php foreach ($feedbackinfo['internet'] as $internet): ?>
                                        <option value="<?= $internet['id'] ?>"><?= $internet['message'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <select class="seek-slk" name="zt" id="v_system">
                                <?php if (!empty($feedbackinfo['system'])) : ?>
                                    <?php foreach ($feedbackinfo['system'] as $system): ?>
                                        <option value="<?= $system['id'] ?>"><?= $system['message'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <select class="seek-slk" name="zt" id="v_browser">
                                <?php if (!empty($feedbackinfo['browser'])) : ?>
                                    <?php foreach ($feedbackinfo['browser'] as $browser): ?>
                                        <option value="<?= $browser['id'] ?>"><?= $browser['message'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="seekbox-tta" style="overflow:visible;">
                            <textarea id="v_description" placeholder="请详细描述问题现象以及出现了哪些错误提示等等，至少10个字。"
                                      name="zt"></textarea>
                        </div>
                        <p>
                            如果您的描述只有“视频无法播放”，“网站打不开”， “为什么不能登录”这类毫无信息量的文字，客服将直接忽略您的问题。
                        </p>
                        <input class="seek-btn-help" type="button" name="" id="v_submit" value="提交"/>
                    </li>
                </ul>
            </div>
        </div>-->
        <!--忘记密码-->
        <div class="helpbox01 c_pwd J_safe">
            <div class="alt-content02" name="zt">
                <div class="hlp-forget-pass-title">您的账号当前处于安全环境，可找回密码</div>
            </div>
            <div class="hlp-forget-pass-content J_safe_auth_title">
                <div class="hlp-forget-pass-item">

                    <div class="hlp-forget-pass-jindu">
                        <div class="hlp-forget-pass-line hlp-forget-pass-line-01 act"></div>
                        <div class="hlp-forget-pass-jindu-01 act">
                            1
                        </div>
                    </div>
                    <p class="hlp-forget-pass-desc act">安全认证</p>
                </div>
                <div class="hlp-forget-pass-item">
                    <div class="hlp-forget-pass-jindu">
                        <div class="hlp-forget-pass-line hlp-forget-pass-line-02 J_line2"></div>
                        <div class="hlp-forget-pass-jindu-01 J_jindu2">
                            2
                        </div>
                    </div>
                    <p class="hlp-forget-pass-desc J_auth_text2">找回密码</p>
                </div>
                <div class="hlp-forget-pass-item">
                    <div class="hlp-forget-pass-jindu">
                        <div class="hlp-forget-pass-line hlp-forget-pass-line-03 J_line3"></div>
                        <div class="hlp-forget-pass-jindu-01 J_jindu3">
                            3
                        </div>
                    </div>
                    <p class="hlp-forget-pass-desc J_auth_text3">操作成功</p>
                <div class="hlp-forget-pass-text"></div>
                </div>
            </div>
            <div class="hlp-forget-pass-sub J_safe_auth">
                <div class="help-te-box act J_step_one">
                    <div class="inp-box J_account">
                        <span class="inp-title">账号</span>
                        <ul class="opJ J_opt_country">
                            <?php
                            $selectVal = "";
                            $selectData = "";
                            foreach ($channels['country_info'] as $country){
                                if($country['mobile_areacode']!=''){
                                    $selectVal = $country['country_name'] . '+' . $country['mobile_areacode'];
                                    $selectData = '+' . $country['mobile_areacode'];
                                    break;
                                }
                            }
                            ?>
                            <?php if(!empty($channels['country_info'])) :?>
                                <?php foreach ($channels['country_info'] as $country): ?>
                                    <?php if($country['mobile_areacode']!=''):?>
                                        <li data="<?=$country['country_name']?>+<?=$country['mobile_areacode']?>"><?=$country['country_name']?><span>+<?=$country['mobile_areacode']?></span></li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                        <input type="button" class="selectJ J_select_country" value="<?=$selectVal?>" data="<?=$selectData?>"/>
                        <input class="tel J_phone" type="text" name="" placeholder="请输手机号" value="" />
                    </div>
                    <div class="bttn-box-warning J_warning">账号有误</div>
                    <div class="bttn-box J_first_step">
                        <input type="button" value="找回密码" />
                    </div>
                </div>
                <div class="help-tel-check-box J_step_two">
                    <div class="help-tel-check">通过手机<span class="J_hide_account">155******02</span>验证</div>
                    <div class="bttn-box-warning1 J_warning1">验证码发送失败</div>
                </div>
                <div class="help-tel-check-code-box J_step_two2">
                    <div class="help-tel-check-item">
                        <p>短信验证码已经发送至<span class="J_hide_account">155******02</span></p>
                        <div class="help-tel-check-code">
                            <input class="yzm J_yzm" type="text" name="" value="" />
                            <input type="button" class="yzm-btn J_second_step" id="reg_prefix_phone" value="验证" />
                        </div>
                        <div class="bttn-box-warning2 J_warning2">验证码发送失败</div>
                        <p>未收到验证码？<span class="J_count_down">53s后重新发送</span></p>
                    </div>
                </div>
                <div class="help-pass-box J_step_two3">
                    <div class="inp-box pasbox">
                        <span class="inp-title">新密码</span>
                        <input type="password" class="inp pas J_new_pass" name="" placeholder="请输入密码" id="login_pwd" value="" onkeyup="value=value.replace(/[^(\w-*\.*)]/g,'')" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" autocomplete="off">
                        <input type="button" class="eye" value="">
                    </div>
                    <div class="inp-box pasbox">
                        <span class="inp-title">确认密码</span>
                        <input type="password" class="inp pas J_sure_pass" name="" placeholder="请再次输入密码" id="login_pwd" value="" onkeyup="value=value.replace(/[^(\w-*\.*)]/g,'')" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" autocomplete="off">
                        <input type="button" class="eye" value="">
                    </div>
                    <div class="inp-box pasbox J_inp_box_warning" style="display: none;">
                        <span class="inp-title"></span>
                        <div class="bttn-box-warning3 J_warning3">两次输入密码不一致</div>
                    </div>
                    <div class="inp-box pasbox">
                        <span class="inp-title"></span>
                        <input type="button" value="确认" class="inp-sure-btn J_three_step"/>
                    </div>
                </div>
                <div class="help-pass-set J_step_three">
                    <div class="help-pass-set-success">恭喜您设置成功！</div>
                </div>
            </div>
        </div>
        <!--关于我们-->
        <div class="helpbox01 c_aboutUs">
            <div class="hlp-us" name="zt">
                <ul>
                    <li class="hlp-us-img01">&nbsp;</li>
                    <li>
                        <div class="hlp-text05">
                            关于我们
                        </div>
                        <div class="hlp-text06">
                            <?= $name ?>
                            是一家由海外华人创立、面向海外华人服务的视频平台，现可支持PC（Windows、macOS）、电视、移动（IOS、Android）三大终端，兼具多种多样的内容形态。<br/><br/>
                            作为海外视频行业领先者，<?= $name ?>
                            为全球超6000万华人用户提供全面网络服务，致力于打造涵盖多种视频类型的海外华人视频分享平台。在这里您可以看到来自全球各地华人制作，分享的各类影视资讯，新闻热点等。同时，作为海外视频行业领先者，<?= $name ?>
                            拥有海量付费用户，坚持为广大VIP会员提供专属的精品内容，极致的视听体验和独有的VIP特权。
                        </div>
                    </li>
                </ul>
                <ul>
                    <li class="hlp-us-img02">&nbsp;</li>
                    <li>
                        <div class="hlp-text05">
                            品牌口号
                        </div>
                        <div class="hlp-text06">
                            海外远航，<?= $logo ?>随行
                        </div>
                    </li>
                </ul>
                <ul>
                    <li class="hlp-us-img03">&nbsp;</li>
                    <li>
                        <div class="hlp-text05">
                            企业理念
                        </div>
                        <div class="hlp-text06">
                            旨作引领海外华人视频行业的媒体时代领军者。
                        </div>
                    </li>
                </ul>
                <ul>
                    <li class="hlp-us-img04">&nbsp;</li>
                    <li>
                        <div class="hlp-text05">
                            公司地址
                        </div>
                        <div class="hlp-text06">
                            捷克 布拉格 Budějovická 1912/64b, Hongyuan Technology Studio（九二科技）
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!--用户协议-->
        <div class="helpbox01 c_terms">
            <div class="hlp-xy" name="zt">
                <h3>“<?= $name ?>”用户服务协议</h3>
                <h4>1.导言</h4>
                <p>欢迎您使用“<?= $name ?>”软件及相关服务！</p>
                <p> “<?= $name ?>”软件及相关服务，系指<?= $name ?>（以下简称“公司”）合法拥有并运营的、标注名称为“<?= $name ?>
                    ”的客户端应用程序（同时含其简化版等不同版本）以及相关网站向您提供的产品与服务，包括但不限于个性化音视频推荐、网络直播、发布信息、互动交流、搜索查询等核心功能及其他功能。《“<?= $name ?>
                    ”用户服务协议》（以下称“本协议”）是您与公司就您下载、安装、注册、登录、使用（以下统称“使用”）“<?= $name ?>”软件，并获得“<?= $name ?>
                    ”软件提供的相关服务所订立的协议。 </p>
                <p> 为了更好地为您提供服务，请您在开始使用“<?= $name ?>
                    ”软件及相关服务之前，认真阅读并充分理解本协议，特别是涉及免除或者限制责任的条款、权利许可和信息使用的条款、同意开通和使用特殊单项服务的条款、法律适用和争议解决条款等。其中，免除或者限制责任条款等重要内容将以加粗形式提示您注意，您应重点阅读。 </p>
                <p> 如您未满18周岁，请您在法定监护人陪同下仔细阅读并充分理解本协议，并征得法定监护人的同意后使用“<?= $name ?>”软件及相关服务。 </p>
                <p> 如您不同意本协议，这将导致公司无法为您提供完整的产品和服务，您也可以选择停止使用。如您自主选择同意或使用“<?= $name ?>
                    ”软件及相关服务，则视为您已充分理解本协议，并同意作为本协议的一方当事人接受本协议以及其他与“<?= $name ?>”软件及相关服务相关的协议和规则（包括但不限于《“<?= $name ?>
                    ”隐私政策》）的约束。 </p>
                <p> 公司有权依“<?= $name ?>”软件及相关服务或运营的需要单方决定，安排或指定其关联方、控制公司、继承公司或公司认可的第三方公司继续运营“<?= $name ?>
                    ”软件。并且，就本协议项下涉及的某些服务，可能会由公司的关联方、控制公司、继承公司或公司认可的第三方公司向您提供。您知晓并同意接受相关服务内容，即视为接受相关权利义务关系亦受本协议约束。 </p>
                <p>如对本协议内容有任何疑问、意见或建议，您可通过登录“<?= $name ?>”客户端内的“帮助中心”页面或发送邮件与公司联系。</p>
                <h4>2.“<?= $name ?>”软件及相关服务</h4>
                <ul>
                    <li> 2.1您使用“<?= $name ?>”软件及相关服务，可以通过预装、公司已授权的第三方下载等方式获取“<?= $name ?>”客户端应用程序或访问<?= $name ?>
                        相关网站。若您并非从公司或经公司授权的第三方获取“<?= $name ?>”软件的，公司无法保证非官方版本的“<?= $name ?>”软件能够正常使用，您因此遭受的损失与公司无关。
                    </li>
                    <li>2.2公司可能为不同的终端设备开发不同的应用程序软件版本，您应当根据实际设备状况获取、下载、安装合适的版本。</li>
                    <li> 2.3您可根据需要自行使用“<?= $name ?>”软件及相关服务或更新“<?= $name ?>”版本，如您不再需要使用“<?= $name ?>
                        ”软件及相关服务，您也可自行卸载相应的应用程序软件。
                    </li>
                    <li> 2.4为更好的提升用户体验及服务，公司将不定期提供“<?= $name ?>
                        ”软件及相关服务的更新或改变（包括但不限于软件修改、升级、功能强化、开发新服务、软件替换等），您可根据需要自行选择是否更新相应的版本。为保证“<?= $name ?>
                        ”软件及相关服务安全、提升用户服务，“<?= $name ?>
                        ”软件及相关服务部分或全部更新后，公司将在可行情况下以适当方式（包括但不限于系统提示、公告、站内信等）提示您，您有权选择接受更新后版本；如您选择不作更新，则“<?= $name ?>
                        ”软件及相关服务的部分功能将受到限制或不能正常使用。
                    </li>
                    <li> 2.5除非得到公司明示事先书面授权，您不得以任何形式对“<?= $name ?>”软件及相关服务进行包括但不限于改编、复制、传播、垂直搜索、镜像或交易等未经授权的访问或使用。</li>
                    <li> 2.6您理解，您使用“<?= $name ?>”软件及相关服务需自行准备与软件及相关服务有关的终端设备（如电脑、手机等装置），一旦您在您终端设备中打开“<?= $name ?>
                        ”软件或访问“<?= $name ?>”相关网站，即视为您使用“<?= $name ?>”软件及相关服务。为充分实现“<?= $name ?>
                        ”的全部功能，您可能需要将您的终端设备联网，您理解您应自行承担所需要的费用（如流量费、上网费等）。
                    </li>
                    <li> 2.7公司许可您一项个人的、可撤销的、不可转让的、非独占地和非商业的合法使用“<?= $name ?>
                        ”软件及相关服务的权利。本协议未明示授权的其他一切权利仍由公司保留，您在行使该些权利前须另行获得公司的书面许可，同时公司如未行使前述任何权利，并不构成对该权利的放弃。
                    </li>
                    <li> 2.8您无需注册也可开始使用“<?= $name ?>”软件及相关服务，但部分功能或服务可能会受到影响。同时，您也理解，为使您更好地使用“<?= $name ?>
                        ”软件及相关服务，保障您的帐号安全，某些功能和/或某些单项服务项目，如评论服务、网络直播服务等，要求您按照国家相关法律法规的规定，提供真实的身份信息实名注册并登录后方可使用。
                    </li>
                </ul>
                <h4>3.关于“帐号”</h4>
                <ul>
                    <li> 3.1“<?= $name ?>
                        ”软件及相关服务为您提供了注册通道，您有权选择合法的字符组合作为自己的帐号，并自行设置符合安全要求的密码。用户设置的帐号、密码是用户用以登录并以注册用户身份使用“<?= $name ?>
                        ”软件及相关服务的凭证。
                    </li>
                    <li>
                        <p>3.2帐号注销</p>
                        <p>在需要终止使用“<?= $name ?>”帐号服务时，符合以下条件的，您可以申请注销您的“<?= $name ?>”帐号：</p>
                        <ul>
                            <li>（1）您仅能申请注销您本人的帐号，并依照“<?= $name ?>”的流程进行注销；</li>
                            <li>（2）您仍应对您在注销帐号前且使用“<?= $name ?>”服务期间的行为承担相应责任；</li>
                            <li>（3）注销成功后，帐号记录、功能等将无法恢复或提供。</li>
                        </ul>
                        <p>如您需要注销您的“<?= $name ?>”帐号，请联系客服按提示进行注销。</p>
                    </li>
                    <li> 3.3您理解并承诺，您所设置的帐号不得违反“<?= $name ?>
                        ”的相关规则，您的帐号名称、头像和简介等注册信息及其他个人信息中不得出现违法和不良信息，未经他人许可不得用他人名义（包括但不限于冒用他人姓名、名称、字号、头像等或采取其他足以让人引起混淆的方式）开设帐号，不得恶意注册“<?= $name ?>
                        ”帐号（包括但不限于频繁注册、批量注册帐号等行为）。您在帐号注册及使用过程中需遵守相关法律法规，不得实施任何侵害国家利益、损害其他公民合法权益，有害社会道德风尚的行为。公司有权对您提交的注册信息进行审核。
                    </li>
                    <li> 3.4您在“<?= $name ?>
                        ”中的注册帐号仅限于您本人使用，未经公司书面同意，禁止以任何形式赠与、借用、出租、转让、售卖或以其他方式许可他人使用该帐号。如果公司发现或者有合理理由认为使用者并非帐号初始注册人，为保障帐号安全，公司有权立即暂停或终止向该注册帐号提供服务，并有权永久禁用该帐号。
                    </li>
                    <li> 3.5您有责任维护个人帐号、密码的安全性与保密性，并对您以注册帐号名义所从事的活动承担全部法律责任，包括但不限于您在“<?= $name ?>
                        ”软件及相关服务上进行的任何数据修改、言论发表、款项支付等操作行为可能引起的一切法律责任。您应高度重视对帐号与密码的保密，在任何情况下不向他人透露帐号及密码。若发现他人未经许可使用您的帐号或发生其他任何安全漏洞问题时，您应当立即通知公司。
                    </li>
                    <li>
                        3.6如您丢失帐号或遗忘密码，可遵照公司的申诉途径及时申诉请求找回帐号或密码。您理解并认可，密码找回机制仅需要识别申诉单上所填资料与系统记录资料具有一致性，而无法识别申诉人是否系帐号真正有权使用者。公司特别提醒您应妥善保管您的帐号和密码。当您使用完毕后，应安全退出。因您保管不当等自身原因或其他不可抗因素导致遭受盗号或密码丢失，您应自行承担相应责任。
                    </li>
                    <li>
                        3.7在注册、使用和管理帐号时，您应保证注册帐号时填写的身份信息的真实性，请您在注册、管理帐号时使用真实、准确、有效的相关身份证明材料及必要信息（包括您的姓名及电子邮件地址、联系电话、联系地址等）。依照规定，为使用“<?= $name ?>
                        ”软件及相关服务的部分功能，您需要填写必要的信息，请您按照规定完成认证，并注意及时更新上述相关信息。若您提交的材料或提供的信息不准确、不真实、不规范或者公司有理由怀疑为错误、不实或不合法的资料，则公司有权拒绝为您提供相关服务，您可能无法使用“<?= $name ?>
                        ”软件及相关服务或在使用过程中部分功能受到限制。
                    </li>
                    <li> 3.8除自行注册“<?= $name ?>
                        ”帐号外，您也可选择通过授权使用您合法拥有的包括但不限于公司和/或其关联方其他软件或平台用户帐号，以及实名注册的第三方软件或平台用户帐号登录使用“<?= $name ?>
                        ”软件及相关服务，但第三方软件或平台对此有限制或禁止的除外。当您以前述已有帐号登录使用的，应保证相应帐号已进行实名注册登记，并同样适用本协议中的相关条款。
                    </li>
                    <li> 3.9您理解并同意，除您登录、使用“<?= $name ?>”软件及相关服务外，您还可以用“<?= $name ?>
                        ”帐号登录使用公司及其关联方或其他合作方提供的其他软件、服务。您以“<?= $name ?>”帐号登录并使用前述服务的，同样应受其他软件、服务实际提供方的用户协议及其他协议条款约束。
                    </li>
                    <li>
                        <p> 3.10为提高您内容曝光量及发布效率，您同意您在“<?= $name ?>
                            ”软件及相关服务的帐号及相应帐号所发布的全部内容均授权公司以您的帐号自动同步发布至公司及/或关联方运营的其他软件及网站，您帐号的头像、昵称等公开信息可能会一并同步。您在“<?= $name ?>
                            ”软件/网站发布、修改、删除内容的操作，均会同步到上述其他软件及网站。 </p>
                        <p> 您通过已注册或者已同步的帐号登录公司及/或关联方运营的系列客户端软件产品及网站时（如有），应遵守该软件产品及网站自身的用户协议及其他协议条款的规定。 </p>
                    </li>
                    <li> 3.11当您完成“<?= $name ?>
                        ”的帐号注册、登录并进行合理和必要的身份验证后，您可随时浏览、修改自己提交的个人身份信息。您理解并同意，出于安全性和身份识别（如帐号或密码找回申诉服务等）的考虑，您可能无法修改注册时提供的初始注册信息及其他验证信息。您也可以申请注销帐号，公司会在完成个人身份、安全状态、设备信息、侵权投诉等方面的合理和必要的验证后协助您注销帐号，并依照您的要求删除有关您帐号的一切信息。
                    </li>
                    <li>
                        <p>
                            3.12您理解并同意，为了充分使用帐号资源，如您在注册后未及时进行初次登录使用或连续超过二个月未登录帐号并使用，公司有权收回您的帐号。如您的帐号被收回，您可能无法通过您此前持有的帐号登录并使用“<?= $name ?>
                            ”软件及相关服务，您该帐号下保存的任何个性化设置和使用记录将无法恢复。在收回您的帐号之前，公司将以适当的方式向您作出提示，如您在收到相关提示后一定期限内仍未登录、使用帐号，公司将进行帐号收回。 </p>
                        <p> 如您的帐号被收回，您可以通过注册新的帐号登录、使用“<?= $name ?>”软件及相关服务。您注册新帐号并登录、使用的行为仍受到本协议相关条款的约束。 </p>
                    </li>
                </ul>
                <h4>4.用户个人信息保护</h4>
                <p> 公司与您一同致力于您个人信息（即能够独立或与其他信息结合后识别您身份的信息）的保护。 </p>
                <p> 保护用户个人信息是公司的基本原则之一，在使用“<?= $name ?>
                    ”软件及相关服务的过程中，您可能需要提供您的个人信息（包括但不限于您的姓名、电话号码、位置信息、设备信息等），以便公司向您提供更好的服务和相应的技术支持。公司将依法保护您浏览、修改、删除相关个人信息以及撤回授权的权利，并将运用加密技术、匿名化处理等其他与“<?= $name ?>
                    ”软件及相关服务相匹配的技术措施及其他安全措施保护您的个人信息。 </p>
                <h4>5.用户行为规范</h4>
                <ul>
                    <li>
                        <p>5.1用户行为要求</p>
                        <p> 您应对您使用“<?= $name ?>”软件及相关服务的行为负责，除非法律允许或者经公司事先书面许可，您使用“<?= $name ?>”软件及相关服务不得具有下列行为： </p>
                        <ul>
                            <li> 5.1.1使用未经公司授权或许可的任何插件、外挂、系统或第三方工具对“<?= $name ?>”软件及相关服务的正常运行进行干扰、破坏、修改或施加其他影响。</li>
                            <li>
                                <p>5.1.2利用或针对“<?= $name ?>”软件及相关服务进行任何危害计算机网络安全的行为，包括但不限于：</p>
                                <ul>
                                    <li>（1）非法侵入网络、干扰网络正常功能、窃取网络数据等危害网络安全的活动；</li>
                                    <li>（2）提供专门用于从事侵入网络、干扰网络正常功能及防护措施、窃取网络数据等危害网络安全活动的程序、工具；</li>
                                    <li>（3）明知他人从事危害网络安全的活动的，为其提供技术支持、广告推广、支付结算等帮助；</li>
                                    <li>（4）使用未经许可的数据或进入未经许可的服务器/帐号；</li>
                                    <li>（5）未经允许进入公众计算机网络或者他人计算机系统并删除、修改、增加存储信息；</li>
                                    <li>（6）未经许可，企图探查、扫描、测试“<?= $name ?>”系统或网络的弱点或其它实施破坏网络安全的行为；</li>
                                    <li>（7）企图干涉、破坏“<?= $name ?>”系统或网站的正常运行，故意传播恶意程序或病毒以及其他破坏干扰正常网络信息服务的行为；</li>
                                    <li>（8）伪造TCP/IP数据包名称或部分名称；</li>
                                    <li>（9）对“<?= $name ?>”软件及相关服务进行反向工程、反向汇编、编译或者以其他方式尝试发现“<?= $name ?>”软件及相关服务的源代码；
                                    </li>
                                    <li>（10）恶意注册“<?= $name ?>”帐号，包括但不限于频繁、批量注册帐号；</li>
                                    <li>（11）违反本协议、公司的相关规则及侵犯他人合法权益的其他行为。</li>
                                </ul>
                            </li>
                            <li> 5.1.3如果公司有理由认为您的行为违反或可能违反上述约定的，公司可独立进行判断并处理，且在任何时候有权在不事先通知的情况下终止向您提供服务，并依法追究相关责任。</li>
                        </ul>
                    </li>
                    <li>5.2信息内容展示及规范
                        <ul>
                            <li> 5.2.1您按规定完成实名认证后，可以以注册帐号或“<?= $name ?>”合作平台帐号登录“<?= $name ?>
                                ”发布信息、互动交流、评论等。您在“<?= $name ?>”中因相关操作所形成的关注、粉丝信息将会向其他用户展示。
                            </li>
                            <li>
                                5.2.2公司致力使发布信息、互动交流、评论成为文明、理性、友善、高质量的意见交流。在推动发布信息、互动交流、评论业务发展的同时，不断加强相应的信息安全管理能力，完善发布信息、互动交流、评论自律，切实履行社会责任，遵守国家法律法规，尊重公民合法权益，尊重社会公序良俗。
                            </li>
                            <li>
                                <p> 5.2.3您制作、评论、发布、传播的信息（包括但不限于随拍或上传至“<?= $name ?>
                                    ”平台的未公开的私密视频）应自觉遵守社会公共秩序、道德风尚和信息真实性等要求，否则公司有权立即采取相应处理措施。您同意并承诺不制作、复制、发布、传播下列信息： </p>
                                <ul>
                                    <li>（1）反对宪法确定的基本原则的；</li>
                                    <li>（2）危害国家安全，泄露国家秘密的；</li>
                                    <li>（3）颠覆国家政权，推翻社会主义制度，煽动分裂国家，破坏国家统一的；</li>
                                    <li>（4）损害国家荣誉和利益的；</li>
                                    <li>（5）宣扬恐怖主义、极端主义的；</li>
                                    <li>（6）宣扬民族仇恨、民族歧视，破坏民族团结的；</li>
                                    <li>（7）煽动地域歧视、地域仇恨的；</li>
                                    <li>（8）破坏国家宗教政策，宣扬邪教和封建迷信的；</li>
                                    <li>（9）编造、散布谣言、虚假信息，扰乱经济秩序和社会秩序、破坏社会稳定的；</li>
                                    <li>（10）散布、传播淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</li>
                                    <li>（11）危害网络安全、利用网络从事危害国家安全、荣誉和利益的；</li>
                                    <li>（12）侮辱或者诽谤他人，侵害他人合法权益的；</li>
                                    <li>（13）对他人进行暴力恐吓、威胁，实施人肉搜索的；</li>
                                    <li>（14）涉及他人隐私、个人信息或资料的；</li>
                                    <li>（15）散布污言秽语，损害社会公序良俗的；</li>
                                    <li>（16）侵犯他人隐私权、名誉权等权益内容的；</li>
                                    <li>（17）散布商业广告，或类似的商业招揽信息、过度营销信息及垃圾信息；</li>
                                    <li>（18）使用本网站常用语言文字以外的其他语言文字评论的；</li>
                                    <li>（19）与所评论的信息毫无关系的；</li>
                                    <li>（20）所发表的信息毫无意义的，或刻意使用字符组合以逃避技术审核的；</li>
                                    <li>（21）侵害未成年人合法权益或者损害未成年人身心健康的；</li>
                                    <li>（22）未获他人允许，偷拍、偷录他人，侵害他人合法权利的；</li>
                                    <li>
                                        <p>（23）包含恐怖、暴力血腥、高危险性、危害表演者自身或他人身心健康内容的，包括但不限于以下情形：</p>
                                        <ul>
                                            <li>i. 任何暴力和/或自残行为内容；</li>
                                            <li>ii. 任何威胁生命健康、利用刀具等危险器械表演的危及自身或他人人身及/或财产权利的内容；</li>
                                            <li>iii.怂恿、诱导他人参与可能会造成人身伤害或导致死亡的危险或违法活动的内容；</li>
                                        </ul>
                                    </li>
                                    （24）其他含有公序良俗、干扰“<?= $name ?>”正常运营或侵犯其他用户或第三方合法权益内容的信息。
                                </ul>
                            </li>
                            <li>
                                5.2.4您制作、发布、传播的内容需遵守规定，不得利用基于深度学习、虚拟现实等的新技术新应用制作、发布、传播虚假新闻信息。您在发布或传播利用基于深度学习、虚拟现实等的新技术新应用制作的非真实音视频信息时，应当以显著方式予以标识。
                            </li>
                        </ul>
                    </li>
                    <li>
                        5.3公司设立公众投诉、举报平台，您可按照公司公示的投诉举报制度向公司投诉、举报各类违规行为、违规传播活动、有害信息等内容，公司将及时受理和处理您的投诉举报，以共同营造风清气正的网络空间。
                    </li>
                </ul>
                <h4>6.“<?= $name ?>”信息内容使用规范</h4>
                <ul>
                    <li>
                        <p>6.1未经公司书面许可，任何用户、第三方均不得自行或授权、允许、协助他人对“<?= $name ?>”软件及相关服务中信息内容进行如下行为：</p>
                        <ul>
                            <li> （1）复制、读取、采用“<?= $name ?>”软件及相关服务的信息内容，用于包括但不限于宣传、增加阅读量、浏览量等商业用途；</li>
                            <li> （2）擅自编辑、整理、编排“<?= $name ?>”软件及相关服务的信息内容后在“<?= $name ?>”软件及相关服务的源页面以外的渠道进行展示；</li>
                            <li> （3）采用包括但不限于特殊标识、特殊代码等任何形式的识别方法，自行或协助第三人对“<?= $name ?>
                                ”软件及相关服务的信息内容产生流量、阅读量引导、转移、劫持等不利影响；
                            </li>
                            <li> （4）其他非常规获取或使用“<?= $name ?>”软件及相关服务的信息内容的行为。</li>
                        </ul>
                    </li>
                    <li> 6.2未经公司书面许可，任何用户、第三方不得以任何方式（包括但不限于盗链、冗余盗取、非法抓取、模拟下载、深度链接、假冒注册等）直接或间接盗取“<?= $name ?>
                        ”软件及相关服务的视频、图文等信息内容，或以任何方式（包括但不限于隐藏或者修改域名、平台特有标识、用户名等）删除或改变相关信息内容的权利管理电子信息。
                    </li>
                    <li>
                        <p>6.3经公司书面许可后，用户、第三方对“<?= $name ?>”软件及相关服务的信息内容的分享、转发等行为，还应符合以下规范：</p>
                        <ul>
                            <li> （1）对抓取、统计、获得的相关搜索热词、命中率、分类、搜索量、点击率、阅读量等相关数据，未经公司事先书面同意，不得将上述数据以任何方式公示、提供、泄露给任何第三人；</li>
                            <li> （2）不得对“<?= $name ?>”软件及相关服务的源网页进行任何形式的任何改动，包括但不限于“<?= $name ?>
                                ”软件及相关服务的首页链接、广告系统链接等入口，也不得对“<?= $name ?>”软件及相关服务的源页面的展示进行任何形式的遮挡、插入、弹窗等妨碍；
                            </li>
                            <li> （3）应当采取安全、有效、严密的措施，防止“<?= $name ?>”软件及相关服务的信息内容被第三方通过包括但不限于“蜘蛛”（spider）程序等任何形式进行非法获取；
                            </li>
                            <li> （4）不得把相关数据内容用于公司书面许可范围之外的目的，进行任何形式的销售和商业使用，或向第三方泄露、提供或允许第三方为任何方式的使用。</li>
                            <li> （5）用户向任何第三人分享、转发、复制“<?= $name ?>”软件及相关服务信息内容的行为，还应遵守公司为此制定的其他规范和标准。</li>
                        </ul>
                    </li>
                </ul>
                <h4>7.违约处理</h4>
                <ul>
                    <li>
                        7.1针对您违反本协议或其他服务条款的行为，公司有权独立判断并视情况采取预先警示、拒绝发布、立即停止传输信息、删除内容或评论、短期禁止发布内容或评论、限制帐号部分或者全部功能直至终止提供服务、永久关闭帐号等措施，对于因此而造成您无法正常使用帐号及相关服务、无法正常获取您帐号内资产或其他权益等后果，公司不承担任何责任。公司有权公告处理结果，且有权根据实际情况决定是否恢复相关帐号的使用。
                    </li>
                    <li>
                        7.2因您违反本协议或其他服务条款规定，引起第三方投诉或诉讼索赔的，您应当自行处理并承担可能因此产生的全部法律责任。因您的违法或违约等行为导致公司及其关联方、控制公司、继承公司向任何第三方赔偿或遭受处罚的，您还应足额赔偿公司及其关联方、控制公司、继承公司因此遭受的全部损失。
                    </li>
                    <li> 7.3公司尊重并保护用户及他人的知识产权、名誉权、姓名权、隐私权等合法权益。您保证，在使用“<?= $name ?>
                        ”软件及相关服务时上传的文字、图片、视频、音频、链接等不侵犯任何第三方的知识产权、名誉权、姓名权、隐私权等权利及合法权益。否则，公司有权在收到权利方或者相关方通知的情况下移除该涉嫌侵权内容。针对第三方提出的全部权利主张，您应自行处理并承担可能因此产生的全部法律责任；如因您的侵权行为导致公司及其关联方、控制公司、继承公司遭受损失的（包括但不限于经济、商誉等损失），您还应足额赔偿公司及其关联方、控制公司、继承公司遭受的全部损失。
                    </li>
                </ul>
                <h4>8.服务的变更、中断和终止</h4>
                <ul>
                    <li> 8.1您理解并同意，公司提供的“<?= $name ?>
                        ”软件及相关服务是按照现有技术和条件所能达到的现状提供的。公司会尽最大努力向您提供服务，确保服务的连贯性和安全性。您理解，公司不能随时或始终预见和防范法律、技术以及其他风险，包括但不限于不可抗力、网络原因、第三方服务瑕疵、第三方网站等原因可能导致的服务中断、不能正常使用“<?= $name ?>
                        ”软件及相关服务以及其他的损失和风险。
                    </li>
                    <li> 8.2您理解并同意，公司为了整体服务运营、平台运营安全的需要，有权视具体情况决定服务/功能的设置及其范围修改、中断、中止或终止“<?= $name ?>”软件及相关服务。</li>
                </ul>
                <h4>9.广告</h4>
                <ul>
                    <li> 9.1您理解并同意，在您使用“<?= $name ?>”软件及相关服务过程中，公司可能会向您推送具有相关性的信息、广告发布或品牌推广服务，且公司将在“<?= $name ?>
                        ”软件及相关服务中展示“<?= $name ?>”软件及相关服务和/或第三方供应商、合作伙伴的商业广告、推广或信息（包括商业或非商业信息）。
                    </li>
                    <li> 9.2如您不愿意接收具有相关性的广告，您有权对该广告信息选择“不感兴趣”，该广告同类广告的推送将会减少。</li>
                    <li> 9.3如您不愿意接收“<?= $name ?>”推送通知服务的，您有权在手机系统通知管理中自行关闭该服务。</li>
                    <li>
                        9.4公司依照法律规定履行广告及推广相关义务，您应当自行判断该广告或推广信息的真实性和可靠性并为自己的判断行为负责。除法律法规明确规定外，您因该广告或推广信息进行的购买、交易或因前述内容遭受的损害或损失，您应自行承担，公司不予承担责任。
                    </li>
                </ul>
                <h4>10.知识产权</h4>
                <ul>
                    <li> 10.1公司在“<?= $name ?>
                        ”软件及相关服务中提供的内容（包括但不限于软件、技术、程序、网页、文字、图片、图像、音频、视频、图表、版面设计、电子文档等）的知识产权属于公司所有。公司提供“<?= $name ?>
                        ”及相关服务时所依托的软件的著作权、专利权及其他知识产权均归公司所有。未经公司许可，任何人不得擅自使用（包括但不限于通过任何机器人、“蜘蛛”等程序或设备监视、复制、传播、展示、镜像、上载、下载）“<?= $name ?>
                        ”软件及相关服务中的内容。
                    </li>
                    <li> 10.2您理解并承诺，您在使用“<?= $name ?>
                        ”软件及相关服务时发布上传的内容（包括但不限于文字、图片、视频、音频等各种形式的内容及其中包含的音乐、声音、台词、视觉设计等所有组成部分）均由您原创或已获合法授权（且含转授权）。您通过“<?= $name ?>
                        ”上传、发布所产生内容的知识产权归属您或原始著作权人所有。
                    </li>
                    <li> 10.3除非有相反证明，您知悉、理解并同意，为使您的作品得到更好的分享及推广，提高其传播价值及影响力，您通过“<?= $name ?>
                        ”软件及相关服务上传、发布或传输的内容（包括但不限文字，图像，音频，视频、直播内容等各种形式的内容及其中包括的音乐、声音、台词、视觉设计、对话等所有组成部分），您授予公司及其关联方、控制公司、继承公司一项全球范围内、免费、非独家、可再许可（通过多层次）的权利（包括但不限于复制权、翻译权、汇编权、信息网络传播权、改编权及制作衍生品、表演和展示的权利等），上述权利的使用范围包括但不限于在当前或其他网站、应用程序、产品或终端设备等使用。您在此确认并同意，公司有权自行或许可第三方在与上述内容、“<?= $name ?>
                        ”软件及相关服务、公司和/或公司品牌有关的任何宣传、推广、广告、营销和/或研究中使用和以其他方式开发内容（全部或部分）。为避免疑义，您理解并同意，上述授予的权利包括使用、复制和展示您拥有或被许可使用并植入内容中的个人形象、肖像、姓名、商标、服务标志、品牌、名称、标识和公司标记（如有）以及任何其他品牌、营销或推广资产、物料、素材等的权利和许可。基于部分功能的特性，您通过“<?= $name ?>
                        ”软件及相关服务发布的内容（包括但不限于内容中包含的声音、音频或对话等）可供其他用户使用“<?= $name ?>”软件创作及发布相关内容时使用。
                    </li>
                    <li> 10.4公司为“<?= $name ?>”开发、运营提供技术支持，并对“<?= $name ?>”软件及相关服务的开发和运营等过程中产生的所有数据和信息等享有相应允许范围内的全部权利。
                    </li>
                </ul>
                <h4>11.免责声明</h4>
                <ul>
                    <li>
                        <p>11.1您理解并同意，“<?= $name ?>”软件及相关服务可能会受多种因素的影响或干扰，公司不保证(包括但不限于)：</p>
                        <ul>
                            <li>11.1.1“<?= $name ?>”软件及相关服务完全适合用户的使用要求；</li>
                            <li>11.1.2“<?= $name ?>”软件及相关服务不受干扰，及时、安全、可靠或不出现错误；用户经由公司取得的任何软件、服务或其他材料符合用户的期望；</li>
                            <li>11.1.3“<?= $name ?>”软件及相关服务中任何错误都将能得到更正。</li>
                        </ul>
                    </li>
                    <li>
                        11.2如有涉嫌借款、投融资、理财或其他涉财产的网络信息、账户密码、广告或推广等信息的，请您谨慎对待并自行进行判断，对您因此遭受的利润、商业信誉、资料损失或其他有形或无形损失，公司不承担任何直接、间接、附带、特别、衍生性或惩罚性的赔偿责任。
                    </li>
                    <li> 11.3您理解并同意，在使用“<?= $name ?>
                        ”软件及相关服务过程中，可能遇到不可抗力等因素（不可抗力是指不能预见、不能克服并不能避免的客观事件），包括但不限于政府行为、自然灾害（如洪水、地震、台风等）、网络原因、战争、罢工、骚乱等。出现不可抗力情况时，公司将努力在第一时间及时修复，但因不可抗力造成的暂停、中止、终止服务或造成的任何损失，公司在法律法规允许范围内免于承担责任。
                    </li>
                    <li> 11.4公司依据本协议约定获得处理违法违规内容的权利，该权利不构成公司的义务或承诺，公司不能保证及时发现违法行为或进行相应处理。</li>
                    <li> 11.5您理解并同意：关于“<?= $name ?>”软件及相关服务，公司不提供任何种类的明示或暗示担保或条件，包括但不限于商业适售性、特定用途适用性等。您对“<?= $name ?>
                        ”软件及相关服务的使用行为应自行承担相应风险。
                    </li>
                    <li>
                        11.6您理解并同意，本协议旨在保障遵守相关规定、维护公序良俗，保护用户和他人相关权益，公司在能力范围内尽最大的努力按照相规定进行判断，但并不保证公司判断完全与司法机关、行政机关的判断一致，如因此产生的后果您已经理解并同意自行承担。
                    </li>
                    <li> 11.7在任何情况下，公司均不对任何间接性、后果性、惩罚性、偶然性、特殊性或刑罚性的损害，包括因您使用“<?= $name ?>
                        ”软件及相关服务而遭受的利润损失，承担责任。除另有明确规定外，公司对您承担的全部责任，无论因何原因或何种行为方式，始终不超过您因使用“<?= $name ?>
                        ”软件及相关服务期间而支付给公司的费用（如有）。
                    </li>
                </ul>
                <h4>12.关于单项服务与第三方服务的特殊约定</h4>
                <ul>
                    <li> 12.1“<?= $name ?>”软件及相关服务中包含公司以各种官方规定方式获取的信息或信息内容链接，同时也包括公司及其关联方运营的其他单项服务。这些服务在“<?= $name ?>
                        ”可能以单独板块形式存在。公司有权不时地增加、减少或改动这些特别板块的设置及服务。
                    </li>
                    <li> 12.2您可以在“<?= $name ?>
                        ”软件中开启和使用上述单项服务功能。某些单项服务可能需要您同时接受就该服务特别制订的协议或者其他约束您与该项服务提供者之间的规则。必要时公司将以醒目的方式提供这些协议、规则供您查阅。一旦您开始使用上述服务，则视为您理解并接受有关单项服务的相关协议、规则的约束。如未标明使用期限、或未标明使用期限为“永久”、“无限期”或“无限制”的，则这些服务的使用期限为自您开始使用该服务至该服务在“<?= $name ?>
                        ”软件停止提供之日为止。
                    </li>
                    <li> 12.3您在“<?= $name ?>”软件中使用第三方提供的软件及相关服务时，除遵守本协议及“<?= $name ?>
                        ”软件中的其他相关规则外，还可能需要同意并遵守第三方的协议、相关规则。如因第三方软件及相关服务产生的争议、损失或损害，由您自行与第三方解决，公司并不就此而对您或任何第三方承担任何责任。
                    </li>
                </ul>
                <h4>13.未成年人使用条款</h4>
                <ul>
                    <li> 13.1若您是未满18周岁的未成年人，您应在您的监护人监护、指导下并获得监护人同意的情况下，认真阅读并同意本协议后，方可使用“<?= $name ?>”软件及相关服务。</li>
                    <li> 13.2公司重视对未成年人个人信息的保护，未成年用户在填写个人信息时，请加强个人保护意识并谨慎对待，并应在取得监护人的同意以及在监护人指导下正确使用“<?= $name ?>
                        ”软件及相关服务。
                    </li>
                    <li> 13.3未成年人用户及其监护人理解并确认，如您违反相关规定、本协议内容，则您及您的监护人应依照法律规定承担因此而可能导致的全部责任。</li>
                    <li>
                        <p>13.4未成年人用户特别提示</p>
                        <ul>
                            <li> 13.4.1未成年人使用“<?= $name ?>”软件及相关服务应该在其监护人的监督指导下，在合理范围内正确学习使用网络，避免沉迷虚拟的网络空间，养成良好上网习惯。
                            </li>
                            <li>
                                <p>13.4.2青少年用户必须遵守《全国青少年网络文明公约》：</p>
                                <ul>
                                    <li>（1）要善于网上学习，不浏览不良信息；</li>
                                    <li>（2）要诚实友好交流，不侮辱欺诈他人；</li>
                                    <li>（3）要增强自护意识，不随意约会网友；</li>
                                    <li>（4）要维护网络安全，不破坏网络秩序；</li>
                                    <li>（5）要有益身心健康，不沉溺虚拟时空。</li>
                                </ul>
                            </li>
                            <li> 13.4.3为更好地保护未成年人隐私权益，公司特别提醒您慎重发布包含未成年人素材的内容，一经发布，即视为您已获得权利人同意在“<?= $name ?>
                                ”软件及相关服务展示未成年人的肖像、声音等信息，且允许公司依据本协议使用、处理该等与未成年人相关的内容。
                            </li>
                        </ul>
                    </li>
                    <li>
                        <p>13.5监护人特别提示</p>
                        <ul>
                            <li> 13.5.1如您的被监护人使用“<?= $name ?>”软件及相关服务的，您作为监护人应指导并监督被监护人的注册和使用行为，如您的被监护人申请注册<?= $name ?>
                                帐号，公司将有权认为其已取得您的同意。
                            </li>
                            <li> 13.5.2您的被监护人在使用“<?= $name ?>
                                ”软件及相关服务时可能使用充值、打赏等功能。您作为监护人，请保管好您的支付设备、支付账户及支付密码等，以避免被监护人在未取得您同意的情况下通过您的<?= $name ?>
                                帐号使用充值、打赏等功能。
                            </li>
                        </ul>
                    </li>
                </ul>
                <h4>14．其他</h4>
                <ul>
                    <li> 14.1本协议的成立、生效、履行、解释及争议的解决均以<?= $name ?>最终解释权为准。</li>
                    <li> 14.2 如您对修订后的协议内容存有异议的，请立即停止登录或使用“<?= $name ?>”软件及相关服务。若您继续登录或使用“<?= $name ?>
                        ”软件及相关服务，即视为您认可并接受修订后的协议内容。
                    </li>
                    <li> 14.3本协议中的标题仅为方便阅读而设，并不影响本协议中任何规定的含义或解释。</li>
                    <li> 14.4 您和公司均是独立的主体，在任何情况下本协议不构成公司对您的任何形式的明示或暗示担保或条件，双方之间亦不构成代理、合伙、合营或雇佣关系。</li>
                </ul>
            </div>
        </div>
        <!--联系我们-->
        <div class="helpbox01 c_contact">
            <div class="hlp-mm" name="zt">
                <div class="help-contact-img"></div>
                <div class="help-contact-way">
                    <p>站长邮箱：guazitv@163.com</p>
                    <p>商务合作：guazitv@163.com</p>
                </div>
            </div>
        </div>
        <!--下载APP-->
        <div class="helpbox02 c_appdownload">
            <!--app-->
            <div class="hlp-app-help" id="hlpapp">
                <div class="hlp-app-L-help"><img src="/images/Index/helpweb.png"></div>
                <div class="hlp-app-box-help">
                    <p class="hlp-app-box-title"">便源全 更新块</p>
                    <p class="hlp-app-box-detail">无论是国内最火的电视剧、综艺还是日剧、韩剧、英剧、美剧、 各种电影、纪录动漫等等</p>
                    <p class="hlp-app-box-detail">瓜子tv（www.guzitv.tv）都应有尽有</p>
                    <div class="hlp-app-btn-box">
                        <!--下载按钮-->
                        <div class="hlp-app-btn01 hlp-app-box-btn">
                            <?php if($appversion["iosdata"]) :?>
                                <a href="<?=$appversion["iosdata"]["file_path"]?>" class="button1">IOS下载</a>
                            <?php else :?>
                                <a href="###" class="button1">无IOS应用</a>
                            <?php endif; ?>
                           <!-- <div>
                                <img src="/images/newindex/triangle-up.png"/>
                            </div>
                            <div class="hlp-app-alt">
                                <ul class="app-tabA">
                                    <li class="act">主线路</li>
                                    <li>备用线路</li>
                                </ul>
                                <ul class="app-tabbox">
                                    <li class="act"><img src="/images/newindex/ewm.jpg"/></li>
                                    <li><img src="/images/newindex/ewm02.jpg"/></li>
                                </ul>
                            </div>-->
                        </div>
                        <!--下载按钮-->
                        <div class="hlp-app-btn01 hlp-app-box-btn">
                            <?php if($appversion["androiddata"]) :?>
                                <a href="<?=$appversion["androiddata"]["file_path"]?>" class="button2">Android下载</a>
                            <?php else :?>
                                <a href="<?=$appversion["iosdata"]["file_path"]?>" class="button2">无安卓应用</a>
                            <?php endif; ?>
                           <!-- <div>
                                <img src="/images/newindex/triangle-up.png"/>
                            </div>
                            <div class="hlp-app-alt">
                                <ul class="app-tabbox">
                                    <li class="act"><img src="/images/newindex/ewm02.jpg"/></li>
                                </ul>
                                <a href="javascript:;">点击此处下载</a>
                            </div>-->
                        </div>
                        <div class="hlp-app-btn01 hlp-app-box-btn">
                            <a href="javascript:;">
                                Windows下载
                            </a>
                            <div>
                                <img src="/images/newindex/triangle-up.png"/>
                            </div>
                            <div class="hlp-app-alt">
                                <a href="javascript:;">开发中</a>
                            </div>
                        </div>
                        <div class="hlp-app-btn01 hlp-app-box-btn">
                            <?php if($appversion["tvdata"]) :?>
                                <a href="<?=$appversion["tvdata"]["file_path"]?>" class="button2">电视盒子下载</a>
                            <?php else :?>
                                <a href="<?=$appversion["iosdata"]["file_path"]?>" class="button2">无电视应用</a>
                            <?php endif; ?>
                        </div>
                        <!--下载按钮-->
                        <!--<div class="hlp-app-btn01 hlp-app-box-btn">
                            <a href="javascript:;">
                               iPad 客户端下载
                            </a>
                            <div>
                                <img src="/images/newindex/triangle-up.png"/>
                            </div>
                            <div class="hlp-app-alt">
                                <ul class="app-tabA">
                                    <li class="act">主线路</li>
                                    <li>备用线路</li>
                                </ul>
                                <ul class="app-tabbox">
                                    <li class="act"><img src="/images/newindex/ewm.jpg"/></li>
                                    <li><img src="/images/newindex/ewm02.jpg"/></li>
                                </ul>
                                <a href="javascript:;">点击此处下载</a>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="hlp-app-code"><img src="/images/Index/guazicode.png"></div>
            </div>
        </div>
    </div>
</div>

<script src="/js/jquery.js"></script>
<script>
    $(function () {
        //首次加载
        $(document).ready(function () {
            var uid = finduser();
            if (!isNaN(uid) && uid != "") {
                $("#v_feedback_login").empty();
            }
            var helptab = $('#helptab').val();
            if (helptab == 'feedback') {
                $('.c_feedback').addClass('act');
                $('.c_feedback .J_per_tab_img_c').show().siblings().hide();
                $('.c_feedback').siblings().find('.J_per_tab_img_c').hide().siblings().show();
            } else if (helptab == 'aboutUs') {
                $('.c_aboutUs').addClass('act');
                $('.c_aboutUs .J_per_tab_img_c').show().siblings().hide();
                $('.c_aboutUs').siblings().find('.J_per_tab_img_c').hide().siblings().show();
            } else if (helptab == 'terms') {
                $('.c_terms').addClass('act');
                $('.c_terms .J_per_tab_img_c').show().siblings().hide();
                $('.c_terms').siblings().find('.J_per_tab_img_c').hide().siblings().show();
            } else if (helptab == 'contact') {
                $('.c_contact').addClass('act');
                $('.c_contact .J_per_tab_img_c').show().siblings().hide();
                $('.c_contact').siblings().find('.J_per_tab_img_c').hide().siblings().show();
            } else if (helptab == 'pwd') {
                $('.c_pwd').addClass('act');
                $('.c_pwd .J_per_tab_img_c').show().siblings().hide();
                $('.c_pwd').siblings().find('.J_per_tab_img_c').hide().siblings().show();
            } else if (helptab == 'appdownload') {
                showwarning();
                // $('.c_appdownload').addClass('act');
            } else {//c_question
                $('.c_question').addClass('act');
                $('.c_question .J_per_tab_img_c').show().siblings().hide();
                $('.c_question').siblings().find('.J_per_tab_img_c').hide().siblings().show();
            }
        });
        //在线反馈提交
        $("#v_submit").click(function () {
            var uid = finduser();
            var arrIndex = {};
            var str = '提交成功';
            if (isNaN(uid) || uid == "") {
                showloggedin();//弹登录框
                return false;
            }
            var description = $("#v_description").val();
            if (description.length < 10) {
                $(".alt-title").text("请详细描述问题，至少10个字");
                $("#alt05").show();
                return false;
            }
            arrIndex['country'] = $("#v_country").val();
            arrIndex['internets'] = $("#v_internet").val();
            arrIndex['systems'] = $("#v_system").val();
            arrIndex['browsers'] = $("#v_browser").val();
            arrIndex['description'] = $("#v_description").val();
            //发送请求，获取数据
            $.get('/video/save-feedbackinfo', arrIndex, function (s) {
                // console.log(s);
                if (s > 0) {
                    //插入成功，所有值置空
                    // $("#v_country").val('');
                    $("#v_country").find("option").eq(0).prop("selected", true);
                    $("#v_internet").find("option").eq(0).prop("selected", true);
                    $("#v_system").find("option").eq(0).prop("selected", true);
                    $("#v_browser").find("option").eq(0).prop("selected", true);
                    $("#v_description").val('');
                    str = '提交成功';
                } else {
                    str = '提交失败';
                }
                $(".alt-title").text(str);
                $("#alt05").show();
            });
        });
        //修改密码提交
        $("#pwd_update").click(function () {
            var arrIndex = {};
            var tab = true;
            var str = '提交成功';
            var account = $("#pwd_account").val();
            var answer = $("#pwd_answer").val();
            var newpwd = $("#pwd_newpwd").val();
            if (account == "") {
                showwrg("pwd_account", true);
                tab = false;
                return false;
            } else {
                var ismobile = isMobilePhone(account);
                var isemail = isEmail(account);
                if (!ismobile && !isemail) {
                    showwrg("pwd_account", true);
                    tab = false;
                    return false;
                } else {
                    arrIndex['account'] = account;
                }
            }
            if (answer == "") {
                showwrg("pwd_answer", true);
                tab = false;
                return false;
            }
            if (newpwd == "") {
                showwrg("pwd_newpwd", true);
                tab = false;
                return false;
            }
            if (tab) {
                arrIndex['account'] = account;
                arrIndex['question'] = $("#pwd_question").val();
                arrIndex['answer'] = answer;
                arrIndex['newpwd'] = newpwd;
                //发送请求，获取数据
                $.get('/video/modify-password', arrIndex, function (res) {
                    if (res.errno == 0) {
                        //插入成功，所有值置空
                        $("#pwd_account").val('');
                        $("#pwd_question").find("option").eq(0).prop("selected", true);
                        $("#pwd_answer").val('');
                        $("#pwd_newpwd").val('');
                        $(".alt-title").text('修改成功');
                        $("#alt05").show();
                    } else {
                        if (res.data.reason != "") {
                            $(".alt-title").text(res.data.reason);
                        } else {
                            $(".alt-title").text('修改失败');
                        }
                        $("#alt05").show();
                    }
                });
            }
        });

        $(".c_blur").blur(function () {
            if ($(this).val() == "") {
                showwrg($(this).attr("id"), true);
            } else {
                hiddenwrg($(this).attr("id"), true);
            }
        });
    });

    function showwrg(id, type) {
        $("#" + id).parent().parent().addClass("wrg");
        if (type) {
            $("#" + id).parent().parent().find(".ADbz").removeClass("ADbzhidden");
        }
    }

    function hiddenwrg(id, type) {
        $("#" + id).parent().parent().removeClass("wrg");
        if (type) {
            $("#" + id).parent().parent().find(".ADbz").addClass("ADbzhidden");
        }
    }
</script>
