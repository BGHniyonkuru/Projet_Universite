<!DOCTYPE html>
<html>
<head>
    <title>Comparison</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/menu.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php
    require("bd.php");

    function fetch_university_names($starting_chars){
        global $bdd;
        $query = "SELECT u.name FROM universite u 
                  WHERE u.name LIKE :starting_chars ORDER BY u.name LIMIT 15";

        $result = $bdd->prepare($query);
        $result->bindValue(':starting_chars', '%' . $starting_chars . '%', PDO::PARAM_STR);
        $result->execute();
        $university_names = array();
        if ($result !== false) {
            if ($result->rowCount() > 0){
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $university_names[] = $row["name"];
                }
            }
        }
        return $university_names;
    }

    $university_names = fetch_university_names("");
    ?>

    <h1>Compare your universities</h1>
    <form action="form_comparison.php" method="post">
        <label for="university1"> University 1: </label>
        <input type="text" id="university1_input" name="university1" autocomplete="off">
        <select id="university1_select" style="display:none;"></select>
        <br>
        <label for="university2"> University 2: </label>
        <input type="text" id="university2_input" name="university2" autocomplete="off">
        <select id="university2_select" style="display:none;"></select>
        <br>
        <input type="submit" value="Compare">
    </form>

    <script>
        $(document).ready(function(){
            $('#university1_input').on('input', function(){
                var inputVal = $(this).val();
                $.ajax({
                    url: 'form_comparison.php',
                    type: 'post',
                    data: {starting_chars: inputVal},
                    success: function(response){
                        $('#university1_select').html(response);
                        $('#university1_select').show();
                    }
                });
            });

            $('#university2_input').on('input', function(){
                var inputVal = $(this).val();
                $.ajax({
                    url: 'form_comparison.php',
                    type: 'post',
                    data: {starting_chars: inputVal},
                    success: function(response){
                        $('#university2_select').html(response);
                        $('#university2_select').show();
                    }
                });
            });

            $('#university1_select').on('change', function(){
                $('#university1_input').val(($this).val());
                $(this).hide();
            });

            $('#university2_select').on('change', function(){
                $('#university2_input').val(($this).val());
                $(this).hide();
            });
        });
    </script>

</body>
</html>
    