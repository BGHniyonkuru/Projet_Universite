<?php
session_start();
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
      left: 0px;
      z-index: 1;
      background: black;
      color: white;
    }

    button{
      border-radius: 50%;
    }

  </style>
</head>
<body>
    <?php
      $menu_bar_content = file_get_contents("menu_bar.html");
      echo $menu_bar_content;
    ?>

    <div class="search-container">
      <form action="localisation.php" method="get">
          <input type="text" id="university-search" name="searchTerm" placeholder="Search for a university...">
          <button type="button" onclick="searchUniversity()">Search</button>
      </form>
    </div>

    <div id='map'></div>

    <div id='popup'></div>

    <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYm5peW9uazEiLCJhIjoiY2xyeGdkYW5nMTlhZDJpbXhnMnl4ejA4cCJ9.fZNXwplt_ESYRJiJjWFKFw';
    var map = new mapboxgl.Map({
      container: 'map', 
      style: 'mapbox://styles/mapbox/outdoors-v12', // Specify which map style to use
      center: [-98.5795, 39.8283], // Specify the starting position [lng, lat]
      zoom: 3.5 // Specify the starting zoom
    });

    <?php
    if (!empty($result) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "new mapboxgl.Marker().setLngLat([" . $row['longitude'] . ", " . $row['latitude'] . "])
                  .setPopup(new mapboxgl.Popup().setHTML('<h4>" . $row['name'] . "</h4><p><a href=\"" . $row['webpage'] . "\">Visit page</a></p>'))
                  .addTo(map);";
        }
    }
    ?>

    const popup = new mapboxgl.Popup({
      closeButton: false,
      closeOnClick: false
    });

    let universitiesGeoJSON = {"type": "FeatureCollection", "features": []};

    fetch("geojson.php")
        .then(response => response.json())
        .then(data => {
            universitiesGeoJSON = {
                "type": "FeatureCollection",
                "features": data.map(university =>{
                    return {
                        "type": "Feature",
                        "properties": {
                            "university_name": university.university_name,
                            "university_id": university.university_id,

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
                        const universityId = event.features[0].properties.university_id;
                        window.location.href = `universite.php?id=${universityId}`;
                    }
                    else{
                      console.log('No university found at this location.');
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
          const filteredFeatures = universitiesGeoJSON.features.filter(feature =>
              feature.properties.university_name.toLowerCase().includes(searchTerm));
          const filteredGeoJSON = {
              "type": "FeatureCollection",
              "features": filteredFeatures
          };
          map.getSource('universities').setData(filteredGeoJSON);
      }
  }
  </script>

</body>
</html>        