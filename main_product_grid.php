<?php include_once "main_user_info.php" ?>
<?php

// Create page object
if (!isset($main_Product_grid)) $main_Product_grid = new cmain_Product_grid();

// Page init
$main_Product_grid->Page_Init();

// Page main
$main_Product_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_Product_grid->Page_Render();
?>
<?php if ($main_Product->Export == "") { ?>
<script type="text/javascript">

// Form object
var fmain_Productgrid = new ew_Form("fmain_Productgrid", "grid");
fmain_Productgrid.FormKeyCountName = '<?php echo $main_Product_grid->FormKeyCountName ?>';

// Validate form
fmain_Productgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pr_Barcode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Barcode->FldCaption(), $main_Product->pr_Barcode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Activated");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Activated->FldCaption(), $main_Product->pr_Activated->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Status->FldCaption(), $main_Product->pr_Status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_PO");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_PO->FldCaption(), $main_Product->pr_PO->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Cost");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Cost->FldCaption(), $main_Product->pr_Cost->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Cost");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($main_Product->pr_Cost->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pr_intStatus");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_intStatus->FldCaption(), $main_Product->pr_intStatus->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fmain_Productgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "pr_Barcode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_Activated", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_Status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_PO", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_Cost", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_intStatus", false)) return false;
	return true;
}

// Form_CustomValidate event
fmain_Productgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Productgrid.ValidateRequired = true;
<?php } else { ?>
fmain_Productgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Productgrid.Lists["x_pr_Status"] = {"LinkField":"x_ps_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_ps_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Productgrid.Lists["x_pr_intStatus"] = {"LinkField":"x_in_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_in_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($main_Product->CurrentAction == "gridadd") {
	if ($main_Product->CurrentMode == "copy") {
		$bSelectLimit = $main_Product_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$main_Product_grid->TotalRecs = $main_Product->SelectRecordCount();
			$main_Product_grid->Recordset = $main_Product_grid->LoadRecordset($main_Product_grid->StartRec-1, $main_Product_grid->DisplayRecs);
		} else {
			if ($main_Product_grid->Recordset = $main_Product_grid->LoadRecordset())
				$main_Product_grid->TotalRecs = $main_Product_grid->Recordset->RecordCount();
		}
		$main_Product_grid->StartRec = 1;
		$main_Product_grid->DisplayRecs = $main_Product_grid->TotalRecs;
	} else {
		$main_Product->CurrentFilter = "0=1";
		$main_Product_grid->StartRec = 1;
		$main_Product_grid->DisplayRecs = $main_Product->GridAddRowCount;
	}
	$main_Product_grid->TotalRecs = $main_Product_grid->DisplayRecs;
	$main_Product_grid->StopRec = $main_Product_grid->DisplayRecs;
} else {
	$bSelectLimit = $main_Product_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($main_Product_grid->TotalRecs <= 0)
			$main_Product_grid->TotalRecs = $main_Product->SelectRecordCount();
	} else {
		if (!$main_Product_grid->Recordset && ($main_Product_grid->Recordset = $main_Product_grid->LoadRecordset()))
			$main_Product_grid->TotalRecs = $main_Product_grid->Recordset->RecordCount();
	}
	$main_Product_grid->StartRec = 1;
	$main_Product_grid->DisplayRecs = $main_Product_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$main_Product_grid->Recordset = $main_Product_grid->LoadRecordset($main_Product_grid->StartRec-1, $main_Product_grid->DisplayRecs);

	// Set no record found message
	if ($main_Product->CurrentAction == "" && $main_Product_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$main_Product_grid->setWarningMessage(ew_DeniedMsg());
		if ($main_Product_grid->SearchWhere == "0=101")
			$main_Product_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$main_Product_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$main_Product_grid->RenderOtherOptions();
?>
<?php $main_Product_grid->ShowPageHeader(); ?>
<?php
$main_Product_grid->ShowMessage();
?>
<?php if ($main_Product_grid->TotalRecs > 0 || $main_Product->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fmain_Productgrid" class="ewForm form-inline">
<?php if ($main_Product_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($main_Product_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_main_Product" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_main_Productgrid" class="table ewTable">
<?php echo $main_Product->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$main_Product_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$main_Product_grid->RenderListOptions();

// Render list options (header, left)
$main_Product_grid->ListOptions->Render("header", "left");
?>
<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Barcode) == "") { ?>
		<th data-name="pr_Barcode"><div id="elh_main_Product_pr_Barcode" class="main_Product_pr_Barcode"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Barcode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Barcode"><div><div id="elh_main_Product_pr_Barcode" class="main_Product_pr_Barcode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Barcode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Barcode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Barcode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Activated) == "") { ?>
		<th data-name="pr_Activated"><div id="elh_main_Product_pr_Activated" class="main_Product_pr_Activated"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Activated->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Activated"><div><div id="elh_main_Product_pr_Activated" class="main_Product_pr_Activated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Activated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Activated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Activated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Status) == "") { ?>
		<th data-name="pr_Status"><div id="elh_main_Product_pr_Status" class="main_Product_pr_Status"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Status"><div><div id="elh_main_Product_pr_Status" class="main_Product_pr_Status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_PO) == "") { ?>
		<th data-name="pr_PO"><div id="elh_main_Product_pr_PO" class="main_Product_pr_PO"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_PO->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_PO"><div><div id="elh_main_Product_pr_PO" class="main_Product_pr_PO">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_PO->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_PO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_PO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Cost) == "") { ?>
		<th data-name="pr_Cost"><div id="elh_main_Product_pr_Cost" class="main_Product_pr_Cost"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Cost->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Cost"><div><div id="elh_main_Product_pr_Cost" class="main_Product_pr_Cost">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Cost->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Cost->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Cost->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_intStatus) == "") { ?>
		<th data-name="pr_intStatus"><div id="elh_main_Product_pr_intStatus" class="main_Product_pr_intStatus"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_intStatus->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_intStatus"><div><div id="elh_main_Product_pr_intStatus" class="main_Product_pr_intStatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_intStatus->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_intStatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_intStatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$main_Product_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$main_Product_grid->StartRec = 1;
$main_Product_grid->StopRec = $main_Product_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($main_Product_grid->FormKeyCountName) && ($main_Product->CurrentAction == "gridadd" || $main_Product->CurrentAction == "gridedit" || $main_Product->CurrentAction == "F")) {
		$main_Product_grid->KeyCount = $objForm->GetValue($main_Product_grid->FormKeyCountName);
		$main_Product_grid->StopRec = $main_Product_grid->StartRec + $main_Product_grid->KeyCount - 1;
	}
}
$main_Product_grid->RecCnt = $main_Product_grid->StartRec - 1;
if ($main_Product_grid->Recordset && !$main_Product_grid->Recordset->EOF) {
	$main_Product_grid->Recordset->MoveFirst();
	$bSelectLimit = $main_Product_grid->UseSelectLimit;
	if (!$bSelectLimit && $main_Product_grid->StartRec > 1)
		$main_Product_grid->Recordset->Move($main_Product_grid->StartRec - 1);
} elseif (!$main_Product->AllowAddDeleteRow && $main_Product_grid->StopRec == 0) {
	$main_Product_grid->StopRec = $main_Product->GridAddRowCount;
}

