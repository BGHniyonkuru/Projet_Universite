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
      body, html {
        margin: 0;
        padding: 0;
        height: 100%; /* Ensure full height */
        overflow: hidden; /* Hide scrollbars */
        background-color: #FAF7F2;
      }

      .bandeau {
      text-decoration: none;
      color: white;
      }

      #logo {
      margin-left: 130px;
      margin-top: 10px;
      height: 90px;
      width: 90px;
      }

      #logo2 {
      margin-left: 100px;
      margin-top: 5px;
      height: 50px;
      width: 50px;
      }

      #logo3 {
      margin-left: 10px;
      margin-top: 5px;
      height: 50px;
      width: 50px;
      }

      .container, .search-container, #map {
      padding: 10px 0;
      }

      .container {
      height:90px;
      background-color: #3C3B6E;
      color: white;
      padding-top: 10px;
      padding-bottom: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      margin: 0;
      margin-bottom: 2px;
      max-width: none;
      }

      .container > ul {
      position: relative;
      margin-top:30px;
      transform: translateY(-50%);	
      text-align: center;
      background-color:#3C3B6E;
      width:800px;
      }
      .container > ul > li{
      list-style-type: none;
      display: inline;
      margin-right: 50px;

      }
      li:hover{
      font-size: 20px;
      }

      .container ul li a {
      color: white;
      text-decoration: none;
      }
      .container, .search-container, #map {
      margin-bottom:2px; /* Uniform margin for all major containers */
      }

      #map {
      margin-top: 
      position: relative; /* Change positioning to relative */
      height: 75vh; /* Adjust height */
      width: 100%;
      }

      #popup {
        display: none;
        background-color: #fff;
        border: 1px solid #000;
        padding: 10px;
        font-size: 14px;
        position: absolute;
      }

      .search-container {
        margin-top: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0px;
        background-color: #FAF7F2;
        margin: 0px auto; /* Centering the search container */
        width: 100%; /* Making the search container a bit narrower */
        position: relative; /* Ensuring it is in the normal document flow */
      }

      .search-container input[type="text"] {
        height: 10px;
        flex-grow: 1; /* Takes up the remaining space */
        padding: 10px;
        margin-right: 10px; /* Space between input and button */
        border: 2px solid #555; /* Slightly thicker border for better visual impact */
        border-radius: 4px;
        background-color: #fff; /* White background for the input */
        outline: none; /* Removes the default focus outline */
        transition: all 0.3s ease; /* Smooth transition for visual effects */
      }

      .search-container input[type="text"]:focus {
        border-color: #007bff; /* Highlight color when focused */
        box-shadow: 0 0 8px rgba(0,123,255,0.8); /* Glowing effect on focus */
      }

      .search-container button {
        padding: 10px 20px;
        background-color: #007bff; /* Primary button color */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
      }

      .search-container button:hover {
        background-color: #0056b3; /* Darker shade on hover */
      }


    </style>

  </head>

  <body>
    
    <div class="container">

    <a href= "accueil.php"><img id="logo" src="images/logo.png" alt="logo" ></a>

    <ul>
        <li><a class= "bandeau" href="compare.php">Compare</a></li>
        <li><a class= "bandeau" href="localisation.php">Map</a></li>
        <li><a class= "bandeau" href="prediction.html" >Predict</a></li>
        <li><a class= "bandeau" href="contact.php" >Contact</a></li>
        <li><a class= "bandeau" href="search_university.html" >Search</a></li>
    </ul>
    <a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
    <a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
    </div>


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
                              "university_id": university.id_universite,

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
                          window.location.href = 'universite.php?id='+universityId;
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