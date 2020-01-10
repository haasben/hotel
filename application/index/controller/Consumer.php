<?php
namespace app\index\controller;

use think\Controller;

class Consumer extends Controller
{
    //构造函数，判断数据状态（修改会员状态）
    public function _initialize()
    {
        $list = db('consumer')->where("is_del",0)->select();
        $nums = count($list);
        for($i=0;$i<$nums;$i++){
            if($list[$i]['expire_time'] < time() ){
                db("consumer")->where('id',$list[$i]['id'])->update(['leavel'=>0]);
            }else{
                continue;
            }
        }
    }
    //显示用户列表
    public function index()
    {
        $list=db('consumer')
            ->field('a.*,b.title')
            ->alias('a')
            ->join('consumer_member b','a.leavel = b.id','LEFT')
            ->where("a.is_del","0")
            ->paginate(8);
        $cate = db("consumer_member")->select();
        return view("index",["list"=>$list,"cate"=>$cate]);
    }
    //手动新增用户
    
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
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/users');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['header'] =  '/uploads/users/'.date("Ymd",time()).'/'.$info->getFilename();
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
            return redirect('consumer/index');
        }else{
            $this->error('添加失败');
        }
    }
    //软删除会员
    public function delete($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time = date("Y-m-d H:i:s",time());
        $rs = db("consumer")->where("id",$id)->update(["is_del"=>1,"delete_time"=>$time]);
        if($rs){
            return redirect('consumer/index');
        }else{
            $this->error('删除失败');
        }
    }
    //修改会员回显
    public function edit($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = db("consumer")->where("id",$id)->find();
        $cate = db("consumer_member")->select();
        return view("edit",["data"=>$data,"cate"=>$cate]);
    }
    //修改会员
    public function update($id){
        $row = db('consumer')->where('id',$id)->find();
        $data = input();
//        var_dump($data);
        $path = '/index/consumer/update/id/'.$id.'_html';
        unset($data[$path]);
        unset($data['id']);
//        var_dump($data);exit;
        //修改会员到期时间
        if(isset($data['opening'])){
            if($data['opening'] == "clear"){
                $data['opening_time'] = 0;
                $data['expire_time'] = 0;
            }else{
                if($row['expire_time'] < time() ){
                    $data['opening_time'] = time();
                    $data['expire_time'] = time()+$data['opening']*30*24*60*60;
                }else{
                    $data['expire_time'] = $row['expire_time']+$data['opening']*30*24*60*60;
                }
            }
            unset($data['opening']);
        }
//        echo $id;
//        var_dump($data);exit;
        if(request()->file('header')){
            // 获取表单上传文件
            $file = request()->file('header');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/users');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['header'] =  '/uploads/users/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        $data['update_time'] = date("Y-m-d H:i:s",time());
        $rs = db("consumer")->where("id",$id)->update($data);
        if($rs){
            return redirect('consumer/index');
        }else{
            $this->error('修改失败');
        }
    }
    //拉黑用户
    public function status($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = db("consumer")->where("id",$id)->find();
        if($data['status']==1){
            $rs = db("consumer")->where("id",$id)->update(['status'=>2]);
            if($rs){
                return redirect('consumer/index');
            }else{
                $this->error('拉黑失败');
            }
        }else{
            $rs = db("consumer")->where("id",$id)->update(['status'=>1]);
            if($rs){
                return redirect('consumer/index');
            }else{
                $this->error('回白名单失败');
            }
        }
    }
    //会员身份列表
    public function menber(){
        $list = db("consumer_member")->where('is_del',0)->paginate(10);
        return view("member",['list'=>$list]);
    }
    //添加会员身份
    public function memberinsert(){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = input();
        if(request()->file('icon')){
            // 获取表单上传文件
            $file = request()->file('icon');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/member');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['icon'] =  '/uploads/member/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
//        var_dump($data);
        unset($data["/index/consumer/memberinsert_html"]);
        $rs = db("consumer_member")->insert($data);
        if($rs){
            return redirect('consumer/menber');
        }else{
            $this->error('新增失败');
        }
    }
    //假删除会员身份
    public function memberdelete($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time = date("Y-m-d H:i:s",time());
        $rs = db("consumer_member")->where("id",$id)->update(["is_del"=>1,"delete_time"=>$time]);
        if($rs){
            return redirect('consumer/menber');
        }else{
            $this->error('删除失败');
        }
    }
    //修改会员身份回显
    public function memberedit($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data = db("consumer_member")->where("id",$id)->find();
        return view("memberedit",["data"=>$data]);
    }
    //修改会员身份
    public function memberupdate($id){
        $data = input();
//        var_dump($data);exit;
        $path = '/index/consumer/memberupdate/id/'.$id.'_html';
        unset($data[$path]);
        unset($data['id']);
//        echo $id;
//        var_dump($data);
        if(request()->file('icon')){
            // 获取表单上传文件
            $file = request()->file('icon');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/member');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['icon'] =  '/uploads/member/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        $data['update_time'] = date("Y-m-d H:i:s",time());
        $rs = db("consumer_member")->where("id",$id)->update($data);
        if($rs){
            return redirect('consumer/menber');
        }else{
            $this->error('修改失败');
        }
    }
}
