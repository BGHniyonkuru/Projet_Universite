import tkinter as tk


def fetch_university_names(starting_chars):
    return [f"University {i}" for i in range(1, 16)]


class CustomTkinterApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Custom Tkinter App")

        self.university1_var = tk.StringVar()
        self.university2_var = tk.StringVar()

        tk.Label(self.root, text="University 1").pack()
        self.university1_entry = tk.Entry(self.root, textvariable=self.university1_var)
        self.university1_entry.pack()

        tk.Label(self.root, text="University 2").pack()
        self.university2_entry = tk.Entry(self.root, textvariable=self.university2_var)
        self.university2_entry.pack()

        self.compare_button = tk.Button(self.root, text="Compare your universities", command=self.compare)
        self.compare_button.pack()

    def compare(self):
        university1_name = self.university1_var.get()
        university2_name = self.university2_var.get()
        print(f"Comparing {university1_name} and {university2_name}")


def run_custom_tkinter_app():
    root = tk.Tk()
    app = CustomTkinterApp(root)
    root.mainloop()


if __name__ == "__main__":
    run_custom_tkinter_app()
