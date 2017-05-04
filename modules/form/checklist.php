<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<?php

include 'includes/database.php';
include 'login/session.php';



?>

<!DOCTYPE html>
<html>
<head>
<LINK href="includes/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>

<!-- <div class="dropdown">
  <select id="workshop_tijd" onchange="changeFunc(); >
  </select>
  <button id="button" type="button">Submit</button>
</div>

 -->
 <div class="dropdown">
 <select id="selectBox" onchange="changeFunc();">
   <option disabled selected>Selecteer workshop</option>
   <option value="choice_1">Workshop 14:30</option>
   <option value="choice_2">Workshop 15:00</option>
   <option value="choice_3">Workshop 16:00</option>
   <option value="choice_4">Workshop 16:30</option>
 </select>
</div>
 <div class="dropdown">
 <select id="workshops" onchange="getList();"">
 </select>
</div>
<button id="print" onclick="window.print();">Print this page</button>
<div id="table">

</div>
</body>
</html>
<script>
$('#workshops').hide();
function changeFunc() {
  $('#workshops').show();
 var selectBox = document.getElementById("selectBox");
 var selectedValue = selectBox.options[selectBox.selectedIndex].value;

 $.ajax({
  method: "POST",
  url: 'select.php',
  data: {
    column : selectedValue,
    start  : 1
  },
  success: function(res) {
    $('#workshops')[0].innerHTML = '<option disabled selected>Selecteer workshop</option>';
    for(i = 0; i < res.count; i++){
      console.log(selectedValue);
      console.log(res.value[i]);
      $('#workshops')[0].innerHTML += '<option value="'+res.value[i][selectedValue]+'">'+res.value[i][selectedValue]+'</option>';
    }
  }
 });

}
function getList(){
  console.log('get list');

  var selectBox = document.getElementById("selectBox");
  var boxValue = selectBox.options[selectBox.selectedIndex].value;


  var workshops = document.getElementById("workshops");
  var selectedValue = workshops.options[workshops.selectedIndex].value;

  console.log(boxValue);
  console.log(selectedValue);
  $.ajax({
   method: "POST",
   url: 'select.php',
   data: {
     column : boxValue,
     value  : selectedValue,
     start  : 2
   },
   success: function(res) {
    $('#table')[0].innerHTML = '';
    for(i = 0; i < res.count; i++){
      $('#table').append('<label id="label-list"><input id="input-list" type="checkbox" name="myCheckbox" /><span id="name-text">' + res.value[i]['voornaam'] + ' ' +  res.value[i]['achternaam'] + '</span></label>');
    }

   }
  });



}
</script>
