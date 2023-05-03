function openTab(evt, tabName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("tab");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}
function deleteDatabase() {
  var confirmDelete = confirm("Are you sure you want to delete the database?");
  if (confirmDelete) {
    jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: {
        action: "delete_myplugin_database"
      },
      success: function(response) {
        alert("Database deleted successfully!");
        location.reload();
      }
    });
  }
}
