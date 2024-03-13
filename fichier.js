$(document).ready(function() {
    
    // Fonction pour vérifier si un champ est vide
    function isNotEmpty(value) {
        return value.trim() !== '';
    }
    
    // Fonction pour vérifier si le mot de passe contient au moins une lettre, un chiffre et un caractère spécial
    function isValidPassword(password) {
        var regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        return regex.test(password);
    }

    // Fonction pour vérifier si l'adresse email est valide
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Fonction pour vérifier si le mail existe déjà dans la base de données
    function isUniqueEmail(email, callback) {
        $.ajax({
            type: 'POST',
            url: 'enregistrement.php',
            data: {email: email},
            success: function(response) {
                if (response === 'unique') {
                    callback(true);
                } else {
                    displayError('#email', 'This email address is already in use.');
                    callback(false);
                }
            },
            error: function() {
                callback(false);
            }
        });
    }
    

    // Fonction pour afficher un message d'erreur
    function displayError(field, message) {
        $(field).next('.error-msg').text(message);
    }

    // Fonction pour supprimer les messages d'erreur
    function clearError(field) {
        $(field).next('.error-msg').text('');
    }

    // Gérer la soumission du formulaire d'inscription
    $('#inscription-form').submit(function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

        // Récupérer les valeurs des champs
        var nom = $('#nom').val().trim();
        var prenom = $('#prenom').val().trim();
        var email = $('#email').val().trim();
        var mdp = $('#mdp').val().trim();
        var mdpConfirmation = $('#mdp1').val().trim();

        // Réinitialiser les messages d'erreur
        $('.error-msg').text('');

        // Vérifier que tous les champs sont remplis
        if (!isNotEmpty(nom) || !isNotEmpty(prenom) || !isNotEmpty(email) || !isNotEmpty(mdp) || !isNotEmpty(mdpConfirmation)) {
            displayError('#inscription-form', 'Please fill all the fields.');
            return;
        }

        // Vérifier que le mot de passe respecte les critères
        if (!isValidPassword(mdp)) {
            displayError('#mdp', 'The password must contain at least 1 letter, 1 number and 1 special character, and be at least 8 characters long.');
            return;
        }

        // Vérifier que l'adresse email est valide
        if (!isValidEmail(email)) {
            displayError('#email', 'Please enter a valid email address.');
            return;
        }

        // Vérifier que le mot de passe et sa confirmation correspondent
        if (mdp !== mdpConfirmation) {
            displayError('#mdp1', 'Passwords do not match.');
            return;
        }

        // Vérifier si l'email est déjà utilisé
        isUniqueEmail(email, function(unique) {
            if (!unique) {
                displayError('#email', 'This email address is already in use.');
            } else {
                // Envoyer le formulaire si tout est valide
                $('#inscription-form').off('submit').submit();
            }
        });
    });

});
/*
$(document).ready(function() {
    
    // Fonction pour vérifier si un champ est vide
    function isNotEmpty(value) {
        return value.trim() !== '';
    }
    
    // Fonction pour vérifier si le mot de passe contient au moins une lettre, un chiffre et un caractère spécial
    function isValidPassword(password) {
        var regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        return regex.test(password);
    }

    // Fonction pour vérifier si l'adresse email est valide
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Fonction pour vérifier si le mail existe déjà dans la base de données
    function isUniqueEmail(email, callback) {
        $.ajax({
            type: 'POST',
            url: 'enregistrement.php', // Remplacez 'check_email.php' par le chemin vers votre script de vérification en PHP
            data: {email: email},
            success: function(response) {
                if (response === 'unique') {
                    callback(true);
                } else {
                    callback(false);
                }
            },
            error: function() {
                callback(false); // En cas d'erreur de la requête AJAX, considérez l'email comme non unique
            }
        });
    }

    // Fonction pour afficher un message d'erreur
    function displayError(field, message) {
        $(field).next('.error-msg').text(message);
    }

    // Fonction pour supprimer les messages d'erreur
    function clearError(field) {
        $(field).next('.error-msg').text('');
    }

    // Gérer la soumission du formulaire d'inscription
    $('#inscription-form').submit(function(event) {
        event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

        var nom = $('#nom').val().trim();
        var prenom = $('#prenom').val().trim();
        var email = $('#email').val().trim();
        var mdp = $('#mdp').val().trim();
        var mdpConfirmation = $('#mdp1').val().trim();

        // Vérifier que tous les champs sont remplis
        if (!isNotEmpty(nom) || !isNotEmpty(prenom) || !isNotEmpty(email) || !isNotEmpty(mdp) || !isNotEmpty(mdpConfirmation)) {
            displayError('#inscription-form', 'Please fill all the fields.');
            return;
        }

        // Vérifier que le mot de passe respecte les critères
        if (!isValidPassword(mdp)) {
            displayError('#mdp', 'The password must contain at least 1 letter, 1 number and 1 special character, and be at least 8 characters long.');
            return;
        }

        // Vérifier que l'adresse email est valide
        if (!isValidEmail(email)) {
            displayError('#email', 'Please enter a valid email address.');
            return;
        }

        // Vérifier que le mot de passe et sa confirmation correspondent
        if (mdp !== mdpConfirmation) {
            displayError('#mdp1', 'Passwords do not match.');
            return;
        }

        // Vérifier si l'email est déjà utilisé
        isUniqueEmail(email, function(unique) {
            if (!unique) {
                displayError('#email', 'This email address is already in use.');
            } else {
                // Envoyer le formulaire si tout est valide
                $('#inscription-form').unbind('submit').submit();
            }
        });
    });

});
*/
