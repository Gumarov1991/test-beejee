<?php

namespace App\Models;

use App\Components\Db;
use App\Models\User;

class Task
{
    public static function getAll($page = 1, $orderBy = 'id', $order = 'asc') : array
    {

        $tasks = [];
        $tasksPerPage = TASKS_PER_PAGE;
        $offset = ($page - 1) * $tasksPerPage;

        $db = Db::connect();
        $field = ($orderBy === 'id' || $orderBy === 'ready') ? "t.$orderBy" : "u.$orderBy";
        $sql = "SELECT 
                    t.text, t.ready, t.id, t.is_edit_by_admin, u.name, u.email
                    FROM tasks AS t
                    LEFT JOIN users AS u
                    ON t.author_id = u.id
                    ORDER BY $field $order
                    LIMIT $tasksPerPage
                    OFFSET $offset";

        $query = $db->query($sql);
        while ($row = $query->fetch()) {
            $tasks[] = $row;
        }

        return $tasks;
    }

    public static function getAllTasksCount() : int
    {
        $db = Db::connect();
        $sql = "SELECT COUNT(id) AS count FROM tasks";

        $query = $db->query($sql);
        $result = $query->fetch();

        return $result['count'];
    }

    public static function add($taskText, $userId, $isReady = false) : bool
    {
        $db = Db::connect();
        $sql = 'INSERT INTO tasks (text, author_id, ready) VALUES (?,?,?)';

        $query = $db->prepare($sql);
        $query->execute([$taskText, $userId, $isReady]);

        if ($query)
            return true;

        return false;
    }

    public static function update($id, $text, $isReady, $isEditByAdmin) : bool
    {
        $db = Db::connect();
        $sql = 'UPDATE tasks SET text=?, ready=?, is_edit_by_admin=? WHERE id=?';

        $query = $db->prepare($sql);
        $query->execute([$text, $isReady, $isEditByAdmin, $id]);

        if ($query)
            return true;

        return false;
    }

    public static function getTaskById($id)
    {
        $db = Db::connect();
        $sql = "SELECT 
                    t.text, t.ready, t.id, t.is_edit_by_admin, u.name, u.email
                    FROM tasks AS t
                    LEFT JOIN users AS u
                    ON t.author_id = u.id
                    WHERE t.id=?";

        $query = $db->prepare($sql);
        $query->execute([$id]);

        $result = $query->fetch();

        return $result;
    }

    public static function checkText($text) : bool
    {
        return (mb_strlen($text) >= MIN_LENGTH_TASK_TEXT && strlen($text) <= MAX_LENGTH_TASK_TEXT);
    }

}