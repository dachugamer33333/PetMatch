<?php
    require ("../Model/conec.php");
    require __DIR__ . '/../vendor/autoload.php';


    // Cargar las variables desde el archivo .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

    $dotenv->load();

    class Usuario{

        public function register($usuario,$pass,$conn,$foto)
        {
            $rango="user";
            if ($pass==$_ENV['Admin_Pass'])
            {
                $rango="admin";
            }
            $pass=password_hash($pass,PASSWORD_DEFAULT);
            $sql=$conn->prepare("select * from usuarios where name_user=?");
            $sql->bind_param('s',$usuario);
            $sql->execute();
            $result=$sql->get_result();
            if($result->num_rows > 0)
            {
                echo "<script>alert('Ya hay un usuario Registrado con este nombre')</script>";
            }
            else
            {
                $sql=$conn->prepare("insert into usuarios(name_user,pass,Rango,foto) values (?,?,?,?)");
                $sql->bind_param('ssss',$usuario,$pass,$rango,$foto);
                if($sql->execute())
                {
                    echo "<script>alert('Registrado Exitosamente'); window.location.href = 'login.php';</script>";
                }



            }



        }

        public function login($usuario,$pass,$conn)
        {
            $sql=$conn->prepare("select * from usuarios where name_user=?");
            $sql->bind_param('s',$usuario);
            $sql->execute();
            
                $result=$sql->get_result();
                $user = $result->fetch_assoc();
                
                if($user && password_verify($pass,$user['pass']))
                {
                    session_start();
                    $_SESSION['usuario']=$user['name_user'];
                    $_SESSION['id']=$user['id'];
                    $_SESSION['rango']=$user['Rango'];
                    setcookie('id',$_SESSION['id']);
                    echo "<script>alert('Sesion Iniciada'); window.location.href = 'dashboard.php';</script>";
                }
                else
                {
                    echo "<script>alert('Contraseña o Usuario Incorrectos'); window.location.href = 'register.php';</script>";
                }
            
        }

       
        public function pb($conn,$mostarMas)
        {
            $count=0;
            $sql=$conn->query("select * from publicacion where estado = 'publicado' order by fecha_aceptacion desc");
            while($row=$sql->fetch_assoc())
            {
                $consul=$conn->prepare("select name_user,id,foto from usuarios where id = ? ");
                $id_user=$row['usuario_id'];
                $consul->bind_param('s',$id_user);
                $consul->execute();
                $consul=$consul->get_result();
                $result=$consul->fetch_assoc();
                $count++;

                if($count <= $mostarMas)
                {
                   
                    echo '<div class="card">
                    <div class="avatar">
                         <img src="data:image/jpeg;base64,' . base64_encode($result['foto']) . '" alt="User Icon">
                    </div>
                    <div class="content">
                        <div class="user-name">'. $result['name_user'] .'</div>
                        <div class="description">' . $row['descripcion'] . '</div>
                        <div class="actions">
                            <form action="publicacion.php" method="POST">
                                <button name="id" class="btn" type="submit" value="'.$row['id'].'">Ver Más</button>
                            </form>
                            <form action="mensajes.php" method="POST">
                                <button name="idm" class="btn" type="submit" value="'.$result['id'].'">Chat</button>
                            </form>
                        </div>
                    </div>
                  </div>';
            
                }
              
            }
        }
       

        public function pba($conn)
        {
            $sql=$conn->query("select * from publicacion where estado = 'pendiente'");
            while($row=$sql->fetch_assoc())
            {
                $consul=$conn->prepare("select name_user from usuarios where id = ? ");
                $id_user=$row['usuario_id'];
                $consul->bind_param('s',$id_user);
                $consul->execute();
                $consul=$consul->get_result();
                $result=$consul->fetch_assoc();
             

                
                    echo "<tr><td>".$row['id']."</td><td>".$row['descripcion']."</td><td>".$row['fecha_publicacion']."</td><td>".$result['name_user']."</td><td>".$row['edad']."</td><td>".$row['raza']."</td><td>".$row['estado']."</td><td><form method='post'><button type ='submit' class='aceptar' name='aceptar' value='".$row['id']."'>Aceptar</button></td><td><form method='post'><button type ='submit' class='rechazar' name='rechazar' value='".$row['id']."'>Rechazar</button></td><tr>";
                
  
            }


        }

        public function logout()
        {
            session_destroy();
            echo "<script> alert('ha cerrado secion correctamente'); window.location.href = 'login.php';</script>";
        }

        public function btns()
        {
            
            if (isset($_SESSION['usuario']) && isset($_SESSION['id'])) {
                echo '<form method="post" class="form">
                        <input type="submit" name="cerrar" value="Cerrar sesión" class="btn btn-danger">
                    </form>';
            } else {
                echo '<form method="post" class="form">
                        <input type="submit" name="cerrar" value="Inicia Sesion" class="btn btn-success">
                    </form>';
            }

            if (isset($_SESSION['rango']) && $_SESSION['rango'] == "admin") {
                echo '<button onclick="remadm()" class="btn btn-admin">Administrador</button>';
            }

        }

        public function publicar($conn,$foto,$descripcion,$edad,$especie)
        {
            if(isset($_SESSION['id']))
            {

                $usuario_id=$_SESSION['id'];
                $estado='pendiente';
                $fecha=date('Y-m-d');
                $sql=$conn->prepare('insert into publicacion(descripcion,fecha_publicacion,estado,raza,edad,foto,usuario_id) values (?,?,?,?,?,?,?)');
                $sql->bind_param('sssssss',$descripcion,$fecha,$estado,$especie,$edad,$foto,$usuario_id);
                if($sql->execute())
                {
                    echo '<script>alert("Publicacion esperando a ser aceptada")</script>';
                }
                else{
                    echo '<script>alert("Hubo un problema de conexion")</script>';
                } 
            }
            

        }

    }

    class Chats
    {
        // Mostrar la lista de receptores únicos con la última fecha de mensaje
        public function ver($conn, $id_emisor, $id_receptor)
        {
            $sql = $conn->prepare("
            SELECT DISTINCT
                CASE
                    WHEN m.emisor_id = ? THEN m.receptor_id
                    WHEN m.receptor_id = ? THEN m.emisor_id
                END AS user_id,
                u.name_user AS user_name,
                MAX(m.fecha) AS last_date
            FROM mensaje m
            JOIN usuarios u ON u.id = CASE
                WHEN m.emisor_id = ? THEN m.receptor_id
                WHEN m.receptor_id = ? THEN m.emisor_id
            END
            WHERE m.emisor_id = ? OR m.receptor_id = ?
            GROUP BY user_id, u.name_user
            ORDER BY last_date DESC
        ");
        $sql->bind_param('iiiiii', $id_emisor, $id_emisor, $id_emisor, $id_emisor, $id_emisor, $id_emisor);
        $sql->execute();
        $result = $sql->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $last_date = $row['last_date'];
        
            echo "
            <tr>
                <td>
                    <form method='POST'>
                        <button type='submit' name='reca' value='{$user_id}'>Abrir Chat</button>
                    </form>
                </td>
                <td>{$user_name}</td>
                <td>{$last_date}</td>
            </tr>";
        }
        }
    
        // Mostrar los mensajes entre el usuario actual y el receptor seleccionado
        public function mensajesVer($conn, $id_rec, $id_emisor)
        {
            $sql = $conn->prepare("
                SELECT * 
                FROM mensaje 
                WHERE (receptor_id = ? AND emisor_id = ?) 
                   OR (receptor_id = ? AND emisor_id = ?)
                ORDER BY fecha ASC
            ");
            $sql->bind_param('iiii', $id_rec, $id_emisor, $id_emisor, $id_rec);
            $sql->execute();
            $result = $sql->get_result();
    
            // Mostrar los mensajes
            while ($row = $result->fetch_assoc()) {
                if ($row['emisor_id'] == $id_emisor) {
                    // Mensaje enviado
                    echo "<p class='emi'>{$row['contenido']}</p>";
                } else {
                    // Mensaje recibido
                    echo "<p class='rec'>{$row['contenido']}</p>";
                }
            }
        }
    }
    

?>