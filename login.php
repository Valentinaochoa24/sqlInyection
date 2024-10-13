<?php
// Conexión con la BD
include_once 'leer_configuracion.php';
session_start();

// Reiniciar mensajes de error o éxito
unset($_SESSION['mensaje']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = !empty($_POST['correo']) ? filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL) : null;
    $contrasena = limpiarEntradas($_POST['contrasena']); 

    // Validar con la BD
    if ($correo && $contrasena) {
        $sql = "SELECT nombres, apellidos, fecha_nacimiento, correo, contrasena, salt FROM usuarios WHERE correo = ?"; 
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("s", $correo); 
        $stmt->execute(); 
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nombre, $apellido, $fecha_nacimiento, $correo, $contrasenaCifrada, $salt);
            if ($stmt->fetch()) {
                // Concatenar la contraseña ingresada con el salt y generar el hash
                $contrasenaConSalt = $contrasena . $salt;
                $contrasenaCifradaDelFormulario = hash('sha256', $contrasenaConSalt);

                // Comparar el hash generado con el almacenado
                if ($contrasenaCifrada == $contrasenaCifradaDelFormulario) {
                    $_SESSION['correo'] = $correo;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellido'] = $apellido;
                    $_SESSION['mensaje'] = ["tipo" => "exito", "texto" => "Bienvenido, $nombre $apellido. Has iniciado sesión correctamente."];
                    header('Location: bienvenido.php');
                    exit();
                } else {
                    $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Correo o contraseña incorrectos."];
                }
            }
        } else {
            $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Correo o contraseña incorrectos."];
        }

        $stmt->close(); 
    } else {
        $_SESSION['mensaje'] = ["tipo" => "error", "texto" => "Por favor, completa todos los campos."];
    }
    header('Location: login_view.php');  // Redirecciona para evitar el resubmit del formulario
    exit();
}

function limpiarEntradas($contenido){
    return htmlspecialchars(trim($contenido), ENT_QUOTES, 'UTF-8');
}
?>
