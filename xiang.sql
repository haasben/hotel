# Host: 127.0.0.1  (Version: 5.5.53)
# Date: 2020-01-10 14:26:17
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "comment"
#

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT '用户openID11111',
  `type_id` int(10) unsigned NOT NULL COMMENT '房型id',
  `content` varchar(255) NOT NULL COMMENT '评论内容',
  `comment_img` text COMMENT '评论图片',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '评论时间',
  `settop` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶：0-不置顶；1-置顶；',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '评论状态：0-显示；1-隐藏',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除：0-没删除；1-删除；',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "comment"
#

/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,'1',1,'1','1','2019-09-05 16:25:45',0,0,0,1567671945,1567666427),(2,'userstest',1,'住好点','/uploads/comment/20190905/152327ba9a39457c200c54db8876883e.jpg','2019-09-07 17:51:48',0,0,0,1567849908,NULL),(3,'',0,'',NULL,'2019-09-07 18:55:01',0,0,0,1567853701,NULL),(4,'公布的非官',2,'马上住','/uploads/comment/20190907/63ab56304e7f081e34959bebb774243f.jpg','2019-09-07 18:13:45',0,0,0,NULL,NULL),(5,'说过的时光',1,'有点东西',NULL,'2019-09-07 18:54:59',0,0,0,1567853699,NULL),(6,'公布的非官',4,'改变和想法后才发现',NULL,'2019-09-07 19:02:23',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

#
# Structure for table "companyimg"
#

DROP TABLE IF EXISTS `companyimg`;
CREATE TABLE `companyimg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_path` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "companyimg"
#

/*!40000 ALTER TABLE `companyimg` DISABLE KEYS */;
INSERT INTO `companyimg` VALUES (1,'/uploads/roomstype/20190902/98ef4c094eaa6890648d2704ab0ed5b5.jpg','2019-09-05 10:18:30',NULL,NULL),(3,'/uploads/hotel/20190906/15b2669c7163e4133643333237d64f80.jpg','2019-09-06 10:20:27',NULL,NULL);
/*!40000 ALTER TABLE `companyimg` ENABLE KEYS */;

#
# Structure for table "companymsg"
#

DROP TABLE IF EXISTS `companymsg`;
CREATE TABLE `companymsg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '酒店',
  `name` varchar(50) NOT NULL COMMENT '酒店名称',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT '经度',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT '纬度',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `main_img` varchar(255) DEFAULT NULL COMMENT '酒店首图',
  `weihu` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '维护：0-开放；1-维护',
  `tel` varchar(255) DEFAULT NULL COMMENT '联系方式',
  `zhuce_time` int(10) unsigned NOT NULL COMMENT '公司注册时间',
  `content` text COMMENT '酒店详情',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "companymsg"
#

/*!40000 ALTER TABLE `companymsg` DISABLE KEYS */;
INSERT INTO `companymsg` VALUES (1,'1111',1.0000000,1.0000000,'1','/uploads/roomstype/20190902/98ef4c094eaa6890648d2704ab0ed5b5.jpg',1,'11111',1568822400,'<p>gsfhdjhfggggggg<strong>ggggggggggg</strong><span style=\"background-color: rgb(255, 204, 153);\"><strong>ggggggggggg</strong><span style=\"color: rgb(255, 153, 0);\"><strong>gg</strong></span></span><span style=\"color: rgb(255, 153, 0);\"><strong>gggggggggggggggg</strong>gggggg</span></p>','2019-09-07 14:34:39',1567655786,NULL);
/*!40000 ALTER TABLE `companymsg` ENABLE KEYS */;

#
# Structure for table "consumer"
#

DROP TABLE IF EXISTS `consumer`;
CREATE TABLE `consumer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `openid` varchar(100) NOT NULL COMMENT 'openid',
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `header` varchar(255) DEFAULT NULL COMMENT '头像',
  `tel` char(11) DEFAULT NULL COMMENT '电话',
  `birthday` datetime DEFAULT NULL COMMENT '出生日期',
  `leavel` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0:普通用户；其他:会员标题',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:正常；2:拉黑',
  `storno` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '排序号',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 0——未删除；1——已删除 ',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `opening_time` int(11) unsigned DEFAULT NULL COMMENT '会员开通时间',
  `expire_time` int(11) unsigned DEFAULT NULL COMMENT '到期时间',
  `price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '消费总金额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "consumer"
#

/*!40000 ALTER TABLE `consumer` DISABLE KEYS */;
INSERT INTO `consumer` VALUES (2,'users2222','是个大范甘迪',NULL,'12345678901','1997-06-13 00:00:00',0,2,50,0,'2019-09-04 19:37:40','2019-09-02 15:30:50',NULL,NULL,NULL,0.00),(5,'userstest','adminuser','/uploads/users/20190829/b3c3b39d27b8613dfc15bfd999cc25e2.jpg','12345678987','2019-08-29 00:00:00',0,2,50,0,'2019-09-07 10:11:14','2019-09-07 10:11:14',NULL,0,0,0.00),(6,'公布的非官','说过的时光','/uploads/users/20190830/30afc09066a10c1eaaa82721a589495e.jpg','发的郭德纲','2019-08-07 00:00:00',0,1,50,0,'2019-08-30 12:24:02','2019-08-30 11:50:22',NULL,0,0,0.00),(20,'o_LEK4853SI-D8CXvtOrNX57I1D4','孜然','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eopcEkI9VoKdp3nB9yGFVlw7vHeKE9ibQzTYxeAlON58LTzBflhENghhaM8ccfgB9qibTTQPQMV5yibg/132',NULL,NULL,0,1,50,0,'2019-09-03 14:18:31',NULL,NULL,NULL,NULL,0.00);
/*!40000 ALTER TABLE `consumer` ENABLE KEYS */;

#
# Structure for table "consumer_member"
#

DROP TABLE IF EXISTS `consumer_member`;
CREATE TABLE `consumer_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '会员标题',
  `icon` varchar(255) DEFAULT NULL COMMENT '会员图样',
  `price` decimal(6,2) NOT NULL,
  `discount` tinyint(3) unsigned NOT NULL COMMENT '折扣——1-100之间',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `storno` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '排序号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "consumer_member"
#

/*!40000 ALTER TABLE `consumer_member` DISABLE KEYS */;
INSERT INTO `consumer_member` VALUES (2,'高级会员111',NULL,30.00,10,0,'2019-08-29 16:02:51','2019-08-29 16:02:51','2019-08-29 15:57:48',50),(3,'法国的风格','/uploads/member/20190830/16d42cb3380e458aef8dfc56486187cb.jpg',100.00,20,0,'2019-08-30 09:11:09','2019-08-30 09:11:09',NULL,50),(4,'超级会员111','/uploads/member/20190829/d28bf120a3673a4bc67965e4d8e87153.jpg',998.00,80,0,'2019-09-02 11:25:57','2019-08-30 20:00:52',NULL,50);
/*!40000 ALTER TABLE `consumer_member` ENABLE KEYS */;

#
# Structure for table "consumer_orders_member"
#

DROP TABLE IF EXISTS `consumer_orders_member`;
CREATE TABLE `consumer_orders_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_number` varchar(30) NOT NULL COMMENT '订单编号',
  `openid` varchar(100) CHARACTER SET big5 NOT NULL COMMENT '用户openid',
  `member_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `title` varchar(50) NOT NULL COMMENT '会员标题',
  `price` decimal(7,2) NOT NULL COMMENT '会员价格',
  `dates` int(10) unsigned NOT NULL COMMENT '开通期限',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态:0-已支付',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除：0-没删除；1-删除',
  `create_time` int(10) unsigned NOT NULL COMMENT '订单添加时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "consumer_orders_member"
#

/*!40000 ALTER TABLE `consumer_orders_member` DISABLE KEYS */;
INSERT INTO `consumer_orders_member` VALUES (1,'201908301529003778','users2222',2,'高级会员111',90.00,3,0,0,1567150140,NULL,1567152945);
/*!40000 ALTER TABLE `consumer_orders_member` ENABLE KEYS */;

#
# Structure for table "food"
#

DROP TABLE IF EXISTS `food`;
CREATE TABLE `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '菜品名',
  `sort` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '菜品图片',
  `content` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '菜品说明',
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '菜品单价',
  `discount` tinyint(4) DEFAULT '0' COMMENT '是否参与折扣,0:不参与,1:参与',
  `member_discount` tinyint(4) DEFAULT '0' COMMENT '是否参与会员折扣,0:不参与,1:参与',
  `stock` int(10) unsigned DEFAULT '0' COMMENT '库存',
  `food_sort_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '菜品分类id',
  `state` tinyint(4) DEFAULT NULL COMMENT '状态,0:售空,1:销售中',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "food"
#

INSERT INTO `food` VALUES (1,'红烧排骨1',50,'/uploads/roomstype/20190905/7d276b23c7af74316451b43de9547ef9.png','排骨它不香嗷?',100.00,0,0,199,'3',0,'1567675480','1567677446','1567676435',0);

#
# Structure for table "food_sort"
#

DROP TABLE IF EXISTS `food_sort`;
CREATE TABLE `food_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '分类名',
  `sort` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `state` tinyint(4) DEFAULT '0' COMMENT '状态  0:售空,1:销售中',
  `img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图标',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "food_sort"
#

INSERT INTO `food_sort` VALUES (3,'炸鸡',50,0,'/uploads/roomstype/20190904/e7bb2a00052a11ca341d7aa7d9ea093b.png','1567595767','1567667918','0',0),(4,'烤肉饭',20,0,'/uploads/roomstype/20190904/632efcda937a134ca2314ab8cb38c978.png','1567595903','1567667133','0',0),(5,'冒菜',5,0,'/uploads/roomstype/20190905/f1e16ae1b393d8d6122fb14804a59dcf.png','1567667145','0','0',0),(6,'面条',5,0,'/uploads/roomstype/20190905/89542687b44306fa17023349a538c525.png','1567667156','0','0',0);

#
# Structure for table "goods_class"
#

DROP TABLE IF EXISTS `goods_class`;
CREATE TABLE `goods_class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cj` int(11) NOT NULL,
  `parent_id` int(255) NOT NULL COMMENT '父级id',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `name` varchar(255) NOT NULL COMMENT '标题',
  `state` int(11) NOT NULL COMMENT '状态 0:显示1:影藏',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "goods_class"
#


#
# Structure for table "goods_list"
#

DROP TABLE IF EXISTS `goods_list`;
CREATE TABLE `goods_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `name` varchar(255) NOT NULL COMMENT '标题',
  `price` int(11) DEFAULT NULL COMMENT '价格',
  `discount` int(11) NOT NULL COMMENT '折扣  0:参与1:不参与',
  `member_discount` int(11) NOT NULL COMMENT '会员折扣 0:参与1:不参与',
  `distribution` int(11) NOT NULL COMMENT '分销 0:参与1:不参与',
  `pic` varchar(255) DEFAULT NULL COMMENT '图片',
  `stock` int(11) DEFAULT NULL COMMENT '库存',
  `goods_srot_id` varchar(255) NOT NULL COMMENT '类别',
  `state` int(11) DEFAULT NULL COMMENT '状态 0:销售中1:售空',
  `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_delete` int(11) NOT NULL COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "goods_list"
#


#
# Structure for table "home_navigation"
#

DROP TABLE IF EXISTS `home_navigation`;
CREATE TABLE `home_navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `one_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '一级标题',
  `two_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '二级标题',
  `sort` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标题',
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '链接',
  `state` tinyint(4) DEFAULT NULL COMMENT '状态  0正常,1禁用',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "home_navigation"
#

INSERT INTO `home_navigation` VALUES (3,'酒店','HOTEL',50,'/uploads/roomstype/20190904/2b66f82c7db40a99061ee69c15865ba6.png','/pages/hotel/index',0,'1567567818','1567577411','0',0),(11,'点餐','ORDER',40,'/uploads/roomstype/20190904/99d1bb234e565b937fd6a44cc7ea4d48.png','/pages/fine_food/index/index',0,'1567569323','1567577429','0',0),(12,'商城','STORE',30,'/uploads/roomstype/20190904/0627acc28ffc6d8815ee1be0449c7f06.png','/pages/shop/index/index',0,'1567569339','1567577439','0',0),(13,'旅游','TRAVEL',20,'/uploads/roomstype/20190904/c45fe69d931801fb12374377d55b76aa.png','/pages/tourism/tourism',0,'1567569359','1567577454','0',0),(15,'测试','测试',5,NULL,'5',1,'1567576905','0','0',0);

#
# Structure for table "hotel_orders"
#

DROP TABLE IF EXISTS `hotel_orders`;
CREATE TABLE `hotel_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `ordernum` varchar(255) NOT NULL COMMENT '订单编号',
  `openid` varchar(255) NOT NULL COMMENT '用户名',
  `header` varchar(255) DEFAULT NULL COMMENT '头像',
  `room_type` varchar(50) DEFAULT NULL COMMENT '房型',
  `room` varchar(50) DEFAULT NULL COMMENT '房间号',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '下单时间',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单价格',
  `pay_time` int(10) unsigned DEFAULT NULL COMMENT '支付时间',
  `intime` int(10) unsigned DEFAULT NULL COMMENT '入住时间',
  `out_time` int(10) unsigned DEFAULT NULL COMMENT '退房时间',
  `comment_id` int(10) unsigned DEFAULT NULL COMMENT '评论id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态：0-未支付；1-待入住；2-待评论；3-已评论；4-已关闭；',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除:0-未删除；1-已删除；',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '订单修改时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "hotel_orders"
#

/*!40000 ALTER TABLE `hotel_orders` DISABLE KEYS */;
INSERT INTO `hotel_orders` VALUES (1,'201909051819525595','说过的时光','/uploads/hotelorders/20190905/0a036dde6902688f560ce6d203a9b533.jpg','标准间',NULL,'2019-09-06 20:43:54',60.00,NULL,NULL,NULL,NULL,0,1,NULL,NULL),(2,'201909051823299839','adminuser','/uploads/hotelorders/20190905/106222f72057c438ea8d2b91155b9113.jpg','标准间','203','2019-09-07 17:43:03',60.00,1567837182,1567840106,1567840109,NULL,3,0,1567840109,NULL),(3,'201909051823445835','说过的时光','/uploads/hotelorders/20190905/ae37d4bba69c958f0c50246ee90db481.jpg','标准间','201','2019-09-07 18:51:22',60.00,1567837015,1567840112,1567840113,NULL,4,0,1567853482,NULL),(4,'201909071424383153','adminuser','/uploads/hotelorders/20190907/ade2ffe45963d18e025d78aa84ff6fb0.jpg','单人间','1011','2019-09-07 15:08:34',30.00,1567837481,1567840113,1567840114,NULL,3,0,1567840114,NULL),(5,'201909071821368486','公布的非官','/uploads/hotelorders/20190907/19f218468f4e1dacdec178aa4e311894.jpg','豪华间','1111','2019-09-07 19:02:23',30.00,1567851702,1567854135,1567854136,NULL,4,0,1567854143,NULL),(6,'201909071858177905','userstest','/uploads/hotelorders/20190907/cdd50668c5bf4a8f883abc5790ac998c.jpg','豪华间',NULL,'2019-09-07 18:58:19',30.00,1567853899,1567872000,NULL,NULL,1,0,1567853899,NULL);
/*!40000 ALTER TABLE `hotel_orders` ENABLE KEYS */;

#
# Structure for table "img"
#

DROP TABLE IF EXISTS `img`;
CREATE TABLE `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片',
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'url地址',
  `content` text COLLATE utf8_unicode_ci COMMENT '说明',
  `sort` int(11) DEFAULT '5' COMMENT '排序',
  `state` tinyint(3) unsigned DEFAULT NULL COMMENT '状态 0正常,1隐藏',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "img"
#

INSERT INTO `img` VALUES (1,'/uploads/roomstype/20190905/95386da056cea4f817d74586d5194b20.png','www.baidu.com','',5,0,'1567646944','0','0',0);

#
# Structure for table "order_dc"
#

DROP TABLE IF EXISTS `order_dc`;
CREATE TABLE `order_dc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL COMMENT 'openid',
  `food_id` int(11) DEFAULT NULL COMMENT '商品id',
  `food_money` decimal(10,2) DEFAULT NULL COMMENT '商品单价',
  `food_number` int(11) DEFAULT NULL COMMENT '商品数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

#
# Data for table "order_dc"
#

INSERT INTO `order_dc` VALUES (49,'o_LEK4853SI-D8CXvtOrNX57I1D4',1,NULL,1),(51,'o_LEK4853SI-D8CXvtOrNX57I1D4',2,NULL,2);

#
# Structure for table "platform"
#

DROP TABLE IF EXISTS `platform`;
CREATE TABLE `platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `platform_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '平台名称',
  `trem` tinyint(3) unsigned DEFAULT NULL COMMENT '订单自动关闭期限(天数)',
  `logo_img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '平台logo',
  `defend` tinyint(3) unsigned DEFAULT NULL COMMENT '平台维护开关',
  `appid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'appsecret',
  `record` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备案号',
  `cdn` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'cdn地址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "platform"
#

INSERT INTO `platform` VALUES (1,'2',255,'/uploads/roomstype/20190903/e7e91eaf52358d255708c05154bfbc3e.gif',2,'1313113123','11231','131132313','1232311');

#
# Structure for table "poster"
#

DROP TABLE IF EXISTS `poster`;
CREATE TABLE `poster` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '广告图',
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '广告链接',
  `content` text COLLATE utf8_unicode_ci COMMENT '广告说明',
  `state` tinyint(4) DEFAULT NULL COMMENT '状态  0正常,1禁用',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "poster"
#

INSERT INTO `poster` VALUES (1,'/uploads/roomstype/20190904/ce9129c3aece06b3e44f55a828866ee9.jpg','www.baidu.com','百度广告',1,'1567576232','1567576953','0',0),(3,'/uploads/roomstype/20190904/c2428ac763401cb3c23f57fba63e790b.jpg','www.baidu.com123','1',1,'1567576403','1567576871','1567576523',0),(4,'/uploads/roomstype/20190904/777421d527e7f034f46f81d8518d036d.jpg','12313','1',1,'1567576551','1567576844','0',0),(5,'/uploads/roomstype/20190904/dfc3ac198536c1534dbb19dd41768506.png','url','',0,'1567576558','1567580075','1567576578',0);

#
# Structure for table "pow"
#

DROP TABLE IF EXISTS `pow`;
CREATE TABLE `pow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pow_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名',
  `pow_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '规则',
  `pow_url_term` text COLLATE utf8_unicode_ci COMMENT '规则条件',
  `remarks` text COLLATE utf8_unicode_ci COMMENT '备注',
  `parent_id` int(11) NOT NULL COMMENT '父级id',
  `state` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '状态',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) unsigned DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  `cj` tinyint(3) DEFAULT NULL COMMENT '层级',
  `sort` tinyint(3) DEFAULT '5' COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=318 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "pow"
