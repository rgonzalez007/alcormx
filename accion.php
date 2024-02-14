<?php
//session_start();
date_default_timezone_set("America/Mexico_City");
//include("conexion/patron.php");

/* if(@$_SESSION['SESION_USER']){

  $SESION_ADMIN_usuario= mysqli_fetch_row(mysqli_query($conexion,"SELECT `usuario_que_registra`  FROM `login_usuarios` WHERE `usuario`='".$_SESSION['SESION_USER']['usuario']."';"))[0];
  $SESION_ADMIN_id= mysqli_fetch_row(mysqli_query($conexion,"SELECT `id`  FROM `login_administradores` WHERE `usuario`='".$SESION_ADMIN_usuario."';"))[0];
  $SESION_detectada_id= $_SESSION['SESION_USER']['id'];
  $SESION_detectada_pais_region=$_SESSION['SESION_USER']['pais_region'];
  $SESION_detectada_usuario=$_SESSION['SESION_USER']['usuario'];
  $SESION_detectada_rol= $_SESSION['SESION_USER']['rol'];

  }else if(@$_SESSION['SESION_ADMIN']){
    $SESION_detectada_usuario=$_SESSION['SESION_ADMIN']['usuario'];
    $SESION_detectada_pais_region= $_SESSION['SESION_ADMIN']['pais_region'];
    $SESION_detectada_rol= $_SESSION['SESION_ADMIN']['rol'];
    $SESION_detectada_id= $_SESSION['SESION_ADMIN']['id'];
  }
 */

