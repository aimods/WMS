<?php

// pn_Barcode
// v_ID
// b_ID
// pn_ProductName

?>
<?php if ($main_PartNum->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $main_PartNum->TableCaption() ?></h4> -->
<table id="tbl_main_PartNummaster" class="table table-bordered table-striped ewViewTable">
<?php echo $main_PartNum->TableCustomInnerHtml ?>
	<tbody>
<?php if ($main_PartNum->pn_Barcode->Visible) { // pn_Barcode ?>
		<tr id="r_pn_Barcode">
			<td><?php echo $main_PartNum->pn_Barcode->FldCaption() ?></td>
			<td<?php echo $main_PartNum->pn_Barcode->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Barcode">
<span<?php echo $main_PartNum->pn_Barcode->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_Barcode->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_PartNum->v_ID->Visible) { // v_ID ?>
		<tr id="r_v_ID">
			<td><?php echo $main_PartNum->v_ID->FldCaption() ?></td>
			<td<?php echo $main_PartNum->v_ID->CellAttributes() ?>>
<span id="el_main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<?php echo $main_PartNum->v_ID->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_PartNum->b_ID->Visible) { // b_ID ?>
		<tr id="r_b_ID">
			<td><?php echo $main_PartNum->b_ID->FldCaption() ?></td>
			<td<?php echo $main_PartNum->b_ID->CellAttributes() ?>>
<span id="el_main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<?php echo $main_PartNum->b_ID->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($main_PartNum->pn_ProductName->Visible) { // pn_ProductName ?>
		<tr id="r_pn_ProductName">
			<td><?php echo $main_PartNum->pn_ProductName->FldCaption() ?></td>
			<td<?php echo $main_PartNum->pn_ProductName->CellAttributes() ?>>
<span id="el_main_PartNum_pn_ProductName">
<span<?php echo $main_PartNum->pn_ProductName->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_ProductName->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
