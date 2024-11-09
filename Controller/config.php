<?php
    require ("../Model/conec.php");

    class Usuario{

        public function register($usuario,$pass,$conn)
        {
            $rango="user";
            if ($pass=="admin")
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
                    echo "<script>alert('Registrado Exitosamente')</script>";
                }



            }



        }

    }




?>