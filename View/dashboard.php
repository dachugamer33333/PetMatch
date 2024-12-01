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
        /* Variables para colores */
        :root {
            --primary-color: #333; /* Gris oscuro */
            --secondary-color: #f9f9f9; /* Fondo claro */
            --highlight-color: #ff6f61; /* Naranja */
            --shadow-color: rgba(0, 0, 0, 0.1);
            --text-color: #555; /* Gris para texto */
        }

        /* General Styles */
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            line-height: 1.6;
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
            padding: 15px 20px;
            background-color: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 8px var(--shadow-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header .logo {
            font-size: 28px;
            font-weight: bold;
            color: var(--highlight-color);
        }

        .header .nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .nav a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .header .nav a:hover {
            color: var(--highlight-color);
        }

        .header .user {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header .user i {
            font-size: 20px;
        }

        /* Content */
        .content {
            margin-top: 30px;
            animation: fadeIn 1.5s ease;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px var(--shadow-color);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
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

        .card .content {
            flex: 1;
        }

        .user-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .description {
            margin-bottom: 10px;
            color: var(--text-color);
        }

        /* Buttons */
        .btn {
            padding: 10px 15px;
            background-color: var(--highlight-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #e55b54;
            transform: scale(1.05);
        }

        .btn:active {
            transform: scale(0.95);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                flex-wrap: wrap;
                text-align: center;
            }

            .header .nav {
                justify-content: center;
                margin-top: 10px;
            }

            .card {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn {
                width: 100%;
            }
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
                <?php $config->btns(); ?>
                <div class="user">
                    <span>
                        <?php
                            if (isset($_SESSION['usuario'])) {
                                echo $_SESSION['usuario'];
                            } else {
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
            <?php $config->pb($conn, $_SESSION['mostrarMas']); ?>
            <form method="post">
                <button type="submit" name="env" value="Mostrar mas" class="btn">Mostrar más</button>
            </form>
        </div>
    </div>
    <script src="renviar.js"></script>
</body>
</html>
