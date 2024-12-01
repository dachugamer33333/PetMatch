<?php
require '../Controller/config.php';
session_start();

$config = new Usuario;

// Inicializa la sesión si no existe
if (!isset($_SESSION['mostrarMas'])) {
    $_SESSION['mostrarMas'] = 5; // Inicializa el valor.
}

if (isset($_POST['env']) && $_POST['env'] == "Mostrar mas") {
    $_SESSION['mostrarMas'] += 5; // Incrementa 5 si el botón fue presionado.
}

echo "Mostrar más: " . $_SESSION['mostrarMas']; // Muestra el valor actualizado.

if(isset($_POST['cerrar']))
{
    if($_POST['cerrar']== 'Cerrar sesión')
    {
        $config->logout();
    }
    else
    {
        header('Location:login.php');
    }

}
?>
    






    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetMatch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header .logo {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }

        .header .nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .nav a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            font-weight: bold;
        }

        .header .nav a:hover {
            color: #007bff;
        }

        .header .nav .user {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 18px;
            color: #333;
        }

        .header .nav .user i {
            font-size: 24px;
        }

        /* Content */
        .content {
            width: 100%;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 15px;
        }

        .card .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
        }

        .card .btn:hover {
            background-color: #0056b3;
        }

        .card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 20px;
}

.avatar {
    background-color: #ffeb3b;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #ffc107;
}

.content {
    flex: 1;
}

.user-name {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 8px;
    color: #333;
}

.description {
    margin-bottom: 12px;
    color: #555;
}

.actions {
    display: flex;
    gap: 10px;
}

.actions form {
    margin: 0;
}

.btn {
    padding: 8px 12px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    text-align: center;
}

.btn:hover {
    background-color: #218838;
}

.form {
    margin: 0;
    display: inline-block;
}

.btn {
    padding: 8px 12px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-success {
    background-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-admin {
    padding: 8px 12px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
}

.btn-admin:hover {
    background-color: #0056b3;
}


    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">PETMATCH</div>
            <div class="nav">
                <a href="mensajes.php">Chat</a>
                <a href="publicar.php">Publicar</a>
               <?php
               $config->btns();
               ?>
                <div class="user">
                    <span>
                        <?php
                            if(isset($_SESSION['usuario']))
                            {
                                echo $_SESSION['usuario'];
                            }
                            else{
                                echo 'user';
                            }
                        ?>
                    </span>
                    <a href="usuario.php"><i class="fas fa-user-circle"></i></a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <?php
                $config->pb($conn, $_SESSION['mostrarMas']);
            ?>
            <form method="post">
                <button type="submit" name="env" value="Mostrar mas" class="btn">Mostrar más</button>
            </form>
        </div>
    </div>
    <script src="renviar.js"></script>
</body>
</html>
