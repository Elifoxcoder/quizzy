document.addEventListener("DOMContentLoaded", () => {
  const button = document.getElementById("button");
  const navigation = document.getElementById("navigation");

  if (localStorage.getItem("mode") == "dark") {
    navigation.classList.toggle("dark_mode");
  }

  if (button) {
    button.addEventListener("click", () => {
      if (localStorage.getItem("mode") == "dark") {
        navigation.classList.remove("dark_mode");
        localStorage.setItem("mode", "light");
      } else {
        navigation.classList.add("dark_mode");
        localStorage.setItem("mode", "dark");
      }
    });
  }
});
