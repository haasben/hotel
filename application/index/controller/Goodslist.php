<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Goodslist extends Controller
{
    //显示商品列表
    public function index()
    {
        echo date('Y-m-d H:i:s',time());
        $list = db('goods_list')
            ->where("is_delete","0")
            ->order('state asc')
            ->order('sort desc')
            ->paginate(10);
        $row=db('goods_class')
            ->where("is_delete","0")
            ->select();
        foreach($row as $key=>$val){
            $s[$val['id']]=$val['name'];
        }
        return view("index",["list"=>$list,'row'=>$row,'s'=>$s]);
    }
    // 添加商品
    public function goods_add(){
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
        if(!$data['price']){
            $this->error('请添加价格');
        }
        if(isset( $data['goods_sort_id'])){
            $data['goods_sort_id']=implode(',',$data['goods_sort_id']);
        }
        $data['state']=0;
        $data['create_time']=time();
        unset($data['/index/goodslist/goods_add_html']);
        $data['pic'] =  '/uploads/goodslist/'.date("Ymd",time()).'/';
        if(request()->file('pic')){
            // 获取表单上传文件
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/goodslist');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['pic'] =  '/uploads/goodslist/'.date("Ymd",time()).'/'.$info->getFilename();
                    }else{
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        $rs = db("goods_list")->insert($data);
        if($rs){
            return redirect('goodslist/index');
        }else{
            $this->error('添加失败');
        }
    }
    // 修改商品
    public function goods_update($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $res=db('goods_list')->where('id',$id)->select();
        $data = input();
        unset($data['/index/goodslist/goods_update_html']);
        $data['update_time']=time();
        if(isset($data['goods_sort_id'])){
            $data['goods_sort_id']=implode(',',$data['goods_sort_id']);
        }
        if(request()->file('pic')){
            // 获取表单上传文件
            $file = request()->file('pic');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/goodslist');
                if($info){
                    if(in_array($info->getExtension(),["jpg","jpeg","png","gif"])){
                        $data['pic'] =  '/uploads/goodslist/'.date("Ymd",time()).'/'.$info->getFilename();
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
        $r=db('goods_list')->where('id',$id)->update($data);
        if($r){
            return redirect('goodslist/index');
        }else{
            $this->error('修改失败,请联系管理员');
        }
        
    }
    // 修改商品回显
    public function goods_edit(){
        $id=input('id');
        $row=db('goods_list')->where('id',$id)->find();
        return $row;
    }
    // 商品状态
    public function goods_state($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('goods_list')->where('id',$id)->find();
        if($row['state']==0){
            $r=db('goods_list')->where('id',$id)->update(['state'=>1]);
        }else{
            $r=db('goods_list')->where('id',$id)->update(['state'=>0]);
        }
        if($r){
            return redirect('goodslist/index');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //商品分类回显
    public function goods_sort()
    {
        $id=input('id');
        $row=db('goods_list')->where('id',$id)->find();
        $sz=explode(',',$row['goods_sort_id']);
        $sort=db('goods_class')->where('is_delete',0)->field('name,id')->select();
        return view('goodslist/goods_so_up',['row'=>$row,'sort'=>$sort,'id'=>$id,'sz'=>$sz]);
    }
    // 商品分类添加
    public function goods_sort_add(){
        $data=input();
        $da=implode(",",$data['check_all']);
        $r=db('goods_list')->where('id',$data['id'])->update(['goods_sort_id'=>$da]);
        if ($r){
            $msg=["error"=>1,'ts'=>"分类成功"];
        }else{
            $msg=["error"=>101,'ts'=>'分类失败,请联系管理员'];
        }
        return $msg;
    }
    // 商品删除
    public function goods_del($id){
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $delete_time=time();
        $r=db('goods_list')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$delete_time]);
        if($r){
            return redirect('goodslist/index');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
}
