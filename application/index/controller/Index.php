<?php
namespace app\index\controller;

use think\Session;

class Index extends \think\Controller
{
    public static $md=[];
    public static $cj=[];
    //首页
    public function home()
    {
        $user=Session::get('users');
        $js=db('power')
            ->where('id',$user['role_id'])
            ->find();
        //导航容器
        $a=[];
        if ($js['name']=='超级管理员'){
            $rows=db('pow')
                ->where('is_delete',0)
                ->where('state','正常')
                ->where('cj',1)
                ->order('sort desc')
                ->select();
            $rows_one=db('pow')
                ->where('is_delete',0)
                ->where('state','正常')
                ->order('sort desc')
                ->select();
            foreach ($rows as $k=>$row) {
                foreach ($rows_one as $item) {
                    if ($row['id']==$item['parent_id']){
                        $rows[$k]['er'][$item['pow_url']]=$item['pow_name'];
                    }
                }
            }
            foreach ($rows as $m=>$f) {
                if (empty($f['er'])){
                    $rows[$m]['er']=[];
                }
            }
            $a=$rows;
        }else{
            $this->read(0,$user['role_id']);
            $md = self::$md;
            $rows=$md;
            //找到所有层级为1的
            foreach ($rows as $row) {
                if($row['cj']==1){
                    $a[]=$row;
                }
            }
            //利用层级为1的找到子级，并附给er数组
            foreach ($a as $f=>$b) {
                foreach ($rows as $k=>$row) {
                    if ($b['id']==$row['parent_id']){
                        $a[$f]['er'][$row['pow_url']]=$row['pow_name'];
                    }
                }
            }
            //没有数据时，er为空
            foreach ($a as $p=>$item) {
                if (empty($item['er'])){
                    $a[$p]['er']=[];
                }
            }
        }
        return view('Index/index',['user'=>$user,'rows'=>$a,'js'=>$js]);
    }
    //找子级
    public function read($pid,$role_id)
    {
        $rows=db('pow')->where('is_delete',0)->where('state','正常')->where('parent_id',$pid)->order('sort desc')->select();
        $power=db('pow_power')->where('power_id',$role_id)->find();
        $pow=explode(",",$power['pow_id']);
        foreach ($rows as $row) {
            foreach ($pow as $v){
                if($v==$row['id']){
                    self::$md[]=$row;
                    $this->read($row['id'],$role_id);
                }
            }
        }
    }
    //退出登录
    public function user_out()
    {
        Session::delete('users');
        $this->success('退出成功','Login/login');
    }
}
