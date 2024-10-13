<?php
// Conexión con la BD
include_once 'leer_configuracion.php';
session_start();

// Reiniciar mensajes de error o éxito
unset($_SESSION['mensaje']);

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Verificar que los campos no estén vacíos
    if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["correo"]) || empty($_POST["contrasena"])) {
        $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Por favor, complete todos los campos."];
        header("Location: registro_view.php");
        exit();
    }

    try {
        $nombre = limpiarEntradas($_POST['nombre']);
        $apellido = limpiarEntradas($_POST['apellido']);
        $fecha_nacimiento = limpiarEntradas($_POST['fecha_nacimiento']);
        $correo = mysqli_real_escape_string($conn, filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL));
        $salt = bin2hex(random_bytes(16)); // Genera el salt
        $contrasenaConSalt = $_POST['contrasena'] . $salt;
        $contrasena = hash('sha256', $contrasenaConSalt); // Hashear la contraseña con el salt

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Correo no válido."];
            header("Location: registro_view.php");
            exit();
        }
        if ($correo&& $nombre && $fecha_nacimiento && $apellido && $contrasena) {
        
            $sql = "INSERT INTO usuarios (nombres, apellidos, fecha_nacimiento, correo, contrasena, salt) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssssss", $nombre, $apellido, $fecha_nacimiento, $correo, $contrasena, $salt);
                if ($stmt->execute()) {
                    $_SESSION['mensaje'] = ["tipo" => "exito", "texto" => "Registro completo. ¡Bienvenido, $nombre $apellido!"];
                    header("Location: login.php");
                } else {
                    $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Error al registrar el usuario: " . $stmt->error];
                }
                $stmt->close();
            } else {
                $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Error en la preparación de la consulta: " . $conn->error];
            }
        }else {
            $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Correo o contraseña incorrectos."];
        }
    } catch (Exception $th) {
        error_log('Fatal error: ' . $th->getMessage());
        $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Error al registrar el usuario."];
    }
    header("Location: registro_view.php");
    exit();
}

function limpiarEntradas($contenido) {
    return htmlspecialchars(trim($contenido), ENT_QUOTES, 'UTF-8');
}
