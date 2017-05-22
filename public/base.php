<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 20:56
 */


define( 'THINK_START_TIME', microtime( true ) );
define( 'THINK_START_MEM', memory_get_usage() );
define( 'EXT', '.php' );
define( 'DS', DIRECTORY_SEPARATOR );


defined( 'APP_PATH' ) or define( 'APP_PATH', dirname( $_SERVER[ 'SCRIPT_FILENAME' ] ) . DS );
defined( 'ROOT_PATH' ) or define( 'ROOT_PATH', dirname( realpath( APP_PATH ) ) . DS );
defined( 'EXTEND_PATH' ) or define( 'EXTEND_PATH', ROOT_PATH . 'extend' . DS );
defined( 'VENDOR_PATH' ) or define( 'VENDOR_PATH', ROOT_PATH . 'vendor' . DS );
//defined( 'RUNTIME_PATH' ) or define( 'RUNTIME_PATH', ROOT_PATH . 'runtime' . DS );
//defined( 'LOG_PATH' ) or define( 'LOG_PATH', RUNTIME_PATH . 'log' . DS );
//defined( 'CACHE_PATH' ) or define( 'CACHE_PATH', RUNTIME_PATH . 'cache' . DS );
//defined( 'TEMP_PATH' ) or define( 'TEMP_PATH', RUNTIME_PATH . 'temp' . DS );
//defined( 'CONF_PATH' ) or define( 'CONF_PATH', APP_PATH ); // 配置文件目录
defined( 'CONF_EXT' ) or define( 'CONF_EXT', EXT ); // 配置文件后缀
defined( 'ENV_PREFIX' ) or define( 'ENV_PREFIX', 'PHP_' ); // 环境变量的配置前缀

defined( 'THINK_PATH' ) or define( 'THINK_PATH', ROOT_PATH . 'thinkphp' . DS );
defined( 'LIB_PATH' ) or define( 'LIB_PATH', THINK_PATH . 'library' . DS );
defined( 'CORE_PATH' ) or define( 'CORE_PATH', LIB_PATH . 'think' . DS );
defined( 'TRAIT_PATH' ) or define( 'TRAIT_PATH', LIB_PATH . 'traits' . DS );

// 环境常量
defined( 'IS_CLI' ) or define( 'IS_CLI', PHP_SAPI == 'cli' ? true : false );
defined( 'IS_WIN' ) or define( 'IS_WIN', strpos( PHP_OS, 'WIN' ) !== false );


/*公共资源根路径*/
defined( 'PUBLIC_PATH' ) or define( 'PUBLIC_PATH', ROOT_PATH . 'public' . DS );

/*模板主题根路径*/
defined( 'THEME_PATH' ) or define( 'THEME_PATH', PUBLIC_PATH . 'theme' . DS );

/*上传根目录*/
defined( 'UPLOAD_PATH' ) or define( 'UPLOAD_PATH', PUBLIC_PATH . 'upload' . DS );

/*站点数据根目录*/
defined( 'SITE_DATA_PATH' ) or define( 'SITE_DATA_PATH', PUBLIC_PATH . 'site_data' . DS );
/*备份目录*/
defined( 'BACKUP_PATH' ) or define( 'BACKUP_PATH', SITE_DATA_PATH . 'backup' . DS );
/*配置目录*/
defined( 'CONFIG_PATH' ) or define( 'CONFIG_PATH', SITE_DATA_PATH . 'config' . DS );
defined( 'CONF_PATH' ) or define( 'CONF_PATH', ROOT_PATH . 'config' . DS );
/*锁目录*/
defined( 'LOCK_PATH' ) or define( 'LOCK_PATH', SITE_DATA_PATH . 'locks' . DS );
/*配置参数目录*/
defined( 'PARAM_PATH' ) or define( 'PARAM_PATH', SITE_DATA_PATH . 'param' . DS );
/*运行时目录*/
defined( 'RUNTIME_PATH' ) or define( 'RUNTIME_PATH', SITE_DATA_PATH . 'runtime' . DS );
defined( 'LOG_PATH' ) or define( 'LOG_PATH', RUNTIME_PATH . 'log' . DS );
defined( 'CACHE_PATH' ) or define( 'CACHE_PATH', RUNTIME_PATH . 'cache' . DS );
defined( 'TEMP_PATH' ) or define( 'TEMP_PATH', RUNTIME_PATH . 'temp' . DS );
defined( 'HTML_PATH' ) or define( 'HTML_PATH', RUNTIME_PATH . 'html' . DS );

