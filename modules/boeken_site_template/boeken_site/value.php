<?php
include 'includes/init.php';

$value = $_GET['value'];
$user_id = $_SESSION['id'];
if(!empty($_GET['id'])){
	$book_id = $_GET['id'];
};
if(!empty($_GET['E'])){
	$e_value = $_GET['E'];
};

if ($value == 'money') {
?>

<script type="text/javascript"> 
      var value = prompt("Input a value", "0");
      var encoded = encodeURIComponent(value);
      window.location.href = '?value='+encoded+'&id='+<?php echo $book_id; ?>;
 </script>
   <?php
} else {
	if(is_numeric($value)){
		$query= $db->prepare('UPDATE user_books SET money_value=:MONEY_VALUE WHERE user_id=:USER_ID AND book_id=:BOOK_ID');
		$query->bindparam(":MONEY_VALUE",$value);
		$query->bindparam(":USER_ID",$user_id);
		$query->bindparam(":BOOK_ID",$book_id);
		$query->execute();
	} else {
		$equery = $db->prepare('UPDATE user_books SET emotional_value=:EMOTIONAL_VALUE WHERE user_id=:USER_ID AND book_id=:BOOK_ID');
		$equery->bindparam(":EMOTIONAL_VALUE",$e_value);
		$equery->bindparam(":USER_ID",$user_id);
		$equery->bindparam(":BOOK_ID",$book_id);
		$equery->execute();
	}
	header('location: ./bookList.php?Books=User');
}
?>