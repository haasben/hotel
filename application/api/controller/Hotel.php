<?php
/**
 * Created by PhpStorm.
 * User: 金戋
 * Date: 2019/9/6
 * Time: 16:45
 */

namespace app\api\controller;


use think\Controller;

class Hotel extends Controller
{
    public function index()
    {
        $row=db('companymsg')->where('weihu',1)->field('name,address,main_img')->find();
        $room=db('rooms_type')->where('is_del',0)->field('id,title,price,breakfast,area,nums')->select();
        foreach ($room as $k=>$r) {
            if($r['breakfast']==1){
                $room[$k]['breakfast']='含早';
            }else{
                $room[$k]['breakfast']='不含早';
            }
            if($r['nums']==1){
                $room[$k]['nums']='双床';
            }else{
                $room[$k]['nums']='单床';
            }
        }
        return ['row'=>$row,'room'=>$room];
    }
}