<?php

// pr_Barcode
// pr_Activated
// pr_Status
// pr_PO
// pr_Cost
// pr_intStatus

?>
<?php if ($main_Product->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $main_Product->TableCaption() ?></h4> -->
<table id="tbl_main_Productmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $main_Product->TableCustomInnerHtml ?>
	<tbody>
<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
		<tr id="r_pr_Barcode">
			<td><?php echo $main_Product->pr_Barcode->FldCaption() ?></td>
			<td<?php echo $main_Product->pr_Barcode->CellAttributes() ?>>
<span id="el_main_Product_pr_Barcode">
<span<?php echo $main_Product->pr_Barcode->ViewAttributes() ?>>
<?php echo $main_Product->pr_Barcode->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
		<tr id="r_pr_Activated">
			<td><?php echo $main_Product->pr_Activated->FldCaption() ?></td>
			<td<?php echo $main_Product->pr_Activated->CellAttributes() ?>>
<span id="el_main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<?php echo $main_Product->pr_Activated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
		<tr id="r_pr_Status">
			<td><?php echo $main_Product->pr_Status->FldCaption() ?></td>
			<td<?php echo $main_Product->pr_Status->CellAttributes() ?>>
<span id="el_main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<?php echo $main_Product->pr_Status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
		<tr id="r_pr_PO">
			<td><?php echo $main_Product->pr_PO->FldCaption() ?></td>
			<td<?php echo $main_Product->pr_PO->CellAttributes() ?>>
<span id="el_main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<?php echo $main_Product->pr_PO->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
		<tr id="r_pr_Cost">
			<td><?php echo $main_Product->pr_Cost->FldCaption() ?></td>
			<td<?php echo $main_Product->pr_Cost->CellAttributes() ?>>
<span id="el_main_Product_pr_Cost">
<span<?php echo $main_Product->pr_Cost->ViewAttributes() ?>>
<?php echo $main_Product->pr_Cost->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
		<tr id="r_pr_intStatus">
			<td><?php echo $main_Product->pr_intStatus->FldCaption() ?></td>
			<td<?php echo $main_Product->pr_intStatus->CellAttributes() ?>>
<span id="el_main_Product_pr_intStatus">
<span<?php echo $main_Product->pr_intStatus->ViewAttributes() ?>>
<?php echo $main_Product->pr_intStatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
