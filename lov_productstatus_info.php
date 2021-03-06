<?php

// Global variable for table object
$lov_ProductStatus = NULL;

//
// Table class for lov_ProductStatus
//
class clov_ProductStatus extends cTable {
	var $ps_ID;
	var $ps_Name;
	var $ps_inWarranty;
	var $ps_DayofWarranty;
	var $ps_Created;
	var $ps_Updated;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'lov_ProductStatus';
		$this->TableName = 'lov_ProductStatus';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`lov_ProductStatus`";
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

		// ps_ID
		$this->ps_ID = new cField('lov_ProductStatus', 'lov_ProductStatus', 'x_ps_ID', 'ps_ID', '`ps_ID`', '`ps_ID`', 3, -1, FALSE, '`ps_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->ps_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps_ID'] = &$this->ps_ID;

		// ps_Name
		$this->ps_Name = new cField('lov_ProductStatus', 'lov_ProductStatus', 'x_ps_Name', 'ps_Name', '`ps_Name`', '`ps_Name`', 200, -1, FALSE, '`ps_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['ps_Name'] = &$this->ps_Name;

		// ps_inWarranty
		$this->ps_inWarranty = new cField('lov_ProductStatus', 'lov_ProductStatus', 'x_ps_inWarranty', 'ps_inWarranty', '`ps_inWarranty`', '`ps_inWarranty`', 16, -1, FALSE, '`ps_inWarranty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->ps_inWarranty->OptionCount = 2;
		$this->ps_inWarranty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps_inWarranty'] = &$this->ps_inWarranty;

		// ps_DayofWarranty
		$this->ps_DayofWarranty = new cField('lov_ProductStatus', 'lov_ProductStatus', 'x_ps_DayofWarranty', 'ps_DayofWarranty', '`ps_DayofWarranty`', '`ps_DayofWarranty`', 3, -1, FALSE, '`ps_DayofWarranty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps_DayofWarranty->FldDefaultErrMsg = str_replace(array("%1", "%2"), array("0", "2000"), $Language->Phrase("IncorrectRange"));
		$this->fields['ps_DayofWarranty'] = &$this->ps_DayofWarranty;

		// ps_Created
		$this->ps_Created = new cField('lov_ProductStatus', 'lov_ProductStatus', 'x_ps_Created', 'ps_Created', '`ps_Created`', 'DATE_FORMAT(`ps_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`ps_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['ps_Created'] = &$this->ps_Created;

		// ps_Updated
		$this->ps_Updated = new cField('lov_ProductStatus', 'lov_ProductStatus', 'x_ps_Updated', 'ps_Updated', '`ps_Updated`', 'DATE_FORMAT(`ps_Updated`, \'%d/%m/%Y\')', 135, 7, FALSE, '`ps_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps_Updated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['ps_Updated'] = &$this->ps_Updated;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`lov_ProductStatus`";
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
			if (array_key_exists('ps_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('ps_ID', $this->DBID) . '=' . ew_QuotedValue($rs['ps_ID'], $this->ps_ID->FldDataType, $this->DBID));
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
		return "`ps_ID` = @ps_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->ps_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@ps_ID@", ew_AdjustSql($this->ps_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "lov_productstatus_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "lov_productstatus_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("lov_productstatus_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("lov_productstatus_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "lov_productstatus_add.php?" . $this->UrlParm($parm);
		else
			$url = "lov_productstatus_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("lov_productstatus_edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("lov_productstatus_add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("lov_productstatus_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "ps_ID:" . ew_VarToJson($this->ps_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->ps_ID->CurrentValue)) {
			$sUrl .= "ps_ID=" . urlencode($this->ps_ID->CurrentValue);
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
			if ($isPost && isset($_POST["ps_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["ps_ID"]);
			elseif (isset($_GET["ps_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["ps_ID"]);
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
			$this->ps_ID->CurrentValue = $key;
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
		$this->ps_ID->setDbValue($rs->fields('ps_ID'));
		$this->ps_Name->setDbValue($rs->fields('ps_Name'));
		$this->ps_inWarranty->setDbValue($rs->fields('ps_inWarranty'));
		$this->ps_DayofWarranty->setDbValue($rs->fields('ps_DayofWarranty'));
		$this->ps_Created->setDbValue($rs->fields('ps_Created'));
		$this->ps_Updated->setDbValue($rs->fields('ps_Updated'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// ps_ID
		// ps_Name
		// ps_inWarranty
		// ps_DayofWarranty
		// ps_Created
		// ps_Updated
		// ps_ID

		$this->ps_ID->ViewValue = $this->ps_ID->CurrentValue;
		$this->ps_ID->ViewCustomAttributes = "";

		// ps_Name
		$this->ps_Name->ViewValue = $this->ps_Name->CurrentValue;
		$this->ps_Name->ViewCustomAttributes = "";

		// ps_inWarranty
		if (strval($this->ps_inWarranty->CurrentValue) <> "") {
			$this->ps_inWarranty->ViewValue = $this->ps_inWarranty->OptionCaption($this->ps_inWarranty->CurrentValue);
		} else {
			$this->ps_inWarranty->ViewValue = NULL;
		}
		$this->ps_inWarranty->ViewCustomAttributes = "";

		// ps_DayofWarranty
		$this->ps_DayofWarranty->ViewValue = $this->ps_DayofWarranty->CurrentValue;
		$this->ps_DayofWarranty->ViewCustomAttributes = "";

		// ps_Created
		$this->ps_Created->ViewValue = $this->ps_Created->CurrentValue;
		$this->ps_Created->ViewValue = ew_FormatDateTime($this->ps_Created->ViewValue, 7);
		$this->ps_Created->ViewCustomAttributes = "";

		// ps_Updated
		$this->ps_Updated->ViewValue = $this->ps_Updated->CurrentValue;
		$this->ps_Updated->ViewValue = ew_FormatDateTime($this->ps_Updated->ViewValue, 7);
		$this->ps_Updated->ViewCustomAttributes = "";

		// ps_ID
		$this->ps_ID->LinkCustomAttributes = "";
		$this->ps_ID->HrefValue = "";
		$this->ps_ID->TooltipValue = "";

		// ps_Name
		$this->ps_Name->LinkCustomAttributes = "";
		$this->ps_Name->HrefValue = "";
		$this->ps_Name->TooltipValue = "";

		// ps_inWarranty
		$this->ps_inWarranty->LinkCustomAttributes = "";
		$this->ps_inWarranty->HrefValue = "";
		$this->ps_inWarranty->TooltipValue = "";

		// ps_DayofWarranty
		$this->ps_DayofWarranty->LinkCustomAttributes = "";
		$this->ps_DayofWarranty->HrefValue = "";
		$this->ps_DayofWarranty->TooltipValue = "";

		// ps_Created
		$this->ps_Created->LinkCustomAttributes = "";
		$this->ps_Created->HrefValue = "";
		$this->ps_Created->TooltipValue = "";

		// ps_Updated
		$this->ps_Updated->LinkCustomAttributes = "";
		$this->ps_Updated->HrefValue = "";
		$this->ps_Updated->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// ps_ID
		$this->ps_ID->EditAttrs["class"] = "form-control";
		$this->ps_ID->EditCustomAttributes = "";
		$this->ps_ID->EditValue = $this->ps_ID->CurrentValue;
		$this->ps_ID->ViewCustomAttributes = "";

		// ps_Name
		$this->ps_Name->EditAttrs["class"] = "form-control";
		$this->ps_Name->EditCustomAttributes = "";
		$this->ps_Name->EditValue = $this->ps_Name->CurrentValue;
		$this->ps_Name->PlaceHolder = ew_RemoveHtml($this->ps_Name->FldCaption());

		// ps_inWarranty
		$this->ps_inWarranty->EditCustomAttributes = "";
		$this->ps_inWarranty->EditValue = $this->ps_inWarranty->Options(FALSE);

		// ps_DayofWarranty
		$this->ps_DayofWarranty->EditAttrs["class"] = "form-control";
		$this->ps_DayofWarranty->EditCustomAttributes = "";
		$this->ps_DayofWarranty->EditValue = $this->ps_DayofWarranty->CurrentValue;
		$this->ps_DayofWarranty->PlaceHolder = ew_RemoveHtml($this->ps_DayofWarranty->FldCaption());

		// ps_Created
		$this->ps_Created->EditAttrs["class"] = "form-control";
		$this->ps_Created->EditCustomAttributes = "";
		$this->ps_Created->EditValue = ew_FormatDateTime($this->ps_Created->CurrentValue, 7);
		$this->ps_Created->PlaceHolder = ew_RemoveHtml($this->ps_Created->FldCaption());

		// ps_Updated
		$this->ps_Updated->EditAttrs["class"] = "form-control";
		$this->ps_Updated->EditCustomAttributes = "";
		$this->ps_Updated->EditValue = ew_FormatDateTime($this->ps_Updated->CurrentValue, 7);
		$this->ps_Updated->PlaceHolder = ew_RemoveHtml($this->ps_Updated->FldCaption());

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
					if ($this->ps_Name->Exportable) $Doc->ExportCaption($this->ps_Name);
					if ($this->ps_inWarranty->Exportable) $Doc->ExportCaption($this->ps_inWarranty);
					if ($this->ps_DayofWarranty->Exportable) $Doc->ExportCaption($this->ps_DayofWarranty);
				} else {
					if ($this->ps_Name->Exportable) $Doc->ExportCaption($this->ps_Name);
					if ($this->ps_inWarranty->Exportable) $Doc->ExportCaption($this->ps_inWarranty);
					if ($this->ps_DayofWarranty->Exportable) $Doc->ExportCaption($this->ps_DayofWarranty);
					if ($this->ps_Created->Exportable) $Doc->ExportCaption($this->ps_Created);
					if ($this->ps_Updated->Exportable) $Doc->ExportCaption($this->ps_Updated);
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
						if ($this->ps_Name->Exportable) $Doc->ExportField($this->ps_Name);
						if ($this->ps_inWarranty->Exportable) $Doc->ExportField($this->ps_inWarranty);
						if ($this->ps_DayofWarranty->Exportable) $Doc->ExportField($this->ps_DayofWarranty);
					} else {
						if ($this->ps_Name->Exportable) $Doc->ExportField($this->ps_Name);
						if ($this->ps_inWarranty->Exportable) $Doc->ExportField($this->ps_inWarranty);
						if ($this->ps_DayofWarranty->Exportable) $Doc->ExportField($this->ps_DayofWarranty);
						if ($this->ps_Created->Exportable) $Doc->ExportField($this->ps_Created);
						if ($this->ps_Updated->Exportable) $Doc->ExportField($this->ps_Updated);
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
