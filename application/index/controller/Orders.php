<?php
namespace app\index\controller;

use think\Controller;

class Orders extends Controller
{

    //显示用户得会员订单列表
    public function member()
    {
        $cate = db("consumer_member")->where('is_del',0)->select();
        $users = db('consumer')->where('is_del',0)->select();
        $list=db('consumer_orders_member')->where('is_del',0)->paginate(10);
        return view("member_orders",['list'=>$list,'cate'=>$cate,'users'=>$users]);
    }
    //手动新增用户订单
    public function insert(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/orders/insert_html']);
        //生成订单id
        $data['order_number'] = date('YmdHis',time()).mt_rand(1000,9999);
        //获取会员身份标题
        $data['title'] = db('consumer_member')->where('id',$data['member_id'])->find()['title'];
        //计算会员价格
        $data['price'] = $data['price']*$data['dates'];
        //创建订单时间
        $data['create_time'] = time();
        $rs = db("consumer_orders_member")->insert($data);
        if($rs){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }
    //软删除订单
    public function delete($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time = time();
        $rs = db("consumer_orders_member")->where("id",$id)->update(["is_del"=>1,"delete_time"=>$time]);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    //展示购买会员订单
    public function show($id){
        $data = db("consumer_orders_member")->where("id",$id)->find();
        return view("show_member_order",["data"=>$data]);
    }
}
