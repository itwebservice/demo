<?php
include_once('../../../../model/model.php');
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$branch_status = $_POST['branch_status']; 
?>
<form id="frm_vendor_payment_save1">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>" >
<div class="modal fade" id="v_payment_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width:80%; margin-top:20px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Payment Save</h4>
      </div>
      <div class="modal-body">

            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
            <legend>Select Sale</legend>

              <div class="row">
                <div class="col-md-3">
                  <select class="form-control" name="vendor_type" id="vendor_type" title="Supplier Type" onchange="vendor_data_for_pay(this.value, 'div_vendor_type_content')">
                    <option value="">*Supplier Type</option>
                    <?php 
                    $sq_vendor = mysqlQuery("select * from vendor_type_master order by vendor_type");
                    while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
                      ?>
                      <option value="<?= $row_vendor['vendor_type'] ?>"><?= $row_vendor['vendor_type'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="div_vendor_type_content"></div>
                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <select class="form-control" name="estimate_type3" id="estimate_type3" title="Purchase Type" onchange="payment_for_data_load(this.value, 'div_payment_for_content3', '3')">
                    <option value="">Purchase Type</option>
                    <?php 
                    $sq_estimate_type = mysqlQuery("select * from estimate_type_master order by estimate_type");
                    while($row_estimate = mysqli_fetch_assoc($sq_estimate_type)){
                      ?>
                      <option value="<?= $row_estimate['estimate_type'] ?>"><?= $row_estimate['estimate_type'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="div_payment_for_content3"></div>
              </div>

            </div>
            <div id="div_payment_for"></div>

            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
            <legend>Payment Particulars</legend>
          
              <div class="row mg_bt_20">
                <div class="col-md-4">
                  <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="Date" title="Payment Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
                </div>  
                <div class="col-md-4">
                  <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Amount" title="Payment Amount" onchange="number_validate(this.id);">
                </div>             
                <div class="col-md-4">
                  <select class="form-control" name="payment_mode" id="payment_mode" title="*Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                  <option value="">*Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="NEFT">NEFT</option>
                    <option value="RTGS">RTGS</option>
                    <option value="IMPS">IMPS</option>
                    <option value="DD">DD</option>
                    <option value="Online">Online</option>
                    <option value="Debit Note">Debit Note</option>
                    <option value="Advance">Advance</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
              <div class="row mg_bt_10">
                <div class="col-md-4">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
                </div>
                <div class="col-md-4">
                  <input type="text" id="transaction_id" name="transaction_id" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
                </div>
                <div class="col-md-4">
                  <select class="form-control" name="bank_id" id="bank_id" title="Debitor Bank" disabled>
                    <?php get_bank_dropdown('Debitor Bank'); ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="div-upload pull-left" id="div_upload_button">
                      <div id="payment_evidence_upload" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url" name="payment_evidence_url">
                  </div>
                </div>
                <div class="col-md-9 col-sm-9 no-pad mg_bt_20">
                  <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note">Please make sure Date, Amount, Mode, Debitor bank entered properly.</span>
                </div>
              </div>

            </div>

            <div class="row text-center mg_tp_20">
                <div class="col-md-12">
                  <button class="btn btn-success" id="payment_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>    


      </div>      
    </div>
  </div>
</div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#v_payment_save_modal').modal('show');
$('#payment_date').datetimepicker({timepicker:false, format:'d-m-Y'});

payment_evidence_upload();
function payment_evidence_upload(offset='')
{
    var btnUpload=$('#payment_evidence_upload'+offset);
    var status=$('#payment_evidence_status'+offset);
    new AjaxUpload(btnUpload, {
      action: 'payment/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         var id_proof_url = $("#payment_evidence_url"+offset).val();
          
     
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          $("#payment_evidence_url"+offset).val(response);
		  $(btnUpload).find('span').text('Uploaded');
          msg_alert('File uploaded!');
        }
      }
    });

}
$(function(){
  $('#frm_vendor_payment_save1').validate({
      rules:{              
              vendor_type: { required: true },
              payment_amount : { required: true, number:true },
              payment_date : { required: true },
              payment_mode : { required : true },
              bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
              bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
      },
      submitHandler:function(form){
        $('#payment_save').prop('disabled',true);
        var status = validate_estimate_vendor('estimate_type3','3');
        if(!status){ 
        $('#payment_save').prop('disabled',false);
        return false; }

        var vendor_type = $('#vendor_type').val();
        var vendor_type_id = get_vendor_type_id('vendor_type');
        var estimate_type = $('#estimate_type3').val();
        var estimate_type_id = get_estimate_type_id('estimate_type3','3');
        var payment_amount = $('#payment_amount').val();
        var payment_date = $('#payment_date').val();
        var payment_mode = $('#payment_mode').val();
        var bank_name = $('#bank_name').val();
        var transaction_id = $('#transaction_id').val();              
        var bank_id = $('#bank_id').val();
        var payment_evidence_url = $('#payment_evidence_url').val();
        var branch_admin_id = $('#branch_admin_id1').val();
        var emp_id = $('#emp_id').val();
        var base_url = $('#base_url').val();
        if(vendor_type_id == ''){
          error_msg_alert("Select "+vendor_type+"!");
          $('#payment_save').prop('disabled',false);
          return false;
        }
        
        var advance_amount = $('#advance_amount').val();
        var advance_nullify = $('#advance_nullify').val();
        var debit_note_amount =  $('#debit_note_amount').val();

        // Jquery check undefined value
        if(typeof advance_nullify === "undefined") { advance_nullify = '0'; }
        if(typeof advance_amount === "undefined") { advance_amount = '0'; }
        if(typeof debit_note_amount === 'undefined') { debit_note_amount = '0'; }
        if(advance_nullify == "") { advance_nullify = '0'; }

        if(payment_mode=='Credit Card'){
          $('#payment_save').prop('disabled',false);
          error_msg_alert("Please select another payment mode!");
          return false; 
        }

        //Amount Validations
        if(parseFloat(advance_nullify) > 0 || parseFloat(advance_nullify) != '' || parseFloat(advance_nullify) != 0){

          if(parseFloat(payment_amount)>0){
            $('#payment_save').prop('disabled',false);
            error_msg_alert("Please release payment either from Advances or Payment Particulars!");
            return false; 
          }
          if(payment_mode!='Advance'){
            $('#payment_save').prop('disabled',false);
            error_msg_alert("Please select payment mode as Advance!");
            return false; 
          }
        }
        if(payment_mode=='Advance'){
          
          if(parseFloat(advance_nullify) <= 0 || parseFloat(advance_nullify) == ''){
            
            $('#payment_save').prop('disabled',false);
            error_msg_alert("Please select another payment mode!");
            return false; 
          }
          if(parseFloat(advance_amount) < parseFloat(payment_amount)){ 
            $('#payment_save').prop('disabled',false);
            error_msg_alert("Payment amount to be nullify should not be more than Advance");
            return false; 
          }
        }
        if (payment_mode == "Debit Note" && debit_note_amount == '0') {
          error_msg_alert("You don't have Debit Note Amount");
          $('#payment_save').prop('disabled', false);
          return false;
        }
        else if(payment_mode == 'Debit Note' && debit_note_amount != '0') {
          if (parseFloat(payment_amount) > parseFloat(debit_note_amount)) {
            error_msg_alert('Low Debit note balance');
            $('#payment_save').prop('disabled', false);
            return false;
          }
        }

        if(parseFloat(advance_nullify)<'0'){ 
          $('#payment_save').prop('disabled',false);
          error_msg_alert("Amount to be nullify should be greater than 0"); return false; 
        };

        var total_payment_amount = parseFloat(payment_amount) + parseFloat(advance_nullify);

        $.post('../inc/costing_check.php', {vendor_type : vendor_type,vendor_type_id : vendor_type_id,estimate_type : estimate_type, estimate_type_id : estimate_type_id}, function(check){
          if(isNaN(check) || isNaN(parseInt(check))){
            $('#payment_save').prop('disabled',false);
            error_msg_alert("Please select the Booking(with a Purchase).");
            return false;
          }
          else{
            $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
            if(data !== 'valid'){
              $('#payment_save').prop('disabled',false);
              error_msg_alert("The Payment date does not match between selected Financial year.");
              return false;
            }
            else{
              $('#payment_save').button('loading');

              $.ajax({
                type: 'post',
                url: base_url+'controller/vendor/dashboard/multiple_invoice_payment/payment_save.php',
                data:{ vendor_type : vendor_type, vendor_type_id : vendor_type_id,estimate_type : estimate_type,estimate_type_id : estimate_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_evidence_url :payment_evidence_url, branch_admin_id : branch_admin_id , emp_id : emp_id,advance_nullify : advance_nullify,total_payment_amount:total_payment_amount},
                success: function(result){
                $('#payment_save').button('reset');
                $('#payment_save').prop('disabled',false);
                var msg = result.split('-');
                if(msg[0]=='error'){
                  msg_alert(result);
                }
                else{
                  msg_alert(result);
                  $('#v_payment_save_modal').modal('hide'); 
                  reset_form('frm_vendor_payment_save1'); 
                  payment_list_reflect();
                }
                
              }
            });
          }
        });
        }
        });

      }
  });
});
</script>