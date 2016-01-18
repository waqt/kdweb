CREATE TABLE IF NOT EXISTS `web_cooperation` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
`company`  varchar(255) NOT NULL  COMMENT '公司名称',
`industry`  varchar(255) NOT NULL  COMMENT '行业',
`intention`  text NOT NULL  COMMENT '合作意向',
`contacts`  varchar(255) NOT NULL  COMMENT '联系人',
`phonenum`  varchar(255) NOT NULL  COMMENT '联系电话',
`mailbox`  varchar(255) NOT NULL  COMMENT '联系邮箱',
`code`  varchar(255) NOT NULL  COMMENT '验证码' ,
PRIMARY KEY (`id`));