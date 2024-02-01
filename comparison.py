from dash import Dash, html, dcc, Output, Input, callback
import plotly.express as px
import pymysql
import pandas as pd

app = Dash(
    __name__,
    meta_tags=[
        {"name": "viewport", "content": "width=device-width, initial-scale=1.0"}
    ],
    )

app.title = "US universities Comparisons"

external_stylesheets = [
    'assets/reset.css',
    'assets/menu.css'
]

# Connect to the MySQL database
conn = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='projet_universite'
)
# Define the SQL query to select specific columns from the "universite" table


query = """
SELECT u.id_universite,u.id_ville AS id_ville_universite, u.name AS university_name, u.domaine_etude, 
    u.`Acceptance rate` AS acceptance_rate, u.`Price(Average Cost After Financial Aid)` AS price,
     c.annee, c.rank_order
    FROM universite AS u
    JOIN etre AS e ON u.id_universite = e.id_universite
    JOIN classement AS c ON e.id_classement = c.id_classement
"""

# Execute SQL queries
cursor = conn.cursor()
cursor.execute(query)
rows = cursor.fetchall()

columns = [i[0] for i in cursor.description]
df = pd.DataFrame(rows, columns=columns)

# Close the connection when you're done
conn.close()

app.layout = html.Div([
    html.Iframe(
            srcDoc=open('menu_bar.html', 'r').read(),
            style={'width': '100%', 'height': '100px'}
        ),
    dcc.Dropdown(
        id="slct_year",
        options=[
            {'label': str(year), 'value': year} for year in df['annee'].unique()],
            multi=False,
            value=df['annee'].max(),
            style={'width': "40%"}
    ),
    dcc.Graph(id="comparison-chart"),
])


@app.callback(
    Output("comparison-chart", "figure"),
    [Input("university-selector", "value")]
)
def update_chart(selected_universities):
    filtered_df = df_universite[df_universite["id_universite"].isin(selected_universities)]

    figure = px.bar(filtered_df, x="name", y="acceptance_rate", title="Comparison of Acceptance Rates")
    return figure


if __name__ == '__main__':
    app.run_server(debug=True)
