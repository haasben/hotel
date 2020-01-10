<?php
namespace app\index\controller;


use think\Controller;

class sortposter extends Controller
{
    // 显示分类广告
    public function index(){
        $row=db('sort_poster')->where('is_delete',0)->order('state asc')->select();
        return view('sortposter/index',['row'=>$row]);
    }
    // 分类广告添加
    public function poster_add(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('pic')){
            // 获取表单上传文件
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/sort_poster');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['pic'] =  '/uploads/sort_poster/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
        }
        $data['create_time']=time();
        $data['is_delete']=0    ;
        $count=db('sort_poster')->where('state',0)->where('is_delete',0)->count();
        if($count>=1){
            $data['state']=1;
        }
        $r=db('sort_poster')->insert($data);
        if($r){
            return redirect('sortposter/index');
        }else{
            $this->error('添加失败,请联系管理员');
        }
    }
    // 修改分类广告
    public function poster_update($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        var_dump($data);
        array_shift($data);
        if(request()->file('pic')){
            // 获取表单上传文件
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/sort_poster');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['pic'] =  '/uploads/sort_poster/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
            $data['update_time']=time();
            $r=db('sort_poster')->update($data);
        }else{
            $data['update_time']=time();
            $r=db('sort_poster')->update($data);
        }
        echo db('sort_poster')->getlastSql();
        // if($r){
        //     return redirect('sortposter/index');
        // }else{
        //     $this->error('修改失败,请联系管理员');
        // }
    }
    // 分类广告状态修改
    public function poster_state($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('sort_poster')->where('id',$id)->find();
        $time=time();
        if($row['state']==0){
            $r=db('sort_poster')->where('id',$id)->update(['update_time'=>$time,'state'=>1]);
        }else{
            $count=db('sort_poster')->where('state',0)->count();
            if($count>=1){
                $this->error('广告只能展示一个');
            }
            $r=db('sort_poster')->where('id',$id)->update(['update_time'=>$time,'state'=>0]);
        }
        if($r){
            return redirect('sortposter/index');
        }else{
            $this->error('修改广告状态失败,请联系管理员');
        }
    }
    // 分类广告删除
    public function poster_del($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time=time();
        $r=db('sort_poster')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$time]);
        if($r){
            return redirect('sortposter/index');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
}