<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Room extends Controller
{
    //显示房间列表
    public function index()
    {
        $list = db('rooms')
            ->field('a.*,b.title')
            ->alias('a')
            ->join('rooms_type b','a.type_id = b.id','left')
            ->where('a.is_del',0)
            ->paginate(10);
//        var_dump($list);exit;
        $info = $list->toArray();
//        var_dump($info);exit;
        foreach($info['data'] as &$value){
            $value['img_id'] = db('room_img')->where('is_del',0)->where('room_id',$value['id'])->find();
//            var_dump($value['img_id']);
        }
//        var_dump($value['img_id']);exit;
//        var_dump($info);exit;
        //房间类型
        $roomtype = db('rooms_type')->where('is_del',0)->select();
//        var_dump($roomtype);exit;
        return view("index",["list"=>$info['data'],"roomtype"=>$roomtype,'page' => $list->render()]);
    }
    //手动新增房间
    public function insert()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/room/insert_html']);
//        var_dump($data);exit;
        //酒店房房间图片上传
        if(request()->file('path')){
            // 获取表单上传文件
            $file = request()->file('path');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/rooms');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $roomimg['path'] =  '/uploads/rooms/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        // 开启事务
        Db::startTrans();
        try {
            //插入房间类型表
            $roomimg['room_id'] = db("rooms")->insertGetId($data);  //  获取刚添加得id
            $roomtype = db('rooms_type')->where('id',$data['type_id'])->setInc('roomscount');
            if(request()->file('path')){
                //插入图片表
                $img = db('room_img')->insertGetId($roomimg);
                if ($roomimg['room_id'] && $roomtype && $img) {
                    // 提交事务
                    Db::commit();
                    $str = "添加成功";
                }
            }else if($roomimg['room_id'] && $roomtype){
                Db::commit();
                $str = "添加成功";
            }

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $str = $e->getMessage();
        }
        if($str){
            return redirect('room/index');
        }else{
            $this->error($str);
        }
    }

    //查看房间详情
    public function show($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = db('rooms')
            ->field('a.*,b.title')
            ->alias('a')
            ->join('rooms_type b','a.type_id = b.id','left')
            ->where("a.id",$id)
            ->where('a.is_del',0)
            ->find();
        $data['img_id'] = db('room_img')->where('is_del',0)->where('room_id',$data['id'])->where('main_img',0)->find();
//        var_dump($data);exit;
        return json_encode($data);
    }
    //软删除房间
    public function delete($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time = time();
        $rs = db("rooms")->where("id",$id)->update(["is_del"=>1,"delete_time"=>$time]);
        if($rs){
            return redirect('room/index');
        }else{
            $this->error('删除失败');
        }
    }
    //修改房间回显
    public function edit($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = db('rooms')->where("id",$id)->where('is_del',0)->find();
        $data['img_id'] = db('room_img')->where('is_del',0)->where('room_id',$data['id'])->where('main_img',0)->find();
        $data['types'] = db('rooms_type')->where('is_del',0)->select();
//        var_dump($data);exit;
        return json_encode($data);
    }
    //保存修改房间
    public function update(){
		// $lists = $_FILES['path2']['name'];
        $roomimg = [];
        $data = input();
        $path = '/index/room/update_html';
        unset($data[$path]);
//        var_dump($data);exit;
        //修改时间
        $data['update_time'] = time();
        $id = $data['myid'];
        unset($data['myid']);
        // 开启事务
        Db::startTrans();
        try {
            $rs1 = db('rooms')->where('id',$id)->update($data);
            //上传图片
            if(request()->file('path')){
                // 获取表单上传文件
                $file = request()->file('path');
                // 移动到框架应用根目录/public/uploads/ 目录下
                if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/rooms');
                    if($info){
                        if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                            $roomimg['room_id'] = $id;
                            $roomimg['path'] =  '/uploads/rooms/'.date("Ymd",time()).'/'.$info->getFilename();
                            $rs2 = db('room_img')->insert($roomimg);
                        }else{
                            $this->error('图片上传失败，请检查图片格式！');
                        }
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            if(request()->file('path2')){
                // 获取表单上传文件
                $files = request()->file('path2');

                foreach ($files as $file){
                    // 移动到框架应用根目录/public/uploads/ 目录下
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/rooms');
                    if($info){
                        if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                            $roomimg['room_id'] = $id;
                            $roomimg['path'] =  '/uploads/rooms/'.date("Ymd",time()).'/'.$info->getFilename();
                            $roomimg['main_img'] = 1;
                            $rs3 = db('room_img')->insert($roomimg);
                        }else{
                            $this->error('图片上传失败，请检查图片格式！');
                        }
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            if(request()->file('path')){
                if(request()->file('path2')){
                    if($rs1 && $rs2 && $rs3){//有主图和附图
                        // 提交事务
                        Db::commit();
                        $str = "修改成功";
                    }
                }else{
                    if($rs1 && $rs2){//有主图和无附图
                        // 提交事务
                        Db::commit();
                        $str = "修改成功";
                    }
                }
            }else{
                if(request()->file('path2')){
                    if($rs1 && $rs3){//无主图有附图
                        // 提交事务
                        Db::commit();
                        $str = "修改成功";
                    }
                }else{
                    if($rs1){//无图
                        // 提交事务
                        Db::commit();
                        $str = "修改成功";
                    }
                }
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $str = $e->getMessage();
        }
        if($str){
            return redirect('room/index');
        }else{
            $this->error($str);
        }
    }
}
