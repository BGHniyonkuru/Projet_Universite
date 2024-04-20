// Attendre que le contenu du DOM soit entièrement chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', function () {
  // Obtenir les références du champ de saisie et du conteneur de résultats de l'autocomplétion
  var searchInput = document.getElementById('searchInput');
  var autocompleteResults = document.getElementById('autocompleteResults');

  // Écouteur d'événements pour le champ de saisie afin de récupérer des suggestions d'autocomplétion
  searchInput.addEventListener('input', function () {
    var searchTerm = searchInput.value;

    // Vérifier si le terme de recherche n'est pas vide
    if (searchTerm.trim() !== '') {
      // Récupérer des suggestions d'autocomplétion via AJAX
      fetch('get_autocomplete.php?q=' + encodeURIComponent(searchTerm))
        .then(response => response.json())
        .then(data => displayAutocompleteResults(data));
    } else {
      // Effacer les résultats de l'autocomplétion si le terme de recherche est vide
      autocompleteResults.innerHTML = '';
    }
  });

  // Fonction pour afficher les résultats de l'autocomplétion
  function displayAutocompleteResults(results) {
    autocompleteResults.innerHTML = '';

    // Créer des liens pour chaque suggestion
    results.forEach(function (university) {
      var link = document.createElement('a');
      link.href = '#';
      link.textContent = university;
      link.addEventListener('click', function () {
        // Définir la suggestion sélectionnée comme la valeur du champ de saisie
        document.getElementById('searchInput').value = university;
        searchUniversities();
        autocompleteResults.innerHTML = '';
      });

      autocompleteResults.appendChild(link);
    });
  }
});

// Fonction pour afficher le menu déroulant de l'autocomplétion
function showAutocomplete() {
  var autocompleteResults = document.getElementById('autocompleteResults');
  autocompleteResults.style.display = 'block';
}

// Fonction pour fermer le menu déroulant de l'autocomplétion
function closeAutocomplete() {
  var autocompleteResults = document.getElementById('autocompleteResults');
  autocompleteResults.innerHTML = '';
}

// Fonction pour gérer la touche Entrée
function handleEnterKey(event) {
  if (event.key === 'Enter') {
    searchUniversities();
  }
}

// Ajouter un écouteur d'événements pour la touche Entrée sur le champ de saisie
document.getElementById('searchInput').addEventListener('keydown', handleEnterKey);

// Fonction pour effectuer la recherche d'universités
function searchUniversities() {
  // Fermer le menu déroulant de l'autocomplétion
  closeAutocomplete();

  // Obtenir la requête de recherche
  var searchQuery = document.getElementById('searchInput').value || "";
  searchQuery = searchQuery.trim().toLowerCase();

  // Requête AJAX pour récupérer les universités depuis la base de données
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_universities.php?q=' + encodeURIComponent(searchQuery), true);

  xhr.onload = function() {
    if (xhr.status == 200) {
      var universities = JSON.parse(xhr.responseText);
      if (universities) {
        displayResults(universities);
      } else {
        console.error('Réponse invalide : universities est null ou non défini');
      }
    } else {
      console.error('Erreur de requête AJAX');
    }
  };

  xhr.send();
}

// Définir les en-têtes du tableau
// Create an array to store the header text and corresponding property names for sorting
var headers = [
  { text: 'Logo', property: 'image_link' }, // Add this line for the logo column
  { text: 'Université', property: 'universite_name' },
  { text: 'Domaine d\'Étude', property: 'domaine_etude' },
  { text: 'Ville', property: 'ville_name' },
  { text: 'Rang', property: 'rank_order' },
  { text: 'Scores Overall', property: 'scores_overall' },
  { text: 'Année', property: 'annee' }
];

