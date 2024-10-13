<?php
session_start();
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
unset($_SESSION['mensaje']); // Limpia el mensaje para que no se muestre después de la recarga
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            color: #ffffff;
        }
        .login-container {
            margin-top: 100px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            color: #fffbf3;
        }
        .input-field input {
            color: #ffffff;
        }
        .mensaje-exito {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .mensaje-error {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .is-invalid {
            border-color: red !important;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3 login-container">
                <h2 class="center-align">Iniciar Sesión</h2>

                <!-- Mostrar mensaje de error o éxito -->
                <?php if ($mensaje): ?>
                    <div class="mensaje-<?php echo $mensaje['tipo']; ?>">
                        <?php echo $mensaje['texto']; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="login.php" id="loginForm">
                    <div class="input-field col s12">
                        <input type="email" id="correo" name="correo" required>
                        <label for="correo">Correo</label>
                        <div class="error-message" id="correoError">Por favor, ingresa un correo válido.</div>
                    </div>

                    <div class="input-field col s12">
                        <input type="password" id="contrasena" name="contrasena" required>
                        <label for="contrasena">Contraseña</label>
                        <div class="error-message" id="contrasenaError">La contraseña debe tener al menos 8 caracteres.</div>
                    </div>

                    <button type="submit" class="btn waves-effect waves-light">Iniciar Sesión</button>
                </form>
                <p class="center-align">¿No tienes cuenta? <a href="registro_view.php" class="white-text">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        // Expresión regular para validar correos electrónicos
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Validación del correo en tiempo real
        document.getElementById('correo').addEventListener('input', function() {
            validarCampo('correo', emailRegex, 'correoError');
        });

        // Validación de la contraseña en tiempo real
        document.getElementById('contrasena').addEventListener('input', function() {
            const contrasena = this.value;
            const errorDiv = document.getElementById('contrasenaError');
            if (contrasena.length >= 8) {
                this.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            } else {
                this.classList.add('is-invalid');
                errorDiv.style.display = 'block';
            }
        });

        // Función de validación de campos
        function validarCampo(id, regex, errorId) {
            const campo = document.getElementById(id);
            const errorDiv = document.getElementById(errorId);
            if (regex.test(campo.value)) {
                campo.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            } else {
                campo.classList.add('is-invalid');
                errorDiv.style.display = 'block';
            }
        }

        // Validar formulario antes de enviarlo
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            let isValid = true;
            const correo = document.getElementById('correo');
            const contrasena = document.getElementById('contrasena');

            // Validar correo
            if (!emailRegex.test(correo.value)) {
                correo.classList.add('is-invalid');
                document.getElementById('correoError').style.display = 'block';
                isValid = false;
            }

            // Validar contraseña
            if (contrasena.value.length < 8) {
                contrasena.classList.add('is-invalid');
                document.getElementById('contrasenaError').style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Evita el envío si los campos no son válidos
                alert('Por favor, corrige los errores antes de iniciar sesión.');
            }
        });
    </script>
</body>
</html>
