<?php 
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];

$sq_package_info = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$booking_id'"));
$date = $sq_package_info['booking_date'];
$yr = explode("-", $date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="package_display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_package_booking_id($booking_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Passenger Information</h3>
		                <div class="table-responsive">
		                    <table class="table table-bordered no-marg">
			                    <thead>
			                        <tr class="table-heading-row">
				                       	<th>S_No.</th>
				                       	<th>Honorific</th>
				                       	<th>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				                       	<th>Gender</th>
				                       	<th>Date_of_birth</th>
				                       	<th>Age</th>
				                       	<th>Adole</th>
				                       	<th>Passport_No.</th>
				                       	<th>Issue_Date</th>
				                       	<th>Expire_Date</th>
			                        </tr>
			                    </thead>
		                        <tbody>
		                       <?php 
		                       		$count = 0;
		                       		$sq_entry = mysqlQuery("select * from package_travelers_details where booking_id='$booking_id'");
		                            $bg="";
		                       		while($row_entry = mysqli_fetch_assoc($sq_entry)){
		                       			if($row_entry['status']=="Cancel"){
		                       				$bg="danger";
		                       			}
		                       			else {
		                       				$bg="#fff";
		                       			}
		                       			$count++;
		                       			?>
									<tr class="<?php echo $bg; ?>">
									    <td><?php echo $count; ?></td>
									    <td><?php echo $row_entry['m_honorific'] ?></td>
									    <td><?php echo $row_entry['first_name']." ".$row_entry['last_name']; ?></td>
										<td><?php echo $row_entry['gender']; ?></td>
									    <td><?php echo get_date_user($row_entry['birth_date']); ?></td>
									    <td><?php echo $row_entry['age']; ?></td>
									    <td><?php echo $row_entry['adolescence']; ?> </td>
									    <?php 
									    if($row_entry['passport_no']==''){ ?>
									    <td><?php echo "N/A"; ?> </td>
									    <?php } else { ?>
									    <td><?php echo $row_entry['passport_no']; ?> </td>
									    <?php } ?>
									    <?php 
									    if($row_entry['passport_issue_date']=='1970-01-01'){ ?>
									    <td><?php echo "N/A"; ?> </td>
									    <?php } else { ?>
									    <td><?php echo get_date_user($row_entry['passport_issue_date']); ?></td>
									    <?php }  ?>
									    <?php
									    if($row_entry['passport_expiry_date']=='1970-01-01'){ ?>
									    <td><?php echo "N/A"; ?> </td>
									    <?php } else { ?>
									    <td><?php echo get_date_user($row_entry['passport_expiry_date']); ?></td>
									    <?php }  ?>
									</tr>  
										<script>
											$("#birth_date<?= $offset.$count ?>_d, #expiry_date<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });
										</script>      
		                       			<?php
		                       		}
		                       ?>
		                     </tbody>
		                </table>
		            </div>
		        </div>  
		    </div>
		</div>

	<!--  Train   -->
	<?php $sq_train_count = mysqli_num_rows(mysqlQuery("select * from package_train_master where booking_id='$booking_id'")); 
	if($sq_train_count != '0' ){?>
	<div class="row">    
		  	<div class="col-xs-12 mg_bt_20">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Train Information</h3>
		                <div class="table-responsive">
		                    <table  class="table table-bordered no-marg">
			                    <thead>
                       		<tr class="table-heading-row">
		                       	<th>S_No.</th>
		                       	<th>Departure&nbsp;</th>
		                       	<th>Location_From</th>
		                       	<th>Location_To</th>
		                       	<th>Train_Name_No</th>
		                       	<th>Total_Seats</th>
		                       	<th>Class</th>
		                       	<th>Priority</th>
                       		</tr>
                    	</thead>
                   		<tbody>
                       <?php 
                       		$count = 0;
                       		$sq_entry = mysqlQuery("select * from package_train_master where booking_id='$booking_id'");
                       		while($row_entry = mysqli_fetch_assoc($sq_entry)){
                       			$count++;
                       	?>
							<tr class="<?php echo $bg; ?>">
							    <td><?php echo $count; ?></td>
							    <td><?php echo date("d-m-Y H:i", strtotime($row_entry['date'])) ?></td>
							    <td><?php echo $row_entry['from_location'] ?></td>
								<td><?php echo $row_entry['to_location']; ?></td>
							    <td><?php echo $row_entry['train_no']; ?></td>
							    <td><?php echo $row_entry['seats']; ?> </td>
							    <td><?php echo $row_entry['train_class']; ?> </td>
							    <td><?php echo $row_entry['train_priority']; ?></td>
							</tr>        
	               			<?php

	               				}

	               			?>
	                    </tbody>
		                </table>
		            </div>
		        </div>  
		    </div>
		</div> 
		<?php } ?>
		<!--  Flight   -->
	<?php $sq_plane_count = mysqli_num_rows(mysqlQuery("select * from package_plane_master where booking_id='$booking_id'")); 
	if($sq_plane_count != '0' ){?>
	<div class="row">    
		  	<div class="col-xs-12 mg_bt_20">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Flight Information</h3>
		                <div class="table-responsive">
		                    <table  class="table table-bordered no-marg">
			                   <thead>
	                       	<tr class="table-heading-row">
		                       	<th>S_No.</th>
		                       	<th>Departure&nbsp;</th>
		                       	<th>From_City</th>
								<th>Sector_From</th>
								<th>To_City</th>
		                       	<th>Sector_To</th>
		                       	<th>Airline_Name</th>
		                       	<th>Total_Seats</th>
		                       	<th>Arrival&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	                       </tr>
	                    </thead>
	                    <tbody>
	                       <?php 
	                       		$count = 0;
	                       		$sq_entry = mysqlQuery("select * from package_plane_master where booking_id='$booking_id'");
	                       		while($row_entry = mysqli_fetch_assoc($sq_entry)){
	                       			$count++;
	                       			$sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_entry[company]'"));

	                       			$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_entry[from_city]'"));
		                            $sq_city1 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_entry[to_city]'"));
	                       	?>
							<tr class="<?php echo $bg; ?>">
							    <td><?php echo $count; ?></td>
							    <td><?php echo date("d-m-Y H:i", strtotime($row_entry['date'])) ?></td>
							    <td><?php echo $sq_city['city_name']; ?></td>
								<td><?php echo $row_entry['from_location']; ?></td>
								<td><?php echo $sq_city1['city_name']; ?></td>
								<td><?php echo $row_entry['to_location']; ?></td>
							    <td><?php echo $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')'; ?></td>
							    <td><?php echo $row_entry['seats']; ?> </td>
							    <td><?php echo date("d-m-Y H:i", strtotime($row_entry['arraval_time'])); ?> </td>
							</tr>  
							<script>
								$("#birth_date<?= $offset.$count ?>_d, #expiry_date<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });
							</script>      
	               			<?php

	               				}

	               			?>
	                    </tbody>
		                </table>
		            </div>
		        </div>  
		    </div>
		</div> 
		<?php } ?>			
		
<!-- Cruise Info -->
<?php $sq_c_count = mysqli_num_rows(mysqlQuery("select * from package_cruise_master where booking_id='$booking_id'")); 
    if($sq_c_count != '0'){?>
	<div class="row">

	<div class="col-xs-12 mg_bt_20">

		<div class="profile_box main_block">

        	 	<h3 class="editor_title">Cruise Information</h3>
				<div class="table-responsive">
                    <table class="table table-bordered no-marg">
	                    <thead>
	                       	<tr class="table-heading-row">
		                       	<th>S_No.</th>
		                       	<th>Departure_Date/Time</th>
		                       	<th>Arrival_Date/Time</th>
		                       	<th>Route</th>
		                       	<th>Cabin</th>
		                       	<th>Sharing</th>
		                       	<th>Seats</th>
	                       </tr>
	                    </thead>
	                    <tbody>
	                       <?php 
	                       		$count = 0;
	                       		$sq_entry = mysqlQuery("select * from package_cruise_master where booking_id='$booking_id'");
	                       		while($row_entry = mysqli_fetch_assoc($sq_entry)){
	                       			$count++;
	                       	?>
							<tr class="<?php echo $bg; ?>">
							    <td><?php echo $count; ?></td>
							    <td><?php echo get_datetime_user($row_entry['dept_datetime']) ?></td>
							    <td><?php echo get_datetime_user($row_entry['arrival_datetime']) ?></td>
								<td><?php echo $row_entry['route']; ?></td>
							    <td><?php echo $row_entry['cabin']; ?></td>
							    <td><?php echo $row_entry['sharing']; ?></td>
							    <td><?php echo $row_entry['seats']; ?> </td>
							</tr>

	               			<?php

	               				}

	               			?>
	                    </tbody>
                </table>
            </div>
	    </div> 
	</div>
</div>
<?php } ?>
	</div>
</div>
</div>
</div>
  
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#package_display_modal').modal('show');
</script>