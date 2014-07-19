<?php
//邀请码处理模型
if (!defined("IN_ESOTALK")) exit;

/**
 * @package esoTalk
 */
class ETInviteModel extends ETModel {

    const CACHE_KEY = "invite";


    /**
     * A local cache of all groups and their details.
     * @var array
     */
    protected $invite;


    /**
     * Class constructor; sets up the base model functions to use the group table.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct("invite");
    }

    /**
     * 生成邀请吗
     * @param int $num 生成的数量
     */
    public function createCode($num){
        $i = 0;
        $box = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        while($i<$num){
            $j = 0;
            $code = '';
            while($j<10){
                $code .= $box[array_rand($box,1)];
                $j++;
            }
            parent::create(array('code'=>$code,'used'=>0));
            $i++;
        }

    }

    /**
     * 获取邀请码
     * @param array $where 筛选条件默认是未被使用的
     * @return array
     */
    public function getAll($where=array('used'=>0)) {
        return parent::get($where);
    }

    /**
     * 删除已经被使用的邀请码
     * @param $code
     * @return ETSQLResult
     */
    public function deleteByCode($code) {
        return parent::delete(array('code'=>$code));
    }

    /**
     * 检查并删除邀请码
     * @param $code
     * @return ETSQLResult
     */
    public function checkCode($code) {
        $info = parent::get(array('code'=>$code));
        return (bool)$info;
    }
}