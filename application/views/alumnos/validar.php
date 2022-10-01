<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->









<!DOCTYPE html>
<html>
<head>
	<title>Validar</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">





    <style>

@import url('https://fonts.googleapis.com/css?family=Numans');

html,body{
background-image: url('https://img.wallpapersafari.com/desktop/1024/576/29/44/xtkiDz.jpg');
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;
}

.container{
height: 100%;
align-content: center;
}

.card{
height: 230px;
margin-top: auto;
margin-bottom: auto;
width: 420px;
background-color: rgba(0,0,0,0.5) !important;
}

.social_icon span{
font-size: 60px;
margin-left: 10px;
color: #FFC312;
}

.social_icon span:hover{
color: white;
cursor: pointer;
}

.card-header h3{
color: white;
}

.social_icon{
position: absolute;
right: 20px;
top: -45px;
}

.input-group-prepend span{
width: 50px;
background-color: #FFC312;
color: black;
border:0 !important;
}

input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}

.remember{
color: white;
}

.remember input
{
width: 20px;
height: 20px;
margin-left: 15px;
margin-right: 5px;
}

.login_btn{
color: black;
background-color: #FFC312;
width: 100px;
}

.login_btn:hover{
color: black;
background-color: white;
}

.links{
color: white;
}

.links a{
margin-left: 4px;
}
#titulo
{
text-align: center;
}
#show_password {
-webkit-transition-duration: 0.4s; /* Safari */
transition-duration: 0.4s;
background-color: white;
color: black;
border: 1px solid #DCDCDC;
border-radius: 3px;
}

#show_password:hover {
background-color: #A9A9A9; /* Green */
color: white;
}


</style>

</head>
<body>

<?php
 
	   $errores=[];
	   $succes=[];
	   if($_SERVER['REQUEST_METHOD']==='POST')
	   {
	
//POST DATA
$codigo = $_POST['codigo'];
$url = "http://18.225.9.39/crud/index.php/Api_User/";

// Los datos de formulario
$datos = [
    "codigo" => $codigo
];
// Crear opciones de la petición HTTP
$opciones = array(
    "http" => array(
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($datos), # Agregar el contenido definido antes
    ),
);
# Preparar petición
$contexto = stream_context_create($opciones);
# Hacerla
$resultado = file_get_contents($url, false, $contexto);
$respuesta =  json_decode(($resultado));
if($respuesta)
{
	$estado= $respuesta->status;
	if($estado==0)
	{
		$succes[]="Felicidades, ya puedes iniciar sesión";
	
	}
	
	//$estado = $resultado->status;
	else if($estado==1)
			{
			$errores[]="Código ya validado";
			}
			

	
}
else 
{
	$errores[]="No existe";
}




}
	   
       
    ?>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3 id="titulo" >Validar Usuario</h3>
					<?php foreach($errores as $error): ?>

					<div >
 					<label id ="Epass" style="color:red; font-size:14px" > <?php echo $error; ?></label>
					
   					 </div>
					<?php endforeach; ?>

					<?php foreach($succes as $succ): ?>

					<div >
					 <label id ="Epas" style="color:green; font-size:14px" > <?php echo $succ; ?></label>

					</div>
					<?php endforeach; ?>


					</div>
					<div class="card-body">
				<form method="POST">
                
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-code"></i></span>
						</div>
						<input type="text" class="form-control" name="codigo" id ="codigo" placeholder="codigo" required>
						
					</div>
                   
				
					
					<div class="form-group">
					<div class="d-flex justify-content-center links">
					
				</div>
						<input type="submit" value="Validar" class="btn float-right login_btn"  >
					</div>
					<div class="d-flex justify-content-right links">
				<a href="http://18.225.9.39/crud/index.php/login">Vamos allá</a>
				</div>
				</form>
				</div>
		
		</div>
	</div>
</div>
<script src="<?=base_url('/application/resourses/js/scripts.js')?>"></>

<
</script>
</body>
</html>


