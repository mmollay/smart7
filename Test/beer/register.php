<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            background-color: #F5D04C;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            width: 400px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .register-container .logo {
            margin-bottom: 30px;
            border-radius: 50%;
            overflow: hidden;
        }

        .register-container .logo img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .register-container h2 {
            color: #4F311E;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .register-container .ui.form .field input {
            padding: 12px;
        }

        .register-container .ui.form .field.button {
            margin-top: 30px;
        }

        .register-container .ui.form .field.button .ui.button {
            width: 100%;
        }

        .register-container .password-strength {
            margin-top: 10px;
        }

        .register-container .password-strength span {
            font-size: 12px;
            color: #999;
        }

        .register-container .password-strength .weak {
            color: #FF4040;
        }

        .register-container .password-strength .strong {
            color: #40C057;
        }

        .register-container .email-check-result {
            margin-top: 10px;
            font-size: 12px;
            color: #FF4040;
        }
        
        .register-container .error-message {
            color: #FF4040;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .register-container .back-button {
            margin-top: 20px;
            text-align: left;
        }
        
        .register-container .back-button a {
            color: #000;
            text-decoration: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Überprüfung der Passwortstärke beim Eingeben des Passworts
            $('#password').keyup(function() {
                var password = $(this).val();
                var strengthText = $('#password-strength-text');

                if (password.length < 8) {
                    strengthText.text('Das Passwort ist zu kurz');
                    strengthText.removeClass().addClass('weak');
                } else if (!password.match(/[0-9]+/)) {
                    strengthText.text('Das Passwort sollte mindestens eine Zahl enthalten');
                    strengthText.removeClass().addClass('weak');
                } else if (!password.match(/[\W]+/)) {
                    strengthText.text('Das Passwort sollte mindestens ein Sonderzeichen enthalten');
                    strengthText.removeClass().addClass('weak');
                } else {
                    strengthText.text('Das Passwort ist stark');
                    strengthText.removeClass().addClass('strong');
                }
            });

            // Überprüfung der Email-Adresse vor dem Absenden des Formulars
            $('#email').blur(function() {
                var email = $(this).val();
                var checkResult = $('.email-check-result');

                // Überprüfung der Email-Adresse mit Ajax
                $.ajax({
                    url: 'check_email.php',
                    method: 'POST',
                    data: { email: email },
                    success: function(response) {
                        if (response === 'exists') {
                            checkResult.text('Diese Email-Adresse wird bereits verwendet.');
                            $('#submit-button').prop('disabled', true);
                        } else {
                            checkResult.text('');
                            $('#submit-button').prop('disabled', false);
                        }
                    }
                });
            });

            // Überprüfung der Passwort-Wiederholung vor dem Absenden des Formulars
            $('#confirm_password').blur(function() {
                var password = $('#password').val();
                var confirm_password = $(this).val();
                var checkResult = $('#confirm-password-check-result');

                if (password !== confirm_password) {
                    checkResult.text('Die Passwörter stimmen nicht überein.');
                    $('#submit-button').prop('disabled', true);
                } else {
                    checkResult.text('');
                    $('#submit-button').prop('disabled', false);
                }
            });
        });
    </script>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <img src="beer.png" alt="Logo">
        </div>
        <h2>Registrierung</h2>
        <form class="ui form" method="POST" action="registration.php">
            <div class="field">
                <label>Vorname</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="field">
                <label>Nachname</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" id="email" required>
                <div class="email-check-result"></div>
                <?php
                    if(isset($_GET['error']) && $_GET['error'] === 'email_exists') {
                        echo '<div class="error-message">Diese Email-Adresse wird bereits verwendet.</div>';
                    }
                ?>
            </div>
            <div class="field">
                <label>Geburtsdatum</label>
                <input type="date" name="birthdate" required>
            </div>
            <div class="field">
                <label>Passwort</label>
                <input type="password" name="password" id="password" required>
                <div class="password-strength">
                    <span id="password-strength-text"></span>
                </div>
            </div>
            <div class="field">
                <label>Passwort wiederholen</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <div id="confirm-password-check-result" class="error-message"></div>
            </div>
            <div class="field button">
                <button class="ui primary button" type="submit" id="submit-button" disabled>Registrieren</button>
            </div>
        </form>
        <div class="back-button">
            <a href="login.php">Zurück zum Login</a>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
</body>
</html>