// Initialize aggregate
$main_Product->RowType = EW_ROWTYPE_AGGREGATEINIT;
$main_Product->ResetAttrs();
$main_Product_grid->RenderRow();
if ($main_Product->CurrentAction == "gridadd")
	$main_Product_grid->RowIndex = 0;
if ($main_Product->CurrentAction == "gridedit")
	$main_Product_grid->RowIndex = 0;
while ($main_Product_grid->RecCnt < $main_Product_grid->StopRec) {
	$main_Product_grid->RecCnt++;
	if (intval($main_Product_grid->RecCnt) >= intval($main_Product_grid->StartRec)) {
		$main_Product_grid->RowCnt++;
		if ($main_Product->CurrentAction == "gridadd" || $main_Product->CurrentAction == "gridedit" || $main_Product->CurrentAction == "F") {
			$main_Product_grid->RowIndex++;
			$objForm->Index = $main_Product_grid->RowIndex;
			if ($objForm->HasValue($main_Product_grid->FormActionName))
				$main_Product_grid->RowAction = strval($objForm->GetValue($main_Product_grid->FormActionName));
			elseif ($main_Product->CurrentAction == "gridadd")
				$main_Product_grid->RowAction = "insert";
			else
				$main_Product_grid->RowAction = "";
		}

		// Set up key count
		$main_Product_grid->KeyCount = $main_Product_grid->RowIndex;

		// Init row class and style
		$main_Product->ResetAttrs();
		$main_Product->CssClass = "";
		if ($main_Product->CurrentAction == "gridadd") {
			if ($main_Product->CurrentMode == "copy") {
				$main_Product_grid->LoadRowValues($main_Product_grid->Recordset); // Load row values
				$main_Product_grid->SetRecordKey($main_Product_grid->RowOldKey, $main_Product_grid->Recordset); // Set old record key
			} else {
				$main_Product_grid->LoadDefaultValues(); // Load default values
				$main_Product_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$main_Product_grid->LoadRowValues($main_Product_grid->Recordset); // Load row values
		}
		$main_Product->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($main_Product->CurrentAction == "gridadd") // Grid add
			$main_Product->RowType = EW_ROWTYPE_ADD; // Render add
		if ($main_Product->CurrentAction == "gridadd" && $main_Product->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$main_Product_grid->RestoreCurrentRowFormValues($main_Product_grid->RowIndex); // Restore form values
		if ($main_Product->CurrentAction == "gridedit") { // Grid edit
			if ($main_Product->EventCancelled) {
				$main_Product_grid->RestoreCurrentRowFormValues($main_Product_grid->RowIndex); // Restore form values
			}
			if ($main_Product_grid->RowAction == "insert")
				$main_Product->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$main_Product->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($main_Product->CurrentAction == "gridedit" && ($main_Product->RowType == EW_ROWTYPE_EDIT || $main_Product->RowType == EW_ROWTYPE_ADD) && $main_Product->EventCancelled) // Update failed
			$main_Product_grid->RestoreCurrentRowFormValues($main_Product_grid->RowIndex); // Restore form values
		if ($main_Product->RowType == EW_ROWTYPE_EDIT) // Edit row
			$main_Product_grid->EditRowCnt++;
		if ($main_Product->CurrentAction == "F") // Confirm row
			$main_Product_grid->RestoreCurrentRowFormValues($main_Product_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$main_Product->RowAttrs = array_merge($main_Product->RowAttrs, array('data-rowindex'=>$main_Product_grid->RowCnt, 'id'=>'r' . $main_Product_grid->RowCnt . '_main_Product', 'data-rowtype'=>$main_Product->RowType));

		// Render row
		$main_Product_grid->RenderRow();

		// Render list options
		$main_Product_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($main_Product_grid->RowAction <> "delete" && $main_Product_grid->RowAction <> "insertdelete" && !($main_Product_grid->RowAction == "insert" && $main_Product->CurrentAction == "F" && $main_Product_grid->EmptyRow())) {
?>
	<tr<?php echo $main_Product->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_Product_grid->ListOptions->Render("body", "left", $main_Product_grid->RowCnt);
?>
	<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
		<td data-name="pr_Barcode"<?php echo $main_Product->pr_Barcode->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Barcode" class="main_Product_pr_Barcode">
<span<?php echo $main_Product->pr_Barcode->ViewAttributes() ?>>
<?php echo $main_Product->pr_Barcode->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->FormValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->OldValue) ?>">
<?php } ?>
<a id="<?php echo $main_Product_grid->PageObjName . "_row_" . $main_Product_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_ID" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->CurrentValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_ID" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT || $main_Product->CurrentMode == "edit") { ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_ID" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
		<td data-name="pr_Activated"<?php echo $main_Product->pr_Activated->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<input type="text" data-table="main_Product" data-field="x_pr_Activated" data-format="7" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Activated->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Activated->EditValue ?>"<?php echo $main_Product->pr_Activated->EditAttributes() ?>>
<?php if (!$main_Product->pr_Activated->ReadOnly && !$main_Product->pr_Activated->Disabled && !isset($main_Product->pr_Activated->EditAttrs["readonly"]) && !isset($main_Product->pr_Activated->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fmain_Productgrid", "x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Activated->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->CurrentValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Activated" class="main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<?php echo $main_Product->pr_Activated->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->FormValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
		<td data-name="pr_Status"<?php echo $main_Product->pr_Status->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_Status->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_Status->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>" checked<?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_Status->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_Status->DisplayValueSeparator) ? json_encode($main_Product->pr_Status->DisplayValueSeparator) : $main_Product->pr_Status->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="{value}"<?php echo $main_Product->pr_Status->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
$sWhereWrk = "";
$main_Product->pr_Status->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_Status->LookupFilters += array("f0" => "`ps_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_Status, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_Status->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo $main_Product->pr_Status->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Status->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Status" class="main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<?php echo $main_Product->pr_Status->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->FormValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
		<td data-name="pr_PO"<?php echo $main_Product->pr_PO->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<input type="text" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_PO->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_PO->EditValue ?>"<?php echo $main_Product->pr_PO->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_PO->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->CurrentValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_PO" class="main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<?php echo $main_Product->pr_PO->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->FormValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
		<td data-name="pr_Cost"<?php echo $main_Product->pr_Cost->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_Cost" class="main_Product_pr_Cost">
<span<?php echo $main_Product->pr_Cost->ViewAttributes() ?>>
<?php echo $main_Product->pr_Cost->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->FormValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
		<td data-name="pr_intStatus"<?php echo $main_Product->pr_intStatus->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_intStatus->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_intStatus->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_intStatus`";
$sWhereWrk = "";
$main_Product->pr_intStatus->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_intStatus->LookupFilters += array("f0" => "`in_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_intStatus, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_intStatus->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_intStatus->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_intStatus->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_intStatus`";
$sWhereWrk = "";
$main_Product->pr_intStatus->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_intStatus->LookupFilters += array("f0" => "`in_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_intStatus, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_intStatus->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_grid->RowCnt ?>_main_Product_pr_intStatus" class="main_Product_pr_intStatus">
<span<?php echo $main_Product->pr_intStatus->ViewAttributes() ?>>
<?php echo $main_Product->pr_intStatus->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->FormValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_Product_grid->ListOptions->Render("body", "right", $main_Product_grid->RowCnt);
?>
	</tr>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD || $main_Product->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmain_Productgrid.UpdateOpts(<?php echo $main_Product_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($main_Product->CurrentAction <> "gridadd" || $main_Product->CurrentMode == "copy")
		if (!$main_Product_grid->Recordset->EOF) $main_Product_grid->Recordset->MoveNext();
}
?>
<?php
	if ($main_Product->CurrentMode == "add" || $main_Product->CurrentMode == "copy" || $main_Product->CurrentMode == "edit") {
		$main_Product_grid->RowIndex = '$rowindex$';
		$main_Product_grid->LoadDefaultValues();

		// Set row properties
		$main_Product->ResetAttrs();
		$main_Product->RowAttrs = array_merge($main_Product->RowAttrs, array('data-rowindex'=>$main_Product_grid->RowIndex, 'id'=>'r0_main_Product', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($main_Product->RowAttrs["class"], "ewTemplate");
		$main_Product->RowType = EW_ROWTYPE_ADD;

		// Render row
		$main_Product_grid->RenderRow();

		// Render list options
		$main_Product_grid->RenderListOptions();
		$main_Product_grid->StartRowCnt = 0;
?>
	<tr<?php echo $main_Product->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_Product_grid->ListOptions->Render("body", "left", $main_Product_grid->RowIndex);
?>
	<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
		<td data-name="pr_Barcode">
<?php if ($main_Product->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<span<?php echo $main_Product->pr_Barcode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Barcode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
		<td data-name="pr_Activated">
<?php if ($main_Product->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<input type="text" data-table="main_Product" data-field="x_pr_Activated" data-format="7" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Activated->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Activated->EditValue ?>"<?php echo $main_Product->pr_Activated->EditAttributes() ?>>
<?php if (!$main_Product->pr_Activated->ReadOnly && !$main_Product->pr_Activated->Disabled && !isset($main_Product->pr_Activated->EditAttrs["readonly"]) && !isset($main_Product->pr_Activated->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fmain_Productgrid", "x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Activated->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
		<td data-name="pr_Status">
<?php if ($main_Product->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_Status->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_Status->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>" checked<?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_Status->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_Status->DisplayValueSeparator) ? json_encode($main_Product->pr_Status->DisplayValueSeparator) : $main_Product->pr_Status->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="{value}"<?php echo $main_Product->pr_Status->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
$sWhereWrk = "";
$main_Product->pr_Status->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_Status->LookupFilters += array("f0" => "`ps_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_Status, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_Status->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo $main_Product->pr_Status->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Status" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
		<td data-name="pr_PO">
<?php if ($main_Product->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<input type="text" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_PO->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_PO->EditValue ?>"<?php echo $main_Product->pr_PO->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_PO->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_PO" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
		<td data-name="pr_Cost">
<?php if ($main_Product->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<span<?php echo $main_Product->pr_Cost->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Cost->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
		<td data-name="pr_intStatus">
<?php if ($main_Product->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_intStatus->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_intStatus->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_intStatus`";
$sWhereWrk = "";
$main_Product->pr_intStatus->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_intStatus->LookupFilters += array("f0" => "`in_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_intStatus, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_intStatus->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<span<?php echo $main_Product->pr_intStatus->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_intStatus->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="o<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" id="o<?php echo $main_Product_grid->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_Product_grid->ListOptions->Render("body", "right", $main_Product_grid->RowCnt);
?>
<script type="text/javascript">
fmain_Productgrid.UpdateOpts(<?php echo $main_Product_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($main_Product->CurrentMode == "add" || $main_Product->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $main_Product_grid->FormKeyCountName ?>" id="<?php echo $main_Product_grid->FormKeyCountName ?>" value="<?php echo $main_Product_grid->KeyCount ?>">
<?php echo $main_Product_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($main_Product->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $main_Product_grid->FormKeyCountName ?>" id="<?php echo $main_Product_grid->FormKeyCountName ?>" value="<?php echo $main_Product_grid->KeyCount ?>">
<?php echo $main_Product_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($main_Product->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmain_Productgrid">
</div>
<?php

// Close recordset
if ($main_Product_grid->Recordset)
	$main_Product_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($main_Product_grid->TotalRecs == 0 && $main_Product->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($main_Product_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($main_Product->Export == "") { ?>
<script type="text/javascript">
fmain_Productgrid.Init();
</script>
<?php } ?>
<?php
$main_Product_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$main_Product_grid->Page_Terminate();
?>
