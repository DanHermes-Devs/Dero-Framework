<?php

// Constant: To define whether we are working locally or remotely.
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));

// Constant: Define timezone
date_default_timezone_set('America/Mexico_City');

// Constant: Language
define('LANG', 'es');

// Constant: Base path of our project
define('BASEPATH', IS_LOCAL ? '/dero_framework/' : '___BASEPATH DE PRODUCCION___');

// Constant: Salt
define('AUTH_SALT', 'DeroFramework');

// Constant: Port and site url
define('PORT', '8848');
define('URL', IS_LOCAL ? 'http://127.0.0.1:'.PORT.'/dero_framework/' : '__URL EN PRODUCCION__');

// Constant: Directory and file paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd().DS);

// App folder directory
define('APP'        , ROOT.'app'.DS);
define('CLASSES'    , APP.'classes'.DS);
define('CONFIG'     , APP.'config'.DS);
define('CONTROLLERS', APP.'controllers'.DS);
define('FUNCTIONS'  , APP.'functions'.DS);
define('MODELS'     , APP.'models'.DS);

// Templates folder directory
define('TEMPLATES'  , ROOT.'templates'.DS);
define('INCLUDES'   , TEMPLATES.'includes'.DS);
define('MODULES'    , TEMPLATES.'modules'.DS);
define('VIEWS'      , TEMPLATES.'views'.DS);

// Assets folder directory
define('ASSETS'   , URL.'assets/');
define('CSS'      , ASSETS.'css/');
define('FAVICON'  , ASSETS.'favicon/');
define('FONTS'    , ASSETS.'fonts/');
define('IMAGES'   , ASSETS.'images/');
define('JS'       , ASSETS.'js/');
define('PLUGINS'  , ASSETS.'plugins/');
define('UPLOADS'  , ASSETS.'uploads/');

// Constants: Credentials for BBDD
// Set for local or development connection LDB: Local Data Base
define('LDB_ENGINE', 'mysql');
define('LDB_HOST', 'localhost');
define('LDB_NAME', 'dero_fw');
define('LDB_USER', 'root');
define('LDB_PASS', '');
define('LDB_CHARSET', 'utf8');

// Set for connection to production or real server
define('DB_ENGINE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', '__REMOTE CREDENTIALS BD__');
define('DB_USER', '__REMOTE CREDENTIALS BD__');
define('DB_PASS', '__REMOTE CREDENTIALS BD__');
define('DB_CHARSET', '__REMOTE CHARSET__');

// El controlador por defecto / el método por defecto / y el controlador de errores por defecto
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ERROR_CONTROLLER', 'error');
define('DEFAULT_METHOD', 'index');

