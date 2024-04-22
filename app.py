from flask import Flask, jsonify, request
from flask_cors import CORS
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression
import mysql.connector

app = Flask(__name__)
CORS(app)

# Fonction pour récupérer les données et effectuer la prédiction
def fetch_and_predict():
    conn = mysql.connector.connect(
        host='127.0.0.1',
        user='root',
        #password='your_password',  # Uncomment and set your MySQL root password here
        database='projet_universite'
    )
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM classement")
    rows = cursor.fetchall()
    columns = cursor.column_names
    data = pd.DataFrame(rows, columns=columns)
    cursor.close()
    conn.close()


    # Nettoyage des données
    data['id_classement'] = pd.to_numeric(data['id_classement'], errors='coerce')
    data['stats_number_students'] = pd.to_numeric(data['stats_number_students'], errors='coerce')
    data['percentage_of_women'] = pd.to_numeric(data['percentage_of_women'], errors='coerce')
    data = data.rename(columns={'percentage_of_male': 'percentage_of_male'})

    # Ingénierie des caractéristiques
    data['score_exp'] = 1 / (data['rank_order'] ** 1)

    # Préparation du modèle
    features = ['id_classement', 'scores_teaching', 'scores_research', 'scores_citations', 'scores_industry_income', 
                'scores_international_outlook', 'stats_number_students', 'stats_pc_intl_students',
                'stats_student_staff_ratio', 'annee']
    X = data[features]
    y = data['score_exp']

    # Division des données
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

    # Analyse de régression
    model = LinearRegression()
    model.fit(X_train, y_train)
    y_pred = model.predict(X_test)

    # Transformation des prédictions pour évaluation
    predicted_rankings = 1 / np.power(y_pred, 1)
    actual_rankings = 1 / np.power(y_test, 1)

    # Conversion des résultats en listes pour JSON
    predicted_rankings_list = predicted_rankings.tolist()
    actual_rankings_list = actual_rankings.tolist()
    ids = X_test['id_classement'].tolist()

    return jsonify({"Predicted Rankings": predicted_rankings_list, "Actual Rankings": actual_rankings_list, "id_classement": ids})


    #return jsonify({"Predicted Rankings": predicted_rankings.tolist(), "Actual Rankings": actual_rankings.tolist(), "id_classement": ids.tolist()})

@app.route('/predict', methods=['GET'])
def predict():
    return fetch_and_predict()

if __name__ == "__main__":
    app.run(debug=True)
