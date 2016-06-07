<?php include_once "main_user_info.php" ?>
<?php

// Create page object
if (!isset($lov_amphur_grid)) $lov_amphur_grid = new clov_amphur_grid();

// Page init
$lov_amphur_grid->Page_Init();

// Page main
$lov_amphur_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_amphur_grid->Page_Render();
?>
<?php if ($lov_amphur->Export == "") { ?>
<script type="text/javascript">

// Form object
var flov_amphurgrid = new ew_Form("flov_amphurgrid", "grid");
flov_amphurgrid.FormKeyCountName = '<?php echo $lov_amphur_grid->FormKeyCountName ?>';

// Validate form
flov_amphurgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_AMPHUR_CODE");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_amphur->AMPHUR_CODE->FldCaption(), $lov_amphur->AMPHUR_CODE->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PROVINCE_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_amphur->PROVINCE_ID->FldCaption(), $lov_amphur->PROVINCE_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AMPHUR_NAME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_amphur->AMPHUR_NAME->FldCaption(), $lov_amphur->AMPHUR_NAME->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
flov_amphurgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "AMPHUR_CODE", false)) return false;
	if (ew_ValueChanged(fobj, infix, "PROVINCE_ID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AMPHUR_NAME", false)) return false;
	if (ew_ValueChanged(fobj, infix, "AMPER_NAME_EN", false)) return false;
	return true;
}

