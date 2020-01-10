<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Company extends Controller
{
    //显示酒店信息
    public function index()
    {
        $list=db('companymsg')->find();
//        var_dump($list);exit;
        return view("index",["v"=>$list]);
    }
    //保存酒店基本信息
    public function insert()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/consumer/insert_html']);
        //判断是否有会员身份
        if($data['leavel'] != 0){
            $data['expire_time'] = time()+$data['opening_time']*30*24*60*60;
            $data['opening_time'] = time();
        }
//        var_dump($data);exit;
        if(request()->file('header')){
            // 获取表单上传文件
            $file = request()->file('header');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/hotel');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['header'] =  '/uploads/hotel/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        $rs = db("consumer")->insert($data);
        if($rs){
            return redirect('company/index');
        }else{
            $this->error('添加失败');
        }
    }
    //维护酒店按钮
    public function status(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = db("companymsg")->find();
        if($data['weihu']==0){
            $rs = db("companymsg")->where('id',1)->update(['weihu'=>1]);
            if($rs){
                return redirect('company/index');
            }else{
                $this->error('维护失败');
            }
        }else{
            $rs = db("companymsg")->where('id',1)->update(['weihu'=>0]);
            if($rs){
                return redirect('company/index');
            }else{
                $this->error('开放失败');
            }
        }
    }
    //修改公司基本信息接口
    public function edit(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $rs['another_img'] = db('companyimg')->select();
        return json_encode($rs);
    }
    //保存酒店基本信息得修改
    public function update(){
        $another = [];
        $data = input();
        $data['tel'] = $data['tels'];
        unset($data['tels']);
//        var_dump($data);exit;
        unset($data['/index/company/update_html']);
        $data['zhuce_time'] = strtotime($data['zhuce_time']);
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
        // 开启事务
        Db::startTrans();
        try {
            $rs1 = db('companymsg')->where('id',1)->update($data);
            if(request()->file('another_img')){
                // 获取表单上传文件
                $file = request()->file('another_img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/hotel');
                    if($info){
                        if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                            $another['img_path'] =  '/uploads/hotel/'.date("Ymd",time()).'/'.$info->getFilename();
                        }else{
                            $this->error('图片上传失败，请检查图片格式！');
                        }
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            $rs2 = db('companyimg')->insert($another);
            if(request()->file('another_img')){
                if($rs1 && $rs2){
                    // 提交事务
                    Db::commit();
                    $str = "修改成功";
                }
            }else{
                if($rs1){//无主图有附图
                    // 提交事务
                    Db::commit();
                    $str = "修改成功";
                }
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $str = $e->getMessage();
        }
        if($str){
            return redirect('company/index');
        }else{
            $this->error($str);
        }
    }
}
