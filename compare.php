<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Button Page</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%; /* Full height */
      background-color: #f0f2f5;
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

    .container {
        height:100px;
        background-color: #3C3B6E;
        color: white;
        padding-top: 10px;
        padding-bottom: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 0;
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

    #menu-bar {
      width: 100%;
      position: fixed;
      top: 0; /* Fixed at the top */
      z-index: 1000; /* Ensure it is above other content */
    }

    .button-container {
      position: absolute;
      bottom: 20px; /* Positioned at the bottom with a little margin */
      width: 100%; /* Take full width */
      text-align: center; /* Center-align the buttons */
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      color: #fff;
      border: none;
      border-radius: 5px;
      margin: 5px; /* Small margin around buttons */
      background-color: #007bff; /* Bootstrap primary color */
    }

    #button1 {
      background-color: green;
    }

    #button2 {
      background-color: blue;
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

  <!-- Button container -->
  <div class="button-container">
    <button id="button1" onclick="openSearchPage()">Compare universities</button>
    <button id="button2" onclick="openComparePage()">Compare cities</button>
  </div>

  <script>
    function openSearchPage() {
      window.location.href = 'comparison_unis.php';
    }

    function openComparePage() {
      window.location.href = 'ville.php';
    }
  </script>
</body>
</html>
