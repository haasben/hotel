<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/9/3
 * Time: 18:12
 */

namespace app\index\controller;


use think\Controller;

class Platform extends Controller
{
    //控制台视图
    public function index()
    {
        $row=db('platform')->find();
        return view('Plat/index',['row'=>$row]);
    }
    //修改控制台
    public function edit()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('logo_img')){
            // 获取表单上传文件
            $file = request()->file('logo_img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['logo_img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
        }
        $r=db('platform')->update($data);
        if($r){
            return redirect('Platform/index');
        }else{
            $this->error('修改失败');
        }
    }


    //轮播图视图
    public function img()
    {
        $row=db('img')->where('is_delete',0)->order('state asc')->order('sort desc')->select();
        return view('Plat/img',['row'=>$row]);
    }
    //添加轮播图
    public function img_add()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('img')){
            // 获取表单上传文件
            $file = request()->file('img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
        }
        $data['start_time']=time();
        $count=db('img')->where('state',0)->where('is_delete',0)->count();
        if($count>=6){
            $data['state']=1;
        }
        $r=db('img')->insert($data);
        if($r){
            return redirect('Platform/img');
        }else{
            $this->error('添加失败');
        }
    }
    //删除轮播图
    public function img_del()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $id=input('id');
        $time=time();
        $r=db('img')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$time]);
        if($r){
            return redirect('Platform/img');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    //修改轮播图状态
    public function img_state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }

        $r=db('img')->where('id',$id)->find();
        if($r['state']==0){
            $s=db('img')->where('id',$id)->update(['state'=>1]);
        }else{
            $count=db('img')->where('state',0)->where('is_delete',0)->count();
            if($count>=6){
                $this->error('轮播图最多存在六张');
            }
            $s=db('img')->where('id',$id)->update(['state'=>0]);
        }
        if($s){
            return redirect('Platform/img');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //修改数据回显
    public function img_edit()
    {
        $id=input('id');
        $row=db('img')->where('id',$id)->find();
        return $row;
    }
    //修改轮播图
    public function img_update()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('img')){
            // 获取表单上传文件
            $file = request()->file('img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
            $data['update_time']=time();
            $r=db('img')->update($data);
        }else{
            $data['update_time']=time();
            $r=db('img')->update($data);
        }
        if($r){
            return redirect('Platform/img');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
    
    
    //首页导航视图
    public function navigation()
    {
        $row=db('home_navigation')->where('is_delete',0)->order('state asc')->order('sort desc')->select();
        return view('Plat/navigation',['row'=>$row]);
    }
    //添加导航
    public function navigation_add()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('img')){
            // 获取表单上传文件
            $file = request()->file('img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
        }
        $data['start_time']=time();
        $count=db('home_navigation')->where('state',0)->where('is_delete',0)->count();
        if($count>=4){
            $data['state']=1;
        }
        $r=db('home_navigation')->insert($data);
        if($r){
            return redirect('Platform/navigation');
        }else{
            $this->error('添加失败,请联系管理员');
        }
    }
    //软删除导航
    public function navigation_del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time=time();
        $r=db('home_navigation')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$time]);
        if($r){
            return redirect('Platform/navigation');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    //修改导航状态
    public function navigation_state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('home_navigation')->where('id',$id)->find();
        $time=time();
        if($row['state']==0){
            $r=db('home_navigation')->where('id',$id)->update(['state'=>1,'update_time'=>$time]);
        }else{
            $count=db('home_navigation')->where('state',0)->where('is_delete',0)->count();
            if($count>=4){
                $this->error('导航最多存在4个');
            }
            $r=db('home_navigation')->where('id',$id)->update(['state'=>0,'update_time'=>$time]);
        }
        if($r){
            return redirect('Platform/navigation');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //修改回显
    public function navigation_edit()
    {
        $id=input('id');
        $row=db('home_navigation')->where('id',$id)->find();
        return $row;
    }
    //修改导航
    public function navigation_update()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('img')){
            // 获取表单上传文件
            $file = request()->file('img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
            $data['update_time']=time();
            $r=db('home_navigation')->update($data);
        }else{
            $data['update_time']=time();
            $r=db('home_navigation')->update($data);
        }
        if($r){
            return redirect('Platform/navigation');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
    
    
    //广告
    public function poster()
    {
        $row=db('poster')->where('is_delete',0)->order('state asc')->select();
        return view('Plat/poster',['row'=>$row]);
    }
    //添加广告
    public function poster_add()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('img')){
            // 获取表单上传文件
            $file = request()->file('img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
        }
        $data['start_time']=time();
        $count=db('poster')->where('state',0)->where('is_delete',0)->count();
        if($count>=1){
            $data['state']=1;
        }
        $r=db('poster')->insert($data);
        if($r){
            return redirect('Platform/poster');
        }else{
            $this->error('添加失败,请联系管理员');
        }
    }
    //软删除广告
    public function poster_del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time=time();
        $r=db('poster')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$time]);
        if($r){
            return redirect('Platform/poster');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    //修改广告状态
    public function poster_state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('poster')->where('id',$id)->find();
        $time=time();
        if($row['state']==0){
            $r=db('poster')->where('id',$id)->update(['update_time'=>$time,'state'=>1]);
        }else{
            $count=db('poster')->where('state',0)->count();
            if($count>=1){
                $this->error('广告只能展示一个');
            }
            $r=db('poster')->where('id',$id)->update(['update_time'=>$time,'state'=>0]);
        }
        if($r){
            return redirect('Platform/poster');
        }else{
            $this->error('修改广告状态失败,请联系管理员');
        }
    }
    //修改回显
    public function poster_edit()
    {
        $id=input('id');
        $row=db('poster')->where('id',$id)->find();
        return $row;
    }
    //修改导航
    public function poster_update()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if(request()->file('img')){
            // 获取表单上传文件
            $file = request()->file('img');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['img'] =  '/uploads/roomstype/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }
            }
            $data['update_time']=time();
            $r=db('poster')->update($data);
        }else{
            $data['update_time']=time();
            $r=db('poster')->update($data);
        }
        if($r){
            return redirect('Platform/poster');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
}















