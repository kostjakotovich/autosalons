function on() {
  document.getElementById("overlay_order").style.display = "block";
}

function off(event) {
  if (event && (event.target.id === "cancelButton" || event.target.id === "submitButton")) {
    document.getElementById("overlay_order").style.display = "none";
  }
  if (event) {
    event.preventDefault();
  }
}

