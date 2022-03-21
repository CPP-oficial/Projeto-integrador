<?php
    class Users{
        private $pdo;
        public $msgERRO = "";

            //Método para conectar com o banco de dados
            
            public function connect($bdname, $host, $user, $password){
                global $pdo;
                global $msgERRO;

                try{
                    // 'mysql:$host;dbname=$database'
                    $pdo = new PDO("mysql:dbname=".$bdname.";host=".$host, $user, $password);
                } catch(PDOException $e){
                    $msgERRO = $e->getMessage();
                }
            }

            //Método de cadastro, mas aqui usamos ele só para cadastrar um admin para testes. 
            public function register($name, $email, $password){
                global $pdo;

                //Verificação se já há alguém esses dados
                $sql = $pdo->prepare("SELECT id_users FROM users WHERE email = :e");
                $sql->bindValue(":e", $email);
                $sql->execute();

                //Já está cadastrado
                if($sql->rowCount() > 0){
                    return false; 

                //Não é cadastrado
                }else{
                    $sql = $pdo->prepare("INSERT INTO users(name, email, password) VALUES(:n, :e, :p);");
                    $sql->bindValue(":n", $name);
                    $sql->bindValue(":e", $email);
                    $sql->bindValue(":p", md5($password));
                    $sql->execute();
                    return true;
                }

            }

            //Metodos para realizar o login
            public function log($email, $password){
                global $pdo;

                //Verificação de dados para poder logar
                $sql = $pdo->prepare("SELECT id_users FROM users WHERE email = :e AND password = :p");
                $sql->bindValue(":e", $email);
                $sql->bindValue(":p", md5($password));
                $sql->execute();

                //Acessar site apartir de uma sessão
                if($sql->rowCount() > 0){
                    $dado = $sql->fetch();
                    session_start();
                    $_SESSION['id_users'] = $dado['id_users'];
                    return true;

                }else{
                    return false;
                }
            }
    }
?>