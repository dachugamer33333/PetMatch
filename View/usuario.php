<?php
session_start();
require "../Model/conec.php";
require "../Controller/config.php";
$config=new Usuario;

if(!isset($_SESSION['id']))
{
    echo "<script> alert('Inicia secion'); window.location.href='login.php';</script>";
}

$sql=$conn->prepare("select * from usuarios where id = ? ");
$sql->bind_param('i',$_SESSION['id']);
$sql->execute();

$result=$sql->get_result();
$result=$result->fetch_assoc();
$pass = $result['pass']; // Usa la contraseña actual como predeterminada.
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $usuario=isset($_POST['usuario'])?$_POST['usuario'] : $result['name_user'];
   

    // Solo procesa la contraseña si fue proporcionada en el formulario.
    if (!empty($_POST['pass'])) {
        if ($_POST['pass'] != $result['pass']) {
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hashea si es nueva.
        } else {
            $pass = $_POST['pass']; // Mantén la contraseña actual si no cambia.
        }
    }


    if($_POST['env'] == "cambiar")
    {
        
        if($_POST['usuario'] != $result['name_user'])
        {
                $sql3=$conn->prepare("select name_user from usuarios where name_user = ?");
            $sql3->bind_param("s",$_POST['usuario']);
            $sql3->execute();
            $row=$sql3->get_result();

            if($row->num_rows > 0)
        {
            echo "<script>alert('Ya hay un usuario con este nombre'); window.location.href='usuario.php';</script>";
        }
        }
       
        
           
                $sql2=$conn->prepare("update usuarios set name_user=?,pass= ? where id=?");
                $sql2->bind_param("ssi",$usuario,$pass,$_SESSION['id']);
                if($sql2->execute())
                {
                    echo "<script> alert('se cambio exitosamente') </script>";
                    $config->logout();
                    
                }
        



      
    }
   
    
    if($_POST['env'] == "borrar")
    {
        $sql3=$conn->prepare("delete from usuarios where id=?");
        $sql3->bind_param("i",$_SESSION['id']);
        if($sql3->execute())
        {
            echo "<script> alert('Usuario Eliminado Exitosamente') </script>";
            $config->logout();
            
        }

    }
        

}
 






?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 800px;
            max-width: 100%;
        }
        .left-section {
            background: #4CAF50;
            color: #fff;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .left-section img {
            border-radius: 10px;
            width: 90%;
            max-width: 300px;
            height: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .right-section {
            flex: 2;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right-section h2 {
            margin: 0 0 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .form-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .permissions {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
        form button {
    background-color: #4CAF50; /* Color de fondo por defecto */
    color: white; /* Color del texto */
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-right: 10px; /* Separación entre botones */
}

/* Efecto hover para botones generales */
form button:hover {
    transform: scale(1.05); /* Efecto de aumento */
}

/* Botón "Cambiar" (verde, por defecto) */
form button[value="cambiar"] {
    background-color: #4CAF50;
}

form button[value="cambiar"]:hover {
    background-color: #45a049;
}

/* Botón "Borrar" (rojo) */
form button[value="borrar"] {
    background-color: #f44336; /* Color de fondo rojo */
}

form button[value="borrar"]:hover {
    background-color: #d32f2f; /* Color rojo más oscuro al pasar el mouse */
}

/* Efecto al hacer clic */
form button:active {
    transform: scale(0.95); /* Efecto de reducción */
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Sección Izquierda -->
        <div class="left-section">
            <?php
            
            if (isset($result['foto'])) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($result['foto']) . '" alt="User Icon">';
            } else {
                echo '<p>No hay imagen disponible.</p>';
            }



            ?>
        </div>
        
        <!-- Sección Derecha -->
         <form method="post">
            <div class="right-section">
                <h2>Perfil del Usuario</h2>
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="usuario" placeholder="Nombre del Usuario" value="<?php echo $result['name_user'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="pass" placeholder="Contraseña" >
                </div>
                <div class="permissions">
                    <strong>Permisos:</strong> <span id="permission-label"><?php echo $result['Rango'] ?></span>
                </div>
                <button type="submit" value="cambiar" name="env">Cambiar</button>
                <button type="submit" value="borrar" name="env">Borrar</button>
               

            </div>

         </form>
         <button onclick="rem()">Regresar</button>
    </div>
    <script src="renviar.js"></script>
</body>
</html>
