<?php
/**
 * WordPress基础配置文件。
 *
 * 本文件包含以下配置选项：MySQL设置、数据库表名前缀、密钥、
 * WordPress语言设定以及ABSPATH。如需更多信息，请访问
 * {@link http://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 * 编辑wp-config.php}Codex页面。MySQL设置具体信息请咨询您的空间提供商。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以手动复制这个文件，并重命名为“wp-config.php”，然后填入相关信息。
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/data/home/qxu1098410073/htdocs/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'qdm115011382_db');

/** MySQL数据库用户名 */
define('DB_USER', 'qdm115011382');

/** MySQL数据库密码 */
define('DB_PASSWORD', 'hackxing');

/** MySQL主机 */
define('DB_HOST', 'qdm115011382.my3w.com');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':;N?-+6C46j{@/5a0?Y%< 9RMbTP[fE>x$|-hl8Q|Au+&gWdH2NlRP[gG/!otQcR');
define('SECURE_AUTH_KEY',  'B+z;+<^L?5p}v~0=gI- c[KATAnB$#)EA_}G-I$8xoiUg)oV!*3&1`r<;|Bpz!uL');
define('LOGGED_IN_KEY',    'l547qf<RoL(ibX5qQVZ8y;<FH+;l[v#X1jCBOaahy!AFERlTaKquY:Sk a=h6,=c');
define('NONCE_KEY',        '</kI>f9qqxz7zY<5kK:Ft1[%zh+u,t(A>R[MQ0s$kmeyD|^1%YN+nXm+0s8-LPYe');
define('AUTH_SALT',        '+E0j&p/j%|=?2tQ1o76+4@,WF10bZ:CJR_$dMJi7V?$C+LV4)$$UwQV%9dvbd6=-');
define('SECURE_AUTH_SALT', 'S?W0t6)VazS!Z/m6lQ9T_dife/?Bf+P<PdQ/!0d]W9oTAk,%<oYyz0Fy=PI2j[,X');
define('LOGGED_IN_SALT',   'E8#f|/F9`%E*8ju37j15m&8<&3qvRlU.3+,eH1zn?EpM{T)M]-zY.ud-oMq%BBZK');
define('NONCE_SALT',       '}*JMvm^Kr{,BT|qRQFd/E==PIQ$<VMVRNNdIi]l~+VJE1S?uyjFQMG|l=Mg?&%;a');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
