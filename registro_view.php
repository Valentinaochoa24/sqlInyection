<?php
session_start();
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
unset($_SESSION['mensaje']); // Limpia el mensaje después de mostrarlo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        .container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .iniciar-sesion {
            margin-top: 20px;
            text-align: center;
        }
        .is-invalid {
            border-color: red;
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
        <form method="post" action="registro.php" class="col s12" id="registroForm">
            <h2 class="text-center">Registro de Usuario</h2>

            <!-- Mostrar mensaje de error o éxito -->
            <?php if ($mensaje): ?>
                <div class="mensaje-<?php echo $mensaje['tipo']; ?>">
                    <?php echo $mensaje['texto']; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
                <div class="error-message" id="nombreError">Solo se permiten letras y espacios (incluyendo ñ y tildes).</div>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
                <div class="error-message" id="apellidoError">Solo se permiten letras y espacios (incluyendo ñ y tildes).</div>
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
                <div class="error-message" id="correoError">Por favor, ingresa un correo válido.</div>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                <div class="error-message" id="contrasenaError">La contraseña debe tener al menos 8 caracteres.</div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>
        <div class="iniciar-sesion">
            <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Expresiones regulares para validaciones
        const nombreApellidoRegex = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Validar los campos en tiempo real
        document.getElementById('nombre').addEventListener('input', function() {
            validarCampo('nombre', nombreApellidoRegex, 'nombreError');
        });

        document.getElementById('apellido').addEventListener('input', function() {
            validarCampo('apellido', nombreApellidoRegex, 'apellidoError');
        });

        document.getElementById('correo').addEventListener('input', function() {
            validarCampo('correo', emailRegex, 'correoError');
        });

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

        // Función de validación general
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

        // Validar el formulario antes de enviar
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            let isValid = true;
            const nombre = document.getElementById('nombre');
            const apellido = document.getElementById('apellido');
            const correo = document.getElementById('correo');
            const contrasena = document.getElementById('contrasena');

            // Validar nombre
            if (!nombreApellidoRegex.test(nombre.value)) {
                nombre.classList.add('is-invalid');
                document.getElementById('nombreError').style.display = 'block';
                isValid = false;
            }

            // Validar apellido
            if (!nombreApellidoRegex.test(apellido.value)) {
                apellido.classList.add('is-invalid');
                document.getElementById('apellidoError').style.display = 'block';
                isValid = false;
            }

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
                event.preventDefault(); // Evitar que se envíe el formulario si no es válido
                alert('Por favor, corrige los errores antes de enviar.');
            }
        });
    </script>
</body>
</html>
