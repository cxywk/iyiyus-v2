<?php

namespace app\admin\model;

use think\Model;


class Cerman extends Model
{

    

    

    // 表名
    protected $name = 'cerman';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'cermdata_text',
        'pooldata_text',
        'typedata_text',
        'statedata_text',
        'warrantydata_text',
        'addtime_text',
        'warrantytime_text'
    ];
    
    public function getCermdataList()
    {
        return ['0' => __('Cermdata 0'), '1' => __('Cermdata 1'), '2' => __('Cermdata 2'), '3' => __('Cermdata 3')];
    }
    public function getSjypList()
    {
        return ['3' => __('一年')];
    }

    public function getPooldataList()
    {
        return ['0' => __('Pooldata 0'), '1' => __('Pooldata 1')];
    }

    public function getTypedataList()
    {
        return ['0' => __('Typedata 0'), '1' => __('Typedata 1')];
    }

    public function getStatedataList()
    {
        return ['0' => __('Statedata 0'), '1' => __('Statedata 1')];
    }

    public function getWarrantydataList()
    {
        return ['0' => __('Warrantydata 0'), '1' => __('Warrantydata 1')];
    }


    public function getCermdataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['cermdata']) ? $data['cermdata'] : '');
        $list = $this->getCermdataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPooldataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['pooldata']) ? $data['pooldata'] : '');
        $list = $this->getPooldataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['typedata']) ? $data['typedata'] : '');
        $list = $this->getTypedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['statedata']) ? $data['statedata'] : '');
        $list = $this->getStatedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getWarrantydataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['warrantydata']) ? $data['warrantydata'] : '');
        $list = $this->getWarrantydataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getAddtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['addtime']) ? $data['addtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getWarrantytimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['warrantytime']) ? $data['warrantytime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAddtimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setWarrantytimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
