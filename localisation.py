from dash import Dash, html, dcc, Output, Input, callback
import plotly.express as px
import plotly.graph_objects as go
import pymysql
import pandas as pd
from geopy.geocoders import Nominatim

# Initialize the app
app = Dash(
    __name__,
    meta_tags=[
        {"name": "viewport", "content": "width=device-width, initial-scale=1.0"}
    ],
)
app.title = "US universities localization"

external_stylesheets = [
    'assets/reset.css',
    'assets/menu.css'
]


def get_coordinates(uni_name, city, state):
    # Concaténer le nom de l'université, la ville et l'état pour former l'adresse complète
    address = f"{uni_name}, {city}, {state}"

    # Utiliser Geopy pour obtenir les coordonnées géographiques
    geolocator = Nominatim(user_agent="university_locator")
    location = geolocator.geocode(address)

    if location:
        return location.latitude, location.longitude
    else:
        return None


# Connect to the MySQL database
conn = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='projet_universite'
)
# Define the SQL query to select specific columns from the "universite" table
cursor = conn.cursor()

query = """
SELECT v.id_ville, v.name AS ville, v.latitude, v.longitude, v.name_etat, u.id_universite,
    u.id_ville AS id_ville_universite, u.name AS university_name, u.domaine_etude, 
    u.`Acceptance rate` AS acceptance_rate, u.`Price(Average Cost After Financial Aid)` AS price
FROM ville v
JOIN universite u ON v.id_ville = u.id_ville;
"""

# Execute SQL queries
cursor.execute(query)
rows = cursor.fetchall()

columns = [i[0] for i in cursor.description]
df = pd.DataFrame(rows, columns=columns)

# Close the connection when you're done
conn.close()

# App layout
app.layout = html.Div([
    html.Iframe(
        srcDoc=open('menu_bar.html', 'r').read(),
        style={'width': '100%', 'height': '100px'}
    ),
    html.H1(children="Localisation", style={'textAlign': 'center'}),

    dcc.Input(id="search_university",
              type="text",
              placeholder="Enter a university name...",
              style={'width': "40%", 'margin': 'auto'}),

    html.Div(id='output_container', children=[]),
    html.Br(),

    dcc.Graph(id='my_uni_map', figure={}),

])


@callback(
    [Output('output_container', 'children'),
     Output('my_uni_map', 'figure')],
    [Input('search_university', 'value')],

)
def update_graph(option_slctd):
    container = f'The university chosen by the user was: {option_slctd}' if option_slctd else "No university searched."
    dff = df.copy()

    if option_slctd:
        dff = df[df['university_name'].str.contains(option_slctd, case=False, na=False)]

        # Ajouter les coordonnées géographiques aux données
        dff['latitude'] = 0.0
        dff['longitude'] = 0.0
        for index, row in dff.iterrows():
            university_name = row['university_name']
            city = row['ville']
            state = row['name_etat']

            coordinates = get_coordinates(university_name, city, state)
            if coordinates:
                dff.at[index, 'latitude'] = coordinates[0]
                dff.at[index, 'longitude'] = coordinates[1]

    # Plotly Express
    fig = go.Figure(go.Scattermapbox(
        lat=dff['latitude'],
        lon=dff['longitude'],
        mode='markers',
        marker=go.scattermapbox.Marker(size=10),
        text=dff['university_name'],
    ))

    fig.update_layout(
        mapbox=dict(
            accesstoken='pk.eyJ1IjoiYm5peW9uazEiLCJhIjoiY2xyeGdkYW5nMTlhZDJpbXhnMnl4ejA4cCJ9.fZNXwplt_ESYRJiJjWFKFw',
            style="light",
            center=dict(lon=-95, lat=37),
            zoom=3,
        ),
    )

    return container, fig


# Run the app
if __name__ == '__main__':
    app.run(debug=True)
