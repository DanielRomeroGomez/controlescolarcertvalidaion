<?php 
session_start();

if(count($_SESSION) == 0){
    require_once 'app/login.php';

    $ses = new Sesion();
    $resS = $ses->validarSesion();
}
?>
<?php include_once('header.php');?>
		
		<!-------------------------sidebar------------>
<?php include_once('sidebar.php');?>
		     <!-- Sidebar  -->
        
		
		<!--------page-content---------------->
		
		
		   
		   <!--top--navbar----design--------->
<?php include_once('top-header.php');?>		   
		   
		   <!--------main-content------------->
<?php include_once('main-content.php');?>		   
		   
			 
			 <!---footer---->
<?php include_once('footer.php');?>			 
			 
			