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
<div id="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h3>Входим под админом</h3>
                <form action="" method="post">
                    <input type="text" placeholder="login" name="name" value="<?php echo $name; ?>">
                    <input type="password" placeholder="Password" name="password" value="<?php echo $password; ?>">
                    <input type="submit" class="btn btn-default" name="submit" value="Login">
                </form>
            </div>
        </div>
    </div>
</div>