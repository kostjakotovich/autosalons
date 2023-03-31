function on() {
  document.getElementById("overlay").style.display = "block";
}

function off(event) {
  if (event && (event.target.id === "cancelButton" || event.target.id === "submitButton")) {
    document.getElementById("overlay").style.display = "none";
  }
  if (event) {
    event.preventDefault();
  }
}

