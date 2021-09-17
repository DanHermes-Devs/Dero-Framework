<?php

class Db
{
    private $link;
    private $engine;
    private $host;
    private $name;
    private $user;
    private $pass;
    private $charset;

    /**
     * Constructor para la clase DB
     * 
     * @return void
     */
    public function __construct()
    {
        $this->engine  = IS_LOCAL ? LDB_ENGINE  : DB_ENGINE;
        $this->host    = IS_LOCAL ? LDB_HOST    : DB_HOST;
        $this->name    = IS_LOCAL ? LDB_NAME    : DB_NAME;
        $this->user    = IS_LOCAL ? LDB_USER    : DB_USER;
        $this->pass    = IS_LOCAL ? LDB_PASS    : DB_PASS;
        $this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;
        return $this;
    }

    /**
     * Método para crear una conexión
     * 
     */

    private function connect()
    {
        try {
            $this->link = new PDO($this->engine . ':host=' . $this->host . ';dbname=' . $this->name . ';charset=' . $this->charset, $this->user, $this->pass);
            return $this->link;
        } catch (PDOException $e) {
            die(sprintf('No hay conexión a la BD, hubo un error: %s', $e->getMessage()));
        }
    }

    /**
     * Método para hacer queryes a la BD
     * 
     * @param string $sql
     * @param array $params
     * @return void
     */
    public static function query($sql, $params = [])
    {
        $db = new self();
        $link = $db->connect(); // Conexion a la DB
        $link->beginTransaction(); // Error, Checkpoint
        $query = $link->prepare($sql);

        // Manejar errores en el query o la peticion
        if (!$query->execute($params)) {
            $link->rollback();
            $error = $query->errorInfo();
            throw new Exception($error[2]);
        }

        // Manejando el tipo de query
        if (strpos($sql, 'SELECT') !== false) {

            return $query->rowCount() > 0 ? $query->fetchAll() : false;
        } elseif (strpos($sql, 'INSERT') !== false) {

            $id = $link->lastInsertId();
            $link->commit();
            return $id;
        } elseif (strpos($sql, 'UPDATE') !== false) {

            $link->commit();
            return true;
        } elseif (strpos($sql, 'DELETE') !== false) {

            if ($query->rowCount() > 0) {

                $link->commit();
                return true;
            }

            $link->rollBack();
            return false; // Nada ha sido borrado

        } else {

            $link->commit();
            return true;
        }
    }
}
