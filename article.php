<?php 
include("header.php");
if(!isset($_SESSION['adminid']))
{
	echo "<script>window.location='adminloginpanel.php'; </script>";
}
if($_SESSION['randnumber']  == $_POST['randnumber'])
{
if(isset($_POST['submit']))
{
	
	$imgname1 = rand() . $_FILES['img1']['name'];
	move_uploaded_file($_FILES['img1']['tmp_name'],"imgarticle/" . $imgname1);
	$imgname2 = rand() . $_FILES['img2']['name'];
	move_uploaded_file($_FILES['img2']['tmp_name'],"imgarticle/" . $imgname2);
	$imgname3 = rand() . $_FILES['img3']['name'];
	move_uploaded_file($_FILES['img3']['tmp_name'],"imgarticle/" . $imgname3);
	$imgname4 = rand() . $_FILES['img4']['name'];
	move_uploaded_file($_FILES['img4']['tmp_name'],"imgarticle/" . $imgname4);
	$imgname5 = rand() . $_FILES['img5']['name'];
	move_uploaded_file($_FILES['img5']['tmp_name'],"imgarticle/" . $imgname5);
	
	if(isset($_GET['editid']))
	{
		$sql ="UPDATE record SET `record_type`='$_POST[recordtype]', `publish_date`='$_POST[publishdate]', `title`='$_POST[title]', `record_description`='$_POST[description]', `record_img1`='$imgname1', `record_img2`='$imgname2', `record_img3`='$imgname3', `record_img4`='$imgname4', `record_img5`='$imgname5', `status`='$_POST[status]' where record_id='$_GET[editid]'";
		if(!mysqli_query($con,$sql))
		{
			echo "Error in mysqli query";
		}
		else
		{
			echo "<script>alert('Record updated successfully...');</script>";
		}
	}
	else
	{
		$description = mysqli_real_escape_string($con, $_POST['description']);
	$sql="INSERT INTO `record`(`record_id`, `record_type`, `publish_date`, `title`, `record_description`, `record_img1`, `record_img2`, `record_img3`, `record_img4`, `record_img5`, `status`) VALUES ('','$_POST[recordtype]','$_POST[publishdate]','$_POST[title]','$description','$imgname1','$imgname2','$imgname3','$imgname4','$imgname5','Active')";
	if(!mysqli_query($con,$sql))
		{
			echo "Error in mysqli query" . mysqli_error($con);
		}
		else
		{
			echo "<script>alert('Record inserted successfully...');</script>";
		}
	}
}
}
$randnumber = rand();
$_SESSION['randnumber'] = $randnumber;
if(isset($_GET['editid']))
{
	$sql = "SELECT * FROM record WHERE record_id='$_GET[editid]'";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
}
?>
  <main id="main">


    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in">
		<br><br>
          <h3>Record</h3>
        </div>

      </div>
    </section><!-- End Cta Section -->


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="row">
		

          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            <div class="info mt-4 ">
			
		<center><h4>Enter Record Detail...</h4></center><hr>

<form method="post" action="" enctype="multipart/form-data" name="frmrecord" onSubmit="return validaterecord()">
<input type="hidden" name="randnumber" value="<?php echo $randnumber; ?>" >
				  
<div class="form-row">
	<div class="col-md-6 form-group">
	Record Type <font color="#FF0000">*</font>
	  <select name="recordtype" id="recordtype" autofocus class="form-control" >
		<option value="">Select Record Type</option>
		  <?php
		  $arr= array("Event","Competition");
		  $i=1;
		  foreach($arr as $val)
		  {
			  if($rsedit['record_type'] == $val)
			  {
			  echo "<option value='$val' selected >$val</option>";
			  }
			  else
			  {
			  echo "<option value='$val'>$val</option>";
			  }
		  }
		  ?>
	  </select>
	</div>	
	
	<div class="col-md-6 form-group">
		Publish Date <font color="#FF0000">*</font>
		<input type="date" name="publishdate" id="publishdate" value="<?php echo $rsedit['publish_date']; ?>" class="form-control" >
	</div>	
	
	<div class="col-md-12 form-group">
		Title <font color="#FF0000">*</font>
		<input type="text" name="title" id="title" value="<?php echo $rsedit['title']; ?>" class="form-control">
	</div>	
	
	<div class="col-md-12 form-group">
	Description <font color="#FF0000">*</font>
	  <textarea  name="description" id="description" class="form-control" ><?php echo $rsedit['record_description']; ?></textarea>
	</div>	
	
	
	<div class="col-md-6 form-group">
	Image 1 (Primary image) <font color="#FF0000">*</font>
	  <input type="file" name="img1" id="img1" class="form-control">
	</div>	
	<div class="col-md-6 form-group">
	Image 2<font color="#FF0000">*</font>
	  <input type="file" name="img2" id="img2" class="form-control">
	</div>	
	<div class="col-md-6 form-group">
	Image 3<font color="#FF0000">*</font>
	  <input type="file" name="img3" id="img3" class="form-control">
	</div>	
	<div class="col-md-6 form-group">
	Image 4<font color="#FF0000">*</font>
	  <input type="file" name="img4" id="img4" class="form-control">
	</div>	
	<div class="col-md-6 form-group">
	Image 5<font color="#FF0000">*</font>
	  <input type="file" name="img5" id="img5" class="form-control">
	</div>	
	
	
</div>

<hr>
<button type="submit" name="submit" id="submit" class="btn btn-info btn-lg btn-block" >Submit</button>

</form>
            </div>
		  </div>
		  
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  
<?php
include("footer.php");
?>
	<script type="application/javascript">
	function validaterecord()
	{
				if(document.frmrecord.recordtype.value == "")
				{
					alert("Kindly select an record type..");
					document.frmrecord.recordtype.focus();
					return false;
				}
					else if(document.frmrecord.publishdate.value == "")
				{
					alert("Kindly select a date..");
					document.frmrecord.publishdate.focus();
					return false;
				}
				else if(document.frmrecord.title.value == "")
				{
					alert("Title should not be blank..");
					document.frmrecord.title.focus();
					return false;
				}	
				else if(document.frmrecord.img1.value == "")
				{
					alert("Kindly upload at least one image.");
					document.frmrecord.img1.focus();
					return false;
				}	
				else
				
				{
					return true;
				}
	}
    </script>