// Form_CustomValidate event
flov_amphurgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_amphurgrid.ValidateRequired = true;
<?php } else { ?>
flov_amphurgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flov_amphurgrid.Lists["x_PROVINCE_ID"] = {"LinkField":"x_PROVINCE_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_PROVINCE_NAME","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($lov_amphur->CurrentAction == "gridadd") {
	if ($lov_amphur->CurrentMode == "copy") {
		$bSelectLimit = $lov_amphur_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$lov_amphur_grid->TotalRecs = $lov_amphur->SelectRecordCount();
			$lov_amphur_grid->Recordset = $lov_amphur_grid->LoadRecordset($lov_amphur_grid->StartRec-1, $lov_amphur_grid->DisplayRecs);
		} else {
			if ($lov_amphur_grid->Recordset = $lov_amphur_grid->LoadRecordset())
				$lov_amphur_grid->TotalRecs = $lov_amphur_grid->Recordset->RecordCount();
		}
		$lov_amphur_grid->StartRec = 1;
		$lov_amphur_grid->DisplayRecs = $lov_amphur_grid->TotalRecs;
	} else {
		$lov_amphur->CurrentFilter = "0=1";
		$lov_amphur_grid->StartRec = 1;
		$lov_amphur_grid->DisplayRecs = $lov_amphur->GridAddRowCount;
	}
	$lov_amphur_grid->TotalRecs = $lov_amphur_grid->DisplayRecs;
	$lov_amphur_grid->StopRec = $lov_amphur_grid->DisplayRecs;
} else {
	$bSelectLimit = $lov_amphur_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($lov_amphur_grid->TotalRecs <= 0)
			$lov_amphur_grid->TotalRecs = $lov_amphur->SelectRecordCount();
	} else {
		if (!$lov_amphur_grid->Recordset && ($lov_amphur_grid->Recordset = $lov_amphur_grid->LoadRecordset()))
			$lov_amphur_grid->TotalRecs = $lov_amphur_grid->Recordset->RecordCount();
	}
	$lov_amphur_grid->StartRec = 1;
	$lov_amphur_grid->DisplayRecs = $lov_amphur_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$lov_amphur_grid->Recordset = $lov_amphur_grid->LoadRecordset($lov_amphur_grid->StartRec-1, $lov_amphur_grid->DisplayRecs);

	// Set no record found message
	if ($lov_amphur->CurrentAction == "" && $lov_amphur_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$lov_amphur_grid->setWarningMessage(ew_DeniedMsg());
		if ($lov_amphur_grid->SearchWhere == "0=101")
			$lov_amphur_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$lov_amphur_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$lov_amphur_grid->RenderOtherOptions();
?>
<?php $lov_amphur_grid->ShowPageHeader(); ?>
<?php
$lov_amphur_grid->ShowMessage();
?>
<?php if ($lov_amphur_grid->TotalRecs > 0 || $lov_amphur->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="flov_amphurgrid" class="ewForm form-inline">
<?php if ($lov_amphur_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($lov_amphur_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_lov_amphur" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_lov_amphurgrid" class="table ewTable">
<?php echo $lov_amphur->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$lov_amphur_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$lov_amphur_grid->RenderListOptions();

// Render list options (header, left)
$lov_amphur_grid->ListOptions->Render("header", "left");
?>
<?php if ($lov_amphur->AMPHUR_ID->Visible) { // AMPHUR_ID ?>
	<?php if ($lov_amphur->SortUrl($lov_amphur->AMPHUR_ID) == "") { ?>
		<th data-name="AMPHUR_ID"><div id="elh_lov_amphur_AMPHUR_ID" class="lov_amphur_AMPHUR_ID"><div class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPHUR_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AMPHUR_ID"><div><div id="elh_lov_amphur_AMPHUR_ID" class="lov_amphur_AMPHUR_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPHUR_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_amphur->AMPHUR_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_amphur->AMPHUR_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_amphur->AMPHUR_CODE->Visible) { // AMPHUR_CODE ?>
	<?php if ($lov_amphur->SortUrl($lov_amphur->AMPHUR_CODE) == "") { ?>
		<th data-name="AMPHUR_CODE"><div id="elh_lov_amphur_AMPHUR_CODE" class="lov_amphur_AMPHUR_CODE"><div class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPHUR_CODE->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AMPHUR_CODE"><div><div id="elh_lov_amphur_AMPHUR_CODE" class="lov_amphur_AMPHUR_CODE">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPHUR_CODE->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_amphur->AMPHUR_CODE->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_amphur->AMPHUR_CODE->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_amphur->PROVINCE_ID->Visible) { // PROVINCE_ID ?>
	<?php if ($lov_amphur->SortUrl($lov_amphur->PROVINCE_ID) == "") { ?>
		<th data-name="PROVINCE_ID"><div id="elh_lov_amphur_PROVINCE_ID" class="lov_amphur_PROVINCE_ID"><div class="ewTableHeaderCaption"><?php echo $lov_amphur->PROVINCE_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PROVINCE_ID"><div><div id="elh_lov_amphur_PROVINCE_ID" class="lov_amphur_PROVINCE_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_amphur->PROVINCE_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_amphur->PROVINCE_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_amphur->PROVINCE_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_amphur->AMPHUR_NAME->Visible) { // AMPHUR_NAME ?>
	<?php if ($lov_amphur->SortUrl($lov_amphur->AMPHUR_NAME) == "") { ?>
		<th data-name="AMPHUR_NAME"><div id="elh_lov_amphur_AMPHUR_NAME" class="lov_amphur_AMPHUR_NAME"><div class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPHUR_NAME->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AMPHUR_NAME"><div><div id="elh_lov_amphur_AMPHUR_NAME" class="lov_amphur_AMPHUR_NAME">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPHUR_NAME->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_amphur->AMPHUR_NAME->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_amphur->AMPHUR_NAME->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_amphur->AMPER_NAME_EN->Visible) { // AMPER_NAME_EN ?>
	<?php if ($lov_amphur->SortUrl($lov_amphur->AMPER_NAME_EN) == "") { ?>
		<th data-name="AMPER_NAME_EN"><div id="elh_lov_amphur_AMPER_NAME_EN" class="lov_amphur_AMPER_NAME_EN"><div class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPER_NAME_EN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="AMPER_NAME_EN"><div><div id="elh_lov_amphur_AMPER_NAME_EN" class="lov_amphur_AMPER_NAME_EN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_amphur->AMPER_NAME_EN->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_amphur->AMPER_NAME_EN->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_amphur->AMPER_NAME_EN->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$lov_amphur_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$lov_amphur_grid->StartRec = 1;
$lov_amphur_grid->StopRec = $lov_amphur_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($lov_amphur_grid->FormKeyCountName) && ($lov_amphur->CurrentAction == "gridadd" || $lov_amphur->CurrentAction == "gridedit" || $lov_amphur->CurrentAction == "F")) {
		$lov_amphur_grid->KeyCount = $objForm->GetValue($lov_amphur_grid->FormKeyCountName);
		$lov_amphur_grid->StopRec = $lov_amphur_grid->StartRec + $lov_amphur_grid->KeyCount - 1;
	}
}
$lov_amphur_grid->RecCnt = $lov_amphur_grid->StartRec - 1;
if ($lov_amphur_grid->Recordset && !$lov_amphur_grid->Recordset->EOF) {
	$lov_amphur_grid->Recordset->MoveFirst();
	$bSelectLimit = $lov_amphur_grid->UseSelectLimit;
	if (!$bSelectLimit && $lov_amphur_grid->StartRec > 1)
		$lov_amphur_grid->Recordset->Move($lov_amphur_grid->StartRec - 1);
} elseif (!$lov_amphur->AllowAddDeleteRow && $lov_amphur_grid->StopRec == 0) {
	$lov_amphur_grid->StopRec = $lov_amphur->GridAddRowCount;
}

// Initialize aggregate
$lov_amphur->RowType = EW_ROWTYPE_AGGREGATEINIT;
$lov_amphur->ResetAttrs();
$lov_amphur_grid->RenderRow();
if ($lov_amphur->CurrentAction == "gridadd")
	$lov_amphur_grid->RowIndex = 0;
if ($lov_amphur->CurrentAction == "gridedit")
	$lov_amphur_grid->RowIndex = 0;
while ($lov_amphur_grid->RecCnt < $lov_amphur_grid->StopRec) {
	$lov_amphur_grid->RecCnt++;
	if (intval($lov_amphur_grid->RecCnt) >= intval($lov_amphur_grid->StartRec)) {
		$lov_amphur_grid->RowCnt++;
		if ($lov_amphur->CurrentAction == "gridadd" || $lov_amphur->CurrentAction == "gridedit" || $lov_amphur->CurrentAction == "F") {
			$lov_amphur_grid->RowIndex++;
			$objForm->Index = $lov_amphur_grid->RowIndex;
			if ($objForm->HasValue($lov_amphur_grid->FormActionName))
				$lov_amphur_grid->RowAction = strval($objForm->GetValue($lov_amphur_grid->FormActionName));
			elseif ($lov_amphur->CurrentAction == "gridadd")
				$lov_amphur_grid->RowAction = "insert";
			else
				$lov_amphur_grid->RowAction = "";
		}

		// Set up key count
		$lov_amphur_grid->KeyCount = $lov_amphur_grid->RowIndex;

		// Init row class and style
		$lov_amphur->ResetAttrs();
		$lov_amphur->CssClass = "";
		if ($lov_amphur->CurrentAction == "gridadd") {
			if ($lov_amphur->CurrentMode == "copy") {
				$lov_amphur_grid->LoadRowValues($lov_amphur_grid->Recordset); // Load row values
				$lov_amphur_grid->SetRecordKey($lov_amphur_grid->RowOldKey, $lov_amphur_grid->Recordset); // Set old record key
			} else {
				$lov_amphur_grid->LoadDefaultValues(); // Load default values
				$lov_amphur_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$lov_amphur_grid->LoadRowValues($lov_amphur_grid->Recordset); // Load row values
		}
		$lov_amphur->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($lov_amphur->CurrentAction == "gridadd") // Grid add
			$lov_amphur->RowType = EW_ROWTYPE_ADD; // Render add
		if ($lov_amphur->CurrentAction == "gridadd" && $lov_amphur->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$lov_amphur_grid->RestoreCurrentRowFormValues($lov_amphur_grid->RowIndex); // Restore form values
		if ($lov_amphur->CurrentAction == "gridedit") { // Grid edit
			if ($lov_amphur->EventCancelled) {
				$lov_amphur_grid->RestoreCurrentRowFormValues($lov_amphur_grid->RowIndex); // Restore form values
			}
			if ($lov_amphur_grid->RowAction == "insert")
				$lov_amphur->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$lov_amphur->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($lov_amphur->CurrentAction == "gridedit" && ($lov_amphur->RowType == EW_ROWTYPE_EDIT || $lov_amphur->RowType == EW_ROWTYPE_ADD) && $lov_amphur->EventCancelled) // Update failed
			$lov_amphur_grid->RestoreCurrentRowFormValues($lov_amphur_grid->RowIndex); // Restore form values
		if ($lov_amphur->RowType == EW_ROWTYPE_EDIT) // Edit row
			$lov_amphur_grid->EditRowCnt++;
		if ($lov_amphur->CurrentAction == "F") // Confirm row
			$lov_amphur_grid->RestoreCurrentRowFormValues($lov_amphur_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$lov_amphur->RowAttrs = array_merge($lov_amphur->RowAttrs, array('data-rowindex'=>$lov_amphur_grid->RowCnt, 'id'=>'r' . $lov_amphur_grid->RowCnt . '_lov_amphur', 'data-rowtype'=>$lov_amphur->RowType));

		// Render row
		$lov_amphur_grid->RenderRow();

		// Render list options
		$lov_amphur_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($lov_amphur_grid->RowAction <> "delete" && $lov_amphur_grid->RowAction <> "insertdelete" && !($lov_amphur_grid->RowAction == "insert" && $lov_amphur->CurrentAction == "F" && $lov_amphur_grid->EmptyRow())) {
?>
	<tr<?php echo $lov_amphur->RowAttributes() ?>>
<?php

// Render list options (body, left)
$lov_amphur_grid->ListOptions->Render("body", "left", $lov_amphur_grid->RowCnt);
?>
	<?php if ($lov_amphur->AMPHUR_ID->Visible) { // AMPHUR_ID ?>
		<td data-name="AMPHUR_ID"<?php echo $lov_amphur->AMPHUR_ID->CellAttributes() ?>>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_ID" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_ID->OldValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_ID" class="form-group lov_amphur_AMPHUR_ID">
<span<?php echo $lov_amphur->AMPHUR_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->AMPHUR_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_ID->CurrentValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_ID" class="lov_amphur_AMPHUR_ID">
<span<?php echo $lov_amphur->AMPHUR_ID->ViewAttributes() ?>>
<?php echo $lov_amphur->AMPHUR_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_ID->FormValue) ?>">
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_ID" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_ID->OldValue) ?>">
<?php } ?>
<a id="<?php echo $lov_amphur_grid->PageObjName . "_row_" . $lov_amphur_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($lov_amphur->AMPHUR_CODE->Visible) { // AMPHUR_CODE ?>
		<td data-name="AMPHUR_CODE"<?php echo $lov_amphur->AMPHUR_CODE->CellAttributes() ?>>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_CODE" class="form-group lov_amphur_AMPHUR_CODE">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_CODE->EditValue ?>"<?php echo $lov_amphur->AMPHUR_CODE->EditAttributes() ?>>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->OldValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_CODE" class="form-group lov_amphur_AMPHUR_CODE">
<span<?php echo $lov_amphur->AMPHUR_CODE->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->AMPHUR_CODE->EditValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->CurrentValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_CODE" class="lov_amphur_AMPHUR_CODE">
<span<?php echo $lov_amphur->AMPHUR_CODE->ViewAttributes() ?>>
<?php echo $lov_amphur->AMPHUR_CODE->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->FormValue) ?>">
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($lov_amphur->PROVINCE_ID->Visible) { // PROVINCE_ID ?>
		<td data-name="PROVINCE_ID"<?php echo $lov_amphur->PROVINCE_ID->CellAttributes() ?>>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($lov_amphur->PROVINCE_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<span<?php echo $lov_amphur->PROVINCE_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->PROVINCE_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $lov_amphur->PROVINCE_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $lov_amphur->PROVINCE_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lov_amphur->PROVINCE_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($lov_amphur->PROVINCE_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>" checked<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $lov_amphur->PROVINCE_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" class="ewTemplate"><input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_amphur->PROVINCE_ID->DisplayValueSeparator) ? json_encode($lov_amphur->PROVINCE_ID->DisplayValueSeparator) : $lov_amphur->PROVINCE_ID->DisplayValueSeparator) ?>" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="{value}"<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
$sWhereWrk = "";
$lov_amphur->PROVINCE_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$lov_amphur->PROVINCE_ID->LookupFilters += array("f0" => "`PROVINCE_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$lov_amphur->Lookup_Selecting($lov_amphur->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
if ($sSqlWrk <> "") $lov_amphur->PROVINCE_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="s_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo $lov_amphur->PROVINCE_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="o<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="o<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->OldValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($lov_amphur->PROVINCE_ID->getSessionValue() <> "") { ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<span<?php echo $lov_amphur->PROVINCE_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->PROVINCE_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $lov_amphur->PROVINCE_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $lov_amphur->PROVINCE_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lov_amphur->PROVINCE_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($lov_amphur->PROVINCE_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>" checked<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $lov_amphur->PROVINCE_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" class="ewTemplate"><input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_amphur->PROVINCE_ID->DisplayValueSeparator) ? json_encode($lov_amphur->PROVINCE_ID->DisplayValueSeparator) : $lov_amphur->PROVINCE_ID->DisplayValueSeparator) ?>" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="{value}"<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
$sWhereWrk = "";
$lov_amphur->PROVINCE_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$lov_amphur->PROVINCE_ID->LookupFilters += array("f0" => "`PROVINCE_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$lov_amphur->Lookup_Selecting($lov_amphur->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
if ($sSqlWrk <> "") $lov_amphur->PROVINCE_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="s_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo $lov_amphur->PROVINCE_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_PROVINCE_ID" class="lov_amphur_PROVINCE_ID">
<span<?php echo $lov_amphur->PROVINCE_ID->ViewAttributes() ?>>
<?php echo $lov_amphur->PROVINCE_ID->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->FormValue) ?>">
<input type="hidden" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="o<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="o<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($lov_amphur->AMPHUR_NAME->Visible) { // AMPHUR_NAME ?>
		<td data-name="AMPHUR_NAME"<?php echo $lov_amphur->AMPHUR_NAME->CellAttributes() ?>>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_NAME" class="form-group lov_amphur_AMPHUR_NAME">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_NAME->EditValue ?>"<?php echo $lov_amphur->AMPHUR_NAME->EditAttributes() ?>>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->OldValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_NAME" class="form-group lov_amphur_AMPHUR_NAME">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_NAME->EditValue ?>"<?php echo $lov_amphur->AMPHUR_NAME->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPHUR_NAME" class="lov_amphur_AMPHUR_NAME">
<span<?php echo $lov_amphur->AMPHUR_NAME->ViewAttributes() ?>>
<?php echo $lov_amphur->AMPHUR_NAME->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->FormValue) ?>">
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($lov_amphur->AMPER_NAME_EN->Visible) { // AMPER_NAME_EN ?>
		<td data-name="AMPER_NAME_EN"<?php echo $lov_amphur->AMPER_NAME_EN->CellAttributes() ?>>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPER_NAME_EN" class="form-group lov_amphur_AMPER_NAME_EN">
<input type="text" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPER_NAME_EN->EditValue ?>"<?php echo $lov_amphur->AMPER_NAME_EN->EditAttributes() ?>>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" value="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->OldValue) ?>">
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPER_NAME_EN" class="form-group lov_amphur_AMPER_NAME_EN">
<input type="text" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPER_NAME_EN->EditValue ?>"<?php echo $lov_amphur->AMPER_NAME_EN->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $lov_amphur_grid->RowCnt ?>_lov_amphur_AMPER_NAME_EN" class="lov_amphur_AMPER_NAME_EN">
<span<?php echo $lov_amphur->AMPER_NAME_EN->ViewAttributes() ?>>
<?php echo $lov_amphur->AMPER_NAME_EN->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" value="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->FormValue) ?>">
<input type="hidden" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" value="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lov_amphur_grid->ListOptions->Render("body", "right", $lov_amphur_grid->RowCnt);
?>
	</tr>
<?php if ($lov_amphur->RowType == EW_ROWTYPE_ADD || $lov_amphur->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
flov_amphurgrid.UpdateOpts(<?php echo $lov_amphur_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($lov_amphur->CurrentAction <> "gridadd" || $lov_amphur->CurrentMode == "copy")
		if (!$lov_amphur_grid->Recordset->EOF) $lov_amphur_grid->Recordset->MoveNext();
}
?>
<?php
	if ($lov_amphur->CurrentMode == "add" || $lov_amphur->CurrentMode == "copy" || $lov_amphur->CurrentMode == "edit") {
		$lov_amphur_grid->RowIndex = '$rowindex$';
		$lov_amphur_grid->LoadDefaultValues();

		// Set row properties
		$lov_amphur->ResetAttrs();
		$lov_amphur->RowAttrs = array_merge($lov_amphur->RowAttrs, array('data-rowindex'=>$lov_amphur_grid->RowIndex, 'id'=>'r0_lov_amphur', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($lov_amphur->RowAttrs["class"], "ewTemplate");
		$lov_amphur->RowType = EW_ROWTYPE_ADD;

		// Render row
		$lov_amphur_grid->RenderRow();

		// Render list options
		$lov_amphur_grid->RenderListOptions();
		$lov_amphur_grid->StartRowCnt = 0;
?>
	<tr<?php echo $lov_amphur->RowAttributes() ?>>
<?php

// Render list options (body, left)
$lov_amphur_grid->ListOptions->Render("body", "left", $lov_amphur_grid->RowIndex);
?>
	<?php if ($lov_amphur->AMPHUR_ID->Visible) { // AMPHUR_ID ?>
		<td data-name="AMPHUR_ID">
<?php if ($lov_amphur->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_lov_amphur_AMPHUR_ID" class="form-group lov_amphur_AMPHUR_ID">
<span<?php echo $lov_amphur->AMPHUR_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->AMPHUR_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_ID" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_ID" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($lov_amphur->AMPHUR_CODE->Visible) { // AMPHUR_CODE ?>
		<td data-name="AMPHUR_CODE">
<?php if ($lov_amphur->CurrentAction <> "F") { ?>
<span id="el$rowindex$_lov_amphur_AMPHUR_CODE" class="form-group lov_amphur_AMPHUR_CODE">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_CODE->EditValue ?>"<?php echo $lov_amphur->AMPHUR_CODE->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_lov_amphur_AMPHUR_CODE" class="form-group lov_amphur_AMPHUR_CODE">
<span<?php echo $lov_amphur->AMPHUR_CODE->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->AMPHUR_CODE->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_CODE" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($lov_amphur->PROVINCE_ID->Visible) { // PROVINCE_ID ?>
		<td data-name="PROVINCE_ID">
<?php if ($lov_amphur->CurrentAction <> "F") { ?>
<?php if ($lov_amphur->PROVINCE_ID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<span<?php echo $lov_amphur->PROVINCE_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->PROVINCE_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $lov_amphur->PROVINCE_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $lov_amphur->PROVINCE_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lov_amphur->PROVINCE_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($lov_amphur->PROVINCE_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>" checked<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $lov_amphur->PROVINCE_ID->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" class="ewTemplate"><input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_amphur->PROVINCE_ID->DisplayValueSeparator) ? json_encode($lov_amphur->PROVINCE_ID->DisplayValueSeparator) : $lov_amphur->PROVINCE_ID->DisplayValueSeparator) ?>" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="{value}"<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
$sWhereWrk = "";
$lov_amphur->PROVINCE_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$lov_amphur->PROVINCE_ID->LookupFilters += array("f0" => "`PROVINCE_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$lov_amphur->Lookup_Selecting($lov_amphur->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
if ($sSqlWrk <> "") $lov_amphur->PROVINCE_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="s_x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo $lov_amphur->PROVINCE_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_lov_amphur_PROVINCE_ID" class="form-group lov_amphur_PROVINCE_ID">
<span<?php echo $lov_amphur->PROVINCE_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->PROVINCE_ID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="x<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="o<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" id="o<?php echo $lov_amphur_grid->RowIndex ?>_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($lov_amphur->AMPHUR_NAME->Visible) { // AMPHUR_NAME ?>
		<td data-name="AMPHUR_NAME">
<?php if ($lov_amphur->CurrentAction <> "F") { ?>
<span id="el$rowindex$_lov_amphur_AMPHUR_NAME" class="form-group lov_amphur_AMPHUR_NAME">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_NAME->EditValue ?>"<?php echo $lov_amphur->AMPHUR_NAME->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_lov_amphur_AMPHUR_NAME" class="form-group lov_amphur_AMPHUR_NAME">
<span<?php echo $lov_amphur->AMPHUR_NAME->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->AMPHUR_NAME->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPHUR_NAME" value="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($lov_amphur->AMPER_NAME_EN->Visible) { // AMPER_NAME_EN ?>
		<td data-name="AMPER_NAME_EN">
<?php if ($lov_amphur->CurrentAction <> "F") { ?>
<span id="el$rowindex$_lov_amphur_AMPER_NAME_EN" class="form-group lov_amphur_AMPER_NAME_EN">
<input type="text" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPER_NAME_EN->EditValue ?>"<?php echo $lov_amphur->AMPER_NAME_EN->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_lov_amphur_AMPER_NAME_EN" class="form-group lov_amphur_AMPER_NAME_EN">
<span<?php echo $lov_amphur->AMPER_NAME_EN->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->AMPER_NAME_EN->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="x<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" value="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" id="o<?php echo $lov_amphur_grid->RowIndex ?>_AMPER_NAME_EN" value="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lov_amphur_grid->ListOptions->Render("body", "right", $lov_amphur_grid->RowCnt);
?>
<script type="text/javascript">
flov_amphurgrid.UpdateOpts(<?php echo $lov_amphur_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($lov_amphur->CurrentMode == "add" || $lov_amphur->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $lov_amphur_grid->FormKeyCountName ?>" id="<?php echo $lov_amphur_grid->FormKeyCountName ?>" value="<?php echo $lov_amphur_grid->KeyCount ?>">
<?php echo $lov_amphur_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($lov_amphur->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $lov_amphur_grid->FormKeyCountName ?>" id="<?php echo $lov_amphur_grid->FormKeyCountName ?>" value="<?php echo $lov_amphur_grid->KeyCount ?>">
<?php echo $lov_amphur_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($lov_amphur->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="flov_amphurgrid">
</div>
<?php

// Close recordset
if ($lov_amphur_grid->Recordset)
	$lov_amphur_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($lov_amphur_grid->TotalRecs == 0 && $lov_amphur->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($lov_amphur_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($lov_amphur->Export == "") { ?>
<script type="text/javascript">
flov_amphurgrid.Init();
</script>
<?php } ?>
<?php
$lov_amphur_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$lov_amphur_grid->Page_Terminate();
?>
