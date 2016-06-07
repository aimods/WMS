<?php

// v_Name
// v_TAX
// v_Country
// v_Contact

?>
<?php if ($main_Vendor->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $main_Vendor->TableCaption() ?></h4> -->
<table id="tbl_main_Vendormaster" class="table table-bordered table-striped ewViewTable">
<?php echo $main_Vendor->TableCustomInnerHtml ?>
	<tbody>
<?php if ($main_Vendor->v_Name->Visible) { // v_Name ?>
		<tr id="r_v_Name">
			<td><?php echo $main_Vendor->v_Name->FldCaption() ?></td>
			<td<?php echo $main_Vendor->v_Name->CellAttributes() ?>>
<span id="el_main_Vendor_v_Name">
<span<?php echo $main_Vendor->v_Name->ViewAttributes() ?>>
<?php echo $main_Vendor->v_Name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Vendor->v_TAX->Visible) { // v_TAX ?>
		<tr id="r_v_TAX">
			<td><?php echo $main_Vendor->v_TAX->FldCaption() ?></td>
			<td<?php echo $main_Vendor->v_TAX->CellAttributes() ?>>
<span id="el_main_Vendor_v_TAX">
<span<?php echo $main_Vendor->v_TAX->ViewAttributes() ?>>
<?php echo $main_Vendor->v_TAX->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Vendor->v_Country->Visible) { // v_Country ?>
		<tr id="r_v_Country">
			<td><?php echo $main_Vendor->v_Country->FldCaption() ?></td>
			<td<?php echo $main_Vendor->v_Country->CellAttributes() ?>>
<span id="el_main_Vendor_v_Country">
<span<?php echo $main_Vendor->v_Country->ViewAttributes() ?>>
<?php echo $main_Vendor->v_Country->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Vendor->v_Contact->Visible) { // v_Contact ?>
		<tr id="r_v_Contact">
			<td><?php echo $main_Vendor->v_Contact->FldCaption() ?></td>
			<td<?php echo $main_Vendor->v_Contact->CellAttributes() ?>>
<span id="el_main_Vendor_v_Contact">
<span<?php echo $main_Vendor->v_Contact->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($main_Vendor->v_Contact->ListViewValue())) && $main_Vendor->v_Contact->LinkAttributes() <> "") { ?>
<a<?php echo $main_Vendor->v_Contact->LinkAttributes() ?>><?php echo $main_Vendor->v_Contact->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $main_Vendor->v_Contact->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
