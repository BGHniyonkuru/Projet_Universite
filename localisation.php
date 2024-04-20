<?php
session_start();
if (!isset($_SESSION['client'])) {
  // Redirect, throw an error, or set a default value
  $_SESSION['client'] = "default_value"; 
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='utf-8' />
  <title>US universities localize</title>
  <meta name='viewport' content='width=device-width, initial-scale=1' />
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v3.1.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v3.1.0/mapbox-gl.css' rel='stylesheet' />
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    #map {
      position: absolute;
      top: 12.5%;
      bottom: 0;
      height: 90%;
      width: 100%;
    }

    #popup {
      position: absolute;
      display: none;
      background-color: #fff;
      border: 1px solid #000;
      padding: 10px;
      font-family: sans-serif;
      font-size: 14px;
    }

    .search-container {
      position: absolute;
      top: 12.5%;
      left: 10px;
      z-index: 1;
      backgroundColor: black;
      color: white;
    }

  </style>
</head>
<body>
    <?php
    $menu_bar_content = file_get_contents("menu_bar.html");
    echo $menu_bar_content;
    ?>

    <div class="search-container">
        <input type="text" id="university-search" placeholder="Search for a university...">
        <button type="submit">Search</button>
    </div>

    <div id='map'></div>

    <div id='popup'></div>

    <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYm5peW9uazEiLCJhIjoiY2xyeGdkYW5nMTlhZDJpbXhnMnl4ejA4cCJ9.fZNXwplt_ESYRJiJjWFKFw';
    const map = new mapboxgl.Map({
      container: 'map', 
      style: 'mapbox://styles/mapbox/outdoors-v12', // Specify which map style to use
      center: [-98.5795, 39.8283], // Specify the starting position [lng, lat]
      zoom: 3.5 // Specify the starting zoom
    });

    function addMarker(lng, lat, name, url) {
        const el = document.createElement('div');
        el.style.backgroundImage = 'url(https://placekitten.com/g/30/30)';  // Use a different icon
        el.style.width = '30px';
        el.style.height = '30px';
        el.style.backgroundSize = '100%';

        el.addEventListener('click', function() {
            window.location.href = url;
        });

        new mapboxgl.Marker(el)
            .setLngLat([lng, lat])
            .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML('<h3>' + name + '</h3><p>' + lat + ', ' + lng + '</p>'))
            .addTo(map);
    }

    const popup = new mapboxgl.Popup({
      closeButton: false,
      closeOnClick: false
    });

    fetch("geojson.php")
        .then(response => response.json())
        .then(data => {
            const universitiesGeoJSON = {
                "type": "FeatureCollection",
                "features": data.map(university =>{
                    return {
                        "type": "Feature",
                        "properties": {
                            "university_name": university.university_name,
                        },
                        "geometry": {
                            "type": "Point",
                            "coordinates": [parseFloat(university.longitude), parseFloat(university.latitude)]
                        }
                };
                })
    };

    

        map.on('load', () => {
            map.addSource('universities', {
                type: 'geojson',
                data: universitiesGeoJSON,
                generateId: true // This ensures that all features have unique IDs
            });


            map.addLayer({
                id: 'universities-layer',
                type: 'circle',
                source: 'universities',
                paint: {
                    'circle-stroke-color': '#FF0000',
                    'circle-stroke-width': 1,
                    'circle-color': '#008000'
                }
                });

                map.on('click', 'universities-layer', (event) => {
                    if (event.features && event.features.length > 0) {
                        const universityName = event.features[0].properties.university_name;
                        window.location.href = `http://localhost/projet_universite/universite.php/${universityName.replace(/\s+/g, '-').toLowerCase()}`;
                    }
                });

            map.on('mousemove', 'universities-layer', (event) => {
                map.getCanvas().style.cursor = 'pointer';
                // Set constants equal to the current feature's magnitude, location, and time
                if (event.features && event.features.length > 0) {
                    const universityName = event.features[0].properties.university_name;
                    const coordinates = event.features[0].geometry.coordinates;

                    popup.setLngLat(coordinates)
                          .setHTML(`<strong>University:</strong> ${universityName}<br><strong>Location:</strong> ${coordinates}`)
                          .addTo(map);
                }else{
                    popup.remove();
                }
            });

            map.on('mouseleave', 'universities-layer', () => {
                map.getCanvas().style.cursor = '';
                popup.remove();
                });
        });
    })

    function searchUniversity() {
      const searchTerm = document.getElementById('university-search').value.toLowerCase();
      if (searchTerm.trim() !== '') {
        const filteredFeatures = universitiesGeoJSON.features.filter(feature => {
          const universityName = feature.properties.university_name.toLowerCase();
          return universityName.includes(searchTerm);
        });

        const filteredGeoJSON = {
          "type": "FeatureCollection",
          "features": filteredFeatures
        };

        // Mettre à jour la source de données de la carte avec les résultats filtrés
        map.getSource('universities').setData(filteredGeoJSON);
      }
    }
  </script>

</body>
</html>        