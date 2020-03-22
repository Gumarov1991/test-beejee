<?php


namespace App\Controllers;


use App\Models\User;

class UserController
{
    public function actionLogin() : bool
    {
        $name = '';
        $password = '';
        $result = [];

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            if (!User::checkAdminData($name, $password)) {
                $result['status'] = 'error';
                $result['message'] = MESSAGE_ERROR_WRONG_NAME_OR_PASS;
            } else {
                User::authAdmin();
                $result['status'] = 'ok';
                $result['message'] = MESSAGE_SUCCESS_LOGIN;
            }

            echo json_encode($result);

            return true;
        }

        require_once 'App/views/user/login.php';

        return true;
    }

    public function actionLogout()
    {
        unset($_SESSION['user']);
        $url = MAIN_DIRECTORY;
        header("Location: $url");
    }
}