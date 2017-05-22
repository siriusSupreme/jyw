<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 20:56
 */

defined( 'DS') or define( 'DS', DIRECTORY_SEPARATOR);

/*网站根路径*/
defined( 'ROOT_PATH') or define( 'ROOT_PATH', dirname( realpath( APP_PATH)).DIRECTORY_SEPARATOR);

/*公共资源根路径*/
defined( 'PUBLIC_PATH') or define( 'PUBLIC_PATH', ROOT_PATH.'public'.DIRECTORY_SEPARATOR);

/*模板主题根路径*/
defined( 'THEME_PATH') or define( 'THEME_PATH', PUBLIC_PATH.'theme'.DIRECTORY_SEPARATOR);

/*上传根目录*/
defined( 'UPLOAD_PATH') or define( 'UPLOAD_PATH', PUBLIC_PATH.'upload'.DIRECTORY_SEPARATOR);

/*站点数据根目录*/
defined( 'SITE_DATA_PATH') or define( 'SITE_DATA_PATH', PUBLIC_PATH.'site_data'.DIRECTORY_SEPARATOR);
/*备份目录*/
defined( 'BACKUP_PATH') or define( 'BACKUP_PATH', SITE_DATA_PATH.'backup'.DIRECTORY_SEPARATOR);
/*配置目录*/
defined( 'CONFIG_PATH') or define( 'CONFIG_PATH', SITE_DATA_PATH.'config'.DIRECTORY_SEPARATOR);
defined( 'CONF_PATH') or define( 'CONF_PATH', ROOT_PATH.'config'.DIRECTORY_SEPARATOR);
/*锁目录*/
defined( 'LOCK_PATH') or define( 'LOCK_PATH', SITE_DATA_PATH.'locks'.DIRECTORY_SEPARATOR);
/*配置参数目录*/
defined( 'PARAM_PATH' ) or define( 'PARAM_PATH', SITE_DATA_PATH . 'param' . DIRECTORY_SEPARATOR );
/*运行时目录*/
defined( 'RUNTIME_PATH') or define( 'RUNTIME_PATH', SITE_DATA_PATH.'runtime'.DIRECTORY_SEPARATOR);
defined( 'LOG_PATH') or define( 'LOG_PATH', RUNTIME_PATH.'log'.DIRECTORY_SEPARATOR);
defined( 'CACHE_PATH') or define( 'CACHE_PATH', RUNTIME_PATH.'cache'.DIRECTORY_SEPARATOR);
defined( 'TEMP_PATH') or define( 'TEMP_PATH', RUNTIME_PATH.'temp'.DIRECTORY_SEPARATOR);
defined( 'HTML_PATH') or define( 'HTML_PATH', RUNTIME_PATH.'html'.DIRECTORY_SEPARATOR);

