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
        <p>Already registered?, <a href="http://localhost/Projet/connexion.php">click here</a></p>

        <form  id="inscription-form" method="post" autocomplete="on">
            <p>
				First Name :
				<input type="text" id="prenom" name="prenom" value=""/>
			</p>
			<p>
				Last Name :
				<input type="text" id="nom" name="nom" value=""/>
			</p>
			<p>
				Email address :
				<input type="text" id="email" name="email" value=""/>
			</p>
			<p>
				Password :
				<input type="password" id="mdp" name="mdp" value=""/>
			</p>
			<p>
				Password Confirmation  :
				<input type="password" id="mdp1" name="mdp1" value=""/>
			</p>
			<p>
				<input type="submit" id="oval-button-inscr" value="Send" onclick="submitForm()">
			</p>
        </form>
    </div>

<script>
		function submitForm() {
        var nom = $("#nom").val();
		var prenom = $("#prenom").val();
		var email = $("#email").val();
		var mdp = $("#mdp").val();
		var mdp1 = $("#mdp1").val();

        // Envoyer les données au serveur via AJAX
        $.ajax({
            type: "POST",
            url: "enregistrement.php",
            data: { 
                nom: nom,
                prenom: prenom,
				email:email,
				mdp:mdp,
				mdp1:mdp1,
            },
            success: function(response) {
                // Analysez la réponse JSON
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    // Redirection côté client après une connexion réussie
                    window.location.href = 'questionnaire.php';
                } else {
                    // Affichez un message d'erreur en fonction de la réponse
                    console.log(result.message);
                }
            },
            error: function(error) {
                // Gérez les erreurs ici
                console.log(error);
            }
        });
    };

	function isEmailUnique(email, callback) {
        $.ajax({
            url: 'verif_email.php',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
				if (reponse.status === 'success') {
					callback(response.emailExists);
				} else {
					// Affichez un message d'erreur en fonction de la réponse
					console.log(response.error);
				}
			}		
            
        });
    }

// Fonction pour mettre à jour l'état de validation d'un champ
function updateValidationState(inputField, isValid, message) {
    // Supprimez les messages d'erreur existants
    inputField.next('p').remove();

    if (isValid) {
        inputField.css('background-color', 'lightgreen');
    } else {
        inputField.css('background-color', 'mistyrose');
        // Affichez le message d'erreur sous le champ
        inputField.after('<p style="color: red;">' + message + '</p>');
    }
    checkFormValidity();
}
    // Fonction pour valider le format de l'email
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Événement de saisie pour le champ email
$('#email').on('input', function() {
    var emailValue = $(this).val();
    var isValid = isValidEmail(emailValue);
	updateValidationState($(this), isValid, '');
    if (isValid) {
        isEmailUnique(emailValue, function(existe) {
			if (existe) {
			// L'adresse e-mail existe déjà, affichez un message ou prenez une autre action
				updateValidationState($(this),false ,'Adresse e-mail déjà existante');
			} else {
			// L'adresse e-mail est unique, vous pouvez continuer avec votre formulaire
				isValid=true;
			}            
        });
    } else {
        updateValidationState($(this), isValid, 'Format email invalide');
    }
});


// Fonction pour vérifier le format du mot de passe
function isValidPassword(password) {
    var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    return passwordRegex.test(password);
}

// Fonction pour vérifier la validité du formulaire
function checkFormValidity() {
    var emailIsValid = isValidEmail($('#email').val());
    var passwordIsValid = isValidPassword($('#mdp').val());
    var confirmPasswordIsValid = ($('#mdp').val() === $('#mdp1').val());
    var noFieldIsEmpty = ($('#nom').val() !== '' && $('#prenom').val() !== '');
	var isEmailUnique = ($('#emailValidation').text() === '');
    // Activez ou désactivez le bouton d'envoi du formulaire en fonction de la validité des champs
    if (emailIsValid && passwordIsValid && confirmPasswordIsValid && noFieldIsEmpty ) {
        $('input[type="submit"]').prop('disabled', false);
    } else {
        $('input[type="submit"]').prop('disabled', true);
    }
}


// Événement de saisie pour le champ mot de passe
$('#mdp').on('input', function() {
    var passwordValue = $(this).val();
    var isValid = isValidPassword(passwordValue);
    updateValidationState($(this), isValid, 'Le mot de passe doit contenir au moins 1 lettre, 1 chiffre, 1 caractère spécial et doit être de minimum 8 caractères');
});

// Événement de saisie pour le champ de confirmation du mot de passe
$('#mdp1').on('input', function() {
    var passwordValue = $('#mdp1').val();
    var confirmPasswordValue = $(this).val();
    var isValid = (passwordValue === confirmPasswordValue);
    updateValidationState($(this), isValid, 'Les mots de passe ne correspondent pas');
});

// Événement de saisie pour le champ de nom
$('#nom').on('input', function() {
    var noFieldIsEmpty = ($(this).val() !== '');
    updateValidationState($(this), noFieldIsEmpty, 'Le champ ne doit pas être vide');
});

// Événement de saisie pour le champ de prénom
$('#prenom').on('input', function() {
    var noFieldIsEmpty = ($(this).val() !== '');
    updateValidationState($(this), noFieldIsEmpty, 'Le champ ne doit pas être vide');
});

</script>
   
</body>

<footer>
    Copyright © 2023 UniDiscover
</footer>

</html>
