
  document.addEventListener("DOMContentLoaded", function(event) { 
    const closeButton = document.querySelector(".alert .close");
    if (closeButton) {
      closeButton.addEventListener("click", function() {
        const alert = this.closest(".alert");
        alert.style.display = "none";
      });
    }
  });
