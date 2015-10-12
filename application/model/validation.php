<?php
namespace Model;

class Validation extends \Core\Validation
{
    /**
     * 数据
     * @var array
     */
    protected $data = array();
    
    /**
     * 设置数据
     * @param array $arr
     */
    public function set_data($arr)
    {
    	$this->data = $arr;
    }
    
    /**
     * 获取错误消息
     */
    public function get_error($key = NULL)
    {
        $data = array('message'=>$this->error_mesage, 'code'=>$this->error_code, 'data'=>$this->data);
        if ($key !== NULL && isset($data[$key]))
        {
            return $data[$key];
        }
        return $data;
    }
    
    /**
     * 输出数据
     */
    public function send()
    {
        header("Content-type: application/json");
        $info = $this->get_error();
        echo json_encode($info);exit();
    }
}