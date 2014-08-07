<?php //
$ns = 'http://localhost/nbd/webservice/';
$ep= 'http://localhost/nbd/webservice/servidor.php';
//se crea un objeto soap_server
$server = new soap_server();
//se configura el servidor
$server->configureWSDL('Servicio Web de Negocios Bendiciones de Dios', $ns,$ep);


$server->wsdl->addComplexType(
        'login', 
        'complexType', 
        'struct', 
        'all', 
        '', 
        array(
    'NOMBRE' => array('name' => 'NOMBRE', 'type' => 'xsd:string'),
    'APELLIDO' => array('name' => 'APELLIDO', 'type' => 'xsd:string')
        )
);

$server->wsdl->addComplexType(
        'info_producto', 
        'complexType', 
        'struct', 
        'all', 
        '', 
        array(
    'NOMBRE' => array('name' => 'NOMBRE', 'type' => 'xsd:string'),
    'APELLIDO' => array('name' => 'APELLIDO', 'type' => 'xsd:string')
        )
);

$server->wsdl->addComplexType(
        'caja', 
        'complexType', 
        'struct', 
        'all', 
        '', 
        array(
    'FECHA_HORA_AP' => array('name' => 'FECHA', 'type' => 'xsd:string'),
    'SALDO_AP' => array('name' => 'SALDO', 'type' => 'xsd:double')
        )
);
//sel_caja_android
$server->wsdl->addComplexType(
'productos',
'complexType',
'struct',
'all',
'',
array(
'ID_PRODUCTO'=>array('name' => 'NRO_HABITACION', 'type' => 'xsd:int'),
'DESCRIPCION'=>array('name' => 'DESCRIPCION', 'type' => 'xsd:string'),
'STOCKACTUAL'=>array('name' => 'STOCKACTUAL', 'type' => 'xsd:int'),
'UNIDAD'=>array('name' => 'UNIDAD', 'type' => 'xsd:string')
    )
);
//aquí cambiar
$server->wsdl->addComplexType(
'proveedores',
'complexType',
'struct',
'all',
'',
array(
'NOMBRE'=>array('name' => 'NOMBRE', 'type' => 'xsd:string'),
'TELFMOVIL'=>array('name' => 'TELFMOVIL', 'type' => 'xsd:string')
    )
);

$server->wsdl->addComplexType(
'productos_list',
'complexType',
'array',
'',
'',
array(),
array (
	array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:productos[]')
	),
'tns:productos'
);
$server->wsdl->addComplexType(
'proveedores_list',
'complexType',
'array',
'',
'',
array(),
array (
	array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:proveedores[]')
	),
'tns:proveedores'
);
//get_proveedor

$server->register('get_proveedores',                    // method name
    array('codigo' => 'xsd:string'),          // input parameters
    array('proveedores_list' => 'tns:proveedores_list'),    // output parameters
    'urn:servidor',                         // namespace
    'urn:servidor#get_proveedores',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'devuelve el total de proveedores con sus respectivos datos'        // documentation
);

$server->register('get_productos',                    // method name
    array('codigo' => 'xsd:string'),          // input parameters
    array('productos_list' => 'tns:productos_list'),    // output parameters
    'urn:servidor',                         // namespace
    'urn:servidor#get_productos',                   // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'devuelve el total de productos con sus respectivos datos'        // documentation
);

$server->register('login_user', // method name
        array('user' => 'xsd:string', 'clave' => 'xsd:string'), // input parameters
        array('login' => 'tns:login'), // output parameters
        'urn:servidor', // namespace
        'urn:servidor#login_user', // soapaction
        'rpc', // style
        'encoded', // use
        'Este Metodo permite hacer login en el sistema'        // documentation
);

$server->register('sele_caja', // method name
        array('codigo' => 'xsd:string'), // input parameters
        array('caja' => 'tns:caja'), // output parameters
        'urn:servidor', // namespace
        'urn:servidor#sele_caja', // soapaction
        'rpc', // style
        'encoded', // use
        'Este Metodo permite ver la ultima apertura de caja'        // documentation
);
////////***********funcion para validar usuario****************

function login_user($user, $clave) {
    $obj = new webservice_controlador();
    $res = $obj->login_usuario($user, $clave);
       return $res; 
}
//get_producto
function get_proveedores($codigo) {
    $obj = new webservice_controlador();
    $res = $obj->selecciona_proveedor($codigo);
       return $res; 
}
function get_productos($codigo){
    $obj = new webservice_controlador();
    $res = $obj->selecciona_productos();
    return $res;
}

function sele_caja($codigo){
   $obj = new webservice_controlador();
    $res = $obj->selecciona_caja();
       return $res; 
}

if (!isset($HTTP_RAW_POST_DATA))
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
$server->service($HTTP_RAW_POST_DATA);
//$r=login_user("admin","1");
//echo '<pre>';
//print_r($r);
//$r=get_habitaciones();
//echo '<pre>';
//print_r($r);
?>

