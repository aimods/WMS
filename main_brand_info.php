<?php

// Global variable for table object
$main_Brand = NULL;

//
// Table class for main_Brand
//
class cmain_Brand extends cTable {
	var $b_ID;
	var $logo;
	var $b_Name;
	var $b_Note;
	var $b_LastUpdate;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'main_Brand';
		$this->TableName = 'main_Brand';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`main_Brand`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// b_ID
		$this->b_ID = new cField('main_Brand', 'main_Brand', 'x_b_ID', 'b_ID', '`b_ID`', '`b_ID`', 3, -1, FALSE, '`b_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->b_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_ID'] = &$this->b_ID;

		// logo
		$this->logo = new cField('main_Brand', 'main_Brand', 'x_logo', 'logo', '`logo`', '`logo`', 201, -1, TRUE, '`logo`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->logo->ImageResize = TRUE;
		$this->logo->UploadAllowedFileExt = "png, jpg, jpeg";
		$this->fields['logo'] = &$this->logo;

		// b_Name
		$this->b_Name = new cField('main_Brand', 'main_Brand', 'x_b_Name', 'b_Name', '`b_Name`', '`b_Name`', 200, -1, FALSE, '`b_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['b_Name'] = &$this->b_Name;

		// b_Note
		$this->b_Note = new cField('main_Brand', 'main_Brand', 'x_b_Note', 'b_Note', '`b_Note`', '`b_Note`', 201, -1, FALSE, '`b_Note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['b_Note'] = &$this->b_Note;

		// b_LastUpdate
		$this->b_LastUpdate = new cField('main_Brand', 'main_Brand', 'x_b_LastUpdate', 'b_LastUpdate', '`b_LastUpdate`', 'DATE_FORMAT(`b_LastUpdate`, \'%d/%m/%Y\')', 135, 7, FALSE, '`b_LastUpdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_LastUpdate->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['b_LastUpdate'] = &$this->b_LastUpdate;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "main_PartNum") {
			$sDetailUrl = $GLOBALS["main_PartNum"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_b_ID=" . urlencode($this->b_ID->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "main_brand_list.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`main_Brand`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('b_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('b_ID', $this->DBID) . '=' . ew_QuotedValue($rs['b_ID'], $this->b_ID->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`b_ID` = @b_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->b_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@b_ID@", ew_AdjustSql($this->b_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "main_brand_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "main_brand_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_brand_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_brand_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "main_brand_add.php?" . $this->UrlParm($parm);
		else
			$url = "main_brand_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_brand_edit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_brand_edit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_brand_add.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_brand_add.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("main_brand_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "b_ID:" . ew_VarToJson($this->b_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->b_ID->CurrentValue)) {
			$sUrl .= "b_ID=" . urlencode($this->b_ID->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["b_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["b_ID"]);
			elseif (isset($_GET["b_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["b_ID"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->b_ID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->b_ID->setDbValue($rs->fields('b_ID'));
		$this->logo->Upload->DbValue = $rs->fields('logo');
		$this->b_Name->setDbValue($rs->fields('b_Name'));
		$this->b_Note->setDbValue($rs->fields('b_Note'));
		$this->b_LastUpdate->setDbValue($rs->fields('b_LastUpdate'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// b_ID

		$this->b_ID->CellCssStyle = "white-space: nowrap;";

		// logo
		$this->logo->CellCssStyle = "white-space: nowrap;";

		// b_Name
		// b_Note
		// b_LastUpdate
		// b_ID

		$this->b_ID->ViewValue = $this->b_ID->CurrentValue;
		$this->b_ID->ViewCustomAttributes = "";

		// logo
		$this->logo->UploadPath = files/technica/logo;
		if (!ew_Empty($this->logo->Upload->DbValue)) {
			$this->logo->ImageWidth = 150;
			$this->logo->ImageHeight = 0;
			$this->logo->ImageAlt = $this->logo->FldAlt();
			$this->logo->ViewValue = $this->logo->Upload->DbValue;
		} else {
			$this->logo->ViewValue = "";
		}
		$this->logo->ViewCustomAttributes = "";

		// b_Name
		$this->b_Name->ViewValue = $this->b_Name->CurrentValue;
		$this->b_Name->ViewCustomAttributes = "";

		// b_Note
		$this->b_Note->ViewValue = $this->b_Note->CurrentValue;
		$this->b_Note->ViewCustomAttributes = "";

		// b_LastUpdate
		$this->b_LastUpdate->ViewValue = $this->b_LastUpdate->CurrentValue;
		$this->b_LastUpdate->ViewValue = ew_FormatDateTime($this->b_LastUpdate->ViewValue, 7);
		$this->b_LastUpdate->ViewCustomAttributes = "";

		// b_ID
		$this->b_ID->LinkCustomAttributes = "";
		$this->b_ID->HrefValue = "";
		$this->b_ID->TooltipValue = "";

		// logo
		$this->logo->LinkCustomAttributes = "";
		$this->logo->UploadPath = files/technica/logo;
		if (!ew_Empty($this->logo->Upload->DbValue)) {
			$this->logo->HrefValue = ew_GetFileUploadUrl($this->logo, $this->logo->Upload->DbValue); // Add prefix/suffix
			$this->logo->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->logo->HrefValue = ew_ConvertFullUrl($this->logo->HrefValue);
		} else {
			$this->logo->HrefValue = "";
		}
		$this->logo->HrefValue2 = $this->logo->UploadPath . $this->logo->Upload->DbValue;
		if ($this->Export == "") {
			$this->logo->TooltipValue = ($this->b_Name->ViewValue <> "") ? $this->b_Name->ViewValue : $this->b_Name->CurrentValue;
			$this->logo->TooltipWidth = 300;
			if ($this->logo->HrefValue == "") $this->logo->HrefValue = "javascript:void(0);";
			ew_AppendClass($this->logo->LinkAttrs["class"], "ewTooltipLink");
			$this->logo->LinkAttrs["data-tooltip-id"] = "tt_main_Brand_x" . (($this->RowType <> EW_ROWTYPE_MASTER) ? @$this->RowCnt : "") . "_logo";
			$this->logo->LinkAttrs["data-tooltip-width"] = $this->logo->TooltipWidth;
			$this->logo->LinkAttrs["data-placement"] = $GLOBALS["EW_CSS_FLIP"] ? "left" : "right";
		}
		if ($this->logo->UseColorbox) {
			if (ew_Empty($this->logo->TooltipValue))
				$this->logo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->logo->LinkAttrs["data-rel"] = "main_Brand_x_logo";
			ew_AppendClass($this->logo->LinkAttrs["class"], "ewLightbox");
		}

		// b_Name
		$this->b_Name->LinkCustomAttributes = "";
		$this->b_Name->HrefValue = "";
		$this->b_Name->TooltipValue = "";

		// b_Note
		$this->b_Note->LinkCustomAttributes = "";
		$this->b_Note->HrefValue = "";
		$this->b_Note->TooltipValue = "";

		// b_LastUpdate
		$this->b_LastUpdate->LinkCustomAttributes = "";
		$this->b_LastUpdate->HrefValue = "";
		$this->b_LastUpdate->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// b_ID
		$this->b_ID->EditAttrs["class"] = "form-control";
		$this->b_ID->EditCustomAttributes = "";
		$this->b_ID->EditValue = $this->b_ID->CurrentValue;
		$this->b_ID->ViewCustomAttributes = "";

		// logo
		$this->logo->EditAttrs["class"] = "form-control";
		$this->logo->EditCustomAttributes = "";
		$this->logo->UploadPath = files/technica/logo;
		if (!ew_Empty($this->logo->Upload->DbValue)) {
			$this->logo->ImageWidth = 150;
			$this->logo->ImageHeight = 0;
			$this->logo->ImageAlt = $this->logo->FldAlt();
			$this->logo->EditValue = $this->logo->Upload->DbValue;
		} else {
			$this->logo->EditValue = "";
		}
		if (!ew_Empty($this->logo->CurrentValue))
			$this->logo->Upload->FileName = $this->logo->CurrentValue;

		// b_Name
		$this->b_Name->EditAttrs["class"] = "form-control";
		$this->b_Name->EditCustomAttributes = "";
		$this->b_Name->EditValue = $this->b_Name->CurrentValue;
		$this->b_Name->PlaceHolder = ew_RemoveHtml($this->b_Name->FldCaption());

		// b_Note
		$this->b_Note->EditAttrs["class"] = "form-control";
		$this->b_Note->EditCustomAttributes = "";
		$this->b_Note->EditValue = $this->b_Note->CurrentValue;
		$this->b_Note->PlaceHolder = ew_RemoveHtml($this->b_Note->FldCaption());

		// b_LastUpdate
		$this->b_LastUpdate->EditAttrs["class"] = "form-control";
		$this->b_LastUpdate->EditCustomAttributes = "";
		$this->b_LastUpdate->EditValue = ew_FormatDateTime($this->b_LastUpdate->CurrentValue, 7);
		$this->b_LastUpdate->PlaceHolder = ew_RemoveHtml($this->b_LastUpdate->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->logo->Exportable) $Doc->ExportCaption($this->logo);
					if ($this->b_Name->Exportable) $Doc->ExportCaption($this->b_Name);
					if ($this->b_Note->Exportable) $Doc->ExportCaption($this->b_Note);
					if ($this->b_LastUpdate->Exportable) $Doc->ExportCaption($this->b_LastUpdate);
				} else {
					if ($this->b_Name->Exportable) $Doc->ExportCaption($this->b_Name);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->logo->Exportable) $Doc->ExportField($this->logo);
						if ($this->b_Name->Exportable) $Doc->ExportField($this->b_Name);
						if ($this->b_Note->Exportable) $Doc->ExportField($this->b_Note);
						if ($this->b_LastUpdate->Exportable) $Doc->ExportField($this->b_LastUpdate);
					} else {
						if ($this->b_Name->Exportable) $Doc->ExportField($this->b_Name);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
