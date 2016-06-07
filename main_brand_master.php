<?php

// logo
// b_Name

?>
<?php if ($main_Brand->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $main_Brand->TableCaption() ?></h4> -->
<table id="tbl_main_Brandmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $main_Brand->TableCustomInnerHtml ?>
	<tbody>
<?php if ($main_Brand->logo->Visible) { // logo ?>
		<tr id="r_logo">
			<td><?php echo $main_Brand->logo->FldCaption() ?></td>
			<td<?php echo $main_Brand->logo->CellAttributes() ?>>
<span id="el_main_Brand_logo">
<span>
<?php echo ew_GetFileViewTag($main_Brand->logo, $main_Brand->logo->ListViewValue()) ?><div id="tt_main_Brand_x_logo" style="display: none">
<?php echo $main_Brand->logo->TooltipValue ?>
</div>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Brand->b_Name->Visible) { // b_Name ?>
		<tr id="r_b_Name">
			<td><?php echo $main_Brand->b_Name->FldCaption() ?></td>
			<td<?php echo $main_Brand->b_Name->CellAttributes() ?>>
<span id="el_main_Brand_b_Name">
<span<?php echo $main_Brand->b_Name->ViewAttributes() ?>>
<?php echo $main_Brand->b_Name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
