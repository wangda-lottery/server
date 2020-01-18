<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['site.title'];
?>

<div class="header">
    <div class="inner">
        <div class="logo fl">
            <h1><a href="/" class=""><img src="./images/logo.png" alt=""></a></h1>
        </div>

        <div class="nav fr">
            <ul>
                <li><a href="javascript:;" class="" onclick="showQueryWin();"><span class="nvicon nv3"></span>红包查询</a></li>
                <li><a href="https://40997a.com/home" target="_blank" class=""><span class="nvicon nv1"></span>官方首页</a></li>
                <li><a href="https://40997a.com/register" target="_blank" class=""><span class="nvicon nv2"></span>会员注册</a></li>
                <li><a href="https://40997a.com/mobilee" target="_blank" class=""><span class="nvicon nv4"></span>手机投注</a></li>
                <li>
                    <a href="https://vue.comm100.com/chatWindow.aspx?siteId=5000346&planId=730" target="_blank" class="">
                        <span class="nvicon nv6"></span>在线客服
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="banner">
    <div class="inner">
        <div class="hongba">
            <div class="hongba-in">
                <div class="cl"></div>
                <div class="cl h30"></div>
                <div class="cl h12"></div>
                <div class="tac haishen" id="hb-message">距离红包雨开始</div>
                <div class="cl h12"></div>
                <div class="juhd">
                    <span class="" style="display:none;"></span>
                    <span class="" id="hb-clock-d">0</span><em class="">天</em>
                    <span class="" id="hb-clock-h">0</span><em class="">小时</em>
                    <span class="" id="hb-clock-m">0</span><em class="">分</em>
                    <span class="" id="hb-clock-s">0</span>
                    <em class="">秒</em>
                </div>
                <div class="cl h15"></div>
                <div class="cl"></div>
                <div class="yiji">
                    <span class="fl pl22">易记域名 <span id="domain"></span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cl h20"></div>
<div class="inner ctnbx">
    <div class="lunwax">
        <div class="luntopwa">
            <div class="luntop luntop2">
                <ul id="announce" style="top: -185px;">

                </ul>
            </div>
        </div>
    </div>
    <div class="contin">
        <div class="tlbx"><img src="./images/t1.png" alt=""></div>
        <div class="wenzi">
            当日存款达到以下标准的会员，隔天皆可参与抢红包，亿万红包将于（北京时间20:00至23:59开抢） 单个红包最高8888元，更
            多活动，敬请关注彩票联盟活动中心。
        </div>

        <div class="bige">
            <table class="biao">
                <tbody>
                <tr class="biaotou">
                    <td>当天存款总额</td>
                    <td>抢红包次数</td>
                    <td>红包金额</td>
                    <td>流水限制</td>
                    <td>活动时间</td>
                </tr>

                <tr>
                </tr>

                <tr>
                    <td>100+</td>
                    <td> 1次</td>
                    <td rowspan="6"> 1-8888元<br>(随机)</td>
                    <td rowspan="6"> 1倍流水</td>
                    <td rowspan="6"> 每天北京时间<br>晚上20：00至23：59<br>限时抢红包</td>
                </tr>
                <tr>
                    <td>500+</td>
                    <td> 2次</td>
                </tr>
                <tr>
                    <td>5000+</td>
                    <td> 3次</td>
                </tr>
                <tr>
                    <td>20000+</td>
                    <td> 4次</td>
                </tr>
                <tr>
                    <td>100000+</td>
                    <td> 5次</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="h10"></div>
        <div class="wenzi">
            小提示：存款金额越高,抢到大额的几率越大,感谢支持
            注意：如会员没有在规定时间抢红包，超过开抢时间视为放弃不给于重新补抢机会。
        </div>

        <div class="h10"></div>
        <div class="tlbx"><img src="./images/t2.png" alt=""></div>
        <div class="wenzi">
            1、所有获得红包现金都是打入游戏账户。
            <br>2、提现要求：一倍流水。提现金额=投注金额+中奖金额（小于或等于余额）*投注金额不含撤单的投注金额
            <br>3、每个银行卡户名，每位会员，每一相同IP，每一电子邮箱，每一电话号码，相同支付方式（借记卡/信用卡/银行账户）及共
            享计算机环境（例如网吧，其他公用计算机等）只能享受一次优惠；若会员有重复申请账号行为，公司保留取消或收回会员
            优惠彩金的权利。
            <br>4、彩票联盟的所有优惠为玩家而设，如发现任何团体或个人，以不诚实方式套取红利或任何威胁，滥用公司优惠等行为。公司保
            留冻结，取消该团体或个人账户结余的权利。
            <br>5、此红包活动为{彩票联盟}系统程序自动进行，红包的概率完全遵守力学及自然概率，不涉及任何人工操作，抽奖结果以系统判
            定为准，不得争议。
            <br>6、如果达到抢红包条件，请于在当天的抢红包活动时间规定内进行参与，超过限定抢红包时间将视为会员自动弃权，不得争议！
            <br>7、*此活动可与其他优惠同时申请!
            <br>8、彩票联盟保留对活动最终解释权；以及在无通知的情况下修改，终止活动的权利，适用于所有优惠。
        </div>

        <div class="h10"></div>
        <div class="h10"></div>
    </div>

    <div class="h10"></div>
