<?php include "../../model/model.php"; ?>
<?php
  
  $tourwise_id = $_GET['tourwise_id'];  
  $traveling_type = $_GET['traveling_type'];
?>
	<option value=""> Select Transaction </option>   
<?php

  $sq = mysqlQuery("select * from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='$traveling_type'");
  while($row = mysqli_fetch_assoc($sq))
  {
    if($row['amount']!=0)
    {  
  	?> 

     <option value="<?php echo $row['payment_id'] ?>"><?php echo $row['payment_id'].'-'.$row['amount']; ?></option>

    <?php
    } 
  }  

?>