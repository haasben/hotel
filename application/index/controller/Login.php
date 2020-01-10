<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/8/27
 * Time: 16:18
 */

namespace app\index\controller;


use think\Controller;
use think\Session;

class Login extends Controller
{
    //登录界面
    public function login()
    {
        return view('Index/login');
    }
    //登录验证
    public function proving()
    {
        $data=input();
        $pwd=md5($data['password']);
        $row=db('users')
            ->where('is_delete',0)
            ->where('username',$data['username'])
            ->where('password',$pwd)
            ->find();
        if ($row['state']=='禁用'){
            $this->error('该账号已被禁用，请联系管理员');
        }elseif($row){
            Session::set('users',$row);
            $cate=db('power')
                ->where('power.id',$row['role_id'])
                ->join('pow_power','power.id=pow_power.power_id')
                ->field('pow_power.pow_id')
                ->find();
            Session::set('qx',$cate);
            $this->success('登录成功','Index/home');
        }else{
            $this->error('登录失败,用户名或密码错误');
        }
    }
}