</div>

<div class="cop">
    Copyright © 彩票联盟 Reserved | 18+
</div>

<div class="h10"></div>
<div class="h10"></div>

<!-- 公告 -->
<div class="gonggao">
    <div class="gaoti">
        <span class="fl l30 cw f12 pl10">活动公告：</span>
        <div class="fr">
            <span class="db w22 tac fl  cup xiao">-</span>
            <span class="db fl  tac w22 cup  chag">X</span>
        </div>
    </div>

    <div class="cl h10"></div>
    <div class="luntop luntop1">
        <ul style="top: -140px; text-indent: 2em;">
            <li>当日存款达到以下标准的会员，隔天皆可参与抢红包，亿万红包将于（北京时间20:00至23:59开抢） 单个红包最高8888元，更多活动，敬请关注彩票联盟活动中心。</li>
        </ul>
    </div>
</div>

<!-- 领取窗口 start -->
<div class="tanchuceng" id="getWin" style="z-index: 99999999; display: none;">
    <div class="tanin" style="height:250px">
        <div class="chacha" onclick="closeGetWin();">×</div>
        <div class="tantoux">输入会员账号领取</div>
        <div class="cl h35"></div>
        <div class="tac shuzangh">
            <span class="">会员账号：</span>
            <input id="username" type="text" class="shuimsnt" value="">

        </div>
        <div class="cl h15"></div>
        <div class="tac shuzangh">
            <a href="javascript:;" class="chaaa" onclick="closeGetWin();"><img src="./images/submit.jpg" class="vm" alt=""></a>
        </div>
        <div class="cl h35"></div>
    </div>
</div>
<!-- 领取窗口 end -->

<!-- 查询窗口 start -->
<div class="tanchuceng" id="querywin" style="display:none; z-index:99999999">
    <div class="tanin">
        <div class="chacha" onclick="closeQueryWin();">×</div>
        <div class="tantoux">输入会员账号查询</div>
        <div class="cl h35"></div>
        <div class="tac shuzangh">
            <span class="">会员账号：</span>
            <input id="username-query" type="text" class="shuimsnt" value="">
            <a href="javascript:;" class="chaaa" onclick="query();"><img src="./images/chaa.png" class="vm" alt=""></a>
        </div>
        <div class="cl h15"></div>
        <div class="chatablewa">
            <table class="chtable">
                <tbody>
                <tr class="toum">
                    <td>红包金额</td>
                    <td>领取时间</td>
                    <td>是否派彩</td>
                </tr>
                </tbody>
                <tbody id="query-result">

                </tbody>
            </table>
        </div>
        <div class="cl h35"></div>
    </div>
</div>

<div id="hongbao_back" class="hide" style="display:none;"></div>
<div id="hongbao_open" class="popup flip" style="display:none;">
    <div class="popup-t"><a href="javascript:;" onclick="close_hongbao(this)" class="b1"><img src="./images/x.png"></a>
        <p class="b2"><img src="./images/logo.png" width="110"></p>
        <p class="b3"></p>
        <p class="b4">&nbsp;&nbsp;</p>
        <p class="b5" id="b5">恭喜发财，大吉大利</p>
        <a href="javascript:;" id="openpacket" onclick="getPacket()" class="b6">拆</a></div>
    <div class="popup-b"></div>
</div>

<div id="hongbao_result" class="reward flip" style="display:none;background-color: #e60000;">
    <div class="reward-t"><a href="javascript:;" onclick="close_hongbao(this)" class="b1"><img src="./images/x.png"></a>
        <p class="b2"><img src="./images/logo.png" width="110"></p>
    </div>
    <div class="reward-b">
        <p class="wx3"><span id="resultamount"></span><em>元</em></p>
        <p class="wx2">恭喜发财，大吉大利</p>
        <p class="wx1">彩金将在10分钟内派送</p>
    </div>
</div>


