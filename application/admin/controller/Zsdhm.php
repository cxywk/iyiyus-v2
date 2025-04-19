<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Zsdhm extends Backend
{
    
    /**
     * Kami模型对象
     * @var \app\admin\model\Kami
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Zsdhm;

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
	
    public function index()
    {
	   return parent::index();
    }
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
			
            if ($params) {
				$kmsl = intval($params['kami']);
				$kmqz = trim($params['udid']);
				$beizhu = trim($params['beizhu']);
				$sjtp = intval($params['sjyp']);
				$type = intval($params['type']);
				$shouhou = intval($params['shouhou']);
			
                if($kmsl ==0){
					$this->error('数量需大于0');
				}
				if(strlen($kmqz) ==0){
					$kmqz = '';
					//$this->error('请设置卡密前缀');
				}
				
				$jsq = $kmsl;
				$gtime = time();
				$gtm = date('YmdHis',time());
				$strs = '<br>';
				for ($i=1;$i<=$jsq;$i++) {
					$data = array();
					$rd = rand(1,15);
					$data['kami'] = strtoupper($kmqz.substr(md5(($gtm.'Km'.$i)),$rd,18));
					$data['udid'] = '';
					$data['zsid'] = '';
					$data['jh'] = 0;
					$data['beizhu'] = $beizhu;
					$data['sjyp'] = $sjtp;
					$data['type'] = $type;
					$data['shouhou'] =$shouhou;
					$data['jhtime'] = 0;
					Db::table('fa_zsdhm')->insert($data);
					$strs .= $data['kami'].'<br>';
				}
				Db::table('fa_dhmstr')->where('id',1)->update(array('kmstr'=>$strs));
                $this->success();
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
		return parent::add();
    }

}
