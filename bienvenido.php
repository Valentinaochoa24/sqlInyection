<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.wrapper {
    display: flex;
    width: 100%;
    height: 100vh;
}

#sidebar {
    width: 250px;
    background-color: #6c5ce7;
    color: #fff;
    padding: 20px;
    transition: all 0.3s;
}

#sidebar .sidebar-header {
    padding: 20px;
    background-color: #6c5ce7;
}

#sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

#sidebar ul li {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

#sidebar ul li a {
    color: #fff;
    text-decoration: none;
}

#sidebar ul li a:hover {
    color: #ccc;
}

#content {
    width: calc(100% - 250px);
    padding: 20px;
    transition: all 0.3s;
}

#content .navbar {
    background-color: #6c5ce7;
    color: purple;
    padding: 10px;
}

#content .navbar .btn {
    background-color: #6c5ce7;
    color: #fff;
    border: none;
    padding: 10px;
}

#content .container-fluid {
    padding : 20px;
}

.card {
    margin-bottom: 20px;
}

.card .card-body {
    padding: 20px;
}

.card .card-title {
    font-size: 18px;
    font-weight: bold;
}

.card .card-text {
    font-size: 14px;
    color: #666;
}
    </style>
</head>
<body>
  <?php  session_start();?>
    <div class="wrapper">
        <!-- Menu lateral -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Menu</h3>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="login.php">Cerrar Sesion</a>

                </li>
            </ul>
        </nav>
        <!-- Contenido principal -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <h1>Bienvenido!  <?php  echo $_SESSION['nombre'] .  " " . $_SESSION['apellido']; ?></h1>


            </nav>
            <div class="container-fluid">
                <!-- Contenido del dashboard -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- <script src="js/script.js"></script> -->
     <script>
      $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
          $('#sidebar').toggleClass('active');
          $('#content').toggleClass('active');
        });
      });
     </script>
</body>
</html>