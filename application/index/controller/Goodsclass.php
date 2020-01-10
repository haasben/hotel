<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Goodsclass extends Controller
{
    //显示分类列表
    public function index()
    {
        $row=db('goods_class')->where('is_delete',0)->order('state asc')->order('sort desc')->paginate(10);
        return view('goodsclass/index',['row'=>$row]);
    }
    // 添加分类
    public function goods_sort_add(){
        {
            $ms=$this->qx();
            if($ms==0){
                $this->error('警告：越权操作');
            }
            $data = input();
            if(!$_FILES['pic']['name']){
                $this->error('请添加图片');
            }
            if(!$data['name']){
                $this->error('请添加名字');
            }
            unset($data['/index/goodsclass/goods_sort_add_html']);
            $name=db('goods_class')->where('name',$data['name'])->where('is_delete',0)->count();
            if($name>0){
                $this->error('该分类名称已被使用');
            }
            $start_time=time();
            $data['create_time']=$start_time;
            if(request()->file('pic')){
                // 获取表单上传文件
                $file = request()->file('pic');
                // 移动到框架应用根目录/public/uploads/ 目录下
                if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/goodsclass');
                    if($info){
                        if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                            $data['pic'] =  '/uploads/goodsclass/'.date("Ymd",time()).'/'.$info->getFilename();
                        }else{
                            $this->error('图片上传失败，请检查图片格式！');
                        }
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            $r=db('goods_class')->insert($data);
            if($r){
                return redirect('goodsclass/index');
            }else{
                $this->error('添加失败,请联系管理员');
            }
            
        }
    }
    // 修改分类
    public function goods_sort_update($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        $data['update_time']=time();
        $res=db('goods_class')->where('id',$id)->select();
        if(request()->file('pic')){
            // 获取表单上传文件
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/goodsclass');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['pic'] =  '/uploads/goodsclass/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
                // 删除原图片
                if(strstr($res['0']['pic'],'.') && !empty($res['0']['pic'])){
                    if(!unlink(".".$res['0']['pic'])){
                        $this->error('图片修改 失败,请联系管理员');
                    }
                }
            }
        }
        $r=db('goods_class')->update($data);
        if($r){
            return redirect('goodsclass/index');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
    // 修改分类回显
    public function goods_sort_edit()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $id=input('id');
        $row=db('goods_class')->where('id',$id)->find();
        return $row;
    }
    // 修改分类状态
    public function goods_sort_state($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('goods_class')->where('id',$id)->find();
        if($row['state']==0){
            $r=db('goods_class')->where('id',$id)->update(['state'=>1]);
        }else{
            $r=db('goods_class')->where('id',$id)->update(['state'=>0]);
        }
        if($r){
            return redirect('goodsclass/index');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    // 软删除分类
    public function goods_sort_del($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $delete_time=time();
        $r=db('goods_class')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$delete_time]);
        if($r){
            return redirect('goodsclass/index');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    
}
