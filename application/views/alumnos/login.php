<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
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
height: 370px;
margin-top: auto;
margin-bottom: auto;
width: 400px;
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
background-color: #FFC314;
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
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


</head>
<body>

<?php
 
	   $errores=[];
	   if($_SERVER['REQUEST_METHOD']==='POST')
	   {
	

		$user = $_POST['usuario'];
		$password = $_POST['password'];
		
		//Hacemos uso de Get con parametro usuario
		$consulta = json_decode(
			file_get_contents('http://18.225.9.39/crud/index.php/Api_User/?usuario='.$user)
		);
		 
		if($consulta->status==1)
		{
			$passw= $consulta->data->pass;
			$usuario= $consulta->data->usuario;
			$status= $consulta->data->status;
			//verifiar si password es correcto
			$auth = password_verify($password, $passw);
			
		if($auth && $status!=0)
		{
			//Se inicia la sesion
			session_start();
			//Se llena la sesion
			$_SESSION['usuario']=$usuario;
			$_SESSION['login']=true;

			//Se redireciona 
			header('Location: /crud/index.php/inicio');
		}
		else if($status==0)
		{
			$errores[]="Debe validar el usuario";
		}
		 
		else
		{
			$errores[]="La contraseña no es correcta";
		}
			
		}
		else
		{
			$errores[]="Usuario no válido";
		}
		
	
	   }
       
    ?>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3 id="titulo" >Login</h3>
<?php foreach($errores as $error): ?>

	<div >
 <label id ="Epass" style="color:red; font-size:14px" > <?php echo $error; ?></label>

    </div>
<?php endforeach; ?>

			</div>
			<div class="card-body">
				<form method="POST">
                
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="usuario" id ="usuario" placeholder="Usuario" required>
						
					</div>
                   
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" name="password" class="form-control" id="contrasena" placeholder="Contraseña" required>
                        <div class="input-group-append">
            <button id="show_password" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
          </div>
					</div>
					
					<div class="d-flex justify-content-center" >
						<input type="submit" value="Login" class="btn float-right login_btn" >
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿Aún no tienes una cuenta? <a href="https://script.google.com/a/macros/miumg.edu.gt/s/AKfycbyIOSO339K4xaGAHzLbbviWq7IN7676hTdvrmlGYlZyDkEulExGQWrkQMcDmXYpZvtdYw/exec">Crear una Cuenta</a>
				</div>
				
			</div>
		</div>
	</div>
</div>
<script src="<?=base_url('./scripts.js')?>"></script>
<script>

function mostrarPassword(){
    var cambio = document.getElementById("contrasena");
   
    if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
   
    }else{
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
} 

</script>

</body>
</html>


