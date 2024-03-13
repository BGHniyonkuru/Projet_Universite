<!DOCTYPE html >
<html>
	<head>
		<title>Comparison Universities</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="assets/menu.css">
        <script src="https://d3js.org/d3.v7.min.js"></script>
	</head>
	<body>
        <?php
        $menu_bar_content = file_get_contents("menu_bar.html");
        echo $menu_bar_content;
        
        require("bd.php");
        $bdd=getBD();
        $query= "SELECT u.name AS university_name, c.annee, c.rank_order
                 FROM universite u
                 JOIN etre e ON e.id_universite = u.id_universite
                 JOIN classement c on e.id_classement = c.id_classement";

        $result= $bdd->prepare($query);
        $result->execute();

        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        ?>
        
        <script>
            const data = <?php echo json_encode($data); ?>;
            const svg = d3.select("body")
                          .append("svg")
                          .attr("width", 400)
                          .attr("height", 200);
            
            svg.selectAll("circle")
               .data(data)
               .enter()
               .append("circle")
               .attr("cx", (d,i) => i*30+20)
               .attr("cy", d => 100-d.rank_order)
               .attr("r", 5)
               .attr("fill", "blue");
        </script>

</body>
</html>