<?php
include_once("../../../model/model.php");
$entry_id = $_POST['entry_id'];
$sq_gallary =  mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id = '$entry_id'"));
?>
<form id="frm_save">

<div class="modal fade" id="display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div>
        <?php   
            $url = $sq_gallary['image_url'];
            $pos = strstr($url,'uploads');
            if ($pos != false)   {
                $newUrl1 = preg_replace('/(\/+)/','/',$sq_gallary['image_url']); 
                $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
            }
            else{
                $newUrl =  $sq_gallary['image_url']; 
            }
            if($newUrl!=''){
              ?>
            <img src="<?php echo $newUrl; ?>" class="img-responsive">
            <?php } ?>
      </div>     
      <div class="img_description">
        <p><?php echo $sq_gallary['description']; ?></p>
      </div>   
    </div>
  </div>
</div>

</form>
<script>
$('#display_modal').modal('show');
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>