#

INSERT INTO `pow` VALUES (40,'权限','#','权限规则条件','全责备注',0,'正常','1567129822','0','0',0,1,20),(41,'规则','Pow/pow_list','','',40,'正常','1567129868','0','0',0,2,20),(42,'管理员','Users/users_list','','',40,'正常','1567129895','0','0',0,2,10),(43,'角色','Power/add','','',40,'正常','1567129928','0','0',0,2,15),(44,'添加规则','Pow/add','123','',41,'隐藏','1567129963','0','0',0,3,5),(46,'删除规则','Pow/del','','',41,'隐藏','1567130003','0','0',0,3,5),(52,'修改规则','Pow/edit','','',41,'隐藏','1567150950','0','0',0,3,5),(53,'修改规则状态','Pow/state','','',41,'隐藏','1567151030','0','1567509995',0,3,5),(54,'添加角色','Power/insert','','没有权限时点击提交添加角色表单时会阻止操作',43,'隐藏','1567151270','0','0',0,3,5),(55,'角色授权','Power/pow','','',43,'隐藏','1567151294','0','0',0,3,5),(56,'删除角色','Power/del','','',43,'隐藏','1567151334','0','0',0,3,5),(57,'查看角色','Power/select','','',43,'隐藏','1567151350','0','0',0,3,5),(58,'修改角色','Power/power_edit','','',43,'隐藏','1567151367','0','0',0,3,5),(59,'会员','#','','',0,'正常','1567165494','0','0',0,1,5),(60,'用户列表','Consumer/index','','',59,'正常','1567165511','0','0',0,2,5),(61,'会员类型','Consumer/menber','','',59,'正常','1567166367','0','0',0,2,5),(62,'会员订单','Orders/member','','',59,'正常','1567166666','0','0',0,2,5),(63,'新增用户','Consumer/insert','','',60,'隐藏','1567396255','0','0',0,3,5),(64,'删除用户','Consumer/delete','','',60,'隐藏','1567396315','0','0',0,3,5),(65,'编辑用户','Consumer/edit','','',60,'隐藏','1567396371','0','0',0,3,5),(66,'编辑用户状态','Consumer/status','','',60,'隐藏','1567396441','0','0',0,3,5),(67,'添加会员','Consumer/memberinsert','','',61,'隐藏','1567396523','0','0',0,3,5),(68,'删除会员','Consumer/memberdelete','','',61,'隐藏','1567396574','0','0',0,3,5),(69,'编辑会员','Consumer/memberedit','','',61,'隐藏','1567396617','0','0',0,3,5),(70,'添加会员订单','Orders/insert','','',62,'隐藏','1567396696','0','0',0,3,5),(71,'删除订单','Orders/delete','','',62,'隐藏','1567396729','0','0',0,3,5),(72,'订单详情','Orders/show','','',62,'隐藏','1567396765','0','0',0,3,5),(74,'房型列表','Rooms/index','','',123,'正常','1567402886','0','0',0,2,5),(75,'添加房型','Rooms/insert','','',74,'隐藏','1567407403','0','0',0,3,5),(76,'删除房型','Orders/delete','','',74,'隐藏','1567409717','0','0',0,3,5),(77,'基础','#','','',0,'正常','1567505352','0','0',0,1,100),(78,'控制台','Platform/index','','',77,'正常','1567505592','0','0',0,2,5),(79,'轮播图','Platform/img','','',77,'正常','1567509778','0','0',0,2,5),(80,'修改房型','Rooms/update','','',74,'隐藏','1567562077','0','0',0,3,5),(81,'查看房型','Rooms/show','','',74,'隐藏','1567562145','0','0',0,3,5),(82,'房间列表','Room/index','','',123,'正常','1567562196','0','0',0,2,5),(83,'添加房间','Room/insert','','',82,'隐藏','1567562237','0','0',0,3,5),(84,'公司','#','','',123,'正常','1567591612','0','1567820515',1,2,5),(85,'公司基本情况','company/index','','',123,'正常','1567591637','0','0',0,2,5),(86,'修改控制台','Platform/edit','','',78,'隐藏','1567646409','0','0',0,3,5),(87,'添加轮播图','Platform/img_add','','',79,'隐藏','1567646428','0','0',0,3,5),(88,'删除轮播图','Platform/img_del','','',79,'隐藏','1567646445','0','0',0,3,5),(89,'修改轮播图状态','Platform/img_state','','',79,'隐藏','1567646459','0','0',0,3,5),(90,'修改轮播图','Platform/img_update','','',79,'隐藏','1567646475','0','0',0,3,5),(91,'导航','Platform/navigation','','',77,'正常','1567646495','0','0',0,2,5),(92,'添加导航','Platform/navigation_add','','',91,'隐藏','1567646519','0','0',0,3,5),(93,'删除导航','Platform/navigation_del','','',91,'隐藏','1567646535','0','0',0,3,5),(94,'修改导航状态','Platform/navigation_state','','',91,'隐藏','1567646550','0','0',0,3,5),(95,'修改导航','Platform/navigation_update','','',91,'隐藏','1567646580','0','0',0,3,5),(96,'广告','Platform/poster','','',77,'正常','1567646593','0','0',0,2,5),(97,'添加广告','Platform/poster_add','','',96,'隐藏','1567646605','0','0',0,3,5),(98,'删除广告','Platform/poster_del','','',96,'隐藏','1567646617','0','0',0,3,5),(99,'修改广告状态','Platform/poster_state','','',96,'隐藏','1567646630','0','0',0,3,5),(100,'修改广告','Platform/poster_update','','',96,'隐藏','1567646645','0','0',0,3,5),(101,'点餐','#','','',0,'正常','1567647041','0','0',0,1,5),(102,'餐厅管理','Order/restaurant','','',101,'正常','1567647092','0','0',0,2,5),(103,'菜品分类','Order/food_sort','','',101,'正常','1567647110','0','0',0,2,5),(104,'添加餐厅','Order/restaurant_add','','',102,'隐藏','1567647140','0','0',0,3,5),(105,'删除餐厅','Order/restaurant_del','','',102,'正常','1567647155','0','0',0,3,5),(106,'修改餐厅状态','Order/restaurant_state','','',102,'隐藏','1567647183','0','0',0,3,5),(107,'修改餐厅','Order/restaurant_update','','',102,'隐藏','1567647193','0','0',0,3,5),(108,'添加菜品分类','Prder/food_sort_add','','',103,'隐藏','1567647212','0','0',0,3,5),(109,'删除菜品分类','Order/food_sort_del','','',103,'隐藏','1567647249','0','0',0,3,5),(110,'修改菜品分类状态','Order/food_sort_state','','',103,'隐藏','1567647267','0','0',0,3,5),(111,'修改菜品分类','Order/food_sort_update','','',103,'隐藏','1567647282','0','0',0,3,5),(112,'桌号管理','Order/table_number_one','','',101,'正常','1567648067','0','0',0,2,5),(113,'添加桌号','Order/table_number_add','','',112,'隐藏','1567666300','0','0',0,3,5),(114,'删除桌号','Order/table_number_del','','',112,'隐藏','1567666313','0','0',0,3,5),(115,'修改桌号状态','Order/table_number_state','','',112,'隐藏','1567666326','0','0',0,3,5),(116,'修改桌号','Order/table_number_update','','',112,'正常','1567666350','0','0',0,3,5),(117,'菜品管理','Order/food','','',101,'正常','1567666383','0','0',0,2,5),(119,'编辑基本信息','Company/insert','','',85,'正常','1567656057','0','0',0,3,5),(120,'酒店维护开关','Company/status','','',85,'正常','1567656095','0','0',0,3,5),(121,'评论','comment/index','','',116,'正常','1567662744','0','1567820710',1,2,5),(122,'评论列表','comment/index','','',114,'正常','1567662767','0','1567672393',1,2,5),(123,'酒店','#','','',0,'正常','1567671028','0','0',0,1,5),(124,'删除房间','room/delete','','',82,'隐藏','1567672077','0','0',0,3,5),(125,'修改房间信息','room/update','','',82,'隐藏','1567672102','0','0',0,3,5),(126,'修改评论','comment/update','','',303,'隐藏','1567672258','0','0',0,3,5),(127,'新增评论','comment/insert','','',303,'隐藏','1567672294','0','0',0,3,5),(128,'删除评论','comment/delete','','',303,'隐藏','1567672326','0','0',0,3,5),(129,'显示隐藏评论','comment/status','','',303,'隐藏','1567672357','0','0',0,3,5),(130,'评论置顶','comment/settop','','',303,'隐藏','1567672385','0','0',0,3,5),(131,'酒店订单','hotelorders/index','','',123,'正常','1567675038','0','0',0,2,5),(200,'添加订单','hotelorders/insert','','',131,'隐藏','1567737236','0','0',0,3,5),(201,'删除房间订单','hotelorders/delete','','',131,'隐藏','1567757533','0','0',0,3,5),(202,'酒店订单信息','hotelorders/show','','',131,'隐藏','1567757600','0','0',0,3,5),(203,'修改订单状态','hotelorders/changestatus','','',131,'隐藏','1567765041','0','0',0,3,5),(204,'订单编辑','hotelorders/editorders','','',131,'隐藏','1567765201','0','0',0,3,5),(300,'商城','#','','',0,'正常','1567737987','0','0',0,1,5),(301,'商品列表','Goodslist/index','','',300,'正常','1567738017','0','0',0,2,5),(302,'商品类别管理','Goodsclass/index','','',300,'正常','1567741455','0','0',0,2,5),(303,'酒店评论','comment/index','','',123,'正常','1567820600','0','0',0,2,5),(304,'分类添加','goodsclass/goods_sort_add','','',302,'隐藏','1567823003','0','0',0,3,5),(305,'分类修改','goodsclass/goods_sort_update','','',302,'隐藏','1567823044','0','0',0,3,5),(306,'修改分类回显','goodsclass/goods_sort_edit','','',302,'隐藏','1567823088','0','0',0,3,5),(307,'修改分类状态','goodsclass/goods_sort_state','','',302,'隐藏','1567823126','0','0',0,3,5),(308,'分类删除','goodsclass/goods_sort_del','','',302,'隐藏','1567823167','0','0',0,3,5),(309,'添加商品','goodslist/goods_add','','',301,'隐藏','1567823205','0','0',0,3,5),(310,'修改商品','goodslist/goods_update','','',301,'隐藏','1567823321','0','0',0,3,5),(311,'商品状态','goodslist/goods_state','','',301,'隐藏','1567823377','0','0',0,3,5),(312,'商品删除','goodslist/goods_del','','',301,'隐藏','1567823406','0','0',0,3,5),(313,'修改商品回显','goodslist/goods_edit','','',301,'隐藏','1567844945','0','0',0,3,5),(314,'商品分类回显','goodslist/goods_sort','','',301,'隐藏','1567845023','0','0',0,3,5),(315,'商品类分配','goodslist/goods_sort_add','','',301,'隐藏','1567845185','0','0',0,3,5),(316,'商城维护开关','storeseting/index','','',300,'正常','1567845670','0','0',0,2,5),(317,'分类广告','sortposter/index','','',300,'正常','1567853092','0','0',0,2,5);

