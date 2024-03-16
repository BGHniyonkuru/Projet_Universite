<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />

<title>Quiz</title>
</head>

<body id="body_bleu">

<div class="carre_questionnaire">
<p>Here is a short questionnaire to suggest what suits you</a></p>


<form action="enr_questionnaire.php" method="post" autocomplete="on">
		
		<label for "diplome">Last diploma obtained :</label>
		<input type="text" id="diplome" name="diplome" required/></br></br>
		
		<label for "prenom">Série :</label>
		<input type="text" id="serie" name="serie" required/></br></br>

		<label for "email">Mention :</label>
		<input type="text" id="mention" name="mention" required/></br></br>
		
		<label for "budget">Planned academic budget :</label>
		<input type="txt" id="budget" name="budget" required/></br></br>
		
		
        <label for="etatSelect">State of preference :</label></br></br>
        <select id="etatSelect" name="etatSelect" >
            <option value="" disabled selected>Choose a field</option>
            <option value="Alabama">Alabama</option>
            <option value="Alaska">Alaska</option>
			<option value="Arizona">Arizona</option>
            <option value="Arkansas">Arkansas</option>
			<option value="California">California</option>
            <option value="Colorado">Colorado</option>
			<option value="Connecticut">Connecticut</option>
            <option value="Delaware">Delaware</option>
			<option value="Columbia">Columbia</option>
            <option value="Florida">Florida</option>
			<option value="Georgia">Georgia</option>
            <option value="Hawaii">Hawaii</option>
			<option value="Idaho">Idaho</option>
            <option value="Illinois">Illinois</option>
			<option value="Indiana">Indiana</option>
            <option value="Iowa">Iowa</option>
			<option value="Kansas">Kansas</option>
            <option value="Kentucky">Kentucky</option>
			<option value="Louisiana">Louisiana</option>
            <option value="Maine">Maine</option>
			<option value="Maryland">Maryland</option>
            <option value="Massachusetts">Massachusetts</option>
			<option value="Michigan">Michigan</option>
            <option value="Minnesota">Minnesota</option>
			<option value="Mississippi">Mississippi</option>
            <option value="Missouri">Missouri</option>
			<option value="Montana">Montana</option>
            <option value="Nebraska">Nebraska</option>
			<option value="Nevada">Nevada</option>
            <option value="New Hampshire">New Hampshire</option>
			<option value="New Jersey">New Jersey</option>
            <option value="New Mexico">New Mexico</option>
			<option value="New York">New York</option>
			<option value="North Carolina">North Carolina</option>
            <option value="North Dakota">North Dakota</option>
			<option value="Ohio">Ohio</option>
            <option value="Oklahoma">Oklahoma</option>
			<option value="Oregon">Oregon</option>
            <option value="Pennsylvania">Pennsylvania</option>
			<option value="Rhode Island">Rhode Island</option>
            <option value="South Carolina">South Carolina</option>
			<option value="South Dakota">South Dakota</option>
            <option value="Tennessee">Tennessee</option>
			<option value="Texas">Texas</option>
            <option value="Utah">Utah</option>
			<option value="Vermont">Vermont</option>
            <option value="Virginia">Virginia</option>
			<option value="Washington">Washington</option>
            <option value="West Virginia">West Virginia</option>
			<option value="Wisconsin">Wisconsin</option>
            <option value="Wyoming">Wyoming</option>
        </select></br></br>
		
    <label for="domainSelect"> Field of study of preference :</label>
    <select id="domainSelect" name="domainSelect">
      <option value="" disabled selected>Choose a field</option>
      <option value="accounting">accounting</option>
      <option value="finance">finance</option>
      <option value="agriculture & forestry">agriculture & forestry </option>
      <option value="archaeology">archaeology</option>
      <option value="architecture">architecture</option>
	  <option value="art">art</option>
      <option value="biological sciences">biological sciences</option>
      <option value="business & management">business & management </option>
      <option value="chemical engineering">chemical engineering</option>
      <option value="chemistry">chemistry</option>
	  <option value="civil engineering">civil engineering</option>
      <option value="communication & media">communication & media</option>
      <option value="computer science">computer science </option>
      <option value="earth & marine sciences">earth & marine sciences</option>
      <option value="economics & econometrics">economics & econometrics</option>
      <option value="education">education</option>
      <option value="electrical & electronic engineerin">electrical & electronic engineering</option>
      <option value="sport science">sport science </option>
      <option value="environmental">environmental</option>
      <option value="general engineering">general engineering</option>
	  <option value="geography">geography</option>
      <option value="geology">geology</option>
      <option value="history">history </option>
      <option value="languages">languages</option>
      <option value="law">law</option>
	  <option value="literature & linguistics">literature & linguistics</option>
      <option value="mathematics & statistics">mathematics & statistics</option>
      <option value="mechanical & aerospace engineering">mechanical & aerospace engineering</option>
      <option value="medicine & dentistry">medicine & dentistry</option>
      <option value="other health">other health</option>
	  <option value="performing arts & design">performing arts & design</option>
      <option value="philosophy & theology">philosophy & theology </option>
      <option value="physics & astronomy">physics & astronomy</option>
      <option value="politics & international studies">politics & international studies</option>
	  <option value="psychology">psychology</option>
	  <option value="sociology">sociology</option>
      <option value="veterinary science">veterinary science</option>
    </select>
	

		<button id="oval-button-inscr" type="submit" >Validate</button></br></br>
		<a href="http://localhost/Projet/accueil.php">Ignore the questonnaire</a>
 </form>
  
</div>

</body>

<footer>
Copyright © 2023 UniDiscover
</footer>
</html>
