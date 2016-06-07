<?php

// Global variable for table object
$lov_intStatus = NULL;

//
// Table class for lov_intStatus
//
class clov_intStatus extends cTable {
	var $in_ID;
	var $in_Name;
	var $in_isDeath;
	var $in_isSale;
	var $is_InternalUse;
	var $in_Created;
	var $in_Updated;
	var $in_Note;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'lov_intStatus';
		$this->TableName = 'lov_intStatus';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`lov_intStatus`";
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

		// in_ID
		$this->in_ID = new cField('lov_intStatus', 'lov_intStatus', 'x_in_ID', 'in_ID', '`in_ID`', '`in_ID`', 3, -1, FALSE, '`in_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->in_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['in_ID'] = &$this->in_ID;

		// in_Name
		$this->in_Name = new cField('lov_intStatus', 'lov_intStatus', 'x_in_Name', 'in_Name', '`in_Name`', '`in_Name`', 200, -1, FALSE, '`in_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['in_Name'] = &$this->in_Name;

		// in_isDeath
		$this->in_isDeath = new cField('lov_intStatus', 'lov_intStatus', 'x_in_isDeath', 'in_isDeath', '`in_isDeath`', '`in_isDeath`', 3, -1, FALSE, '`in_isDeath`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->in_isDeath->OptionCount = 2;
		$this->in_isDeath->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['in_isDeath'] = &$this->in_isDeath;

		// in_isSale
		$this->in_isSale = new cField('lov_intStatus', 'lov_intStatus', 'x_in_isSale', 'in_isSale', '`in_isSale`', '`in_isSale`', 3, -1, FALSE, '`in_isSale`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->in_isSale->OptionCount = 2;
		$this->in_isSale->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['in_isSale'] = &$this->in_isSale;

		// is_InternalUse
		$this->is_InternalUse = new cField('lov_intStatus', 'lov_intStatus', 'x_is_InternalUse', 'is_InternalUse', '`is_InternalUse`', '`is_InternalUse`', 3, -1, FALSE, '`is_InternalUse`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->is_InternalUse->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_InternalUse'] = &$this->is_InternalUse;

		// in_Created
		$this->in_Created = new cField('lov_intStatus', 'lov_intStatus', 'x_in_Created', 'in_Created', '`in_Created`', 'DATE_FORMAT(`in_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`in_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->in_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['in_Created'] = &$this->in_Created;

		// in_Updated
		$this->in_Updated = new cField('lov_intStatus', 'lov_intStatus', 'x_in_Updated', 'in_Updated', '`in_Updated`', 'DATE_FORMAT(`in_Updated`, \'%d/%m/%Y\')', 135, 7, FALSE, '`in_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->in_Updated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['in_Updated'] = &$this->in_Updated;

		// in_Note
		$this->in_Note = new cField('lov_intStatus', 'lov_intStatus', 'x_in_Note', 'in_Note', '`in_Note`', '`in_Note`', 201, -1, FALSE, '`in_Note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['in_Note'] = &$this->in_Note;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`lov_intStatus`";
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
			if (array_key_exists('in_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('in_ID', $this->DBID) . '=' . ew_QuotedValue($rs['in_ID'], $this->in_ID->FldDataType, $this->DBID));
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
		return "`in_ID` = @in_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->in_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@in_ID@", ew_AdjustSql($this->in_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "lov_intstatus_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "lov_intstatus_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("lov_intstatus_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("lov_intstatus_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "lov_intstatus_add.php?" . $this->UrlParm($parm);
		else
			$url = "lov_intstatus_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("lov_intstatus_edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("lov_intstatus_add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("lov_intstatus_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "in_ID:" . ew_VarToJson($this->in_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->in_ID->CurrentValue)) {
			$sUrl .= "in_ID=" . urlencode($this->in_ID->CurrentValue);
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
			if ($isPost && isset($_POST["in_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["in_ID"]);
			elseif (isset($_GET["in_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["in_ID"]);
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
			$this->in_ID->CurrentValue = $key;
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
		$this->in_ID->setDbValue($rs->fields('in_ID'));
		$this->in_Name->setDbValue($rs->fields('in_Name'));
		$this->in_isDeath->setDbValue($rs->fields('in_isDeath'));
		$this->in_isSale->setDbValue($rs->fields('in_isSale'));
		$this->is_InternalUse->setDbValue($rs->fields('is_InternalUse'));
		$this->in_Created->setDbValue($rs->fields('in_Created'));
		$this->in_Updated->setDbValue($rs->fields('in_Updated'));
		$this->in_Note->setDbValue($rs->fields('in_Note'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// in_ID

		$this->in_ID->CellCssStyle = "white-space: nowrap;";

		// in_Name
		// in_isDeath
		// in_isSale
		// is_InternalUse
		// in_Created
		// in_Updated
		// in_Note
		// in_ID

		$this->in_ID->ViewValue = $this->in_ID->CurrentValue;
		$this->in_ID->ViewCustomAttributes = "";

		// in_Name
		$this->in_Name->ViewValue = $this->in_Name->CurrentValue;
		$this->in_Name->ViewCustomAttributes = "";

		// in_isDeath
		if (strval($this->in_isDeath->CurrentValue) <> "") {
			$this->in_isDeath->ViewValue = $this->in_isDeath->OptionCaption($this->in_isDeath->CurrentValue);
		} else {
			$this->in_isDeath->ViewValue = NULL;
		}
		$this->in_isDeath->ViewCustomAttributes = "";

		// in_isSale
		if (strval($this->in_isSale->CurrentValue) <> "") {
			$this->in_isSale->ViewValue = $this->in_isSale->OptionCaption($this->in_isSale->CurrentValue);
		} else {
			$this->in_isSale->ViewValue = NULL;
		}
		$this->in_isSale->ViewCustomAttributes = "";

		// is_InternalUse
		$this->is_InternalUse->ViewValue = $this->is_InternalUse->CurrentValue;
		$this->is_InternalUse->ViewCustomAttributes = "";

		// in_Created
		$this->in_Created->ViewValue = $this->in_Created->CurrentValue;
		$this->in_Created->ViewValue = ew_FormatDateTime($this->in_Created->ViewValue, 7);
		$this->in_Created->ViewCustomAttributes = "";

		// in_Updated
		$this->in_Updated->ViewValue = $this->in_Updated->CurrentValue;
		$this->in_Updated->ViewValue = ew_FormatDateTime($this->in_Updated->ViewValue, 7);
		$this->in_Updated->ViewCustomAttributes = "";

		// in_Note
		$this->in_Note->ViewValue = $this->in_Note->CurrentValue;
		$this->in_Note->ViewCustomAttributes = "";

		// in_ID
		$this->in_ID->LinkCustomAttributes = "";
		$this->in_ID->HrefValue = "";
		$this->in_ID->TooltipValue = "";

		// in_Name
		$this->in_Name->LinkCustomAttributes = "";
		$this->in_Name->HrefValue = "";
		$this->in_Name->TooltipValue = "";

		// in_isDeath
		$this->in_isDeath->LinkCustomAttributes = "";
		$this->in_isDeath->HrefValue = "";
		$this->in_isDeath->TooltipValue = "";

		// in_isSale
		$this->in_isSale->LinkCustomAttributes = "";
		$this->in_isSale->HrefValue = "";
		$this->in_isSale->TooltipValue = "";

		// is_InternalUse
		$this->is_InternalUse->LinkCustomAttributes = "";
		$this->is_InternalUse->HrefValue = "";
		$this->is_InternalUse->TooltipValue = "";

		// in_Created
		$this->in_Created->LinkCustomAttributes = "";
		$this->in_Created->HrefValue = "";
		$this->in_Created->TooltipValue = "";

		// in_Updated
		$this->in_Updated->LinkCustomAttributes = "";
		$this->in_Updated->HrefValue = "";
		$this->in_Updated->TooltipValue = "";

		// in_Note
		$this->in_Note->LinkCustomAttributes = "";
		$this->in_Note->HrefValue = "";
		$this->in_Note->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// in_ID
		$this->in_ID->EditAttrs["class"] = "form-control";
		$this->in_ID->EditCustomAttributes = "";
		$this->in_ID->EditValue = $this->in_ID->CurrentValue;
		$this->in_ID->ViewCustomAttributes = "";

		// in_Name
		$this->in_Name->EditAttrs["class"] = "form-control";
		$this->in_Name->EditCustomAttributes = "";
		$this->in_Name->EditValue = $this->in_Name->CurrentValue;
		$this->in_Name->PlaceHolder = ew_RemoveHtml($this->in_Name->FldCaption());

		// in_isDeath
		$this->in_isDeath->EditAttrs["class"] = "form-control";
		$this->in_isDeath->EditCustomAttributes = "";
		$this->in_isDeath->EditValue = $this->in_isDeath->Options(TRUE);

		// in_isSale
		$this->in_isSale->EditAttrs["class"] = "form-control";
		$this->in_isSale->EditCustomAttributes = "";
		$this->in_isSale->EditValue = $this->in_isSale->Options(TRUE);

		// is_InternalUse
		$this->is_InternalUse->EditAttrs["class"] = "form-control";
		$this->is_InternalUse->EditCustomAttributes = "";
		$this->is_InternalUse->EditValue = $this->is_InternalUse->CurrentValue;
		$this->is_InternalUse->PlaceHolder = ew_RemoveHtml($this->is_InternalUse->FldCaption());

		// in_Created
		$this->in_Created->EditAttrs["class"] = "form-control";
		$this->in_Created->EditCustomAttributes = "";
		$this->in_Created->EditValue = ew_FormatDateTime($this->in_Created->CurrentValue, 7);
		$this->in_Created->PlaceHolder = ew_RemoveHtml($this->in_Created->FldCaption());

		// in_Updated
		$this->in_Updated->EditAttrs["class"] = "form-control";
		$this->in_Updated->EditCustomAttributes = "";
		$this->in_Updated->EditValue = ew_FormatDateTime($this->in_Updated->CurrentValue, 7);
		$this->in_Updated->PlaceHolder = ew_RemoveHtml($this->in_Updated->FldCaption());

		// in_Note
		$this->in_Note->EditAttrs["class"] = "form-control";
		$this->in_Note->EditCustomAttributes = "";
		$this->in_Note->EditValue = $this->in_Note->CurrentValue;
		$this->in_Note->PlaceHolder = ew_RemoveHtml($this->in_Note->FldCaption());

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
					if ($this->in_Name->Exportable) $Doc->ExportCaption($this->in_Name);
					if ($this->in_isDeath->Exportable) $Doc->ExportCaption($this->in_isDeath);
					if ($this->in_isSale->Exportable) $Doc->ExportCaption($this->in_isSale);
					if ($this->is_InternalUse->Exportable) $Doc->ExportCaption($this->is_InternalUse);
					if ($this->in_Note->Exportable) $Doc->ExportCaption($this->in_Note);
				} else {
					if ($this->in_Name->Exportable) $Doc->ExportCaption($this->in_Name);
					if ($this->in_isDeath->Exportable) $Doc->ExportCaption($this->in_isDeath);
					if ($this->in_isSale->Exportable) $Doc->ExportCaption($this->in_isSale);
					if ($this->is_InternalUse->Exportable) $Doc->ExportCaption($this->is_InternalUse);
					if ($this->in_Created->Exportable) $Doc->ExportCaption($this->in_Created);
					if ($this->in_Updated->Exportable) $Doc->ExportCaption($this->in_Updated);
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
						if ($this->in_Name->Exportable) $Doc->ExportField($this->in_Name);
						if ($this->in_isDeath->Exportable) $Doc->ExportField($this->in_isDeath);
						if ($this->in_isSale->Exportable) $Doc->ExportField($this->in_isSale);
						if ($this->is_InternalUse->Exportable) $Doc->ExportField($this->is_InternalUse);
						if ($this->in_Note->Exportable) $Doc->ExportField($this->in_Note);
					} else {
						if ($this->in_Name->Exportable) $Doc->ExportField($this->in_Name);
						if ($this->in_isDeath->Exportable) $Doc->ExportField($this->in_isDeath);
						if ($this->in_isSale->Exportable) $Doc->ExportField($this->in_isSale);
						if ($this->is_InternalUse->Exportable) $Doc->ExportField($this->is_InternalUse);
						if ($this->in_Created->Exportable) $Doc->ExportField($this->in_Created);
						if ($this->in_Updated->Exportable) $Doc->ExportField($this->in_Updated);
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
