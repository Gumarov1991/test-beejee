<?php include 'App/views/layouts/header.php'; ?>
<header>
    <div class="container">
        <div class="row justify-content-center mt-4 mb-4">
            <div class="col-12">
                <a class="back-home" href="/beejee/">Главная</a>
                <h1>Задачник</h1>
            </div>

        </div>
    </div>
</header>
<div id="add-task">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h3>Добавить задачу</h3>
                <form action="" method="post">
                    <input type="text" placeholder="login" name="name" value="<?php echo $name; ?>">
                    <input type="email" placeholder="email" name="email" value="<?php echo $email; ?>">
                    <textarea name="text" cols="30" rows="10" value="<?php echo $taskText; ?>"></textarea>
                    <input type="submit" class="btn btn-default" name="submit" value="Add">
                </form>
                <ul class="ajax-resp">

                </ul>
            </div>
        </div>
    </div>
</div>