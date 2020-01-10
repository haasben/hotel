<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/9/4
 * Time: 17:14
 */

namespace app\index\controller;



class Order extends \think\Controller
{
    //餐厅管理
    public function restaurant()
    {
        $row=db('restaurant')->where('is_delete',0)->order('state asc')->order('sort desc')->select();
        return view('Order/restaurant',['row'=>$row]);
    }
    //添加餐厅
    public function restaurant_add()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        $data['start_time']=time();
        $r=db('restaurant')->insert($data);
        if($r){
            return redirect('Order/restaurant');
        }else{
            $this->error('添加失败,请联系管理员');
        }
    }
    //删除餐厅
    public function restaurant_del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $delete_time=time();
        $r=db('restaurant')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$delete_time]);
        if($r){
            return redirect('Order/restaurant');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    //修改餐厅状态
    public function restaurant_state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('restaurant')->where('id',$id)->find();
        if($row['state']==0){
            $r=db('restaurant')->where('id',$id)->update(['state'=>1]);
        }else{
            $r=db('restaurant')->where('id',$id)->update(['state'=>0]);
        }
        if($r){
            return redirect('Order/restaurant');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //修改餐厅回显
    public function restaurant_edit()
    {
        $id=input('id');
        $row=db('restaurant')->where('id',$id)->find();
        return $row;
    }
    //修改餐厅
    public function restaurant_update()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        $data['update_time']=time();
        $r=db('restaurant')->update($data);
        if($r){
            return redirect('Order/restaurant');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
    //添加餐厅菜品视图
    public function restaurant_food($id)
    {
        $row=db('restaurant')->where('id',$id)->find();
        $food=db('food')->where('is_delete',0)->select();
        $sz=explode(',',$row['foot_id']);
        return view('Order/restaurant_food',['row'=>$row,'food'=>$food,'id'=>$id,'sz'=>$sz]);
    }
    //添加餐厅菜品
    public function restaurant_food_add()
    {
        $data=input();
        $da=implode(",",$data['check_all']);
        $r=db('restaurant')->where('id',$data['id'])->update(['foot_id'=>$da]);
        if ($r){
            $msg=["error"=>1,'ts'=>"添加成功"];
        }else{
            $msg=["error"=>101,'ts'=>'添加失败,请联系管理员'];
        }
        return $msg;
    }
    //餐厅菜品数据回显
    public function restaurant_select()
    {
        $md=[];
        $id=input('id');
        $row=db('restaurant')->where('id',$id)->find();
        $food_id=explode(',',$row['foot_id']);
        $foods=db('food')->where('is_delete',0)->select();
        foreach ($foods as $f) {
            foreach ($food_id as $s) {
                if($s==$f['id']){
                    $md[]=$f;
                }
            }
        }
        return ['row'=>$row,'md'=>$md];
    }


    //桌号管理
    public function table_number_one()
    {
        $restaurant_id=input('restaurant_id') ? input('restaurant_id') : 0;
        if($restaurant_id==0){
            $row=db('table_number')
                ->where('table_number.is_delete',0)
                ->join('restaurant','table_number.restaurant_id=restaurant.id')
                ->field('table_number.*,restaurant.name as re_name')
                ->order('table_number.state asc')
                ->order('table_number.sort desc')
                ->paginate(10,false,['query'=>['restaurant_id'=>$restaurant_id]]);
            $restaurant=db('restaurant')->where('is_delete',0)->field('id,name')->select();
            return view('Order/table_number',['row'=>$row,'restaurant'=>$restaurant,'restaurant_id'=>$restaurant_id]);
        }else{
            $row=db('table_number')
                ->where('table_number.is_delete',0)
                ->join('restaurant','table_number.restaurant_id=restaurant.id')
                ->field('table_number.*,restaurant.name as re_name')
                ->order('table_number.state asc')
                ->order('table_number.sort desc')
                ->where('table_number.restaurant_id',$restaurant_id)
                ->paginate(10,false,['query'=>['restaurant_id'=>$restaurant_id]]);
            $restaurant=db('restaurant')->where('is_delete',0)->field('id,name')->select();
            return view('Order/table_number',['row'=>$row,'restaurant'=>$restaurant,'restaurant_id'=>$restaurant_id]);
        }
    }
    //添加桌号
    public function table_number_add()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        if($data['restaurant_id']==0){
            $this->error('请选择所属餐厅');
        }
        $data['start_time']=time();
        $r=db('table_number')->insert($data);
        if($r){
            return redirect('Order/table_number_one');
        }else{
            $this->error('添加桌号失败,请联系管理员');
        }
    }
    //删除桌号
    public function table_number_del($id)
    {
        $restaurant_id=input('restaurant_id');
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $time=time();
        $r=db('table_number')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$time]);
        if($r){
            return redirect('Order/table_number_one?restaurant_id='.$restaurant_id);
        }else{
            $this->error('删除桌号失败,请联系管理员');
        }
    }
    //修改桌号状态
    public function table_number_state($id)
    {
        $restaurant_id=input('restaurant_id');
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('table_number')->where('id',$id)->find();
        if($row['state']==0){
            $r=db('table_number')->where('id',$id)->update(['state'=>1]);
        }else{
            $r=db('table_number')->where('id',$id)->update(['state'=>0]);
        }
        if($r){
            return redirect('Order/table_number_one?restaurant_id='.$restaurant_id);
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //修改桌号回显
    public function table_number_edit()
    {
        $id=input('id');
        $row=db('table_number')->where('id',$id)->find();
        return $row;
    }
    //修改桌号
    public function table_number_update()
    {
        $restaurant_id=input('re_id');
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        $data['update_time']=time();
        unset($data['re_id']);
        $r=db('table_number')->update($data);
        if($r){
            return redirect('Order/table_number_one?restaurant_id='.$restaurant_id);
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
    

    //菜品分类
    public function food_sort()
    {
        $row=db('food_sort')->where('is_delete',0)->order('state asc')->order('sort desc')->select();
        return view('Order/food_sort',['row'=>$row]);
    }
    //添加菜品分类
    public function food_sort_add()
    {
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
        $r=db('food_sort')->insert($data);
        if($r){
            return redirect('Order/food_sort');
        }else{
            $this->error('添加菜品分类失败,请联系管理员');
        }
    }
    //删除菜品分类
    public function food_sort_del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $delete_time=time();
        $r=db('food_sort')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$delete_time]);
        if($r){
            return redirect('Order/food_sort');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    //修改菜品分类状态
    public function food_sort_state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('food_sort')->where('id',$id)->find();
        if($row['state']==0){
            $rows=db('food')->where('is_delete',0)->where('state',0)->select();
            foreach ($rows as $r) {
                $sort_id=explode(',',$r['food_sort_id']);
                foreach ($sort_id as $i) {
                    if($i==$row['id']){
                        db('food')->where('id',$r['id'])->update(['state'=>1]);
                    }
                }
            }
            $r=db('food_sort')->where('id',$id)->update(['state'=>1]);
        }else{
            $rows=db('food')->where('is_delete',0)->where('state',1)->select();
            foreach ($rows as $r) {
                $sort_id=explode(',',$r['food_sort_id']);
                foreach ($sort_id as $i) {
                    if($i==$row['id']){
                        db('food')->where('id',$r['id'])->update(['state'=>0]);
                    }
                }
            }
            $r=db('food_sort')->where('id',$id)->update(['state'=>0]);
        }
        if($r){
            return redirect('Order/food_sort');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //修改菜品分类回显
    public function food_sort_edit()
    {
        $id=input('id');
        $row=db('food_sort')->where('id',$id)->find();
        return $row;
    }
    //修改菜品分类
    public function food_sort_update()
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
            $r=db('food_sort')->update($data);
        }else{
            $data['update_time']=time();
            $r=db('food_sort')->update($data);
        }
        if($r){
            return redirect('Order/food_sort');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }


    //菜品管理
    public function food()
    {
        $row=db('food')
            ->where('is_delete',0)
            ->order('state asc')
            ->order('sort desc')
            ->paginate(10);
        return view('Order/food',['row'=>$row]);
    }
    //添加菜品
    public function food_add()
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
        $r=db('food')->insert($data);
        if($r){
            return redirect('Order/food');
        }else{
            $this->error('添加失败,请联系管理员');
        }
    }
    //删除菜品
    public function food_del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $delete_time=time();
        $r=db('food')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$delete_time]);
        if($r){
            return redirect('Order/food');
        }else{
            $this->error('删除失败,请联系管理员');
        }
    }
    //修改菜品状态
    public function food_state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('food')->where('id',$id)->find();
        if($row['state']==0){
            $r=db('food')->where('id',$id)->update(['state'=>1]);
        }else{
            $r=db('food')->where('id',$id)->update(['state'=>0]);
        }
        if($r){
            return redirect('Order/food');
        }else{
            $this->error('修改状态失败,请联系管理员');
        }
    }
    //修改菜品分类回显
    public function food_edit()
    {
        $id=input('id');
        $row=db('food')->where('id',$id)->find();
        return $row;
    }
    //修改菜品分类
    public function food_update()
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
            $r=db('food')->update($data);
        }else{
            $data['update_time']=time();
            $r=db('food')->update($data);
        }
        if($r){
            return redirect('Order/food');
        }else{
            $this->error('修改失败,请联系管理员');
        }
    }
    //菜品分类回显
    public function food_sort_up()
    {
        $id=input('id');
        $row=db('food')->where('id',$id)->find();
        $sz=explode(',',$row['food_sort_id']);
        $sort=db('food_sort')->where('is_delete',0)->field('name,id')->select();
        return view('Order/food_so_up',['row'=>$row,'sort'=>$sort,'id'=>$id,'sz'=>$sz]);
    }
    //添加菜品分类
    public function food_food_sort_add()
    {
        $data=input();
        $da=implode(",",$data['check_all']);
        $r=db('food')->where('id',$data['id'])->update(['food_sort_id'=>$da]);
        if ($r){
            $msg=["error"=>1,'ts'=>"分类成功"];
        }else{
            $msg=["error"=>101,'ts'=>'分类失败,请联系管理员'];
        }
        return $msg;
    }
}