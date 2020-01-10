<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class storeseting extends Controller
{
    //商城开关页面
    public function index()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $res=db('store_seting')
            ->order('state desc')
            ->limit(1)
            ->select();
        return view("index",["res"=>$res]);
    }
    public function seting_state($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('store_seting')->where('id',$id)->find();
        if($row['state']==0){
            $data['update_time']=time();
            $data['state']=1;
            $r=db('store_seting')->where('id',$id)->update($data);
        }else{
            $data['update_time']=time();
            $data['state']=0;
            $r=db('store_seting')->where('id',$id)->update($data);
        }
        if($r){
            return redirect('storeseting/index');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    
}
