<?php

class Dero
{

    // Propiedades del Framework
    private $framework = 'Dero Framework';
    private $verion = '1.0.0';
    private $uri = [];

    // Funcion principal que se ejecuta al instanciar nuestra clase
    function __construct()
    {
        $this->init();
        $this->filter_url();
    }

    /**
     * Metodo para ejecutar cada "metodo" de forma subsecuente
     *
     * @return void
     */
    private function init()
    {
        $this->init_sesion();
        $this->init_load_config();
        $this->init_load_functions();
        $this->init_autoload();
        $this->init_csrf();
        $this->dispatch();
    }

    /**
     * Método para iniciar la sesion en el sistema
     * 
     * @return void
     */
    private function init_sesion()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return;
    }

    /**
     * Método para cargar archivo de configuracion
     * 
     * @return void
     */
    private function init_load_config()
    {
        $file = 'dero_config.php';
        if (!is_file('app/config/' . $file)) {
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $this->framework));
        }

        // Cargando el archivo de configuración
        require_once 'app/config/' . $file;

        return;
    }

    /**
     * Método para cargar las funciones Core del framework (Sistema)
     * 
     * @return void
     */
    private function init_load_functions()
    {
        $file = "dero_core_functions.php";
        if (!is_file(FUNCTIONS . $file)) {
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione', $file, $this->framework));
        }
        // Cargando el archivo funciones core
        require_once FUNCTIONS . $file;

        $file = "dero_custom_functions.php";
        if (!is_file(FUNCTIONS . $file)) {
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione', $file, $this->framework));
        }
        // Cargando el archivo funciones custom
        require_once FUNCTIONS . $file;

        return;
    }

    /**
     * Método para cargar las clases del framework (Autoload)
     * 
     * @return void
     */
    private function init_autoload()
    {
        require_once CLASSES . 'Autoload.php';
        Autoload::init();
        return;
    }

    /**
     * Método para crear un nuevo token de la sesión del usuario
     *
     * @return void
     */
    private function init_csrf()
    {
        $csrf = new Csrf();
        print_r($_SESSION);
    }

    /**
     * Método para filtrar y descomponer los elementos de nuestra url y uri
     * 
     * @return void
     */
    private function filter_url()
    {
        if (isset($_GET['uri'])) {
            $this->uri = $_GET['uri'];
            $this->uri = rtrim($this->uri, '/');
            $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
            $this->uri = explode('/', strtolower($this->uri));
            return $this->uri;
        }
    }

    /**
     * Método para ejecutar y cargar de forma automatica el controlador solicitado por el usuario
     * su método y pasar parametros a el
     * 
     * @return void
     */
    private function dispatch()
    {
        /**
         * Filtrar URL y Sperara URI
         * 
         */
        $this->filter_url();

        /**
         * Saber si se esta pasando el nombre de un controlador a nuesra URI
         * $this->uri[0] es el controlador en cuestion
         * 
         */
        if (isset($this->uri[0])) {
            $current_controller = $this->uri[0]; // users Controller.php
            unset($this->uri[0]);
        } else {
            $current_controller = DEFAULT_CONTROLLER; // home Controler.php
        }
        /**
         * Ejecución del controlador
         * Verificamos si existe una clase con el controlador solicitado
         * 
         */
        $controller = $current_controller . 'Controller'; // homeController
        if (!class_exists($controller)) {
            $controller = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
            $current_controller = DEFAULT_ERROR_CONTROLLER; // Para que el CONTROLLER sea error
        }

        /**
         * Ejecución del método solicitado
         * 
         */
        if (isset($this->uri[1])) {

            $method = str_replace('-', '_', $this->uri[1]);

            // Validamos que el método exista
            if (!method_exists($controller, $method)) {
                $controller = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
                $current_method = DEFAULT_METHOD; // Index
                $current_controller = DEFAULT_ERROR_CONTROLLER;
            } else {
                $current_method = $method;
            }

            unset($this->uri[1]);
        } else {
            $current_method = DEFAULT_METHOD; // Index
        }

        /**
         * Nuevas constantes a usar
         * 
         */
        define('CONTROLLER', $current_controller);
        define('METHOD', $current_method);

        /**
         * Ejecutando Controlador y metodo segun se haga la peticion
         * 
         */

        // Instanciando el controlador
        $controller = new $controller;

        // Obteniendo los parametros de la URI
        $params = array_values(empty($this->uri) ? [] : $this->uri);

        // Llamada al método que solicita el usuario en curso
        if (empty($params)) {
            call_user_func([$controller, $current_method]);
        } else {
            call_user_func_array([$controller, $current_method], $params);
        }

        return; // Línea final todo sucede entre esta línea y el comienzo
    }

    /**
     * Corre el Framework
     *
     */
    public static function init_dero()
    {
        $dero = new self();
        return;
    }
}
