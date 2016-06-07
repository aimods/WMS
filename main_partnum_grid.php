<?php include_once "main_user_info.php" ?>
<?php

// Create page object
if (!isset($main_PartNum_grid)) $main_PartNum_grid = new cmain_PartNum_grid();

// Page init
$main_PartNum_grid->Page_Init();

// Page main
$main_PartNum_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_PartNum_grid->Page_Render();
?>
<?php if ($main_PartNum->Export == "") { ?>
<script type="text/javascript">

// Form object
var fmain_PartNumgrid = new ew_Form("fmain_PartNumgrid", "grid");
fmain_PartNumgrid.FormKeyCountName = '<?php echo $main_PartNum_grid->FormKeyCountName ?>';

// Validate form
fmain_PartNumgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pn_Barcode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_PartNum->pn_Barcode->FldCaption(), $main_PartNum->pn_Barcode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_v_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_PartNum->v_ID->FldCaption(), $main_PartNum->v_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pn_ProductName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_PartNum->pn_ProductName->FldCaption(), $main_PartNum->pn_ProductName->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fmain_PartNumgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "pn_Barcode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "v_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "b_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pn_ProductName", false)) return false;
	return true;
}

// Form_CustomValidate event
fmain_PartNumgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_PartNumgrid.ValidateRequired = true;
<?php } else { ?>
fmain_PartNumgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_PartNumgrid.Lists["x_v_ID"] = {"LinkField":"x_v_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_v_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_PartNumgrid.Lists["x_b_ID"] = {"LinkField":"x_b_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_b_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($main_PartNum->CurrentAction == "gridadd") {
	if ($main_PartNum->CurrentMode == "copy") {
		$bSelectLimit = $main_PartNum_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$main_PartNum_grid->TotalRecs = $main_PartNum->SelectRecordCount();
			$main_PartNum_grid->Recordset = $main_PartNum_grid->LoadRecordset($main_PartNum_grid->StartRec-1, $main_PartNum_grid->DisplayRecs);
		} else {
			if ($main_PartNum_grid->Recordset = $main_PartNum_grid->LoadRecordset())
				$main_PartNum_grid->TotalRecs = $main_PartNum_grid->Recordset->RecordCount();
		}
		$main_PartNum_grid->StartRec = 1;
		$main_PartNum_grid->DisplayRecs = $main_PartNum_grid->TotalRecs;
	} else {
		$main_PartNum->CurrentFilter = "0=1";
		$main_PartNum_grid->StartRec = 1;
		$main_PartNum_grid->DisplayRecs = $main_PartNum->GridAddRowCount;
	}
	$main_PartNum_grid->TotalRecs = $main_PartNum_grid->DisplayRecs;
	$main_PartNum_grid->StopRec = $main_PartNum_grid->DisplayRecs;
} else {
	$bSelectLimit = $main_PartNum_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($main_PartNum_grid->TotalRecs <= 0)
			$main_PartNum_grid->TotalRecs = $main_PartNum->SelectRecordCount();
	} else {
		if (!$main_PartNum_grid->Recordset && ($main_PartNum_grid->Recordset = $main_PartNum_grid->LoadRecordset()))
			$main_PartNum_grid->TotalRecs = $main_PartNum_grid->Recordset->RecordCount();
	}
	$main_PartNum_grid->StartRec = 1;
	$main_PartNum_grid->DisplayRecs = $main_PartNum_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$main_PartNum_grid->Recordset = $main_PartNum_grid->LoadRecordset($main_PartNum_grid->StartRec-1, $main_PartNum_grid->DisplayRecs);

	// Set no record found message
	if ($main_PartNum->CurrentAction == "" && $main_PartNum_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$main_PartNum_grid->setWarningMessage(ew_DeniedMsg());
		if ($main_PartNum_grid->SearchWhere == "0=101")
			$main_PartNum_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$main_PartNum_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$main_PartNum_grid->RenderOtherOptions();
?>
<?php $main_PartNum_grid->ShowPageHeader(); ?>
<?php
$main_PartNum_grid->ShowMessage();
?>
<?php if ($main_PartNum_grid->TotalRecs > 0 || $main_PartNum->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fmain_PartNumgrid" class="ewForm form-inline">
<?php if ($main_PartNum_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($main_PartNum_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_main_PartNum" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_main_PartNumgrid" class="table ewTable">
<?php echo $main_PartNum->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$main_PartNum_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$main_PartNum_grid->RenderListOptions();

// Render list options (header, left)
$main_PartNum_grid->ListOptions->Render("header", "left");
?>
<?php if ($main_PartNum->pn_Barcode->Visible) { // pn_Barcode ?>
	<?php if ($main_PartNum->SortUrl($main_PartNum->pn_Barcode) == "") { ?>
		<th data-name="pn_Barcode"><div id="elh_main_PartNum_pn_Barcode" class="main_PartNum_pn_Barcode"><div class="ewTableHeaderCaption"><?php echo $main_PartNum->pn_Barcode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pn_Barcode"><div><div id="elh_main_PartNum_pn_Barcode" class="main_PartNum_pn_Barcode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_PartNum->pn_Barcode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_PartNum->pn_Barcode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_PartNum->pn_Barcode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_PartNum->v_ID->Visible) { // v_ID ?>
	<?php if ($main_PartNum->SortUrl($main_PartNum->v_ID) == "") { ?>
		<th data-name="v_ID"><div id="elh_main_PartNum_v_ID" class="main_PartNum_v_ID"><div class="ewTableHeaderCaption"><?php echo $main_PartNum->v_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_ID"><div><div id="elh_main_PartNum_v_ID" class="main_PartNum_v_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_PartNum->v_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_PartNum->v_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_PartNum->v_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_PartNum->b_ID->Visible) { // b_ID ?>
	<?php if ($main_PartNum->SortUrl($main_PartNum->b_ID) == "") { ?>
		<th data-name="b_ID"><div id="elh_main_PartNum_b_ID" class="main_PartNum_b_ID"><div class="ewTableHeaderCaption"><?php echo $main_PartNum->b_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="b_ID"><div><div id="elh_main_PartNum_b_ID" class="main_PartNum_b_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_PartNum->b_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_PartNum->b_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_PartNum->b_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_PartNum->pn_ProductName->Visible) { // pn_ProductName ?>
	<?php if ($main_PartNum->SortUrl($main_PartNum->pn_ProductName) == "") { ?>
		<th data-name="pn_ProductName"><div id="elh_main_PartNum_pn_ProductName" class="main_PartNum_pn_ProductName"><div class="ewTableHeaderCaption"><?php echo $main_PartNum->pn_ProductName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pn_ProductName"><div><div id="elh_main_PartNum_pn_ProductName" class="main_PartNum_pn_ProductName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_PartNum->pn_ProductName->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_PartNum->pn_ProductName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_PartNum->pn_ProductName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$main_PartNum_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$main_PartNum_grid->StartRec = 1;
$main_PartNum_grid->StopRec = $main_PartNum_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($main_PartNum_grid->FormKeyCountName) && ($main_PartNum->CurrentAction == "gridadd" || $main_PartNum->CurrentAction == "gridedit" || $main_PartNum->CurrentAction == "F")) {
		$main_PartNum_grid->KeyCount = $objForm->GetValue($main_PartNum_grid->FormKeyCountName);
		$main_PartNum_grid->StopRec = $main_PartNum_grid->StartRec + $main_PartNum_grid->KeyCount - 1;
	}
}
$main_PartNum_grid->RecCnt = $main_PartNum_grid->StartRec - 1;
if ($main_PartNum_grid->Recordset && !$main_PartNum_grid->Recordset->EOF) {
	$main_PartNum_grid->Recordset->MoveFirst();
	$bSelectLimit = $main_PartNum_grid->UseSelectLimit;
	if (!$bSelectLimit && $main_PartNum_grid->StartRec > 1)
		$main_PartNum_grid->Recordset->Move($main_PartNum_grid->StartRec - 1);
} elseif (!$main_PartNum->AllowAddDeleteRow && $main_PartNum_grid->StopRec == 0) {
	$main_PartNum_grid->StopRec = $main_PartNum->GridAddRowCount;
}

// Initialize aggregate
$main_PartNum->RowType = EW_ROWTYPE_AGGREGATEINIT;
$main_PartNum->ResetAttrs();
$main_PartNum_grid->RenderRow();
if ($main_PartNum->CurrentAction == "gridadd")
	$main_PartNum_grid->RowIndex = 0;
if ($main_PartNum->CurrentAction == "gridedit")
	$main_PartNum_grid->RowIndex = 0;
while ($main_PartNum_grid->RecCnt < $main_PartNum_grid->StopRec) {
	$main_PartNum_grid->RecCnt++;
	if (intval($main_PartNum_grid->RecCnt) >= intval($main_PartNum_grid->StartRec)) {
		$main_PartNum_grid->RowCnt++;
		if ($main_PartNum->CurrentAction == "gridadd" || $main_PartNum->CurrentAction == "gridedit" || $main_PartNum->CurrentAction == "F") {
			$main_PartNum_grid->RowIndex++;
			$objForm->Index = $main_PartNum_grid->RowIndex;
			if ($objForm->HasValue($main_PartNum_grid->FormActionName))
				$main_PartNum_grid->RowAction = strval($objForm->GetValue($main_PartNum_grid->FormActionName));
			elseif ($main_PartNum->CurrentAction == "gridadd")
				$main_PartNum_grid->RowAction = "insert";
			else
				$main_PartNum_grid->RowAction = "";
		}

		// Set up key count
		$main_PartNum_grid->KeyCount = $main_PartNum_grid->RowIndex;

		// Init row class and style
		$main_PartNum->ResetAttrs();
		$main_PartNum->CssClass = "";
		if ($main_PartNum->CurrentAction == "gridadd") {
			if ($main_PartNum->CurrentMode == "copy") {
				$main_PartNum_grid->LoadRowValues($main_PartNum_grid->Recordset); // Load row values
				$main_PartNum_grid->SetRecordKey($main_PartNum_grid->RowOldKey, $main_PartNum_grid->Recordset); // Set old record key
			} else {
				$main_PartNum_grid->LoadDefaultValues(); // Load default values
				$main_PartNum_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$main_PartNum_grid->LoadRowValues($main_PartNum_grid->Recordset); // Load row values
		}
		$main_PartNum->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($main_PartNum->CurrentAction == "gridadd") // Grid add
			$main_PartNum->RowType = EW_ROWTYPE_ADD; // Render add
		if ($main_PartNum->CurrentAction == "gridadd" && $main_PartNum->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$main_PartNum_grid->RestoreCurrentRowFormValues($main_PartNum_grid->RowIndex); // Restore form values
		if ($main_PartNum->CurrentAction == "gridedit") { // Grid edit
			if ($main_PartNum->EventCancelled) {
				$main_PartNum_grid->RestoreCurrentRowFormValues($main_PartNum_grid->RowIndex); // Restore form values
			}
			if ($main_PartNum_grid->RowAction == "insert")
				$main_PartNum->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$main_PartNum->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($main_PartNum->CurrentAction == "gridedit" && ($main_PartNum->RowType == EW_ROWTYPE_EDIT || $main_PartNum->RowType == EW_ROWTYPE_ADD) && $main_PartNum->EventCancelled) // Update failed
			$main_PartNum_grid->RestoreCurrentRowFormValues($main_PartNum_grid->RowIndex); // Restore form values
		if ($main_PartNum->RowType == EW_ROWTYPE_EDIT) // Edit row
			$main_PartNum_grid->EditRowCnt++;
		if ($main_PartNum->CurrentAction == "F") // Confirm row
			$main_PartNum_grid->RestoreCurrentRowFormValues($main_PartNum_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$main_PartNum->RowAttrs = array_merge($main_PartNum->RowAttrs, array('data-rowindex'=>$main_PartNum_grid->RowCnt, 'id'=>'r' . $main_PartNum_grid->RowCnt . '_main_PartNum', 'data-rowtype'=>$main_PartNum->RowType));

		// Render row
		$main_PartNum_grid->RenderRow();

		// Render list options
		$main_PartNum_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($main_PartNum_grid->RowAction <> "delete" && $main_PartNum_grid->RowAction <> "insertdelete" && !($main_PartNum_grid->RowAction == "insert" && $main_PartNum->CurrentAction == "F" && $main_PartNum_grid->EmptyRow())) {
?>
	<tr<?php echo $main_PartNum->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_PartNum_grid->ListOptions->Render("body", "left", $main_PartNum_grid->RowCnt);
?>
	<?php if ($main_PartNum->pn_Barcode->Visible) { // pn_Barcode ?>
		<td data-name="pn_Barcode"<?php echo $main_PartNum->pn_Barcode->CellAttributes() ?>>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_pn_Barcode" class="form-group main_PartNum_pn_Barcode">
<input type="text" data-table="main_PartNum" data-field="x_pn_Barcode" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_Barcode->EditValue ?>"<?php echo $main_PartNum->pn_Barcode->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_Barcode" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" value="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->OldValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_pn_Barcode" class="form-group main_PartNum_pn_Barcode">
<span<?php echo $main_PartNum->pn_Barcode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->pn_Barcode->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_Barcode" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" value="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->CurrentValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_pn_Barcode" class="main_PartNum_pn_Barcode">
<span<?php echo $main_PartNum->pn_Barcode->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_Barcode->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_Barcode" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" value="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->FormValue) ?>">
<input type="hidden" data-table="main_PartNum" data-field="x_pn_Barcode" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" value="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->OldValue) ?>">
<?php } ?>
<a id="<?php echo $main_PartNum_grid->PageObjName . "_row_" . $main_PartNum_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ID" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ID->CurrentValue) ?>">
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ID" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ID->OldValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_EDIT || $main_PartNum->CurrentMode == "edit") { ?>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ID" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($main_PartNum->v_ID->Visible) { // v_ID ?>
		<td data-name="v_ID"<?php echo $main_PartNum->v_ID->CellAttributes() ?>>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($main_PartNum->v_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_v_ID" class="form-group main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->v_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_v_ID" class="form-group main_PartNum_v_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_PartNum->v_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_PartNum->v_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_PartNum->v_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_PartNum->v_ID->EditAttributes() ?>><?php echo $main_PartNum->v_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_PartNum->v_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>" checked<?php echo $main_PartNum->v_ID->EditAttributes() ?>><?php echo $main_PartNum->v_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_PartNum->v_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" class="ewTemplate"><input type="radio" data-table="main_PartNum" data-field="x_v_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_PartNum->v_ID->DisplayValueSeparator) ? json_encode($main_PartNum->v_ID->DisplayValueSeparator) : $main_PartNum->v_ID->DisplayValueSeparator) ?>" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="{value}"<?php echo $main_PartNum->v_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
$sWhereWrk = "";
$main_PartNum->v_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_PartNum->v_ID->LookupFilters += array("f0" => "`v_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_PartNum->Lookup_Selecting($main_PartNum->v_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v_Name` ASC";
if ($sSqlWrk <> "") $main_PartNum->v_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="s_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo $main_PartNum->v_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="main_PartNum" data-field="x_v_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->OldValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_v_ID" class="form-group main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->v_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_v_ID" class="main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<?php echo $main_PartNum->v_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->FormValue) ?>">
<input type="hidden" data-table="main_PartNum" data-field="x_v_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_PartNum->b_ID->Visible) { // b_ID ?>
		<td data-name="b_ID"<?php echo $main_PartNum->b_ID->CellAttributes() ?>>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($main_PartNum->b_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_b_ID" class="form-group main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->b_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_b_ID" class="form-group main_PartNum_b_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_PartNum->b_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_PartNum->b_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_PartNum->b_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_PartNum->b_ID->EditAttributes() ?>><?php echo $main_PartNum->b_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_PartNum->b_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>" checked<?php echo $main_PartNum->b_ID->EditAttributes() ?>><?php echo $main_PartNum->b_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_PartNum->b_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" class="ewTemplate"><input type="radio" data-table="main_PartNum" data-field="x_b_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_PartNum->b_ID->DisplayValueSeparator) ? json_encode($main_PartNum->b_ID->DisplayValueSeparator) : $main_PartNum->b_ID->DisplayValueSeparator) ?>" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="{value}"<?php echo $main_PartNum->b_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
$sWhereWrk = "";
$main_PartNum->b_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_PartNum->b_ID->LookupFilters += array("f0" => "`b_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_PartNum->Lookup_Selecting($main_PartNum->b_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `b_Name` ASC";
if ($sSqlWrk <> "") $main_PartNum->b_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="s_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo $main_PartNum->b_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="main_PartNum" data-field="x_b_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->OldValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_b_ID" class="form-group main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->b_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_b_ID" class="main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<?php echo $main_PartNum->b_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->FormValue) ?>">
<input type="hidden" data-table="main_PartNum" data-field="x_b_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_PartNum->pn_ProductName->Visible) { // pn_ProductName ?>
		<td data-name="pn_ProductName"<?php echo $main_PartNum->pn_ProductName->CellAttributes() ?>>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_pn_ProductName" class="form-group main_PartNum_pn_ProductName">
<input type="text" data-table="main_PartNum" data-field="x_pn_ProductName" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_ProductName->EditValue ?>"<?php echo $main_PartNum->pn_ProductName->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ProductName" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->OldValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_pn_ProductName" class="form-group main_PartNum_pn_ProductName">
<span<?php echo $main_PartNum->pn_ProductName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->pn_ProductName->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ProductName" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->CurrentValue) ?>">
<?php } ?>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_PartNum_grid->RowCnt ?>_main_PartNum_pn_ProductName" class="main_PartNum_pn_ProductName">
<span<?php echo $main_PartNum->pn_ProductName->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_ProductName->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ProductName" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->FormValue) ?>">
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ProductName" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_PartNum_grid->ListOptions->Render("body", "right", $main_PartNum_grid->RowCnt);
?>
	</tr>
<?php if ($main_PartNum->RowType == EW_ROWTYPE_ADD || $main_PartNum->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmain_PartNumgrid.UpdateOpts(<?php echo $main_PartNum_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($main_PartNum->CurrentAction <> "gridadd" || $main_PartNum->CurrentMode == "copy")
		if (!$main_PartNum_grid->Recordset->EOF) $main_PartNum_grid->Recordset->MoveNext();
}
?>
<?php
	if ($main_PartNum->CurrentMode == "add" || $main_PartNum->CurrentMode == "copy" || $main_PartNum->CurrentMode == "edit") {
		$main_PartNum_grid->RowIndex = '$rowindex$';
		$main_PartNum_grid->LoadDefaultValues();

		// Set row properties
		$main_PartNum->ResetAttrs();
		$main_PartNum->RowAttrs = array_merge($main_PartNum->RowAttrs, array('data-rowindex'=>$main_PartNum_grid->RowIndex, 'id'=>'r0_main_PartNum', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($main_PartNum->RowAttrs["class"], "ewTemplate");
		$main_PartNum->RowType = EW_ROWTYPE_ADD;

		// Render row
		$main_PartNum_grid->RenderRow();

		// Render list options
		$main_PartNum_grid->RenderListOptions();
		$main_PartNum_grid->StartRowCnt = 0;
?>
	<tr<?php echo $main_PartNum->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_PartNum_grid->ListOptions->Render("body", "left", $main_PartNum_grid->RowIndex);
?>
	<?php if ($main_PartNum->pn_Barcode->Visible) { // pn_Barcode ?>
		<td data-name="pn_Barcode">
<?php if ($main_PartNum->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_PartNum_pn_Barcode" class="form-group main_PartNum_pn_Barcode">
<input type="text" data-table="main_PartNum" data-field="x_pn_Barcode" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_Barcode->EditValue ?>"<?php echo $main_PartNum->pn_Barcode->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_PartNum_pn_Barcode" class="form-group main_PartNum_pn_Barcode">
<span<?php echo $main_PartNum->pn_Barcode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->pn_Barcode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_Barcode" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" value="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_Barcode" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_Barcode" value="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_PartNum->v_ID->Visible) { // v_ID ?>
		<td data-name="v_ID">
<?php if ($main_PartNum->CurrentAction <> "F") { ?>
<?php if ($main_PartNum->v_ID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_main_PartNum_v_ID" class="form-group main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->v_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_main_PartNum_v_ID" class="form-group main_PartNum_v_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_PartNum->v_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_PartNum->v_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_PartNum->v_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_PartNum->v_ID->EditAttributes() ?>><?php echo $main_PartNum->v_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_PartNum->v_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>" checked<?php echo $main_PartNum->v_ID->EditAttributes() ?>><?php echo $main_PartNum->v_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_PartNum->v_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" class="ewTemplate"><input type="radio" data-table="main_PartNum" data-field="x_v_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_PartNum->v_ID->DisplayValueSeparator) ? json_encode($main_PartNum->v_ID->DisplayValueSeparator) : $main_PartNum->v_ID->DisplayValueSeparator) ?>" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="{value}"<?php echo $main_PartNum->v_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
$sWhereWrk = "";
$main_PartNum->v_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_PartNum->v_ID->LookupFilters += array("f0" => "`v_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_PartNum->Lookup_Selecting($main_PartNum->v_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v_Name` ASC";
if ($sSqlWrk <> "") $main_PartNum->v_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="s_x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo $main_PartNum->v_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_PartNum_v_ID" class="form-group main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->v_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_v_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_PartNum" data-field="x_v_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_PartNum->b_ID->Visible) { // b_ID ?>
		<td data-name="b_ID">
<?php if ($main_PartNum->CurrentAction <> "F") { ?>
<?php if ($main_PartNum->b_ID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_main_PartNum_b_ID" class="form-group main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->b_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_main_PartNum_b_ID" class="form-group main_PartNum_b_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_PartNum->b_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_PartNum->b_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_PartNum->b_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_PartNum->b_ID->EditAttributes() ?>><?php echo $main_PartNum->b_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_PartNum->b_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>" checked<?php echo $main_PartNum->b_ID->EditAttributes() ?>><?php echo $main_PartNum->b_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_PartNum->b_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" class="ewTemplate"><input type="radio" data-table="main_PartNum" data-field="x_b_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_PartNum->b_ID->DisplayValueSeparator) ? json_encode($main_PartNum->b_ID->DisplayValueSeparator) : $main_PartNum->b_ID->DisplayValueSeparator) ?>" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="{value}"<?php echo $main_PartNum->b_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
$sWhereWrk = "";
$main_PartNum->b_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_PartNum->b_ID->LookupFilters += array("f0" => "`b_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_PartNum->Lookup_Selecting($main_PartNum->b_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `b_Name` ASC";
if ($sSqlWrk <> "") $main_PartNum->b_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="s_x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo $main_PartNum->b_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_main_PartNum_b_ID" class="form-group main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->b_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_b_ID" name="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="x<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_PartNum" data-field="x_b_ID" name="o<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" id="o<?php echo $main_PartNum_grid->RowIndex ?>_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_PartNum->pn_ProductName->Visible) { // pn_ProductName ?>
		<td data-name="pn_ProductName">
<?php if ($main_PartNum->CurrentAction <> "F") { ?>
<span id="el$rowindex$_main_PartNum_pn_ProductName" class="form-group main_PartNum_pn_ProductName">
<input type="text" data-table="main_PartNum" data-field="x_pn_ProductName" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_ProductName->EditValue ?>"<?php echo $main_PartNum->pn_ProductName->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_main_PartNum_pn_ProductName" class="form-group main_PartNum_pn_ProductName">
<span<?php echo $main_PartNum->pn_ProductName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->pn_ProductName->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ProductName" name="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="x<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="main_PartNum" data-field="x_pn_ProductName" name="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" id="o<?php echo $main_PartNum_grid->RowIndex ?>_pn_ProductName" value="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_PartNum_grid->ListOptions->Render("body", "right", $main_PartNum_grid->RowCnt);
?>
<script type="text/javascript">
fmain_PartNumgrid.UpdateOpts(<?php echo $main_PartNum_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($main_PartNum->CurrentMode == "add" || $main_PartNum->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $main_PartNum_grid->FormKeyCountName ?>" id="<?php echo $main_PartNum_grid->FormKeyCountName ?>" value="<?php echo $main_PartNum_grid->KeyCount ?>">
<?php echo $main_PartNum_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($main_PartNum->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $main_PartNum_grid->FormKeyCountName ?>" id="<?php echo $main_PartNum_grid->FormKeyCountName ?>" value="<?php echo $main_PartNum_grid->KeyCount ?>">
<?php echo $main_PartNum_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($main_PartNum->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmain_PartNumgrid">
</div>
<?php

// Close recordset
if ($main_PartNum_grid->Recordset)
	$main_PartNum_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($main_PartNum_grid->TotalRecs == 0 && $main_PartNum->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($main_PartNum_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($main_PartNum->Export == "") { ?>
<script type="text/javascript">
fmain_PartNumgrid.Init();
</script>
<?php } ?>
<?php
$main_PartNum_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$main_PartNum_grid->Page_Terminate();
?>
