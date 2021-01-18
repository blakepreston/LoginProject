<?php
echo "My First PHP Project <br />";
session_start(); // grab a session that is created

if (isset($_SESSION['userId'])) {
    require('./config/db.php');

    $userId = $_SESSION['userId'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);

    $user = $stmt->fetch(); //access name id and email

    if ($user->role === 'guest') {
        $message = "Your Role is a Guest";
    }
}

?>

<?php require('./inc/header.html'); ?>

<div class="container">
    <div class="card bg-light mb-3">
        <div class="card-header">
            <?php if (isset($user)) { ?>
                <h5>Welcome <?php echo $user->name ?>!</h5>
            <?php } else { ?>
                <h5>Welcome Guest!</h5>
            <?php } ?>
        </div>
        <div class="card-body">
            <?php if (isset($user)) { ?>
                <h5>You have unlocked secret content for logged in people.</h5>
            <?php } else { ?>
                <h4>Please Login/Register to gain access.</h4>
            <?php } ?>
        </div>
    </div>
</div>


<?php require('./inc/footer.html'); ?>