<?php


namespace App\Controllers;


use App\Models\Task;
use App\Models\User;

class TaskController
{
    public function actionIndex() : bool
    {
        $name = '';
        $email = '';
        $taskText = '';

        if (isset($_POST['name'])) {
            $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $email = $_POST['email'];
            $taskText = filter_var($_POST['text'],FILTER_SANITIZE_STRING);
            $result = [];
            $errors = [];

            if (!User::checkEmail($email))
                $errors[] = MESSAGE_ERROR_EMAIL;

            if (!User::checkName($name))
                $errors[] = MESSAGE_ERROR_NAME;

            if (!Task::checkText($taskText))
                $errors[] = MESSAGE_ERROR_TASK_TEXT;

            if (!$errors) {
                $userId = User::checkUserExists($email)['id'] ?? User::add($name, $email);
                if (Task::add($taskText, $userId)) {
                    $result['status'] = 'ok';
                    $result['message'] = MESSAGE_SUCCESS_TASK_ADD;
                }
            } else {
                $result['status'] = 'error';
                $result['data'] = $errors;

            }

            echo json_encode($result);

            return true;
        }

        require_once 'App/views/task/index.php';

        return true;
    }

    public function actionEdit($id) :bool
    {
        if (!User::isAdmin()) {
            $result['status'] = 'not_admin';
            $result['message'] = MESSAGE_ERROR_UNLOGGED;
            echo json_encode($result);
            return true;
        }

        $taskText = filter_var($_POST['text'],FILTER_SANITIZE_STRING);
        $isReady = $_POST['is_ready'];
        $oldTaskText = Task::getTaskById($id)['text'];
        $oldIsEditByAdmin = Task::getTaskById($id)['is_edit_by_admin'];
        $isEditByAdmin = ($taskText === $oldTaskText) ? $oldIsEditByAdmin : 1;
        $result = [];

        if (!Task::checkText($taskText)) {
            $result['status'] = 'error';
            $result['message'] = MESSAGE_ERROR_TASK_TEXT;
        } else {
            $result['status'] = 'ok';
            Task::update($id, $taskText, $isReady, $isEditByAdmin);
            $dataTask = Task::getTaskById($id);
            $result['data'] = $dataTask;
            $result['message'] = MESSAGE_SUCCESS_TASK_EDIT;
        }

        echo json_encode($result);

        return true;
    }
}