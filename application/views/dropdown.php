<?php
echo "<option value='-1'>Select Polling_District</option>";
foreach ( $list as $item ) :
	?>
<option value='<?php echo $item['id']?>'
	<?php if ($item['id']==$objectid):echo 'selected';endif;?>><?php echo $item['title'];?></option>
<?php
endforeach
;
