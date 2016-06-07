<?php

// PROVINCE_ID
// PROVINCE_CODE
// PROVINCE_NAME
// PROVINCE_NAME_EN

?>
<?php if ($lov_province->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $lov_province->TableCaption() ?></h4> -->
<table id="tbl_lov_provincemaster" class="table table-bordered table-striped ewViewTable">
<?php echo $lov_province->TableCustomInnerHtml ?>
	<tbody>
<?php if ($lov_province->PROVINCE_ID->Visible) { // PROVINCE_ID ?>
		<tr id="r_PROVINCE_ID">
			<td><?php echo $lov_province->PROVINCE_ID->FldCaption() ?></td>
			<td<?php echo $lov_province->PROVINCE_ID->CellAttributes() ?>>
<span id="el_lov_province_PROVINCE_ID">
<span<?php echo $lov_province->PROVINCE_ID->ViewAttributes() ?>>
<?php echo $lov_province->PROVINCE_ID->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($lov_province->PROVINCE_CODE->Visible) { // PROVINCE_CODE ?>
		<tr id="r_PROVINCE_CODE">
			<td><?php echo $lov_province->PROVINCE_CODE->FldCaption() ?></td>
			<td<?php echo $lov_province->PROVINCE_CODE->CellAttributes() ?>>
<span id="el_lov_province_PROVINCE_CODE">
<span<?php echo $lov_province->PROVINCE_CODE->ViewAttributes() ?>>
<?php echo $lov_province->PROVINCE_CODE->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($lov_province->PROVINCE_NAME->Visible) { // PROVINCE_NAME ?>
		<tr id="r_PROVINCE_NAME">
			<td><?php echo $lov_province->PROVINCE_NAME->FldCaption() ?></td>
			<td<?php echo $lov_province->PROVINCE_NAME->CellAttributes() ?>>
<span id="el_lov_province_PROVINCE_NAME">
<span<?php echo $lov_province->PROVINCE_NAME->ViewAttributes() ?>>
<?php echo $lov_province->PROVINCE_NAME->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($lov_province->PROVINCE_NAME_EN->Visible) { // PROVINCE_NAME_EN ?>
		<tr id="r_PROVINCE_NAME_EN">
			<td><?php echo $lov_province->PROVINCE_NAME_EN->FldCaption() ?></td>
			<td<?php echo $lov_province->PROVINCE_NAME_EN->CellAttributes() ?>>
<span id="el_lov_province_PROVINCE_NAME_EN">
<span<?php echo $lov_province->PROVINCE_NAME_EN->ViewAttributes() ?>>
<?php echo $lov_province->PROVINCE_NAME_EN->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
