-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ca`
--
CREATE DATABASE `ca` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ca`;

-- --------------------------------------------------------

--
-- 表的结构 `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `cid` varchar(26) NOT NULL,
  `app_uid` int(255) NOT NULL,
  `app_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- 表的结构 `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `admin_uid` int(11) NOT NULL COMMENT '管理者uid',
  `uid` varchar(255) NOT NULL COMMENT '学生id',
  `cname` varchar(16) NOT NULL,
  `school` varchar(24) NOT NULL,
  `create_time` char(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`cid`),
  FULLTEXT KEY `cname` (`cname`,`school`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL COMMENT 'email',
  `classes` char(255) NOT NULL COMMENT '所在班级',
  `username` varchar(16) NOT NULL,
  `sex` tinyint(3) NOT NULL DEFAULT '3',
  `age` smallint(150) NOT NULL,
  `work` varchar(125) NOT NULL,
  `address` varchar(125) NOT NULL,
  `qq` varchar(10) NOT NULL,
  `telephone` varchar(11) NOT NULL,
  `passwd` char(32) NOT NULL COMMENT 'md5密码',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email_2` (`email`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
