<?php

	namespace app\controllers;
	use app\models\mainModel;

	class loginController extends mainModel{

		/*----------  Controlador iniciar sesion  ----------*/
		public function iniciarSesionControlador(){

			$cedula=$this->limpiarCadena($_POST['login_cedula']);
		    $password=$this->limpiarCadena($_POST['login_password']);

		    # Verificando campos obligatorios #
		    if($cedula=="" || $password==""){
		        echo "<script>
			        Swal.fire({
					  icon: 'error',
					  title: 'Ocurrió un error inesperado',
					  text: 'No has llenado todos los campos que son obligatorios'
					});
				</script>";
		    }else{
			    # Verificando integridad de los datos de cedula#
			    if($this->verificarDatos("[0-9]{1,8}",$cedula)){
			        echo "<script>
				        Swal.fire({
						  icon: 'error',
						  title: 'Ocurrió un error inesperado',
						  text: 'La CEDULA no coincide con el formato solicitado'
						});
					</script>";
			    }else{
					// cambiar por formato a conveniencia 
			    	# Verificando integridad de los datos de la contraseña#
				    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$password)){
				        echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ocurrió un error inesperado',
							  text: 'La CONTRASEÑA no coincide con el formato solicitado'
							});
						</script>";
				    }else{

					    # Verificando cedula empleado #
					    $check_cedula=$this->ejecutarConsulta("SELECT * FROM e
						
						
						mpleado WHERE cedula='$cedula'");

					    if($check_cedula->rowCount()==1){

					    	$check_cedula=$check_cedula->fetch();

					    	if($check_cedula['cedula']==$cedula && password_verify($password,$check_cedula['usuario_password'])){

					    		$_SESSION['id']=$check_usuario['usuario_id'];
					            $_SESSION['nombre']=$check_usuario['usuario_nombre'];
					            $_SESSION['apellido']=$check_usuario['usuario_apellido'];
					            $_SESSION['usuario']=$check_usuario['usuario_usuario'];
					            $_SESSION['foto']=$check_usuario['usuario_foto'];


					            if(headers_sent()){
					                echo "<script> window.location.href='".APP_URL."dashboard/'; </script>";
					            }else{
					                header("Location: ".APP_URL."dashboard/");
					            }

					    	}else{
					    		echo "<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Ocurrió un error inesperado',
									  text: 'Cedula o Contraseña Incorrectos'
									});
								</script>";
					    	}

					    }else{
					        echo "<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'Cedula o Contraseña Incorrectos'
								});
							</script>";
					    }
				    }
			    }
		    }
		}


		/*----------  Controlador cerrar sesion  ----------*/
		public function cerrarSesionControlador(){

			session_destroy();

		    if(headers_sent()){
                echo "<script> window.location.href='".APP_URL."login/'; </script>";
            }else{
                header("Location: ".APP_URL."login/");
            }
		}

	}