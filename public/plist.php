<?php

$data= $_SERVER["QUERY_STRING"];
$data= _decrypt($data, '8659471');
$plist = explode(",", $data);



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

function isDict($array)
{
 return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));

}

//向xml节点中写入字典数组（dict）
function xmlWriteDict(XMLWriter $x, &$dict) 
{
 $x->startElement('dict');
 foreach($dict as $k => &$v) 
 {
 $x->writeElement('key', $k);
 xmlWriteValue($x, $v);
 }
 $x->endElement();
}
 
 //向xml节点中写入数组（array）
function xmlWriteArray(XMLWriter $x, &$arr) 
{
 $x->startElement('array');
 foreach($arr as &$v)
 xmlWriteValue($x, $v);
 $x->endElement();
}

//根据类型向xml节点中写入值
function xmlWriteValue(XMLWriter $x, &$v) 
{
 if (is_int($v) || is_long($v))
 $x->writeElement('integer', $v);
 elseif (is_float($v)  || is_double($v))
 $x->writeElement('real', $v);
 elseif (is_string($v))
 $x->writeElement('string', $v);
 elseif (is_bool($v))
 $x->writeElement($v?'true':'false');
 elseif (isDict($v))
 xmlWriteDict($x, $v);
 elseif (is_array($v))
 xmlWriteArray($x, $v);
 else 
 {
 trigger_error("Unsupported data type in plist ($v)", E_USER_WARNING);
 $x->writeElement('string', $v);
 }
}

//创建plist
function createplist($title,$pngurl,$bundle_identifier,$ipaurl)
{

 $subtitle = 'Wangbei Inc.';
 $versionname = '1.0.0';
 $versioncode = str_replace('.', '', $versionname);
 $channelid = $_GET['cid'];
 if (!$channelid) 
 {
 $channelid = '0';
 }


 $plist = new XmlWriter();
 $plist->openMemory();
 $plist->setIndent(TRUE);
 $plist->startDocument('1.0', 'UTF-8');
 $plist->writeDTD('plist', '-//Apple//DTD PLIST 1.0//EN', 'http://www.apple.com/DTDs/PropertyList-1.0.dtd');
 $plist->startElement('plist');
 $plist->writeAttribute('version', '1.0');

 $pkg = array();
 $pkg['kind'] = 'software-package';
 $pkg['url'] = $ipaurl;

 $displayimage = array();
 $displayimage['kind'] = 'display-image';
 $displayimage['needs-shine'] = TRUE;
 $displayimage['url'] = $pngurl;

 $fullsizeimage = array();
 $fullsizeimage['kind'] = 'full-size-image';
 $fullsizeimage['needs-shine'] = TRUE;
 $fullsizeimage['url'] = $pngurl;

 $assets = array();
 $assets[] = $pkg;
 $assets[] = $displayimage;
 $assets[] = $fullsizeimage;

 $metadata = array();
 $metadata['bundle-identifier'] = $bundle_identifier;
 $metadata['bundle-version'] = $versionname;
 $metadata['kind'] = 'software';
 $metadata['subtitle'] = $subtitle;
 $metadata['title'] = $title;

 $items0 = array();
 $items0['assets'] = $assets;
 $items0['metadata'] = $metadata;

 $items = array();
 $items[] = $items0;

 $root = array();
 $root['items'] = $items;

 xmlWriteValue($plist, $root);

 $plist->endElement();
 $plist->endDocument();

 return $plist->outputMemory();
}

echo createplist($plist[0],$plist[1],$plist[2],$plist[3]);
exit;
?>