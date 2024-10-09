<?php
session_start();
if (isset($_GET['userlogin'])) {
    if (isset($_SESSION['unique_id']) && isset($_SESSION['user_token'])) {
        header('Location:../membership');
    }
} else {
    if (isset($_SESSION['unique_id']) && isset($_SESSION['Admin_access'])) {
        header('Location:../pages/ZMS/Dashboard.php');
    }
}
if (empty($_SESSION['token_data'])) {
    $_SESSION['token_data'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token_data'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="../css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container" id="container">
        <div class="overlay-container" id="overlayCon">
            <div class="overlay">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
            </div>
        </div>
        <div class="form-container sign-in-container">
            <form action="#" autocomplete="off">
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <div class="loader"></div>
                <div class="infield">
                    <input type="email" placeholder="Email" name="user" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" name="pass" />
                    <label></label>
                </div>
                <input type="hidden" name="token"
                    value="<?php echo hash_hmac('sha256', 'http://localhost/database/Church/API/login/data_process.php', $_SESSION['token_data']); ?>" />
                <a href="#" class="forgot">Forgot your password?</a>
                <button>Sign In</button>
            </form>
        </div>
    </div>

    <script>
        splitScreen = "";

        if (window.location.href.includes('?')) {
            splitScreen = window.location.href.split('?');
            if (splitScreen.length > 2) {
                location.href = '../pages/error404/general404.html'
            }
        }
        var form = document.querySelector('form');
        var button = document.querySelector('form button');
        var loader = document.querySelector('.loader');
        bearer_token = false;
        window.addEventListener('load', async function () {
            try {
                APIENDPOINT = '../API/login/getjwt.php';
                const Request = await fetch(APIENDPOINT, {
                    method: 'GET'
                })
                if (Request.status == 200) {
                    response = await Request.json(Request);
                    if (response) {
                        if (response['status'] == 'success') {
                            bearer_token = response['message'];
                        }
                    }
                }
            } catch (error) {
                console.error(error);
            }
        })
        function CleanData(form1) {
            Counter = true;
            form1.forEach(element => {
                if (element.value == '' || element.value < 1 || element.value == ' ') {
                    Counter = false;
                }
            });
            return Counter;
        }

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (bearer_token != false) {
                let AllInput = document.querySelectorAll('form input');
                if (CleanData(AllInput)) {
                    dataSend = {
                        User: AllInput[1].value,
                        Key: AllInput[0].value,
                        token_data: AllInput[2].value
                    }
                    try {
                        APIENDPOINT = '../API/login/data_process.php';
                        const Request = await fetch(APIENDPOINT, {
                            method: 'POST',
                            body: JSON.stringify(dataSend),
                            headers: {
                                "Content-Type": "application/json",
                                "Authorization": "Bearer " + bearer_token
                            },
                        })
                        if (Request.status == 200) {
                            response = await Request.json(response);
                            if (response['status'] == 'success') {
                                if (!loader.classList.contains('danger')) {
                                    loader.classList.add('danger');
                                }
                                if (typeof response['message'] != 'object') {
                                    loader.innerText = response['message'];
                                } else {
                                    loader.innerText = response['status'];
                                    Splitname = splitScreen[1].toLowerCase();
                                    console.log(Splitname);
                                    if (typeof splitScreen == 'object') {
                                        if (Splitname == 'userlogin') {
                                            location.href = '../pages/parallax.php';
                                        } else if (Splitname == 'admin') {
                                            location.href = '../pages/ZMS/Dashboard.php#';
                                        }
                                    }

                                }
                            } else {
                                loader.innerText = response['message'];
                            }
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }

            }

        })
    </script>
</body>

</html>