//incluir menu y variables de sessión:
//include 'definiciones_de_arrays.php';
if(!empty($_POST))
	{
 //estas lineas hacen que no se indefinan las variables post y tomen valor  ""
if($_POST['accion']=="Registrar") {
$arrayTipos = array("accion","nss","nacimiento","celular","email", "comentario");

}
//print_r($arrayTipos);
for ($i = 0; $i <= sizeof($arrayTipos)-1; $i++) {
if($_POST["$arrayTipos[$i]"]=="undefined"  ) {
	$_POST["$arrayTipos[$i]"]="";
}else{	
${$arrayTipos[$i]} = (isset($_POST["$arrayTipos[$i]"])) ? $_POST["$arrayTipos[$i]"] : "";
}
}
switch ($accion) {

  
case 'Registrar':

  
  $caracteres_prohibidos = array( ">", "'", '"',"null","\t","\n","\r","\R"); // quitar caracteres prohibidos
      for ($i=0; $i <sizeof($arrayTipos) ; $i++) {
for ($j=0; $j <sizeof($caracteres_prohibidos) ; $j++) { 
   ${$arrayTipos[$i]} = str_replace($caracteres_prohibidos[$j], "", ${$arrayTipos[$i]});
}
}
 

 // aqui van las busquedas de los valores para definir si hay restricciones.




/* esta restriccion asegura que los datos que tengan campo 4 no puedan ser modificados por una posible modifiacion en el script de readonly*/
$array_insert=array();
  for ($i=1; $i <sizeof($arrayTipos) ; $i++) {
$array_insert[$arrayTipos[$i]]=${$arrayTipos[$i]};
     }

if( $id!='' ){
$sql_array_comprobante="SELECT * FROM ".$tabla_principal." where id='$id' ";
$array_comprobante=mysqli_fetch_assoc(mysqli_query($conexion,$sql_array_comprobante));


for ($i=1; $i <=sizeof($array_comprobante) ; $i++) { // hace que no se puedan cambiar los valores de los campos marcados como 4 los que se ven sin modificar
  if($array_comprobante[$arrayTipos[$i]]!=$array_insert[$arrayTipos[$i]] & (in_array($i,$index_cabezales_los_que_se_ven_sin_modificar))){
    ${$arrayTipos[$i]}=$array_comprobante[$arrayTipos[$i]];
  }
}
for ($i=1; $i <=sizeof($array_comprobante) ; $i++) { // hace que no se puedan cambiar los valores de los campos marcados como 4 los que se ven sin modificar
  if($array_comprobante[$arrayTipos[$i]]!=$array_insert[$arrayTipos[$i]] & (in_array($i,$index_cabezales_los_hidden))){
    ${$arrayTipos[$i]}=$array_comprobante[$arrayTipos[$i]];
  }
  }
}
/**/

if($id=='' ){//echo 'NO HAY REGISTRO CON ESTE ID POR TANTO REGISTRO VALORES';
//aqui es la zona para cambiar valores por default
      $usuario=$SESION_detectada_usuario;
      $lugar=$SESION_detectada_pais_region;
      $epoc=time();
      $fecha=date("d/m/Y");
      $dia=date("z");
      $mes=date("n");
      $semana=date("W");
      $year=date("Y");



//termina la redefinicion por default
$array_insert=array();    
  
      for ($i=1; $i <sizeof($arrayTipos) ; $i++) {
 
$array_insert[$arrayTipos[$i]]=${$arrayTipos[$i]};
         }





/* $sql="INSERT INTO `".$tabla_principal."`  VALUES ('".implode("','", $array_insert)."')";
mysqli_query($conexion,$sql); */


//mandar mail con datos.

//AQUI ES EL ALGORITMO PARA ENVIAR CORREO:
$mensaje= $nss.",".$nacimiento.",".$celular.",".$email.",".$comentario;
$contenido= "Datos recibidos: ".$mensaje;
$cabeceras = 'Content-type: text/html; charset=UTF-8'. "\r\n".'From: PORTAL ALCORMX HOME <noreply@noreply.com.mx> ' . "\r\n" . 'Bcc: inmoviliariaalcormx@gmail.com' . "\r\n" .
    'Reply-To: noreply@noreply.com.mx' . "\r\n" . 
    'X-Mailer: PHP/' . phpversion();
mail("alcormx@alcormx.com,","PORTAL ALCORMX HOME",$contenido,$cabeceras);
//echo '<script>alert("SE HA ENVIADO CORREO A LA DIRECCION, ES PROBABLE QUE SE ENCUENTRE EN CORREOS NO DESEADOS.")</script> ';


estado_con_mensaje (1,'REGISTRO EXITOSO, ESPERE QUE UN EJECUTIVO SE COMUNIQUE CON USTED'
//.$nss.$nacimiento.$celular.$email.$comentario
);







}else if( $id!=''){ //echo 'ENTONCES ACTUALIZO SI ES QUE ANTES NO HAY RESTRICCIONES';


  if($estatus!=$array_comprobante['estatus']){
  $usuario=$SESION_detectada_usuario;
  $lugar=$SESION_detectada_pais_region;
  $epoc=time();
  $fecha=date("d/m/Y");
  $dia=date("z");
  $mes=date("n");
  $semana=date("W");
  $year=date("Y");
}
//cuando hay cambio el estatus entonces hay cambio de la huella del registro

$array_insert=array();    
      for ($i=1; $i <sizeof($arrayTipos) ; $i++) {
$array_insert[$arrayTipos[$i]]=${$arrayTipos[$i]};
         }

 $array_insert_reducido=array();
 $arrayTipos_reducido=array();
  $fecha_acum=date('d/m/Y');
$usuario_acum=$SESION_detectada_usuario;
$hora_acum=date('G:i:s');
$epoc_acum=time();
$string_cambios_reales_acumulados='';

for ($i=1; $i <=sizeof($array_comprobante) ; $i++) {
  if($array_comprobante[$arrayTipos[$i]]!=$array_insert[$arrayTipos[$i]]){
  //$array_insert_reducido[$arrayTipos[$i]]=$array_insert[$arrayTipos[$i]];
  //$arrayTipos_reducido[$arrayTipos[$i]]=$arrayTipos[$i];

array_push($array_insert_reducido, $array_insert[$arrayTipos[$i]]);

array_push($arrayTipos_reducido, $arrayTipos[$i]);
}

}
//print_r($arrayTipos_reducido);
 
//print_r($array_insert_reducido);
$acumulado_update="";
for ($i=0; $i <sizeof($arrayTipos_reducido) ; $i++) { //EMPEZAR EL UNO PROHIBE CAMBIAR EL id que eso de todas formas no es posible
//GENERACIÓN DE STRING donde el ultimo elemento va sin coma final:
if($i==sizeof($arrayTipos_reducido)-1){
      if($array_comprobante[$arrayTipos_reducido[$i]]==""){$array_comprobant_vista[$i]="vacío";}else{$array_comprobant_vista[$i]=$array_comprobante[$arrayTipos_reducido[$i]];}
      if($array_insert_reducido[$i]==""){$array_insert_reducido_vista[$i]="vacío";}else{$array_insert_reducido_vista[$i]=$array_insert_reducido[$i];}

        if($arrayTipos_reducido[$i]!='epoc'){$string_cambios_reales_acumulados=$string_cambios_reales_acumulados.$arrayTipos_reducido[$i]." de ".$array_comprobant_vista[$i]." a ".$array_insert_reducido_vista[$i]."//";
}$acumulado_update=$acumulado_update.$arrayTipos_reducido[$i]."='".$array_insert_reducido[$i];
 // no se registrara el cambio d epoc pero si funcionara para marcar la fecha de la versión de la especifición

}else{
if($array_comprobante[$arrayTipos_reducido[$i]]==""){$array_comprobant_vista[$i]="vacío";}else{$array_comprobant_vista[$i]=$array_comprobante[$arrayTipos_reducido[$i]];}
if($array_insert_reducido[$i]==""){$array_insert_reducido_vista[$i]="vacío";}else{$array_insert_reducido_vista[$i]=$array_insert_reducido[$i];}

if($arrayTipos_reducido[$i]!='epoc'){$string_cambios_reales_acumulados=$string_cambios_reales_acumulados.$arrayTipos_reducido[$i]." de ".$array_comprobant_vista[$i]." a ".$array_insert_reducido[$i]."//";}
$acumulado_update=$acumulado_update.$arrayTipos_reducido[$i]."='".$array_insert_reducido[$i]."',";

}
}
$sql_update="UPDATE ".$tabla_principal." SET  ".$acumulado_update. "' WHERE id='$id'";
//echo $sql_update;
  $sql_insertar_string_cambios_reales_acumulados="INSERT INTO `".$nombre_de_base_para_cambios_detalle."` VALUES ('','$id', '$string_cambios_reales_acumulados','$usuario_acum', '$fecha_acum', '$hora_acum', '', '$epoc_acum')";
mysqli_query($conexion,$sql_update);
 
if($string_cambios_reales_acumulados!=''){
  mysqli_query($conexion,$sql_insertar_string_cambios_reales_acumulados);
 
}
 
 

estado_con_mensaje (1,'ACTUALIZACIÓN EXITOSA! USUARIO: '.$SESION_detectada_usuario.". ");





}elseif($registrar == 0){

  estado_con_mensaje (0,'No se permite el registro en este módulo. Solo la actualización esta permitida');
  }



 break;
 

		}
 
}




function estado_con_mensaje ($estado_de_registro,$mensaje_de_registro){
	//pintar un array con un estado y con el mensaje
	$arr_de_registro = array('estado' => $estado_de_registro,'mensaje' => $mensaje_de_registro);
	
	echo  '['.json_encode($arr_de_registro).']';
	
	}