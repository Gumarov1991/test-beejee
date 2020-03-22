<?php include 'App/views/layouts/header.php'; ?>

<header>
    <div class="container">
        <div class="row justify-content-between no-gutters mt-4 mb-4">
            <div class="col-sm-3">
                <a href="/beejee/task/add">Добавить задачу</a>
            </div>
            <div class="col-sm-6">
                <h1>Задачник</h1>
            </div>
            <div class="col-sm-3 login">
                <?php if (\App\Models\User::isAdmin()) : ?>
                    <a href="/beejee/logout">Выход</a>
                <?php else : ?>
                    <a href="/beejee/admin-login">Вход для Администратора</a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</header>
<div id="content">
    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Задачи</th>
                <th>
                    <div class="table-head">
                        Имя
                        <div class="sort-arrow">
                            <a href="/beejee/page-1?orderby=name"><i class="fas fa-sort-up"></i></a>
                            <a href="/beejee/page-1/?orderby=name&order=desc"><i class="fas fa-sort-down"></i></a>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="table-head">
                        Email
                        <div class="sort-arrow">
                            <a href="/beejee/page-1?orderby=email"><i class="fas fa-sort-up"></i></a>
                            <a href="/beejee/page-1?orderby=email&order=desc"><i class="fas fa-sort-down"></i></a>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="table-head">
                        Статус
                        <div class="sort-arrow">
                            <a href="/beejee/page-1?orderby=ready"><i class="fas fa-sort-up"></i></a>
                            <a href="/beejee/page-1?orderby=ready&order=desc"><i class="fas fa-sort-down"></i></a>
                        </div>
                    </div>
                </th>
                <?php if (\App\Models\User::isAdmin()) : ?>
                    <th>Дейсвия</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $task) : ?>
                <tr>
                    <td class="task-text"><?php echo $task['text']; ?></td>
                    <td><?php echo $task['name']; ?></td>
                    <td><?php echo $task['email']; ?></td>
                    <td class="col-status">
                        <div class="is-ready">
                            <p>Выполнено:</p>
                            <?php if ($task['ready']) : ?>
                                <i class="fas fa-check status-ready"></i>
                            <?php else : ?>
                                <i class="fas fa-times"></i>
                            <?php endif; ?>
                        </div>
                        <?php if ($task['is_edit_by_admin']) : ?>
                            <p class="is-edited">Отредактировано администратором</p>
                        <?php endif; ?>
                    </td>
                    <?php if (\App\Models\User::isAdmin()) : ?>
                        <td class="admin-actions">
                            <a class="edit-task" data-id="<?php echo $task['id']; ?>" href="#">Редатировать</a>
<!--                            <a class="rm-task" href="/beejee/task/remove/--><?php //echo $task['id']; ?><!--">Удалить</a>-->
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $pager; ?>
    </div>
</div>

</body>
</html>