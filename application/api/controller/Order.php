<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/9/7
 * Time: 14:37
 */

namespace app\api\controller;


use think\Controller;
use think\session\driver\Redis;

class Order extends Controller
{
    //餐厅接口
    public function index()
    {
        $row=db('restaurant')->where('is_delete',0)->where('state',0)->field('id,name')->select();
        return $row;
    }
    //进入餐厅
    public function home()
    {
        $id=input('restaurant');//餐厅
        $table_number=input('table_number');//桌号
        $row=db('restaurant')->where('id',$id)->find();
        if($row){
            if($row['state']==1){
                $message=['error'=>101,'msg'=>'餐厅已停止营业'];
                return $message;
            }
            $food_sort=db('food_sort')->where('is_delete',0)->where('state',0)->field('name,id')->select();
            $food_id=explode(',',$row['foot_id']);
            $food=db('food')->where('state',0)->where('is_delete',0)->field('name,money,img,id,content')->select();
            $md=[];
            foreach ($food as $f) {
                foreach ($food_id as $f_id) {
                    if($f['id']==$f_id){
                        $md[]=$f;
                    }
                }
            }
            foreach ($md as $k=>$item) {
                $md[$k]['img']='http://crm.cdqifa.cn:66'.$md[$k]['img'];
            }
            return ['restaurant'=>$row['name'],'food_sort'=>$food_sort,'md'=>$md];
        }else{
            return ['error'=>102,'msg'=>'非法访问'];
        }
    }

    public function order_dc()
    {
        $key=input('key');
        $food_id=input('id');
        $r=new \Redis();
        $r->connect('127.0.0.1');
        $openid=$r->get($key);
        $count=db('order_dc')->where('openid',$openid)->where('food_id',$food_id)->find();
        if(!$count){
            db('order_dc')->insert(['openid'=>$openid,'food_id'=>$food_id,'food_number'=>1]);
        }else{
            db('order_dc')->where('openid',$openid)->where('food_id',$food_id)->update(['food_number'=>$count['food_number']+1]);
        }
        $rows=db('order_dc')
            ->where('order_dc.openid',$openid)
            ->join('food','order_dc.food_id=food.id')
            ->field('food.name,food.money,order_dc.food_money,order_dc.food_number')
            ->select();
        foreach ($rows as $k=>$row) {
            $rows[$k]['food_money']=$row['money']*$row['food_number'];
        }
        $money='';
        $count='';
        $f=[];
        $da=[];
        foreach ($rows as $r=>$o) {
            $money+=$o['food_money'];
            $count+=$o['food_number'];
            $rows['money']=$money;
            $rows['count']=$count;
            unset($rows[$r]['food_money']);
            $f[$r]=$o;
            $da['array']=$f;
            $da['money']=$money;
            $da['count']=$count;
        }
        return $da;
    }

    public function order_fc()
    {
        $key=input('key');
        $food_id=input('id');
        $r=new \Redis();
        $r->connect('127.0.0.1');
        $openid=$r->get($key);
        $count=db('order_dc')->where('openid',$openid)->where('food_id',$food_id)->find();
        if($count){
            if($count['food_number']==1){
                db('order_dc')->where('openid',$openid)->where('food_id',$food_id)->update(['food_number'=>$count['food_number']-1]);
                db('order_dc')->where('openid',$openid)->where('food_id',$food_id)->delete();
            }else{
                db('order_dc')->where('openid',$openid)->where('food_id',$food_id)->update(['food_number'=>$count['food_number']-1]);
            }
        }
        $rows=db('order_dc')
            ->where('order_dc.openid',$openid)
            ->join('food','order_dc.food_id=food.id')
            ->field('food.name,food.money,order_dc.food_money,order_dc.food_number')
            ->select();
        foreach ($rows as $k=>$row) {
            $rows[$k]['food_money']=$row['money']*$row['food_number'];
        }
        $money='';
        $count='';
        $f=[];
        $da=[];
        foreach ($rows as $r=>$o) {
            $money+=$o['food_money'];
            $count+=$o['food_number'];
            $rows['money']=$money;
            $rows['count']=$count;
            unset($rows[$r]['food_money']);
            $f[$r]=$o;
            $da['array']=$f;
            $da['money']=$money;
            $da['count']=$count;
        }
        return $da;
    }
}