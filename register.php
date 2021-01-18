<?php
echo "My First PHP Project <br />";

if (isset($_POST['register'])) {
    require('./config/db.php');

    // $userName = $_POST['userName'];
    // $userEmail = $_POST['userEmail'];
    // $userPassword = $_POST['userPassword'];

    //Form Validation
    //Need to make sure the input is not harmful

    $userName = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
    $userEmail = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
    $userPassword = filter_var($_POST["userPassword"], FILTER_SANITIZE_STRING);
    $passwordHashed = password_hash($userPassword, PASSWORD_DEFAULT);

    if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('SELECT* FROM users WHERE email=? ');
        $stmt->execute([$userEmail]);
        $totalUsers = $stmt->rowCount();

        echo $totalUsers . '<br >';

        if ($totalUsers > 0) {
            $emailTaken = "Email Already Used <br />";
        } else {
            $stmt2 = $pdo->prepare('INSERT into users(name, email, password) VALUES(?, ?, ?)');
            $stmt2->execute([$userName, $userEmail, $passwordHashed]);
        }
    }
}
?>

<?php require('./inc/header.html'); ?>

<div class="container">
    <div class="card">
        <div class="card-header bg-light mb-3">Register</div>
        <div class="card-body">
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="userName">User Name</label>
                    <input required type="text" name="userName" class="form-control">
                </div>
                <div class="form-group">
                    <label for="userEmail">User Email</label>
                    <input require type="email" name="userEmail" class="form-control">
                    <br />
                    <?php if (isset($emailTaken)) {  ?>
                        <p style="background-color: red;"><?php echo $emailTaken ?></p>
                    <?php }
                    $emailTaken ?>
                </div>
                <div class="form-group">
                    <label for="password">User Password</label>
                    <input required type="password" name="userPassword" class="form-control">
                </div>
                <button name="register" type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>


<?php require('./inc/footer.html'); ?>