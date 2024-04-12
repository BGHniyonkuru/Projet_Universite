<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">        
    <link rel="stylesheet" type="text/css" href="assets/menu.css">
    <title>US universities localization</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v3.1.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v3.1.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        #map { height: 500px; }
    </style>
</head>
<body>
    <?php
    $menu_bar_content = file_get_contents("menu_bar.html");
    echo $menu_bar_content;

    require("bd.php");
    $bdd = getBD();
    $searchQuery = $_GET['search'] ?? '';

    $sql = "SELECT v.id_ville, v.name AS ville, v.latitude, v.longitude, v.name_etat, u.id_universite,
        u.id_ville AS id_ville_universite, u.name AS university_name, u.domaine_etude, 
        u.`Acceptance rate` AS acceptance_rate, u.`Price(Average Cost After Financial Aid)` AS price
        FROM ville v
        JOIN universite u ON v.id_ville = u.id_ville";
    $result = $bdd->prepare($sql);
    $result->execute();

    $universities = array();
    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $universities[] = $row;
        }
    }

    // Fermeture de la connexion à la base de données
    $bdd = null;

    // Renvoi des données au format JSON
    header('Content-Type: application/json');
    echo json_encode($universities);
    ?>

    <h1>Visualize where you may spend your next four years</h1>
    <h1 style="text-align: center;">Localisation</h1>

    <input id="search_university" type="text" placeholder="Enter a university name..." style="width: 40%; margin: auto;" oninput="searchUniversity()"/>
    <div id="output_container"></div>
    
    <div id="map"></div>
    <script>

        //Making a map and tiles
        const mymap = L.map('map').setView([37.0902, -95.7129], 4);
        const attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        const tileUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
        const tiles = L.tileLayer(tileUrl, {attribution});
        tiles.addTo(mymap);

        //Making a marker with a custom icon
        const myIcon = L.icon({
                iconUrl: 'marker.png',
                iconSize: [38,95],
                iconAnchor: [25,16]
            });
        const marker = L.marker([0, 0],{icon: myIcon}).addTo(mymap);

        const api_url = "" //Ajouter un lien
        
    async function getCoordinates(universityName, city, state) {
        const address = `${universityName}, ${city}, ${state}`;

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${address}`);
            const data = await response.json();
            
            if (data.length > 0) {
                return [data[0].lat, data[0].lon];
            } else {
                return null;
            }
        } catch (error) {
            console.error('Error fetching coordinates:', error);
            return null;
        }
    }

    async function updateMap(optionSelected) {
        const searchQuery = optionSelected.trim().toLowerCase();

        try {
            const response = await fetch('/universities?search=' + searchQuery);
            const universities = await response.json();

            let container = `The university chosen by the user was: ${optionSelected}` || "No university searched.";

            let markers = [];

            universities.forEach(async function(uni) {
                const coordinates = await getCoordinates(uni.university_name, uni.ville, uni.name_etat);
                
                if (coordinates) {
                    markers.push(L.marker(coordinates)
                        .bindPopup(uni.university_name)
                        .addTo(mymap));
                }
            });

            // Center the map on the first marker
            if (markers.length > 0) {
                mymap.setView(markers[0].getLatLng(), 12);
            }

        } catch (error) {
            console.error('Error fetching universities:', error);
        }
    }

    // Event listener for search input
    document.getElementById('search_university').addEventListener('input', function(event) {
        var searchQuery = event.target.value.trim();
        updateMap(searchQuery);
    });
</script>    

</body>
</html>
