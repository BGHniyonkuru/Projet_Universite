import streamlit as st
import pymysql
conn = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='projet_universite'
)


def fetch_university_names(starting_chars):
    cursor = conn.cursor()
    query = f"""
        SELECT name
        FROM universite
        WHERE name LIKE '%{starting_chars}%'
        ORDER BY name
        LIMIT 15
        """
    cursor.execute(query)
    university_names = [row[0] for row in cursor.fetchall()]
    cursor.close()
    return university_names

def display_matching_universities(university_name, col):
    matching_names = fetch_university_names(university_name)

    if matching_names:
        selected_university = st.selectbox("Select University", matching_names)
        return selected_university
    else:
        col.write("No matching university names found for {university_name}.")
        return None

st.set_page_config(page_title="Comparison", page_icon=":tada:", layout="wide")

with open("bandeau.html", "r", encoding="utf-8") as file:
    bandeau_content = file.read()

st.components.v1.html(bandeau_content)

# ----Header section----
with st.container():
    st.subheader("Wanna get a hint about the best university for you?")
    st.title("Compare your universities")
    col1, col2, col3 = st.columns([1,1,1])
    universsity_names = fetch_university_names("")
    university1_name = col1.selectbox("University 1", [""] + university_names, index=0)
    university2_name = col2.selectbox("University 2", [""] + university_names, index=0)

    col3.write("")
    compare_button_clicked = col3.button("Compare your universities")

    if compare_button_clicked:
        st.components.v1.html("<a href='compare_universities.py'>Redirecting to comparison page...</a>")

    if university1_name:
        selected_university1 = display_matching_universities(university1_name, col1)
        if selected_university1:
            col1.text_input("university1", selected_university1)


    if university2_name:
        selected_university2 = display_matching_universities(university2_name, col2)
        if selected_university2:
            col2.text_input("University2", selected_university2)


conn.close()

# ---Load Assets
lottie_coding = ""


