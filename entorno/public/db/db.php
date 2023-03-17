<?php
/**
 * Clase que implementa un método estático para realizar la conexión a la BBDD. Obtiene los datos de conexión
 * de variables de entorno existentes en el fichero .env.
 */
class Database {

    private $db=null;
    
    /**
     * Método que inicia la conexión y la devuelve.
     */
    public static function connect ()
    {
        $host='mariadb';
        $dbname=getenv ('MARIADB_DATABASE');

        try {
            $dsn = 'mysql:host='.$host.";dbname=".$dbname.";charset=UTF8";;
            $dbh = new PDO($dsn, getenv('MARIADB_USER'), getenv ('MARIADB_PASSWORD'));
            $dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;

        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

}
?>