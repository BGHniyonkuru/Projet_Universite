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
  <!-- Include the menu bar -->
  <div id="menu-bar"><?php include 'menu_bar.html'; ?></div>

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
