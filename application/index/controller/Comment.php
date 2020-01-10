<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Comment extends Controller
{
    //显示评论信息
    public function index()
    {
        $users = db('consumer')->where('is_del',0)->select();
        $roomtype = db('rooms_type')->where('is_del',0)->select();
        $list=db('comment')->where('is_del',0)->order('settop desc')->select();
        return view("index",["list"=>$list,"users"=>$users,"roomtype"=>$roomtype]);
    }
    //评论置顶
    public function settop($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row = db('comment')->where('id',$id)->find();
        if($row['settop'] == 0){
            $rs = db('comment')->where('id',$id)->update(['settop'=>1,'update_time'=>time()]);
        }else{
            $rs = db('comment')->where('id',$id)->update(['settop'=>0,'update_time'=>time()]);
        }
        if($rs){
            return redirect('comment/index');
        }else{
            $this->error('置顶失败');
        }
    }
    //显示隐藏评论
    public function status($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row = db('comment')->where('id',$id)->find();
        if($row['status'] == 0){
            $rs = db('comment')->where('id',$id)->update(['status'=>1,'update_time'=>time()]);
        }else{
            $rs = db('comment')->where('id',$id)->update(['status'=>0,'update_time'=>time()]);
        }
        if($rs){
            return redirect('comment/index');
        }else{
            $this->error('修改失败');
        }
    }
    //删除评论
    public function delete($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $rs = db('comment')->where('id',$id)->update(['is_del'=>1,'delete_time'=>time()]);
        if($rs){
            return redirect('comment/index');
        }else{
            $this->error('删除失败');
        }
    }
    //新增评论
    public function insert()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/comment/insert_html']);
//        var_dump($data);exit;
        if(request()->file('comment_img')){
            // 获取表单上传文件
            $file = request()->file('comment_img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/comment');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['comment_img'] =  '/uploads/comment/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        $rs = db("comment")->insert($data);
        if($rs){
            return redirect('comment/index');
        }else{
            $this->error('添加失败');
        }
    }
    //修改公司基本信息接口
    public function edit($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $rs = db("comment")->where('id',$id)->find();
        return json_encode($rs);
    }
    //修改评论
    public function update(){
        $data = input();
        unset($data['/index/comment/update_html']);
        $id = $data['myid'];
        unset($data['myid']);
//        var_dump($data);exit;
        if(request()->file('main_img')){
            // 获取表单上传文件
            $file = request()->file('main_img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/hotel');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['main_img'] =  '/uploads/hotel/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        $data['update_time'] = time();
        $rs = db('comment')->where('id',$id)->update($data);
        if($rs){
            return redirect('comment/index');
        }else{
            $this->error('添加失败');
        }
    }
}
