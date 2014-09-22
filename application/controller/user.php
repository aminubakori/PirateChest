<?php

/**
 * Class User
 */
class User extends Controller
{
    public function index()
    {
        require 'application/views/home/index.php';
    }

    public function register()
    {
        if(!isset($_SESSION))
        {
            ob_start();
            session_start();
        }
        $user_model = $this->loadModel('UserModel');
        $users = $user_model->db->select("pc_user");
        if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $username = trim(htmlentities($_POST['username']));
            $password = trim(htmlentities($_POST['password']));

            if(empty($users)) {
                $user = array(
                    "Username" => $username,
                    "Password" => md5($password)
                );
                $user_model->db->insert("pc_user", $user);
                $_SESSION['success'] = "Admin Account Added Successfully.";
                header("Location:".URL);
            }else {
                $_SESSION['error'] = "Admin User Already Exist.";
                header("Location:".URL);
            }
        }else {
            $_SESSION['error'] = "All Feilds Are Required.";
            header("Location:".URL);
        }
    }

    public function login()
    {
        if(!isset($_SESSION))
        {
            ob_start();
            session_start();
        }
        $user_model = $this->loadModel('UserModel');
        if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $username = trim(htmlentities($_POST['username']));
            $password = md5(trim(htmlentities($_POST['password'])));

            $user = $user_model->db->select("pc_user", "Username = '$username' AND Password = '$password'");
            if(empty($user)) {
                $_SESSION['error'] = "User Doesnt Exist.";
                header("Location:".URL);
            }else {
                $_SESSION['pc_user'] = $user[0]['ID'];
                if(isset($_POST['remember']) && $_POST['remember'] == "on") {
                    $remember = trim(htmlentities($_POST['remember']));
                    setcookie('pc_user', $_SESSION['pc_user'], time() + (86400 * 7)); //86400 == One Day -> that makes 7 days
                }
                header("Location:".URL);
            }
        }else {
            $_SESSION['error'] = "All Feilds Are Required.";
            header("Location:".URL);
        }
    }
}
