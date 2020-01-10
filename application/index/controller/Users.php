<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/8/30
 * Time: 15:40
 */

namespace app\index\controller;


use think\Controller;
use think\Session;

class Users extends Controller
{
    //列表
    public function users_list()
    {
        $power=db('power')->where('is_delete',0)->select();
        $rows=db('users')
            ->where('users.is_delete',0)
            ->join('power','users.role_id=power.id')
            ->field('users.*,power.name as name')
            ->paginate(10);
        return view('Users/list',['rows'=>$rows,'power'=>$power]);
    }
    //添加管理员
    public function insert()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        $row=db('users')->where('username',$data['username'])->where('is_delete',0)->count();
        if($row>0){
            $this->error('用户名已被使用,一旦确定不可更改');
        }elseif($data['password']!=$data['pwd2']){
            $this->error('密码不一致');
        }elseif($data['role_id']==0){
            $this->error('请选择管理员的角色');
        }
        unset($data['pwd2']);
        $data['password']=md5($data['password']);
        $data['start_time']=time();
        $r=db('users')->insert($data);
        if($r){
            $this->success('添加管理员成功');
        }else{
            $this->error('添加管理员失败,请联系工作人员');
        }
    }
    //软删除管理员
    public function del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $r=db('users')->where('id',$id)->update(['is_delete'=>1]);
        if($r){
            $this->success('删除成功');
        }else{
            $this->error('删除失败,请联系工作人员');
        }
    }
    //修改状态
    public function state($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $row=db('users')->where('id',$id)->find();
        if ($row['state']=='使用中'){
            $r=db('users')->where('id',$id)->update(['state'=>'禁用']);
        }else{
            $r=db('users')->where('id',$id)->update(['state'=>'使用中']);
        }
        if($r){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }

    //修改视图回显
    public function edit()
    {
        $id=input('id');
        $row=db('users')->where('id',$id)->find();
        return $row;
    }
    //修改
    public function update()
    {
        $data=input();
        $pwd=md5($data['pwd']);
        $row=db('users')->where('id',$data['id'])->where('password',$pwd)->count();
        if ($row==0){
            $this->error('原密码错误');
        }
        array_shift($data);
        if($data['pwd2']!=$data['pwd3']){
            $this->error('两次密码不一致');
        }
        $data['password']=md5($data['pwd2']);
        unset($data['pwd'],$data['pwd2'],$data['pwd3']);
        $r=db('users')->where('id',$data['id'])->update($data);
        if ($r){
            Session::delete('users');
            $this->success('修改成功，请重新登录','Login/login');
        }else{
            $this->error('修改失败，请联系管理员');
        }
    }
    //编辑管理员角色回显
    public function role_js()
    {
        $id=$_POST['id'];
        $row=db('users')->where('id',$id)->find();
        return $row;
    }
    //修改管理员角色
    public function role_up()
    {
        $data=input();
        array_shift($data);
        $r=db('users')->update($data);
        if ($r){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }
}