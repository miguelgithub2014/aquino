<?php

class conexion extends PDO {

    protected static $instancia = null;
    public static $_servidor = null;

    public function __construct() {
        $file = 'config.ini';
        @$settings = parse_ini_file($file, TRUE);
        $dsn = $settings['database']['driver'] . ':dbname=' . $settings['database']['basedatos'] . '; host=' . $settings['database']['host'] . '; port=' . $settings['database']['puerto'];
        self::$_servidor = $settings['database']['driver'];
        $user = $settings['database']['usuario'];
        $password = trim($settings['database']['password']);
        try {
            self::$instancia = parent::__construct($dsn, $user, $password);
            return self::$instancia;
        } catch (PDOException $e) {
            set_time_limit(20);
            if ($_POST['guardar'] == 1) {
                $host = $_POST['host'];
                $driver = $_POST['sgbd'];
                $user = $_POST['usuario'];
                $password = $_POST['clave'];
                $port = $_POST['puerto'];
                $dbname = $_POST['basedatos'];
                $archivo = '';
                if ($driver == 'oci') {
                    $archivo = 'OCI';
                } else {
                    $archivo = 'PDO';
                }
                $configuracion = array("archivo" => $archivo, "driver" => $driver, "usuario" => $user, "password" => $password, "host" => $host,
                    "puerto" => $port, "basedatos" => $dbname);
                $fp = fopen(ROOT . DS . "basedatos" . DS . "config.ini", "w");
                fwrite($fp, "[database]");
                $fp = fopen(ROOT . DS . "basedatos" . DS . "config.ini", "a+");
                foreach ($configuracion as $key => $valor) {
                    fwrite($fp, "\n" . $key . " = " . $valor);
                }
                fclose($fp);
                //            conexion::conexionSingleton();
                echo '<script>
                    alert("Datos GRABADOS Correctamente");
                    window.location="' . BASE_URL . '";
                </script>';
            }
            ?>

            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8" />
                    <script type="text/javascript" src="<?php echo BASE_URL ?>lib/js/jquery.js"></script>
                    <script type="text/javascript" src="<?php echo BASE_URL ?>lib/js/jquery.min.js"></script>

                    <script type="text/javascript">
                        alert("¡Conexion Fallida!. El sistema se inicializara, los datos que hayan sido guardados no se perderan.");

                        $(document).ready(function(){
                            setTimeout("$('#bienvenido1').fadeIn(600)",0);
                            setTimeout("$('#bienvenido1').fadeOut(500)",1900);
                            setTimeout("$('#bienvenido2').fadeIn(600)",1700);
                            setTimeout("$('#bienvenido2').fadeOut(400)",3200);
                            setTimeout("$('#bienvenido2').fadeIn(500)",3500);
                            setTimeout("$('#bienvenido2').fadeOut(500)",4700);
                            setTimeout("$('#bienvenido3').fadeIn(500)",5000);
                            setTimeout("$('#bienvenido3').fadeOut(1500)",7500);
                            setTimeout("$('#formulario_bd').fadeIn(500)",7800);

                            var delay_linea = 8000;//8000
                            var intervalo = 500;
                            setTimeout("$('#linealogo').fadeIn(500)",delay_linea);
                            setTimeout("$('#linea1').fadeIn(500)",delay_linea+(intervalo*2));
                            setTimeout("$('#linea2').fadeIn(500)",delay_linea+(intervalo*3));
                            setTimeout("$('#linea3').fadeIn(500)",delay_linea+(intervalo*4));
                            setTimeout("$('#linea4').fadeIn(500)",delay_linea+(intervalo*5));
                            setTimeout("$('#linea5').fadeIn(500)",delay_linea+(intervalo*6));
                            setTimeout("$('#linea6').fadeIn(500)",delay_linea+(intervalo*7));
                            setTimeout("$('#linea7').fadeIn(500)",delay_linea+(intervalo*8));

                        });
                    </script>
                </head>
                <body>
                    <div id="bienvenido1" style="display: none; width: 100%; height: 100%; position:absolute;top:50%;margin-top:-50px;">
                        <table align="center"><tr><td><text style="font-family: Arial; font-size: 50;">Bienvenido</text></td></tr></table></div>
                    <div id="bienvenido2" style="display: none; width: 100%; height: 100%; position:absolute;top:50%;margin-top:-50px;">
                        <table align="center"><tr><td><text style="font-family: Arial; font-size: 26;">Procederemos a inicializar el sistema...</text></td></tr></table></div>
                    <div id="bienvenido3" style="display: none; width: 100%; height: 100%; position:absolute;top:50%;margin-top:-50px;">
                        <table align="center"><tr><td><text style="font-family: Arial; font-size: 26;">Necesitaremos datos t&eacute;cnicos del sistema.<br>Contacte con el administrador si es que los desconoce.</text></td></tr></table></div>
                    <div id="linealogo" style="display: none; width: 100%; position:absolute;top:10%;text-align:center" align="center">
                        <img src="<?php echo BASE_URL ?>lib/img/titulo.png" width="400px"/>
                    </div>
                    <div id="formulario_bd" style="width: 100%; position:absolute;top:25%;">
                        <form method="post" action="index" id="frm" >
                            <input type="hidden" name="guardar" id="guardar" value="1"/>

                            <table class="tabForm" align="center">

                                <tr style="display: none" id="linea1">
                                    <td><label for="sgbd"><text style="font-family: Arial">SGBD: </text></label></td>
                                    <td>
                                        <select placeholder="Seleccione..." class="combo" name="sgbd" required id="sqbd">
                                            <option></option>
                                            <option value="mysql">MySQL</option>
                                            <option value="pgsql">PostgreSQL</option>
                                            <option value="mssql">SQL Server</option>
                                            <option value="oci">Oracle</option>
                                        </select>
                                        <span class="k-invalid-msg" data-for="sgbd"></span>
                                    </td>
                                    <td>
                                        <div class="k-invalid-msg msgerror" data-for="sgbd"></div>
                                    </td>
                                </tr>
                                <tr style="display: none" id="linea2">
                                    <td><label for="usuario"><text style="font-family: Arial">Usuario: </text></label></td>
                                    <td><input type="text" placeholder="Ingrese usuario" required class="k-textbox" name="usuario" value="" /></td>
                                    <td>
                                        <div class="k-invalid-msg msgerror" data-for="usuario"></div>
                                    </td>
                                </tr>
                                <tr style="display: none" id="linea3">
                                    <td><label for="password"><text style="font-family: Arial">Clave: </text></label></td>
                                    <td><input type="password" placeholder="Ingrese contrase&ntilde;a" class="k-textbox" name="clave" value="" /></td>
                                    <td>
                                        <div class="msgerror"></div>
                                    </td>
                                </tr>
                                <tr style="display: none" id="linea4">
                                    <td><label for="host"><text style="font-family: Arial">Host: </text></label></td>
                                    <td><input type="text" placeholder="Ingrese host" class="k-textbox" required name="host" value="" /></td>
                                    <td>
                                        <div class="k-invalid-msg msgerror" data-for="host"></div>
                                    </td>
                                </tr>
                                <tr style="display: none" id="linea5">
                                    <td><label for="puerto"><text style="font-family: Arial">Puerto: </text></label></td>
                                    <td><input type="text" placeholder="Ingrese puerto" class="k-textbox" required name="puerto" value="" /></td>
                                    <td>
                                        <div class="k-invalid-msg msgerror" data-for="puerto"></div>
                                    </td>
                                </tr>
                                <tr style="display: none" id="linea6">
                                    <td><label for="basedatos"><text style="font-family: Arial">Base de Datos: </text></label></td>
                                    <td><input type="text" placeholder="Ingrese nombre bd" class="k-textbox" required name="basedatos" value="" /></td>
                                    <td>
                                        <div class="k-invalid-msg msgerror" data-for="basedatos"></div>
                                    </td>
                                </tr>
                                <tr style="display: none" id="linea7">
                                    <td colspan="2" align="center">
                                        <p><button type="submit" class="k-button" id="saveform">Guardar</button>
                                            <button type="button" class="btn btn-info" onclick="window.location = '<?php echo BASE_URL ?>'">Cancelar</button></p>
                                    </td>
                                    <td>
                                        <div class="msgerror"></div>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>
                </body>
            </html>

            <?php
            die();
        }
    }

    public static function __callStatic($name, $args) {
        $callback = array(self :: conexionSingleton(), $name);
        return call_user_func_array($callback, $args);
    }

    public static function get_servidor() {
        switch (self::$_servidor) {
            case 'mssql': $_servidor = "SQL Server ";
                break;
            case 'mysql': $_servidor = "MySql ";
                break;
            case 'pgsql': $_servidor = "PostgreSQL";
                break;
            case 'oci': $_servidor = "Oracle";
                break;
            default :
                echo "<script>alert('No existe este servidor');
                            window.location='/localhost/';
                        </script>";
                break;
        }
        return $_servidor;
    }

}
?>
