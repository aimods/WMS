<?php include_once "main_user_info.php" ?>
<?php

// Create page object
if (!isset($StockCard_grid)) $StockCard_grid = new cStockCard_grid();

// Page init
$StockCard_grid->Page_Init();

// Page main
$StockCard_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$StockCard_grid->Page_Render();
?>
<?php if ($StockCard->Export == "") { ?>
<script type="text/javascript">

// Form object
var fStockCardgrid = new ew_Form("fStockCardgrid", "grid");
fStockCardgrid.FormKeyCountName = '<?php echo $StockCard_grid->FormKeyCountName ?>';

// Validate form
fStockCardgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_PartNo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $StockCard->PartNo->FldCaption(), $StockCard->PartNo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ProductName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $StockCard->ProductName->FldCaption(), $StockCard->ProductName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $StockCard->Status->FldCaption(), $StockCard->Status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Items");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($StockCard->Items->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fStockCardgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "PartNo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ProductName", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Items", false)) return false;
	return true;
}

// Form_CustomValidate event
fStockCardgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fStockCardgrid.ValidateRequired = true;
<?php } else { ?>
fStockCardgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($StockCard->CurrentAction == "gridadd") {
	if ($StockCard->CurrentMode == "copy") {
		$bSelectLimit = $StockCard_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$StockCard_grid->TotalRecs = $StockCard->SelectRecordCount();
			$StockCard_grid->Recordset = $StockCard_grid->LoadRecordset($StockCard_grid->StartRec-1, $StockCard_grid->DisplayRecs);
		} else {
			if ($StockCard_grid->Recordset = $StockCard_grid->LoadRecordset())
				$StockCard_grid->TotalRecs = $StockCard_grid->Recordset->RecordCount();
		}
		$StockCard_grid->StartRec = 1;
		$StockCard_grid->DisplayRecs = $StockCard_grid->TotalRecs;
	} else {
		$StockCard->CurrentFilter = "0=1";
		$StockCard_grid->StartRec = 1;
		$StockCard_grid->DisplayRecs = $StockCard->GridAddRowCount;
	}
	$StockCard_grid->TotalRecs = $StockCard_grid->DisplayRecs;
	$StockCard_grid->StopRec = $StockCard_grid->DisplayRecs;
} else {
	$bSelectLimit = $StockCard_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($StockCard_grid->TotalRecs <= 0)
			$StockCard_grid->TotalRecs = $StockCard->SelectRecordCount();
	} else {
		if (!$StockCard_grid->Recordset && ($StockCard_grid->Recordset = $StockCard_grid->LoadRecordset()))
			$StockCard_grid->TotalRecs = $StockCard_grid->Recordset->RecordCount();
	}
	$StockCard_grid->StartRec = 1;
	$StockCard_grid->DisplayRecs = $StockCard_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$StockCard_grid->Recordset = $StockCard_grid->LoadRecordset($StockCard_grid->StartRec-1, $StockCard_grid->DisplayRecs);

	// Set no record found message
	if ($StockCard->CurrentAction == "" && $StockCard_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$StockCard_grid->setWarningMessage(ew_DeniedMsg());
		if ($StockCard_grid->SearchWhere == "0=101")
			$StockCard_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$StockCard_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$StockCard_grid->RenderOtherOptions();
?>
<?php $StockCard_grid->ShowPageHeader(); ?>
<?php
$StockCard_grid->ShowMessage();
?>
<?php if ($StockCard_grid->TotalRecs > 0 || $StockCard->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fStockCardgrid" class="ewForm form-inline">
<?php if ($StockCard_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($StockCard_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_StockCard" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_StockCardgrid" class="table ewTable">
<?php echo $StockCard->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$StockCard_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$StockCard_grid->RenderListOptions();

// Render list options (header, left)
$StockCard_grid->ListOptions->Render("header", "left");
?>
<?php if ($StockCard->PartNo->Visible) { // PartNo ?>
	<?php if ($StockCard->SortUrl($StockCard->PartNo) == "") { ?>
		<th data-name="PartNo"><div id="elh_StockCard_PartNo" class="StockCard_PartNo"><div class="ewTableHeaderCaption"><?php echo $StockCard->PartNo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PartNo"><div><div id="elh_StockCard_PartNo" class="StockCard_PartNo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $StockCard->PartNo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($StockCard->PartNo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($StockCard->PartNo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($StockCard->ProductName->Visible) { // ProductName ?>
	<?php if ($StockCard->SortUrl($StockCard->ProductName) == "") { ?>
		<th data-name="ProductName"><div id="elh_StockCard_ProductName" class="StockCard_ProductName"><div class="ewTableHeaderCaption"><?php echo $StockCard->ProductName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ProductName"><div><div id="elh_StockCard_ProductName" class="StockCard_ProductName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $StockCard->ProductName->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($StockCard->ProductName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($StockCard->ProductName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($StockCard->Status->Visible) { // Status ?>
	<?php if ($StockCard->SortUrl($StockCard->Status) == "") { ?>
		<th data-name="Status"><div id="elh_StockCard_Status" class="StockCard_Status"><div class="ewTableHeaderCaption"><?php echo $StockCard->Status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Status"><div><div id="elh_StockCard_Status" class="StockCard_Status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $StockCard->Status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($StockCard->Status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($StockCard->Status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($StockCard->Items->Visible) { // Items ?>
	<?php if ($StockCard->SortUrl($StockCard->Items) == "") { ?>
		<th data-name="Items"><div id="elh_StockCard_Items" class="StockCard_Items"><div class="ewTableHeaderCaption"><?php echo $StockCard->Items->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Items"><div><div id="elh_StockCard_Items" class="StockCard_Items">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $StockCard->Items->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($StockCard->Items->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($StockCard->Items->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$StockCard_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$StockCard_grid->StartRec = 1;
$StockCard_grid->StopRec = $StockCard_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($StockCard_grid->FormKeyCountName) && ($StockCard->CurrentAction == "gridadd" || $StockCard->CurrentAction == "gridedit" || $StockCard->CurrentAction == "F")) {
		$StockCard_grid->KeyCount = $objForm->GetValue($StockCard_grid->FormKeyCountName);
		$StockCard_grid->StopRec = $StockCard_grid->StartRec + $StockCard_grid->KeyCount - 1;
	}
}
$StockCard_grid->RecCnt = $StockCard_grid->StartRec - 1;
if ($StockCard_grid->Recordset && !$StockCard_grid->Recordset->EOF) {
	$StockCard_grid->Recordset->MoveFirst();
	$bSelectLimit = $StockCard_grid->UseSelectLimit;
	if (!$bSelectLimit && $StockCard_grid->StartRec > 1)
		$StockCard_grid->Recordset->Move($StockCard_grid->StartRec - 1);
} elseif (!$StockCard->AllowAddDeleteRow && $StockCard_grid->StopRec == 0) {
	$StockCard_grid->StopRec = $StockCard->GridAddRowCount;
}

// Initialize aggregate
$StockCard->RowType = EW_ROWTYPE_AGGREGATEINIT;
$StockCard->ResetAttrs();
$StockCard_grid->RenderRow();
if ($StockCard->CurrentAction == "gridadd")
	$StockCard_grid->RowIndex = 0;
if ($StockCard->CurrentAction == "gridedit")
	$StockCard_grid->RowIndex = 0;
while ($StockCard_grid->RecCnt < $StockCard_grid->StopRec) {
	$StockCard_grid->RecCnt++;
	if (intval($StockCard_grid->RecCnt) >= intval($StockCard_grid->StartRec)) {
		$StockCard_grid->RowCnt++;
		if ($StockCard->CurrentAction == "gridadd" || $StockCard->CurrentAction == "gridedit" || $StockCard->CurrentAction == "F") {
			$StockCard_grid->RowIndex++;
			$objForm->Index = $StockCard_grid->RowIndex;
			if ($objForm->HasValue($StockCard_grid->FormActionName))
				$StockCard_grid->RowAction = strval($objForm->GetValue($StockCard_grid->FormActionName));
			elseif ($StockCard->CurrentAction == "gridadd")
				$StockCard_grid->RowAction = "insert";
			else
				$StockCard_grid->RowAction = "";
		}

		// Set up key count
		$StockCard_grid->KeyCount = $StockCard_grid->RowIndex;

		// Init row class and style
		$StockCard->ResetAttrs();
		$StockCard->CssClass = "";
		if ($StockCard->CurrentAction == "gridadd") {
			if ($StockCard->CurrentMode == "copy") {
				$StockCard_grid->LoadRowValues($StockCard_grid->Recordset); // Load row values
				$StockCard_grid->SetRecordKey($StockCard_grid->RowOldKey, $StockCard_grid->Recordset); // Set old record key
			} else {
				$StockCard_grid->LoadDefaultValues(); // Load default values
				$StockCard_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$StockCard_grid->LoadRowValues($StockCard_grid->Recordset); // Load row values
		}
		$StockCard->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($StockCard->CurrentAction == "gridadd") // Grid add
			$StockCard->RowType = EW_ROWTYPE_ADD; // Render add
		if ($StockCard->CurrentAction == "gridadd" && $StockCard->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$StockCard_grid->RestoreCurrentRowFormValues($StockCard_grid->RowIndex); // Restore form values
		if ($StockCard->CurrentAction == "gridedit") { // Grid edit
			if ($StockCard->EventCancelled) {
				$StockCard_grid->RestoreCurrentRowFormValues($StockCard_grid->RowIndex); // Restore form values
			}
			if ($StockCard_grid->RowAction == "insert")
				$StockCard->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$StockCard->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($StockCard->CurrentAction == "gridedit" && ($StockCard->RowType == EW_ROWTYPE_EDIT || $StockCard->RowType == EW_ROWTYPE_ADD) && $StockCard->EventCancelled) // Update failed
			$StockCard_grid->RestoreCurrentRowFormValues($StockCard_grid->RowIndex); // Restore form values
		if ($StockCard->RowType == EW_ROWTYPE_EDIT) // Edit row
			$StockCard_grid->EditRowCnt++;
		if ($StockCard->CurrentAction == "F") // Confirm row
			$StockCard_grid->RestoreCurrentRowFormValues($StockCard_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$StockCard->RowAttrs = array_merge($StockCard->RowAttrs, array('data-rowindex'=>$StockCard_grid->RowCnt, 'id'=>'r' . $StockCard_grid->RowCnt . '_StockCard', 'data-rowtype'=>$StockCard->RowType));

		// Render row
		$StockCard_grid->RenderRow();

		// Render list options
		$StockCard_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($StockCard_grid->RowAction <> "delete" && $StockCard_grid->RowAction <> "insertdelete" && !($StockCard_grid->RowAction == "insert" && $StockCard->CurrentAction == "F" && $StockCard_grid->EmptyRow())) {
?>
	<tr<?php echo $StockCard->RowAttributes() ?>>
<?php

// Render list options (body, left)
$StockCard_grid->ListOptions->Render("body", "left", $StockCard_grid->RowCnt);
?>
	<?php if ($StockCard->PartNo->Visible) { // PartNo ?>
		<td data-name="PartNo"<?php echo $StockCard->PartNo->CellAttributes() ?>>
<?php if ($StockCard->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_PartNo" class="form-group StockCard_PartNo">
<input type="text" data-table="StockCard" data-field="x_PartNo" name="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($StockCard->PartNo->getPlaceHolder()) ?>" value="<?php echo $StockCard->PartNo->EditValue ?>"<?php echo $StockCard->PartNo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="StockCard" data-field="x_PartNo" name="o<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="o<?php echo $StockCard_grid->RowIndex ?>_PartNo" value="<?php echo ew_HtmlEncode($StockCard->PartNo->OldValue) ?>">
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_PartNo" class="form-group StockCard_PartNo">
<span<?php echo $StockCard->PartNo->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($StockCard->PartNo->EditValue)) && $StockCard->PartNo->LinkAttributes() <> "") { ?>
<a<?php echo $StockCard->PartNo->LinkAttributes() ?>><p class="form-control-static"><?php echo $StockCard->PartNo->EditValue ?></p></a>
<?php } else { ?>
<p class="form-control-static"><?php echo $StockCard->PartNo->EditValue ?></p>
<?php } ?>
</span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_PartNo" name="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" value="<?php echo ew_HtmlEncode($StockCard->PartNo->CurrentValue) ?>">
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_PartNo" class="StockCard_PartNo">
<span<?php echo $StockCard->PartNo->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($StockCard->PartNo->ListViewValue())) && $StockCard->PartNo->LinkAttributes() <> "") { ?>
<a<?php echo $StockCard->PartNo->LinkAttributes() ?>><?php echo $StockCard->PartNo->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $StockCard->PartNo->ListViewValue() ?>
<?php } ?>
</span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_PartNo" name="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" value="<?php echo ew_HtmlEncode($StockCard->PartNo->FormValue) ?>">
<input type="hidden" data-table="StockCard" data-field="x_PartNo" name="o<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="o<?php echo $StockCard_grid->RowIndex ?>_PartNo" value="<?php echo ew_HtmlEncode($StockCard->PartNo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $StockCard_grid->PageObjName . "_row_" . $StockCard_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($StockCard->ProductName->Visible) { // ProductName ?>
		<td data-name="ProductName"<?php echo $StockCard->ProductName->CellAttributes() ?>>
<?php if ($StockCard->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_ProductName" class="form-group StockCard_ProductName">
<input type="text" data-table="StockCard" data-field="x_ProductName" name="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($StockCard->ProductName->getPlaceHolder()) ?>" value="<?php echo $StockCard->ProductName->EditValue ?>"<?php echo $StockCard->ProductName->EditAttributes() ?>>
</span>
<input type="hidden" data-table="StockCard" data-field="x_ProductName" name="o<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="o<?php echo $StockCard_grid->RowIndex ?>_ProductName" value="<?php echo ew_HtmlEncode($StockCard->ProductName->OldValue) ?>">
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_ProductName" class="form-group StockCard_ProductName">
<span<?php echo $StockCard->ProductName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $StockCard->ProductName->EditValue ?></p></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_ProductName" name="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" value="<?php echo ew_HtmlEncode($StockCard->ProductName->CurrentValue) ?>">
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_ProductName" class="StockCard_ProductName">
<span<?php echo $StockCard->ProductName->ViewAttributes() ?>>
<?php echo $StockCard->ProductName->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_ProductName" name="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" value="<?php echo ew_HtmlEncode($StockCard->ProductName->FormValue) ?>">
<input type="hidden" data-table="StockCard" data-field="x_ProductName" name="o<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="o<?php echo $StockCard_grid->RowIndex ?>_ProductName" value="<?php echo ew_HtmlEncode($StockCard->ProductName->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($StockCard->Status->Visible) { // Status ?>
		<td data-name="Status"<?php echo $StockCard->Status->CellAttributes() ?>>
<?php if ($StockCard->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_Status" class="form-group StockCard_Status">
<input type="text" data-table="StockCard" data-field="x_Status" name="x<?php echo $StockCard_grid->RowIndex ?>_Status" id="x<?php echo $StockCard_grid->RowIndex ?>_Status" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($StockCard->Status->getPlaceHolder()) ?>" value="<?php echo $StockCard->Status->EditValue ?>"<?php echo $StockCard->Status->EditAttributes() ?>>
</span>
<input type="hidden" data-table="StockCard" data-field="x_Status" name="o<?php echo $StockCard_grid->RowIndex ?>_Status" id="o<?php echo $StockCard_grid->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($StockCard->Status->OldValue) ?>">
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_Status" class="form-group StockCard_Status">
<input type="text" data-table="StockCard" data-field="x_Status" name="x<?php echo $StockCard_grid->RowIndex ?>_Status" id="x<?php echo $StockCard_grid->RowIndex ?>_Status" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($StockCard->Status->getPlaceHolder()) ?>" value="<?php echo $StockCard->Status->EditValue ?>"<?php echo $StockCard->Status->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_Status" class="StockCard_Status">
<span<?php echo $StockCard->Status->ViewAttributes() ?>>
<?php echo $StockCard->Status->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_Status" name="x<?php echo $StockCard_grid->RowIndex ?>_Status" id="x<?php echo $StockCard_grid->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($StockCard->Status->FormValue) ?>">
<input type="hidden" data-table="StockCard" data-field="x_Status" name="o<?php echo $StockCard_grid->RowIndex ?>_Status" id="o<?php echo $StockCard_grid->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($StockCard->Status->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($StockCard->Items->Visible) { // Items ?>
		<td data-name="Items"<?php echo $StockCard->Items->CellAttributes() ?>>
<?php if ($StockCard->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_Items" class="form-group StockCard_Items">
<input type="text" data-table="StockCard" data-field="x_Items" name="x<?php echo $StockCard_grid->RowIndex ?>_Items" id="x<?php echo $StockCard_grid->RowIndex ?>_Items" size="30" placeholder="<?php echo ew_HtmlEncode($StockCard->Items->getPlaceHolder()) ?>" value="<?php echo $StockCard->Items->EditValue ?>"<?php echo $StockCard->Items->EditAttributes() ?>>
</span>
<input type="hidden" data-table="StockCard" data-field="x_Items" name="o<?php echo $StockCard_grid->RowIndex ?>_Items" id="o<?php echo $StockCard_grid->RowIndex ?>_Items" value="<?php echo ew_HtmlEncode($StockCard->Items->OldValue) ?>">
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_Items" class="form-group StockCard_Items">
<input type="text" data-table="StockCard" data-field="x_Items" name="x<?php echo $StockCard_grid->RowIndex ?>_Items" id="x<?php echo $StockCard_grid->RowIndex ?>_Items" size="30" placeholder="<?php echo ew_HtmlEncode($StockCard->Items->getPlaceHolder()) ?>" value="<?php echo $StockCard->Items->EditValue ?>"<?php echo $StockCard->Items->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($StockCard->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $StockCard_grid->RowCnt ?>_StockCard_Items" class="StockCard_Items">
<span<?php echo $StockCard->Items->ViewAttributes() ?>>
<?php echo $StockCard->Items->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_Items" name="x<?php echo $StockCard_grid->RowIndex ?>_Items" id="x<?php echo $StockCard_grid->RowIndex ?>_Items" value="<?php echo ew_HtmlEncode($StockCard->Items->FormValue) ?>">
<input type="hidden" data-table="StockCard" data-field="x_Items" name="o<?php echo $StockCard_grid->RowIndex ?>_Items" id="o<?php echo $StockCard_grid->RowIndex ?>_Items" value="<?php echo ew_HtmlEncode($StockCard->Items->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$StockCard_grid->ListOptions->Render("body", "right", $StockCard_grid->RowCnt);
?>
	</tr>
<?php if ($StockCard->RowType == EW_ROWTYPE_ADD || $StockCard->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fStockCardgrid.UpdateOpts(<?php echo $StockCard_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($StockCard->CurrentAction <> "gridadd" || $StockCard->CurrentMode == "copy")
		if (!$StockCard_grid->Recordset->EOF) $StockCard_grid->Recordset->MoveNext();
}
?>
<?php
	if ($StockCard->CurrentMode == "add" || $StockCard->CurrentMode == "copy" || $StockCard->CurrentMode == "edit") {
		$StockCard_grid->RowIndex = '$rowindex$';
		$StockCard_grid->LoadDefaultValues();

		// Set row properties
		$StockCard->ResetAttrs();
		$StockCard->RowAttrs = array_merge($StockCard->RowAttrs, array('data-rowindex'=>$StockCard_grid->RowIndex, 'id'=>'r0_StockCard', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($StockCard->RowAttrs["class"], "ewTemplate");
		$StockCard->RowType = EW_ROWTYPE_ADD;

		// Render row
		$StockCard_grid->RenderRow();

		// Render list options
		$StockCard_grid->RenderListOptions();
		$StockCard_grid->StartRowCnt = 0;
?>
	<tr<?php echo $StockCard->RowAttributes() ?>>
<?php

// Render list options (body, left)
$StockCard_grid->ListOptions->Render("body", "left", $StockCard_grid->RowIndex);
?>
	<?php if ($StockCard->PartNo->Visible) { // PartNo ?>
		<td data-name="PartNo">
<?php if ($StockCard->CurrentAction <> "F") { ?>
<span id="el$rowindex$_StockCard_PartNo" class="form-group StockCard_PartNo">
<input type="text" data-table="StockCard" data-field="x_PartNo" name="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($StockCard->PartNo->getPlaceHolder()) ?>" value="<?php echo $StockCard->PartNo->EditValue ?>"<?php echo $StockCard->PartNo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_StockCard_PartNo" class="form-group StockCard_PartNo">
<span<?php echo $StockCard->PartNo->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($StockCard->PartNo->ViewValue)) && $StockCard->PartNo->LinkAttributes() <> "") { ?>
<a<?php echo $StockCard->PartNo->LinkAttributes() ?>><p class="form-control-static"><?php echo $StockCard->PartNo->ViewValue ?></p></a>
<?php } else { ?>
<p class="form-control-static"><?php echo $StockCard->PartNo->ViewValue ?></p>
<?php } ?>
</span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_PartNo" name="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="x<?php echo $StockCard_grid->RowIndex ?>_PartNo" value="<?php echo ew_HtmlEncode($StockCard->PartNo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="StockCard" data-field="x_PartNo" name="o<?php echo $StockCard_grid->RowIndex ?>_PartNo" id="o<?php echo $StockCard_grid->RowIndex ?>_PartNo" value="<?php echo ew_HtmlEncode($StockCard->PartNo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($StockCard->ProductName->Visible) { // ProductName ?>
		<td data-name="ProductName">
<?php if ($StockCard->CurrentAction <> "F") { ?>
<span id="el$rowindex$_StockCard_ProductName" class="form-group StockCard_ProductName">
<input type="text" data-table="StockCard" data-field="x_ProductName" name="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($StockCard->ProductName->getPlaceHolder()) ?>" value="<?php echo $StockCard->ProductName->EditValue ?>"<?php echo $StockCard->ProductName->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_StockCard_ProductName" class="form-group StockCard_ProductName">
<span<?php echo $StockCard->ProductName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $StockCard->ProductName->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_ProductName" name="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="x<?php echo $StockCard_grid->RowIndex ?>_ProductName" value="<?php echo ew_HtmlEncode($StockCard->ProductName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="StockCard" data-field="x_ProductName" name="o<?php echo $StockCard_grid->RowIndex ?>_ProductName" id="o<?php echo $StockCard_grid->RowIndex ?>_ProductName" value="<?php echo ew_HtmlEncode($StockCard->ProductName->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($StockCard->Status->Visible) { // Status ?>
		<td data-name="Status">
<?php if ($StockCard->CurrentAction <> "F") { ?>
<span id="el$rowindex$_StockCard_Status" class="form-group StockCard_Status">
<input type="text" data-table="StockCard" data-field="x_Status" name="x<?php echo $StockCard_grid->RowIndex ?>_Status" id="x<?php echo $StockCard_grid->RowIndex ?>_Status" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($StockCard->Status->getPlaceHolder()) ?>" value="<?php echo $StockCard->Status->EditValue ?>"<?php echo $StockCard->Status->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_StockCard_Status" class="form-group StockCard_Status">
<span<?php echo $StockCard->Status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $StockCard->Status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_Status" name="x<?php echo $StockCard_grid->RowIndex ?>_Status" id="x<?php echo $StockCard_grid->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($StockCard->Status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="StockCard" data-field="x_Status" name="o<?php echo $StockCard_grid->RowIndex ?>_Status" id="o<?php echo $StockCard_grid->RowIndex ?>_Status" value="<?php echo ew_HtmlEncode($StockCard->Status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($StockCard->Items->Visible) { // Items ?>
		<td data-name="Items">
<?php if ($StockCard->CurrentAction <> "F") { ?>
<span id="el$rowindex$_StockCard_Items" class="form-group StockCard_Items">
<input type="text" data-table="StockCard" data-field="x_Items" name="x<?php echo $StockCard_grid->RowIndex ?>_Items" id="x<?php echo $StockCard_grid->RowIndex ?>_Items" size="30" placeholder="<?php echo ew_HtmlEncode($StockCard->Items->getPlaceHolder()) ?>" value="<?php echo $StockCard->Items->EditValue ?>"<?php echo $StockCard->Items->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_StockCard_Items" class="form-group StockCard_Items">
<span<?php echo $StockCard->Items->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $StockCard->Items->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="StockCard" data-field="x_Items" name="x<?php echo $StockCard_grid->RowIndex ?>_Items" id="x<?php echo $StockCard_grid->RowIndex ?>_Items" value="<?php echo ew_HtmlEncode($StockCard->Items->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="StockCard" data-field="x_Items" name="o<?php echo $StockCard_grid->RowIndex ?>_Items" id="o<?php echo $StockCard_grid->RowIndex ?>_Items" value="<?php echo ew_HtmlEncode($StockCard->Items->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$StockCard_grid->ListOptions->Render("body", "right", $StockCard_grid->RowCnt);
?>
<script type="text/javascript">
fStockCardgrid.UpdateOpts(<?php echo $StockCard_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($StockCard->CurrentMode == "add" || $StockCard->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $StockCard_grid->FormKeyCountName ?>" id="<?php echo $StockCard_grid->FormKeyCountName ?>" value="<?php echo $StockCard_grid->KeyCount ?>">
<?php echo $StockCard_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($StockCard->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $StockCard_grid->FormKeyCountName ?>" id="<?php echo $StockCard_grid->FormKeyCountName ?>" value="<?php echo $StockCard_grid->KeyCount ?>">
<?php echo $StockCard_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($StockCard->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fStockCardgrid">
</div>
<?php

// Close recordset
if ($StockCard_grid->Recordset)
	$StockCard_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($StockCard_grid->TotalRecs == 0 && $StockCard->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($StockCard_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($StockCard->Export == "") { ?>
<script type="text/javascript">
fStockCardgrid.Init();
</script>
<?php } ?>
<?php
$StockCard_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$StockCard_grid->Page_Terminate();
?>
