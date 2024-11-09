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
                    echo "<script>alert('Secion Iniciada'); window.location.href = 'dashboard.php';</script>";
                }
            
        }

    }




?>