<?php

namespace app\index\controller;
use think\Db;
use app\common\controller\Frontend;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $udid=isset($_GET['udid'])?$_GET['udid']:'';
        if (!(strlen($udid) == 25 || strlen($udid) == 40||strlen($udid) == 0))  return '<h2>非法访问！</h2>';
       
        $categorytype = json_decode(Db::table('fa_config')-> where('name','categorytype')->value('value'),true);
        $categorytype_key=array_keys($categorytype);
        $gg = explode("\r\n", Db::table('fa_config')-> where('name','gonggao')->value('value'));
        $lburl = explode("\r\n", Db::table('fa_config')-> where('name','lburl')->value('value'));
        foreach ($categorytype_key as $key => $value) {
            $ls=['id'=>$value,'value'=>$categorytype[$value]];
            $all=Db::table('fa_category')->where('status',"normal")->where('type',$value)->order('weigh desc')->select();
            $childs=[];
            foreach ($all as $key => $vo) {
                $childs[]=['id'=>$vo['id'],'value'=>$vo['name'],'desc'=>$vo['description'],'bid'=>$vo['baoming'],'banben'=>$vo['banben'],'filesize'=>$vo['filesize'],'image'=>$vo['image']];
            }
            $ls['childs']=$childs;
            $datas[]=$ls;
        }
        // 更新日志 
        $updateLog = Db::table('fa_category')->field('name, banben, description as `desc`, from_unixtime(update_time, "%Y-%m-%d") as `date`')->orderRaw('update_time+0 desc')->select();

        $this->assign('applist',$datas);
        $this->assign('lburl',$lburl);
        $this->assign('gg',$gg);
        $this->assign('updateLog',$updateLog);
        return $this->view->fetch();
    }

    public function getudid()
    {
       $data = file_get_contents('php://input');
        $plistBegin   = '<?xml version="1.0"';
        $plistEnd   = '</plist>';
        $pos1 = strpos($data, $plistBegin);
        $pos2 = strpos($data, $plistEnd);
        $data2 = substr ($data,$pos1,$pos2-$pos1);
        $xml = xml_parser_create();
        xml_parse_into_struct($xml, $data2, $vs);
        xml_parser_free($xml);
        
        $UDID = "";

        $DEVICE_PRODUCT = "";
        
        $iterator = 0;
        
        $arrayCleaned = array();
        foreach($vs as $v){
            if($v['level'] == 3 && $v['type'] == 'complete'){
        
            $arrayCleaned[]= $v;
        
            }
        $iterator++;
        
        }
        
        $data = "";
        $iterator = 0;
        
        foreach($arrayCleaned as $elem){
        
            $data .= "\n==".$elem['tag']." -> ".$elem['value']."<br/>";
        
            switch ($elem['value']) {
        
                case "PRODUCT":
        
                    $DEVICE_PRODUCT = $arrayCleaned[$iterator+1]['value'];
        
                    break;
        
                case "UDID":
        
                    $UDID = $arrayCleaned[$iterator+1]['value'];
        
                    break;
                 
        
                }
                $iterator++;
        
        }
        
         
        
        $params = "udid=".$UDID;
        
        switch ($DEVICE_PRODUCT)
        {
         // iphone 系列
        case "iPhone1,1": $DEVICE_PRODUCT= "iPhone 1G";break;
        case "iPhone1,2": $DEVICE_PRODUCT= "iPhone 3G";break;
        case "iPhone2,1": $DEVICE_PRODUCT= "iPhone 3GS";break;
        case "iPhone3,1": $DEVICE_PRODUCT= "iPhone 4";break;
        case "iPhone3,2": $DEVICE_PRODUCT= "Verizon iPhone 4";break;
        case "iPhone3,3": $DEVICE_PRODUCT= "iPhone 4";break;
        case "iPhone4,1": $DEVICE_PRODUCT= "iPhone 4S";break;
        case "iPhone5,1": $DEVICE_PRODUCT= "iPhone 5";break;
        case "iPhone5,2": $DEVICE_PRODUCT= "iPhone 5";break;
        case "iPhone5,3": $DEVICE_PRODUCT= "iPhone 5C";break;
        case "iPhone5,4": $DEVICE_PRODUCT= "iPhone 5C";break;
        case "iPhone6,1": $DEVICE_PRODUCT= "iPhone 5S";break;
        case "iPhone6,2": $DEVICE_PRODUCT= "iPhone 5S";break;
        case "iPhone7,1": $DEVICE_PRODUCT= "iPhone 6 Plus";break;
        case "iPhone7,2": $DEVICE_PRODUCT= "iPhone 6";break;
        case "iPhone8,1": $DEVICE_PRODUCT= "iPhone 6s";break;
        case "iPhone8,2": $DEVICE_PRODUCT= "iPhone 6s Plus";break;
        case "iPhone8,4": $DEVICE_PRODUCT= "iPhone SE";break;
        case "iPhone9,1": $DEVICE_PRODUCT= "iPhone 7";break;
        case "iPhone9,2": $DEVICE_PRODUCT= "iPhone 7 Plus";break;
        case "iPhone9,3": $DEVICE_PRODUCT= "iPhone 7";break;
        case "iPhone9,4": $DEVICE_PRODUCT= "iPhone 7 Plus";break;
        case "iPhone10,1": $DEVICE_PRODUCT= "iPhone 8";break;
        case "iPhone10,2": $DEVICE_PRODUCT= "iPhone 8 Plus";break;
        case "iPhone10,3": $DEVICE_PRODUCT= "iPhone X";break;
        case "iPhone10,4": $DEVICE_PRODUCT= "iPhone 8";break;
        case "iPhone10,5": $DEVICE_PRODUCT= "iPhone 8 Plus";break;
        case "iPhone10,6": $DEVICE_PRODUCT= "iPhone X";break;
        case "iPhone11,2": $DEVICE_PRODUCT= "iPhone XS";break;
        case "iPhone11,4": $DEVICE_PRODUCT= "iPhone XS Max";break;
        case "iPhone11,6": $DEVICE_PRODUCT= "iPhone XS Max";break;
        case "iPhone11,8": $DEVICE_PRODUCT= "iPhone XR";break;
        case "iPhone12,1": $DEVICE_PRODUCT= "iPhone 11";break;
        case "iPhone12,3": $DEVICE_PRODUCT= "iPhone 11 Pro";break;
        case "iPhone12,5": $DEVICE_PRODUCT= "iPhone 11 Pro Max";break;
        case "iPhone12,8": $DEVICE_PRODUCT= "iPhone SE (2nd generation)";break;
        case "iPhone13,1": $DEVICE_PRODUCT= "iPhone 12 mini";break;
        case "iPhone13,2": $DEVICE_PRODUCT= "iPhone 12";break;
        case "iPhone13,3": $DEVICE_PRODUCT= "iPhone 12 Pro";break;
        case "iPhone13,4": $DEVICE_PRODUCT= "iPhone 12 Pro Max";break;
        case "iPhone14,5": $DEVICE_PRODUCT= "iPhone 13";break;
        case "iPhone14,2": $DEVICE_PRODUCT= "iPhone 13 Pro";break;
        case "iPhone14,3": $DEVICE_PRODUCT= "iPhone 13 Pro Max";break;
        case "iPhone14,4": $DEVICE_PRODUCT= "iPhone 13 mini";break;
        case "iPhone14,8": $DEVICE_PRODUCT= "iPhone 14 Plus";break;
        case "iPhone15,2": $DEVICE_PRODUCT= "iPhone 14 Pro";break;
        case "iPhone15,3": $DEVICE_PRODUCT= "iPhone 14 Pro Max";break;
        case "iPhone14,7": $DEVICE_PRODUCT= "iPhone 14 ";break;
        // iPod 系列
        case "iPod1,1": $DEVICE_PRODUCT= "iPod Touch 1G";break;
        case "iPod2,1": $DEVICE_PRODUCT= "iPod Touch 2G";break;
        case "iPod3,1": $DEVICE_PRODUCT= "iPod Touch 3G";break;
        case "iPod4,1": $DEVICE_PRODUCT= "iPod Touch 4G";break;
        case "iPod5,1": $DEVICE_PRODUCT= "iPod Touch 5G";break;
        case "iPod7,1": $DEVICE_PRODUCT= "iPod Touch 6G";break;
        case "iPod9,1": $DEVICE_PRODUCT= "iPod Touch 7G";break;
        // iPad
        case "iPad1,1": $DEVICE_PRODUCT= "iPad";break;
        case "iPad1,2": $DEVICE_PRODUCT= "iPad 3G";break;
        case "iPad2,1": $DEVICE_PRODUCT= "iPad 2 (WiFi)";break;
        case "iPad2,2": $DEVICE_PRODUCT= "iPad 2";break;
        case "iPad2,3": $DEVICE_PRODUCT= "iPad 2";break;
        case "iPad2,4": $DEVICE_PRODUCT= "iPad 2 (32nm)";break;
        case "iPad2,5": $DEVICE_PRODUCT= "iPad Mini (WiFi)";break;
        case "iPad2,6": $DEVICE_PRODUCT= "iPad Mini";break;
        case "iPad2,7": $DEVICE_PRODUCT= "iPad Mini";break;
        case "iPad3,1": $DEVICE_PRODUCT= "iPad 3(WiFi)";break;
        case "iPad3,2": $DEVICE_PRODUCT= "iPad 3(CDMA)";break;
        case "iPad3,3": $DEVICE_PRODUCT= "iPad 3(4G)";break;
        case "iPad3,4": $DEVICE_PRODUCT= "iPad 4 (WiFi)";break;
        case "iPad3,5": $DEVICE_PRODUCT= "iPad 4 (4G)";break;
        case "iPad3,6": $DEVICE_PRODUCT= "iPad 4";break;
        case "iPad4,1": $DEVICE_PRODUCT= "iPad Air";break;
        case "iPad4,2": $DEVICE_PRODUCT= "iPad Air";break;
        case "iPad4,3": $DEVICE_PRODUCT= "iPad Air";break;
        case "iPad4,4": $DEVICE_PRODUCT= "iPad Mini 2";break;
        case "iPad4,5": $DEVICE_PRODUCT= "iPad Mini 2";break;
        case "iPad4,6": $DEVICE_PRODUCT= "iPad Mini 2";break;
        case "iPad4,7": $DEVICE_PRODUCT= "iPad Mini 3";break;
        case "iPad4,8": $DEVICE_PRODUCT= "iPad Mini 3";break;
        case "iPad4,9": $DEVICE_PRODUCT= "iPad Mini 3";break;
        case "iPad5,1": $DEVICE_PRODUCT= "iPad Mini 4";break;
        case "iPad5,2": $DEVICE_PRODUCT= "iPad Mini 4";break;
        case "iPad5,3": $DEVICE_PRODUCT= "iPad Air 2";break;
        case "iPad5,4": $DEVICE_PRODUCT= "iPad Air 2";break;
        case "iPad6,3": $DEVICE_PRODUCT= "iPad Pro (9.7-inch)";break;
        case "iPad6,4": $DEVICE_PRODUCT=  "iPad Pro (9.7-inch)";break;
        case "iPad6,7": $DEVICE_PRODUCT= "iPad Pro (12.9-inch)";break;
        case "iPad6,8": $DEVICE_PRODUCT= "iPad Pro (12.9-inch)";break;
        case "iPad6,11": $DEVICE_PRODUCT= "iPad 5";break;
        case "iPad6,12": $DEVICE_PRODUCT= "iPad 5";break;
        case "iPad7,1": $DEVICE_PRODUCT= "iPad PRO 2 (12.9)";break;
        case "iPad7,2": $DEVICE_PRODUCT= "iPad PRO 2 (12.9)";break;
        case "iPad7,3": $DEVICE_PRODUCT= "iPad PRO (10.5)";break;
        case "iPad7,4": $DEVICE_PRODUCT= "iPad PRO (10.5)";break;
        case "iPad7,5": $DEVICE_PRODUCT= "iPad (6th generation)";break;
        case "iPad7,6": $DEVICE_PRODUCT= "iPad (6th generation)";break;
        case "iPad7,11": $DEVICE_PRODUCT= "iPad (7th generation)";break;
        case "iPad7,12": $DEVICE_PRODUCT= "iPad (7th generation)";break;
        case "iPad11,6": $DEVICE_PRODUCT= "iPad (8th generation)";break;
        case "iPad11,7": $DEVICE_PRODUCT= "iPad (8th generation)";break;
        case "iPad8,1":$DEVICE_PRODUCT= "iPad Pro (11-inch)";break; 
        case "iPad8,2":$DEVICE_PRODUCT= "iPad Pro (11-inch)";break;
        case "iPad8,3":$DEVICE_PRODUCT= "iPad Pro (11-inch)";break;
        case "iPad8,4": $DEVICE_PRODUCT= "iPad Pro (11-inch)";break;
        case "iPad8,5": $DEVICE_PRODUCT= "iPad Pro (12.9-inch) (3rd generation)";break;
        case "iPad8,6": $DEVICE_PRODUCT= "iPad Pro (12.9-inch) (3rd generation)";break;
        case "iPad8,7": $DEVICE_PRODUCT= "iPad Pro (12.9-inch) (3rd generation)";break;
        case "iPad8,8": $DEVICE_PRODUCT= "iPad Pro (12.9-inch) (3rd generation)";break;
        case "iPad8,9": $DEVICE_PRODUCT= "iPad Pro (11-inch) (2nd generation)";break;
        case "iPad8,10": $DEVICE_PRODUCT= "iPad Pro (11-inch) (2nd generation)";break;
        case "iPad8,11": $DEVICE_PRODUCT= "iPad Pro (12.9-inch) (4th generation)";break;
        case "iPad8,12": $DEVICE_PRODUCT= "iPad Pro (12.9-inch) (4th generation)";break;
        case "iPad11,1": $DEVICE_PRODUCT= "iPad mini (5th generation)";break;
        case "iPad11,2": $DEVICE_PRODUCT= "iPad mini (5th generation)";break;
        case "iPad11,3": $DEVICE_PRODUCT= "iPad Air (3rd generation)";break;
        case "iPad11,4": $DEVICE_PRODUCT= "iPad Air (3rd generation)";break;
        case "iPad12,1": $DEVICE_PRODUCT= "iPad 9";break;
        case "iPad12,2": $DEVICE_PRODUCT= "iPad 9";break;
        case "iPad13,1": $DEVICE_PRODUCT= "iPad Air (4th generation)";break; 
        case "iPad13,2": $DEVICE_PRODUCT= "iPad Air (4th generation)";break;
        }
      	$chkis = Db::table('fa_udidlist')->where('udid',$UDID)->order('id desc')->select();
        if($chkis){
            Db::table('fa_udidlist')->where('udid',$UDID)->update(array('product'=>$DEVICE_PRODUCT));   
        }else{
            $sbcs=Db::table('fa_config')-> where('name','sbcs')->value('value');
            $sjs=0;
            if($UDID!=''){
            Db::table('fa_udidlist')->insert(array('udid'=>$UDID,'type'=>0,'product'=>$DEVICE_PRODUCT,'sign'=>$sbcs,'sjskg'=>$sjs)); 
            
            $zctz=Db::table('fa_config')-> where('name','zctz')->value('value');
            $wechatkey=Db::table('fa_config')-> where('name','wechatkey')->value('value');
            if($zctz==1){
                $url = $wechatkey;
                $post_data['msgtype'] = 'markdown';
                $post_data['markdown'] =array('content'=> "<font color=\"warning\">有新用户获取了UDID！</font>
                 >#### 机型:<font color=\"comment\">".$DEVICE_PRODUCT."</font>
                 >#### <font color=\"info\">".$UDID."</font>");
                 $this->request_post($url, json_encode($post_data));
            }
            }
        }
       
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: https://".$_SERVER['HTTP_HOST']."/?".$params);
        exit();
    }
    
     function request_post($url = '', $post_data = array()) {
		if (empty($url) || empty($post_data)) {
			return false;
		}
		$postUrl = $url;
		$curlPost = $post_data;
		$ch = curl_init();
		//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);
		//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);
		//post提交方式
		curl_setopt($ch, CURLOPT_ENCODING, "");
		//解压
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip, deflate,flate'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//不验证证书下同
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//不验证证书下同
		$data = curl_exec($ch);
		//运行curl
		curl_close($ch);
	
	}
	

}
