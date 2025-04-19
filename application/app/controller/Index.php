<?php

namespace app\app\controller;
use think\Db;
use app\common\controller\Frontend;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $pathurl='https://'.$_SERVER['HTTP_HOST']. $_SERVER["REQUEST_URI"];
        if(substr($_SERVER["REQUEST_URI"],-1)=='='){
            $urlid= substr($_SERVER["REQUEST_URI"],-6,-1);
        }else{
            $urlid= substr($_SERVER["REQUEST_URI"],-5);
        }
        
        $chkis = Db::table('fa_shorturl')->where('shortid',$urlid)->select();
        if(!$chkis){
            print <<<EOT
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>404</title>
    <style>
    	body{
    		background-color:#444;
    		font-size:14px;
    	}
    	h3{
    		font-size:30px;
    		color:#eee;
    		text-align:center;
    		padding-top:30px;
    		font-weight:normal;
    	}
    </style>
    </head>
    
    <body>
    <h3>此链接不存在或已失效</h3>
    </body>
    </html>
EOT;
            exit();
        }
        
        $data= $this->_decrypt($chkis[0]['url'], '8659471');
        $plist = explode(",", $data);
        $ua = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($ua, 'MicroMessenger') == false && strpos($ua, 'Windows Phone') == false) {
        print <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>$plist[0]</title>
    <link href="assets/app/app.css" rel="stylesheet" />
    <script src="assets/app/qrcode.min.js"></script>
    <script type="text/javascript" src="/assets/index/css/jquery.js"></script>
    <script src="/assets/index/css/layer.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/assets/index/css/layer.css" id="layuicss-layer">
    <link href="assets/app/iosdownload.css" rel="stylesheet" />
</head>
<body>
    <div class="container">

        <div class="titleHead">
            <div class="appTitle">$plist[0]</div>
        </div>
        <img class="appIcon" src="$plist[1]" />

        <a class="installButton" onclick="Install('$urlid')">
            <i class="iconApple"></i>
            <span id="lblInstallText"> 点击安装</span>
        </a>

        <div class="span12" style="text-align:center;">
            <span class="label label-info">适用于iOS设备</span>
            <span class="label label-danger">内测版</span>
        </div>

        <div class="bottom">
            <p>
                或者用手机扫描下面的二维码安装
            </p>
            <div id="qrcode"></div>

            <script type="text/javascript">
                new QRCode(document.getElementById("qrcode"), "$pathurl");
                
                
                function Install(id) {
                $.ajax({
                    type: 'POST',
                    url: "/app/index/install_app",
                    data: {urlid:id,},
                    dataType: "json",
                    success: function(result, textStatus, jqXHR) {
                        if(result.code==1){
                            window.location.href = "itms-services://?action=download-manifest&url="+result.msg;
                          
                        }else{
                            layer.msg(result.msg);
                        }
                        
                        
            
                    },
                    error: function(response) {
                    layer.msg('安装地址获取失败！');
                          
                    }});
                } 

          
            </script>

        </div>


    </div>

</body>

        
        
        
EOT;
}else{
    
    	echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="font-size: 100px;">
<head id="Head1"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>站点提示</title>
    <!--禁止全屏缩放-->
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <!--不显示成手机号-->
    <meta name="format-detection" content="telephone=no" />
    <!--删除默认的苹果工具栏和菜单栏-->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!--解决UC手机字体变大的问题-->
    <meta name="wap-font-scale" content="no" />
    <!--控制状态栏显示样式-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link href="assets/app/index.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    
<iframe src="assets/app/test.html" width="100%" height="800" frameborder="0"></iframe> 
</body>
</html>';						 
    
}
       
    }
    
function _decrypt($data, $key) {
	$data = str_replace(array('ksq','wangbei','haha'), array('=','+','/'),$data);
	$key = md5($key);
	$x = 0;
	$data = base64_decode($data);
	$expire = substr($data, 0, 10);
	$data = substr($data, 10);
	if($expire > 0 && $expire < time()) {
		return null;
	}
	$len = strlen($data);
	$l = strlen($key);
	$char = $str = '';
	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}
	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		} else {
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return base64_decode($str);
}


function install_app($urlid) {
    $chkis = Db::table('fa_shorturl')->where('shortid',$urlid)->select();
    $shorturl=$chkis[0];
    if($shorturl['cs']<=0)$this->error('安装失败：下载次数不足');
    $jymsg=Db::table('fa_config')-> where('name','jymsg')->value('value');
    $chkis = Db::table('fa_udidlist')->where('udid',$shorturl['udid'])->order('id desc')->select();
    $a_udid=$chkis[0];
    if($a_udid['disable']==1)$this->error($jymsg);
     Db::table('fa_shorturl')->where('shortid',$urlid)->setDec('cs', 1);      
	$appurl='https://'.$_SERVER['HTTP_HOST'].'/plist.php?'.$shorturl['url'];
	$this->success($appurl);
}

   
}