#
# Structure for table "pow_power"
#

DROP TABLE IF EXISTS `pow_power`;
CREATE TABLE `pow_power` (
  `power_id` int(11) NOT NULL COMMENT '角色ID',
  `pow_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限id',
  `state` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`power_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "pow_power"
#

INSERT INTO `pow_power` VALUES (1,'40,41,44,57,58,47',NULL),(2,'40,41,42,43,59,60,61,62,101,102,106,103,110',NULL);

#
# Structure for table "power"
#

DROP TABLE IF EXISTS `power`;
CREATE TABLE `power` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限组名',
  `power_content` text COLLATE utf8_unicode_ci COMMENT '权限描述',
  `state_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "power"
#

INSERT INTO `power` VALUES (1,'超级管理员','全部权限',0,0,0,0),(2,'总经理','总经理',1567148418,0,0,0);

#
# Structure for table "restaurant"
#

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '餐厅标题',
  `sort` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `business_hours_start` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '开始营业时间',
  `business_hours_end` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '结束营业时间',
  `foot_id` text COLLATE utf8_unicode_ci COMMENT '菜品id',
  `state` tinyint(4) DEFAULT NULL COMMENT '状态  0:正常营业,1:停止营业',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "restaurant"
#

INSERT INTO `restaurant` VALUES (1,'一号餐厅',5,'09:00','22:00','1',0,'1567648213','0','0',0),(2,'夜间餐厅',5,'22:00','09:00',NULL,0,'1567648385','0','1567648396',0),(3,'二号餐厅',5,'09:00','23:59',NULL,0,'1567665267','0','0',0);

#
# Structure for table "room_img"
#

DROP TABLE IF EXISTS `room_img`;
CREATE TABLE `room_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `room_id` int(10) unsigned DEFAULT NULL COMMENT '房间id',
  `room_type_id` int(10) unsigned DEFAULT NULL COMMENT '房型id',
  `path` varchar(255) NOT NULL COMMENT '路径',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除：0未删除；1删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  `main_img` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '主图:0 是；1 否;',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "room_img"
#

INSERT INTO `room_img` VALUES (1,NULL,1,'/uploads/roomstype/20190902/98ef4c094eaa6890648d2704ab0ed5b5.jpg',0,'2019-09-02 17:42:14',NULL,NULL,0),(2,NULL,2,'/uploads/roomstype/20190902/5acc302184ae359c89330411a98719c9.jpg',0,'2019-09-02 19:18:31',NULL,NULL,0),(4,NULL,1,'/uploads/roomstype/20190902/85560f4f4fa1f9ceb6a1fb81c509e325.jpg',0,'2019-09-02 19:26:33',NULL,NULL,0),(5,NULL,1,'/uploads/roomstype/20190902/a4b4fb84ad590d091c4a2a4befe1cdbf.jpg',0,'2019-09-02 19:27:58',NULL,NULL,0),(6,NULL,1,'/uploads/roomstype/20190902/856ae72b7d9f0f858a723686b997a45f.jpg',0,'2019-09-02 19:28:06',NULL,NULL,0),(7,NULL,3,'',0,'2019-09-04 10:36:46',NULL,NULL,0),(8,5,NULL,'/uploads/rooms/20190904/88b8be7eab173ecfbee8f087be20786e.jpg',0,'2019-09-04 13:47:33',NULL,NULL,0),(9,1,NULL,'/uploads/rooms/20190904/a16a0d94062422702f114ea747356912.jpg',0,'2019-09-04 17:19:13',NULL,NULL,0),(10,1,NULL,'/uploads/rooms/20190904/775d53ef74759ccd6b77ac0a1f0e87ac.jpg',0,'2019-09-04 17:21:54',NULL,NULL,1),(11,4,NULL,'/uploads/rooms/20190904/05e4870cc0ac390b8b43e3d6655a043e.jpg',0,'2019-09-04 17:48:58',NULL,NULL,1),(12,7,NULL,'/uploads/rooms/20190907/bb3b862f7deadf61116fd26d38e75023.jpg',0,'2019-09-07 11:33:57',NULL,NULL,0),(13,7,NULL,'/uploads/rooms/20190907/5d39ad88bf3e372cf15c48f5e59eb866.jpg',0,'2019-09-07 11:36:46',NULL,NULL,1),(14,7,NULL,'/uploads/rooms/20190907/760ebb3c8a2bdd54ba23e61fab9d8861.jpg',0,'2019-09-07 11:36:46',NULL,NULL,1),(15,6,NULL,'/uploads/rooms/20190907/f5811187e77d6ae0a5690a660cbab42a.jpg',0,'2019-09-07 11:39:17',NULL,NULL,1),(16,6,NULL,'/uploads/rooms/20190907/c0d972e80128415f825ac8998b4db0e3.jpg',0,'2019-09-07 11:39:17',NULL,NULL,1),(17,NULL,3,'/uploads/roomstype/20190907/92973bd1ebea9bd831645e3d73b0aec0.jpg',0,'2019-09-07 16:27:13',NULL,NULL,0),(18,NULL,4,'/uploads/roomstype/20190907/8aeaed30babb550fdde8e885ef75fbcf.jpg',0,'2019-09-07 17:10:20',NULL,NULL,0),(19,NULL,4,'/uploads/roomstype/20190907/8aeaed30babb550fdde8e885ef75fbcf.jpg',0,'2019-09-07 17:11:40',NULL,NULL,0),(20,12,NULL,'/uploads/rooms/20190907/b3dfa45b02bec886777b2f38ce330d73.jpg',0,'2019-09-07 17:46:08',NULL,NULL,0),(21,NULL,2,'/uploads/roomstype/20190907/25abe643d11a7524cc04c17ca848cd87.jpg',0,'2019-09-07 17:50:19',NULL,NULL,0);

#
# Structure for table "rooms"
#

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '房间id',
  `type_id` int(10) unsigned NOT NULL COMMENT '房型id',
  `name` varchar(255) NOT NULL COMMENT '房间标题',
  `content` varchar(255) DEFAULT NULL COMMENT '房间说明',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态：0-空闲；1-已预订；2-已入住；',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '跟新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "rooms"
#

INSERT INTO `rooms` VALUES (1,1,'1011','便宜点',0,0,'2019-09-07 15:08:34',1567840114,NULL),(2,1,'102','便宜点',1,0,'2019-09-04 15:54:25',NULL,1567583665),(3,1,'103','便宜点',1,0,'2019-09-04 15:54:21',NULL,1567583661),(4,2,'201','便宜点',0,0,'2019-09-07 15:08:33',1567840113,NULL),(5,2,'202','便宜点',0,0,'2019-09-07 14:23:53',NULL,NULL),(6,2,'203','便宜点',0,0,'2019-09-07 15:08:29',1567840109,NULL),(7,1,'1001','便宜点',0,0,'2019-09-07 11:36:46',1567827406,NULL),(12,4,'1111','马上住',0,0,'2019-09-07 19:02:16',1567854136,NULL);

#
# Structure for table "rooms_type"
#

DROP TABLE IF EXISTS `rooms_type`;
CREATE TABLE `rooms_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '房型id',
  `title` varchar(50) NOT NULL COMMENT '房间标题',
  `wc` varchar(5) NOT NULL DEFAULT '1' COMMENT '独立卫生间：1-有；2-没有；',
  `window` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否有窗户：1-有；2-没有',
  `price` decimal(9,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '房间价格',
  `wifi` varchar(5) NOT NULL DEFAULT '1' COMMENT '是否有wifi：1-有；2-没有',
  `breakfast` varchar(3) NOT NULL DEFAULT '1' COMMENT '是否包含早餐：1-有；2-没有',
  `nums` varchar(3) NOT NULL DEFAULT '1' COMMENT '最多居住人数',
  `area` tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '房间面积：平方',
  `content` text COMMENT '房型描述',
  `rerund` text COMMENT '退款规则',
  `reserve` text COMMENT '预定规则',
  `use` text COMMENT '使用规则',
  `roomscount` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '房间数量',
  `discount` varchar(5) DEFAULT '' COMMENT '是否参与折扣',
  `stor_no` tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '房型排序号',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  `roomtype` varchar(255) NOT NULL COMMENT '床型',
  `floor` varchar(255) NOT NULL COMMENT '楼层',
  `img` varchar(255) DEFAULT NULL COMMENT '主图图片',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "rooms_type"
#

INSERT INTO `rooms_type` VALUES (1,'单人间111','2',1,30.00,'2','1','1',30,'便宜点',NULL,NULL,NULL,2,'参与',20,0,0,'2019-09-07 17:14:42',1567841240,NULL,'大床1.8*2.0两张','','/uploads/roomstype/20190907/8c0d08600d3a788eae9a1ae43b9c28e3.jpg'),(2,'标准间111','1',1,60.00,'1','1','2',1,'住好点','111','222','333',3,'不参与',20,0,0,'2019-09-07 17:50:19',1567849819,1567583656,'大床1.0*1.8两张','1-6层','/uploads/roomstype/20190907/8c0d08600d3a788eae9a1ae43b9c28e3.jpg'),(3,'111','1',1,30.00,'1','1','11',1,'111','222','333','444',0,'参与',20,0,0,'2019-09-07 16:41:03',NULL,NULL,'大床1.8*2.0两张','1','/uploads/roomstype/20190907/8c0d08600d3a788eae9a1ae43b9c28e3.jpg'),(4,'豪华间','独立',0,30.00,'宽带','大床1','3',50,'111','222','333','444',1,'会员折扣',20,0,0,'2019-09-07 17:46:01',NULL,NULL,'大床1.8*2.0两张','8层','/uploads/roomstype/20190907/1566acada73c1c3d0b3bf26383f3fdc3.jpg');

#
# Structure for table "sort_poster"
#

DROP TABLE IF EXISTS `sort_poster`;
CREATE TABLE `sort_poster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(255) DEFAULT NULL COMMENT '图片',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转地址',
  `state` int(11) DEFAULT NULL COMMENT '状态 0显示:1:禁用',
  `create_time` varchar(30) DEFAULT NULL,
  `update_time` varchar(30) DEFAULT NULL,
  `delete_time` varchar(30) DEFAULT NULL,
  `is_delete` int(11) DEFAULT NULL COMMENT '删除 0:未删除1:删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "sort_poster"
#

INSERT INTO `sort_poster` VALUES (1,'/uploads/sort_poster/20190907/8d8cbcbcaf370aab6856f5774e9000d0.jpg','#',1,'1567854180',NULL,'1567854660',1),(2,'/uploads/sort_poster/20190907/103a8740e868e6e26991563ccd3c31ee.jpg','#',0,'1567854669','1567854979',NULL,0);

#
# Structure for table "store_seting"
#

DROP TABLE IF EXISTS `store_seting`;
CREATE TABLE `store_seting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state` int(11) NOT NULL COMMENT '维护  0:维护1:开放',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "store_seting"
#

INSERT INTO `store_seting` VALUES (1,0,1567852322);

#
# Structure for table "table_number"
#

DROP TABLE IF EXISTS `table_number`;
CREATE TABLE `table_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标题',
  `x_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '小程序码',
  `restaurant_id` int(10) unsigned DEFAULT NULL COMMENT '所属餐厅',
  `state` tinyint(4) DEFAULT NULL COMMENT '状态 0正常  1停止营业',
  `sort` int(10) unsigned DEFAULT NULL COMMENT '排序',
  `start_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '创建时间',
  `update_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '更新时间',
  `delete_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "table_number"
#

INSERT INTO `table_number` VALUES (1,'A001',NULL,1,0,50,'1567648621','0','1567665062',0),(3,'Y001',NULL,2,0,51,'1567648772','1567666005','1567663882',0),(4,'Y002',NULL,1,0,219,'1567652328','1567665981','1567664664',0),(5,'S004',NULL,3,0,40,'1567665290','1567665595','0',0),(6,'123',NULL,1,0,123,'1567665344','0','1567665630',1),(7,'Y002',NULL,2,0,123,'1567665404','1567665583','0',0),(8,'2',NULL,1,0,2,'1567665548','1567665561','1567665639',1);

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '电话',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '电子邮箱',
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `role_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '角色id,0超级管理员',
  `start_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT '0' COMMENT '删除时间',
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '软删除,0未删除,1已删除',
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (2,'admins','123123123','1576962841@qq.com','2aefc34200a294a3cc7db81b43a81873',1,1567156197,0,0,0,'使用中'),(3,'admin','123213','1576962841@qq.com','21232f297a57a5a743894a0e4a801fc3',2,1567156235,0,0,0,'使用中'),(4,'guojian','12345678901','1545359864@qq.com','e10adc3949ba59abbe56e057f20f883e',2,1567396157,0,0,0,'使用中');
