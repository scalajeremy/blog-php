<?php
namespace App\Models;

use Slim\Container;

class User{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    //check if the user is in database
    public function authenticate($username, $password) : bool {
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        $sql = 'SELECT passwd, permission_lvl FROM users WHERE username = :username';
        $stmt= $this->container->db->prepare($sql);
        $stmt->bindValue('username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

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

    //add a user into the database
    public function addUser($firstname, $lastname, $email, $username, $password) : bool{
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = password_hash(htmlspecialchars($password),PASSWORD_BCRYPT, ['cost' => 10]);
        var_dump($this->container->db);
        try{
            $sql = 'INSERT INTO users (last_name, first_name, username, passwd, email, permission_lvl)
            VALUES (:last_name, :first_name, :username, :passwd, :email, 0)';
            $stmt = $this->container->db->prepare($sql);
            $req = $stmt->execute([
                'last_name' => $lastname,
                'first_name' => $firstname,
                'username' => $username,
                'passwd' => $password,
                'email' => $email
            ]);
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    //edit a user in the database
    public function editUser($firstname, $lastname, $email, $username, $password) : bool{
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = password_hash(htmlspecialchars($password),PASSWORD_BCRYPT, ['cost' => 10]);

        try{
            $sql = ''; //alter table to do
            $stmt= $this->container->db->prepare($sql);
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

    //delete the user in the database, (change a flag, not a real deletion)
    public function deleteUser() : book{
        return false;
    }

    //check if the user didn't change his session to be someone else
    // session secure / login.username.permission.time() => sha-256
    public function check() : bool{
        return true;
    }

    //change de permission lvl of a user
    public function changePermission($username, $permission) : bool{
        return false;
    }
}
