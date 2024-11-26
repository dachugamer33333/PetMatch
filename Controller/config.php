<?php
    require ("../Model/conec.php");
    require __DIR__ . '/../vendor/autoload.php';


    // Cargar las variables desde el archivo .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

    $dotenv->load();

    class Usuario{

        public function register($usuario,$pass,$conn)
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
                $sql=$conn->prepare("insert into usuarios(name_user,pass,Rango) values (?,?,?)");
                $sql->bind_param('sss',$usuario,$pass,$rango);
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
                    echo "<script>alert('Secion Iniciada'); window.location.href = 'dashboard.php';</script>";
                }
                else
                {
                    echo "<script>alert('Contraseña o Usuario Incorrectos'); window.location.href = 'register.php';</script>";
                }
            
        }

        public function pb($conn,$mostarMas)
        {
            $count=0;
            $sql=$conn->query("select * from publicacion where estado = 'publicado'");
            while($row=$sql->fetch_assoc())
            {
                $consul=$conn->prepare("select name_user from usuarios where id = ? ");
                $id_user=$row['usuario_id'];
                $consul->bind_param('s',$id_user);
                $consul->execute();
                $consul=$consul->get_result();
                $result=$consul->fetch_assoc();
                $count++;

                if($count <= $mostarMas)
                {
                      echo '<div class="p-4 bg-white rounded shadow flex items-center space-x-4">
                    <div class="bg-yellow-200 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user text-yellow-600"></i>
                    </div>
                    <div>
                        <div class="font-bold">'. $result['name_user'] .'</div>
                        <div>' . $row['descripcion'] . '</div>
                        <div> <form action="publicacion.php" method="POST"> <button name="id" class="p-1 bg-green-500 text-white rounded" type="submit" value="'.$row['id'].'">Ver Mas </button> </form>  </div>
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
            if(isset($_SESSION['usuario']) && isset($_SESSION['id']) )
            {
                echo '<form method="post">
                <input type="submit" name="cerrar" value="Cerrar secion" class="p-2 bg-red-500 text-white rounded" >
            </form>';
            }
            else
            {
                echo '<form method="post">
                <input type="submit" name="cerrar" value="Login" class="p-2 bg-green-500 text-white rounded" >
            </form>';
            }

            if ($_SESSION['rango']=="admin")
            {
                echo "<button onclick='remadm()' class='p-2 bg-green-500 text-white rounded'>Admin<button>";
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




?>