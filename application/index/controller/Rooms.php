<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Rooms extends Controller
{
    //显示房间列表
    public function index()
    {
        $list = db('rooms_type')->where("is_del", "0")->paginate(10);
//        var_dump($list);exit;
//        halt($list);
        $info = $list->toArray();
        foreach ($info['data'] as &$value) {
            $value['img_id'] = db('room_img')->where('is_del', 0)->where('room_type_id', $value['id'])->select();
            $value['roomscount'] = db('rooms')->where('type_id', $value['id'])->where('is_del', 0)->where('status', 0)->count();
        }
//        halt($info);
//        $info['data'] = $info['data']->toArray();
//        halt($info);
        return view("index", ["list" => $info['data'], 'page' => $list->render()]); // list 是数据 page是分页
    }

    //手动新增房型
    public function insert()
    {
        $ms = $this->qx();
        if ($ms == 0) {
            $this->error('警告：越权操作');
        }
        $data = input();
        unset($data['/index/rooms/insert_html']);
//        var_dump($data);exit;
        //酒店主图片上传
        if (request()->file('path')) {
            // 获取表单上传文件
            $file = request()->file('path');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if ($file) {
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if ($info) {
                    if (in_array($info->getExtension(), ["jpg", "jpeg", "png", "gif"])) {
                        $data['img'] = '/uploads/roomstype/' . date("Ymd", time()) . '/' . $info->getFilename();
                    } else {
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        if (request()->file('path2')) {
            Db::startTrans();
            try {
                //插入房间类型表
                $roomimg['room_type_id'] = db("rooms_type")->insertGetId($data);  //  获取刚添加得id=
                    // 获取表单上传文件
                $files = request()->file('path2');

                foreach ($files as $file) {
                    // 移动到框架应用根目录/public/uploads/ 目录下
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                    if ($info) {
                        if (in_array($info->getExtension(), ["jpg", "jpeg", "png", "gif"])) {
                            $roomimg['path'] = '/uploads/roomstype/' . date("Ymd", time()) . '/' . $info->getFilename();
                            //插入图片表
                            $rs2 = db('room_img')->insert($roomimg);
                        } else {
                            $this->error('图片上传失败，请检查图片格式！');
                        }
                    } else {
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }


                if ($roomimg['room_type_id'] && $rs2) {
                    // 提交事务
                    Db::commit();
                    $str = "添加成功";
                }
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $str = $e->getMessage();
            }
        } else {
            $rs = db("rooms_type")->insert($data);
            if ($rs) {
                $str = "添加成功";
            } else {
                $str = "添加失败";
            }
        }
        if ($str == "添加成功") {
            return redirect('rooms/index');
        } else {
            $this->error($str);
        }
    }

    //查看房型详情
    public function show($id)
    {
        $ms = $this->qx();
        if ($ms == 0) {
            $this->error('警告：越权操作');
        }
        $data = db("rooms_type")->where("id", $id)->find();
        $data['img_id'] = db('room_img')->where('is_del', 0)->where('room_type_id', $data['id'])->select();
//        var_dump($data);exit;
        return view("show", ["data" => $data]);
    }

    //软删除房型
    public function delete($id)
    {
        $ms = $this->qx();
        if ($ms == 0) {
            $this->error('警告：越权操作');
        }
        $time = time();
        $rs = db("rooms_type")->where("id", $id)->update(["is_del" => 1, "delete_time" => $time]);
        if ($rs) {
            return redirect('room/index');
        } else {
            $this->error('删除失败');
        }
    }

    //修改房型回显
    public function edit($id)
    {
        $ms = $this->qx();
        if ($ms == 0) {
            $this->error('警告：越权操作');
        }
        $data = db("rooms_type")->where("id", $id)->find();
        $data['img_id'] = db('room_img')->where('is_del', 0)->where('room_type_id', $data['id'])->select();
        return view("edit", ["data" => $data]);
    }

    //保存修改房型
    public function update($id)
    {
        $roomimg = [];
        $data = input();
//        var_dump($data);exit;
        $path = '/index/rooms/update/id/' . $id . '_html';
        unset($data[$path]);
        unset($data['id']);
//        var_dump($data);exit;
        //修改时间
        $data['update_time'] = time();
        //酒店主图片上传
        if (request()->file('path')) {
            // 获取表单上传文件
            $file = request()->file('path');
            // 移动到框架应用根目录/public/uploads/ 目录下
            if ($file) {
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                if ($info) {
                    if (in_array($info->getExtension(), ["jpg", "jpeg", "png", "gif"])) {
                        $data['img'] = '/uploads/roomstype/' . date("Ymd", time()) . '/' . $info->getFilename();
                    } else {
                        $this->error('图片上传失败，请检查图片格式！');
                    }
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        }
        if (request()->file('path2')) {
            Db::startTrans();
            try {
                if (request()->file('path2')) {
                    $roomimg['room_type_id'] = $id;
                    // 获取表单上传文件
                    $files = request()->file('path2');

                    foreach ($files as $file) {
                        // 移动到框架应用根目录/public/uploads/ 目录下
                        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/roomstype');
                        if ($info) {
                            if (in_array($info->getExtension(), ["jpg", "jpeg", "png", "gif"])) {
                                $roomimg['path'] = '/uploads/roomstype/' . date("Ymd", time()) . '/' . $info->getFilename();
                                $rs2 = db("room_img")->insert($roomimg);
                            } else {
                                $this->error('图片上传失败，请检查图片格式！');
                            }
                        } else {
                            // 上传失败获取错误信息
                            echo $file->getError();
                        }
                    }
                }
                //更新房间类型表
                $rs1 = db("rooms_type")->where('id', $id)->update($data);

                if ($rs1 && $rs2) {
                    // 提交事务
                    Db::commit();
                    $str = "添加成功";
                }
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $str = $e->getMessage();
            }
        } else {
            $rs = db("rooms_type")->where('id', $id)->update($data);
            if ($rs) {
                $str = "添加成功";
            } else {
                $str = "";
            }
        }
        if ($str) {
            return redirect('rooms/index');
        } else {
            $this->error($str);
        }
    }
}