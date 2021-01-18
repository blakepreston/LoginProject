<?php
session_start(); // grab a session that is created

echo "My First PHP Project <br />";

if (isset($_POST['login'])) {
    require('./config/db.php');

    $userEmail = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
    $userPassword = filter_var($_POST["userPassword"], FILTER_SANITIZE_STRING);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? ');
    $stmt->execute([$userEmail]);

    $user = $stmt->fetch();

    if (isset($user)) {
        if (password_verify($userPassword, $user->password)) {
            echo "The password is correct";
            $_SESSION['userId'] = $user->id;
            header('Location: http://localhost/login-project/index.php');
        } else {
            $loginWrong = "Incorrect Password or Email.";
        }
    }

    // if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    //     $stmt = $pdo->prepare('SELECT* FROM users WHERE email=? ');
    //     $stmt->execute([$userEmail]);
    //     $totalUsers = $stmt->rowCount();

    //     echo $totalUsers . '<br >';

    //     if ($totalUsers > 0) {
    //         $emailTaken = "Email Already Used <br />";
    //     } else {
    //         $stmt2 = $pdo->prepare('INSERT into users(name, email, password) VALUES(?, ?, ?)');
    //         $stmt2->execute([$userName, $userEmail, $passwordHashed]);
    //     }
    // }
}
?>

<?php require('./inc/header.html'); ?>

<div class="container">
    <div class="card">
        <div class="card-header bg-light mb-3">Login</div>
        <div class="card-body">
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="userEmail">User Email</label>
                    <input require type="email" name="userEmail" class="form-control">
                    <br />
                    <?php if (isset($loginWrong)) {  ?>
                        <p style="background-color: red;"><?php echo $loginWrong ?></p>
                    <?php }
                    ?>
                </div>
                <div class="form-group">
                    <label for="password">User Password</label>
                    <input required type="password" name="userPassword" class="form-control">
                </div>
                <button name="login" type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>


<?php require('./inc/footer.html'); ?>