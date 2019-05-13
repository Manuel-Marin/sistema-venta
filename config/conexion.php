<?php
  
  /*el session_start() debe estar en conexion.php ya que se usar� cuando se declaren las sessiones y si al momento de crearse las variables de sesion no se tiene este session_start() entonces no te loguearas, puedes hacer la prueba comentandolo y luego lo descomentas*/
 
/*
Importante: La funci�n session_start() debe ir siempre en la parte de arriba antes de escribir cualquier c�digo y en las paginas solo se llama una sola vez el session_start() si se llama dos veces dar� un error
*/
session_start();

  class Conectar{

   /*conexi�n a la base de datos*/
    
    protected static function conexion(){


		 		try {

		 			$conectar = new PDO("mysql:local=localhost;dbname=dbsistema","root","");

		 			$conectar->query("SET NAMES 'utf8'");
				   
				     return $conectar;
		 			
		 		} catch (Exception $e) {

		 			print "�Error!: " . $e->getMessage() . "<br/>";
		            die();  
		 			
		 		}
		 

		 } //cierre de llave de la function conexion()



		  public static function corta_palabra($palabra,$num){
		  
		  $largo=strlen($palabra);
		  $cadena=substr($palabra,0,$num);
		  return $cadena;
	}



		 public static function ruta(){

		 	return "http://localhost:8080/desarrollo/sitio1/";
		 }



  }     

?>