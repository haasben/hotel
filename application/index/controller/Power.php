<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/8/27
 * Time: 16:38
 */

namespace app\index\controller;


use think\Controller;

class Power extends Controller
{
    public static $md=[];
    //角色列表
    public function add()
    {
        $cate=db('power')->where('is_delete',0)->paginate(10);
        return view('Power/add',['cate'=>$cate]);
    }
    //新增角色
    public function insert()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        $name=db('power')->where('is_delete',0)->where('name',$data['name'])->count();
        if($name>0){
            $this->error('角色名称已存在');
        }
        $state_time=time();
        $data['state_time']=$state_time;
        array_shift($data);
        $r=db('power')->insert($data);
        if($r){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }
    //添加权限视图
    public function pow($id)
    {
        $i=db('power')->where('id',$id)->find();
        if($i['name']=='超级管理员'){
            $this->error('超级管理员拥有全部权限');
        }
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $rows = db('pow_power')->where('power_id', $id)->find();
        $sz = explode(",", $rows['pow_id']);
        $this->read(0);
        $md = self::$md;
        return view('Power/pow', ['md' => $md, 'id' => $id, 'sz' => $sz]);
    }

    //找子级
    public function read($pid)
    {
		$res = db('pow')->where('is_delete',0)->where('parent_id',$pid)->select();
		$data = array();
		foreach($res as $k => $v){
			$res2 = db('pow')->where('is_delete',0)->where('parent_id',$v['id'])->select();
			$data2 = array();
			foreach($res2 as $k2 => $v2){
				$res3 = db('pow')->where('is_delete',0)->where('parent_id',$v2['id'])->select();
				$data3 = array();
				foreach($res3 as $k3 => $v3){
					$data3[$k3] = $v3;
				}
				$data2[$k2] = $v2;
				$data2[$k2]['child'] = $data3;
			}
			$data[$k] = $v;
			$data[$k]['child'] = $data2;
		}
		$this->assign('menu',$data);
		self::$md=$data;
    }

    //添加权限
    public function edit()
    {
        $ms=$this->qx();
        if($ms==0){
            $msg=["error"=>101,'ts'=>'警告：越权操作'];
            return $msg;
        }
        $data=input();
        $id=$data['id'];
        array_shift($data);
        $da=implode(",",$data['obj']);
        //有数据就修改,没有则添加
        $d=db('pow_power')->where('power_id',$id)->count();
        if ($d>0){
            $r=db('pow_power')->where('power_id',$id)->update(['pow_id'=>$da]);
        }else{
            $r=db('pow_power')->insert(['pow_id'=>$da,'power_id'=>$id]);
        }
        if ($r){
            $msg=["error"=>1,'ts'=>"授权成功"];
        }else{
            $msg=["error"=>101,'ts'=>'授权失败'];
        }
        return $msg;
    }

    //删除角色
    public function del($id)
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $i=db('power')->where('id',$id)->find();
        if($i['name']=='超级管理员'){
            $this->error('超级管理员无法删除');
        }
        $user=db('users')->where('role_id',$id)->count();
        if($user>0){
            $this->error('该角色下还有管理员,不能删除');
        }
        $r=db('power')->where('id',$id)->update(['is_delete'=>1]);
        if ($r){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    //查看
    public function select()
    {
        $id=$_POST['id'];
        $row=db('power')->where('id',$id)->find();
        return $row;
    }
    //修改回显
    public function power_edit()
    {
        $id=$_POST['id'];
        $row=db('power')->where('id',$id)->find();
        return $row;
    }
    //修改角色
    public function update()
    {
        $ms=$this->qx();
        if($ms==0){
            $this->error('警告：越权操作');
        }
        $data=input();
        array_shift($data);
        $name=db('power')->where('name',$data['name'])->count();
        if($name>0){
            $this->error('角色名称已存在');
        }
        $r=db('power')->update($data);
        if($r){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }
}
