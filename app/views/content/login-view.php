<?php include('app/views/inc/head.php');  ?>


<div class="container">
    <div class="login-container">
        <div class="login-header">
            <img src="app/views/img/ine_logo_fondo_blanco.png" alt="Logo INE">
            <h3>Iniciar Sesión</h3>
            <p class="text-muted">Ingresa tus credenciales para continuar</p>
        </div>

        <form class="box login" action="" method="POST" autocomplete="off">

            <div class="mb-3">

                <div class="control">
                    <label class="form-label">Cédula de Identidad</label>
                    <input type="number" class="form-control" id="cedula" name="login_cedula"
                        placeholder="Ingresar Cédula de Identidad" maxlength="10" required>
                </div>


            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="login_clave"
                    pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="20" placeholder="Ingresa tu contraseña" required>
            </div>

                <button type="submit" class="btn btn-primary btn-login">Iniciar sesion</button>

        </form>
    </div>

</div>

<?php
	if(isset($_POST['login_cedula']) && isset($_POST['login_password'])){
		$insLogin->iniciarSesionControlador();
	}
?>