// Fonction pour afficher les résultats de la recherche dans un tableau
function displayResults(universities) {
  // Obtenir l'élément du conteneur de résultats
  var resultContainer = document.getElementById('resultContainer');
  resultContainer.innerHTML = ''; // Effacer les résultats précédents

  // Vérifier s'il y a une erreur dans la réponse
  if (universities.hasOwnProperty('error')) {
    // Gérer le cas d'erreur
    resultContainer.innerHTML = 'Erreur : ' + universities.error;
  } else if (universities.length > 0) {
    // Créer un élément de tableau
    var table = document.createElement('table');
    table.classList.add('result-table');

    // Créer l'en-tête du tableau
    var thead = document.createElement('thead');
    var headerRow = document.createElement('tr');

    // Loop through headers and create th elements with sorting functionality
    headers.forEach(function (header) {
      var th = document.createElement('th');
      th.textContent = header.text;

      // Add a click event listener to the th for sorting
      th.addEventListener('click', function () {
        sortTable(header.property);
      });

      headerRow.appendChild(th);
    });

    // Add the header row to the thead and thead to the table
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Créer le corps du tableau
    var tbody = document.createElement('tbody');
    universities.forEach(function(university) {
      var row = document.createElement('tr');

      // Create a cell for the university logo
      var logoCell = document.createElement('td');
      var logoImage = document.createElement('img');
      logoImage.src = university.image_link; // Assuming image_link contains the URL for the logo
      logoImage.alt = 'University Logo';
      logoImage.style.width = '50px'; // Set the width as needed
      logoCell.appendChild(logoImage);

      var nameCell = document.createElement('td');
      nameCell.innerHTML = university.universite_name;

      var domaineEtudeCell = document.createElement('td');
      var domaineEtudeContent = document.createElement('div');
      domaineEtudeContent.innerHTML = university.domaine_etude;
      domaineEtudeContent.style.maxHeight = '3.2em';  // Set the maximum height for three lines
      domaineEtudeContent.style.overflow = 'hidden'; // Hide overflow
      domaineEtudeContent.style.whiteSpace = 'pre-line'; // Preserve line breaks
      domaineEtudeCell.appendChild(domaineEtudeContent);

      // Add a "Read more..." link
      var readMoreLink = document.createElement('a');
      readMoreLink.textContent = 'Read more...';
      readMoreLink.className = 'read-more-link'; // Apply the CSS class
      readMoreLink.style.cursor = 'pointer';
      readMoreLink.style.display = 'block';
      domaineEtudeCell.appendChild(readMoreLink);

      // Add a "Read less..." link (initially hidden)
      var readLessLink = document.createElement('a');
      readLessLink.textContent = 'Read less...';
      readLessLink.className = 'read-less-link'; // Apply the CSS class
      readLessLink.style.cursor = 'pointer';
      readLessLink.style.display = 'none'; // Initially hidden
      domaineEtudeCell.appendChild(readLessLink);

      // Add a click event listener to toggle the content display
      readMoreLink.addEventListener('click', function() {
        if (domaineEtudeContent.style.maxHeight === '3.2em') {
          domaineEtudeContent.style.maxHeight = 'none';
          readMoreLink.style.display = 'none';
          readLessLink.style.display = 'block';
        } else {
          domaineEtudeContent.style.maxHeight = '3.2em';
          readMoreLink.style.display = 'block';
          readLessLink.style.display = 'none';
        }
      });

      // Add a click event listener to toggle the content display
      readLessLink.addEventListener('click', function() {
        domaineEtudeContent.style.maxHeight = '3.2em';
        readMoreLink.style.display = 'block';
        readLessLink.style.display = 'none';
      });

      var villeCell = document.createElement('td');
      villeCell.innerHTML = university.ville_name;

      var classementCell = document.createElement('td');
      classementCell.innerHTML = university.rank_order;

      var scoresOverallCell = document.createElement('td');
      scoresOverallCell.innerHTML = university.scores_overall;

      var yearCell = document.createElement('td');
      yearCell.innerHTML = university.annee;

      // Add cells to the row
      row.appendChild(logoCell);
      row.appendChild(nameCell);
      row.appendChild(domaineEtudeCell);
      row.appendChild(villeCell);
      row.appendChild(classementCell);
      row.appendChild(scoresOverallCell);
      row.appendChild(yearCell);

      // Add the row to the table body
      tbody.appendChild(row);
    });

    // Add the tbody to the table
    table.appendChild(tbody);

    // Add the table to the result container
    resultContainer.appendChild(table);
  } else {
    // Display a message if no results are found
    resultContainer.innerHTML = 'No results found.';
  }
}

// JavaScript function to sort the table
function sortTable(columnName) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.querySelector('.result-table');
  switching = true;

  // Find the index of the column based on the property value
  var columnIndex = headers.findIndex(header => header.property === columnName);

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
      shouldSwitch = false;

      // Get the two elements to compare
      x = rows[i].getElementsByTagName('td')[columnIndex];
      y = rows[i + 1].getElementsByTagName('td')[columnIndex];

      if (columnName == "rank_order") {
        // Parse content as numbers
        var xValue = isNaN(parseFloat(x.innerHTML)) ? x.innerHTML.toLowerCase() : parseFloat(x.innerHTML);
        var yValue = isNaN(parseFloat(y.innerHTML)) ? y.innerHTML.toLowerCase() : parseFloat(y.innerHTML);

        // Compare the values
        if (xValue > yValue) {
          shouldSwitch = true;
          break;
        }
      } else {
        // Compare the values
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }

    if (shouldSwitch) {
      // If a switch is needed, perform it and set the switching flag to true
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
