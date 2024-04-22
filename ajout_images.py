import mysql.connector

# Connexion à la base de données
connexion = mysql.connector.connect(
    host='127.0.0.1',
    user='root',
    database='projet_universite'
)

# Création d'un curseur
curseur = connexion.cursor()

# Lecture du fichier texte
with open('C:\\Users\\elise\\OneDrive\\Bureau\\Cours fac\\L3\\Gestion de projet\\Jeux de Données\\bd\\img_univ.txt', 'r') as fichier:
    lignes = fichier.readlines()

# Parcourir les lignes du fichier et effectuer les mises à jour
for ligne in lignes:
    valeurs = ligne.strip().split(',')
    id_universite = valeurs[0]
    chemin_image = valeurs[1]

    # Exécution de la requête de mise à jour
    requete = f"UPDATE universite SET image = '{chemin_image}' WHERE id_universite = {id_universite}"
    curseur.execute(requete)

# Valider les modifications
connexion.commit()

# Fermer la connexion
curseur.close()
connexion.close()
