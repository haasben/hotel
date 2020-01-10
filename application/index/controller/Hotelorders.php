<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Hotelorders extends Controller
{
    //构造函数，判断数据状态（修改会员状态）
    public function _initialize()
    {
        $list = db('hotel_orders')->where("is_del",0)->select();
        $nums = count($list);
        for($i=0;$i<$nums;$i++){
            $outime = strtotime($list[$i]['create_time'])+2*60*60;
//            echo date("Y-m-d H:i:s",$outime)."<br/>";
            if($outime < time() && $list[$i]['status'] == 0){
                db("hotel_orders")->where('id',$list[$i]['id'])->update(['is_del'=>1]);
            }
        }
    }
    //显示用户的房间订单列表
    public function index()
    {
        $users = db('consumer')->where('is_del',0)->select();
        $list=db('hotel_orders')->where('is_del!=2')->paginate(10);
        $roomtypes = db('rooms_type')->where('is_del',0)->select();
        return view("index",['list'=>$list,"users"=>$users,"roomtypes"=>$roomtypes]);
    }
    //手动新增用户订单
    public function insert(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/hotelorders/insert_html']);
        $data['create_time'] = date("Y-m-d H:i:s",time());
        $data['intime'] = strtotime($data['intime']);
//        var_dump($data);exit;
        //生成订单id
        $data['ordernum'] = date('YmdHis',time()).mt_rand(1000,9999);
        //计算订单价格
        $row = db('rooms_type')->where('is_del',0)->where('title',$data['room_type'])->find();
        $data['price'] = $row['price'];
        //图片上传
        if(request()->file('header')){
            // 获取表单上传文件
            $file = request()->file('header');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/hotelorders');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['header'] =  '/uploads/hotelorders/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        //保存
        $rs = db("hotel_orders")->insert($data);
        if($rs){
            return redirect('hotelorders/index');
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
        $row = db('hotel_orders')->where('id',$id)->where('is_del!=2')->find();
//        var_dump($row);exit;
        if($row['is_del'] == 0){
            if($row['status'] != 0 && $row['status'] !=5){
                $this->error("订单已付款，管理员无法取消");
            }else{
                $rs = db("hotel_orders")->where("id",$id)->update(["is_del"=>1,"delete_time"=>time()]);
            }
        }else{
            $rs = db("hotel_orders")->where("id",$id)->update(["is_del"=>2,"delete_time"=>time()]);
        }
        if($rs){
            return redirect('hotelorders/index');
        }else{
            $this->error('删除失败');
        }
    }
    //展示酒店房间订单信息
    public function show($id){
        $data = db("hotel_orders")->where("id",$id)->find();
        $roomtypes = db('rooms_type')->where('is_del',0)->where('title',$data['room_type'])->find();
        $rooms = db('rooms')->where('is_del',0)->where('type_id',$roomtypes['id'])->where("status",0)->select();
        $data['rooms'] = $rooms;
        return json_encode($data);
    }
    //修改订单状态
    public function changestatus($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row = db('hotel_orders')->where('id',$id)->where('is_del != 2')->find();
        //后台支付
        if($row['status'] == 0){
            $rs = db("hotel_orders")->where("id",$id)->update(["status"=>1,"update_time"=>time(),"pay_time"=>time()]);
        }
        //入住
        if($row['status'] == 1){
            if(!empty($row['room'])){
                $orders = db("hotel_orders")->where("id",$id)->find();
                // 开启事务
                Db::startTrans();
                try {
                    //修改订单信息
                    $row = db("hotel_orders")->where("id",$id)->update(["status"=>2,"update_time"=>time(),"intime"=>time()]);
                    $row2 = db('rooms')->where('name',$orders['room'])->update(['status'=>2,'update_time'=>time()]);
                    if($row && $row2){
                        $rs = "退房成功";
                        Db::commit();
                    }
                } catch (\Exception $e) {
                    // 回滚事务
                    $rs = "";
                    Db::rollback();
                }
            }else{
                $this->error('请先点击编辑按钮选择入住房间！');
            }
        }
        //退房
        if($row['status'] == 2){
            $orders = db("hotel_orders")->where("id",$id)->find();
            // 开启事务
            Db::startTrans();
            try {
                //修改订单信息
                $row = db("hotel_orders")->where("id",$id)->update(['status'=>3,'update_time'=>time(),'out_time'=>time()]);
                $row2 = db('rooms')->where('name',$orders['room'])->update(['status'=>0,'update_time'=>time()]);
                if($row && $row2){
                    $rs = "退房成功";
                    Db::commit();
                }
            } catch (\Exception $e) {
                // 回滚事务
                $rs = "";
                Db::rollback();
            }
        }
//        var_dump($rs);
//        exit;
        //评论
        if($row['status'] == 3){
            return redirect('comment/index');
        }
        //已评
        if($row['status'] == 4){
            return redirect('hotelorders/index');
        }
        if($rs){
            return redirect('hotelorders/index');
        }else{
            $this->error("订单状态修改失败");
        }
    }
    //修改房间
    public function editorders(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/hotelorders/editorders_html']);
        $data['price'] = $data['orderprice'];
        unset($data['orderprice']);
        $id = $data['id'];
        unset($data['id']);
        $data['update_time'] = time();
//        var_dump($data);exit;
        // 开启事务
        Db::startTrans();
        try {
            //修改订单信息
            $rs = db("hotel_orders")->where("id",$id)->update($data);
            $rs2 = db('rooms')->where('name',$data['room'])->update(['status'=>1,'update_time'=>time()]);
            if($rs && $rs2){
                $str = "选房成功";
                Db::commit();
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $str = $e->getMessage();
        }
        if($str){
            return redirect('hotelorders/index');
        }else{
            $this->error($str);
        }
    }

    public function addcomment(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/hotelorders/addcomment_html']);
        $row = db('hotel_orders')->where('id',$data['myid'])->where('is_del != 2')->find();
        $id = $data['myid'];
        unset($data['myid']);
        $data['openid'] = $row['openid'];
        $name = db('rooms_type')->where('title',$row['room_type'])->where('is_del',0)->find();
        $data['type_id'] = $name['id'] ?? 1;
//        var_dump($data);exit;
        Db::startTrans();
        try {
            //修改订单信息
            $rs = db("comment")->insert($data);
            $rs2 = db('hotel_orders')->where('id',$id)->update(['status'=>4,'update_time'=>time()]);
            if($rs & $rs2){
                $str = "退房成功";
                Db::commit();
            }
        } catch (\Exception $e) {
            // 回滚事务
            $str = "";
            Db::rollback();
        }
        if($str){
            return redirect('hotelorders/index');
        }else{
            $this->error('添加失败');
        }
    }
}
