<?php

class User {
    private $container;

    public function __constructor($container) { 
        $this->container = $container;
    }

    public function authenticate($username, $password) : bool {
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        
        $sql = 'SELECT passwd, permission_lvl FROM users WHERE username = :username';
        $stmt= $this->container->db->prepare($sql);
        $stmt->bindValue('username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($password, $result['passwd'])) {
            return false;
        } else {
            $_SESSION['auth'] = [
                'login' => true,
                'username' => $username,
                'permission' => $result['permission_lvl'],
            ];
            return true;
        }
    }

    public function addUser($firstname, $lastname, $email, $username, $password) : bool{
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = password_hash(htmlspecialchars($password),PASSWORD_BCRYPT, ['cost' => 10]);
        
        try{
            $sql = 'INSERT INTO users (last_name, first_name, username, passwd, email, permission_lvl) 
            VALUES (:last_name, :first_name, :username, :passwd, :email, 0)';
            $stmt= $this->db->prepare($sql);
            $stmt->bindValue('last_name', $lastname, PDO::PARAM_STR);
            $stmt->bindValue('first_name', $firstname, PDO::PARAM_STR);
            $stmt->bindValue('username', $username, PDO::PARAM_STR);
            $stmt->bindValue('passwd', $password, PDO::PARAM_STR);
            $stmt->bindValue('email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function editUser($firstname, $lastname, $email, $username, $password) : bool{
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = password_hash(htmlspecialchars($password),PASSWORD_BCRYPT, ['cost' => 10]);

        try{
            $sql = 'INSERT INTO users (last_name, first_name, username, passwd, email, permission_lvl) 
            VALUES (:last_name, :first_name, :username, :passwd, :email, 0)';
            $stmt= $this->db->prepare($sql);
            $stmt->bindValue('last_name', $lastname, PDO::PARAM_STR);
            $stmt->bindValue('first_name', $firstname, PDO::PARAM_STR);
            $stmt->bindValue('username', $username, PDO::PARAM_STR);
            $stmt->bindValue('passwd', $password, PDO::PARAM_STR);
            $stmt->bindValue('email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function deleteUser() : book{
        return false;
    }

    public function check() : bool{
        return true;
        // session secure / login.username.permission.time() => sha-256
    }

    public function toAdmin($username) : bool{

    }
}