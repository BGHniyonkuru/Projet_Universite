<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body id="body_bleu">
    <?php
    session_start();
    ?>
    <div class="carre_inscr">
        <p>Welcome to <i><b>UniDiscover</b>!</i></p>
        <p>Already registered?, <a href="connexion.php">click here</a></p>

        <form  action= "enregistrement.php" id="inscription-form" method="post" autocomplete="on">
            <p>
                First Name :
                <input type="text" id="prenom" name="prenom" value="" />
            </p>
            <p>
                Last Name :
                <input type="text" id="nom" name="nom" value="" />
            </p>
            <p>
                Email address :
                <input type="text" id="email" name="email" value="" />
                <span id="email-error" class="error-message"></span>
            </p>
            <p>
                Password :
                <input type="password" id="mdp" name="mdp" value="" />
                <span id="password-error" class="error-message"></span>
            </p>
            <p>
                Password Confirmation :
                <input type="password" id="mdp1" name="mdp1" value="" />
                <span id="confirm-password-error" class="error-message"></span>
            </p>
            <p>
                <input type="submit" id="oval-button-inscr" value="Send">
            </p>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            function updateValidationState(inputField, isValid, message) {
                inputField.next('.error-message').text(message);

                if (isValid) {
                    inputField.css('background-color', 'lightgreen');
                } else {
                    inputField.css('background-color', 'mistyrose');
                }
            }

            function isValidEmail(email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function isValidPassword(password) {
                var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
                return passwordRegex.test(password);
            }

            function checkFormValidity() {
                var emailIsValid = isValidEmail($('#email').val());
                var passwordIsValid = isValidPassword($('#mdp').val());
                var confirmPasswordIsValid = ($('#mdp').val() === $('#mdp1').val());
                var noFieldIsEmpty = ($('#nom').val() !== '' && $('#prenom').val() !== '');

                updateValidationState($('#email'), emailIsValid, emailIsValid ? '' : 'Invalid email format');
                updateValidationState($('#mdp'), passwordIsValid, passwordIsValid ? '' : 'Password must contain at least 1 letter, 1 number, 1 special character, and be at least 8 characters long');
                updateValidationState($('#mdp1'), confirmPasswordIsValid, confirmPasswordIsValid ? '' : 'Passwords do not match');
                updateValidationState($('#nom'), noFieldIsEmpty, noFieldIsEmpty ? '' : 'This field cannot be empty');
                updateValidationState($('#prenom'), noFieldIsEmpty, noFieldIsEmpty ? '' : 'This field cannot be empty');

                var formIsValid = emailIsValid && passwordIsValid && confirmPasswordIsValid && noFieldIsEmpty;
                $('input[type="submit"]').prop('disabled', !formIsValid);
            }

            $('#email').on('input', function() {
                checkFormValidity();
            });

            $('#mdp').on('input', function() {
                checkFormValidity();
            });

            $('#mdp1').on('input', function() {
                checkFormValidity();
            });

            $('#nom').on('input', function() {
                checkFormValidity();
            });

            $('#prenom').on('input', function() {
                checkFormValidity();
            });

            $('#inscription-form').submit(function(event) {
                event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

                var nom = $("#nom").val();
                var prenom = $("#prenom").val();
                var email = $("#email").val();
                var mdp = $("#mdp").val();
                var mdp1 = $("#mdp1").val();

                $.ajax({
                    type: "POST",
                    url: "enregistrement.php",
                    data: {
                        nom: nom,
                        prenom: prenom,
                        email: email,
                        mdp: mdp,
                        mdp1: mdp1,
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            window.location.href = 'questionnaire.php';
                        } else {
                            console.log(result.message);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

</body>

<footer>
    Copyright © 2023 UniDiscover
</footer>

</html>
