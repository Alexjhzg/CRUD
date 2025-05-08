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
					
			    	# Verificando integridad de los datos de la contraseña#
				    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,20}",$password)){
				        echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ocurrió un error inesperado',
							  text: 'La CONTRASEÑA no coincide con el formato solicitado'
							});
						</script>";
				    }else{

					    # Verificando cedula empleado #
					    $check_empleado=$this->ejecutarConsulta("SELECT * FROM empleado WHERE cedula='$cedula'");

					    if($check_empleado->rowCount()==1){

					    	$empleado = $check_empleado->fetch();

					    	if($empleado['cedula'] == $cedula && $password == $empleado['password']){
								
								$_SESSION['cedula'] = $empleado['cedula'];
								$_SESSION['nombre'] = $empleado['nombre'];         
								$_SESSION['apellido'] = $empleado['apellido'];      
								$_SESSION['nivel_usuario'] = $empleado['nivel_usuario'];


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
									  text: 'Cedula o Contraseña Incorrectos 1'
									});
								</script>";
					    	}

					    }else{
					        echo "<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'Cedula o Contraseña Incorrectos 2'
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

		    if (headers_sent()) {
				echo "<script> window.location.href='" . APP_URL . "login/'; </script>";
			} else {
				header("Location: " . APP_URL . "login/");
			}
		}

	}