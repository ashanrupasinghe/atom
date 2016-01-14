<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ICA ATOM</title>

<meta name="viewport" content="width=device-width">

	<link href="<?php echo base_url(); ?>style.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/dropzone.css"
			type="text/css" rel="stylesheet" />
		<!--    <script src="--><?php ///*echo base_url(); */ ?>
		<!--assets/js/dropzone.min.js"></script>-->
		<!--    <script src="--><?php //echo base_url(); ?>
		<!--js/modernizr-2.5.3.min.js"></script>-->
		<!--    <script type="text/javascript" src="--><?php //echo base_url(); ?>
		<!--js/jquery-1.11.3.min.js"></script>-->

		<style type="text/css">
.error {
	color: red;
	font-weight: bold;
}
</style>

		<script type="text/javascript">
    </script>


<script type="text/javascript"
	src="<?php echo base_url(); ?>assets/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript"
	src="<?php echo base_url(); ?>assets/js/common.js"></script>
<script type="text/javascript"
	src="<?php echo base_url(); ?>assets/js/formjs.js"></script>

</head>
<body>
	<div class="container">
		<div class="page-header">
			<!--			    <h1>Application Processing Fee for Students with Foreign Qualifications</h1>			  -->
			<!--<div class="alert alert-info"><p>Now updated to remove or add error or success classes when user changes a field. (<a href="http://alittlecode.com/jquery-form-validation-with-styles-from-twitter-bootstrap/#comment-461">Thanks Giedrius</a>!)</p></div>-->
		</div>
		<div class="row">
			<div id="sidebar" class="offset1 span3">
				<div class="well">
					<h2></h2>
					<ul class="nav nav-list">
						<li><a href="<?php echo site_url(); ?>"><h3>Home</h3></a></li>
						<li><a href="<?php echo site_url(); ?>/atom/get_voters_registry"><h3>Voters
									Registry</h3></a></li>
						<li><a href="<?php echo site_url(); ?>/atomVoteController/index"><h3>Voters
									Registry 2</h3></a></li>
					</ul>

				</div>
				<!-- .well -->

			</div>
			<!-- .span -->

			<div id="maincontent" class="span8">

				<div class="tabbable">

					<div class="tab-content">
						<div id="demo" class="tab-pane active">
							<!--<div class="alert alert-success">
                            <h4>NOTES</h4>
                            <ul>
                                <li>To receive feedback, fill in a field and tab to the next. To get negative feedback, only enter one character.</li>
                                <li>For explanations, see the tabs above for the code, and of course <a href="http://docs.jquery.com/Plugins/Validation/"><strong>check out the plugin documentation</strong></a>.</li>
                            </ul>
                        </div> notes .alert -->
							<div class="well">
                            <?php
																												// if($list->num_rows > 0){
																												?>
                            <form
									action="<?php echo site_url('atom_voters/go_inside_voters_dir'); ?>"
									id="contact-form" class="form-horizontal" method="post">
									<fieldset>
										<legend>ICA ATOM [Voters Registers]</legend>

										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Collection</label>

											<div class="controls">

												<select name="collection"
													onchange="selectCollection(this.options[this.selectedIndex].value)">
													<option value="-1">Select Collection</option>
                                                <?php
																																																foreach ( $list->result () as $listElement ) {
																																																	?>
                                                    <option
														value="<?php echo $listElement->id ?>"><?php echo $listElement->title ?></option>
                                                    <?php
																																																}
																																																?>
                                            </select>
											</div>
										</div>
										<!--disabled=""-->
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Series</label>

											<div class="controls">
												<select name="series" id="Series_dropdown"
													onchange="selectSeries(this.options[this.selectedIndex].value)">
													<option value="-1">Select Series</option>
												</select>

											</div>
										</div>
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">District</label>

											<div class="controls">
												<select name="district" id="District_dropdown"
													onchange="selectDistrict(this.options[this.selectedIndex].value)">
													<option value="-1">Select District</option>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Year</label>

											<div class="controls">
												<select name="year" id="Year_dropdown"
													onchange="selectYear(this.options[this.selectedIndex].value)">
													<option value="-1">Select Year</option>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Polling
												Division</label>

											<div class="controls">
												<select name="polldivision" id="Division_dropdown"
													onchange="selectDivision(this.options[this.selectedIndex].value);getdivisionid(this.options[this.selectedIndex].value);">
													<!-- getdivisionid(this.options[this.selectedIndex].value); -->
													<option value="-1">Select Polling Division</option>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Polling
												District</label>

											<div class="controls">
												<select name="polldistrict" id="Polling_District_dropdown"
													onchange="">
													<option value="-1">Select Polling District</option>

												</select>
												<button type="button" class="btn-primary btn"
													id="btn-add-new-poling-district"
													name="btn-add-new-poling-district" onclick="showtogle();">Add
													New</button>
											</div>
										</div>



										<div class="control-group" id="show-hide-div-1"
											name="show-hide-div-1" style="display: none;">
											<label class="control-label col-sm-2" for="newdistrict">Add
												Polling District</label>

											<div class="controls">
												<input type="text" id="newdistrict" name="newdistrict">
													<button type="button" class="btn-primary btn" id="btn"
														name="btn"
														onclick="addField('newdistrict','show-hide-div-1','show-hide-message-1','Polling_District_dropdown');">Add</button>
													<div id="show-hide-message-1" style="display: none;"
													class="alert alert-success"><strong>&lt;&lt;&nbsp;success</strong></div>
											
											</div>
										</div>
										<div id="red" class="colors" style="display: none">....</div>

										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Location</label>

											<div class="controls">
												<input type="text" id="level7" name="level7">
											
											</div>
										</div>
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">Start House
												No</label>

											<div class="controls">
												<input type="text" id="level7_1" name="level7_1">
											
											</div>
										</div>
										<div class="control-group">
											<label class="control-label col-sm-2" for="name">End House No</label>

											<div class="controls">
												<input type="text" id="level7_2" name="level7_2">
											
											</div>
										</div>
										<div class="form-actions">
											<button type="submit" class="btn btn-primary btn-large"
												id="btn" name="btn">Submit</button>

											<button type="reset" name="reset" class="btn">Cancel</button>
										</div>
									</fieldset>
								</form>
                            <?php
																												// }else{
																												// echo 'No Series Name Found';
																												// }
																												?>
                        </div>
						</div>
					</div>

				</div>

			</div>

			<input type="text" class="input-xlarge" style="visibility: hidden"
				name="path" id="path" value="<?php echo site_url(); ?>">
				<hr>
		
		</div>



</body>

</html>
