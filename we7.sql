-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2018 at 09:29 PM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `we7`
--

-- --------------------------------------------------------

--
-- Table structure for table `ims_account`
--

CREATE TABLE `ims_account` (
  `acid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `hash` varchar(8) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `isconnect` tinyint(4) NOT NULL,
  `isdeleted` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_account`
--

INSERT INTO `ims_account` (`acid`, `uniacid`, `hash`, `type`, `isconnect`, `isdeleted`) VALUES
(1, 1, 'uRr8qvQV', 1, 0, 1),
(2, 2, 'cpI0DKa9', 4, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_account_wechats`
--

CREATE TABLE `ims_account_wechats` (
  `acid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(255) NOT NULL,
  `level` tinyint(4) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `account` varchar(30) NOT NULL,
  `original` varchar(50) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `country` varchar(10) NOT NULL,
  `province` varchar(3) NOT NULL,
  `city` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `lastupdate` int(10) UNSIGNED NOT NULL,
  `key` varchar(50) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `styleid` int(10) UNSIGNED NOT NULL,
  `subscribeurl` varchar(120) NOT NULL,
  `auth_refresh_token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_account_wechats`
--

INSERT INTO `ims_account_wechats` (`acid`, `uniacid`, `token`, `encodingaeskey`, `level`, `name`, `account`, `original`, `signature`, `country`, `province`, `city`, `username`, `password`, `lastupdate`, `key`, `secret`, `styleid`, `subscribeurl`, `auth_refresh_token`) VALUES
(1, 1, 'omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP', '', 1, 'we7team', '', '', '', '', '', '', '', '', 0, '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_account_wxapp`
--

CREATE TABLE `ims_account_wxapp` (
  `acid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(43) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `account` varchar(30) NOT NULL,
  `original` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_account_wxapp`
--

INSERT INTO `ims_account_wxapp` (`acid`, `uniacid`, `token`, `encodingaeskey`, `level`, `account`, `original`, `key`, `secret`, `name`) VALUES
(2, 2, 'tLLbbnlaTtwybzfsqW1B147N14Y6F6LL', 'EuQJW2uWJYM00JPB32WWBJR720ZFfYJqb2jJW2UMH33', 1, '', '', 'wx58ebcc18261e55f9', '779fff427ac78cf59391fea71f33cb99', '镇镇通');

-- --------------------------------------------------------

--
-- Table structure for table `ims_article_category`
--

CREATE TABLE `ims_article_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `displayorder` tinyint(3) UNSIGNED NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_article_news`
--

CREATE TABLE `ims_article_news` (
  `id` int(10) UNSIGNED NOT NULL,
  `cateid` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` tinyint(3) UNSIGNED NOT NULL,
  `is_display` tinyint(3) UNSIGNED NOT NULL,
  `is_show_home` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `click` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_article_notice`
--

CREATE TABLE `ims_article_notice` (
  `id` int(10) UNSIGNED NOT NULL,
  `cateid` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `displayorder` tinyint(3) UNSIGNED NOT NULL,
  `is_display` tinyint(3) UNSIGNED NOT NULL,
  `is_show_home` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `click` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_article_unread_notice`
--

CREATE TABLE `ims_article_unread_notice` (
  `id` int(10) UNSIGNED NOT NULL,
  `notice_id` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `is_new` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_basic_reply`
--

CREATE TABLE `ims_basic_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `content` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_business`
--

CREATE TABLE `ims_business` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dist` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `industry1` varchar(10) NOT NULL,
  `industry2` varchar(10) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_attachment`
--

CREATE TABLE `ims_core_attachment` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_core_attachment`
--

INSERT INTO `ims_core_attachment` (`id`, `uniacid`, `uid`, `filename`, `attachment`, `type`, `createtime`) VALUES
(1, 0, 1, 'WechatIMG362.png', 'images/global/nKo08Kk77HT55n30TwPwn2UUUZoZ8W.png', 1, 1513721354),
(2, 0, 1, '50Coin1.png', 'images/global/JrsZqJ55s1Z479i14nvWq9W9qRRD3R.png', 1, 1513721399),
(3, 2, 1, 'WechatIMG362.png', 'images/2/2017/12/i1BBUSzDvl8nc8826nvEXxU3E6vf1D.png', 1, 1513722495),
(4, 2, 1, 'menu_1 (3).png', 'images/2/2018/01/NTXzqXMy5QT5Qy33T3QE76ZexvkSQj.png', 1, 1515224486);

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_cache`
--

CREATE TABLE `ims_core_cache` (
  `key` varchar(50) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_core_cache`
--

INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('account:ticket', 's:95:\"ticket@@@hksQFW8-rgQQKZco73L-GvwB507WQdq6S53pzF3zXa8Bgvv3LGEu5uneJ5QaMIvD1GtvtICERW59pUAEcNwmgQ\";'),
('userbasefields', 'a:45:{s:7:\"uniacid\";s:17:\"同一公众号id\";s:7:\"groupid\";s:8:\"分组id\";s:7:\"credit1\";s:6:\"积分\";s:7:\"credit2\";s:6:\"余额\";s:7:\"credit3\";s:19:\"预留积分类型3\";s:7:\"credit4\";s:19:\"预留积分类型4\";s:7:\"credit5\";s:19:\"预留积分类型5\";s:7:\"credit6\";s:19:\"预留积分类型6\";s:10:\"createtime\";s:12:\"加入时间\";s:6:\"mobile\";s:12:\"手机号码\";s:5:\"email\";s:12:\"电子邮箱\";s:8:\"realname\";s:12:\"真实姓名\";s:8:\"nickname\";s:6:\"昵称\";s:6:\"avatar\";s:6:\"头像\";s:2:\"qq\";s:5:\"QQ号\";s:6:\"gender\";s:6:\"性别\";s:5:\"birth\";s:6:\"生日\";s:13:\"constellation\";s:6:\"星座\";s:6:\"zodiac\";s:6:\"生肖\";s:9:\"telephone\";s:12:\"固定电话\";s:6:\"idcard\";s:12:\"证件号码\";s:9:\"studentid\";s:6:\"学号\";s:5:\"grade\";s:6:\"班级\";s:7:\"address\";s:6:\"地址\";s:7:\"zipcode\";s:6:\"邮编\";s:11:\"nationality\";s:6:\"国籍\";s:6:\"reside\";s:9:\"居住地\";s:14:\"graduateschool\";s:12:\"毕业学校\";s:7:\"company\";s:6:\"公司\";s:9:\"education\";s:6:\"学历\";s:10:\"occupation\";s:6:\"职业\";s:8:\"position\";s:6:\"职位\";s:7:\"revenue\";s:9:\"年收入\";s:15:\"affectivestatus\";s:12:\"情感状态\";s:10:\"lookingfor\";s:13:\" 交友目的\";s:9:\"bloodtype\";s:6:\"血型\";s:6:\"height\";s:6:\"身高\";s:6:\"weight\";s:6:\"体重\";s:6:\"alipay\";s:15:\"支付宝帐号\";s:3:\"msn\";s:3:\"MSN\";s:6:\"taobao\";s:12:\"阿里旺旺\";s:4:\"site\";s:6:\"主页\";s:3:\"bio\";s:12:\"自我介绍\";s:8:\"interest\";s:12:\"兴趣爱好\";s:8:\"password\";s:6:\"密码\";}'),
('usersfields', 'a:46:{s:8:\"realname\";s:12:\"真实姓名\";s:8:\"nickname\";s:6:\"昵称\";s:6:\"avatar\";s:6:\"头像\";s:2:\"qq\";s:5:\"QQ号\";s:6:\"mobile\";s:12:\"手机号码\";s:3:\"vip\";s:9:\"VIP级别\";s:6:\"gender\";s:6:\"性别\";s:9:\"birthyear\";s:12:\"出生生日\";s:13:\"constellation\";s:6:\"星座\";s:6:\"zodiac\";s:6:\"生肖\";s:9:\"telephone\";s:12:\"固定电话\";s:6:\"idcard\";s:12:\"证件号码\";s:9:\"studentid\";s:6:\"学号\";s:5:\"grade\";s:6:\"班级\";s:7:\"address\";s:12:\"邮寄地址\";s:7:\"zipcode\";s:6:\"邮编\";s:11:\"nationality\";s:6:\"国籍\";s:14:\"resideprovince\";s:12:\"居住地址\";s:14:\"graduateschool\";s:12:\"毕业学校\";s:7:\"company\";s:6:\"公司\";s:9:\"education\";s:6:\"学历\";s:10:\"occupation\";s:6:\"职业\";s:8:\"position\";s:6:\"职位\";s:7:\"revenue\";s:9:\"年收入\";s:15:\"affectivestatus\";s:12:\"情感状态\";s:10:\"lookingfor\";s:13:\" 交友目的\";s:9:\"bloodtype\";s:6:\"血型\";s:6:\"height\";s:6:\"身高\";s:6:\"weight\";s:6:\"体重\";s:6:\"alipay\";s:15:\"支付宝帐号\";s:3:\"msn\";s:3:\"MSN\";s:5:\"email\";s:12:\"电子邮箱\";s:6:\"taobao\";s:12:\"阿里旺旺\";s:4:\"site\";s:6:\"主页\";s:3:\"bio\";s:12:\"自我介绍\";s:8:\"interest\";s:12:\"兴趣爱好\";s:7:\"uniacid\";s:17:\"同一公众号id\";s:7:\"groupid\";s:8:\"分组id\";s:7:\"credit1\";s:6:\"积分\";s:7:\"credit2\";s:6:\"余额\";s:7:\"credit3\";s:19:\"预留积分类型3\";s:7:\"credit4\";s:19:\"预留积分类型4\";s:7:\"credit5\";s:19:\"预留积分类型5\";s:7:\"credit6\";s:19:\"预留积分类型6\";s:10:\"createtime\";s:12:\"加入时间\";s:8:\"password\";s:12:\"用户密码\";}'),
('setting', 'a:9:{s:9:\"copyright\";a:26:{s:6:\"status\";i:0;s:10:\"verifycode\";i:0;s:6:\"reason\";s:0:\"\";s:8:\"sitename\";s:0:\"\";s:3:\"url\";s:7:\"http://\";s:8:\"statcode\";s:0:\"\";s:10:\"footerleft\";s:9:\"镇镇通\";s:11:\"footerright\";s:0:\"\";s:4:\"icon\";s:0:\"\";s:5:\"flogo\";s:48:\"images/global/nKo08Kk77HT55n30TwPwn2UUUZoZ8W.png\";s:14:\"background_img\";s:48:\"images/global/JrsZqJ55s1Z479i14nvWq9W9qRRD3R.png\";s:6:\"slides\";s:216:\"a:3:{i:0;s:58:\"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg\";i:1;s:58:\"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg\";i:2;s:58:\"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg\";}\";s:6:\"notice\";s:0:\"\";s:5:\"blogo\";s:48:\"images/global/nKo08Kk77HT55n30TwPwn2UUUZoZ8W.png\";s:8:\"baidumap\";a:2:{s:3:\"lng\";s:10:\"116.403851\";s:3:\"lat\";s:9:\"39.915177\";}s:7:\"company\";s:0:\"\";s:14:\"companyprofile\";s:0:\"\";s:7:\"address\";s:0:\"\";s:6:\"person\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:5:\"email\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:11:\"description\";s:0:\"\";s:12:\"showhomepage\";i:0;s:13:\"leftmenufixed\";i:0;}s:8:\"authmode\";i:1;s:5:\"close\";a:2:{s:6:\"status\";s:1:\"0\";s:6:\"reason\";s:0:\"\";}s:8:\"register\";a:4:{s:4:\"open\";i:0;s:6:\"verify\";i:0;s:4:\"code\";i:0;s:7:\"groupid\";i:1;}s:10:\"module_ban\";a:0:{}s:14:\"module_upgrade\";a:0:{}s:8:\"platform\";a:5:{s:5:\"token\";s:32:\"cQU0MUXUkkJgwS6KLs0Z00u68lB0sKsU\";s:14:\"encodingaeskey\";s:43:\"V3aOE2C5NRA4pa5jA3LaatpJl2EL33RT542tuAZ5144\";s:5:\"appid\";s:18:\"wx7f83e93205d2fd31\";s:9:\"appsecret\";s:32:\"c328083278a9ff1c88be23095798d3f6\";s:9:\"authstate\";i:1;}s:7:\"cloudip\";a:2:{s:2:\"ip\";s:13:\"111.161.3.162\";s:6:\"expire\";i:1515467014;}s:5:\"basic\";a:1:{s:8:\"template\";s:7:\"default\";}}'),
('we7:all_cloud_upgrade_module:', 'a:2:{s:6:\"expire\";i:1513724537;s:4:\"data\";a:0:{}}'),
('system_frame', 'a:8:{s:7:\"account\";a:7:{s:5:\"title\";s:9:\"公众号\";s:4:\"icon\";s:18:\"wi wi-white-collar\";s:3:\"url\";s:41:\"./index.php?c=home&a=welcome&do=platform&\";s:7:\"section\";a:4:{s:13:\"platform_plus\";a:2:{s:5:\"title\";s:12:\"增强功能\";s:4:\"menu\";a:5:{s:14:\"platform_reply\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"自动回复\";s:3:\"url\";s:31:\"./index.php?c=platform&a=reply&\";s:15:\"permission_name\";s:14:\"platform_reply\";s:4:\"icon\";s:11:\"wi wi-reply\";s:12:\"displayorder\";i:5;s:2:\"id\";N;s:14:\"sub_permission\";a:0:{}}s:13:\"platform_menu\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"自定义菜单\";s:3:\"url\";s:30:\"./index.php?c=platform&a=menu&\";s:15:\"permission_name\";s:13:\"platform_menu\";s:4:\"icon\";s:16:\"wi wi-custommenu\";s:12:\"displayorder\";i:4;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:11:\"platform_qr\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:22:\"二维码/转化链接\";s:3:\"url\";s:28:\"./index.php?c=platform&a=qr&\";s:15:\"permission_name\";s:11:\"platform_qr\";s:4:\"icon\";s:12:\"wi wi-qrcode\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";a:0:{}}s:17:\"platform_material\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:16:\"素材/编辑器\";s:3:\"url\";s:34:\"./index.php?c=platform&a=material&\";s:15:\"permission_name\";s:17:\"platform_material\";s:4:\"icon\";s:12:\"wi wi-redact\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:13:\"platform_site\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:16:\"微官网-文章\";s:3:\"url\";s:38:\"./index.php?c=site&a=multi&do=display&\";s:15:\"permission_name\";s:13:\"platform_site\";s:4:\"icon\";s:10:\"wi wi-home\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";a:0:{}}}}s:2:\"mc\";a:2:{s:5:\"title\";s:6:\"粉丝\";s:4:\"menu\";a:2:{s:7:\"mc_fans\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"粉丝管理\";s:3:\"url\";s:24:\"./index.php?c=mc&a=fans&\";s:15:\"permission_name\";s:7:\"mc_fans\";s:4:\"icon\";s:16:\"wi wi-fansmanage\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:9:\"mc_member\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"会员管理\";s:3:\"url\";s:26:\"./index.php?c=mc&a=member&\";s:15:\"permission_name\";s:9:\"mc_member\";s:4:\"icon\";s:10:\"wi wi-fans\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:7:\"profile\";a:2:{s:5:\"title\";s:6:\"配置\";s:4:\"menu\";a:2:{s:7:\"profile\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"参数配置\";s:3:\"url\";s:33:\"./index.php?c=profile&a=passport&\";s:15:\"permission_name\";s:15:\"profile_setting\";s:4:\"icon\";s:23:\"wi wi-parameter-setting\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:7:\"payment\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"支付参数\";s:3:\"url\";s:32:\"./index.php?c=profile&a=payment&\";s:15:\"permission_name\";s:19:\"profile_pay_setting\";s:4:\"icon\";s:17:\"wi wi-pay-setting\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:10:\"statistics\";a:2:{s:5:\"title\";s:6:\"统计\";s:4:\"menu\";a:1:{s:3:\"app\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"访问统计\";s:3:\"url\";s:31:\"./index.php?c=statistics&a=app&\";s:15:\"permission_name\";s:14:\"statistics_app\";s:4:\"icon\";s:9:\"wi wi-api\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}}s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:1;}s:5:\"wxapp\";a:7:{s:5:\"title\";s:9:\"小程序\";s:4:\"icon\";s:19:\"wi wi-small-routine\";s:3:\"url\";s:38:\"./index.php?c=wxapp&a=display&do=home&\";s:7:\"section\";a:3:{s:14:\"wxapp_entrance\";a:3:{s:5:\"title\";s:15:\"小程序入口\";s:4:\"menu\";a:1:{s:20:\"module_entrance_link\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"入口页面\";s:3:\"url\";s:36:\"./index.php?c=wxapp&a=entrance-link&\";s:15:\"permission_name\";s:19:\"wxapp_entrance_link\";s:4:\"icon\";s:18:\"wi wi-data-synchro\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}s:10:\"is_display\";b:1;}s:12:\"wxapp_module\";a:3:{s:5:\"title\";s:6:\"应用\";s:4:\"menu\";a:0:{}s:10:\"is_display\";b:1;}s:20:\"platform_manage_menu\";a:2:{s:5:\"title\";s:6:\"管理\";s:4:\"menu\";a:3:{s:11:\"module_link\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"数据同步\";s:3:\"url\";s:42:\"./index.php?c=wxapp&a=module-link-uniacid&\";s:15:\"permission_name\";s:25:\"wxapp_module_link_uniacid\";s:4:\"icon\";s:18:\"wi wi-data-synchro\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:13:\"wxapp_profile\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"支付参数\";s:3:\"url\";s:30:\"./index.php?c=wxapp&a=payment&\";s:15:\"permission_name\";s:13:\"wxapp_payment\";s:4:\"icon\";s:16:\"wi wi-appsetting\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:14:\"front_download\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:18:\"上传微信审核\";s:3:\"url\";s:37:\"./index.php?c=wxapp&a=front-download&\";s:15:\"permission_name\";s:20:\"wxapp_front_download\";s:4:\"icon\";s:13:\"wi wi-examine\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}}s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:2;}s:6:\"module\";a:7:{s:5:\"title\";s:6:\"应用\";s:4:\"icon\";s:11:\"wi wi-apply\";s:3:\"url\";s:31:\"./index.php?c=module&a=display&\";s:7:\"section\";a:0:{}s:10:\"is_display\";b:0;s:9:\"is_system\";b:1;s:12:\"displayorder\";i:3;}s:6:\"system\";a:7:{s:5:\"title\";s:12:\"系统管理\";s:4:\"icon\";s:13:\"wi wi-setting\";s:3:\"url\";s:39:\"./index.php?c=home&a=welcome&do=system&\";s:7:\"section\";a:6:{s:10:\"wxplatform\";a:2:{s:5:\"title\";s:9:\"公众号\";s:4:\"menu\";a:4:{s:14:\"system_account\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:16:\" 微信公众号\";s:3:\"url\";s:45:\"./index.php?c=account&a=manage&account_type=1\";s:15:\"permission_name\";s:14:\"system_account\";s:4:\"icon\";s:12:\"wi wi-wechat\";s:12:\"displayorder\";i:4;s:2:\"id\";N;s:14:\"sub_permission\";a:6:{i:0;a:2:{s:5:\"title\";s:21:\"公众号管理设置\";s:15:\"permission_name\";s:21:\"system_account_manage\";}i:1;a:2:{s:5:\"title\";s:15:\"添加公众号\";s:15:\"permission_name\";s:19:\"system_account_post\";}i:2;a:2:{s:5:\"title\";s:15:\"公众号停用\";s:15:\"permission_name\";s:19:\"system_account_stop\";}i:3;a:2:{s:5:\"title\";s:18:\"公众号回收站\";s:15:\"permission_name\";s:22:\"system_account_recycle\";}i:4;a:2:{s:5:\"title\";s:15:\"公众号删除\";s:15:\"permission_name\";s:21:\"system_account_delete\";}i:5;a:2:{s:5:\"title\";s:15:\"公众号恢复\";s:15:\"permission_name\";s:22:\"system_account_recover\";}}}s:13:\"system_module\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"公众号应用\";s:3:\"url\";s:51:\"./index.php?c=module&a=manage-system&account_type=1\";s:15:\"permission_name\";s:13:\"system_module\";s:4:\"icon\";s:14:\"wi wi-wx-apply\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:15:\"system_template\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"微官网模板\";s:3:\"url\";s:32:\"./index.php?c=system&a=template&\";s:15:\"permission_name\";s:15:\"system_template\";s:4:\"icon\";s:17:\"wi wi-wx-template\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:15:\"system_platform\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:19:\" 微信开放平台\";s:3:\"url\";s:32:\"./index.php?c=system&a=platform&\";s:15:\"permission_name\";s:15:\"system_platform\";s:4:\"icon\";s:20:\"wi wi-exploitsetting\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:6:\"module\";a:2:{s:5:\"title\";s:9:\"小程序\";s:4:\"menu\";a:2:{s:12:\"system_wxapp\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"微信小程序\";s:3:\"url\";s:45:\"./index.php?c=account&a=manage&account_type=4\";s:15:\"permission_name\";s:12:\"system_wxapp\";s:4:\"icon\";s:11:\"wi wi-wxapp\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";a:6:{i:0;a:2:{s:5:\"title\";s:21:\"小程序管理设置\";s:15:\"permission_name\";s:19:\"system_wxapp_manage\";}i:1;a:2:{s:5:\"title\";s:15:\"添加小程序\";s:15:\"permission_name\";s:17:\"system_wxapp_post\";}i:2;a:2:{s:5:\"title\";s:15:\"小程序停用\";s:15:\"permission_name\";s:17:\"system_wxapp_stop\";}i:3;a:2:{s:5:\"title\";s:18:\"小程序回收站\";s:15:\"permission_name\";s:20:\"system_wxapp_recycle\";}i:4;a:2:{s:5:\"title\";s:15:\"小程序删除\";s:15:\"permission_name\";s:19:\"system_wxapp_delete\";}i:5;a:2:{s:5:\"title\";s:15:\"小程序恢复\";s:15:\"permission_name\";s:20:\"system_wxapp_recover\";}}}s:19:\"system_module_wxapp\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"小程序应用\";s:3:\"url\";s:51:\"./index.php?c=module&a=manage-system&account_type=4\";s:15:\"permission_name\";s:19:\"system_module_wxapp\";s:4:\"icon\";s:17:\"wi wi-wxapp-apply\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:4:\"user\";a:2:{s:5:\"title\";s:13:\"帐户/用户\";s:4:\"menu\";a:3:{s:9:\"system_my\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"我的帐户\";s:3:\"url\";s:29:\"./index.php?c=user&a=profile&\";s:15:\"permission_name\";s:9:\"system_my\";s:4:\"icon\";s:10:\"wi wi-user\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:11:\"system_user\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"用户管理\";s:3:\"url\";s:29:\"./index.php?c=user&a=display&\";s:15:\"permission_name\";s:11:\"system_user\";s:4:\"icon\";s:16:\"wi wi-user-group\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";a:7:{i:0;a:2:{s:5:\"title\";s:12:\"编辑用户\";s:15:\"permission_name\";s:16:\"system_user_post\";}i:1;a:2:{s:5:\"title\";s:12:\"审核用户\";s:15:\"permission_name\";s:17:\"system_user_check\";}i:2;a:2:{s:5:\"title\";s:12:\"店员管理\";s:15:\"permission_name\";s:17:\"system_user_clerk\";}i:3;a:2:{s:5:\"title\";s:15:\"用户回收站\";s:15:\"permission_name\";s:19:\"system_user_recycle\";}i:4;a:2:{s:5:\"title\";s:18:\"用户属性设置\";s:15:\"permission_name\";s:18:\"system_user_fields\";}i:5;a:2:{s:5:\"title\";s:31:\"用户属性设置-编辑字段\";s:15:\"permission_name\";s:23:\"system_user_fields_post\";}i:6;a:2:{s:5:\"title\";s:18:\"用户注册设置\";s:15:\"permission_name\";s:23:\"system_user_registerset\";}}}s:25:\"system_user_founder_group\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"副创始人组\";s:3:\"url\";s:32:\"./index.php?c=founder&a=display&\";s:15:\"permission_name\";s:21:\"system_founder_manage\";s:4:\"icon\";s:16:\"wi wi-co-founder\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";a:6:{i:0;a:2:{s:5:\"title\";s:18:\"添加创始人组\";s:15:\"permission_name\";s:24:\"system_founder_group_add\";}i:1;a:2:{s:5:\"title\";s:18:\"编辑创始人组\";s:15:\"permission_name\";s:25:\"system_founder_group_post\";}i:2;a:2:{s:5:\"title\";s:18:\"删除创始人组\";s:15:\"permission_name\";s:24:\"system_founder_group_del\";}i:3;a:2:{s:5:\"title\";s:15:\"添加创始人\";s:15:\"permission_name\";s:23:\"system_founder_user_add\";}i:4;a:2:{s:5:\"title\";s:15:\"编辑创始人\";s:15:\"permission_name\";s:24:\"system_founder_user_post\";}i:5;a:2:{s:5:\"title\";s:15:\"删除创始人\";s:15:\"permission_name\";s:23:\"system_founder_user_del\";}}}}}s:10:\"permission\";a:2:{s:5:\"title\";s:12:\"权限管理\";s:4:\"menu\";a:2:{s:19:\"system_module_group\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"应用权限组\";s:3:\"url\";s:29:\"./index.php?c=module&a=group&\";s:15:\"permission_name\";s:19:\"system_module_group\";s:4:\"icon\";s:21:\"wi wi-appjurisdiction\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";a:3:{i:0;a:2:{s:5:\"title\";s:21:\"添加应用权限组\";s:15:\"permission_name\";s:23:\"system_module_group_add\";}i:1;a:2:{s:5:\"title\";s:21:\"编辑应用权限组\";s:15:\"permission_name\";s:24:\"system_module_group_post\";}i:2;a:2:{s:5:\"title\";s:21:\"删除应用权限组\";s:15:\"permission_name\";s:23:\"system_module_group_del\";}}}s:17:\"system_user_group\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"用户权限组\";s:3:\"url\";s:27:\"./index.php?c=user&a=group&\";s:15:\"permission_name\";s:17:\"system_user_group\";s:4:\"icon\";s:22:\"wi wi-userjurisdiction\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";a:3:{i:0;a:2:{s:5:\"title\";s:15:\"添加用户组\";s:15:\"permission_name\";s:21:\"system_user_group_add\";}i:1;a:2:{s:5:\"title\";s:15:\"编辑用户组\";s:15:\"permission_name\";s:22:\"system_user_group_post\";}i:2;a:2:{s:5:\"title\";s:15:\"删除用户组\";s:15:\"permission_name\";s:21:\"system_user_group_del\";}}}}}s:7:\"article\";a:2:{s:5:\"title\";s:13:\"文章/公告\";s:4:\"menu\";a:2:{s:14:\"system_article\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"文章管理\";s:3:\"url\";s:29:\"./index.php?c=article&a=news&\";s:15:\"permission_name\";s:19:\"system_article_news\";s:4:\"icon\";s:13:\"wi wi-article\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:21:\"system_article_notice\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"公告管理\";s:3:\"url\";s:31:\"./index.php?c=article&a=notice&\";s:15:\"permission_name\";s:21:\"system_article_notice\";s:4:\"icon\";s:12:\"wi wi-notice\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:5:\"cache\";a:2:{s:5:\"title\";s:6:\"缓存\";s:4:\"menu\";a:1:{s:26:\"system_setting_updatecache\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"更新缓存\";s:3:\"url\";s:35:\"./index.php?c=system&a=updatecache&\";s:15:\"permission_name\";s:26:\"system_setting_updatecache\";s:4:\"icon\";s:12:\"wi wi-update\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}}s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:4;}s:4:\"site\";a:8:{s:5:\"title\";s:12:\"站点管理\";s:4:\"icon\";s:17:\"wi wi-system-site\";s:3:\"url\";s:30:\"./index.php?c=cloud&a=upgrade&\";s:7:\"section\";a:4:{s:5:\"cloud\";a:2:{s:5:\"title\";s:9:\"云服务\";s:4:\"menu\";a:3:{s:14:\"system_profile\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"系统升级\";s:3:\"url\";s:30:\"./index.php?c=cloud&a=upgrade&\";s:15:\"permission_name\";s:20:\"system_cloud_upgrade\";s:4:\"icon\";s:11:\"wi wi-cache\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:21:\"system_cloud_register\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"注册站点\";s:3:\"url\";s:30:\"./index.php?c=cloud&a=profile&\";s:15:\"permission_name\";s:21:\"system_cloud_register\";s:4:\"icon\";s:18:\"wi wi-registersite\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:21:\"system_cloud_diagnose\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"云服务诊断\";s:3:\"url\";s:31:\"./index.php?c=cloud&a=diagnose&\";s:15:\"permission_name\";s:21:\"system_cloud_diagnose\";s:4:\"icon\";s:14:\"wi wi-diagnose\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:7:\"setting\";a:2:{s:5:\"title\";s:6:\"设置\";s:4:\"menu\";a:6:{s:19:\"system_setting_site\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"站点设置\";s:3:\"url\";s:28:\"./index.php?c=system&a=site&\";s:15:\"permission_name\";s:19:\"system_setting_site\";s:4:\"icon\";s:18:\"wi wi-site-setting\";s:12:\"displayorder\";i:6;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:19:\"system_setting_menu\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"菜单设置\";s:3:\"url\";s:28:\"./index.php?c=system&a=menu&\";s:15:\"permission_name\";s:19:\"system_setting_menu\";s:4:\"icon\";s:18:\"wi wi-menu-setting\";s:12:\"displayorder\";i:5;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:25:\"system_setting_attachment\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"附件设置\";s:3:\"url\";s:34:\"./index.php?c=system&a=attachment&\";s:15:\"permission_name\";s:25:\"system_setting_attachment\";s:4:\"icon\";s:16:\"wi wi-attachment\";s:12:\"displayorder\";i:4;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:25:\"system_setting_systeminfo\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"系统信息\";s:3:\"url\";s:34:\"./index.php?c=system&a=systeminfo&\";s:15:\"permission_name\";s:25:\"system_setting_systeminfo\";s:4:\"icon\";s:17:\"wi wi-system-info\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:19:\"system_setting_logs\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"查看日志\";s:3:\"url\";s:28:\"./index.php?c=system&a=logs&\";s:15:\"permission_name\";s:19:\"system_setting_logs\";s:4:\"icon\";s:9:\"wi wi-log\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:26:\"system_setting_ipwhitelist\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:11:\"IP白名单\";s:3:\"url\";s:35:\"./index.php?c=system&a=ipwhitelist&\";s:15:\"permission_name\";s:26:\"system_setting_ipwhitelist\";s:4:\"icon\";s:8:\"wi wi-ip\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:7:\"utility\";a:2:{s:5:\"title\";s:12:\"常用工具\";s:4:\"menu\";a:5:{s:24:\"system_utility_filecheck\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:18:\"系统文件校验\";s:3:\"url\";s:33:\"./index.php?c=system&a=filecheck&\";s:15:\"permission_name\";s:24:\"system_utility_filecheck\";s:4:\"icon\";s:10:\"wi wi-file\";s:12:\"displayorder\";i:5;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:23:\"system_utility_optimize\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"性能优化\";s:3:\"url\";s:32:\"./index.php?c=system&a=optimize&\";s:15:\"permission_name\";s:23:\"system_utility_optimize\";s:4:\"icon\";s:14:\"wi wi-optimize\";s:12:\"displayorder\";i:4;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:23:\"system_utility_database\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:9:\"数据库\";s:3:\"url\";s:32:\"./index.php?c=system&a=database&\";s:15:\"permission_name\";s:23:\"system_utility_database\";s:4:\"icon\";s:9:\"wi wi-sql\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:19:\"system_utility_scan\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"木马查杀\";s:3:\"url\";s:28:\"./index.php?c=system&a=scan&\";s:15:\"permission_name\";s:19:\"system_utility_scan\";s:4:\"icon\";s:12:\"wi wi-safety\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:18:\"system_utility_bom\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:15:\"检测文件BOM\";s:3:\"url\";s:27:\"./index.php?c=system&a=bom&\";s:15:\"permission_name\";s:18:\"system_utility_bom\";s:4:\"icon\";s:9:\"wi wi-bom\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:9:\"workorder\";a:2:{s:5:\"title\";s:12:\"工单系统\";s:4:\"menu\";a:1:{s:16:\"system_workorder\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"工单系统\";s:3:\"url\";s:44:\"./index.php?c=system&a=workorder&do=display&\";s:15:\"permission_name\";s:16:\"system_workorder\";s:4:\"icon\";s:17:\"wi wi-system-work\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}}s:7:\"founder\";b:1;s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:5;}s:9:\"appmarket\";a:9:{s:5:\"title\";s:12:\"应用市场\";s:4:\"icon\";s:12:\"wi wi-market\";s:3:\"url\";s:25:\"https://0418it.taobao.com\";s:7:\"section\";a:0:{}s:5:\"blank\";b:1;s:7:\"founder\";b:1;s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:6;}s:4:\"help\";a:8:{s:5:\"title\";s:12:\"帮助系统\";s:4:\"icon\";s:12:\"wi wi-market\";s:3:\"url\";s:29:\"./index.php?c=help&a=display&\";s:7:\"section\";a:0:{}s:5:\"blank\";b:0;s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:7;}s:5:\"store\";a:7:{s:5:\"title\";s:6:\"商城\";s:4:\"icon\";s:11:\"wi wi-store\";s:3:\"url\";s:43:\"./index.php?c=home&a=welcome&do=ext&m=store\";s:7:\"section\";a:3:{s:11:\"store_goods\";a:2:{s:5:\"title\";s:12:\"商品分类\";s:4:\"menu\";a:1:{s:18:\"store_goods_module\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"应用模块\";s:3:\"url\";s:34:\"./index.php?c=store&a=goods-buyer&\";s:15:\"permission_name\";s:17:\"store_goods_buyer\";s:4:\"icon\";s:11:\"wi wi-goods\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:12:\"store_manage\";a:3:{s:5:\"title\";s:12:\"商城管理\";s:7:\"founder\";b:1;s:4:\"menu\";a:3:{s:18:\"store_manage_goods\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"添加商品\";s:3:\"url\";s:35:\"./index.php?c=store&a=goods-seller&\";s:15:\"permission_name\";s:18:\"store_manage_goods\";s:4:\"icon\";s:15:\"wi wi-goods-add\";s:12:\"displayorder\";i:3;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:20:\"store_manage_setting\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"商城设置\";s:3:\"url\";s:30:\"./index.php?c=store&a=setting&\";s:15:\"permission_name\";s:20:\"store_manage_setting\";s:4:\"icon\";s:11:\"wi wi-store\";s:12:\"displayorder\";i:2;s:2:\"id\";N;s:14:\"sub_permission\";N;}s:19:\"store_manage_payset\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"支付设置\";s:3:\"url\";s:29:\"./index.php?c=store&a=payset&\";s:15:\"permission_name\";s:19:\"store_manage_payset\";s:4:\"icon\";s:13:\"wi wi-account\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}s:12:\"store_orders\";a:2:{s:5:\"title\";s:12:\"订单管理\";s:4:\"menu\";a:1:{s:15:\"store_orders_my\";a:9:{s:9:\"is_system\";i:1;s:10:\"is_display\";i:1;s:5:\"title\";s:12:\"我的订单\";s:3:\"url\";s:29:\"./index.php?c=store&a=orders&\";s:15:\"permission_name\";s:15:\"store_orders_my\";s:4:\"icon\";s:17:\"wi wi-sale-record\";s:12:\"displayorder\";i:1;s:2:\"id\";N;s:14:\"sub_permission\";N;}}}}s:9:\"is_system\";b:1;s:10:\"is_display\";b:1;s:12:\"displayorder\";i:8;}}'),
('module_receive_enable', 'a:0:{}'),
('unisetting:2', 'b:0;'),
('uniaccount:2', 'a:24:{s:4:\"acid\";s:1:\"2\";s:7:\"uniacid\";s:1:\"2\";s:5:\"token\";s:32:\"tLLbbnlaTtwybzfsqW1B147N14Y6F6LL\";s:14:\"encodingaeskey\";s:43:\"EuQJW2uWJYM00JPB32WWBJR720ZFfYJqb2jJW2UMH33\";s:5:\"level\";s:1:\"1\";s:7:\"account\";s:0:\"\";s:8:\"original\";s:0:\"\";s:3:\"key\";s:18:\"wx58ebcc18261e55f9\";s:6:\"secret\";s:32:\"779fff427ac78cf59391fea71f33cb99\";s:4:\"name\";s:9:\"镇镇通\";s:4:\"type\";s:1:\"4\";s:9:\"isconnect\";s:1:\"1\";s:9:\"isdeleted\";s:1:\"0\";s:3:\"uid\";s:1:\"2\";s:9:\"starttime\";s:10:\"1513591629\";s:7:\"endtime\";s:10:\"1548151629\";s:6:\"groups\";a:0:{}s:7:\"setting\";a:0:{}s:10:\"grouplevel\";N;s:4:\"logo\";s:68:\"https://tongcheng.iweiji.cc/attachment/headimg_2.jpg?time=1514618953\";s:6:\"qrcode\";s:67:\"https://tongcheng.iweiji.cc/attachment/qrcode_2.jpg?time=1514618953\";s:9:\"switchurl\";s:51:\"./index.php?c=account&a=display&do=switch&uniacid=2\";s:3:\"sms\";i:0;s:7:\"setmeal\";a:5:{s:3:\"uid\";s:1:\"2\";s:8:\"username\";s:9:\"镇镇通\";s:7:\"groupid\";s:1:\"1\";s:9:\"groupname\";s:9:\"镇镇通\";s:9:\"timelimit\";s:21:\"2017-12-18~2019-01-22\";}}'),
('we7:2:site_store_buy_modules', 'a:0:{}'),
('we7:uni_group', 'a:2:{i:2;a:7:{s:2:\"id\";s:1:\"2\";s:9:\"owner_uid\";s:1:\"0\";s:4:\"name\";s:15:\"同城小程序\";s:7:\"modules\";a:1:{s:10:\"yc_youliao\";a:28:{s:3:\"mid\";s:2:\"12\";s:4:\"name\";s:10:\"yc_youliao\";s:4:\"type\";s:8:\"business\";s:5:\"title\";s:12:\"同城社区\";s:7:\"version\";s:6:\"6.1.95\";s:7:\"ability\";s:27:\"同城论坛，同城生活\";s:11:\"description\";s:18:\"同城生活便民\";s:6:\"author\";s:12:\"同城社区\";s:3:\"url\";s:21:\"https://www.iweiji.cc\";s:8:\"settings\";s:1:\"1\";s:10:\"subscribes\";a:0:{}s:7:\"handles\";a:1:{i:0;s:4:\"text\";}s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"0\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:6:\"a:0:{}\";s:13:\"title_initial\";s:1:\"M\";s:13:\"wxapp_support\";s:1:\"2\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:74:\"https://tongcheng.iweiji.cc/addons/yc_youliao/icon-custom.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:1;s:6:\"config\";a:0:{}s:7:\"enabled\";i:1;s:8:\"shortcut\";N;}}s:9:\"templates\";s:0:\"\";s:7:\"uniacid\";s:1:\"0\";s:5:\"wxapp\";a:1:{s:10:\"yc_youliao\";a:28:{s:3:\"mid\";s:2:\"12\";s:4:\"name\";s:10:\"yc_youliao\";s:4:\"type\";s:8:\"business\";s:5:\"title\";s:12:\"同城社区\";s:7:\"version\";s:6:\"6.1.95\";s:7:\"ability\";s:27:\"同城论坛，同城生活\";s:11:\"description\";s:18:\"同城生活便民\";s:6:\"author\";s:12:\"同城社区\";s:3:\"url\";s:21:\"https://www.iweiji.cc\";s:8:\"settings\";s:1:\"1\";s:10:\"subscribes\";a:0:{}s:7:\"handles\";a:1:{i:0;s:4:\"text\";}s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"0\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:6:\"a:0:{}\";s:13:\"title_initial\";s:1:\"M\";s:13:\"wxapp_support\";s:1:\"2\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:74:\"https://tongcheng.iweiji.cc/addons/yc_youliao/icon-custom.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:1;s:6:\"config\";a:0:{}s:7:\"enabled\";i:1;s:8:\"shortcut\";N;}}}i:1;a:7:{s:2:\"id\";s:1:\"1\";s:9:\"owner_uid\";s:1:\"0\";s:4:\"name\";s:18:\"体验套餐服务\";s:7:\"modules\";a:1:{s:10:\"yc_youliao\";a:28:{s:3:\"mid\";s:2:\"12\";s:4:\"name\";s:10:\"yc_youliao\";s:4:\"type\";s:8:\"business\";s:5:\"title\";s:12:\"同城社区\";s:7:\"version\";s:6:\"6.1.95\";s:7:\"ability\";s:27:\"同城论坛，同城生活\";s:11:\"description\";s:18:\"同城生活便民\";s:6:\"author\";s:12:\"同城社区\";s:3:\"url\";s:21:\"https://www.iweiji.cc\";s:8:\"settings\";s:1:\"1\";s:10:\"subscribes\";a:0:{}s:7:\"handles\";a:1:{i:0;s:4:\"text\";}s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"0\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:6:\"a:0:{}\";s:13:\"title_initial\";s:1:\"M\";s:13:\"wxapp_support\";s:1:\"2\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:74:\"https://tongcheng.iweiji.cc/addons/yc_youliao/icon-custom.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:1;s:6:\"config\";a:0:{}s:7:\"enabled\";i:1;s:8:\"shortcut\";N;}}s:9:\"templates\";s:2:\"N;\";s:7:\"uniacid\";s:1:\"0\";s:5:\"wxapp\";a:1:{s:10:\"yc_youliao\";a:28:{s:3:\"mid\";s:2:\"12\";s:4:\"name\";s:10:\"yc_youliao\";s:4:\"type\";s:8:\"business\";s:5:\"title\";s:12:\"同城社区\";s:7:\"version\";s:6:\"6.1.95\";s:7:\"ability\";s:27:\"同城论坛，同城生活\";s:11:\"description\";s:18:\"同城生活便民\";s:6:\"author\";s:12:\"同城社区\";s:3:\"url\";s:21:\"https://www.iweiji.cc\";s:8:\"settings\";s:1:\"1\";s:10:\"subscribes\";a:0:{}s:7:\"handles\";a:1:{i:0;s:4:\"text\";}s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"0\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:6:\"a:0:{}\";s:13:\"title_initial\";s:1:\"M\";s:13:\"wxapp_support\";s:1:\"2\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:74:\"https://tongcheng.iweiji.cc/addons/yc_youliao/icon-custom.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:1;s:6:\"config\";a:0:{}s:7:\"enabled\";i:1;s:8:\"shortcut\";N;}}}}'),
('we7:user_modules:2', 'a:12:{i:0;s:10:\"yc_youliao\";i:1;s:6:\"wxcard\";i:2;s:5:\"chats\";i:3;s:5:\"voice\";i:4;s:5:\"video\";i:5;s:6:\"images\";i:6;s:6:\"custom\";i:7;s:8:\"recharge\";i:8;s:7:\"userapi\";i:9;s:5:\"music\";i:10;s:4:\"news\";i:11;s:5:\"basic\";}'),
('we7:module_info:wxcard', 'a:25:{s:3:\"mid\";s:2:\"11\";s:4:\"name\";s:6:\"wxcard\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"微信卡券回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:18:\"微信卡券回复\";s:11:\"description\";s:18:\"微信卡券回复\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:63:\"https://tongcheng.iweiji.cc/addons/wxcard/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:chats', 'a:25:{s:3:\"mid\";s:2:\"10\";s:4:\"name\";s:5:\"chats\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"发送客服消息\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:77:\"公众号可以在粉丝最后发送消息的48小时内无限制发送消息\";s:11:\"description\";s:0:\"\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"0\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:62:\"https://tongcheng.iweiji.cc/addons/chats/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:voice', 'a:25:{s:3:\"mid\";s:1:\"9\";s:4:\"name\";s:5:\"voice\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"基本语音回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:18:\"提供语音回复\";s:11:\"description\";s:132:\"在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:62:\"https://tongcheng.iweiji.cc/addons/voice/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:video', 'a:25:{s:3:\"mid\";s:1:\"8\";s:4:\"name\";s:5:\"video\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"基本视频回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:18:\"提供图片回复\";s:11:\"description\";s:132:\"在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:62:\"https://tongcheng.iweiji.cc/addons/video/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:images', 'a:25:{s:3:\"mid\";s:1:\"7\";s:4:\"name\";s:6:\"images\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"基本图片回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:18:\"提供图片回复\";s:11:\"description\";s:132:\"在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:63:\"https://tongcheng.iweiji.cc/addons/images/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:custom', 'a:25:{s:3:\"mid\";s:1:\"6\";s:4:\"name\";s:6:\"custom\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:15:\"多客服转接\";s:7:\"version\";s:5:\"1.0.0\";s:7:\"ability\";s:36:\"用来接入腾讯的多客服系统\";s:11:\"description\";s:0:\"\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:17:\"http://bbs.we7.cc\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";a:0:{}s:7:\"handles\";a:6:{i:0;s:5:\"image\";i:1;s:5:\"voice\";i:2;s:5:\"video\";i:3;s:8:\"location\";i:4;s:4:\"link\";i:5;s:4:\"text\";}s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:63:\"https://tongcheng.iweiji.cc/addons/custom/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:recharge', 'a:25:{s:3:\"mid\";s:1:\"5\";s:4:\"name\";s:8:\"recharge\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:24:\"会员中心充值模块\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:24:\"提供会员充值功能\";s:11:\"description\";s:0:\"\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"0\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:65:\"https://tongcheng.iweiji.cc/addons/recharge/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:userapi', 'a:25:{s:3:\"mid\";s:1:\"4\";s:4:\"name\";s:7:\"userapi\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:21:\"自定义接口回复\";s:7:\"version\";s:3:\"1.1\";s:7:\"ability\";s:33:\"更方便的第三方接口设置\";s:11:\"description\";s:141:\"自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:64:\"https://tongcheng.iweiji.cc/addons/userapi/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:music', 'a:25:{s:3:\"mid\";s:1:\"3\";s:4:\"name\";s:5:\"music\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"基本音乐回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:39:\"提供语音、音乐等音频类回复\";s:11:\"description\";s:183:\"在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:62:\"https://tongcheng.iweiji.cc/addons/music/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:news', 'a:25:{s:3:\"mid\";s:1:\"2\";s:4:\"name\";s:4:\"news\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:24:\"基本混合图文回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:33:\"为你提供生动的图文资讯\";s:11:\"description\";s:272:\"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:61:\"https://tongcheng.iweiji.cc/addons/news/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:module_info:basic', 'a:25:{s:3:\"mid\";s:1:\"1\";s:4:\"name\";s:5:\"basic\";s:4:\"type\";s:6:\"system\";s:5:\"title\";s:18:\"基本文字回复\";s:7:\"version\";s:3:\"1.0\";s:7:\"ability\";s:24:\"和您进行简单对话\";s:11:\"description\";s:201:\"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.\";s:6:\"author\";s:13:\"WeEngine Team\";s:3:\"url\";s:18:\"http://www.we7.cc/\";s:8:\"settings\";s:1:\"0\";s:10:\"subscribes\";s:0:\"\";s:7:\"handles\";s:0:\"\";s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"1\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:0:\"\";s:13:\"title_initial\";s:0:\"\";s:13:\"wxapp_support\";s:1:\"1\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:62:\"https://tongcheng.iweiji.cc/addons/basic/icon.jpg?v=1513722739\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:0;}'),
('we7:unimodules:2:', 'a:12:{s:5:\"basic\";a:1:{s:4:\"name\";s:5:\"basic\";}s:4:\"news\";a:1:{s:4:\"name\";s:4:\"news\";}s:5:\"music\";a:1:{s:4:\"name\";s:5:\"music\";}s:7:\"userapi\";a:1:{s:4:\"name\";s:7:\"userapi\";}s:8:\"recharge\";a:1:{s:4:\"name\";s:8:\"recharge\";}s:6:\"custom\";a:1:{s:4:\"name\";s:6:\"custom\";}s:6:\"images\";a:1:{s:4:\"name\";s:6:\"images\";}s:5:\"video\";a:1:{s:4:\"name\";s:5:\"video\";}s:5:\"voice\";a:1:{s:4:\"name\";s:5:\"voice\";}s:5:\"chats\";a:1:{s:4:\"name\";s:5:\"chats\";}s:6:\"wxcard\";a:1:{s:4:\"name\";s:6:\"wxcard\";}s:10:\"yc_youliao\";a:1:{s:4:\"name\";s:10:\"yc_youliao\";}}'),
('we7:unimodules:2:1', 'a:12:{s:5:\"basic\";a:1:{s:4:\"name\";s:5:\"basic\";}s:4:\"news\";a:1:{s:4:\"name\";s:4:\"news\";}s:5:\"music\";a:1:{s:4:\"name\";s:5:\"music\";}s:7:\"userapi\";a:1:{s:4:\"name\";s:7:\"userapi\";}s:8:\"recharge\";a:1:{s:4:\"name\";s:8:\"recharge\";}s:6:\"custom\";a:1:{s:4:\"name\";s:6:\"custom\";}s:6:\"images\";a:1:{s:4:\"name\";s:6:\"images\";}s:5:\"video\";a:1:{s:4:\"name\";s:5:\"video\";}s:5:\"voice\";a:1:{s:4:\"name\";s:5:\"voice\";}s:5:\"chats\";a:1:{s:4:\"name\";s:5:\"chats\";}s:6:\"wxcard\";a:1:{s:4:\"name\";s:6:\"wxcard\";}s:10:\"yc_youliao\";a:1:{s:4:\"name\";s:10:\"yc_youliao\";}}'),
('we7:lastaccount:r3232', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('we7:user_modules:1', 'a:12:{i:0;s:10:\"yc_youliao\";i:1;s:6:\"wxcard\";i:2;s:5:\"chats\";i:3;s:5:\"voice\";i:4;s:5:\"video\";i:5;s:6:\"images\";i:6;s:6:\"custom\";i:7;s:8:\"recharge\";i:8;s:7:\"userapi\";i:9;s:5:\"music\";i:10;s:4:\"news\";i:11;s:5:\"basic\";}'),
('we7:module:all_uninstall', 'a:2:{s:6:\"expire\";i:1515480233;s:4:\"data\";a:4:{s:13:\"cloud_m_count\";N;s:7:\"modules\";a:2:{s:7:\"recycle\";a:0:{}s:11:\"uninstalled\";a:1:{s:3:\"app\";a:1:{s:10:\"we7_coupon\";a:8:{s:4:\"from\";s:5:\"local\";s:4:\"name\";s:10:\"we7_coupon\";s:7:\"version\";s:3:\"5.2\";s:5:\"title\";s:12:\"系统卡券\";s:11:\"app_support\";i:2;s:13:\"wxapp_support\";i:1;s:11:\"main_module\";s:0:\"\";s:15:\"upgrade_support\";b:0;}}}}s:9:\"app_count\";i:1;s:11:\"wxapp_count\";i:0;}}'),
('unicount:2', 's:1:\"0\";'),
('we7::site_store_buy_modules', 'a:0:{}'),
('we7:unimodules::', 'a:12:{s:5:\"basic\";a:1:{s:4:\"name\";s:5:\"basic\";}s:4:\"news\";a:1:{s:4:\"name\";s:4:\"news\";}s:5:\"music\";a:1:{s:4:\"name\";s:5:\"music\";}s:7:\"userapi\";a:1:{s:4:\"name\";s:7:\"userapi\";}s:8:\"recharge\";a:1:{s:4:\"name\";s:8:\"recharge\";}s:6:\"custom\";a:1:{s:4:\"name\";s:6:\"custom\";}s:6:\"images\";a:1:{s:4:\"name\";s:6:\"images\";}s:5:\"video\";a:1:{s:4:\"name\";s:5:\"video\";}s:5:\"voice\";a:1:{s:4:\"name\";s:5:\"voice\";}s:5:\"chats\";a:1:{s:4:\"name\";s:5:\"chats\";}s:6:\"wxcard\";a:1:{s:4:\"name\";s:6:\"wxcard\";}s:10:\"yc_youliao\";a:1:{s:4:\"name\";s:10:\"yc_youliao\";}}'),
('account:component:assesstoken', 'a:2:{s:5:\"value\";s:156:\"5_vrFEQJkNVuWw3afzrLIId0VAAM0FV_8eDAIdxjXfHRyC6nczHhhJFD9IgzoKEkv3Gtkkr_tYuPR9num2wqlcddMiGwDolehhJNFKS4SPSr1loOQz0CJ16SkQnGGMNoJi8JznEYWWZvCYWbfkGUJbAIAMAP\";s:6:\"expire\";i:1515470745;}'),
('account:preauthcode', 'a:2:{s:5:\"value\";s:78:\"preauthcode@@@hfUpI4NaAKIvnCZ-Hx8rKiuzbO0ygsZhSYPjd9tbsfnwbZEhXUHSIQhBxPIxHIbU\";s:6:\"expire\";i:1515471696;}'),
('we7:unimodules::1', 'a:12:{s:5:\"basic\";a:1:{s:4:\"name\";s:5:\"basic\";}s:4:\"news\";a:1:{s:4:\"name\";s:4:\"news\";}s:5:\"music\";a:1:{s:4:\"name\";s:5:\"music\";}s:7:\"userapi\";a:1:{s:4:\"name\";s:7:\"userapi\";}s:8:\"recharge\";a:1:{s:4:\"name\";s:8:\"recharge\";}s:6:\"custom\";a:1:{s:4:\"name\";s:6:\"custom\";}s:6:\"images\";a:1:{s:4:\"name\";s:6:\"images\";}s:5:\"video\";a:1:{s:4:\"name\";s:5:\"video\";}s:5:\"voice\";a:1:{s:4:\"name\";s:5:\"voice\";}s:5:\"chats\";a:1:{s:4:\"name\";s:5:\"chats\";}s:6:\"wxcard\";a:1:{s:4:\"name\";s:6:\"wxcard\";}s:10:\"yc_youliao\";a:1:{s:4:\"name\";s:10:\"yc_youliao\";}}'),
('we7:lastaccount:pROZN', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('accesstoken:wx947f9a4f36f5884a', 'a:2:{s:5:\"token\";s:156:\"5_D7TMmg9h7ckyzUht-u_iumeaEjDg4OIuxdKSVHZaU0xH7Vb5zRCigseP-tHrq0ky0YKGeIr_qVAvOlrcp8nqr9NkA21Mm7jWye-KfLaNOVtT7OjaasVl_eWWur5U_D-W02lVHVcPU9RHh-pMNFDdAHAGYW\";s:6:\"expire\";i:1514623476;}'),
('we7:lastaccount:h6h16', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('unicount:', 's:1:\"0\";'),
('we7:lastaccount:Iw3c9', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('we7:module_info:yc_youliao', 'a:25:{s:3:\"mid\";s:2:\"12\";s:4:\"name\";s:10:\"yc_youliao\";s:4:\"type\";s:8:\"business\";s:5:\"title\";s:12:\"同城社区\";s:7:\"version\";s:6:\"6.1.95\";s:7:\"ability\";s:27:\"同城论坛，同城生活\";s:11:\"description\";s:18:\"同城生活便民\";s:6:\"author\";s:12:\"同城社区\";s:3:\"url\";s:21:\"https://www.iweiji.cc\";s:8:\"settings\";s:1:\"1\";s:10:\"subscribes\";a:0:{}s:7:\"handles\";a:1:{i:0;s:4:\"text\";}s:12:\"isrulefields\";s:1:\"1\";s:8:\"issystem\";s:1:\"0\";s:6:\"target\";s:1:\"0\";s:6:\"iscard\";s:1:\"0\";s:11:\"permissions\";s:6:\"a:0:{}\";s:13:\"title_initial\";s:1:\"M\";s:13:\"wxapp_support\";s:1:\"2\";s:11:\"app_support\";s:1:\"2\";s:9:\"isdisplay\";i:1;s:4:\"logo\";s:74:\"https://tongcheng.iweiji.cc/addons/yc_youliao/icon-custom.jpg?v=1514617564\";s:11:\"main_module\";b:0;s:11:\"plugin_list\";a:0:{}s:11:\"is_relation\";b:1;}'),
('we7:module_setting:2:yc_youliao', 'a:7:{s:2:\"id\";s:1:\"1\";s:7:\"uniacid\";s:1:\"2\";s:6:\"module\";s:10:\"yc_youliao\";s:7:\"enabled\";s:1:\"1\";s:8:\"settings\";s:2149:\"a:85:{s:8:\"in_money\";N;s:11:\"isredpacket\";s:1:\"0\";s:7:\"isshang\";s:1:\"0\";s:8:\"transfer\";s:0:\"\";s:12:\"transfer_min\";s:0:\"\";s:12:\"transfer_max\";s:0:\"\";s:13:\"transfer_user\";s:0:\"\";s:13:\"pay_type_user\";N;s:9:\"views_num\";s:0:\"\";s:9:\"shop_logo\";s:0:\"\";s:10:\"shop_bgpic\";s:0:\"\";s:10:\"shop_enter\";s:1:\"0\";s:16:\"shop_enter_price\";s:1:\"0\";s:14:\"one_year_money\";s:0:\"\";s:14:\"two_year_money\";s:0:\"\";s:16:\"three_year_money\";s:0:\"\";s:9:\"one_renew\";s:0:\"\";s:9:\"two_renew\";s:0:\"\";s:11:\"three_renew\";s:0:\"\";s:17:\"shop_transfer_min\";s:0:\"\";s:17:\"shop_transfer_max\";s:0:\"\";s:13:\"shop_pay_type\";N;s:8:\"contract\";s:0:\"\";s:16:\"shop_service_btn\";s:0:\"\";s:10:\"refundtime\";s:0:\"\";s:11:\"index_money\";N;s:10:\"time_money\";N;s:11:\"group_money\";N;s:7:\"balance\";s:1:\"0\";s:2:\"wx\";s:1:\"0\";s:9:\"showWater\";s:1:\"0\";s:10:\"issamecity\";s:1:\"0\";s:17:\"isautorefundgroup\";s:0:\"\";s:14:\"isreturncredit\";N;s:19:\"autocancelordertime\";s:0:\"\";s:17:\"remindmessagetime\";s:0:\"\";s:11:\"qrcode_flag\";i:0;s:4:\"help\";s:0:\"\";s:11:\"index_title\";s:5:\"21323\";s:6:\"footer\";s:18:\"<p>31232132132</p>\";s:12:\"comment_flag\";s:1:\"0\";s:10:\"disclaimer\";s:13:\"<p>213232</p>\";s:9:\"time_long\";N;s:7:\"qr_code\";N;s:11:\"share_title\";s:0:\"\";s:9:\"share_img\";s:0:\"\";s:10:\"share_info\";s:0:\"\";s:14:\"qiandao_random\";N;s:13:\"qiandao_jifen\";s:0:\"\";s:12:\"credit2money\";s:0:\"\";s:8:\"showShop\";N;s:11:\"showChannel\";N;s:14:\"showChannelNum\";s:0:\"\";s:7:\"istplon\";N;s:13:\"kefutplminute\";s:0:\"\";s:12:\"ring_creidit\";s:0:\"\";s:8:\"ring_num\";s:0:\"\";s:5:\"mapak\";s:0:\"\";s:11:\"service_btn\";s:0:\"\";s:12:\"service_link\";s:0:\"\";s:9:\"service_w\";s:0:\"\";s:9:\"service_h\";s:0:\"\";s:9:\"service_b\";s:0:\"\";s:9:\"service_l\";s:0:\"\";s:12:\"show_service\";s:1:\"0\";s:9:\"btn1_name\";s:6:\"首页\";s:9:\"btn1_link\";s:1:\"1\";s:4:\"btn1\";s:51:\"images/2/2017/12/i1BBUSzDvl8nc8826nvEXxU3E6vf1D.png\";s:10:\"btn1_hover\";s:0:\"\";s:9:\"btn2_name\";s:0:\"\";s:9:\"btn2_link\";s:0:\"\";s:4:\"btn2\";s:0:\"\";s:10:\"btn2_hover\";s:0:\"\";s:9:\"btn3_name\";s:0:\"\";s:9:\"btn3_link\";s:0:\"\";s:4:\"btn3\";s:0:\"\";s:10:\"btn3_hover\";s:0:\"\";s:9:\"btn4_name\";s:0:\"\";s:9:\"btn4_link\";s:0:\"\";s:4:\"btn4\";s:0:\"\";s:10:\"btn4_hover\";s:0:\"\";s:9:\"btn5_name\";s:0:\"\";s:9:\"btn5_link\";s:0:\"\";s:4:\"btn5\";s:0:\"\";s:10:\"btn5_hover\";s:0:\"\";}\";s:8:\"shortcut\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";}');
INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('we7:memberinfo:2', 'a:52:{s:3:\"uid\";s:1:\"2\";s:7:\"uniacid\";s:1:\"2\";s:6:\"mobile\";s:0:\"\";s:5:\"email\";s:39:\"d8a027afa04cac30294173f7489d1d55@we7.cc\";s:8:\"password\";s:32:\"647ed78db7c0a750ffcf39cc1efc8673\";s:4:\"salt\";s:8:\"qXt944SX\";s:7:\"groupid\";s:1:\"0\";s:7:\"credit1\";d:0;s:7:\"credit2\";d:0;s:7:\"credit3\";d:0;s:7:\"credit4\";d:0;s:7:\"credit5\";d:0;s:7:\"credit6\";d:0;s:10:\"createtime\";s:10:\"1514618953\";s:8:\"realname\";s:0:\"\";s:8:\"nickname\";s:0:\"\";s:6:\"avatar\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:3:\"vip\";s:1:\"0\";s:6:\"gender\";s:1:\"0\";s:9:\"birthyear\";s:1:\"0\";s:10:\"birthmonth\";s:1:\"0\";s:8:\"birthday\";s:1:\"0\";s:13:\"constellation\";s:0:\"\";s:6:\"zodiac\";s:0:\"\";s:9:\"telephone\";s:0:\"\";s:6:\"idcard\";s:0:\"\";s:9:\"studentid\";s:0:\"\";s:5:\"grade\";s:0:\"\";s:7:\"address\";s:0:\"\";s:7:\"zipcode\";s:0:\"\";s:11:\"nationality\";s:0:\"\";s:14:\"resideprovince\";s:0:\"\";s:10:\"residecity\";s:0:\"\";s:10:\"residedist\";s:0:\"\";s:14:\"graduateschool\";s:0:\"\";s:7:\"company\";s:0:\"\";s:9:\"education\";s:0:\"\";s:10:\"occupation\";s:0:\"\";s:8:\"position\";s:0:\"\";s:7:\"revenue\";s:0:\"\";s:15:\"affectivestatus\";s:0:\"\";s:10:\"lookingfor\";s:0:\"\";s:9:\"bloodtype\";s:0:\"\";s:6:\"height\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:6:\"alipay\";s:0:\"\";s:3:\"msn\";s:0:\"\";s:6:\"taobao\";s:0:\"\";s:4:\"site\";s:0:\"\";s:3:\"bio\";s:0:\"\";s:8:\"interest\";s:0:\"\";}'),
('accesstoken:wx58ebcc18261e55f9', 'a:2:{s:5:\"token\";s:156:\"5_KkV09ACrSX7XwFZwkoTCZCWOiag1PNRFTchwz2LMShpOmGf4a1UnHMHb1O7mKDDDs9--7XXg916LPHY6lIlm9BRsCs3bPA0IPKJs4wnTajZYJR7O7sLFLovFeBxNiP6yWqdxOGlbeqt07OCnHBPaAHAQKY\";s:6:\"expire\";i:1515470605;}'),
('1514619192CR-dnPAVQSA', 's:28:\"oKC7q0AX-SG5mIR8tFQ-IGGh3kJA\";'),
('we7:memberinfo:3', 'a:52:{s:3:\"uid\";s:1:\"3\";s:7:\"uniacid\";s:1:\"2\";s:6:\"mobile\";s:0:\"\";s:5:\"email\";s:39:\"d316c3a9f9aaa0f56971297e06a617f0@we7.cc\";s:8:\"password\";s:32:\"647ed78db7c0a750ffcf39cc1efc8673\";s:4:\"salt\";s:8:\"OdFoH9DF\";s:7:\"groupid\";s:1:\"0\";s:7:\"credit1\";d:0;s:7:\"credit2\";d:0;s:7:\"credit3\";d:0;s:7:\"credit4\";d:0;s:7:\"credit5\";d:0;s:7:\"credit6\";d:0;s:10:\"createtime\";s:10:\"1514619366\";s:8:\"realname\";s:0:\"\";s:8:\"nickname\";s:0:\"\";s:6:\"avatar\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:3:\"vip\";s:1:\"0\";s:6:\"gender\";s:1:\"0\";s:9:\"birthyear\";s:1:\"0\";s:10:\"birthmonth\";s:1:\"0\";s:8:\"birthday\";s:1:\"0\";s:13:\"constellation\";s:0:\"\";s:6:\"zodiac\";s:0:\"\";s:9:\"telephone\";s:0:\"\";s:6:\"idcard\";s:0:\"\";s:9:\"studentid\";s:0:\"\";s:5:\"grade\";s:0:\"\";s:7:\"address\";s:0:\"\";s:7:\"zipcode\";s:0:\"\";s:11:\"nationality\";s:0:\"\";s:14:\"resideprovince\";s:0:\"\";s:10:\"residecity\";s:0:\"\";s:10:\"residedist\";s:0:\"\";s:14:\"graduateschool\";s:0:\"\";s:7:\"company\";s:0:\"\";s:9:\"education\";s:0:\"\";s:10:\"occupation\";s:0:\"\";s:8:\"position\";s:0:\"\";s:7:\"revenue\";s:0:\"\";s:15:\"affectivestatus\";s:0:\"\";s:10:\"lookingfor\";s:0:\"\";s:9:\"bloodtype\";s:0:\"\";s:6:\"height\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:6:\"alipay\";s:0:\"\";s:3:\"msn\";s:0:\"\";s:6:\"taobao\";s:0:\"\";s:4:\"site\";s:0:\"\";s:3:\"bio\";s:0:\"\";s:8:\"interest\";s:0:\"\";}'),
('1514619400CR-V2Ve3joe', 's:28:\"oKC7q0BQvMcGX2TaS-uJMKwKaYP0\";'),
('we7:memberinfo:4', 'a:52:{s:3:\"uid\";s:1:\"4\";s:7:\"uniacid\";s:1:\"2\";s:6:\"mobile\";s:0:\"\";s:5:\"email\";s:39:\"3af905316a89966e0af9b946a70bbeb9@we7.cc\";s:8:\"password\";s:32:\"647ed78db7c0a750ffcf39cc1efc8673\";s:4:\"salt\";s:8:\"EEz931y7\";s:7:\"groupid\";s:1:\"0\";s:7:\"credit1\";d:0;s:7:\"credit2\";d:0;s:7:\"credit3\";d:0;s:7:\"credit4\";d:0;s:7:\"credit5\";d:0;s:7:\"credit6\";d:0;s:10:\"createtime\";s:10:\"1514620059\";s:8:\"realname\";s:0:\"\";s:8:\"nickname\";s:0:\"\";s:6:\"avatar\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:3:\"vip\";s:1:\"0\";s:6:\"gender\";s:1:\"0\";s:9:\"birthyear\";s:1:\"0\";s:10:\"birthmonth\";s:1:\"0\";s:8:\"birthday\";s:1:\"0\";s:13:\"constellation\";s:0:\"\";s:6:\"zodiac\";s:0:\"\";s:9:\"telephone\";s:0:\"\";s:6:\"idcard\";s:0:\"\";s:9:\"studentid\";s:0:\"\";s:5:\"grade\";s:0:\"\";s:7:\"address\";s:0:\"\";s:7:\"zipcode\";s:0:\"\";s:11:\"nationality\";s:0:\"\";s:14:\"resideprovince\";s:0:\"\";s:10:\"residecity\";s:0:\"\";s:10:\"residedist\";s:0:\"\";s:14:\"graduateschool\";s:0:\"\";s:7:\"company\";s:0:\"\";s:9:\"education\";s:0:\"\";s:10:\"occupation\";s:0:\"\";s:8:\"position\";s:0:\"\";s:7:\"revenue\";s:0:\"\";s:15:\"affectivestatus\";s:0:\"\";s:10:\"lookingfor\";s:0:\"\";s:9:\"bloodtype\";s:0:\"\";s:6:\"height\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:6:\"alipay\";s:0:\"\";s:3:\"msn\";s:0:\"\";s:6:\"taobao\";s:0:\"\";s:4:\"site\";s:0:\"\";s:3:\"bio\";s:0:\"\";s:8:\"interest\";s:0:\"\";}'),
('1514620280CR-Pe5YMhYu', 's:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";'),
('1514630524CR-fGuzZTyL', 's:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";'),
('1514649138CR-dBz3K2GJ', 's:28:\"oKC7q0AX-SG5mIR8tFQ-IGGh3kJA\";'),
('we7:lastaccount:K8o6G', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";i:2;}'),
('we7:memberinfo:6', 'a:52:{s:3:\"uid\";s:1:\"6\";s:7:\"uniacid\";s:1:\"2\";s:6:\"mobile\";s:0:\"\";s:5:\"email\";s:39:\"0963a2f97d1cfde4ddf58f857c5f2f42@we7.cc\";s:8:\"password\";s:32:\"647ed78db7c0a750ffcf39cc1efc8673\";s:4:\"salt\";s:8:\"ve8Zxux2\";s:7:\"groupid\";s:1:\"0\";s:7:\"credit1\";d:0;s:7:\"credit2\";d:0;s:7:\"credit3\";d:0;s:7:\"credit4\";d:0;s:7:\"credit5\";d:0;s:7:\"credit6\";d:0;s:10:\"createtime\";s:10:\"1515034909\";s:8:\"realname\";s:0:\"\";s:8:\"nickname\";s:0:\"\";s:6:\"avatar\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:3:\"vip\";s:1:\"0\";s:6:\"gender\";s:1:\"0\";s:9:\"birthyear\";s:1:\"0\";s:10:\"birthmonth\";s:1:\"0\";s:8:\"birthday\";s:1:\"0\";s:13:\"constellation\";s:0:\"\";s:6:\"zodiac\";s:0:\"\";s:9:\"telephone\";s:0:\"\";s:6:\"idcard\";s:0:\"\";s:9:\"studentid\";s:0:\"\";s:5:\"grade\";s:0:\"\";s:7:\"address\";s:0:\"\";s:7:\"zipcode\";s:0:\"\";s:11:\"nationality\";s:0:\"\";s:14:\"resideprovince\";s:0:\"\";s:10:\"residecity\";s:0:\"\";s:10:\"residedist\";s:0:\"\";s:14:\"graduateschool\";s:0:\"\";s:7:\"company\";s:0:\"\";s:9:\"education\";s:0:\"\";s:10:\"occupation\";s:0:\"\";s:8:\"position\";s:0:\"\";s:7:\"revenue\";s:0:\"\";s:15:\"affectivestatus\";s:0:\"\";s:10:\"lookingfor\";s:0:\"\";s:9:\"bloodtype\";s:0:\"\";s:6:\"height\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:6:\"alipay\";s:0:\"\";s:3:\"msn\";s:0:\"\";s:6:\"taobao\";s:0:\"\";s:4:\"site\";s:0:\"\";s:3:\"bio\";s:0:\"\";s:8:\"interest\";s:0:\"\";}'),
('1515034999CR-xjPr2FFH', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515035619CR-pziPxYug', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515036849CR-OdYFXBye', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515047715CR-cxJJnDBR', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515049255CR-qFIG0Mnr', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515049435CR-4yFINS2n', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515054145CR-HZGonYsw', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515076229CR-uc3MzWjf', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515204514CR-dJK0ekwq', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('we7:lastaccount:X59i7', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('1515384048CR-Zy1n0syK', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515384461CR-afYTPzmo', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515384532CR-4OiW15IW', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515399883CR-PJYwB4xg', 's:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";'),
('1515399883CR-FdVEufKw', 's:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";'),
('1515399883CR-UtXse1vl', 's:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";'),
('1515399953CR-T2t0OlbX', 's:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";'),
('we7:memberinfo:7', 'a:52:{s:3:\"uid\";s:1:\"7\";s:7:\"uniacid\";s:1:\"2\";s:6:\"mobile\";s:0:\"\";s:5:\"email\";s:39:\"a6fbff910bfd1d80608111db8f64ac09@we7.cc\";s:8:\"password\";s:32:\"647ed78db7c0a750ffcf39cc1efc8673\";s:4:\"salt\";s:8:\"PL4506k5\";s:7:\"groupid\";s:1:\"0\";s:7:\"credit1\";d:0;s:7:\"credit2\";d:0;s:7:\"credit3\";d:0;s:7:\"credit4\";d:0;s:7:\"credit5\";d:0;s:7:\"credit6\";d:0;s:10:\"createtime\";s:10:\"1515400000\";s:8:\"realname\";s:0:\"\";s:8:\"nickname\";s:0:\"\";s:6:\"avatar\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:3:\"vip\";s:1:\"0\";s:6:\"gender\";s:1:\"0\";s:9:\"birthyear\";s:1:\"0\";s:10:\"birthmonth\";s:1:\"0\";s:8:\"birthday\";s:1:\"0\";s:13:\"constellation\";s:0:\"\";s:6:\"zodiac\";s:0:\"\";s:9:\"telephone\";s:0:\"\";s:6:\"idcard\";s:0:\"\";s:9:\"studentid\";s:0:\"\";s:5:\"grade\";s:0:\"\";s:7:\"address\";s:0:\"\";s:7:\"zipcode\";s:0:\"\";s:11:\"nationality\";s:0:\"\";s:14:\"resideprovince\";s:0:\"\";s:10:\"residecity\";s:0:\"\";s:10:\"residedist\";s:0:\"\";s:14:\"graduateschool\";s:0:\"\";s:7:\"company\";s:0:\"\";s:9:\"education\";s:0:\"\";s:10:\"occupation\";s:0:\"\";s:8:\"position\";s:0:\"\";s:7:\"revenue\";s:0:\"\";s:15:\"affectivestatus\";s:0:\"\";s:10:\"lookingfor\";s:0:\"\";s:9:\"bloodtype\";s:0:\"\";s:6:\"height\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:6:\"alipay\";s:0:\"\";s:3:\"msn\";s:0:\"\";s:6:\"taobao\";s:0:\"\";s:4:\"site\";s:0:\"\";s:3:\"bio\";s:0:\"\";s:8:\"interest\";s:0:\"\";}'),
('1515400253CR-cyJ5hYd9', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515401268CR-BoFRWjKs', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515401621CR-kqqHHWLP', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515401794CR-xvFy5Vyv', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515404553CR-qmdSTTOI', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515450778CR-kvUu63R6', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515463161CR-deBtOuXH', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('we7:lastaccount:U274X', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";i:2;}'),
('1515464885CR-qKBQSclS', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515464921CR-NS0TO0Ik', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('1515465139CR-SDqGJcKq', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('we7:lastaccount:l2A30', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";i:2;}'),
('we7:lastaccount:qx011', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('1515476500CR-eYtXZiqy', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";'),
('we7:lastaccount:auU39', 'a:2:{i:0;s:0:\"\";s:5:\"wxapp\";s:1:\"2\";}'),
('1515477821CR-O6Cmwlxu', 's:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";');

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_cron`
--

CREATE TABLE `ims_core_cron` (
  `id` int(10) UNSIGNED NOT NULL,
  `cloudid` int(10) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `lastruntime` int(10) UNSIGNED NOT NULL,
  `nextruntime` int(10) UNSIGNED NOT NULL,
  `weekday` tinyint(3) NOT NULL,
  `day` tinyint(3) NOT NULL,
  `hour` tinyint(3) NOT NULL,
  `minute` varchar(255) NOT NULL,
  `extra` varchar(5000) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_cron_record`
--

CREATE TABLE `ims_core_cron_record` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `tid` int(10) UNSIGNED NOT NULL,
  `note` varchar(500) NOT NULL,
  `tag` varchar(5000) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_menu`
--

CREATE TABLE `ims_core_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `title` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `append_title` varchar(30) NOT NULL,
  `append_url` varchar(255) NOT NULL,
  `displayorder` tinyint(3) UNSIGNED NOT NULL,
  `type` varchar(15) NOT NULL,
  `is_display` tinyint(3) UNSIGNED NOT NULL,
  `is_system` tinyint(3) UNSIGNED NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `icon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_core_menu`
--

INSERT INTO `ims_core_menu` (`id`, `pid`, `title`, `name`, `url`, `append_title`, `append_url`, `displayorder`, `type`, `is_display`, `is_system`, `permission_name`, `group_name`, `icon`) VALUES
(1, 0, '', '', '', '', '', 0, '', 0, 1, 'module', 'frame', '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_paylog`
--

CREATE TABLE `ims_core_paylog` (
  `plid` bigint(11) UNSIGNED NOT NULL,
  `type` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `acid` int(10) NOT NULL,
  `openid` varchar(40) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `tid` varchar(128) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `tag` varchar(2000) NOT NULL,
  `is_usecard` tinyint(3) UNSIGNED NOT NULL,
  `card_type` tinyint(3) UNSIGNED NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `card_fee` decimal(10,2) UNSIGNED NOT NULL,
  `encrypt_code` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_core_paylog`
--

INSERT INTO `ims_core_paylog` (`plid`, `type`, `uniacid`, `acid`, `openid`, `uniontid`, `tid`, `fee`, `status`, `module`, `tag`, `is_usecard`, `card_type`, `card_id`, `card_fee`, `encrypt_code`) VALUES
(1, 'credit1', 0, 0, 'oKC7q0AX-SG5mIR8tFQ-IGGh3kJA', '', '2017-12-30 15:31:49', '1.00', 0, 'yc_youliao', ' 签到1积分', 0, 0, '', '0.00', ''),
(2, 'credit1', 2, 0, 'oKC7q0BQvMcGX2TaS-uJMKwKaYP0', '', '2017-12-30 15:36:53', '1.00', 0, 'yc_youliao', ' 签到1积分', 0, 0, '', '0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_performance`
--

CREATE TABLE `ims_core_performance` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) NOT NULL,
  `runtime` varchar(10) NOT NULL,
  `runurl` varchar(512) NOT NULL,
  `runsql` varchar(512) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_queue`
--

CREATE TABLE `ims_core_queue` (
  `qid` bigint(20) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `message` varchar(2000) NOT NULL,
  `params` varchar(1000) NOT NULL,
  `keyword` varchar(1000) NOT NULL,
  `response` varchar(2000) NOT NULL,
  `module` varchar(50) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `dateline` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_refundlog`
--

CREATE TABLE `ims_core_refundlog` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `refund_uniontid` varchar(64) NOT NULL,
  `reason` varchar(80) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_resource`
--

CREATE TABLE `ims_core_resource` (
  `mid` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `media_id` varchar(100) NOT NULL,
  `trunk` int(10) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL,
  `dateline` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_sendsms_log`
--

CREATE TABLE `ims_core_sendsms_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `result` varchar(255) NOT NULL,
  `createtime` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_sessions`
--

CREATE TABLE `ims_core_sessions` (
  `sid` char(32) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL,
  `data` varchar(5000) NOT NULL,
  `expiretime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_core_sessions`
--

INSERT INTO `ims_core_sessions` (`sid`, `uniacid`, `openid`, `data`, `expiretime`) VALUES
('ed0083c60c3b69bbeaac3d4c349212f3', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"kOZi\";i:1514529481;}', 1514533081),
('a4ef6f9fa35d5486e5cc3ebbb25c41cf', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Z3iC\";i:1514529251;}', 1514532851),
('6357487afb892a70c9c61b0a0433b9f4', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"MOE8\";i:1514529250;}', 1514532850),
('c8a55da2bfc0b6515924572ca38fcabf', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"ZGJf\";i:1514528846;}', 1514532446),
('0c035a543f0a0bc4f0b436a3643991ee', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Uxnk\";i:1514528846;}', 1514532446),
('de6801ee97ed017123363f830952aa74', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"c9Ll\";i:1514525900;}', 1514529500),
('568691402087155101ee72e73b2e1d76', 2, '113.45.41.39', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"N60j\";i:1514529740;}', 1514533340),
('9d7c32b954470a5352996da3b660de4a', 2, '113.45.41.39', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"rVb4\";i:1514529741;}', 1514533341),
('9994304563aa4973c2995d289db8c3dc', 2, '113.45.41.39', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"f3lY\";i:1514529747;}', 1514533347),
('e697a1eaff5164251571ce7f0be95ac3', 2, '113.45.41.39', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"yT4T\";i:1514529748;}', 1514533348),
('165c2a8d35e09abd821985e9f3ac08d1', 2, '113.45.41.39', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Y33S\";i:1514529780;}', 1514533380),
('0adba929639691d3eb2f1dcf38fc77ab', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"o3dB\";i:1514530671;}', 1514534271),
('d3c22c666a787fe489733f125da31253', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Si5B\";i:1514530661;}', 1514534261),
('fc898d6c5e34d18b6fe67fe6f6f3c419', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"ixLH\";i:1514530651;}', 1514534251),
('10076a83c090c21b1ce8a109731bd88a', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"zrc4\";i:1514530641;}', 1514534241),
('7d6086b719650c6bf38924a9721c085b', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"P18z\";i:1514530631;}', 1514534231),
('f3c0d545c2e52bf6d3a9c9c0ed8be293', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"tN4n\";i:1514530621;}', 1514534221),
('77decbb47d4745efb1edab54349bd0e6', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"NWak\";i:1514530611;}', 1514534211),
('184a4ca63f01d8beb841c36a136785ff', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"smDn\";i:1514530601;}', 1514534201),
('d1a0fd5659038b8afc865813e29d83c9', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Zg0x\";i:1514530591;}', 1514534191),
('1791f398a6a8e3a23581c24999a33b98', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"d8BP\";i:1514530581;}', 1514534181),
('7462e52bf0eb6d0933edbbeb8ff9ad61', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"i8cL\";i:1514530571;}', 1514534171),
('dcb8b43c81e1e7b558e7eda6a8e97bca', 2, '211.159.173.101', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"vidO\";i:1514530560;}', 1514534160),
('233b89a3fea2f20ec6b0c5068a76bd61', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"REUD\";i:1514617120;}', 1514620720),
('7303a56b6d43f2a4dccc0e28569c44bc', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"c7n0\";i:1514617472;}', 1514621072),
('9d1580447b20fb5934a05f8ec8a1f775', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"e43p\";i:1514617472;}', 1514621072),
('d088f914f4671a694c9b3e7807305269', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"xAHW\";i:1514617472;}', 1514621072),
('7bccc7400edc26146a1304768ec2a931', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"njss\";i:1514617496;}', 1514621096),
('6db4d47367550aee7cabae5318ae52ed', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"T77b\";i:1514617570;}', 1514621170),
('803487e9b715139e9bf9aedf4006ea4f', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Jmkz\";i:1514617571;}', 1514621171),
('1512b0b3400fe4af26ea062d9f5d5d3c', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Wr7t\";i:1514617572;}', 1514621172),
('74c6a13b9dbddbc3905438857a50e2b5', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Not4\";i:1514617592;}', 1514621192),
('c40899abb649f23cfdfd65306195528d', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"n2ZK\";i:1514617878;}', 1514621478),
('bfacc870b78f6c86dc1290b8c5f13eae', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"a9oG\";i:1514617887;}', 1514621487),
('e00ce4a31dbc8415988fa32b0c3b7d17', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"oUFK\";i:1514617896;}', 1514621496),
('388a1fc151676d8b9ea3209258544653', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"T6r1\";i:1514617945;}', 1514621545),
('f70c7d17162919938566c28cdf9fcbfb', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"u3Zr\";i:1514618035;}', 1514621635),
('838d217b4f2e6ffd024646dc6c3437b6', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Uptj\";i:1514618035;}', 1514621635),
('f552e211048b9421d104b8d432477b42', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"N844\";i:1514618036;}', 1514621636),
('44e61e2ea7491bd6544787c7947f0cb0', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"RHJo\";i:1514618602;}', 1514622202),
('5d5cb2ec424c545f2bdb43e08869725d', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"X7oo\";i:1514618602;}', 1514622202),
('89c1166e99bbab272bf1ca7b34c1a25e', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"uGGD\";i:1514618604;}', 1514622204),
('a0eb200a715d7b6e8a00a237302b070c', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"ao1k\";i:1514618608;}', 1514622208),
('7c77c92c29ad6baa38a299287a12ca33', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"xxmm\";i:1514618608;}', 1514622208),
('7c1ca5494e5cd307133bd40c4ad23f4e', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:5:{s:4:\"LVYP\";i:1514618953;s:4:\"GLY4\";i:1514618954;s:4:\"Uxeq\";i:1514618954;s:4:\"PyLO\";i:1514619058;s:4:\"ngDQ\";i:1514619071;}openid|s:28:\"oKC7q0AX-SG5mIR8tFQ-IGGh3kJA\";session_key|s:24:\"8tnLzArnTGl1inrzbgZ/1g==\";uid|s:1:\"2\";', 1514622671),
('cebb0794343ad97ae741e2167bdc8590', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"n1uM\";i:1514649128;}', 1514652728),
('698745e7f910a3edcd0c80f9db0109bd', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:6:{s:4:\"ET4u\";i:1514649128;s:4:\"BTLS\";i:1514649129;s:4:\"Oa8A\";i:1514649129;s:4:\"Vt7z\";i:1514649136;s:4:\"EhQd\";i:1514649138;s:4:\"tplX\";i:1514649139;}openid|s:28:\"oKC7q0AX-SG5mIR8tFQ-IGGh3kJA\";session_key|s:24:\"Mfj8ZdoiiEbEtKUQipsbsg==\";uid|s:1:\"2\";', 1514652739),
('3eb8571c35195e6e518f696d452e774b', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"QRII\";i:1514619214;}', 1514622814),
('7ecd0f3f08bf299e7dea56a907a07fb7', 2, '112.39.196.23', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Vy29\";i:1514619214;}', 1514622814),
('a6227bb9919467cf5776c8e8d12671ce', 2, '112.39.197.204', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"DMfo\";i:1514804046;}', 1514807646),
('56fb86fb2201a3abcc9ab50d6a60bae4', 2, '112.39.197.204', 'acid|s:1:\"2\";uniacid|i:2;token|a:3:{s:4:\"p007\";i:1514804047;s:4:\"BjPH\";i:1514804047;s:4:\"ylXu\";i:1514804048;}openid|s:28:\"oKC7q0AX-SG5mIR8tFQ-IGGh3kJA\";session_key|s:24:\"H6q6sq/CVwEyYKsM/9Ns5Q==\";uid|s:1:\"2\";', 1514807648),
('d44c0de187ee3e492ebe4b7d8ffb0d17', 2, '121.35.100.30', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"p78G\";i:1514619360;}', 1514622960),
('57510bc58bbc69849e0fefdf1d8fab73', 2, '121.35.100.30', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"RjZK\";i:1514619360;}', 1514622960),
('1321d956d5c3867e96371cf3bab422ec', 2, '121.35.100.30', 'acid|s:1:\"2\";uniacid|i:2;token|a:6:{s:4:\"MUIg\";i:1514619509;s:4:\"RdFk\";i:1514619509;s:4:\"VR62\";i:1514619525;s:4:\"Rs6H\";i:1514619529;s:4:\"R8Mz\";i:1514619529;s:4:\"N58T\";i:1514619591;}openid|s:28:\"oKC7q0BQvMcGX2TaS-uJMKwKaYP0\";session_key|s:24:\"yi3sPMflkAXcsiHsAde/Uw==\";uid|s:1:\"3\";', 1514623191),
('218d6cde69de70ceb5ac48f66ace190e', 2, '110.96.148.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"BDCd\";i:1514704736;}', 1514708336),
('a0d8e40859287a24f58e083a04906ae3', 2, '110.96.148.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:3:{s:4:\"SiFI\";i:1514704737;s:4:\"KLEk\";i:1514704738;s:4:\"XIqZ\";i:1514704738;}openid|s:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";session_key|s:24:\"ihPtPNzYqMiwCdcER3+R/Q==\";uid|s:1:\"4\";', 1514708338),
('3e1456764e9c41186624cbdbb1415fec', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"v5C2\";i:1514620275;}', 1514623875),
('cacd6858bf9b3a11e93b6c636ee24db9', 2, '223.104.3.189', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"H1kl\";i:1514630519;}', 1514634119),
('46454b30957657eea05c47e8cd24985b', 2, '223.104.3.189', 'acid|s:1:\"2\";uniacid|i:2;token|a:6:{s:4:\"a7xn\";i:1514630635;s:4:\"aPb5\";i:1514630637;s:4:\"CE8e\";i:1514630639;s:4:\"xrAO\";i:1514630645;s:4:\"Lf1X\";i:1514630648;s:4:\"s4Fo\";i:1514630655;}openid|s:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";session_key|s:24:\"7Zr2c4sFLuMPerIwibZ3VQ==\";uid|s:1:\"4\";', 1514634255),
('709660e53ba439675c162dab2acc2400', 2, '223.104.3.189', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Yzuu\";i:1514630563;}', 1514634163),
('dbf1785c2c4d53dd9a272b6494db91d2', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"D4rV\";i:1515034526;}', 1515038126),
('d8009d90d6bc2b67028ddbaae108d7d3', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"K512\";i:1515034526;}', 1515038126),
('d0b47523265277a5e3f76e7a43a552b5', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"XRpj\";i:1515034527;}openid|s:28:\"oKC7q0KRMUeodJMzZNNTI-4hw1FY\";session_key|s:24:\"VUDqXR+h+RyAI0937ryeMg==\";uid|s:1:\"5\";', 1515038127),
('55497b586f9704779d149b9152d98965', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"x7f4\";i:1515034560;}', 1515038160),
('07a7d0101eb505be27e1cadc4864a39d', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"e2lU\";i:1515034903;}', 1515038503),
('6888f28b56ae182a12cd8aff65c7220a', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"zNax\";i:1515034903;}', 1515038503),
('8c3744139b8f230ee40e239d9d34860b', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"QlBR\";i:1515044468;}', 1515048068),
('92363009446e96266b94ecdecbd3b6c7', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:3:{s:4:\"Mx4W\";i:1515055445;s:4:\"pWB7\";i:1515055447;s:4:\"a79q\";i:1515055448;}openid|s:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";session_key|s:24:\"wdx3OB+rTQPsDrfEtkcehQ==\";uid|s:1:\"6\";', 1515059048),
('f149472ba836c5c495b5ce718ae83876', 2, '183.95.50.0', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"QkNI\";i:1515076228;}', 1515079828),
('8893df84c1e42b95c352e75d6c33a648', 2, '183.95.50.0', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"HLWg\";i:1515076230;}', 1515079830),
('d031f03bee82902999a7b7e6cca26b7b', 2, '117.136.81.155', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"pW2r\";i:1515204514;}', 1515208114),
('f69472c04024cf899a02db4e9ee514c7', 2, '117.136.81.155', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Tdkr\";i:1515204514;}', 1515208114),
('3d354cdca9f1ba7ef40c743479804061', 2, '117.136.81.155', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"WY6h\";i:1515204523;}', 1515208123),
('0d33e4d0df58c8bb178d2bad2d805f36', 2, '117.136.81.155', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"h7da\";i:1515204523;}', 1515208123),
('4c9b1058efafc1d87b6eaceeff51231b', 2, '117.136.81.116', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"mJp1\";i:1515205551;}', 1515209151),
('21605199809f7db68933d6e544b0e25d', 2, '117.136.81.116', 'acid|s:1:\"2\";uniacid|i:2;token|a:3:{s:4:\"P5VS\";i:1515205555;s:4:\"yNtz\";i:1515205556;s:4:\"wQX2\";i:1515205557;}openid|s:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";session_key|s:24:\"dlnQSkVB4LSJMm1NTRoo8w==\";uid|s:1:\"6\";', 1515209157),
('hokqhcit8gf7hh21l8tnrp90v0', 2, '121.101.208.18', '__acid|i:2;__uniacid|i:2;acid|i:2;uniacid|i:2;token|a:2:{s:4:\"H5QS\";i:1515224360;s:4:\"VNvW\";i:1515224372;}admin_name|s:5:\"admin\";', 1515227972),
('fd46bd74ac9a3a9edb4cfbe2a79557ef', 2, '101.226.233.140', '__acid|i:2;__uniacid|i:2;acid|i:2;uniacid|i:2;token|a:1:{s:4:\"Tr8j\";i:1515224366;}', 1515227966),
('1305f419f2ed1ec9323d0526c441f1ef', 2, '117.136.81.116', '__acid|i:2;__uniacid|i:2;acid|i:2;uniacid|i:2;token|a:2:{s:4:\"UoBB\";i:1515224376;s:4:\"CYqF\";i:1515224391;}admin_name|s:5:\"admin\";', 1515227991),
('16c41ffdcc56947f245f27592027fdae', 2, '117.136.81.24', '__acid|i:2;__uniacid|i:2;acid|i:2;uniacid|i:2;token|a:2:{s:4:\"xcRR\";i:1515225254;s:4:\"JqPP\";i:1515225265;}admin_name|s:5:\"admin\";', 1515228865),
('98c7312d6e89912a2c78fa00e3ab0e44', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Dbmc\";i:1515384048;}', 1515387648),
('f1c88937e8a0f7fb6a0446418241ef6d', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"FdzZ\";i:1515384048;}', 1515387648),
('0ff9d77cf5eae62b0fccd93780229e14', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"T25D\";i:1515384052;}', 1515387652),
('4cd4a81614c7a441b52d4f787fabfe13', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"jZ5x\";i:1515384052;}', 1515387652),
('7ec94b7b3c5d68274abd0b24bba63b63', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"n083\";i:1515384461;}', 1515388061),
('c1bd99452ff6ba63cce4328d17171b63', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"iCUu\";i:1515384461;}', 1515388061),
('9b6f7dcaf33bbcd5d91ac3303eff5e7e', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"tOGn\";i:1515384462;}', 1515388062),
('cfc0a54d9782ebe7c99660c06365dc4b', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"fi7z\";i:1515384521;}', 1515388121),
('dfd95011e4976af51c9393981b082cc6', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"mbKf\";i:1515384532;}', 1515388132),
('011f1f3ff2b8762cac1d1f6bcf38e34d', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"ZrbM\";i:1515384533;}', 1515388133),
('b4d4ce23cfd29dc6fbb8279e39ffa528', 2, '113.57.130.186', '__acid|i:2;__uniacid|i:2;acid|i:2;uniacid|i:2;token|a:2:{s:4:\"TzZs\";i:1515385427;s:4:\"k6g6\";i:1515385437;}admin_name|s:5:\"admin\";', 1515389037),
('bfa4cdb2be6bac441eaa8969bcf90243', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"mwJt\";i:1515399132;}', 1515402732),
('3385cfd33d9cd7a43fcf756a1ed03b0f', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Px7j\";i:1515463160;}', 1515466760),
('2c580fda786ee09f6462d6cbf335993d', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Yccp\";i:1515399578;}', 1515403178),
('7b1c3a9c5308831f04f44904712a8961', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"mF5a\";i:1515404551;}', 1515408151),
('e0a2a120d1262e68c2704e4c207c2a27', 2, '183.95.50.54', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"g5JU\";i:1515450777;}', 1515454377),
('a29da8e15a4730e370af97fcd3a0985e', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"L14j\";i:1515399874;}', 1515403474),
('682c21a4d50aecd27654043a26d727b0', 2, '121.101.208.18', 'acid|s:1:\"2\";uniacid|i:2;token|a:6:{s:4:\"Ub30\";i:1515399952;s:4:\"Ymbg\";i:1515399953;s:4:\"CEmx\";i:1515399956;s:4:\"xxrx\";i:1515399965;s:4:\"tmz3\";i:1515399965;s:4:\"FqLd\";i:1515399969;}openid|s:28:\"oKC7q0Hm8T3b6J9pHjgJNQyf72p4\";session_key|s:24:\"Q8CdNbhnqhCpuKLy0wxofw==\";uid|s:1:\"4\";', 1515403569),
('87babdd67c3b35bbaaaaff0ca0410378', 2, '113.45.86.216', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"Xw3s\";i:1515399999;}', 1515403599),
('f093c64d3dc7c1e683e650dd8850aea9', 2, '113.45.86.216', 'acid|s:1:\"2\";uniacid|i:2;token|a:3:{s:4:\"aVFe\";i:1515400000;s:4:\"v5Kk\";i:1515400000;s:4:\"Lg2J\";i:1515400000;}openid|s:28:\"oKC7q0AO1vcGEx_GVPmY7NwTf1Y8\";session_key|s:24:\"+0BNzV9oIXNdm/leMhlCIw==\";uid|s:1:\"7\";', 1515403600),
('f741b7f90437c8acc44f131b47f5977e', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"FYOB\";i:1515401034;}', 1515404634),
('8fc3f9f3499ef6028b5a0afb53289770', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"b3JY\";i:1515401043;}', 1515404643),
('0a16bf6241e6c3a0f2c2b68029a244e7', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"eU9T\";i:1515477749;}', 1515481349),
('9cff39c49a4d433e2f64d81043a30626', 2, '183.95.50.54', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"cdc5\";i:1515450778;}', 1515454378),
('70bf2d1e751004feb840ecfd41615d34', 2, '117.136.81.247', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"MTTI\";i:1515476497;}', 1515480097),
('0ea39ab3b51e4fb119584b2c00339c3d', 2, '117.136.81.247', 'acid|s:1:\"2\";uniacid|i:2;token|a:5:{s:4:\"Hx5o\";i:1515476498;s:4:\"qUAE\";i:1515476500;s:4:\"moVG\";i:1515476500;s:4:\"D51G\";i:1515476501;s:4:\"ytTG\";i:1515476501;}openid|s:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";session_key|s:24:\"hohtRNvcQqt74NZdCbWrzQ==\";uid|s:1:\"6\";', 1515480101),
('ffa1474c0230710c85f648c1a56b82fa', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"rJe8\";i:1515463161;}', 1515466761),
('8e3ebfd84b926e8138ea8f4a8a4bf676', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:5:{s:4:\"ohlK\";i:1515478070;s:4:\"U1cW\";i:1515478101;s:4:\"Ayeg\";i:1515478138;s:4:\"ey3Y\";i:1515478154;s:4:\"bc1z\";i:1515478178;}openid|s:28:\"oKC7q0IDB1MUYYQYDbBcM8ywSEg0\";session_key|s:24:\"O2gHe37XHK18/xOhGsylcQ==\";uid|s:1:\"6\";', 1515481778),
('d775833175230673606dcf1ab6cead97', 2, '113.57.130.186', 'acid|s:1:\"2\";uniacid|i:2;token|a:1:{s:4:\"brum\";i:1515465325;}', 1515468925);

-- --------------------------------------------------------

--
-- Table structure for table `ims_core_settings`
--

CREATE TABLE `ims_core_settings` (
  `key` varchar(200) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_core_settings`
--

INSERT INTO `ims_core_settings` (`key`, `value`) VALUES
('copyright', 'a:26:{s:6:\"status\";i:0;s:10:\"verifycode\";i:0;s:6:\"reason\";s:0:\"\";s:8:\"sitename\";s:0:\"\";s:3:\"url\";s:7:\"http://\";s:8:\"statcode\";s:0:\"\";s:10:\"footerleft\";s:9:\"镇镇通\";s:11:\"footerright\";s:0:\"\";s:4:\"icon\";s:0:\"\";s:5:\"flogo\";s:48:\"images/global/nKo08Kk77HT55n30TwPwn2UUUZoZ8W.png\";s:14:\"background_img\";s:48:\"images/global/JrsZqJ55s1Z479i14nvWq9W9qRRD3R.png\";s:6:\"slides\";s:216:\"a:3:{i:0;s:58:\"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg\";i:1;s:58:\"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg\";i:2;s:58:\"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg\";}\";s:6:\"notice\";s:0:\"\";s:5:\"blogo\";s:48:\"images/global/nKo08Kk77HT55n30TwPwn2UUUZoZ8W.png\";s:8:\"baidumap\";a:2:{s:3:\"lng\";s:10:\"116.403851\";s:3:\"lat\";s:9:\"39.915177\";}s:7:\"company\";s:0:\"\";s:14:\"companyprofile\";s:0:\"\";s:7:\"address\";s:0:\"\";s:6:\"person\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:2:\"qq\";s:0:\"\";s:5:\"email\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:11:\"description\";s:0:\"\";s:12:\"showhomepage\";i:0;s:13:\"leftmenufixed\";i:0;}'),
('authmode', 'i:1;'),
('close', 'a:2:{s:6:\"status\";s:1:\"0\";s:6:\"reason\";s:0:\"\";}'),
('register', 'a:4:{s:4:\"open\";i:0;s:6:\"verify\";i:0;s:4:\"code\";i:0;s:7:\"groupid\";i:1;}'),
('module_ban', 'a:0:{}'),
('module_upgrade', 'a:0:{}'),
('platform', 'a:5:{s:5:\"token\";s:32:\"cQU0MUXUkkJgwS6KLs0Z00u68lB0sKsU\";s:14:\"encodingaeskey\";s:43:\"V3aOE2C5NRA4pa5jA3LaatpJl2EL33RT542tuAZ5144\";s:5:\"appid\";s:18:\"wx7f83e93205d2fd31\";s:9:\"appsecret\";s:32:\"c328083278a9ff1c88be23095798d3f6\";s:9:\"authstate\";i:1;}'),
('cloudip', 'a:2:{s:2:\"ip\";s:13:\"111.161.3.162\";s:6:\"expire\";i:1515467014;}'),
('basic', 'a:1:{s:8:\"template\";s:7:\"default\";}');

-- --------------------------------------------------------

--
-- Table structure for table `ims_coupon_location`
--

CREATE TABLE `ims_coupon_location` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `sid` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_list` varchar(10000) NOT NULL,
  `avg_price` int(10) UNSIGNED NOT NULL,
  `open_time` varchar(50) NOT NULL,
  `recommend` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `offset_type` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_cover_reply`
--

CREATE TABLE `ims_cover_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `multiid` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `module` varchar(30) NOT NULL,
  `do` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_cover_reply`
--

INSERT INTO `ims_cover_reply` (`id`, `uniacid`, `multiid`, `rid`, `module`, `do`, `title`, `description`, `thumb`, `url`) VALUES
(1, 1, 0, 7, 'mc', '', '进入个人中心', '', '', './index.php?c=mc&a=home&i=1'),
(2, 1, 1, 8, 'site', '', '进入首页', '', '', './index.php?c=home&i=1&t=1');

-- --------------------------------------------------------

--
-- Table structure for table `ims_custom_reply`
--

CREATE TABLE `ims_custom_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `start1` int(10) NOT NULL,
  `end1` int(10) NOT NULL,
  `start2` int(10) NOT NULL,
  `end2` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_images_reply`
--

CREATE TABLE `ims_images_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_cash_record`
--

CREATE TABLE `ims_mc_cash_record` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `clerk_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `clerk_type` tinyint(3) UNSIGNED NOT NULL,
  `fee` decimal(10,2) UNSIGNED NOT NULL,
  `final_fee` decimal(10,2) UNSIGNED NOT NULL,
  `credit1` int(10) UNSIGNED NOT NULL,
  `credit1_fee` decimal(10,2) UNSIGNED NOT NULL,
  `credit2` decimal(10,2) UNSIGNED NOT NULL,
  `cash` decimal(10,2) UNSIGNED NOT NULL,
  `return_cash` decimal(10,2) UNSIGNED NOT NULL,
  `final_cash` decimal(10,2) UNSIGNED NOT NULL,
  `remark` varchar(255) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `trade_type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_chats_record`
--

CREATE TABLE `ims_mc_chats_record` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `flag` tinyint(3) UNSIGNED NOT NULL,
  `openid` varchar(32) NOT NULL,
  `msgtype` varchar(15) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_credits_recharge`
--

CREATE TABLE `ims_mc_credits_recharge` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL,
  `tid` varchar(64) NOT NULL,
  `transid` varchar(30) NOT NULL,
  `fee` varchar(10) NOT NULL,
  `type` varchar(15) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `backtype` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_credits_record`
--

CREATE TABLE `ims_mc_credits_record` (
  `id` int(11) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(11) NOT NULL,
  `credittype` varchar(10) NOT NULL,
  `num` decimal(10,2) NOT NULL,
  `operator` int(10) UNSIGNED NOT NULL,
  `module` varchar(30) NOT NULL,
  `clerk_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `clerk_type` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `remark` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_fans_groups`
--

CREATE TABLE `ims_mc_fans_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `groups` varchar(10000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_fans_tag_mapping`
--

CREATE TABLE `ims_mc_fans_tag_mapping` (
  `id` int(11) UNSIGNED NOT NULL,
  `fanid` int(11) UNSIGNED NOT NULL,
  `tagid` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_groups`
--

CREATE TABLE `ims_mc_groups` (
  `groupid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `credit` int(10) UNSIGNED NOT NULL,
  `isdefault` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mc_groups`
--

INSERT INTO `ims_mc_groups` (`groupid`, `uniacid`, `title`, `credit`, `isdefault`) VALUES
(1, 1, '默认会员组', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_handsel`
--

CREATE TABLE `ims_mc_handsel` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) NOT NULL,
  `touid` int(10) UNSIGNED NOT NULL,
  `fromuid` varchar(32) NOT NULL,
  `module` varchar(30) NOT NULL,
  `sign` varchar(100) NOT NULL,
  `action` varchar(20) NOT NULL,
  `credit_value` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_mapping_fans`
--

CREATE TABLE `ims_mc_mapping_fans` (
  `fanid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `groupid` varchar(30) NOT NULL,
  `salt` char(8) NOT NULL,
  `follow` tinyint(1) UNSIGNED NOT NULL,
  `followtime` int(10) UNSIGNED NOT NULL,
  `unfollowtime` int(10) UNSIGNED NOT NULL,
  `tag` varchar(1000) NOT NULL,
  `updatetime` int(10) UNSIGNED DEFAULT NULL,
  `unionid` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mc_mapping_fans`
--

INSERT INTO `ims_mc_mapping_fans` (`fanid`, `acid`, `uniacid`, `uid`, `openid`, `nickname`, `groupid`, `salt`, `follow`, `followtime`, `unfollowtime`, `tag`, `updatetime`, `unionid`) VALUES
(1, 2, 2, 1, 'oZ_b30Mklnbyxlg35t4tU1j8R6OQ', '小川川', '', 'djJTb2r7', 1, 1513598816, 0, 'YTo5OntzOjk6InN1YnNjcmliZSI7aToxO3M6Njoib3BlbmlkIjtzOjI4OiJvWl9iMzBNa2xuYnl4bGczNXQ0dFUxajhSNk9RIjtzOjg6Im5pY2tuYW1lIjtzOjk6IuWwj+W3neW3nSI7czozOiJzZXgiO2k6MTtzOjg6Imxhbmd1YWdlIjtzOjU6InpoX0NOIjtzOjQ6ImNpdHkiO3M6MDoiIjtzOjg6InByb3ZpbmNlIjtzOjc6IkJlaWppbmciO3M6NzoiY291bnRyeSI7czo1OiJDaGluYSI7czoxMDoiaGVhZGltZ3VybCI7czoxMjY6Imh0dHBzOi8vd3gucWxvZ28uY24vbW1vcGVuL3ZpXzMyL0tEN29FbTk2YUwwc3VqMlo5OHdxd1pOOFlyYVljbmlidElLamJmaWExWjNCcUxMOGljd29FM29rcWg4bGpqbTFEc3N6NDlIWEZvSUU5bnFZczkxS2lhVGlidWcvMCI7fQ==', 1513598816, ''),
(2, 2, 2, 2, 'oKC7q0AX-SG5mIR8tFQ-IGGh3kJA', '清峰、@Yun.0418it.com', '', 'lR335m0K', 1, 1514618953, 0, 'YTo5OntzOjk6InN1YnNjcmliZSI7aToxO3M6Njoib3BlbmlkIjtzOjI4OiJvS0M3cTBBWC1TRzVtSVI4dEZRLUlHR2gza0pBIjtzOjg6Im5pY2tuYW1lIjtzOjI0OiLmuIXls7DjgIFAWXVuLjA0MThpdC5jb20iO3M6Mzoic2V4IjtpOjE7czo4OiJsYW5ndWFnZSI7czo1OiJ6aF9UVyI7czo0OiJjaXR5IjtzOjA6IiI7czo4OiJwcm92aW5jZSI7czowOiIiO3M6NzoiY291bnRyeSI7czoxMDoiRlUgWElOIFNISSI7czoxMDoiaGVhZGltZ3VybCI7czoxMjQ6Imh0dHBzOi8vd3gucWxvZ28uY24vbW1vcGVuL3ZpXzMyL0RZQUlPZ3E4M2VxSlBTTkVGR0oyeURabDJXeTVaOHhpYkpUU3lNdkphWkM5NnRHemR0aWNhNmVhZE50blU3eW9RWW1CMTNvQzBkSzB0TWdpYVZyUUl0Q1ZBLzAiO30=', 1514618953, 'oLOjAs5k-XBW5ahkryUIpG7RoOoU'),
(3, 2, 2, 3, 'oKC7q0BQvMcGX2TaS-uJMKwKaYP0', 'rdgztest_JOSQYK', '', 'X22p5IIB', 1, 1514619366, 0, 'YTo5OntzOjk6InN1YnNjcmliZSI7aToxO3M6Njoib3BlbmlkIjtzOjI4OiJvS0M3cTBCUXZNY0dYMlRhUy11Sk1Ld0thWVAwIjtzOjg6Im5pY2tuYW1lIjtzOjE1OiJyZGd6dGVzdF9KT1NRWUsiO3M6Mzoic2V4IjtpOjA7czo4OiJsYW5ndWFnZSI7czo1OiJ6aF9DTiI7czo0OiJjaXR5IjtzOjA6IiI7czo4OiJwcm92aW5jZSI7czowOiIiO3M6NzoiY291bnRyeSI7czowOiIiO3M6MTA6ImhlYWRpbWd1cmwiO3M6MDoiIjt9', 1514619366, 'oLOjAs-A9qtPzdudPFCsL5oDLbvQ'),
(4, 2, 2, 4, 'oKC7q0Hm8T3b6J9pHjgJNQyf72p4', '叶小川', '', 'kRcCKKqE', 1, 1514620059, 0, 'YTo5OntzOjk6InN1YnNjcmliZSI7aToxO3M6Njoib3BlbmlkIjtzOjI4OiJvS0M3cTBIbThUM2I2SjlwSGpnSk5ReWY3MnA0IjtzOjg6Im5pY2tuYW1lIjtzOjEzOiLlj7blsI/lt53wn5CfIjtzOjM6InNleCI7aToxO3M6ODoibGFuZ3VhZ2UiO3M6NToiemhfQ04iO3M6NDoiY2l0eSI7czo4OiJDaGFveWFuZyI7czo4OiJwcm92aW5jZSI7czo3OiJCZWlqaW5nIjtzOjc6ImNvdW50cnkiO3M6NToiQ2hpbmEiO3M6MTA6ImhlYWRpbWd1cmwiO3M6MTIzOiJodHRwczovL3d4LnFsb2dvLmNuL21tb3Blbi92aV8zMi9EWUFJT2dxODNlb0JXM25MQTdvZE5jdlhycDNCc2ZEWE5MOVZDTTBVdmJWSUZMb05yYkxraWMwM0x2OFVqMmQzNnhyY05vR2NMc0k0b0ZFaFk2aWNadU93LzAiO30=', 1514620059, 'oLOjAs4iGqEJ-3nFppK6Tb996vlo'),
(5, 2, 2, 5, 'oKC7q0KRMUeodJMzZNNTI-4hw1FY', '', '', 'hGv0p5LP', 1, 1515034527, 0, '', 1515034527, ''),
(6, 2, 2, 6, 'oKC7q0IDB1MUYYQYDbBcM8ywSEg0', '随风', '', 'B21NS21U', 1, 1515034909, 0, 'YTo5OntzOjk6InN1YnNjcmliZSI7aToxO3M6Njoib3BlbmlkIjtzOjI4OiJvS0M3cTBJREIxTVVZWVFZRGJCY004eXdTRWcwIjtzOjg6Im5pY2tuYW1lIjtzOjY6Iumaj+mjjiI7czozOiJzZXgiO2k6MTtzOjg6Imxhbmd1YWdlIjtzOjU6InpoX0NOIjtzOjQ6ImNpdHkiO3M6MTk6IlB1ZG9uZyBOZXcgRGlzdHJpY3QiO3M6ODoicHJvdmluY2UiO3M6ODoiU2hhbmdoYWkiO3M6NzoiY291bnRyeSI7czo1OiJDaGluYSI7czoxMDoiaGVhZGltZ3VybCI7czoxMjQ6Imh0dHBzOi8vd3gucWxvZ28uY24vbW1vcGVuL3ZpXzMyLzNoRTViZDhOcDRmRXNpYkpRY0RxMThtTUV4TGdJcmxSZms4OTZNY2ZJemg2VGlibFNmb045cThpYUwzSkt4TUhWMDRibG9uSGx4Zkt0d2NhdWE0RGY4N053LzAiO30=', 1515034909, 'oLOjAs_5BGYcXGXhuGA8FZY8EORM'),
(7, 2, 2, 7, 'oKC7q0AO1vcGEx_GVPmY7NwTf1Y8', '王晓楠', '', 'nj4ybcjz', 1, 1515400000, 0, 'YTo5OntzOjk6InN1YnNjcmliZSI7aToxO3M6Njoib3BlbmlkIjtzOjI4OiJvS0M3cTBBTzF2Y0dFeF9HVlBtWTdOd1RmMVk4IjtzOjg6Im5pY2tuYW1lIjtzOjk6IueOi+aZk+aloCI7czozOiJzZXgiO2k6MTtzOjg6Imxhbmd1YWdlIjtzOjU6InpoX0NOIjtzOjQ6ImNpdHkiO3M6ODoiQ2hhb3lhbmciO3M6ODoicHJvdmluY2UiO3M6NzoiQmVpamluZyI7czo3OiJjb3VudHJ5IjtzOjU6IkNoaW5hIjtzOjEwOiJoZWFkaW1ndXJsIjtzOjEyNToiaHR0cHM6Ly93eC5xbG9nby5jbi9tbW9wZW4vdmlfMzIvRFlBSU9ncTgzZXJDS2dvaWNNZTZWUEE5SDMwRTQwdVFUYjRzdHdEYmxTdDFSaWFBRGxpY1c3T1lNS2twZVRnRGh6NUVIczZpYTF0cjkyM3Q3ZDFMSnNFMHl3LzAiO30=', 1515400000, 'oLOjAs4Teu-5w5QwoilGFxC2ULSE');

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_mapping_ucenter`
--

CREATE TABLE `ims_mc_mapping_ucenter` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `centeruid` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_mass_record`
--

CREATE TABLE `ims_mc_mass_record` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `fansnum` int(10) UNSIGNED NOT NULL,
  `msgtype` varchar(10) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `group` int(10) NOT NULL,
  `attach_id` int(10) UNSIGNED NOT NULL,
  `media_id` varchar(100) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `cron_id` int(10) UNSIGNED NOT NULL,
  `sendtime` int(10) UNSIGNED NOT NULL,
  `finalsendtime` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_members`
--

CREATE TABLE `ims_mc_members` (
  `uid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `groupid` int(11) NOT NULL,
  `credit1` decimal(10,2) UNSIGNED NOT NULL,
  `credit2` decimal(10,2) UNSIGNED NOT NULL,
  `credit3` decimal(10,2) UNSIGNED NOT NULL,
  `credit4` decimal(10,2) UNSIGNED NOT NULL,
  `credit5` decimal(10,2) UNSIGNED NOT NULL,
  `credit6` decimal(10,2) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `realname` varchar(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `vip` tinyint(3) UNSIGNED NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthyear` smallint(6) UNSIGNED NOT NULL,
  `birthmonth` tinyint(3) UNSIGNED NOT NULL,
  `birthday` tinyint(3) UNSIGNED NOT NULL,
  `constellation` varchar(10) NOT NULL,
  `zodiac` varchar(5) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `resideprovince` varchar(30) NOT NULL,
  `residecity` varchar(30) NOT NULL,
  `residedist` varchar(30) NOT NULL,
  `graduateschool` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `education` varchar(10) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `revenue` varchar(10) NOT NULL,
  `affectivestatus` varchar(30) NOT NULL,
  `lookingfor` varchar(255) NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `weight` varchar(5) NOT NULL,
  `alipay` varchar(30) NOT NULL,
  `msn` varchar(30) NOT NULL,
  `taobao` varchar(30) NOT NULL,
  `site` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `interest` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mc_members`
--

INSERT INTO `ims_mc_members` (`uid`, `uniacid`, `mobile`, `email`, `password`, `salt`, `groupid`, `credit1`, `credit2`, `credit3`, `credit4`, `credit5`, `credit6`, `createtime`, `realname`, `nickname`, `avatar`, `qq`, `vip`, `gender`, `birthyear`, `birthmonth`, `birthday`, `constellation`, `zodiac`, `telephone`, `idcard`, `studentid`, `grade`, `address`, `zipcode`, `nationality`, `resideprovince`, `residecity`, `residedist`, `graduateschool`, `company`, `education`, `occupation`, `position`, `revenue`, `affectivestatus`, `lookingfor`, `bloodtype`, `height`, `weight`, `alipay`, `msn`, `taobao`, `site`, `bio`, `interest`) VALUES
(1, 2, '', 'b046b0a7e91c2806fc3307d52fc3891b@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 'qUbuGnqJ', 0, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1513598816, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 2, '', 'd8a027afa04cac30294173f7489d1d55@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 'qXt944SX', 0, '1.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1514618953, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 2, '', 'd316c3a9f9aaa0f56971297e06a617f0@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 'OdFoH9DF', 0, '1.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1514619366, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 2, '', '3af905316a89966e0af9b946a70bbeb9@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 'EEz931y7', 0, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1514620059, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 2, '', 'd5f31ec8d9397e9a7ebf5279c553295a@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 'g0GDwDgD', 0, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1515034527, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 2, '', '0963a2f97d1cfde4ddf58f857c5f2f42@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 've8Zxux2', 0, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1515034909, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 2, '', 'a6fbff910bfd1d80608111db8f64ac09@we7.cc', '647ed78db7c0a750ffcf39cc1efc8673', 'PL4506k5', 0, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1515400000, '', '', '', '', 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_member_address`
--

CREATE TABLE `ims_mc_member_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(50) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `province` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `district` varchar(32) NOT NULL,
  `address` varchar(512) NOT NULL,
  `isdefault` tinyint(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_member_fields`
--

CREATE TABLE `ims_mc_member_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) NOT NULL,
  `fieldid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `displayorder` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_member_property`
--

CREATE TABLE `ims_mc_member_property` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(11) NOT NULL,
  `property` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mc_oauth_fans`
--

CREATE TABLE `ims_mc_oauth_fans` (
  `id` int(10) UNSIGNED NOT NULL,
  `oauth_openid` varchar(50) NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_menu_event`
--

CREATE TABLE `ims_menu_event` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `picmd5` varchar(32) NOT NULL,
  `openid` varchar(128) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_account`
--

CREATE TABLE `ims_mihua_sq_account` (
  `cash_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0未审核1通过2拒绝',
  `reason` text,
  `account` varchar(64) DEFAULT NULL,
  `bank_name` varchar(128) DEFAULT NULL,
  `bank_num` varchar(32) DEFAULT NULL,
  `bank_branch` varchar(128) DEFAULT NULL,
  `bank_realname` varchar(64) DEFAULT NULL,
  `ordersn` varchar(20) DEFAULT NULL,
  `paytype` tinyint(1) DEFAULT NULL COMMENT '1微信2支付宝3银行卡',
  `alipay_account` varchar(128) DEFAULT NULL,
  `alipay_name` varchar(64) DEFAULT NULL,
  `transfer` decimal(10,2) DEFAULT '0.00' COMMENT '手续费',
  `amount` decimal(10,2) DEFAULT '0.00' COMMENT '提现金额',
  `admin_id` int(11) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `checktime` int(11) DEFAULT NULL COMMENT '处理申请时间',
  `check_admin` int(11) DEFAULT NULL COMMENT '处理人',
  `type` tinyint(3) DEFAULT NULL COMMENT '1用户提现 2商户提现'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_address`
--

CREATE TABLE `ims_mihua_sq_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `area` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL,
  `isdefault` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `lat` varchar(255) DEFAULT '',
  `lng` varchar(255) DEFAULT '',
  `inco` varchar(300) DEFAULT NULL COMMENT '标签'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_admin`
--

CREATE TABLE `ims_mihua_sq_admin` (
  `admin_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `passport` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `addtime` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '0开启  1暂停',
  `msg_flag` tinyint(1) DEFAULT '0' COMMENT '0=>发送通知,1=>不发送通知',
  `mobile` char(15) DEFAULT NULL,
  `admin_uid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_adv`
--

CREATE TABLE `ims_mihua_sq_adv` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `type` text COMMENT '1首页，2首页中部，3首页底部，4拼团，5秒杀，6首单，7买单，8同城',
  `add_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_area`
--

CREATE TABLE `ims_mihua_sq_area` (
  `area_id` smallint(5) UNSIGNED NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `area_name` varchar(32) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `is_hot` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_area`
--

INSERT INTO `ims_mihua_sq_area` (`area_id`, `uniacid`, `city_id`, `parent_id`, `area_name`, `orderby`, `is_hot`) VALUES
(1, 2, 1, 0, '宁都县梅江镇', 0, 0),
(2, 2, 1, 0, '宁都县黄石镇', 0, 0),
(3, 2, 1, 0, '宁都县青塘镇', 0, 0),
(4, 2, 1, 0, '宁都县固村镇', 0, 0),
(5, 2, 1, 0, '宁都县田头镇', 0, 0),
(6, 2, 1, 0, '宁都县黄陂镇', 0, 0),
(7, 2, 1, 0, '宁都县石上镇', 0, 0),
(8, 2, 1, 0, '宁都县东山坝镇', 0, 0),
(9, 2, 1, 0, '宁都县赖村镇', 0, 0),
(10, 2, 1, 0, '宁都县小布镇', 0, 0),
(11, 2, 1, 0, '宁都县洛口镇', 0, 0),
(12, 2, 1, 0, '宁都县长胜镇', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_balance`
--

CREATE TABLE `ims_mihua_sq_balance` (
  `balance_id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `money` float(10,2) DEFAULT '0.00',
  `uid` int(11) DEFAULT '0',
  `addtime` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=>未支付,1=>支付完成',
  `openid` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_black`
--

CREATE TABLE `ims_mihua_sq_black` (
  `black_id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` varchar(50) DEFAULT NULL,
  `createtime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_cart`
--

CREATE TABLE `ims_mihua_sq_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `goodsid` int(11) NOT NULL,
  `goodstype` tinyint(1) NOT NULL DEFAULT '1',
  `from_user` varchar(50) NOT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `optionid` int(10) DEFAULT '0',
  `marketprice` decimal(10,2) DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_cash`
--

CREATE TABLE `ims_mihua_sq_cash` (
  `cash_id` int(11) NOT NULL,
  `cash_ordersn` varchar(20) NOT NULL,
  `cash_type` tinyint(1) DEFAULT '1' COMMENT '操作类别(1抢红包，2打赏)',
  `create_time` int(11) NOT NULL COMMENT '该记录创建时间',
  `openid` varchar(50) NOT NULL DEFAULT '用户openid',
  `from_openid` varchar(50) NOT NULL DEFAULT '从哪个用户的opneid得到钱',
  `uniacid` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0.付款中，1:成功)',
  `red_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_channel`
--

CREATE TABLE `ims_mihua_sq_channel` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `sharetitle` varchar(50) NOT NULL,
  `sharethumb` varchar(100) NOT NULL,
  `sharedes` varchar(100) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `canrelease` tinyint(1) NOT NULL DEFAULT '1',
  `isshenhe` tinyint(1) NOT NULL DEFAULT '1',
  `iscang` tinyint(1) NOT NULL,
  `minscore` smallint(6) NOT NULL,
  `isneedpay` tinyint(1) NOT NULL,
  `needpay` decimal(10,2) NOT NULL,
  `templateid` smallint(6) NOT NULL,
  `detailtemplateid` smallint(6) NOT NULL,
  `module` tinyint(4) NOT NULL,
  `autourl` varchar(200) NOT NULL,
  `listhtml` longtext NOT NULL,
  `detailhtml` longtext NOT NULL,
  `defult_list` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1使用默认列表页 2自定义',
  `defult_detail` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1使用默认详情页 2自定义',
  `ison` tinyint(1) NOT NULL DEFAULT '1',
  `zdprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `haibaobg` varchar(100) NOT NULL,
  `template` varchar(20) NOT NULL,
  `template2` varchar(20) NOT NULL,
  `template3` varchar(20) NOT NULL,
  `fid` smallint(6) NOT NULL,
  `bgparam` varchar(10240) NOT NULL,
  `show_location` tinyint(1) DEFAULT '1' COMMENT '1显示发布位置 2不显示',
  `show_comment` tinyint(1) DEFAULT '1' COMMENT '1开启评论 2不开启'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_channel`
--

INSERT INTO `ims_mihua_sq_channel` (`id`, `weid`, `name`, `thumb`, `sharetitle`, `sharethumb`, `sharedes`, `displayorder`, `canrelease`, `isshenhe`, `iscang`, `minscore`, `isneedpay`, `needpay`, `templateid`, `detailtemplateid`, `module`, `autourl`, `listhtml`, `detailhtml`, `defult_list`, `defult_detail`, `ison`, `zdprice`, `haibaobg`, `template`, `template2`, `template3`, `fid`, `bgparam`, `show_location`, `show_comment`) VALUES
(1, 2, '出租', '', '', '', '', 0, 1, 0, 1, 0, 0, '0.00', 0, 0, 0, '', '', '', 1, 1, 1, '0.00', '', '', '', '', 0, 'a:14:{s:6:\"qrleft\";i:145;s:5:\"qrtop\";i:475;s:7:\"qrwidth\";i:240;s:8:\"qrheight\";i:240;s:10:\"avatarleft\";i:0;s:9:\"avatartop\";i:0;s:11:\"avatarwidth\";i:0;s:12:\"avatarheight\";i:0;s:12:\"avatarenable\";i:0;s:8:\"nameleft\";i:0;s:7:\"nametop\";i:0;s:8:\"namesize\";i:0;s:9:\"namecolor\";N;s:10:\"nameenable\";i:0;}', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_chat`
--

CREATE TABLE `ims_mihua_sq_chat` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `toopenid` varchar(100) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `hasread` tinyint(1) NOT NULL,
  `deleteid` int(11) DEFAULT '0' COMMENT '删除者id',
  `userid` varchar(100) DEFAULT NULL,
  `user1` int(11) DEFAULT NULL COMMENT '标识发送消息人',
  `user2` int(11) DEFAULT NULL COMMENT '标识接收消息人',
  `flag` tinyint(3) DEFAULT '0' COMMENT '0文字 1图片 2语音'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_city`
--

CREATE TABLE `ims_mihua_sq_city` (
  `city_id` smallint(5) UNSIGNED NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `pinyin` varchar(32) DEFAULT NULL,
  `isopen` tinyint(2) DEFAULT '1',
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100',
  `first_letter` char(1) DEFAULT NULL,
  `is_hot` tinyint(1) DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_city`
--

INSERT INTO `ims_mihua_sq_city` (`city_id`, `uniacid`, `name`, `pinyin`, `isopen`, `lng`, `lat`, `orderby`, `first_letter`, `is_hot`, `add_time`) VALUES
(1, 2, '赣州市', 'ganzhou', 1, '116.01497', '26.452206', 0, 'G', 0, 1513736976);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_citys`
--

CREATE TABLE `ims_mihua_sq_citys` (
  `id` int(11) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `is_hot` tinyint(1) NOT NULL,
  `firstz` char(1) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `displayorder` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_collect`
--

CREATE TABLE `ims_mihua_sq_collect` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `message_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT '1' COMMENT '1同城信息 2收藏的商品 3收藏的店铺'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_collect`
--

INSERT INTO `ims_mihua_sq_collect` (`id`, `weid`, `openid`, `message_id`, `time`, `shop_id`, `goods_id`, `type`) VALUES
(1, 2, 'oKC7q0IDB1MUYYQYDbBcM8ywSEg0', 2, 1515404569, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_comment`
--

CREATE TABLE `ims_mihua_sq_comment` (
  `comment_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `comment_content` text,
  `mid` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `ordersn` char(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `reply` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_discount`
--

CREATE TABLE `ims_mihua_sq_discount` (
  `id` int(11) UNSIGNED NOT NULL,
  `uniacid` int(11) UNSIGNED DEFAULT '0',
  `shop_id` int(11) DEFAULT '0',
  `cardtype` tinyint(3) UNSIGNED DEFAULT '0' COMMENT '1满减2打折3随机减4积分抵扣',
  `cardname` varchar(100) DEFAULT NULL,
  `needcredit` int(11) UNSIGNED DEFAULT '0' COMMENT '扣除积分',
  `cardvalue` decimal(10,2) UNSIGNED DEFAULT '0.00' COMMENT '面额',
  `fullmoney` decimal(10,2) UNSIGNED DEFAULT '0.00',
  `randomnum` decimal(10,2) UNSIGNED DEFAULT '0.00',
  `totalnum` int(11) UNSIGNED DEFAULT '0',
  `takednum` int(11) UNSIGNED DEFAULT '0',
  `lastnum` int(11) UNSIGNED DEFAULT '0',
  `usednum` int(11) UNSIGNED DEFAULT '0',
  `limitnum` int(11) UNSIGNED DEFAULT '0',
  `expire` int(11) UNSIGNED DEFAULT '0',
  `starttime` int(11) UNSIGNED DEFAULT '0',
  `endtime` int(11) UNSIGNED DEFAULT '0',
  `status` tinyint(3) UNSIGNED DEFAULT '0',
  `time` int(11) UNSIGNED DEFAULT '0',
  `isrecommand` tinyint(3) UNSIGNED DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_discount_record`
--

CREATE TABLE `ims_mihua_sq_discount_record` (
  `id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `discount_id` int(10) UNSIGNED NOT NULL,
  `aftermoney` float(10,2) DEFAULT '0.00',
  `paymoney` float(10,2) DEFAULT '0.00',
  `shop_id` int(11) DEFAULT '0',
  `mid` int(11) DEFAULT '0' COMMENT '对应member表id',
  `createtime` int(11) DEFAULT '0',
  `ordersn` varchar(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0未支付1已支付',
  `paytype` tinyint(1) DEFAULT NULL COMMENT '1为余额，2微信支付，3支付宝，4银行版收银台,5货到付款'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_fields`
--

CREATE TABLE `ims_mihua_sq_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enname` varchar(30) NOT NULL,
  `mtype` varchar(20) NOT NULL,
  `mtypecon` varchar(255) NOT NULL,
  `canvoice` tinyint(1) NOT NULL,
  `canvideo` tinyint(1) NOT NULL,
  `isrequired` tinyint(1) NOT NULL,
  `islenval` tinyint(1) NOT NULL,
  `minlen` smallint(6) NOT NULL,
  `maxlen` smallint(6) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `defaultval` varchar(100) NOT NULL,
  `showname` varchar(50) NOT NULL,
  `sharetype` tinyint(1) NOT NULL,
  `isfilter` tinyint(1) NOT NULL,
  `danwei` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_fields`
--

INSERT INTO `ims_mihua_sq_fields` (`id`, `weid`, `mid`, `name`, `enname`, `mtype`, `mtypecon`, `canvoice`, `canvideo`, `isrequired`, `islenval`, `minlen`, `maxlen`, `displayorder`, `defaultval`, `showname`, `sharetype`, `isfilter`, `danwei`) VALUES
(1, 5, 1, '租房标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '租房标题', 1, 0, ''),
(2, 5, 1, '租金', 'price', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '租金', 0, 0, ''),
(3, 5, 1, '房屋图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 5, '', '房屋图片', 0, 0, ''),
(4, 5, 1, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '联系人', 0, 0, ''),
(5, 5, 1, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 7, '', '手机号码', 0, 0, ''),
(6, 5, 1, '房屋描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 8, '', '房屋描述', 2, 0, ''),
(7, 5, 1, '户型', 'huxing', 'radio', '三室两厅|三室一厅|两室一厅|一室户|其他', 0, 0, 1, 0, 0, 0, 9, '', '户型', 0, 0, ''),
(8, 5, 1, '面积', 'areas', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '面积', 0, 0, ''),
(9, 5, 1, '所在小区', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '所在小区', 0, 0, ''),
(10, 5, 1, '楼层', 'fllor', 'text', '', 0, 0, 1, 0, 0, 0, 13, '', '楼层', 0, 0, ''),
(11, 5, 1, '总楼层', 'allfllor', 'text', '', 0, 0, 1, 0, 0, 0, 14, '', '总楼层', 0, 0, ''),
(12, 5, 1, '付款方式', 'paytype', 'radio', '押一付一|押一付二|押一付三|面议', 0, 0, 1, 0, 0, 0, 15, '押一付三', '付款方式', 0, 0, ''),
(13, 5, 1, '朝向', 'chaoxiang', 'text', '', 0, 0, 1, 0, 0, 0, 16, '', '朝向', 0, 0, ''),
(14, 5, 1, '装修', 'zhuangxiu', 'radio', '精装修|简单装修', 0, 0, 1, 0, 0, 0, 17, '', '装修', 0, 0, ''),
(15, 5, 1, '房屋配置', 'peizhi', 'checkbox', '床|衣柜|沙发|电视', 0, 0, 1, 0, 0, 0, 19, '', '房屋配置', 0, 0, ''),
(16, 5, 2, '拼车标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '拼车标题', 1, 0, ''),
(17, 5, 2, '费用', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 2, '', '费用', 0, 0, ''),
(18, 5, 2, '车辆照片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 4, '', '车辆照片', 0, 0, ''),
(19, 5, 2, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 5, '', '联系人', 0, 0, ''),
(20, 5, 2, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 6, '', '手机号码', 0, 0, ''),
(21, 5, 2, '详细描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '详细描述', 2, 0, ''),
(22, 5, 2, '出发地点', 'cfcity', 'text', '', 0, 0, 1, 0, 0, 0, 8, '', '出发地点', 0, 0, ''),
(23, 5, 2, '目的地', 'ddcity', 'text', '', 0, 0, 1, 0, 0, 0, 9, '', '目的地', 0, 0, ''),
(24, 5, 2, '出行时间', 'gotime', 'datetime', '', 0, 0, 1, 0, 0, 0, 13, '', '出行时间', 0, 0, ''),
(25, 5, 2, '座位数', 'weizi', 'number', '', 0, 0, 1, 0, 0, 0, 14, '', '座位数', 0, 0, ''),
(26, 5, 2, '拼车类型', 'type', 'radio', '长途拼车|上下班拼车', 0, 0, 1, 0, 0, 0, 14, '', '拼车类型', 0, 0, ''),
(27, 5, 3, '个人说明', 'jyxuqiu', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '个人说明', 2, 0, ''),
(28, 5, 3, '体重', 'weight', 'number', '', 0, 0, 1, 0, 0, 0, 6, '', '体重', 0, 0, ''),
(29, 5, 3, '身高', 'height', 'number', '', 0, 0, 1, 0, 0, 0, 5, '', '身高', 0, 0, ''),
(30, 5, 3, '标题', 'title', 'text', '', 0, 0, 1, 1, 10, 100, 1, '', '标题', 1, 0, ''),
(31, 5, 3, '年龄', 'age', 'text', '', 0, 0, 1, 0, 0, 0, 4, '', '年龄', 0, 0, ''),
(32, 5, 3, '个人照片', 'zhaopian', 'images', '', 0, 0, 1, 0, 0, 0, 2, '', '个人照片', 0, 0, ''),
(33, 5, 3, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 8, '', '联系人', 0, 0, ''),
(34, 5, 3, '电话', 'dianhua', 'telphone', '', 0, 0, 1, 0, 0, 0, 9, '', '电话', 0, 0, ''),
(35, 5, 3, '性别', 'sex', 'radio', '男|女', 0, 0, 1, 0, 0, 0, 9, '', '性别', 0, 0, ''),
(36, 5, 4, '二手物品标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '二手物品标题', 1, 0, ''),
(37, 5, 4, '二手物品图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 2, '', '二手物品图片', 0, 0, ''),
(38, 5, 4, '价格', 'price', 'radio', '100元以下|100元以上', 0, 0, 1, 0, 0, 0, 3, '', '价格', 0, 0, ''),
(39, 5, 4, '原价', 'yuanjia', 'text', '', 0, 0, 1, 0, 0, 0, 4, '', '原价', 0, 0, ''),
(40, 5, 4, '详细描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 5, '', '详细描述', 2, 0, ''),
(41, 5, 4, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 8, '', '联系人', 0, 0, ''),
(42, 5, 4, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 9, '', '手机号码', 0, 0, ''),
(43, 5, 4, '交易类型', 'type', 'radio', '个人|商家', 0, 0, 1, 0, 0, 0, 3, '', '交易类型', 0, 0, ''),
(44, 5, 5, '照片', 'tupian', 'images', '', 0, 0, 1, 0, 0, 0, 2, '', '照片', 0, 0, ''),
(45, 5, 5, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 9, '', '联系人', 0, 0, ''),
(46, 5, 5, '电话', 'dianhua', 'telphone', '', 0, 0, 1, 0, 0, 0, 10, '', '电话', 0, 0, ''),
(47, 5, 5, '标题', 'title', 'text', '', 0, 0, 1, 1, 10, 90, 1, '', '标题', 1, 0, ''),
(48, 5, 5, '类型', 'type', 'radio', '寻人|寻物|寻宠物', 0, 0, 1, 0, 0, 0, 0, '', '类型', 0, 0, ''),
(49, 5, 5, '描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 0, '', '描述', 2, 0, ''),
(50, 5, 6, '活动标题', 'title', 'text', '', 0, 0, 1, 1, 10, 100, 1, '', '活动标题', 1, 0, ''),
(51, 5, 6, '图片', 'tupian', 'images', '', 0, 0, 1, 0, 0, 0, 2, '', '图片', 0, 0, ''),
(52, 5, 6, '活动时间', 'huodongtime', 'datetime', '', 0, 0, 1, 0, 0, 0, 3, '', '活动时间', 0, 0, ''),
(53, 5, 6, '活动地点', 'huodongaddress', 'text', '', 0, 0, 1, 0, 0, 0, 4, '', '活动地点', 0, 0, ''),
(54, 5, 6, '活动费用', 'feiyong', 'text', '', 0, 0, 1, 0, 0, 0, 5, '', '活动费用', 0, 0, ''),
(55, 5, 6, '活动介绍', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 6, '', '活动介绍', 2, 0, ''),
(56, 5, 6, '活动类型', 'type', 'radio', '看演唱会|看电影|户外旅游', 0, 0, 1, 0, 0, 0, 6, '', '活动类型', 0, 0, ''),
(57, 5, 7, '职位名称', 'zwtitle', 'text', '', 0, 0, 1, 0, 0, 0, 2, '', '职位名称', 0, 0, ''),
(58, 5, 7, '招聘标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '招聘标题', 0, 0, ''),
(59, 5, 7, '薪水范围', 'xinshui', 'radio', '1000-3000元/月|3000-6000元/月|6000-10000元/月|10000-20000元/月|20000元/月以上', 0, 0, 1, 0, 0, 0, 4, '', '薪水范围', 0, 0, ''),
(60, 5, 7, '招聘人数', 'needpeople', 'number', '', 0, 0, 1, 0, 0, 0, 6, '', '招聘人数', 0, 0, ''),
(61, 5, 7, '工作地点', 'workaddress', 'text', '', 0, 0, 1, 0, 0, 0, 7, '', '工作地点', 0, 0, ''),
(62, 5, 7, '职位简介', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 8, '', '职位简介', 0, 0, ''),
(63, 5, 7, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 9, '', '联系人', 0, 0, ''),
(64, 5, 7, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 10, '', '手机号码', 0, 0, ''),
(65, 5, 7, '福利', 'fuli', 'checkbox', '五险一金|交通补助|餐补|加班少|下午茶|周末双休|话补|房补|加班补助|年底双薪|包吃住|包住|包吃', 0, 0, 1, 0, 0, 0, 15, '', '福利', 0, 0, ''),
(66, 5, 7, '公司名称', 'companyname', 'text', '', 0, 0, 1, 1, 5, 100, 16, '', '公司名称', 0, 0, ''),
(67, 5, 7, '要求学历', 'xueli', 'radio', '高中|大专|本科|研究生', 0, 0, 1, 0, 0, 0, 17, '', '要求学历', 0, 0, ''),
(68, 5, 8, '标题', 'title', 'text', '', 0, 0, 1, 1, 10, 100, 1, '', '标题', 1, 0, ''),
(69, 5, 8, '图片', 'tupian', 'images', '', 0, 0, 1, 0, 0, 0, 2, '', '图片', 0, 0, ''),
(70, 5, 8, '品种', 'pinzhong', 'radio', '泰迪|金毛|比熊|萨摩耶|阿拉斯加|博美|哈士奇|拉布拉多|德国牧羊犬|松狮|秋田犬|吉娃娃|藏獒|雪纳瑞|贵宾|边境牧羊犬|巴哥犬|古牧|罗威纳|银狐犬|杜宾犬|京巴|比特|苏格兰牧羊犬|高加索犬|灵缇犬|西高地|马犬|喜乐蒂|牛头梗|雪橇犬|西施犬|大白熊|卡斯罗|沙皮犬|蝴蝶犬|伯恩山犬|斗牛犬|万能梗|小鹿犬|猎狐梗|威玛烈犬|柴犬|斑点狗|巴吉度猎犬|阿富汗猎犬|格力犬|比格犬|大丹犬|腊肠犬|可卡犬|柯基犬|圣伯纳|其他', 0, 0, 1, 0, 0, 0, 9, '', '品种', 0, 0, ''),
(71, 5, 8, '描述', 'detailmsg', 'longtext', '', 0, 0, 1, 0, 0, 0, 5, '', '描述', 2, 0, ''),
(72, 5, 8, '价格', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '价格', 0, 0, ''),
(73, 5, 8, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 7, '', '联系人', 0, 0, ''),
(74, 5, 8, '联系手机', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 8, '', '联系手机', 0, 0, ''),
(75, 5, 8, '所在区域', 'servicearea', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '所在区域', 0, 0, ''),
(76, 3, 9, '租房标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '租房标题', 1, 0, ''),
(77, 3, 9, '租金', 'price', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '租金', 0, 0, ''),
(78, 3, 9, '房屋图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 5, '', '房屋图片', 0, 0, ''),
(79, 3, 9, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '联系人', 0, 0, ''),
(80, 3, 9, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 7, '', '手机号码', 0, 0, ''),
(81, 3, 9, '房屋描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 8, '', '房屋描述', 2, 0, ''),
(82, 3, 9, '户型', 'huxing', 'radio', '三室两厅|三室一厅|两室一厅|一室户|其他', 0, 0, 1, 0, 0, 0, 9, '', '户型', 0, 0, ''),
(83, 3, 9, '面积', 'areas', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '面积', 0, 0, ''),
(84, 3, 9, '所在小区', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '所在小区', 0, 0, ''),
(85, 3, 9, '楼层', 'fllor', 'text', '', 0, 0, 1, 0, 0, 0, 13, '', '楼层', 0, 0, ''),
(86, 3, 9, '总楼层', 'allfllor', 'text', '', 0, 0, 1, 0, 0, 0, 14, '', '总楼层', 0, 0, ''),
(87, 3, 9, '付款方式', 'paytype', 'radio', '押一付一|押一付二|押一付三|面议', 0, 0, 1, 0, 0, 0, 15, '押一付三', '付款方式', 0, 0, ''),
(88, 3, 9, '朝向', 'chaoxiang', 'text', '', 0, 0, 1, 0, 0, 0, 16, '', '朝向', 0, 0, ''),
(89, 3, 9, '装修', 'zhuangxiu', 'radio', '精装修|简单装修', 0, 0, 1, 0, 0, 0, 17, '', '装修', 0, 0, ''),
(90, 3, 9, '房屋配置', 'peizhi', 'checkbox', '床|衣柜|沙发|电视', 0, 0, 1, 0, 0, 0, 19, '', '房屋配置', 0, 0, ''),
(91, 2, 10, '租房标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '租房标题', 1, 0, ''),
(92, 2, 10, '租金', 'price', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '租金', 0, 0, ''),
(93, 2, 10, '房屋图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 5, '', '房屋图片', 0, 0, ''),
(94, 2, 10, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '联系人', 0, 0, ''),
(95, 2, 10, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 7, '', '手机号码', 0, 0, ''),
(96, 2, 10, '房屋描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 8, '', '房屋描述', 2, 0, ''),
(97, 2, 10, '户型', 'huxing', 'radio', '三室两厅|三室一厅|两室一厅|一室户|其他', 0, 0, 1, 0, 0, 0, 9, '', '户型', 0, 0, ''),
(98, 2, 10, '面积', 'areas', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '面积', 0, 0, ''),
(99, 2, 10, '所在小区', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '所在小区', 0, 0, ''),
(100, 2, 10, '楼层', 'fllor', 'text', '', 0, 0, 1, 0, 0, 0, 13, '', '楼层', 0, 0, ''),
(101, 2, 10, '总楼层', 'allfllor', 'text', '', 0, 0, 1, 0, 0, 0, 14, '', '总楼层', 0, 0, ''),
(102, 2, 10, '付款方式', 'paytype', 'radio', '押一付一|押一付二|押一付三|面议', 0, 0, 1, 0, 0, 0, 15, '押一付三', '付款方式', 0, 0, ''),
(103, 2, 10, '朝向', 'chaoxiang', 'text', '', 0, 0, 1, 0, 0, 0, 16, '', '朝向', 0, 0, ''),
(104, 2, 10, '装修', 'zhuangxiu', 'radio', '精装修|简单装修', 0, 0, 1, 0, 0, 0, 17, '', '装修', 0, 0, ''),
(105, 2, 10, '房屋配置', 'peizhi', 'checkbox', '床|衣柜|沙发|电视', 0, 0, 1, 0, 0, 0, 19, '', '房屋配置', 0, 0, ''),
(138, 5, 15, '期望工资', 'price', 'text', '', 0, 0, 0, 0, 0, 0, 2, '', '期望工资', 0, 0, ''),
(193, 5, 14, '', 'zhaop', 'images', '', 0, 0, 0, 0, 0, 0, 10, '', '', 0, 0, ''),
(135, 5, 14, '要求学历', 'xueli', 'radio', '初中|高中|大专|本科|研究生|不限', 0, 0, 0, 0, 0, 0, 3, '', '要求学历', 0, 0, ''),
(194, 5, 19, '租房标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '租房标题', 1, 0, ''),
(133, 5, 14, '', 'fuli', 'checkbox', '五险一金|交通补助|餐补|加班少|下午茶|周末双休|油补|话补|房补|加班补助|年底双薪|包吃住|包住|包吃', 0, 0, 0, 0, 0, 0, 9, '', '', 0, 0, ''),
(132, 5, 14, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 12, '', '手机号码', 0, 0, ''),
(129, 5, 14, '工作地点', 'workaddress', 'text', '', 0, 0, 0, 0, 0, 0, 7, '', '工作地点', 0, 0, ''),
(130, 5, 14, '职位简介', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 8, '', '职位简介', 2, 0, ''),
(131, 5, 14, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '联系人', 0, 0, ''),
(128, 5, 14, '招聘人数', 'needpeople', 'number', '', 0, 0, 0, 0, 0, 0, 6, '', '招聘人数', 0, 0, '名'),
(136, 5, 15, '标题', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '标题', 1, 0, ''),
(127, 5, 14, '薪水范围', 'xinshui', 'radio', '0-1000元/月|1000-2000元/月|2000-4000元/月|4000-6000元/月|6000-10000元/月|10000元/月以上', 0, 0, 1, 0, 0, 0, 4, '', '薪水范围', 0, 0, ''),
(126, 5, 14, '公司/店铺名称', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '公司/店铺名称', 1, 0, ''),
(167, 5, 17, '户型', 'huxing', 'radio', '别墅|复式|三室两厅|三室一厅|两室一厅|一室户|车库|店铺|办公|写字楼|厂房|其他', 0, 0, 0, 0, 0, 0, 3, '', '户型', 0, 0, ''),
(165, 5, 17, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 7, '', '手机号码', 0, 0, ''),
(166, 5, 17, '求购描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 4, '', '求购描述', 2, 0, ''),
(164, 5, 17, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '联系人', 0, 0, ''),
(323, 5, 28, '类型', 'huxing', 'radio', '厂房|产业|资产|设备|店铺|办公室|代理|授权|专利|经营许可证|其他', 0, 0, 1, 0, 0, 0, 3, '', '类型', 0, 0, ''),
(161, 5, 17, '求购标题', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '', 1, 0, ''),
(162, 5, 17, '期望价格', 'price', 'radio', '10万内|10-30万|30-50万|50-100万|100万以上', 0, 0, 0, 0, 0, 0, 2, '', '期望价格', 0, 0, ''),
(139, 5, 15, '学历', 'xueli', 'radio', '小学|初中|高中|中专|大专|本科|研究生|博士|博士以上', 0, 0, 0, 0, 0, 0, 4, '', '学历', 0, 0, ''),
(140, 5, 15, '工作地点', 'workaddress', 'text', '', 0, 0, 0, 0, 0, 0, 3, '', '工作地点', 0, 0, ''),
(141, 5, 15, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '联系人', 0, 0, ''),
(142, 5, 15, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 10, '', '手机号码', 0, 0, ''),
(143, 5, 15, '性别', 'sex', 'radio', '男|女', 0, 0, 1, 0, 0, 0, 5, '男', '性别', 0, 0, ''),
(147, 5, 15, '', 'shuxing', 'checkbox', '沟通能力|学习能力|执行能力|有亲和力|有责任心|能吃苦|开朗健谈|创业经历|沉稳内敛|人脉广泛', 0, 0, 0, 0, 0, 0, 8, '', '', 0, 0, ''),
(145, 5, 15, '自我评价', 'pingjia', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '自我评价', 2, 0, ''),
(146, 5, 15, '年龄', 'age', 'number', '', 0, 0, 1, 0, 0, 0, 6, '', '年龄', 0, 0, ''),
(148, 5, 15, '添加照片', 'zhaop', 'images', '', 0, 0, 0, 0, 0, 0, 9, '', '', 0, 0, ''),
(201, 5, 19, '面积', 'areas', 'text', '', 0, 0, 0, 0, 0, 0, 4, '', '面积', 0, 0, '平米'),
(198, 5, 19, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 12, '', '手机号码', 0, 0, ''),
(199, 5, 19, '房屋描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '房屋描述', 2, 0, ''),
(200, 5, 19, '类型', 'huxing', 'radio', '复式|三室两厅|三室一厅|两室一厅|一室户|车库|别墅|商铺|写字楼|厂房|其他', 0, 0, 1, 0, 0, 0, 3, '', '类型', 0, 0, ''),
(160, 5, 15, '期望职位', 'qiwangzw', 'radio', '坐办公室|跑业务|闷头苦干|司机|市场开拓', 0, 0, 0, 0, 0, 0, 1, '', '期望职位', 0, 0, ''),
(202, 5, 19, '所在小区/商圈', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 2, '', '所在小区/商圈', 0, 0, ''),
(330, 5, 28, '行业', 'zhuangxiu', 'select', '酒店餐饮|娱乐休闲|零售百货|生活服务|电子通讯|汽车美容|医药保健|教育培训|公司工程', 0, 0, 0, 0, 0, 0, 4, '', '行业', 0, 0, ''),
(192, 5, 14, '性质', 'xingzhi', 'radio', '全职|兼职', 0, 0, 1, 0, 0, 0, 2, '全职', '', 0, 0, ''),
(322, 5, 28, '情况描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 5, '', '情况描述', 2, 0, ''),
(321, 5, 28, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 9, '', '手机号码', 0, 0, ''),
(195, 5, 19, '租金', 'price', 'number', '', 0, 0, 1, 0, 0, 0, 5, '0', '租金', 0, 0, '元/月'),
(196, 5, 19, '房屋图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 9, '', '房屋图片', 0, 0, ''),
(197, 5, 19, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '联系人', 0, 0, ''),
(191, 5, 17, '', 'paytype', 'checkbox', '中介勿扰|全款买房|学校附近|交通便利|双证齐全|电梯房|三楼以上|七楼以上|不要一楼', 0, 0, 0, 0, 0, 0, 5, '', '', 0, 0, ''),
(209, 5, 20, '售房标题', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '售房标题', 1, 0, ''),
(205, 5, 19, '租赁方式', 'paytype', 'checkbox', '押一付一|押一付二|押一付三|最短半年|最短一年|面议', 0, 0, 1, 0, 0, 0, 6, '押一付三', '租赁方式', 0, 0, ''),
(207, 5, 19, '', 'zhuangxiu', 'checkbox', '随时看房|中介勿扰|交通便利|拎包入驻|精装修|简单装修|南向|电梯房|靠近学校', 0, 0, 0, 0, 0, 0, 8, '', '', 0, 0, ''),
(208, 5, 19, '房屋配置', 'peizhi', 'checkbox', '床|衣柜|沙发|电视|空调|冰箱|洗衣机|wifi', 0, 0, 0, 0, 0, 0, 10, '', '房屋配置', 0, 0, ''),
(210, 5, 20, '售价', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 5, '0', '售价', 0, 0, '万元'),
(211, 5, 20, '房屋图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 9, '', '房屋图片', 0, 0, ''),
(212, 5, 20, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '联系人', 0, 0, ''),
(213, 5, 20, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 11, '', '手机号码', 0, 0, ''),
(214, 5, 20, '房屋描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '房屋描述', 2, 0, ''),
(215, 5, 20, '类型', 'huxing', 'radio', '复式|三室两厅|三室一厅|两室一厅|一室户|车库|别墅|商铺|写字楼|厂房|其他', 0, 0, 1, 0, 0, 0, 3, '', '类型', 0, 0, ''),
(216, 5, 20, '面积', 'areas', 'text', '', 0, 0, 0, 0, 0, 0, 4, '', '面积', 0, 0, '平米'),
(217, 5, 20, '所在小区/商圈', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 2, '', '所在小区/商圈', 0, 0, ''),
(226, 5, 21, '货物照片', 'thumbs', 'images', '', 0, 0, 0, 0, 0, 0, 9, '', '货物照片', 0, 0, ''),
(222, 5, 20, '装修情况', 'zhuangxiu', 'radio', '精装修|简单装修|毛坯房', 0, 0, 0, 0, 0, 0, 6, '', '装修情况', 0, 0, ''),
(223, 5, 20, '', 'peizhi', 'checkbox', '随时看房|中介勿扰|交通便利|拎包入驻|南向|电梯房|公园附近|靠近学校|物流园|带车位|家具赠送|电器赠送', 0, 0, 0, 0, 0, 0, 8, '', '', 0, 0, ''),
(224, 5, 21, '货物名称', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '货物名称', 1, 0, ''),
(225, 5, 21, '预期费用', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 3, '0', '预期费用', 0, 0, '元'),
(227, 5, 21, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '联系人', 0, 0, ''),
(228, 5, 21, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 11, '', '手机号码', 0, 0, ''),
(229, 5, 21, '详细描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '详细描述', 2, 0, ''),
(230, 5, 21, '出发地点', 'cfcity', 'text', '', 0, 0, 1, 0, 0, 0, 4, '', '起点', 0, 0, ''),
(231, 5, 21, '目的地', 'ddcity', 'text', '', 0, 0, 1, 0, 0, 0, 5, '', '终点', 0, 0, ''),
(232, 5, 21, '出行时间', 'gotime', 'datetime', '', 0, 0, 1, 0, 0, 0, 6, '', '出行时间', 0, 0, ''),
(233, 5, 21, '货物重量', 'weizi', 'radio', '0-5公斤|5-20公斤|20-100公斤|100-500公斤|0.5-1吨|1-5吨|5-10吨|10吨以上', 0, 0, 1, 0, 0, 0, 2, '', '货物重量', 0, 0, ''),
(234, 5, 21, '拼车类型', 'type', 'radio', '顺带|拼货|整车租赁', 0, 0, 1, 0, 0, 0, 8, '', '拼车类型', 0, 0, ''),
(235, 5, 22, '车辆类型', 'title', 'radio', '面包车|班车|小型货车|中型货车|大型货车|牵引车', 0, 0, 1, 0, 0, 0, 1, '', '', 1, 0, ''),
(236, 5, 22, '载重', 'price', 'radio', '0-100公斤|100-500公斤|0.5-1吨|1-5吨|5-10吨|10吨以上', 0, 0, 1, 0, 0, 0, 2, '', '载重', 0, 0, ''),
(237, 5, 22, '车辆照片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 8, '', '车辆照片', 0, 0, ''),
(238, 5, 22, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 9, '', '联系人', 0, 0, ''),
(239, 5, 22, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 10, '', '手机号码', 0, 0, ''),
(240, 5, 22, '详细描述（途径）', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 6, '', '详细描述', 2, 0, ''),
(241, 5, 22, '出发地点', 'cfcity', 'text', '', 0, 0, 0, 0, 0, 0, 3, '', '起点', 0, 0, ''),
(242, 5, 22, '目的地', 'ddcity', 'text', '', 0, 0, 0, 0, 0, 0, 4, '', '终点', 0, 0, ''),
(243, 5, 22, '出行时间', 'gotime', 'datetime', '', 0, 0, 0, 0, 0, 0, 5, '', '出行时间', 0, 0, ''),
(245, 5, 22, '', 'type', 'checkbox', '带小货物|拼货|整车出租|长途|短途', 0, 0, 0, 0, 0, 0, 7, '', '', 0, 0, ''),
(246, 5, 23, '车型', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '车型', 1, 0, ''),
(247, 5, 23, '费用', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 3, '', '费用', 0, 0, '元'),
(248, 5, 23, '车辆照片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 9, '', '车辆照片', 0, 0, ''),
(249, 5, 23, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '联系人', 0, 0, ''),
(250, 5, 23, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 11, '', '手机号码', 0, 0, ''),
(251, 5, 23, '详细描述（途径）', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 7, '', '详细描述', 2, 0, ''),
(252, 5, 23, '出发地点', 'cfcity', 'text', '', 0, 0, 0, 0, 0, 0, 4, '', '起点', 0, 0, ''),
(253, 5, 23, '目的地', 'ddcity', 'text', '', 0, 0, 0, 0, 0, 0, 5, '', '终点', 0, 0, ''),
(254, 5, 23, '出行时间', 'gotime', 'datetime', '', 0, 0, 0, 0, 0, 0, 6, '', '出行时间', 0, 0, ''),
(255, 5, 23, '座位数', 'weizi', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '座位数', 0, 0, '座'),
(256, 5, 23, '', 'type', 'checkbox', '免费|带小物件|顺风车|拼车|日租|月租|包车|短途|长途|女性免单|不带小孩', 0, 0, 0, 0, 0, 0, 8, '', '', 0, 0, ''),
(257, 5, 24, '拼车标题', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '拼车标题', 1, 0, ''),
(258, 5, 24, '预期费用', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 4, '', '预期费用', 0, 0, ''),
(259, 5, 24, '照片', 'thumbs', 'images', '', 0, 0, 0, 0, 0, 0, 5, '', '', 0, 0, ''),
(260, 5, 24, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '联系人', 0, 0, ''),
(261, 5, 24, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 12, '', '手机号码', 0, 0, ''),
(262, 5, 24, '详细描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 9, '', '详细描述', 2, 0, ''),
(263, 5, 24, '出发地点', 'cfcity', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '起点', 0, 0, ''),
(264, 5, 24, '目的地', 'ddcity', 'text', '', 0, 0, 1, 0, 0, 0, 7, '', '终点', 0, 0, ''),
(265, 5, 24, '出行时间', 'gotime', 'datetime', '', 0, 0, 1, 0, 0, 0, 8, '', '出行时间', 0, 0, ''),
(266, 5, 24, '需要座位数', 'weizi', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '需要座位数', 0, 0, '位'),
(267, 5, 24, '', 'type', 'checkbox', '求带|拼车|顺风车|包车|出油费|送到家门口|有小孩', 0, 0, 0, 0, 0, 0, 10, '', '', 0, 0, ''),
(268, 5, 24, '性别', 'xingbie', 'select', '男|女|有男有女', 0, 0, 1, 0, 0, 0, 3, '', '性别', 0, 0, ''),
(331, 5, 28, '', 'peizhi', 'checkbox', '低租金|营业中|可空转|靠近学校|物流园|设备齐全|接手营业|包技术|证件齐全|临街店铺', 0, 0, 0, 0, 0, 0, 6, '', '', 0, 0, ''),
(313, 5, 27, '', 'paytype', 'checkbox', '中介勿扰|全款买房|学校附近|交通便利|双证齐全|电梯房|三楼以上|七楼以上|不要一楼', 0, 0, 0, 0, 0, 0, 5, '', '', 0, 0, ''),
(320, 5, 28, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 8, '', '联系人', 0, 0, ''),
(317, 5, 28, '转让标题', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '转让标题', 1, 0, ''),
(318, 5, 28, '一口价', 'price', 'text', '', 0, 0, 1, 0, 0, 0, 2, '', '一口价', 0, 0, ''),
(319, 5, 28, '', 'thumbs', 'images', '', 0, 0, 0, 0, 0, 0, 7, '', '', 0, 0, ''),
(302, 5, 27, '求租标题', 'title', 'text', '', 0, 0, 1, 0, 0, 0, 1, '', '求租标题', 1, 0, ''),
(307, 5, 27, '求租描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 4, '', '求租描述', 2, 0, ''),
(308, 5, 27, '户型', 'huxing', 'radio', '别墅|复式|三室两厅|三室一厅|两室一厅|一室户|车库|店铺|办公|写字楼|厂房|其他', 0, 0, 0, 0, 0, 0, 3, '', '户型', 0, 0, ''),
(325, 5, 28, '地址', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 4, '', '地址', 0, 0, ''),
(305, 5, 27, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '联系人', 0, 0, ''),
(306, 5, 27, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 7, '', '手机号码', 0, 0, ''),
(303, 5, 27, '期望租金', 'price', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '期望租金', 0, 0, '元/月以内'),
(332, 2, 1, '租房标题', 'title', 'text', '', 0, 0, 1, 1, 12, 120, 1, '', '租房标题', 1, 0, ''),
(333, 2, 1, '租金', 'price', 'number', '', 0, 0, 1, 0, 0, 0, 2, '', '租金', 0, 0, ''),
(334, 2, 1, '房屋图片', 'thumbs', 'images', '', 0, 0, 1, 0, 0, 0, 5, '', '房屋图片', 0, 0, ''),
(335, 2, 1, '联系人', 'lianxiren', 'text', '', 0, 0, 1, 0, 0, 0, 6, '', '联系人', 0, 0, ''),
(336, 2, 1, '手机号码', 'shouji', 'telphone', '', 0, 0, 1, 0, 0, 0, 7, '', '手机号码', 0, 0, ''),
(337, 2, 1, '房屋描述', 'des', 'longtext', '', 0, 0, 1, 0, 0, 0, 8, '', '房屋描述', 2, 0, ''),
(338, 2, 1, '户型', 'huxing', 'radio', '三室两厅|三室一厅|两室一厅|一室户|其他', 0, 0, 1, 0, 0, 0, 9, '', '户型', 0, 0, ''),
(339, 2, 1, '面积', 'areas', 'text', '', 0, 0, 1, 0, 0, 0, 10, '', '面积', 0, 0, ''),
(340, 2, 1, '所在小区', 'xiaoqu', 'text', '', 0, 0, 1, 0, 0, 0, 11, '', '所在小区', 0, 0, ''),
(341, 2, 1, '楼层', 'fllor', 'text', '', 0, 0, 1, 0, 0, 0, 13, '', '楼层', 0, 0, ''),
(342, 2, 1, '总楼层', 'allfllor', 'text', '', 0, 0, 1, 0, 0, 0, 14, '', '总楼层', 0, 0, ''),
(343, 2, 1, '付款方式', 'paytype', 'radio', '押一付一|押一付二|押一付三|面议', 0, 0, 1, 0, 0, 0, 15, '押一付三', '付款方式', 0, 0, ''),
(344, 2, 1, '朝向', 'chaoxiang', 'text', '', 0, 0, 1, 0, 0, 0, 16, '', '朝向', 0, 0, ''),
(345, 2, 1, '装修', 'zhuangxiu', 'radio', '精装修|简单装修', 0, 0, 1, 0, 0, 0, 17, '', '装修', 0, 0, ''),
(346, 2, 1, '房屋配置', 'peizhi', 'checkbox', '床|衣柜|沙发|电视', 0, 0, 1, 0, 0, 0, 19, '', '房屋配置', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_footmark`
--

CREATE TABLE `ims_mihua_sq_footmark` (
  `foot_id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `content` text COMMENT '只存5条浏览记录|type:1频道 2商品|id：类目id|name:类目名称'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_get_redpackage`
--

CREATE TABLE `ims_mihua_sq_get_redpackage` (
  `get_id` int(11) NOT NULL,
  `red_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(50) NOT NULL DEFAULT '',
  `get_amount` decimal(10,2) NOT NULL COMMENT '领取金额',
  `create_time` int(11) NOT NULL COMMENT '该记录创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_goods`
--

CREATE TABLE `ims_mihua_sq_goods` (
  `goods_id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `xsthumb` varchar(255) DEFAULT '',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` int(10) NOT NULL DEFAULT '0',
  `sales` int(10) NOT NULL DEFAULT '0',
  `spec` varchar(5000) NOT NULL,
  `createtime` int(10) NOT NULL,
  `maxbuy` int(11) DEFAULT '0',
  `hasoption` int(11) DEFAULT '0',
  `thumb_url` text,
  `astrict` int(11) DEFAULT NULL COMMENT '限购',
  `isfirstcut` decimal(10,2) DEFAULT NULL COMMENT '首单优惠',
  `credit` decimal(10,2) DEFAULT NULL COMMENT '积分抵扣',
  `is_hot` int(11) DEFAULT '0' COMMENT '1首页推荐0不推荐',
  `is_time` tinyint(1) DEFAULT '0' COMMENT '1参与秒杀',
  `time_id` int(10) DEFAULT '0' COMMENT '秒杀专场id',
  `datestart` int(11) DEFAULT '0',
  `dateend` int(11) DEFAULT '0',
  `time_num` int(11) DEFAULT '0',
  `time_money` decimal(10,2) DEFAULT NULL COMMENT '秒杀价格',
  `is_group` tinyint(3) DEFAULT NULL COMMENT '1开启团购',
  `groupprice` decimal(10,2) DEFAULT NULL COMMENT '团购价',
  `groupnum` int(10) DEFAULT NULL COMMENT '团购人数',
  `groupendtime` decimal(10,2) DEFAULT NULL COMMENT '团购时间',
  `isshowgroup` tinyint(3) DEFAULT NULL COMMENT '1显示最近团0不显示',
  `group_num` int(11) DEFAULT '0',
  `inco` text COMMENT '商品标签',
  `share_img` varchar(255) DEFAULT NULL,
  `share_title` varchar(100) DEFAULT NULL,
  `share_info` varchar(255) DEFAULT NULL,
  `orderby` tinyint(3) DEFAULT '100' COMMENT 'desc排序',
  `status` tinyint(1) DEFAULT '0' COMMENT '0上架 1下架',
  `totalcnf` int(11) DEFAULT '0' COMMENT '0 拍下减库存 1 付款减库存 2 永久不减',
  `commission` decimal(10,2) UNSIGNED DEFAULT '0.00' COMMENT '该订单的推荐佣金',
  `commission2` decimal(10,2) UNSIGNED DEFAULT '0.00',
  `commission3` decimal(10,2) UNSIGNED DEFAULT '0.00',
  `iscanrefund` tinyint(3) DEFAULT NULL COMMENT '0支持退款 1不支持退款',
  `goods_cate` text COMMENT '商品分类，默认为0全部'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_goods_cate`
--

CREATE TABLE `ims_mihua_sq_goods_cate` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `displayorder` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `cate_url` varchar(250) DEFAULT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_group`
--

CREATE TABLE `ims_mihua_sq_group` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `gid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `fullnumber` int(11) DEFAULT NULL,
  `lastnumber` int(11) DEFAULT NULL,
  `overtime` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `createrid` int(11) DEFAULT NULL,
  `finishtime` int(11) DEFAULT NULL,
  `isrefund` tinyint(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_info`
--

CREATE TABLE `ims_mihua_sq_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `mid` smallint(6) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `avatar` varchar(155) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `createtime` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0未审核,1已审核通过,2审核不通过',
  `lng` varchar(30) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `module` smallint(6) NOT NULL,
  `isneedpay` tinyint(1) NOT NULL,
  `haspay` tinyint(1) NOT NULL,
  `isding` tinyint(1) NOT NULL,
  `dingtime` int(11) NOT NULL,
  `fmid` smallint(6) NOT NULL,
  `freshtime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_info`
--

INSERT INTO `ims_mihua_sq_info` (`id`, `weid`, `mid`, `openid`, `nickname`, `avatar`, `province`, `city`, `district`, `content`, `createtime`, `views`, `status`, `lng`, `lat`, `module`, `isneedpay`, `haspay`, `isding`, `dingtime`, `fmid`, `freshtime`) VALUES
(1, 2, 1, 'oKC7q0Hm8T3b6J9pHjgJNQyf72p4', '叶小川', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eoBW3nLA7odNcvXrp3BsfDXNL9VCM0UvbVIFLoNrbLkic03Lv8Uj2d36xrcNoGcLsI4oFEhY6icZuOw/0', '北京市', '北京市', '朝阳区', 'a:17:{s:4:\"seid\";s:21:\"1514630524CR-fGuzZTyL\";s:3:\"mid\";s:1:\"1\";s:5:\"title\";s:42:\"狠狠年度大奖大奖大奖觉得大奖\";s:5:\"price\";s:5:\"61266\";s:6:\"thumbs\";a:1:{i:0;s:41:\"images/2/2017/121514630563CR-WRKvz26p.jpg\";}s:9:\"lianxiren\";s:11:\"13810344793\";s:3:\"des\";s:21:\"难兄难弟基督教\";s:6:\"shouji\";s:11:\"13810344793\";s:6:\"huxing\";s:12:\"三室两厅\";s:5:\"areas\";s:2:\"53\";s:6:\"xiaoqu\";s:12:\"睡觉睡觉\";s:5:\"fllor\";s:2:\"12\";s:8:\"allfllor\";s:2:\"22\";s:7:\"paytype\";s:12:\"押一付一\";s:9:\"chaoxiang\";s:6:\"南北\";s:9:\"zhuangxiu\";s:9:\"精装修\";s:6:\"peizhi\";a:4:{i:0;s:3:\"床\";i:1;s:6:\"衣柜\";i:2;s:6:\"沙发\";i:3;s:6:\"电视\";}}', 1514630635, 2, 1, '116.47123718261719', '39.97955322265625', 0, 0, 0, 0, 0, 0, 1514630635),
(2, 2, 1, 'oKC7q0IDB1MUYYQYDbBcM8ywSEg0', '随风', 'https://wx.qlogo.cn/mmopen/vi_32/3hE5bd8Np4fEsibJQcDq18mMExLgIrlRfk896McfIzh6TiblSfoN9q8iaL3JKxMHV04blonHlxfKtwcaua4Df87Nw/0', '湖北省', '武汉市', '江夏区', 'a:17:{s:4:\"seid\";s:21:\"1515400253CR-cyJ5hYd9\";s:3:\"mid\";s:1:\"1\";s:5:\"title\";s:45:\"蜜糖镇好房出租过时不候速来看房\";s:5:\"price\";s:4:\"2500\";s:6:\"thumbs\";a:1:{i:0;s:41:\"images/2/2018/011515401043CR-JbMiLxoY.jpg\";}s:9:\"lianxiren\";s:6:\"许刚\";s:6:\"shouji\";s:11:\"13797071376\";s:6:\"huxing\";s:12:\"三室两厅\";s:3:\"des\";s:12:\"朝向很好\";s:5:\"areas\";s:2:\"88\";s:6:\"xiaoqu\";s:9:\"蜜糖镇\";s:5:\"fllor\";s:1:\"3\";s:8:\"allfllor\";s:2:\"11\";s:7:\"paytype\";s:12:\"押一付三\";s:9:\"chaoxiang\";s:3:\"南\";s:9:\"zhuangxiu\";s:9:\"精装修\";s:6:\"peizhi\";a:4:{i:0;s:3:\"床\";i:1;s:6:\"衣柜\";i:2;s:6:\"沙发\";i:3;s:6:\"电视\";}}', 1515401159, 10, 1, '114.32168', '30.37559', 0, 0, 0, 0, 0, 0, 1515401159);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_infoorder`
--

CREATE TABLE `ims_mihua_sq_infoorder` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(10) UNSIGNED NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `transid` varchar(30) NOT NULL DEFAULT '0',
  `paydetail` varchar(255) NOT NULL,
  `paytype` tinyint(1) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `message_id` int(11) NOT NULL,
  `module` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_info_comment`
--

CREATE TABLE `ims_mihua_sq_info_comment` (
  `comment_id` int(11) NOT NULL,
  `info_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `addtime` int(11) UNSIGNED DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_info_comment`
--

INSERT INTO `ims_mihua_sq_info_comment` (`comment_id`, `info_id`, `parent_id`, `uniacid`, `openid`, `info`, `addtime`) VALUES
(1, 2, 0, 2, 'oKC7q0IDB1MUYYQYDbBcM8ywSEg0', 'f库复印', 1515465907);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_integral`
--

CREATE TABLE `ims_mihua_sq_integral` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(11) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `num` smallint(6) NOT NULL,
  `time` int(11) NOT NULL,
  `explain` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_member`
--

CREATE TABLE `ims_mihua_sq_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `createtime` int(11) NOT NULL,
  `telphone` varchar(20) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `idcard` char(18) NOT NULL,
  `realname` varchar(30) NOT NULL,
  `hasrealname` tinyint(1) NOT NULL,
  `hasidcard` tinyint(1) NOT NULL,
  `gender` varchar(10) NOT NULL COMMENT '0男，1女',
  `isagent` tinyint(1) NOT NULL,
  `expirationtime` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `logintime` int(11) DEFAULT NULL,
  `fmid` smallint(6) NOT NULL,
  `mid` smallint(6) NOT NULL,
  `shareid` int(11) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT '0' COMMENT '0为会推广人，1为推广人',
  `flagtime` int(10) DEFAULT NULL COMMENT '为成推广人的时间',
  `mobile` varchar(11) DEFAULT NULL,
  `commission` decimal(10,2) UNSIGNED DEFAULT '0.00' COMMENT '已结佣佣金',
  `zhifu` decimal(10,2) UNSIGNED DEFAULT '0.00' COMMENT '已打款佣金',
  `uid` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL COMMENT '扫的是哪家店铺二维码关注',
  `unionId` varchar(150) DEFAULT NULL COMMENT '用于与小程序标识是否为同一个用户',
  `wxapp` tinyint(1) DEFAULT '0' COMMENT '1微信小程序用户',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT '可提现余额',
  `msg_id_str` text COMMENT '公告ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_member`
--

INSERT INTO `ims_mihua_sq_member` (`id`, `uniacid`, `nickname`, `avatar`, `openid`, `createtime`, `telphone`, `pwd`, `status`, `idcard`, `realname`, `hasrealname`, `hasidcard`, `gender`, `isagent`, `expirationtime`, `province`, `city`, `district`, `logintime`, `fmid`, `mid`, `shareid`, `flag`, `flagtime`, `mobile`, `commission`, `zhifu`, `uid`, `shop_id`, `unionId`, `wxapp`, `balance`, `msg_id_str`) VALUES
(1, 0, '小川川', 'https://wx.qlogo.cn/mmopen/vi_32/KD7oEm96aL0suj2Z98wqwZN8YraYcnibtIKjbfia1Z3BqLL8icwoE3okqh8ljjm1Dssz49HXFoIE9nqYs91KiaTibug/0', 'oZ_b30Mklnbyxlg35t4tU1j8R6OQ', 0, '', '', 0, '', '', 0, 0, '1', 0, 0, '', '', '', 1513598922, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(2, 0, '清峰、@Yun.0418it.com', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqJPSNEFGJ2yDZl2Wy5Z8xibJTSyMvJaZC96tGzdtica6eadNtnU7yoQYf2K0GCw7Boxiaf7HjibwQ3nA/0', '', 0, '', '', 0, '', '', 0, 0, '1', 0, 0, '', '', '', 1514618608, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(3, 2, '清峰、@Yun.0418it.com', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqJPSNEFGJ2yDZl2Wy5Z8xibJTSyMvJaZC96tGzdtica6eadNtnU7yoQYf2K0GCw7Boxiaf7HjibwQ3nA/0', 'oKC7q0AX-SG5mIR8tFQ-IGGh3kJA', 0, '', '', 0, '', '', 0, 0, '1', 0, 0, '', '', '', 1514649138, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(4, 2, 'rdgztest_JOSQYK', '', 'oKC7q0BQvMcGX2TaS-uJMKwKaYP0', 0, '', '', 0, '', '', 0, 0, '0', 0, 0, '', '', '', 1514619400, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(5, 2, '叶小川', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eoBW3nLA7odNcvXrp3BsfDXNL9VCM0UvbVIFLoNrbLkic03Lv8Uj2d36xrcNoGcLsI4oFEhY6icZuOw/0', 'oKC7q0Hm8T3b6J9pHjgJNQyf72p4', 0, '', '', 0, '', '', 0, 0, '1', 0, 0, '', '', '', 1515399953, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(6, 2, '随风', 'https://wx.qlogo.cn/mmopen/vi_32/3hE5bd8Np4fEsibJQcDq18mMExLgIrlRfk896McfIzh6TiblSfoN9q8iaL3JKxMHV04blonHlxfKtwcaua4Df87Nw/0', 'oKC7q0IDB1MUYYQYDbBcM8ywSEg0', 0, '', '', 0, '', '', 0, 0, '1', 0, 0, '', '', '', 1515477821, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(7, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515477751, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(8, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515477759, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(9, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515477848, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(10, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515478071, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(11, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515478101, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(12, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515478139, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(13, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515478154, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL),
(14, 2, '', '', '', 0, '', '', 0, '', '', 0, 0, '', 0, 0, '', '', '', 1515478178, 0, 0, NULL, 0, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '0.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_msg`
--

CREATE TABLE `ims_mihua_sq_msg` (
  `msg_id` int(11) NOT NULL,
  `msg_title` tinytext,
  `msg_content` text,
  `status` tinyint(1) DEFAULT '1',
  `addtime` int(11) DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1用户通知 2商家通知'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_mstime`
--

CREATE TABLE `ims_mihua_sq_mstime` (
  `time_id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(11) NOT NULL,
  `timestart` int(11) DEFAULT '0',
  `timeend` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_option`
--

CREATE TABLE `ims_mihua_sq_option` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(60) DEFAULT '',
  `productprice` decimal(10,2) DEFAULT '0.00',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `costprice` decimal(10,2) DEFAULT '0.00',
  `stock` int(11) DEFAULT '0',
  `weight` decimal(10,2) DEFAULT '0.00',
  `displayorder` int(11) DEFAULT '0',
  `specs` text,
  `virtual` int(11) DEFAULT '0',
  `groupprice` decimal(10,2) DEFAULT NULL COMMENT '团购价',
  `time_money` decimal(10,2) DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_order`
--

CREATE TABLE `ims_mihua_sq_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0普通状态，1为已付款，2为已发货，3为成功，4,退款中，6已取消，7已退款',
  `paytype` tinyint(1) UNSIGNED NOT NULL COMMENT '1为余额，2微信支付，3支付宝，4银行版收银台,5货到付款',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT '0.00',
  `createtime` int(10) UNSIGNED NOT NULL,
  `paytime` int(11) DEFAULT '0',
  `finishtime` int(11) DEFAULT '0',
  `verifytime` int(11) DEFAULT '0',
  `admin_remark` varchar(1000) DEFAULT NULL COMMENT '用户不可见备注',
  `groupid` int(11) DEFAULT NULL COMMENT '拼团id',
  `ordertype` tinyint(3) DEFAULT '1' COMMENT '1单独订单，2参团订单，3建团订单 4秒杀订单 5优惠买单',
  `cardid` int(11) DEFAULT '0',
  `cardcutmoney` decimal(10,2) DEFAULT NULL,
  `iscomplete` tinyint(3) DEFAULT NULL COMMENT '0未完成,1已完成',
  `refundstatus` tinyint(3) DEFAULT '0',
  `canceltime` int(11) DEFAULT '0',
  `refundtime` int(11) DEFAULT '0',
  `refundmoney` varchar(10) DEFAULT NULL,
  `addressid` int(11) DEFAULT NULL,
  `gmessage` tinyint(3) DEFAULT '0' COMMENT '0未发失败团消息,1已发',
  `userid` int(11) DEFAULT NULL COMMENT '关联mihua_sq_member表id',
  `ded_money` decimal(10,2) DEFAULT '0.00',
  `deductible` int(11) DEFAULT '0',
  `m_status` tinyint(3) DEFAULT '0' COMMENT '是否已发送消息0未发 1已发',
  `shareid` int(10) UNSIGNED DEFAULT '0' COMMENT '推荐人ID',
  `shareid2` int(10) DEFAULT '0' COMMENT '2级代理id',
  `shareid3` int(10) DEFAULT '0' COMMENT '3级代理id',
  `xscut` decimal(10,2) DEFAULT NULL COMMENT '限时抢购减去的金额',
  `firstcut` decimal(10,2) DEFAULT NULL COMMENT '首单优惠减去的金额',
  `isremind` tinyint(3) DEFAULT '0' COMMENT ' 1已自动处理'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_order_goods`
--

CREATE TABLE `ims_mihua_sq_order_goods` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `orderid` int(10) UNSIGNED NOT NULL,
  `goodsid` int(10) UNSIGNED NOT NULL,
  `content` text,
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `optionid` int(10) DEFAULT '0',
  `createtime` int(10) UNSIGNED NOT NULL,
  `optionname` text,
  `verifyopenid` varchar(255) DEFAULT NULL COMMENT '核销员',
  `qr_code` text COMMENT '核销二维码',
  `commission` decimal(10,2) UNSIGNED DEFAULT '0.00' COMMENT '该订单的推荐佣金',
  `commission2` decimal(10,2) UNSIGNED DEFAULT '0.00',
  `commission3` decimal(10,2) UNSIGNED DEFAULT '0.00',
  `order_status` tinyint(3) DEFAULT NULL COMMENT '商品订单状态，0正常状态 1已支付  2申请中 3审核通过 4提交退货信息 5收到退货 6退款中 7已退款 8审核不通过',
  `refund_id` int(10) DEFAULT NULL COMMENT '退款表',
  `isverify` tinyint(3) DEFAULT '0' COMMENT '1不支持线下核销，2支持',
  `verified` tinyint(3) DEFAULT '0' COMMENT '订单是否已核销',
  `verifytime` int(11) DEFAULT '0',
  `iscopy` tinyint(3) DEFAULT '0' COMMENT '0未同步资金表，1已同步',
  `iscomplete` tinyint(3) DEFAULT NULL COMMENT '0未完成,1已完成',
  `qr_code_str` varchar(100) DEFAULT NULL COMMENT '核销码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_order_record`
--

CREATE TABLE `ims_mihua_sq_order_record` (
  `id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `ordersn` varchar(20) NOT NULL COMMENT '对应order表ordersn',
  `price` float(10,2) DEFAULT '0.00',
  `ogid` int(11) DEFAULT '0',
  `shop_id` int(11) DEFAULT '0',
  `createtime` int(11) DEFAULT '0',
  `iscopy` tinyint(3) DEFAULT '0' COMMENT '0未同步到余额，1已同步'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_param`
--

CREATE TABLE `ims_mihua_sq_param` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `value` text,
  `displayorder` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_qiandao`
--

CREATE TABLE `ims_mihua_sq_qiandao` (
  `qiandao_id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `timestr` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_qiandao`
--

INSERT INTO `ims_mihua_sq_qiandao` (`qiandao_id`, `uid`, `timestr`) VALUES
(1, 2, '2017-12-30'),
(2, 3, '2017-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_redpackage`
--

CREATE TABLE `ims_mihua_sq_redpackage` (
  `red_id` int(11) NOT NULL,
  `openid` varchar(50) NOT NULL DEFAULT '',
  `uniacid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `lng` varchar(15) DEFAULT '',
  `lat` varchar(15) DEFAULT '',
  `model` tinyint(1) DEFAULT '1' COMMENT '模型(1:普通红包，2：口令红包)',
  `total_amount` decimal(10,2) NOT NULL COMMENT '发出总金额',
  `total_num` int(11) NOT NULL COMMENT '发出总个数',
  `send_num` int(11) DEFAULT '0' COMMENT '发出总个数',
  `allocation_way` int(1) DEFAULT '0' COMMENT '分钱方式：0随机分配，1平均分配',
  `rob_plan` mediumtext NOT NULL COMMENT '红包分配方案',
  `total_pay` decimal(10,2) DEFAULT NULL COMMENT '应付总额',
  `ordersn` varchar(30) DEFAULT NULL COMMENT '订单号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未生效（未付款），1：有效，2：已经抢完，3：待审核，4：审核不通过，5：审核不通过并退款',
  `content` mediumtext COMMENT '内容',
  `xsthumb` text COMMENT '图片',
  `create_time` int(11) NOT NULL COMMENT '该记录创建时间',
  `kouling` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_refund`
--

CREATE TABLE `ims_mihua_sq_refund` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `shop_id` int(11) DEFAULT '0',
  `from_user` varchar(50) NOT NULL,
  `goodsid` int(11) NOT NULL,
  `ogid` int(10) DEFAULT NULL,
  `applytime` int(10) DEFAULT NULL COMMENT '申请退款时间',
  `resulttime` int(10) DEFAULT NULL COMMENT '处理申请时间',
  `remark` varchar(200) DEFAULT NULL COMMENT '审核说明',
  `money` decimal(10,2) DEFAULT '0.00',
  `type` tinyint(1) DEFAULT NULL COMMENT '1退货退款 2仅退款',
  `resean` text COMMENT '退款原因',
  `ordersn` varchar(20) NOT NULL,
  `expresscom` varchar(30) DEFAULT NULL COMMENT '快递公司val',
  `expresssn` varchar(50) DEFAULT NULL COMMENT '快递单号',
  `express` varchar(50) DEFAULT NULL COMMENT '快递公司text',
  `expresstime` int(10) DEFAULT NULL COMMENT '提交物流时间',
  `addressid` int(11) DEFAULT NULL COMMENT '退款地址',
  `refundtime` int(11) DEFAULT '0',
  `back_remark` varchar(200) DEFAULT NULL COMMENT '退款说明'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_ring`
--

CREATE TABLE `ims_mihua_sq_ring` (
  `ring_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `mid` int(11) DEFAULT NULL,
  `addtime` int(11) UNSIGNED DEFAULT '0',
  `info` varchar(1000) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `xsthumb` varchar(255) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_ring_zan`
--

CREATE TABLE `ims_mihua_sq_ring_zan` (
  `zan_id` int(11) NOT NULL,
  `ring_id` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `zan_type` tinyint(1) DEFAULT NULL COMMENT '1点赞，2评论，3关注',
  `info` varchar(255) DEFAULT NULL,
  `addtime` int(11) UNSIGNED DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_sensitiveword`
--

CREATE TABLE `ims_mihua_sq_sensitiveword` (
  `word_id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `sensitiveword` text,
  `replace` text,
  `type` tinyint(1) DEFAULT '0' COMMENT '0敏感字  1协议',
  `contract` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_share_history`
--

CREATE TABLE `ims_mihua_sq_share_history` (
  `sharemid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `from_user` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `joinway` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0默认驱动加入,1二维码加入'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop`
--

CREATE TABLE `ims_mihua_sq_shop` (
  `shop_id` int(11) UNSIGNED NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `shop_name` varchar(64) DEFAULT NULL,
  `city_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `business_id` int(11) DEFAULT '0',
  `pcate_id` int(11) DEFAULT NULL,
  `ccate_id` int(11) DEFAULT NULL,
  `openid` int(11) DEFAULT NULL COMMENT '申请人',
  `lng` varchar(32) DEFAULT NULL,
  `lat` varchar(32) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0' COMMENT '1代表营业中',
  `fan_money` int(10) DEFAULT NULL,
  `is_new` tinyint(1) DEFAULT NULL,
  `dp` decimal(10,2) DEFAULT NULL COMMENT '点评满分5分',
  `month_num` int(10) DEFAULT NULL,
  `rate` int(11) DEFAULT '0' COMMENT '费率 每个商品的结算价格',
  `orderby` tinyint(3) DEFAULT '100' COMMENT '数字越小排序越高',
  `status` tinyint(3) UNSIGNED DEFAULT '0' COMMENT '0未审核1成功入驻2未通过3暂停中',
  `logo` varchar(255) DEFAULT '',
  `shop_cert` varchar(255) DEFAULT '',
  `bgpic` varchar(255) DEFAULT '',
  `intro` varchar(1024) DEFAULT NULL,
  `telphone` varchar(20) DEFAULT NULL,
  `manage` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT '',
  `inco` text COMMENT '店铺标签',
  `starttime` int(11) UNSIGNED DEFAULT NULL COMMENT '入驻时间',
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '1已开通首页推荐',
  `is_group` tinyint(1) DEFAULT '0' COMMENT '1已开通拼团',
  `is_discount` tinyint(1) DEFAULT '0' COMMENT '1已开通优惠买单',
  `is_time` tinyint(1) DEFAULT '0',
  `opendtime` int(11) UNSIGNED DEFAULT NULL COMMENT '开店时间',
  `closetime` int(11) UNSIGNED DEFAULT NULL COMMENT '打烊时间',
  `renjun` decimal(10,2) DEFAULT NULL COMMENT '人均消费',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT '余额',
  `mid` int(11) DEFAULT NULL,
  `qr_code` text COMMENT '商户二维码',
  `address_detail` varchar(255) DEFAULT NULL,
  `endtime` int(11) UNSIGNED DEFAULT NULL COMMENT '到期时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_shop`
--

INSERT INTO `ims_mihua_sq_shop` (`shop_id`, `uniacid`, `shop_name`, `city_id`, `area_id`, `business_id`, `pcate_id`, `ccate_id`, `openid`, `lng`, `lat`, `is_open`, `fan_money`, `is_new`, `dp`, `month_num`, `rate`, `orderby`, `status`, `logo`, `shop_cert`, `bgpic`, `intro`, `telphone`, `manage`, `address`, `inco`, `starttime`, `is_hot`, `is_group`, `is_discount`, `is_time`, `opendtime`, `closetime`, `renjun`, `balance`, `mid`, `qr_code`, `address_detail`, `endtime`) VALUES
(1, 2, '情深网络会所', 1, 1, 0, 0, 0, NULL, '116.026416', '26.473895', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '17890873678', '刘泉泉', '', '[\"\\u5e72\\u51c0\\u536b\\u751f\",\"\\u73af\\u5883\\u4f18\\u96c5\"]', 1513740794, 1, 1, 1, 1, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1555710526),
(2, 2, '百佳超市', 1, 11, 0, 0, 0, NULL, '116.079134', '26.857828', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '18767898734', '昌珉', '', '[\"\\u5e72\\u51c0\\u536b\\u751f\",\"\\u73af\\u5883\\u4f18\\u96c5\"]', 1513741032, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(3, 2, '君豪酒楼', 1, 10, 0, 0, 0, NULL, '115.842513', '26.788868', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '05768796986', '谢斌', '', '[]', 1513741492, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1555710526),
(4, 2, '鹏程酒家', 1, 9, 0, 0, 0, NULL, '115.836506', '26.354423', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '17256780932', '李鹏程', '', '[]', 1513741552, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(5, 2, '吉祥酒楼', 1, 8, 0, 0, 0, NULL, '116.068891', '26.740758', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '13456986431', '吉祥', '', '[]', 1513741744, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(6, 2, '家乐多商场', 1, 7, 0, 0, 0, NULL, '116.073047', '26.625796', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '15297844825', '张海林', '', '[]', 1513741820, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(7, 2, '竹山缘酒店', 1, 6, 0, 0, 0, NULL, '115.857999', '26.697549', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '07523789477', '刘成汉', '', '[]', 1513741922, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(8, 2, '中国电信', 1, 5, 0, 0, 0, NULL, '115.983111', '26.333055', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '05715679083', '旺旺', '', '[]', 1513742242, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(9, 2, '固村新街幼儿园', 1, 4, 0, 0, 0, NULL, '116.160802', '26.246574', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '18267905367', '何月', '', '[]', 1513742340, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, NULL, NULL, 1545256126),
(10, 2, '爱婴宝母婴专卖', 1, 3, 0, 0, 0, NULL, '115.875843', '26.443483', 0, NULL, NULL, '0.00', NULL, 0, 0, 1, '', '', '', '', '17890267825', '爱婴', '', '[]', 1513742442, 1, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, 'images/2/2017/12/mihua_sq_shop_10.png', NULL, 1545256126);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shopinorder`
--

CREATE TABLE `ims_mihua_sq_shopinorder` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(10) UNSIGNED NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `transid` varchar(30) NOT NULL DEFAULT '0',
  `paydetail` varchar(255) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop_admin`
--

CREATE TABLE `ims_mihua_sq_shop_admin` (
  `admin_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `passport` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `addtime` int(11) DEFAULT '0',
  `admin_type` tinyint(1) DEFAULT NULL COMMENT '1超级管理员：全部权限，2操作员：商品管理、订单管理、核销订单，3核销员：仅能核销订单',
  `status` tinyint(1) DEFAULT '0' COMMENT '0开启  1暂停',
  `msg_flag` tinyint(1) DEFAULT '0' COMMENT '0=>发送通知,1=>不发送通知',
  `mobile` char(15) DEFAULT NULL,
  `salt` char(20) DEFAULT NULL,
  `admin_uid` int(11) DEFAULT NULL,
  `msg_id_str` text COMMENT '公告ID',
  `customer` tinyint(1) DEFAULT '0' COMMENT '0非客服  1客服'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop_apply`
--

CREATE TABLE `ims_mihua_sq_shop_apply` (
  `aplly_id` int(11) UNSIGNED NOT NULL,
  `shop_id` int(11) UNSIGNED NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `applytime` int(11) UNSIGNED DEFAULT NULL COMMENT '申请时间',
  `f_type` tinyint(3) DEFAULT '0' COMMENT '0无申请 1入驻申请，2首页推荐，3秒杀，4拼团，5优惠买单',
  `mid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop_cate`
--

CREATE TABLE `ims_mihua_sq_shop_cate` (
  `cate_id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `cate_name` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `orderby` tinyint(3) DEFAULT '100',
  `is_hot` tinyint(1) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT '',
  `cate_url` varchar(255) DEFAULT '',
  `cate_type` tinyint(1) DEFAULT '0' COMMENT '0商铺消费类,1酒店预订,2影院订座,3外卖点餐,4微商城'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_mihua_sq_shop_cate`
--

INSERT INTO `ims_mihua_sq_shop_cate` (`cate_id`, `uniacid`, `cate_name`, `parent_id`, `orderby`, `is_hot`, `title`, `thumb`, `cate_url`, `cate_type`) VALUES
(1, 2, '餐饮美食', 0, 1, 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop_cfg`
--

CREATE TABLE `ims_mihua_sq_shop_cfg` (
  `id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `shop_id` int(11) DEFAULT '0',
  `cfg` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop_renew`
--

CREATE TABLE `ims_mihua_sq_shop_renew` (
  `id` int(11) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `price` float(10,2) DEFAULT '0.00',
  `shop_id` int(11) DEFAULT '0',
  `mid` int(11) DEFAULT '0' COMMENT '对应member表id',
  `createtime` int(11) DEFAULT '0',
  `starttime` int(11) DEFAULT '0' COMMENT '续费开始日期',
  `endtime` int(11) DEFAULT '0' COMMENT '续费到期日期',
  `type` tinyint(3) DEFAULT NULL COMMENT '1续1年，2续2年，3续3年',
  `ordersn` varchar(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0未支付1已支付',
  `paytype` tinyint(1) DEFAULT NULL COMMENT '1为余额，2微信支付，3支付宝，4银行版收银台,5货到付款',
  `flag` tinyint(2) DEFAULT NULL COMMENT '0入驻 1续费'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_shop_user`
--

CREATE TABLE `ims_mihua_sq_shop_user` (
  `id` int(11) NOT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL COMMENT '扫过商户二维码的用户'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_spec`
--

CREATE TABLE `ims_mihua_sq_spec` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` tinyint(3) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_spec_item`
--

CREATE TABLE `ims_mihua_sq_spec_item` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT '0',
  `specid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_topic`
--

CREATE TABLE `ims_mihua_sq_topic` (
  `topic_id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `starttime` int(11) UNSIGNED DEFAULT NULL,
  `endtime` int(11) UNSIGNED DEFAULT NULL,
  `topic_name` varchar(64) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `city_id` smallint(5) DEFAULT '0',
  `area_id` smallint(5) DEFAULT '0',
  `thumb` varchar(255) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_tpl`
--

CREATE TABLE `ims_mihua_sq_tpl` (
  `id` int(11) NOT NULL,
  `tplbh` varchar(50) NOT NULL,
  `tpl_id` varchar(80) DEFAULT NULL,
  `tpl_title` varchar(20) DEFAULT NULL,
  `tpl_key` varchar(500) DEFAULT NULL,
  `tpl_example` varchar(500) DEFAULT NULL,
  `uniacid` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_userdiscount`
--

CREATE TABLE `ims_mihua_sq_userdiscount` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `cardid` int(11) DEFAULT '0',
  `userid` int(11) DEFAULT NULL,
  `openid` varchar(64) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '0',
  `overtime` int(11) DEFAULT '0',
  `taketime` int(11) DEFAULT '0',
  `usetime` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_waitmessage`
--

CREATE TABLE `ims_mihua_sq_waitmessage` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `str` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mihua_sq_zdorder`
--

CREATE TABLE `ims_mihua_sq_zdorder` (
  `id` int(10) UNSIGNED NOT NULL,
  `weid` int(10) UNSIGNED NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(40) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `transid` varchar(30) NOT NULL DEFAULT '0',
  `paydetail` varchar(255) NOT NULL,
  `paytype` tinyint(1) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `message_id` int(11) NOT NULL,
  `module` smallint(6) NOT NULL,
  `days` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_mobilenumber`
--

CREATE TABLE `ims_mobilenumber` (
  `id` int(11) NOT NULL,
  `rid` int(10) NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `dateline` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_modules`
--

CREATE TABLE `ims_modules` (
  `mid` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `version` varchar(15) NOT NULL,
  `ability` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `settings` tinyint(1) NOT NULL,
  `subscribes` varchar(500) NOT NULL,
  `handles` varchar(500) NOT NULL,
  `isrulefields` tinyint(1) NOT NULL,
  `issystem` tinyint(1) UNSIGNED NOT NULL,
  `target` int(10) UNSIGNED NOT NULL,
  `iscard` tinyint(3) UNSIGNED NOT NULL,
  `permissions` varchar(5000) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `wxapp_support` tinyint(1) NOT NULL,
  `app_support` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_modules`
--

INSERT INTO `ims_modules` (`mid`, `name`, `type`, `title`, `version`, `ability`, `description`, `author`, `url`, `settings`, `subscribes`, `handles`, `isrulefields`, `issystem`, `target`, `iscard`, `permissions`, `title_initial`, `wxapp_support`, `app_support`) VALUES
(1, 'basic', 'system', '基本文字回复', '1.0', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(2, 'news', 'system', '基本混合图文回复', '1.0', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(3, 'music', 'system', '基本音乐回复', '1.0', '提供语音、音乐等音频类回复', '在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(4, 'userapi', 'system', '自定义接口回复', '1.1', '更方便的第三方接口设置', '自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(5, 'recharge', 'system', '会员中心充值模块', '1.0', '提供会员充值功能', '', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 0, 1, 0, 0, '', '', 1, 2),
(6, 'custom', 'system', '多客服转接', '1.0.0', '用来接入腾讯的多客服系统', '', 'WeEngine Team', 'http://bbs.we7.cc', 0, 'a:0:{}', 'a:6:{i:0;s:5:\"image\";i:1;s:5:\"voice\";i:2;s:5:\"video\";i:3;s:8:\"location\";i:4;s:4:\"link\";i:5;s:4:\"text\";}', 1, 1, 0, 0, '', '', 1, 2),
(7, 'images', 'system', '基本图片回复', '1.0', '提供图片回复', '在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(8, 'video', 'system', '基本视频回复', '1.0', '提供图片回复', '在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(9, 'voice', 'system', '基本语音回复', '1.0', '提供语音回复', '在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(10, 'chats', 'system', '发送客服消息', '1.0', '公众号可以在粉丝最后发送消息的48小时内无限制发送消息', '', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 0, 1, 0, 0, '', '', 1, 2),
(11, 'wxcard', 'system', '微信卡券回复', '1.0', '微信卡券回复', '微信卡券回复', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 2),
(12, 'yc_youliao', 'business', '同城社区', '6.1.95', '同城论坛，同城生活', '同城生活便民', '同城社区', 'https://www.iweiji.cc', 1, 'a:0:{}', 'a:1:{i:0;s:4:\"text\";}', 1, 0, 0, 0, 'a:0:{}', 'M', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ims_modules_bindings`
--

CREATE TABLE `ims_modules_bindings` (
  `eid` int(11) NOT NULL,
  `module` varchar(100) NOT NULL,
  `entry` varchar(10) NOT NULL,
  `call` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `do` varchar(30) NOT NULL,
  `state` varchar(200) NOT NULL,
  `direct` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `displayorder` tinyint(255) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_modules_bindings`
--

INSERT INTO `ims_modules_bindings` (`eid`, `module`, `entry`, `call`, `title`, `do`, `state`, `direct`, `url`, `icon`, `displayorder`) VALUES
(18, 'yc_youliao', 'menu', '', '独立后台入口', 'index', '', 0, '', '', 0),
(17, 'yc_youliao', 'cover', '', '手机端社区入口', 'index', '', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_modules_plugin`
--

CREATE TABLE `ims_modules_plugin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `main_module` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_modules_recycle`
--

CREATE TABLE `ims_modules_recycle` (
  `id` int(10) NOT NULL,
  `modulename` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_music_reply`
--

CREATE TABLE `ims_music_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(300) NOT NULL,
  `hqurl` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_news_reply`
--

CREATE TABLE `ims_news_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `content` mediumtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `media_id` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_profile_fields`
--

CREATE TABLE `ims_profile_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `unchangeable` tinyint(1) NOT NULL,
  `showinregister` tinyint(1) NOT NULL,
  `field_length` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_profile_fields`
--

INSERT INTO `ims_profile_fields` (`id`, `field`, `available`, `title`, `description`, `displayorder`, `required`, `unchangeable`, `showinregister`, `field_length`) VALUES
(1, 'realname', 1, '真实姓名', '', 0, 1, 1, 1, 0),
(2, 'nickname', 1, '昵称', '', 1, 1, 0, 1, 0),
(3, 'avatar', 1, '头像', '', 1, 0, 0, 0, 0),
(4, 'qq', 1, 'QQ号', '', 0, 0, 0, 1, 0),
(5, 'mobile', 1, '手机号码', '', 0, 0, 0, 0, 0),
(6, 'vip', 1, 'VIP级别', '', 0, 0, 0, 0, 0),
(7, 'gender', 1, '性别', '', 0, 0, 0, 0, 0),
(8, 'birthyear', 1, '出生生日', '', 0, 0, 0, 0, 0),
(9, 'constellation', 1, '星座', '', 0, 0, 0, 0, 0),
(10, 'zodiac', 1, '生肖', '', 0, 0, 0, 0, 0),
(11, 'telephone', 1, '固定电话', '', 0, 0, 0, 0, 0),
(12, 'idcard', 1, '证件号码', '', 0, 0, 0, 0, 0),
(13, 'studentid', 1, '学号', '', 0, 0, 0, 0, 0),
(14, 'grade', 1, '班级', '', 0, 0, 0, 0, 0),
(15, 'address', 1, '邮寄地址', '', 0, 0, 0, 0, 0),
(16, 'zipcode', 1, '邮编', '', 0, 0, 0, 0, 0),
(17, 'nationality', 1, '国籍', '', 0, 0, 0, 0, 0),
(18, 'resideprovince', 1, '居住地址', '', 0, 0, 0, 0, 0),
(19, 'graduateschool', 1, '毕业学校', '', 0, 0, 0, 0, 0),
(20, 'company', 1, '公司', '', 0, 0, 0, 0, 0),
(21, 'education', 1, '学历', '', 0, 0, 0, 0, 0),
(22, 'occupation', 1, '职业', '', 0, 0, 0, 0, 0),
(23, 'position', 1, '职位', '', 0, 0, 0, 0, 0),
(24, 'revenue', 1, '年收入', '', 0, 0, 0, 0, 0),
(25, 'affectivestatus', 1, '情感状态', '', 0, 0, 0, 0, 0),
(26, 'lookingfor', 1, ' 交友目的', '', 0, 0, 0, 0, 0),
(27, 'bloodtype', 1, '血型', '', 0, 0, 0, 0, 0),
(28, 'height', 1, '身高', '', 0, 0, 0, 0, 0),
(29, 'weight', 1, '体重', '', 0, 0, 0, 0, 0),
(30, 'alipay', 1, '支付宝帐号', '', 0, 0, 0, 0, 0),
(31, 'msn', 1, 'MSN', '', 0, 0, 0, 0, 0),
(32, 'email', 1, '电子邮箱', '', 0, 0, 0, 0, 0),
(33, 'taobao', 1, '阿里旺旺', '', 0, 0, 0, 0, 0),
(34, 'site', 1, '主页', '', 0, 0, 0, 0, 0),
(35, 'bio', 1, '自我介绍', '', 0, 0, 0, 0, 0),
(36, 'interest', 1, '兴趣爱好', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_qrcode`
--

CREATE TABLE `ims_qrcode` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL,
  `extra` int(10) UNSIGNED NOT NULL,
  `qrcid` bigint(20) NOT NULL,
  `scene_str` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `model` tinyint(1) UNSIGNED NOT NULL,
  `ticket` varchar(250) NOT NULL,
  `url` varchar(256) NOT NULL,
  `expire` int(10) UNSIGNED NOT NULL,
  `subnum` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_qrcode_stat`
--

CREATE TABLE `ims_qrcode_stat` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `qid` int(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `qrcid` bigint(20) UNSIGNED NOT NULL,
  `scene_str` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_rule`
--

CREATE TABLE `ims_rule` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `displayorder` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `containtype` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_rule`
--

INSERT INTO `ims_rule` (`id`, `uniacid`, `name`, `module`, `displayorder`, `status`, `containtype`) VALUES
(1, 0, '城市天气', 'userapi', 255, 1, ''),
(2, 0, '百度百科', 'userapi', 255, 1, ''),
(3, 0, '即时翻译', 'userapi', 255, 1, ''),
(4, 0, '今日老黄历', 'userapi', 255, 1, ''),
(5, 0, '看新闻', 'userapi', 255, 1, ''),
(6, 0, '快递查询', 'userapi', 255, 1, ''),
(7, 1, '个人中心入口设置', 'cover', 0, 1, ''),
(8, 1, '微擎团队入口设置', 'cover', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_rule_keyword`
--

CREATE TABLE `ims_rule_keyword` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `displayorder` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_rule_keyword`
--

INSERT INTO `ims_rule_keyword` (`id`, `rid`, `uniacid`, `module`, `content`, `type`, `displayorder`, `status`) VALUES
(1, 1, 0, 'userapi', '^.+天气$', 3, 255, 1),
(2, 2, 0, 'userapi', '^百科.+$', 3, 255, 1),
(3, 2, 0, 'userapi', '^定义.+$', 3, 255, 1),
(4, 3, 0, 'userapi', '^@.+$', 3, 255, 1),
(5, 4, 0, 'userapi', '日历', 1, 255, 1),
(6, 4, 0, 'userapi', '万年历', 1, 255, 1),
(7, 4, 0, 'userapi', '黄历', 1, 255, 1),
(8, 4, 0, 'userapi', '几号', 1, 255, 1),
(9, 5, 0, 'userapi', '新闻', 1, 255, 1),
(10, 6, 0, 'userapi', '^(申通|圆通|中通|汇通|韵达|顺丰|EMS) *[a-z0-9]{1,}$', 3, 255, 1),
(11, 7, 1, 'cover', '个人中心', 1, 0, 1),
(12, 8, 1, 'cover', '首页', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_article`
--

CREATE TABLE `ims_site_article` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `kid` int(10) UNSIGNED NOT NULL,
  `iscommend` tinyint(1) NOT NULL,
  `ishot` tinyint(1) UNSIGNED NOT NULL,
  `pcate` int(10) UNSIGNED NOT NULL,
  `ccate` int(10) UNSIGNED NOT NULL,
  `template` varchar(300) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` int(10) UNSIGNED NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `edittime` int(10) NOT NULL,
  `click` int(10) UNSIGNED NOT NULL,
  `type` varchar(10) NOT NULL,
  `credit` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_category`
--

CREATE TABLE `ims_site_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `nid` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `parentid` int(10) UNSIGNED NOT NULL,
  `displayorder` tinyint(3) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `styleid` int(10) UNSIGNED NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `ishomepage` tinyint(1) NOT NULL,
  `icontype` tinyint(1) UNSIGNED NOT NULL,
  `css` varchar(500) NOT NULL,
  `multiid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_multi`
--

CREATE TABLE `ims_site_multi` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `styleid` int(10) UNSIGNED NOT NULL,
  `site_info` text NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `bindhost` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_site_multi`
--

INSERT INTO `ims_site_multi` (`id`, `uniacid`, `title`, `styleid`, `site_info`, `status`, `bindhost`) VALUES
(1, 1, '微擎团队', 1, '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_nav`
--

CREATE TABLE `ims_site_nav` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `multiid` int(10) UNSIGNED NOT NULL,
  `section` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `displayorder` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(500) NOT NULL,
  `css` varchar(1000) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `categoryid` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_page`
--

CREATE TABLE `ims_site_page` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `multiid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `multipage` longtext NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `goodnum` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_slide`
--

CREATE TABLE `ims_site_slide` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `multiid` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_store_goods`
--

CREATE TABLE `ims_site_store_goods` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `account_num` int(10) NOT NULL,
  `wxapp_num` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(15) NOT NULL,
  `slide` varchar(1000) NOT NULL,
  `category_id` int(10) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `synopsis` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_store_order`
--

CREATE TABLE `ims_site_store_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `orderid` varchar(28) NOT NULL,
  `goodsid` int(10) NOT NULL,
  `duration` int(10) NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `buyerid` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `changeprice` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_styles`
--

CREATE TABLE `ims_site_styles` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `templateid` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_site_styles`
--

INSERT INTO `ims_site_styles` (`id`, `uniacid`, `templateid`, `name`) VALUES
(1, 1, 1, '微站默认模板_gC5C');

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_styles_vars`
--

CREATE TABLE `ims_site_styles_vars` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `templateid` int(10) UNSIGNED NOT NULL,
  `styleid` int(10) UNSIGNED NOT NULL,
  `variable` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_site_templates`
--

CREATE TABLE `ims_site_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `version` varchar(64) NOT NULL,
  `description` varchar(500) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `sections` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_site_templates`
--

INSERT INTO `ims_site_templates` (`id`, `name`, `title`, `version`, `description`, `author`, `url`, `type`, `sections`) VALUES
(1, 'default', '微站默认模板', '', '由微擎提供默认微站模板套系', '微擎团队', 'http://we7.cc', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_stat_fans`
--

CREATE TABLE `ims_stat_fans` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `new` int(10) UNSIGNED NOT NULL,
  `cancel` int(10) UNSIGNED NOT NULL,
  `cumulate` int(10) NOT NULL,
  `date` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_stat_fans`
--

INSERT INTO `ims_stat_fans` (`id`, `uniacid`, `new`, `cancel`, `cumulate`, `date`) VALUES
(1, 2, 0, 0, 1, '20171219'),
(2, 2, 0, 0, 1, '20171218'),
(3, 2, 0, 0, 0, '20171217'),
(4, 2, 0, 0, 0, '20171216'),
(5, 2, 0, 0, 0, '20171215'),
(6, 2, 0, 0, 0, '20171214'),
(7, 2, 0, 0, 0, '20171213');

-- --------------------------------------------------------

--
-- Table structure for table `ims_stat_keyword`
--

CREATE TABLE `ims_stat_keyword` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `rid` varchar(10) NOT NULL,
  `kid` int(10) UNSIGNED NOT NULL,
  `hit` int(10) UNSIGNED NOT NULL,
  `lastupdate` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_stat_msg_history`
--

CREATE TABLE `ims_stat_msg_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `kid` int(10) UNSIGNED NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `type` varchar(10) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_stat_rule`
--

CREATE TABLE `ims_stat_rule` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `hit` int(10) UNSIGNED NOT NULL,
  `lastupdate` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_stat_visit`
--

CREATE TABLE `ims_stat_visit` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) NOT NULL,
  `module` varchar(100) NOT NULL,
  `count` int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_stat_visit`
--

INSERT INTO `ims_stat_visit` (`id`, `uniacid`, `module`, `count`, `date`) VALUES
(1, 2, 'yc_youliao', 2, 20171217),
(2, 2, 'yc_youliao', 3, 20171218),
(3, 2, 'yc_youliao', 6, 20171220);

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_account`
--

CREATE TABLE `ims_uni_account` (
  `uniacid` int(10) UNSIGNED NOT NULL,
  `groupid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_acid` int(10) UNSIGNED NOT NULL,
  `rank` int(10) DEFAULT NULL,
  `title_initial` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_uni_account`
--

INSERT INTO `ims_uni_account` (`uniacid`, `groupid`, `name`, `description`, `default_acid`, `rank`, `title_initial`) VALUES
(1, -1, '微擎团队', '一个朝气蓬勃的团队', 1, NULL, 'W'),
(2, 0, '镇镇通', '镇镇通', 2, NULL, 'Z');

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_account_group`
--

CREATE TABLE `ims_uni_account_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `groupid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_account_menus`
--

CREATE TABLE `ims_uni_account_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `menuid` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `sex` tinyint(3) UNSIGNED NOT NULL,
  `group_id` int(10) NOT NULL,
  `client_platform_type` tinyint(3) UNSIGNED NOT NULL,
  `area` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `isdeleted` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_account_modules`
--

CREATE TABLE `ims_uni_account_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `settings` text NOT NULL,
  `shortcut` tinyint(1) UNSIGNED NOT NULL,
  `displayorder` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_uni_account_modules`
--

INSERT INTO `ims_uni_account_modules` (`id`, `uniacid`, `module`, `enabled`, `settings`, `shortcut`, `displayorder`) VALUES
(1, 2, 'yc_youliao', 1, 'a:85:{s:8:\"in_money\";N;s:11:\"isredpacket\";s:1:\"0\";s:7:\"isshang\";s:1:\"0\";s:8:\"transfer\";s:0:\"\";s:12:\"transfer_min\";s:0:\"\";s:12:\"transfer_max\";s:0:\"\";s:13:\"transfer_user\";s:0:\"\";s:13:\"pay_type_user\";N;s:9:\"views_num\";s:0:\"\";s:9:\"shop_logo\";s:0:\"\";s:10:\"shop_bgpic\";s:0:\"\";s:10:\"shop_enter\";s:1:\"0\";s:16:\"shop_enter_price\";s:1:\"0\";s:14:\"one_year_money\";s:0:\"\";s:14:\"two_year_money\";s:0:\"\";s:16:\"three_year_money\";s:0:\"\";s:9:\"one_renew\";s:0:\"\";s:9:\"two_renew\";s:0:\"\";s:11:\"three_renew\";s:0:\"\";s:17:\"shop_transfer_min\";s:0:\"\";s:17:\"shop_transfer_max\";s:0:\"\";s:13:\"shop_pay_type\";N;s:8:\"contract\";s:0:\"\";s:16:\"shop_service_btn\";s:0:\"\";s:10:\"refundtime\";s:0:\"\";s:11:\"index_money\";N;s:10:\"time_money\";N;s:11:\"group_money\";N;s:7:\"balance\";s:1:\"0\";s:2:\"wx\";s:1:\"0\";s:9:\"showWater\";s:1:\"0\";s:10:\"issamecity\";s:1:\"0\";s:17:\"isautorefundgroup\";s:0:\"\";s:14:\"isreturncredit\";N;s:19:\"autocancelordertime\";s:0:\"\";s:17:\"remindmessagetime\";s:0:\"\";s:11:\"qrcode_flag\";i:0;s:4:\"help\";s:0:\"\";s:11:\"index_title\";s:5:\"21323\";s:6:\"footer\";s:18:\"<p>31232132132</p>\";s:12:\"comment_flag\";s:1:\"0\";s:10:\"disclaimer\";s:13:\"<p>213232</p>\";s:9:\"time_long\";N;s:7:\"qr_code\";N;s:11:\"share_title\";s:0:\"\";s:9:\"share_img\";s:0:\"\";s:10:\"share_info\";s:0:\"\";s:14:\"qiandao_random\";N;s:13:\"qiandao_jifen\";s:0:\"\";s:12:\"credit2money\";s:0:\"\";s:8:\"showShop\";N;s:11:\"showChannel\";N;s:14:\"showChannelNum\";s:0:\"\";s:7:\"istplon\";N;s:13:\"kefutplminute\";s:0:\"\";s:12:\"ring_creidit\";s:0:\"\";s:8:\"ring_num\";s:0:\"\";s:5:\"mapak\";s:0:\"\";s:11:\"service_btn\";s:0:\"\";s:12:\"service_link\";s:0:\"\";s:9:\"service_w\";s:0:\"\";s:9:\"service_h\";s:0:\"\";s:9:\"service_b\";s:0:\"\";s:9:\"service_l\";s:0:\"\";s:12:\"show_service\";s:1:\"0\";s:9:\"btn1_name\";s:6:\"首页\";s:9:\"btn1_link\";s:1:\"1\";s:4:\"btn1\";s:51:\"images/2/2017/12/i1BBUSzDvl8nc8826nvEXxU3E6vf1D.png\";s:10:\"btn1_hover\";s:0:\"\";s:9:\"btn2_name\";s:0:\"\";s:9:\"btn2_link\";s:0:\"\";s:4:\"btn2\";s:0:\"\";s:10:\"btn2_hover\";s:0:\"\";s:9:\"btn3_name\";s:0:\"\";s:9:\"btn3_link\";s:0:\"\";s:4:\"btn3\";s:0:\"\";s:10:\"btn3_hover\";s:0:\"\";s:9:\"btn4_name\";s:0:\"\";s:9:\"btn4_link\";s:0:\"\";s:4:\"btn4\";s:0:\"\";s:10:\"btn4_hover\";s:0:\"\";s:9:\"btn5_name\";s:0:\"\";s:9:\"btn5_link\";s:0:\"\";s:4:\"btn5\";s:0:\"\";s:10:\"btn5_hover\";s:0:\"\";}', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_account_users`
--

CREATE TABLE `ims_uni_account_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `rank` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_uni_account_users`
--

INSERT INTO `ims_uni_account_users` (`id`, `uniacid`, `uid`, `role`, `rank`) VALUES
(1, 2, 2, 'owner', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_group`
--

CREATE TABLE `ims_uni_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `modules` varchar(15000) NOT NULL,
  `templates` varchar(5000) NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_uni_group`
--

INSERT INTO `ims_uni_group` (`id`, `owner_uid`, `name`, `modules`, `templates`, `uniacid`) VALUES
(1, 0, '体验套餐服务', 'a:1:{i:0;s:10:\"yc_youliao\";}', 'N;', 0),
(2, 0, '同城小程序', 'a:2:{i:0;s:10:\"yc_youliao\";i:1;s:10:\"yc_youliao\";}', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_settings`
--

CREATE TABLE `ims_uni_settings` (
  `uniacid` int(10) UNSIGNED NOT NULL,
  `passport` varchar(200) NOT NULL,
  `oauth` varchar(100) NOT NULL,
  `jsauth_acid` int(10) UNSIGNED NOT NULL,
  `uc` varchar(500) NOT NULL,
  `notify` varchar(2000) NOT NULL,
  `creditnames` varchar(500) NOT NULL,
  `creditbehaviors` varchar(500) NOT NULL,
  `welcome` varchar(60) NOT NULL,
  `default` varchar(60) NOT NULL,
  `default_message` varchar(2000) NOT NULL,
  `payment` text NOT NULL,
  `stat` varchar(300) NOT NULL,
  `default_site` int(10) UNSIGNED DEFAULT NULL,
  `sync` tinyint(3) UNSIGNED NOT NULL,
  `recharge` varchar(500) NOT NULL,
  `tplnotice` varchar(1000) NOT NULL,
  `grouplevel` tinyint(3) UNSIGNED NOT NULL,
  `mcplugin` varchar(500) NOT NULL,
  `exchange_enable` tinyint(3) UNSIGNED NOT NULL,
  `coupon_type` tinyint(3) UNSIGNED NOT NULL,
  `menuset` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_uni_settings`
--

INSERT INTO `ims_uni_settings` (`uniacid`, `passport`, `oauth`, `jsauth_acid`, `uc`, `notify`, `creditnames`, `creditbehaviors`, `welcome`, `default`, `default_message`, `payment`, `stat`, `default_site`, `sync`, `recharge`, `tplnotice`, `grouplevel`, `mcplugin`, `exchange_enable`, `coupon_type`, `menuset`) VALUES
(1, 'a:3:{s:8:\"focusreg\";i:0;s:4:\"item\";s:5:\"email\";s:4:\"type\";s:8:\"password\";}', 'a:2:{s:6:\"status\";s:1:\"0\";s:7:\"account\";s:1:\"0\";}', 0, 'a:1:{s:6:\"status\";i:0;}', 'a:1:{s:3:\"sms\";a:2:{s:7:\"balance\";i:0;s:9:\"signature\";s:0:\"\";}}', 'a:5:{s:7:\"credit1\";a:2:{s:5:\"title\";s:6:\"积分\";s:7:\"enabled\";i:1;}s:7:\"credit2\";a:2:{s:5:\"title\";s:6:\"余额\";s:7:\"enabled\";i:1;}s:7:\"credit3\";a:2:{s:5:\"title\";s:0:\"\";s:7:\"enabled\";i:0;}s:7:\"credit4\";a:2:{s:5:\"title\";s:0:\"\";s:7:\"enabled\";i:0;}s:7:\"credit5\";a:2:{s:5:\"title\";s:0:\"\";s:7:\"enabled\";i:0;}}', 'a:2:{s:8:\"activity\";s:7:\"credit1\";s:8:\"currency\";s:7:\"credit2\";}', '', '', '', 'a:4:{s:6:\"credit\";a:1:{s:6:\"switch\";b:0;}s:6:\"alipay\";a:4:{s:6:\"switch\";b:0;s:7:\"account\";s:0:\"\";s:7:\"partner\";s:0:\"\";s:6:\"secret\";s:0:\"\";}s:6:\"wechat\";a:5:{s:6:\"switch\";b:0;s:7:\"account\";b:0;s:7:\"signkey\";s:0:\"\";s:7:\"partner\";s:0:\"\";s:3:\"key\";s:0:\"\";}s:8:\"delivery\";a:1:{s:6:\"switch\";b:0;}}', '', 1, 0, '', '', 0, '', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_uni_verifycode`
--

CREATE TABLE `ims_uni_verifycode` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `verifycode` varchar(6) NOT NULL,
  `total` tinyint(3) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_userapi_cache`
--

CREATE TABLE `ims_userapi_cache` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `lastupdate` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_userapi_reply`
--

CREATE TABLE `ims_userapi_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `description` varchar(300) NOT NULL,
  `apiurl` varchar(300) NOT NULL,
  `token` varchar(32) NOT NULL,
  `default_text` varchar(100) NOT NULL,
  `cachetime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_userapi_reply`
--

INSERT INTO `ims_userapi_reply` (`id`, `rid`, `description`, `apiurl`, `token`, `default_text`, `cachetime`) VALUES
(1, 1, '\"城市名+天气\", 如: \"北京天气\"', 'weather.php', '', '', 0),
(2, 2, '\"百科+查询内容\" 或 \"定义+查询内容\", 如: \"百科姚明\", \"定义自行车\"', 'baike.php', '', '', 0),
(3, 3, '\"@查询内容(中文或英文)\"', 'translate.php', '', '', 0),
(4, 4, '\"日历\", \"万年历\", \"黄历\"或\"几号\"', 'calendar.php', '', '', 0),
(5, 5, '\"新闻\"', 'news.php', '', '', 0),
(6, 6, '\"快递+单号\", 如: \"申通1200041125\"', 'express.php', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ims_users`
--

CREATE TABLE `ims_users` (
  `uid` int(10) UNSIGNED NOT NULL,
  `owner_uid` int(10) NOT NULL,
  `groupid` int(10) UNSIGNED NOT NULL,
  `founder_groupid` tinyint(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `joindate` int(10) UNSIGNED NOT NULL,
  `joinip` varchar(15) NOT NULL,
  `lastvisit` int(10) UNSIGNED NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `starttime` int(10) UNSIGNED NOT NULL,
  `endtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_users`
--

INSERT INTO `ims_users` (`uid`, `owner_uid`, `groupid`, `founder_groupid`, `username`, `password`, `salt`, `type`, `status`, `joindate`, `joinip`, `lastvisit`, `lastip`, `remark`, `starttime`, `endtime`) VALUES
(1, 0, 1, 0, 'admin', 'ffbce5f0e95e8e944ca64add2d2a511a1b064584', '9fa7e6ef', 0, 0, 1512833274, '', 1515470263, '121.101.208.18', '', 0, 0),
(2, 0, 1, 0, '镇镇通', 'b01eb558d12408bc2c1282069590ec92011f72b9', 'K28399mr', 1, 2, 1513591629, '121.101.208.18', 1513721561, '121.101.208.18', '', 1513591629, 1548151629);

-- --------------------------------------------------------

--
-- Table structure for table `ims_users_failed_login`
--

CREATE TABLE `ims_users_failed_login` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(15) NOT NULL,
  `username` varchar(32) NOT NULL,
  `count` tinyint(1) UNSIGNED NOT NULL,
  `lastupdate` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_users_founder_group`
--

CREATE TABLE `ims_users_founder_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `maxaccount` int(10) UNSIGNED NOT NULL,
  `maxsubaccount` int(10) UNSIGNED NOT NULL,
  `timelimit` int(10) UNSIGNED NOT NULL,
  `maxwxapp` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_users_group`
--

CREATE TABLE `ims_users_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner_uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `maxaccount` int(10) UNSIGNED NOT NULL,
  `maxsubaccount` int(10) UNSIGNED NOT NULL,
  `timelimit` int(10) UNSIGNED NOT NULL,
  `maxwxapp` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_users_group`
--

INSERT INTO `ims_users_group` (`id`, `owner_uid`, `name`, `package`, `maxaccount`, `maxsubaccount`, `timelimit`, `maxwxapp`) VALUES
(1, 0, '镇镇通', 'a:2:{i:0;i:1;i:1;i:2;}', 1, 0, 400, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ims_users_invitation`
--

CREATE TABLE `ims_users_invitation` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL,
  `fromuid` int(10) UNSIGNED NOT NULL,
  `inviteuid` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_users_permission`
--

CREATE TABLE `ims_users_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `type` varchar(100) NOT NULL,
  `permission` varchar(10000) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_users_profile`
--

CREATE TABLE `ims_users_profile` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL,
  `edittime` int(10) NOT NULL,
  `realname` varchar(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `fakeid` varchar(30) NOT NULL,
  `vip` tinyint(3) UNSIGNED NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthyear` smallint(6) UNSIGNED NOT NULL,
  `birthmonth` tinyint(3) UNSIGNED NOT NULL,
  `birthday` tinyint(3) UNSIGNED NOT NULL,
  `constellation` varchar(10) NOT NULL,
  `zodiac` varchar(5) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `resideprovince` varchar(30) NOT NULL,
  `residecity` varchar(30) NOT NULL,
  `residedist` varchar(30) NOT NULL,
  `graduateschool` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `education` varchar(10) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `revenue` varchar(10) NOT NULL,
  `affectivestatus` varchar(30) NOT NULL,
  `lookingfor` varchar(255) NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `weight` varchar(5) NOT NULL,
  `alipay` varchar(30) NOT NULL,
  `msn` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `taobao` varchar(30) NOT NULL,
  `site` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `interest` text NOT NULL,
  `workerid` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_users_profile`
--

INSERT INTO `ims_users_profile` (`id`, `uid`, `createtime`, `edittime`, `realname`, `nickname`, `avatar`, `qq`, `mobile`, `fakeid`, `vip`, `gender`, `birthyear`, `birthmonth`, `birthday`, `constellation`, `zodiac`, `telephone`, `idcard`, `studentid`, `grade`, `address`, `zipcode`, `nationality`, `resideprovince`, `residecity`, `residedist`, `graduateschool`, `company`, `education`, `occupation`, `position`, `revenue`, `affectivestatus`, `lookingfor`, `bloodtype`, `height`, `weight`, `alipay`, `msn`, `email`, `taobao`, `site`, `bio`, `interest`, `workerid`) VALUES
(1, 1, 1513735009, 1513735353, '黄斐帅', '', '', '983400536', '18270752738', '', 0, 0, 1996, 8, 28, '', '', '', '', '', '', '浙江省杭州市滨江区香溢大厦25楼', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 2, 1513735413, 1513735690, '黄斐帅', '', '', '983400536', '18270752738', '', 0, 0, 1996, 8, 28, '', '', '', '', '', '', '浙江省杭州市滨江区香溢大厦25楼', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ims_video_reply`
--

CREATE TABLE `ims_video_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_voice_reply`
--

CREATE TABLE `ims_voice_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_wechat_attachment`
--

CREATE TABLE `ims_wechat_attachment` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `acid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `media_id` varchar(255) NOT NULL,
  `width` int(10) UNSIGNED NOT NULL,
  `height` int(10) UNSIGNED NOT NULL,
  `type` varchar(15) NOT NULL,
  `model` varchar(25) NOT NULL,
  `tag` varchar(5000) NOT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_wechat_news`
--

CREATE TABLE `ims_wechat_news` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED DEFAULT NULL,
  `attach_id` int(10) UNSIGNED NOT NULL,
  `thumb_media_id` varchar(60) NOT NULL,
  `thumb_url` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(30) NOT NULL,
  `digest` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_source_url` varchar(200) NOT NULL,
  `show_cover_pic` tinyint(3) UNSIGNED NOT NULL,
  `url` varchar(200) NOT NULL,
  `displayorder` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ims_wxapp_general_analysis`
--

CREATE TABLE `ims_wxapp_general_analysis` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) NOT NULL,
  `session_cnt` int(10) NOT NULL,
  `visit_pv` int(10) NOT NULL,
  `visit_uv` int(10) NOT NULL,
  `visit_uv_new` int(10) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `stay_time_uv` varchar(10) NOT NULL,
  `stay_time_session` varchar(10) NOT NULL,
  `visit_depth` varchar(10) NOT NULL,
  `ref_date` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_wxapp_general_analysis`
--

INSERT INTO `ims_wxapp_general_analysis` (`id`, `uniacid`, `session_cnt`, `visit_pv`, `visit_uv`, `visit_uv_new`, `type`, `stay_time_uv`, `stay_time_session`, `visit_depth`, `ref_date`) VALUES
(1, 2, 1, 1, 1, 1, 2, '6', '6', '1', '20171229'),
(2, 2, 0, 0, 0, 0, 2, '0', '0', '0', '20180102'),
(3, 2, 2, 2, 2, 2, 2, '7.5', '7.5', '1', '20180105'),
(4, 2, 0, 0, 0, 0, 2, '0', '0', '0', '20180108');

-- --------------------------------------------------------

--
-- Table structure for table `ims_wxapp_versions`
--

CREATE TABLE `ims_wxapp_versions` (
  `id` int(10) UNSIGNED NOT NULL,
  `uniacid` int(10) UNSIGNED NOT NULL,
  `multiid` int(10) UNSIGNED NOT NULL,
  `version` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `modules` varchar(1000) NOT NULL,
  `design_method` tinyint(1) NOT NULL,
  `template` int(10) NOT NULL,
  `quickmenu` varchar(2500) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ims_wxapp_versions`
--

INSERT INTO `ims_wxapp_versions` (`id`, `uniacid`, `multiid`, `version`, `description`, `modules`, `design_method`, `template`, `quickmenu`, `createtime`) VALUES
(1, 2, 0, 'V0.1', '镇镇通', 'a:1:{s:10:\"yc_youliao\";a:2:{s:4:\"name\";s:10:\"yc_youliao\";s:7:\"version\";s:6:\"6.1.95\";}}', 3, 0, '', 1513519896);

-- --------------------------------------------------------

--
-- Table structure for table `ims_wxcard_reply`
--

CREATE TABLE `ims_wxcard_reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `rid` int(10) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `cid` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(30) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `success` varchar(255) NOT NULL,
  `error` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ims_account`
--
ALTER TABLE `ims_account`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `idx_uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_wechats`
--
ALTER TABLE `ims_account_wechats`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `idx_key` (`key`);

--
-- Indexes for table `ims_account_wxapp`
--
ALTER TABLE `ims_account_wxapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_article_category`
--
ALTER TABLE `ims_article_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `ims_article_news`
--
ALTER TABLE `ims_article_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `cateid` (`cateid`);

--
-- Indexes for table `ims_article_notice`
--
ALTER TABLE `ims_article_notice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `cateid` (`cateid`);

--
-- Indexes for table `ims_article_unread_notice`
--
ALTER TABLE `ims_article_unread_notice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `notice_id` (`notice_id`);

--
-- Indexes for table `ims_basic_reply`
--
ALTER TABLE `ims_basic_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_business`
--
ALTER TABLE `ims_business`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lat_lng` (`lng`,`lat`);

--
-- Indexes for table `ims_core_attachment`
--
ALTER TABLE `ims_core_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_cache`
--
ALTER TABLE `ims_core_cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ims_core_cron`
--
ALTER TABLE `ims_core_cron`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createtime` (`createtime`),
  ADD KEY `nextruntime` (`nextruntime`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `cloudid` (`cloudid`);

--
-- Indexes for table `ims_core_cron_record`
--
ALTER TABLE `ims_core_cron_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `tid` (`tid`),
  ADD KEY `module` (`module`);

--
-- Indexes for table `ims_core_menu`
--
ALTER TABLE `ims_core_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_paylog`
--
ALTER TABLE `ims_core_paylog`
  ADD PRIMARY KEY (`plid`),
  ADD KEY `idx_openid` (`openid`),
  ADD KEY `idx_tid` (`tid`),
  ADD KEY `idx_uniacid` (`uniacid`),
  ADD KEY `uniontid` (`uniontid`);

--
-- Indexes for table `ims_core_performance`
--
ALTER TABLE `ims_core_performance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_queue`
--
ALTER TABLE `ims_core_queue`
  ADD PRIMARY KEY (`qid`),
  ADD KEY `uniacid` (`uniacid`,`acid`),
  ADD KEY `module` (`module`),
  ADD KEY `dateline` (`dateline`);

--
-- Indexes for table `ims_core_refundlog`
--
ALTER TABLE `ims_core_refundlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_uniontid` (`refund_uniontid`),
  ADD KEY `uniontid` (`uniontid`);

--
-- Indexes for table `ims_core_resource`
--
ALTER TABLE `ims_core_resource`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `acid` (`uniacid`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `ims_core_sendsms_log`
--
ALTER TABLE `ims_core_sendsms_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_sessions`
--
ALTER TABLE `ims_core_sessions`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `ims_core_settings`
--
ALTER TABLE `ims_core_settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ims_coupon_location`
--
ALTER TABLE `ims_coupon_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`);

--
-- Indexes for table `ims_cover_reply`
--
ALTER TABLE `ims_cover_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_custom_reply`
--
ALTER TABLE `ims_custom_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_images_reply`
--
ALTER TABLE `ims_images_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_mc_cash_record`
--
ALTER TABLE `ims_mc_cash_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_mc_chats_record`
--
ALTER TABLE `ims_mc_chats_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`),
  ADD KEY `openid` (`openid`),
  ADD KEY `createtime` (`createtime`);

--
-- Indexes for table `ims_mc_credits_recharge`
--
ALTER TABLE `ims_mc_credits_recharge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uniacid_uid` (`uniacid`,`uid`),
  ADD KEY `idx_tid` (`tid`);

--
-- Indexes for table `ims_mc_credits_record`
--
ALTER TABLE `ims_mc_credits_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_mc_fans_groups`
--
ALTER TABLE `ims_mc_fans_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_fans_tag_mapping`
--
ALTER TABLE `ims_mc_fans_tag_mapping`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mapping` (`fanid`,`tagid`),
  ADD KEY `fanid_index` (`fanid`),
  ADD KEY `tagid_index` (`tagid`);

--
-- Indexes for table `ims_mc_groups`
--
ALTER TABLE `ims_mc_groups`
  ADD PRIMARY KEY (`groupid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_handsel`
--
ALTER TABLE `ims_mc_handsel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`touid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_mapping_fans`
--
ALTER TABLE `ims_mc_mapping_fans`
  ADD PRIMARY KEY (`fanid`),
  ADD UNIQUE KEY `openid_2` (`openid`),
  ADD KEY `acid` (`acid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `nickname` (`nickname`),
  ADD KEY `updatetime` (`updatetime`),
  ADD KEY `uid` (`uid`),
  ADD KEY `openid` (`openid`);

--
-- Indexes for table `ims_mc_mapping_ucenter`
--
ALTER TABLE `ims_mc_mapping_ucenter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mc_mass_record`
--
ALTER TABLE `ims_mc_mass_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`);

--
-- Indexes for table `ims_mc_members`
--
ALTER TABLE `ims_mc_members`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `groupid` (`groupid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `email` (`email`),
  ADD KEY `mobile` (`mobile`);

--
-- Indexes for table `ims_mc_member_address`
--
ALTER TABLE `ims_mc_member_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uinacid` (`uniacid`),
  ADD KEY `idx_uid` (`uid`);

--
-- Indexes for table `ims_mc_member_fields`
--
ALTER TABLE `ims_mc_member_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uniacid` (`uniacid`),
  ADD KEY `idx_fieldid` (`fieldid`);

--
-- Indexes for table `ims_mc_member_property`
--
ALTER TABLE `ims_mc_member_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mc_oauth_fans`
--
ALTER TABLE `ims_mc_oauth_fans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_oauthopenid_acid` (`oauth_openid`,`acid`);

--
-- Indexes for table `ims_menu_event`
--
ALTER TABLE `ims_menu_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `picmd5` (`picmd5`);

--
-- Indexes for table `ims_mihua_sq_account`
--
ALTER TABLE `ims_mihua_sq_account`
  ADD PRIMARY KEY (`cash_id`);

--
-- Indexes for table `ims_mihua_sq_address`
--
ALTER TABLE `ims_mihua_sq_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_admin`
--
ALTER TABLE `ims_mihua_sq_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ims_mihua_sq_adv`
--
ALTER TABLE `ims_mihua_sq_adv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_uniacid` (`uniacid`),
  ADD KEY `indx_enabled` (`enabled`),
  ADD KEY `indx_displayorder` (`displayorder`);

--
-- Indexes for table `ims_mihua_sq_area`
--
ALTER TABLE `ims_mihua_sq_area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `ims_mihua_sq_balance`
--
ALTER TABLE `ims_mihua_sq_balance`
  ADD PRIMARY KEY (`balance_id`);

--
-- Indexes for table `ims_mihua_sq_black`
--
ALTER TABLE `ims_mihua_sq_black`
  ADD PRIMARY KEY (`black_id`);

--
-- Indexes for table `ims_mihua_sq_cart`
--
ALTER TABLE `ims_mihua_sq_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_openid` (`from_user`);

--
-- Indexes for table `ims_mihua_sq_cash`
--
ALTER TABLE `ims_mihua_sq_cash`
  ADD PRIMARY KEY (`cash_id`),
  ADD UNIQUE KEY `id` (`cash_id`);

--
-- Indexes for table `ims_mihua_sq_channel`
--
ALTER TABLE `ims_mihua_sq_channel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_chat`
--
ALTER TABLE `ims_mihua_sq_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_city`
--
ALTER TABLE `ims_mihua_sq_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `ims_mihua_sq_citys`
--
ALTER TABLE `ims_mihua_sq_citys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_collect`
--
ALTER TABLE `ims_mihua_sq_collect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_comment`
--
ALTER TABLE `ims_mihua_sq_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `ims_mihua_sq_discount`
--
ALTER TABLE `ims_mihua_sq_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_discount_record`
--
ALTER TABLE `ims_mihua_sq_discount_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_fields`
--
ALTER TABLE `ims_mihua_sq_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_footmark`
--
ALTER TABLE `ims_mihua_sq_footmark`
  ADD PRIMARY KEY (`foot_id`);

--
-- Indexes for table `ims_mihua_sq_get_redpackage`
--
ALTER TABLE `ims_mihua_sq_get_redpackage`
  ADD PRIMARY KEY (`get_id`),
  ADD UNIQUE KEY `id` (`get_id`);

--
-- Indexes for table `ims_mihua_sq_goods`
--
ALTER TABLE `ims_mihua_sq_goods`
  ADD PRIMARY KEY (`goods_id`);

--
-- Indexes for table `ims_mihua_sq_goods_cate`
--
ALTER TABLE `ims_mihua_sq_goods_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_group`
--
ALTER TABLE `ims_mihua_sq_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_info`
--
ALTER TABLE `ims_mihua_sq_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_infoorder`
--
ALTER TABLE `ims_mihua_sq_infoorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_info_comment`
--
ALTER TABLE `ims_mihua_sq_info_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `ims_mihua_sq_integral`
--
ALTER TABLE `ims_mihua_sq_integral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_member`
--
ALTER TABLE `ims_mihua_sq_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_msg`
--
ALTER TABLE `ims_mihua_sq_msg`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `ims_mihua_sq_mstime`
--
ALTER TABLE `ims_mihua_sq_mstime`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `ims_mihua_sq_option`
--
ALTER TABLE `ims_mihua_sq_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_goodsid` (`goodsid`),
  ADD KEY `indx_displayorder` (`displayorder`);

--
-- Indexes for table `ims_mihua_sq_order`
--
ALTER TABLE `ims_mihua_sq_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_order_goods`
--
ALTER TABLE `ims_mihua_sq_order_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_order_record`
--
ALTER TABLE `ims_mihua_sq_order_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_param`
--
ALTER TABLE `ims_mihua_sq_param`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_goodsid` (`goodsid`),
  ADD KEY `indx_displayorder` (`displayorder`);

--
-- Indexes for table `ims_mihua_sq_qiandao`
--
ALTER TABLE `ims_mihua_sq_qiandao`
  ADD PRIMARY KEY (`qiandao_id`);

--
-- Indexes for table `ims_mihua_sq_redpackage`
--
ALTER TABLE `ims_mihua_sq_redpackage`
  ADD PRIMARY KEY (`red_id`),
  ADD UNIQUE KEY `id` (`red_id`);

--
-- Indexes for table `ims_mihua_sq_refund`
--
ALTER TABLE `ims_mihua_sq_refund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_ring`
--
ALTER TABLE `ims_mihua_sq_ring`
  ADD PRIMARY KEY (`ring_id`);

--
-- Indexes for table `ims_mihua_sq_ring_zan`
--
ALTER TABLE `ims_mihua_sq_ring_zan`
  ADD PRIMARY KEY (`zan_id`);

--
-- Indexes for table `ims_mihua_sq_sensitiveword`
--
ALTER TABLE `ims_mihua_sq_sensitiveword`
  ADD PRIMARY KEY (`word_id`);

--
-- Indexes for table `ims_mihua_sq_share_history`
--
ALTER TABLE `ims_mihua_sq_share_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_shop`
--
ALTER TABLE `ims_mihua_sq_shop`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `ims_mihua_sq_shopinorder`
--
ALTER TABLE `ims_mihua_sq_shopinorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_shop_admin`
--
ALTER TABLE `ims_mihua_sq_shop_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ims_mihua_sq_shop_apply`
--
ALTER TABLE `ims_mihua_sq_shop_apply`
  ADD PRIMARY KEY (`aplly_id`);

--
-- Indexes for table `ims_mihua_sq_shop_cate`
--
ALTER TABLE `ims_mihua_sq_shop_cate`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `ims_mihua_sq_shop_cfg`
--
ALTER TABLE `ims_mihua_sq_shop_cfg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_shop_renew`
--
ALTER TABLE `ims_mihua_sq_shop_renew`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_shop_user`
--
ALTER TABLE `ims_mihua_sq_shop_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_spec`
--
ALTER TABLE `ims_mihua_sq_spec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_spec_item`
--
ALTER TABLE `ims_mihua_sq_spec_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indx_uniacid` (`uniacid`),
  ADD KEY `indx_specid` (`specid`),
  ADD KEY `indx_show` (`show`),
  ADD KEY `indx_displayorder` (`displayorder`);

--
-- Indexes for table `ims_mihua_sq_topic`
--
ALTER TABLE `ims_mihua_sq_topic`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `ims_mihua_sq_tpl`
--
ALTER TABLE `ims_mihua_sq_tpl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_userdiscount`
--
ALTER TABLE `ims_mihua_sq_userdiscount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_waitmessage`
--
ALTER TABLE `ims_mihua_sq_waitmessage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mihua_sq_zdorder`
--
ALTER TABLE `ims_mihua_sq_zdorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mobilenumber`
--
ALTER TABLE `ims_mobilenumber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_modules`
--
ALTER TABLE `ims_modules`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `idx_name` (`name`);

--
-- Indexes for table `ims_modules_bindings`
--
ALTER TABLE `ims_modules_bindings`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `idx_module` (`module`);

--
-- Indexes for table `ims_modules_plugin`
--
ALTER TABLE `ims_modules_plugin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `main_module` (`main_module`);

--
-- Indexes for table `ims_modules_recycle`
--
ALTER TABLE `ims_modules_recycle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulename` (`modulename`);

--
-- Indexes for table `ims_music_reply`
--
ALTER TABLE `ims_music_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_news_reply`
--
ALTER TABLE `ims_news_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_profile_fields`
--
ALTER TABLE `ims_profile_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_qrcode`
--
ALTER TABLE `ims_qrcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_qrcid` (`qrcid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `ticket` (`ticket`);

--
-- Indexes for table `ims_qrcode_stat`
--
ALTER TABLE `ims_qrcode_stat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_rule`
--
ALTER TABLE `ims_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_rule_keyword`
--
ALTER TABLE `ims_rule_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_content` (`content`),
  ADD KEY `rid` (`rid`),
  ADD KEY `idx_rid` (`rid`),
  ADD KEY `idx_uniacid_type_content` (`uniacid`,`type`,`content`);

--
-- Indexes for table `ims_site_article`
--
ALTER TABLE `ims_site_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_iscommend` (`iscommend`),
  ADD KEY `idx_ishot` (`ishot`);

--
-- Indexes for table `ims_site_category`
--
ALTER TABLE `ims_site_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_multi`
--
ALTER TABLE `ims_site_multi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `bindhost` (`bindhost`);

--
-- Indexes for table `ims_site_nav`
--
ALTER TABLE `ims_site_nav`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `multiid` (`multiid`);

--
-- Indexes for table `ims_site_page`
--
ALTER TABLE `ims_site_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `multiid` (`multiid`);

--
-- Indexes for table `ims_site_slide`
--
ALTER TABLE `ims_site_slide`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `multiid` (`multiid`);

--
-- Indexes for table `ims_site_store_goods`
--
ALTER TABLE `ims_site_store_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module` (`module`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `ims_site_store_order`
--
ALTER TABLE `ims_site_store_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goodid` (`goodsid`),
  ADD KEY `buyerid` (`buyerid`);

--
-- Indexes for table `ims_site_styles`
--
ALTER TABLE `ims_site_styles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_styles_vars`
--
ALTER TABLE `ims_site_styles_vars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_templates`
--
ALTER TABLE `ims_site_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_stat_fans`
--
ALTER TABLE `ims_stat_fans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`date`);

--
-- Indexes for table `ims_stat_keyword`
--
ALTER TABLE `ims_stat_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_createtime` (`createtime`);

--
-- Indexes for table `ims_stat_msg_history`
--
ALTER TABLE `ims_stat_msg_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_createtime` (`createtime`);

--
-- Indexes for table `ims_stat_rule`
--
ALTER TABLE `ims_stat_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_createtime` (`createtime`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_stat_visit`
--
ALTER TABLE `ims_stat_visit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `module` (`module`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_account`
--
ALTER TABLE `ims_uni_account`
  ADD PRIMARY KEY (`uniacid`);

--
-- Indexes for table `ims_uni_account_group`
--
ALTER TABLE `ims_uni_account_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_uni_account_menus`
--
ALTER TABLE `ims_uni_account_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `menuid` (`menuid`);

--
-- Indexes for table `ims_uni_account_modules`
--
ALTER TABLE `ims_uni_account_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_module` (`module`),
  ADD KEY `idx_uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_account_users`
--
ALTER TABLE `ims_uni_account_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_memberid` (`uid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_group`
--
ALTER TABLE `ims_uni_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_settings`
--
ALTER TABLE `ims_uni_settings`
  ADD PRIMARY KEY (`uniacid`);

--
-- Indexes for table `ims_uni_verifycode`
--
ALTER TABLE `ims_uni_verifycode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_userapi_cache`
--
ALTER TABLE `ims_userapi_cache`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_userapi_reply`
--
ALTER TABLE `ims_userapi_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_users`
--
ALTER TABLE `ims_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ims_users_failed_login`
--
ALTER TABLE `ims_users_failed_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_username` (`ip`,`username`);

--
-- Indexes for table `ims_users_founder_group`
--
ALTER TABLE `ims_users_founder_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_group`
--
ALTER TABLE `ims_users_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_invitation`
--
ALTER TABLE `ims_users_invitation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_code` (`code`);

--
-- Indexes for table `ims_users_permission`
--
ALTER TABLE `ims_users_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_profile`
--
ALTER TABLE `ims_users_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_video_reply`
--
ALTER TABLE `ims_video_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_voice_reply`
--
ALTER TABLE `ims_voice_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_wechat_attachment`
--
ALTER TABLE `ims_wechat_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `acid` (`acid`);

--
-- Indexes for table `ims_wechat_news`
--
ALTER TABLE `ims_wechat_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `attach_id` (`attach_id`);

--
-- Indexes for table `ims_wxapp_general_analysis`
--
ALTER TABLE `ims_wxapp_general_analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `ref_date` (`ref_date`);

--
-- Indexes for table `ims_wxapp_versions`
--
ALTER TABLE `ims_wxapp_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `version` (`version`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_wxcard_reply`
--
ALTER TABLE `ims_wxcard_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ims_account`
--
ALTER TABLE `ims_account`
  MODIFY `acid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_account_wxapp`
--
ALTER TABLE `ims_account_wxapp`
  MODIFY `acid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_article_category`
--
ALTER TABLE `ims_article_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_news`
--
ALTER TABLE `ims_article_news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_notice`
--
ALTER TABLE `ims_article_notice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_unread_notice`
--
ALTER TABLE `ims_article_unread_notice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_basic_reply`
--
ALTER TABLE `ims_basic_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_business`
--
ALTER TABLE `ims_business`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_attachment`
--
ALTER TABLE `ims_core_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ims_core_cron`
--
ALTER TABLE `ims_core_cron`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_cron_record`
--
ALTER TABLE `ims_core_cron_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_menu`
--
ALTER TABLE `ims_core_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_core_paylog`
--
ALTER TABLE `ims_core_paylog`
  MODIFY `plid` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_core_performance`
--
ALTER TABLE `ims_core_performance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_queue`
--
ALTER TABLE `ims_core_queue`
  MODIFY `qid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_refundlog`
--
ALTER TABLE `ims_core_refundlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_resource`
--
ALTER TABLE `ims_core_resource`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_sendsms_log`
--
ALTER TABLE `ims_core_sendsms_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_location`
--
ALTER TABLE `ims_coupon_location`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_cover_reply`
--
ALTER TABLE `ims_cover_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_custom_reply`
--
ALTER TABLE `ims_custom_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_images_reply`
--
ALTER TABLE `ims_images_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_cash_record`
--
ALTER TABLE `ims_mc_cash_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_chats_record`
--
ALTER TABLE `ims_mc_chats_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_credits_recharge`
--
ALTER TABLE `ims_mc_credits_recharge`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_credits_record`
--
ALTER TABLE `ims_mc_credits_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_fans_groups`
--
ALTER TABLE `ims_mc_fans_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_fans_tag_mapping`
--
ALTER TABLE `ims_mc_fans_tag_mapping`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_groups`
--
ALTER TABLE `ims_mc_groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mc_handsel`
--
ALTER TABLE `ims_mc_handsel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_mapping_fans`
--
ALTER TABLE `ims_mc_mapping_fans`
  MODIFY `fanid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ims_mc_mapping_ucenter`
--
ALTER TABLE `ims_mc_mapping_ucenter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_mass_record`
--
ALTER TABLE `ims_mc_mass_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_members`
--
ALTER TABLE `ims_mc_members`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ims_mc_member_address`
--
ALTER TABLE `ims_mc_member_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_member_fields`
--
ALTER TABLE `ims_mc_member_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_member_property`
--
ALTER TABLE `ims_mc_member_property`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_oauth_fans`
--
ALTER TABLE `ims_mc_oauth_fans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_menu_event`
--
ALTER TABLE `ims_menu_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_account`
--
ALTER TABLE `ims_mihua_sq_account`
  MODIFY `cash_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_address`
--
ALTER TABLE `ims_mihua_sq_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_admin`
--
ALTER TABLE `ims_mihua_sq_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_adv`
--
ALTER TABLE `ims_mihua_sq_adv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_area`
--
ALTER TABLE `ims_mihua_sq_area`
  MODIFY `area_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_balance`
--
ALTER TABLE `ims_mihua_sq_balance`
  MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_black`
--
ALTER TABLE `ims_mihua_sq_black`
  MODIFY `black_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_cart`
--
ALTER TABLE `ims_mihua_sq_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_cash`
--
ALTER TABLE `ims_mihua_sq_cash`
  MODIFY `cash_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_channel`
--
ALTER TABLE `ims_mihua_sq_channel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_chat`
--
ALTER TABLE `ims_mihua_sq_chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_city`
--
ALTER TABLE `ims_mihua_sq_city`
  MODIFY `city_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_citys`
--
ALTER TABLE `ims_mihua_sq_citys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_collect`
--
ALTER TABLE `ims_mihua_sq_collect`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_comment`
--
ALTER TABLE `ims_mihua_sq_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_discount`
--
ALTER TABLE `ims_mihua_sq_discount`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_discount_record`
--
ALTER TABLE `ims_mihua_sq_discount_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_fields`
--
ALTER TABLE `ims_mihua_sq_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_footmark`
--
ALTER TABLE `ims_mihua_sq_footmark`
  MODIFY `foot_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_get_redpackage`
--
ALTER TABLE `ims_mihua_sq_get_redpackage`
  MODIFY `get_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_goods`
--
ALTER TABLE `ims_mihua_sq_goods`
  MODIFY `goods_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_goods_cate`
--
ALTER TABLE `ims_mihua_sq_goods_cate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_group`
--
ALTER TABLE `ims_mihua_sq_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_info`
--
ALTER TABLE `ims_mihua_sq_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_infoorder`
--
ALTER TABLE `ims_mihua_sq_infoorder`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_info_comment`
--
ALTER TABLE `ims_mihua_sq_info_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_integral`
--
ALTER TABLE `ims_mihua_sq_integral`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_member`
--
ALTER TABLE `ims_mihua_sq_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_msg`
--
ALTER TABLE `ims_mihua_sq_msg`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_mstime`
--
ALTER TABLE `ims_mihua_sq_mstime`
  MODIFY `time_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_option`
--
ALTER TABLE `ims_mihua_sq_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_order`
--
ALTER TABLE `ims_mihua_sq_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_order_goods`
--
ALTER TABLE `ims_mihua_sq_order_goods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_order_record`
--
ALTER TABLE `ims_mihua_sq_order_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_param`
--
ALTER TABLE `ims_mihua_sq_param`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_qiandao`
--
ALTER TABLE `ims_mihua_sq_qiandao`
  MODIFY `qiandao_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_redpackage`
--
ALTER TABLE `ims_mihua_sq_redpackage`
  MODIFY `red_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_refund`
--
ALTER TABLE `ims_mihua_sq_refund`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_ring`
--
ALTER TABLE `ims_mihua_sq_ring`
  MODIFY `ring_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_ring_zan`
--
ALTER TABLE `ims_mihua_sq_ring_zan`
  MODIFY `zan_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_sensitiveword`
--
ALTER TABLE `ims_mihua_sq_sensitiveword`
  MODIFY `word_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_share_history`
--
ALTER TABLE `ims_mihua_sq_share_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop`
--
ALTER TABLE `ims_mihua_sq_shop`
  MODIFY `shop_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shopinorder`
--
ALTER TABLE `ims_mihua_sq_shopinorder`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop_admin`
--
ALTER TABLE `ims_mihua_sq_shop_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop_apply`
--
ALTER TABLE `ims_mihua_sq_shop_apply`
  MODIFY `aplly_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop_cate`
--
ALTER TABLE `ims_mihua_sq_shop_cate`
  MODIFY `cate_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop_cfg`
--
ALTER TABLE `ims_mihua_sq_shop_cfg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop_renew`
--
ALTER TABLE `ims_mihua_sq_shop_renew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_shop_user`
--
ALTER TABLE `ims_mihua_sq_shop_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_spec`
--
ALTER TABLE `ims_mihua_sq_spec`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_spec_item`
--
ALTER TABLE `ims_mihua_sq_spec_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_topic`
--
ALTER TABLE `ims_mihua_sq_topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_tpl`
--
ALTER TABLE `ims_mihua_sq_tpl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_userdiscount`
--
ALTER TABLE `ims_mihua_sq_userdiscount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_waitmessage`
--
ALTER TABLE `ims_mihua_sq_waitmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mihua_sq_zdorder`
--
ALTER TABLE `ims_mihua_sq_zdorder`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mobilenumber`
--
ALTER TABLE `ims_mobilenumber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules`
--
ALTER TABLE `ims_modules`
  MODIFY `mid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ims_modules_bindings`
--
ALTER TABLE `ims_modules_bindings`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `ims_modules_plugin`
--
ALTER TABLE `ims_modules_plugin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_recycle`
--
ALTER TABLE `ims_modules_recycle`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_music_reply`
--
ALTER TABLE `ims_music_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_news_reply`
--
ALTER TABLE `ims_news_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_profile_fields`
--
ALTER TABLE `ims_profile_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `ims_qrcode`
--
ALTER TABLE `ims_qrcode`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_qrcode_stat`
--
ALTER TABLE `ims_qrcode_stat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_rule`
--
ALTER TABLE `ims_rule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ims_rule_keyword`
--
ALTER TABLE `ims_rule_keyword`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ims_site_article`
--
ALTER TABLE `ims_site_article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_category`
--
ALTER TABLE `ims_site_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_multi`
--
ALTER TABLE `ims_site_multi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_site_nav`
--
ALTER TABLE `ims_site_nav`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_page`
--
ALTER TABLE `ims_site_page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_slide`
--
ALTER TABLE `ims_site_slide`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_goods`
--
ALTER TABLE `ims_site_store_goods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_order`
--
ALTER TABLE `ims_site_store_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_styles`
--
ALTER TABLE `ims_site_styles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_site_styles_vars`
--
ALTER TABLE `ims_site_styles_vars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_templates`
--
ALTER TABLE `ims_site_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_stat_fans`
--
ALTER TABLE `ims_stat_fans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ims_stat_keyword`
--
ALTER TABLE `ims_stat_keyword`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_stat_msg_history`
--
ALTER TABLE `ims_stat_msg_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_stat_rule`
--
ALTER TABLE `ims_stat_rule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_stat_visit`
--
ALTER TABLE `ims_stat_visit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ims_uni_account`
--
ALTER TABLE `ims_uni_account`
  MODIFY `uniacid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_uni_account_group`
--
ALTER TABLE `ims_uni_account_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account_menus`
--
ALTER TABLE `ims_uni_account_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account_modules`
--
ALTER TABLE `ims_uni_account_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_uni_account_users`
--
ALTER TABLE `ims_uni_account_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_uni_group`
--
ALTER TABLE `ims_uni_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_uni_verifycode`
--
ALTER TABLE `ims_uni_verifycode`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_userapi_cache`
--
ALTER TABLE `ims_userapi_cache`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_userapi_reply`
--
ALTER TABLE `ims_userapi_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ims_users`
--
ALTER TABLE `ims_users`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_users_failed_login`
--
ALTER TABLE `ims_users_failed_login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `ims_users_founder_group`
--
ALTER TABLE `ims_users_founder_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_group`
--
ALTER TABLE `ims_users_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_users_invitation`
--
ALTER TABLE `ims_users_invitation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_permission`
--
ALTER TABLE `ims_users_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_profile`
--
ALTER TABLE `ims_users_profile`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_video_reply`
--
ALTER TABLE `ims_video_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_voice_reply`
--
ALTER TABLE `ims_voice_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wechat_attachment`
--
ALTER TABLE `ims_wechat_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wechat_news`
--
ALTER TABLE `ims_wechat_news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wxapp_general_analysis`
--
ALTER TABLE `ims_wxapp_general_analysis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ims_wxapp_versions`
--
ALTER TABLE `ims_wxapp_versions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_wxcard_reply`
--
ALTER TABLE `ims_wxcard_reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
