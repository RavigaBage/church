<?php
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form method="POST" action="clonelogin.php">
        <input type="text" name="email" />
        <input type="password" name="pass_key" />
        <input type="hidden" name="token"
            value="<?php echo hash_hmac('sha256', 'clonelogin.php', $_SESSION['token']); ?>" />
        <button>go</button>
    </form>
    <script>
        // const formData = document.querySelector('form');
        // const formButton = document.querySelector('button');
        // formData.addEventListener('submit', function (e) {
        //     e.preventDefault();
        // })
        // formButton.addEventListener('click', function (e) {

        // })
    </script>
</body>

</html>