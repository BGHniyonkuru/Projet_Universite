import streamlit as st
import pymysql
import pandas as pd
import plotly.express as px

conn = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='projet_universite'
)

st.set_page_config(page_title="Comparison Universities", page_icon=":tada:", layout="wide")
with open("menu_bar.html", "r", encoding="utf-8") as file:
    bandeau_content = file.read()

def fetch_university_names(starting_chars):
    cursor = conn.cursor()
    query = f"""
        SELECT u.name AS university_name, c.annee, c.rank_order
        FROM universite u
        JOIN etre e ON e.id_universite = u.id_universite
        JOIN classement c ON e.id_classement = c.id_classement
    
        """
    cursor.execute(query)
    rows = cursor.fetchall()
    cursor.close()
    columns = [desc[0] for desc in cursor.description]
    df = pd.DataFrame(rows, columns=columns)
    return df

university_df = get_university_data()

st.title('Comparaison des universités')

fig= px.line(university_df, x="rank_order", color="university_name",
             title="Rank_order along years")

st.plotly_chart(fig)

conn.close()





st.components.v1.html(bandeau_content)