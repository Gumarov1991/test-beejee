<?php

namespace App\Controllers;

use App\Models\Task;
use App\Components\Pagination;

class SiteController
{
    public function actionIndex($page = 1) : bool
    {
        $page = (int) $page;
        $orderBy = $_GET['orderby'] ?? 'id';
        $order = $_GET['order'] ?? 'asc';
        $countAllTasks = Task::getAllTasksCount();
        $pager = '';

        $pagination = new Pagination($countAllTasks, $page, TASKS_PER_PAGE, 'page-');

        if ($pagination->amount() > 1)
            $pager = $pagination->get();

        $tasks = Task::getAll($page, $orderBy, $order);

        require_once 'App/views/site/index.php';

        return true;
    }
}