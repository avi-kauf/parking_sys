var dots = "";
window.setInterval(
function () {
    dots = dots + ".";
    document.getElementById("dots").innerHTML ="Please Wait" + dots;
}, 500);
setTimeout(function() {
  $("#unlog").fadeOut().empty();
  window.location.href = "login.php";
}, 3000);