<?php include_once "main_user_info.php" ?>
<?php

// Create page object
if (!isset($transaction_Movement_grid)) $transaction_Movement_grid = new ctransaction_Movement_grid();

// Page init
$transaction_Movement_grid->Page_Init();

// Page main
$transaction_Movement_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$transaction_Movement_grid->Page_Render();
?>
<?php if ($transaction_Movement->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftransaction_Movementgrid = new ew_Form("ftransaction_Movementgrid", "grid");
ftransaction_Movementgrid.FormKeyCountName = '<?php echo $transaction_Movement_grid->FormKeyCountName ?>';

// Validate form
ftransaction_Movementgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_tr_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->tr_type->FldCaption(), $transaction_Movement->tr_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tran_Detail");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->tran_Detail->FldCaption(), $transaction_Movement->tran_Detail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tran_show");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->tran_show->FldCaption(), $transaction_Movement->tran_show->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftransaction_Movementgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "tr_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tran_Detail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "s_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tran_show", false)) return false;
	return true;
}

// Form_CustomValidate event
ftransaction_Movementgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftransaction_Movementgrid.ValidateRequired = true;
<?php } else { ?>
ftransaction_Movementgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftransaction_Movementgrid.Lists["x_u_ID"] = {"LinkField":"x_u_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_LoginName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementgrid.Lists["x_tr_type"] = {"LinkField":"x_tr_Type","Ajax":true,"AutoFill":false,"DisplayFields":["x_tr_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementgrid.Lists["x_s_ID"] = {"LinkField":"x_s_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_s_LOC","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementgrid.Lists["x_tran_show"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementgrid.Lists["x_tran_show"].Options = <?php echo json_encode($transaction_Movement->tran_show->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($transaction_Movement->CurrentAction == "gridadd") {
	if ($transaction_Movement->CurrentMode == "copy") {
		$bSelectLimit = $transaction_Movement_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$transaction_Movement_grid->TotalRecs = $transaction_Movement->SelectRecordCount();
			$transaction_Movement_grid->Recordset = $transaction_Movement_grid->LoadRecordset($transaction_Movement_grid->StartRec-1, $transaction_Movement_grid->DisplayRecs);
		} else {
			if ($transaction_Movement_grid->Recordset = $transaction_Movement_grid->LoadRecordset())
				$transaction_Movement_grid->TotalRecs = $transaction_Movement_grid->Recordset->RecordCount();
		}
		$transaction_Movement_grid->StartRec = 1;
		$transaction_Movement_grid->DisplayRecs = $transaction_Movement_grid->TotalRecs;
	} else {
		$transaction_Movement->CurrentFilter = "0=1";
		$transaction_Movement_grid->StartRec = 1;
		$transaction_Movement_grid->DisplayRecs = $transaction_Movement->GridAddRowCount;
	}
	$transaction_Movement_grid->TotalRecs = $transaction_Movement_grid->DisplayRecs;
	$transaction_Movement_grid->StopRec = $transaction_Movement_grid->DisplayRecs;
} else {
	$bSelectLimit = $transaction_Movement_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($transaction_Movement_grid->TotalRecs <= 0)
			$transaction_Movement_grid->TotalRecs = $transaction_Movement->SelectRecordCount();
	} else {
		if (!$transaction_Movement_grid->Recordset && ($transaction_Movement_grid->Recordset = $transaction_Movement_grid->LoadRecordset()))
			$transaction_Movement_grid->TotalRecs = $transaction_Movement_grid->Recordset->RecordCount();
	}
	$transaction_Movement_grid->StartRec = 1;
	$transaction_Movement_grid->DisplayRecs = $transaction_Movement_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$transaction_Movement_grid->Recordset = $transaction_Movement_grid->LoadRecordset($transaction_Movement_grid->StartRec-1, $transaction_Movement_grid->DisplayRecs);

	// Set no record found message
	if ($transaction_Movement->CurrentAction == "" && $transaction_Movement_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$transaction_Movement_grid->setWarningMessage(ew_DeniedMsg());
		if ($transaction_Movement_grid->SearchWhere == "0=101")
			$transaction_Movement_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$transaction_Movement_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$transaction_Movement_grid->RenderOtherOptions();
?>
<?php $transaction_Movement_grid->ShowPageHeader(); ?>
<?php
$transaction_Movement_grid->ShowMessage();
?>
<?php if ($transaction_Movement_grid->TotalRecs > 0 || $transaction_Movement->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="ftransaction_Movementgrid" class="ewForm form-inline">
<?php if ($transaction_Movement_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($transaction_Movement_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_transaction_Movement" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_transaction_Movementgrid" class="table ewTable">
<?php echo $transaction_Movement->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$transaction_Movement_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$transaction_Movement_grid->RenderListOptions();

// Render list options (header, left)
$transaction_Movement_grid->ListOptions->Render("header", "left");
?>
<?php if ($transaction_Movement->tran_Created->Visible) { // tran_Created ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_Created) == "") { ?>
		<th data-name="tran_Created"><div id="elh_transaction_Movement_tran_Created" class="transaction_Movement_tran_Created"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Created->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_Created"><div><div id="elh_transaction_Movement_tran_Created" class="transaction_Movement_tran_Created">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Created->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_Created->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_Created->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->u_ID->Visible) { // u_ID ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->u_ID) == "") { ?>
		<th data-name="u_ID"><div id="elh_transaction_Movement_u_ID" class="transaction_Movement_u_ID"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->u_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="u_ID"><div><div id="elh_transaction_Movement_u_ID" class="transaction_Movement_u_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->u_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->u_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->u_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tr_type->Visible) { // tr_type ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tr_type) == "") { ?>
		<th data-name="tr_type"><div id="elh_transaction_Movement_tr_type" class="transaction_Movement_tr_type"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tr_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tr_type"><div><div id="elh_transaction_Movement_tr_type" class="transaction_Movement_tr_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tr_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tr_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tr_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tran_Detail->Visible) { // tran_Detail ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_Detail) == "") { ?>
		<th data-name="tran_Detail"><div id="elh_transaction_Movement_tran_Detail" class="transaction_Movement_tran_Detail"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Detail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_Detail"><div><div id="elh_transaction_Movement_tran_Detail" class="transaction_Movement_tran_Detail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Detail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_Detail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_Detail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->s_ID->Visible) { // s_ID ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->s_ID) == "") { ?>
		<th data-name="s_ID"><div id="elh_transaction_Movement_s_ID" class="transaction_Movement_s_ID"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->s_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="s_ID"><div><div id="elh_transaction_Movement_s_ID" class="transaction_Movement_s_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->s_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->s_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->s_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tran_ID->Visible) { // tran_ID ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_ID) == "") { ?>
		<th data-name="tran_ID"><div id="elh_transaction_Movement_tran_ID" class="transaction_Movement_tran_ID"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_ID"><div><div id="elh_transaction_Movement_tran_ID" class="transaction_Movement_tran_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tran_show->Visible) { // tran_show ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_show) == "") { ?>
		<th data-name="tran_show"><div id="elh_transaction_Movement_tran_show" class="transaction_Movement_tran_show"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_show->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_show"><div><div id="elh_transaction_Movement_tran_show" class="transaction_Movement_tran_show">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_show->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_show->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_show->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$transaction_Movement_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$transaction_Movement_grid->StartRec = 1;
$transaction_Movement_grid->StopRec = $transaction_Movement_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($transaction_Movement_grid->FormKeyCountName) && ($transaction_Movement->CurrentAction == "gridadd" || $transaction_Movement->CurrentAction == "gridedit" || $transaction_Movement->CurrentAction == "F")) {
		$transaction_Movement_grid->KeyCount = $objForm->GetValue($transaction_Movement_grid->FormKeyCountName);
		$transaction_Movement_grid->StopRec = $transaction_Movement_grid->StartRec + $transaction_Movement_grid->KeyCount - 1;
	}
}
$transaction_Movement_grid->RecCnt = $transaction_Movement_grid->StartRec - 1;
if ($transaction_Movement_grid->Recordset && !$transaction_Movement_grid->Recordset->EOF) {
	$transaction_Movement_grid->Recordset->MoveFirst();
	$bSelectLimit = $transaction_Movement_grid->UseSelectLimit;
	if (!$bSelectLimit && $transaction_Movement_grid->StartRec > 1)
		$transaction_Movement_grid->Recordset->Move($transaction_Movement_grid->StartRec - 1);
} elseif (!$transaction_Movement->AllowAddDeleteRow && $transaction_Movement_grid->StopRec == 0) {
	$transaction_Movement_grid->StopRec = $transaction_Movement->GridAddRowCount;
}

// Initialize aggregate
$transaction_Movement->RowType = EW_ROWTYPE_AGGREGATEINIT;
$transaction_Movement->ResetAttrs();
$transaction_Movement_grid->RenderRow();
if ($transaction_Movement->CurrentAction == "gridadd")
	$transaction_Movement_grid->RowIndex = 0;
if ($transaction_Movement->CurrentAction == "gridedit")
	$transaction_Movement_grid->RowIndex = 0;
while ($transaction_Movement_grid->RecCnt < $transaction_Movement_grid->StopRec) {
	$transaction_Movement_grid->RecCnt++;
	if (intval($transaction_Movement_grid->RecCnt) >= intval($transaction_Movement_grid->StartRec)) {
		$transaction_Movement_grid->RowCnt++;
		if ($transaction_Movement->CurrentAction == "gridadd" || $transaction_Movement->CurrentAction == "gridedit" || $transaction_Movement->CurrentAction == "F") {
			$transaction_Movement_grid->RowIndex++;
			$objForm->Index = $transaction_Movement_grid->RowIndex;
			if ($objForm->HasValue($transaction_Movement_grid->FormActionName))
				$transaction_Movement_grid->RowAction = strval($objForm->GetValue($transaction_Movement_grid->FormActionName));
			elseif ($transaction_Movement->CurrentAction == "gridadd")
				$transaction_Movement_grid->RowAction = "insert";
			else
				$transaction_Movement_grid->RowAction = "";
		}

		// Set up key count
		$transaction_Movement_grid->KeyCount = $transaction_Movement_grid->RowIndex;

		// Init row class and style
		$transaction_Movement->ResetAttrs();
		$transaction_Movement->CssClass = "";
		if ($transaction_Movement->CurrentAction == "gridadd") {
			if ($transaction_Movement->CurrentMode == "copy") {
				$transaction_Movement_grid->LoadRowValues($transaction_Movement_grid->Recordset); // Load row values
				$transaction_Movement_grid->SetRecordKey($transaction_Movement_grid->RowOldKey, $transaction_Movement_grid->Recordset); // Set old record key
			} else {
				$transaction_Movement_grid->LoadDefaultValues(); // Load default values
				$transaction_Movement_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$transaction_Movement_grid->LoadRowValues($transaction_Movement_grid->Recordset); // Load row values
		}
		$transaction_Movement->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($transaction_Movement->CurrentAction == "gridadd") // Grid add
			$transaction_Movement->RowType = EW_ROWTYPE_ADD; // Render add
		if ($transaction_Movement->CurrentAction == "gridadd" && $transaction_Movement->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$transaction_Movement_grid->RestoreCurrentRowFormValues($transaction_Movement_grid->RowIndex); // Restore form values
		if ($transaction_Movement->CurrentAction == "gridedit") { // Grid edit
			if ($transaction_Movement->EventCancelled) {
				$transaction_Movement_grid->RestoreCurrentRowFormValues($transaction_Movement_grid->RowIndex); // Restore form values
			}
			if ($transaction_Movement_grid->RowAction == "insert")
				$transaction_Movement->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$transaction_Movement->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($transaction_Movement->CurrentAction == "gridedit" && ($transaction_Movement->RowType == EW_ROWTYPE_EDIT || $transaction_Movement->RowType == EW_ROWTYPE_ADD) && $transaction_Movement->EventCancelled) // Update failed
			$transaction_Movement_grid->RestoreCurrentRowFormValues($transaction_Movement_grid->RowIndex); // Restore form values
		if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) // Edit row
			$transaction_Movement_grid->EditRowCnt++;
		if ($transaction_Movement->CurrentAction == "F") // Confirm row
			$transaction_Movement_grid->RestoreCurrentRowFormValues($transaction_Movement_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$transaction_Movement->RowAttrs = array_merge($transaction_Movement->RowAttrs, array('data-rowindex'=>$transaction_Movement_grid->RowCnt, 'id'=>'r' . $transaction_Movement_grid->RowCnt . '_transaction_Movement', 'data-rowtype'=>$transaction_Movement->RowType));

		// Render row
		$transaction_Movement_grid->RenderRow();

		// Render list options
		$transaction_Movement_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($transaction_Movement_grid->RowAction <> "delete" && $transaction_Movement_grid->RowAction <> "insertdelete" && !($transaction_Movement_grid->RowAction == "insert" && $transaction_Movement->CurrentAction == "F" && $transaction_Movement_grid->EmptyRow())) {
?>
	<tr<?php echo $transaction_Movement->RowAttributes() ?>>
<?php

// Render list options (body, left)
$transaction_Movement_grid->ListOptions->Render("body", "left", $transaction_Movement_grid->RowCnt);
?>
	<?php if ($transaction_Movement->tran_Created->Visible) { // tran_Created ?>
		<td data-name="tran_Created"<?php echo $transaction_Movement->tran_Created->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Created" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Created->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_Created" class="transaction_Movement_tran_Created">
<span<?php echo $transaction_Movement->tran_Created->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_Created->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Created" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Created->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Created" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Created->OldValue) ?>">
<?php } ?>
<a id="<?php echo $transaction_Movement_grid->PageObjName . "_row_" . $transaction_Movement_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($transaction_Movement->u_ID->Visible) { // u_ID ?>
		<td data-name="u_ID"<?php echo $transaction_Movement->u_ID->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_u_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->u_ID->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_u_ID" class="transaction_Movement_u_ID">
<span<?php echo $transaction_Movement->u_ID->ViewAttributes() ?>>
<?php echo $transaction_Movement->u_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_u_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->u_ID->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_u_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->u_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tr_type->Visible) { // tr_type ?>
		<td data-name="tr_type"<?php echo $transaction_Movement->tr_type->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tr_type" class="form-group transaction_Movement_tr_type">
<select data-table="transaction_Movement" data-field="x_tr_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tr_type->DisplayValueSeparator) ? json_encode($transaction_Movement->tr_type->DisplayValueSeparator) : $transaction_Movement->tr_type->DisplayValueSeparator) ?>" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type"<?php echo $transaction_Movement->tr_type->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->tr_type->EditValue)) {
	$arwrk = $transaction_Movement->tr_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->tr_type->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->tr_type->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tr_type->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->CurrentValue) ?>" selected><?php echo $transaction_Movement->tr_type->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->tr_type->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_Transaction`";
$sWhereWrk = "";
$transaction_Movement->tr_type->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->tr_type->LookupFilters += array("f0" => "`tr_Type` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->tr_type, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $transaction_Movement->tr_type->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo $transaction_Movement->tr_type->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tr_type" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tr_type" class="form-group transaction_Movement_tr_type">
<select data-table="transaction_Movement" data-field="x_tr_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tr_type->DisplayValueSeparator) ? json_encode($transaction_Movement->tr_type->DisplayValueSeparator) : $transaction_Movement->tr_type->DisplayValueSeparator) ?>" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type"<?php echo $transaction_Movement->tr_type->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->tr_type->EditValue)) {
	$arwrk = $transaction_Movement->tr_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->tr_type->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->tr_type->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tr_type->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->CurrentValue) ?>" selected><?php echo $transaction_Movement->tr_type->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->tr_type->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_Transaction`";
$sWhereWrk = "";
$transaction_Movement->tr_type->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->tr_type->LookupFilters += array("f0" => "`tr_Type` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->tr_type, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $transaction_Movement->tr_type->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo $transaction_Movement->tr_type->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tr_type" class="transaction_Movement_tr_type">
<span<?php echo $transaction_Movement->tr_type->ViewAttributes() ?>>
<?php echo $transaction_Movement->tr_type->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tr_type" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_tr_type" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_Detail->Visible) { // tran_Detail ?>
		<td data-name="tran_Detail"<?php echo $transaction_Movement->tran_Detail->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_Detail" class="form-group transaction_Movement_tran_Detail">
<?php ew_AppendClass($transaction_Movement->tran_Detail->EditAttrs["class"], "editor"); ?>
<textarea data-table="transaction_Movement" data-field="x_tran_Detail" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->getPlaceHolder()) ?>"<?php echo $transaction_Movement->tran_Detail->EditAttributes() ?>><?php echo $transaction_Movement->tran_Detail->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftransaction_Movementgrid", "x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail", 0, 0, <?php echo ($transaction_Movement->tran_Detail->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Detail" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_Detail" class="form-group transaction_Movement_tran_Detail">
<?php ew_AppendClass($transaction_Movement->tran_Detail->EditAttrs["class"], "editor"); ?>
<textarea data-table="transaction_Movement" data-field="x_tran_Detail" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->getPlaceHolder()) ?>"<?php echo $transaction_Movement->tran_Detail->EditAttributes() ?>><?php echo $transaction_Movement->tran_Detail->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftransaction_Movementgrid", "x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail", 0, 0, <?php echo ($transaction_Movement->tran_Detail->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_Detail" class="transaction_Movement_tran_Detail">
<span<?php echo $transaction_Movement->tran_Detail->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_Detail->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Detail" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Detail" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->s_ID->Visible) { // s_ID ?>
		<td data-name="s_ID"<?php echo $transaction_Movement->s_ID->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_s_ID" class="form-group transaction_Movement_s_ID">
<select data-table="transaction_Movement" data-field="x_s_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->s_ID->DisplayValueSeparator) ? json_encode($transaction_Movement->s_ID->DisplayValueSeparator) : $transaction_Movement->s_ID->DisplayValueSeparator) ?>" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID"<?php echo $transaction_Movement->s_ID->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->s_ID->EditValue)) {
	$arwrk = $transaction_Movement->s_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->s_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->s_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->s_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->CurrentValue) ?>" selected><?php echo $transaction_Movement->s_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->s_ID->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Stock`";
$sWhereWrk = "";
$transaction_Movement->s_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->s_ID->LookupFilters += array("f0" => "`s_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->s_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `s_Province`";
if ($sSqlWrk <> "") $transaction_Movement->s_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo $transaction_Movement->s_ID->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_s_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_s_ID" class="form-group transaction_Movement_s_ID">
<select data-table="transaction_Movement" data-field="x_s_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->s_ID->DisplayValueSeparator) ? json_encode($transaction_Movement->s_ID->DisplayValueSeparator) : $transaction_Movement->s_ID->DisplayValueSeparator) ?>" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID"<?php echo $transaction_Movement->s_ID->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->s_ID->EditValue)) {
	$arwrk = $transaction_Movement->s_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->s_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->s_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->s_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->CurrentValue) ?>" selected><?php echo $transaction_Movement->s_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->s_ID->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Stock`";
$sWhereWrk = "";
$transaction_Movement->s_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->s_ID->LookupFilters += array("f0" => "`s_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->s_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `s_Province`";
if ($sSqlWrk <> "") $transaction_Movement->s_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo $transaction_Movement->s_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_s_ID" class="transaction_Movement_s_ID">
<span<?php echo $transaction_Movement->s_ID->ViewAttributes() ?>>
<?php echo $transaction_Movement->s_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_s_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_s_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_ID->Visible) { // tran_ID ?>
		<td data-name="tran_ID"<?php echo $transaction_Movement->tran_ID->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_ID->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_ID" class="form-group transaction_Movement_tran_ID">
<span<?php echo $transaction_Movement->tran_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->tran_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_ID" class="transaction_Movement_tran_ID">
<span<?php echo $transaction_Movement->tran_ID->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_ID->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_show->Visible) { // tran_show ?>
		<td data-name="tran_show"<?php echo $transaction_Movement->tran_show->CellAttributes() ?>>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_show" class="form-group transaction_Movement_tran_show">
<div id="tp_x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" class="ewTemplate"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tran_show->DisplayValueSeparator) ? json_encode($transaction_Movement->tran_show->DisplayValueSeparator) : $transaction_Movement->tran_show->DisplayValueSeparator) ?>" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="{value}"<?php echo $transaction_Movement->tran_show->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $transaction_Movement->tran_show->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($transaction_Movement->tran_show->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tran_show->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->CurrentValue) ?>" checked<?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->tran_show->OldValue = "";
?>
</div></div>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_show" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->OldValue) ?>">
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_show" class="form-group transaction_Movement_tran_show">
<div id="tp_x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" class="ewTemplate"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tran_show->DisplayValueSeparator) ? json_encode($transaction_Movement->tran_show->DisplayValueSeparator) : $transaction_Movement->tran_show->DisplayValueSeparator) ?>" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="{value}"<?php echo $transaction_Movement->tran_show->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $transaction_Movement->tran_show->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($transaction_Movement->tran_show->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tran_show->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->CurrentValue) ?>" checked<?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->tran_show->OldValue = "";
?>
</div></div>
</span>
<?php } ?>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transaction_Movement_grid->RowCnt ?>_transaction_Movement_tran_show" class="transaction_Movement_tran_show">
<span<?php echo $transaction_Movement->tran_show->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_show->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->FormValue) ?>">
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_show" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$transaction_Movement_grid->ListOptions->Render("body", "right", $transaction_Movement_grid->RowCnt);
?>
	</tr>
<?php if ($transaction_Movement->RowType == EW_ROWTYPE_ADD || $transaction_Movement->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftransaction_Movementgrid.UpdateOpts(<?php echo $transaction_Movement_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($transaction_Movement->CurrentAction <> "gridadd" || $transaction_Movement->CurrentMode == "copy")
		if (!$transaction_Movement_grid->Recordset->EOF) $transaction_Movement_grid->Recordset->MoveNext();
}
?>
<?php
	if ($transaction_Movement->CurrentMode == "add" || $transaction_Movement->CurrentMode == "copy" || $transaction_Movement->CurrentMode == "edit") {
		$transaction_Movement_grid->RowIndex = '$rowindex$';
		$transaction_Movement_grid->LoadDefaultValues();

		// Set row properties
		$transaction_Movement->ResetAttrs();
		$transaction_Movement->RowAttrs = array_merge($transaction_Movement->RowAttrs, array('data-rowindex'=>$transaction_Movement_grid->RowIndex, 'id'=>'r0_transaction_Movement', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($transaction_Movement->RowAttrs["class"], "ewTemplate");
		$transaction_Movement->RowType = EW_ROWTYPE_ADD;

		// Render row
		$transaction_Movement_grid->RenderRow();

		// Render list options
		$transaction_Movement_grid->RenderListOptions();
		$transaction_Movement_grid->StartRowCnt = 0;
?>
	<tr<?php echo $transaction_Movement->RowAttributes() ?>>
<?php

// Render list options (body, left)
$transaction_Movement_grid->ListOptions->Render("body", "left", $transaction_Movement_grid->RowIndex);
?>
	<?php if ($transaction_Movement->tran_Created->Visible) { // tran_Created ?>
		<td data-name="tran_Created">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<?php } else { ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Created" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Created->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Created" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Created" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Created->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transaction_Movement->u_ID->Visible) { // u_ID ?>
		<td data-name="u_ID">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_transaction_Movement_u_ID" class="form-group transaction_Movement_u_ID">
<span<?php echo $transaction_Movement->u_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->u_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_u_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->u_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_u_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_u_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->u_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tr_type->Visible) { // tr_type ?>
		<td data-name="tr_type">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transaction_Movement_tr_type" class="form-group transaction_Movement_tr_type">
<select data-table="transaction_Movement" data-field="x_tr_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tr_type->DisplayValueSeparator) ? json_encode($transaction_Movement->tr_type->DisplayValueSeparator) : $transaction_Movement->tr_type->DisplayValueSeparator) ?>" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type"<?php echo $transaction_Movement->tr_type->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->tr_type->EditValue)) {
	$arwrk = $transaction_Movement->tr_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->tr_type->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->tr_type->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tr_type->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->CurrentValue) ?>" selected><?php echo $transaction_Movement->tr_type->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->tr_type->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_Transaction`";
$sWhereWrk = "";
$transaction_Movement->tr_type->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->tr_type->LookupFilters += array("f0" => "`tr_Type` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->tr_type, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $transaction_Movement->tr_type->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo $transaction_Movement->tr_type->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_transaction_Movement_tr_type" class="form-group transaction_Movement_tr_type">
<span<?php echo $transaction_Movement->tr_type->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->tr_type->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tr_type" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tr_type" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tr_type" value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_Detail->Visible) { // tran_Detail ?>
		<td data-name="tran_Detail">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transaction_Movement_tran_Detail" class="form-group transaction_Movement_tran_Detail">
<?php ew_AppendClass($transaction_Movement->tran_Detail->EditAttrs["class"], "editor"); ?>
<textarea data-table="transaction_Movement" data-field="x_tran_Detail" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->getPlaceHolder()) ?>"<?php echo $transaction_Movement->tran_Detail->EditAttributes() ?>><?php echo $transaction_Movement->tran_Detail->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftransaction_Movementgrid", "x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail", 0, 0, <?php echo ($transaction_Movement->tran_Detail->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_transaction_Movement_tran_Detail" class="form-group transaction_Movement_tran_Detail">
<span<?php echo $transaction_Movement->tran_Detail->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->tran_Detail->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Detail" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_Detail" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_Detail" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transaction_Movement->s_ID->Visible) { // s_ID ?>
		<td data-name="s_ID">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transaction_Movement_s_ID" class="form-group transaction_Movement_s_ID">
<select data-table="transaction_Movement" data-field="x_s_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->s_ID->DisplayValueSeparator) ? json_encode($transaction_Movement->s_ID->DisplayValueSeparator) : $transaction_Movement->s_ID->DisplayValueSeparator) ?>" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID"<?php echo $transaction_Movement->s_ID->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->s_ID->EditValue)) {
	$arwrk = $transaction_Movement->s_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->s_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->s_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->s_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->CurrentValue) ?>" selected><?php echo $transaction_Movement->s_ID->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->s_ID->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Stock`";
$sWhereWrk = "";
$transaction_Movement->s_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->s_ID->LookupFilters += array("f0" => "`s_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->s_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `s_Province`";
if ($sSqlWrk <> "") $transaction_Movement->s_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="s_x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo $transaction_Movement->s_ID->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_transaction_Movement_s_ID" class="form-group transaction_Movement_s_ID">
<span<?php echo $transaction_Movement->s_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->s_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_s_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_s_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_s_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_ID->Visible) { // tran_ID ?>
		<td data-name="tran_ID">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_transaction_Movement_tran_ID" class="form-group transaction_Movement_tran_ID">
<span<?php echo $transaction_Movement->tran_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->tran_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_ID" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_ID" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_show->Visible) { // tran_show ?>
		<td data-name="tran_show">
<?php if ($transaction_Movement->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transaction_Movement_tran_show" class="form-group transaction_Movement_tran_show">
<div id="tp_x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" class="ewTemplate"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tran_show->DisplayValueSeparator) ? json_encode($transaction_Movement->tran_show->DisplayValueSeparator) : $transaction_Movement->tran_show->DisplayValueSeparator) ?>" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="{value}"<?php echo $transaction_Movement->tran_show->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $transaction_Movement->tran_show->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($transaction_Movement->tran_show->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tran_show->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->CurrentValue) ?>" checked<?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $transaction_Movement->tran_show->OldValue = "";
?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_transaction_Movement_tran_show" class="form-group transaction_Movement_tran_show">
<span<?php echo $transaction_Movement->tran_show->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->tran_show->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_show" name="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="x<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transaction_Movement" data-field="x_tran_show" name="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" id="o<?php echo $transaction_Movement_grid->RowIndex ?>_tran_show" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$transaction_Movement_grid->ListOptions->Render("body", "right", $transaction_Movement_grid->RowCnt);
?>
<script type="text/javascript">
ftransaction_Movementgrid.UpdateOpts(<?php echo $transaction_Movement_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($transaction_Movement->CurrentMode == "add" || $transaction_Movement->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $transaction_Movement_grid->FormKeyCountName ?>" id="<?php echo $transaction_Movement_grid->FormKeyCountName ?>" value="<?php echo $transaction_Movement_grid->KeyCount ?>">
<?php echo $transaction_Movement_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($transaction_Movement->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $transaction_Movement_grid->FormKeyCountName ?>" id="<?php echo $transaction_Movement_grid->FormKeyCountName ?>" value="<?php echo $transaction_Movement_grid->KeyCount ?>">
<?php echo $transaction_Movement_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($transaction_Movement->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftransaction_Movementgrid">
</div>
<?php

// Close recordset
if ($transaction_Movement_grid->Recordset)
	$transaction_Movement_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($transaction_Movement_grid->TotalRecs == 0 && $transaction_Movement->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($transaction_Movement_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($transaction_Movement->Export == "") { ?>
<script type="text/javascript">
ftransaction_Movementgrid.Init();
</script>
<?php } ?>
<?php
$transaction_Movement_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$transaction_Movement_grid->Page_Terminate();
?>
