<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/8/27
 * Time: 18:19
 */

namespace app\index\controller;


use think\Controller;

class Pow extends Controller
{
    //规则列表
    public function pow_list()
    {
        $a=db('pow')->where('is_delete',0)->select();
        $rows=$this->order($a);
        return view( 'Pow/index',['rows'=>$rows]);
    }

    //添加权限
    public function insert()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        $name=db('pow')->where('pow_name',$data['pow_name'])->where('is_delete',0)->count();
        if($name>0){
            $this->error('该权限名称已被使用');
        }
        if($data['parent_id']==0){
            $data['cj']=1;
        }else{
            $row=db('pow')->where('id',$data['parent_id'])->find();
            $data['cj']=$row['cj']+1;
        }
        if($data['cj']>=3){
            $data['state']='隐藏';
        }
        $start_time=time();//创建时间
        $data['start_time']=$start_time;
        array_shift($data);
        $r=db('pow')->insert($data);
        if($r){
            return redirect('Pow/pow_list');
        }else{
            $this->error('添加失败,请联系管理员');
        }
    }

    //删除权限
    public function del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $count=db('pow')->where('parent_id',$id)->where('is_delete',0)->count();
        if($count>0){
            $this->error('该规则内还有子级,不能删除');
        }
        $delete_time=time();
        $r=db('pow')->where('id',$id)->update(['is_delete'=>1,'delete_time'=>$delete_time]);
        if($r){
            return redirect('Pow/pow_list');
        }else{
            $this->error('删除失败,请联系超级管理员');
        }
    }


    //修改规则状态
    public function state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $state=db('pow')->where('id',$id)->find();
        if($state['cj']==3){
            $this->error('该规则不能显示');
        }
        if($state['state']=='正常'){
            db('pow')->where('id',$id)->update(['state'=>'隐藏']);
        }else{
            db('pow')->where('id',$id)->update(['state'=>'正常']);
        }
//        return redirect('Pow/pow_list');
        return redirect('Pow/pow_list');
    }


    //数据回显
    public function up_edit()
    {
        $id=$_POST['id'];
        $row=db('pow')->where('id',$id)->find();
        return $row;
    }
    //修改
    public function up()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        $count=db('pow')->where('pow_name',$data['pow_name'])->where("id!=$data[id]")->where('is_delete',0)->count();
        if($count>0){
            $this->error('规则名已存在');
        }
        $row=db('pow')->where('id',$data['parent_id'])->find();
        $data['cj']=$row['cj']+1;
        if($data['cj']==2){
            $data['state']=='隐藏';
        }
        array_shift($data);
        $r=db('pow')->update($data);
        if($r){
            return redirect('Pow/pow_list');
        }else{
            $this->error('修改失败');
        }
    }
}
