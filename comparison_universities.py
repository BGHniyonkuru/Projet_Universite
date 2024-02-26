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
        SELECT *
        FROM universite u
        JOIN etre e ON e.id_universite = u.id_universite
    
        """
    cursor.execute(query)
    university_names = [row[0] for row in cursor.fetchall()]
    cursor.close()
    return university_names