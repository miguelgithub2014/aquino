<?php

class Main extends conexion {

    protected static function get_consulta($pa, $datos) {
        $bd = new conexion();
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
        return self::procedimientoAlmacenado($pa, $datos, $bd);
    }

    // procedimiento almacenado para ejecutar consultas
    private function procedimientoAlmacenado($pa, $datos, $bd) {
        //convertimos a mayusculas los datos 
        $search  = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $replace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
        foreach ($datos as $key => $value) {
            $datos[$key]=str_replace($search, $replace, strtoupper($value) );
        }
        
        //arreglar archivo
        $config = parse_ini_file('config.ini', TRUE);
        $driver = $config['database']['driver'];
        switch ($driver) {
            case 'mssql': $sql = "execute ";
                break;
            case 'mysql': $sql = "call ";
                break;
            case 'pgsql': $sql = "select * from ";
                break;
            case 'oci': $sql = "execute ";
                break;
        }
        $sql = $sql . $pa . " ";
        if ($driver != 'mssql') {
            $sql = $sql . "(";
        }

        if ($datos != null) {
            for ($i = 1; $i <= count($datos); $i++) {
                $sql = $sql . "?";
                if ($i < count($datos)) {
                    $sql = $sql . ",";
                } else {
                    if ($driver != 'mssql') {
                        $sql = $sql . ")";
                    }
                }
            }
        } else {
            if ($driver != 'mssql') {
                $sql = $sql . ")";
            }
        }
//        die($sql);
        try {

            if ($driver == 'mysql') {
                //die('jajaja');
                $stmt = $bd->prepare($sql, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
            } else {
                $stmt = $bd->prepare($sql);
            }
            $j = 0;
            if ($datos != null) {
                for ($i = 0; $i < count($datos); $i++) {
                    $j++;
                    if (is_int($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_INT);
                    }
                    if (is_string($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_STR);
                    }
                    if (is_double($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_INT);
                    }
                    if (is_null($datos[$i])) {
                        $stmt->bindValue($j, $datos[$i], PDO::PARAM_NULL);
                    }
                }
            }
            $stmt->execute();
            $error = $stmt->errorInfo();
            if ($driver == 'mssql') {
                if ($error[2] == '(null) [0] (severity 0) [(null)]') {
                    return array($stmt, '');
                } else {
                    $url = str_replace(' ', '_', $error[2]);
                    die("<script> window.location=\"" . BASE_URL . "error/error_bd/" . $url . "\" ; </script>");
                }
            } else {
                return array($stmt, $error[2]);
//                if($error[2]!=''){
//                    return array($stmt, $error[2]);
//                }else{
//                    $url=str_replace(' ', '_', $error[2]);
//                    die("<script> window.location=\"".BASE_URL."error/error_bd/".$url."\" ; </script>");
//                }
            }

//            return array($stmt,$error[2]);
//            return $stmt;
        } catch (PDOException $e) {
            return false;
            echo '<script>
                alert("Fallo ejecucion!: ' . $e->getMessage() . '");
                    window.location="index.php";
                </script>';
        } catch (Exception $ex) {
            return false;
            echo '<script>
                alert("Fallo ejecucion!: ' . $ex->getMessage() . '");
                    window.location="index.php";
                </script>';
        }
    }

}

?>