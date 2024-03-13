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
<p>Voici un petit questionnaire pour vous suggérer ce qui vous correspond</a></p>


<form action="enr_questionnaire.php" method="post" autocomplete="on">
		
		<label for "diplome">Last diploma obtained :</label>
		<input type="text" id="diplome" name="diplome" required/></br></br>
		
		<label for "prenom">Série :</label>
		<input type="text" id="serie" name="serie" required/></br></br>

		<label for "email">Mention :</label>
		<input type="text" id="mention" name="mention" required/></br></br>
		
		<label for "budget">Planned academic budget :</label>
		<input type="txt" id="budget" name="budget" required/></br></br>
		
		<label for "lieux">State of preference :</label>
		<input type="txt" id="etat" name="etat" required/></br></br>
		
		<div id="domainLists">
    <!-- Initial dropdown list -->
    <label for="domainSelect">Choose a field :</label>
    <select class="domainSelect" onchange="updateDomainInput()">
      <option value="" disabled selected>Choose a field</option>
      <option value="Domaine1">accounting</option>
      <option value="Domaine2">finance</option>
      <option value="Domaine3">agriculture & forestry </option>
      <option value="Domaine4">archaeology</option>
      <option value="Domaine5">architecture</option>
	  <option value="Domaine6">art</option>
      <option value="Domaine7">biological sciences</option>
      <option value="Domaine8">business & management </option>
      <option value="Domaine9">chemical engineering</option>
      <option value="Domaine10">chemistry</option>
	  <option value="Domaine11">civil engineering</option>
      <option value="Domaine12">communication & media</option>
      <option value="Domaine13">computer science </option>
      <option value="Domaine14">earth & marine sciences</option>
      <option value="Domaine15">economics & econometrics</option>
      <option value="Domaine16">education</option>
      <option value="Domaine17">electrical & electronic engineering</option>
      <option value="Domaine18">sport science </option>
      <option value="Domaine19">environmental</option>
      <option value="Domaine20">general engineering</option>
	  <option value="Domaine21">geography</option>
      <option value="Domaine22">geology</option>
      <option value="Domaine23">history </option>
      <option value="Domaine24">languages</option>
      <option value="Domaine25">law</option>
	  <option value="Domaine26">literature & linguistics</option>
      <option value="Domaine27">mathematics & statistics</option>
      <option value="Domaine28">mechanical & aerospace engineering</option>
      <option value="Domaine29">medicine & dentistry</option>
      <option value="Domaine30">other health</option>
	  <option value="Domaine31">performing arts & design</option>
      <option value="Domaine32">philosophy & theology </option>
      <option value="Domaine33">physics & astronomy</option>
      <option value="Domaine34">politics & international studies</option>
	  <option value="Domaine35">psychology</option>
	  <option value="Domaine36">sociology</option>
      <option value="Domaine37">veterinary science</option>
    </select>
	
  
  <a href="#" onclick="addNewDomain()">+ Add an other field</a>
  
		<button id="oval-button-inscr" type="submit" >Submit</button></br></br>
		<a href="http://localhost/Projet/accueil.php">Ignore the quiz</a>
 </form>
  
</div>

<script>
  function updateDomainInput() {
    // Met à jour la valeur de la case d'entrée avec la valeur sélectionnée dans le menu déroulant
    const domainSelect = document.querySelector('.domainSelect');
    const domainInput = document.getElementById('domainInput');

    domainInput.value = domainSelect.value;
  }

  function addNewDomain() {
    // Crée une nouvelle liste déroulante et l'ajoute au formulaire
    const domainLists = document.getElementById('domainLists');
    const newDomainSelect = document.createElement('select');
    newDomainSelect.className = 'domainSelect';
    newDomainSelect.onchange = updateDomainInput;

    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = 'Select a field';

    newDomainSelect.appendChild(defaultOption);
    
    const domaines = ['accounting', 'finance', 'agriculture & forestry', 'archaeology', 'architecture','art','biological sciences','business & management','chemical engineering','chemistry','civil engineering',
	'communication & media','computer science','earth & marine sciences','economics & econometrics','education','electrical & electronic engineering','sport science','environmental',
	'general engineering','geography','geology','history','languages','law','literature & linguistics','mathematics & statistics','mechanical & aerospace engineering','medicine & dentistry',
	'other health','performing arts & design','philosophy & theology','physics & astronomy','politics & international studies','psychology','sociology','veterinary science'];

    domaines.forEach(domaine => {
      const option = document.createElement('option');
      option.value = domaine;
      option.textContent = domaine;
      newDomainSelect.appendChild(option);
    });

    domainLists.appendChild(newDomainSelect);
  }
</script>

</body>

<footer>
Copyright © 2023 UniDiscover
</footer>
</html>
