document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('rulesModal');

    var returnButton = document.getElementById('returnButton');
    if (returnButton) {
        returnButton.onclick = function() {
            window.location.href = '../autosalons/index.php';
        }
    }
});
