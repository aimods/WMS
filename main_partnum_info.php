<?php

// Global variable for table object
$main_PartNum = NULL;

//
// Table class for main_PartNum
//
class cmain_PartNum extends cTable {
	var $pn_ID;
	var $pn_Barcode;
	var $v_ID;
	var $b_ID;
	var $pn_ProductName;
	var $pn_Version;
	var $pn_Spec;
	var $pn_Manual;
	var $b_Created;
	var $b_Updated;
	var $pn_PhotoCommercial;
	var $pn_PhotoTechnical;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'main_PartNum';
		$this->TableName = 'main_PartNum';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`main_PartNum`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// pn_ID
		$this->pn_ID = new cField('main_PartNum', 'main_PartNum', 'x_pn_ID', 'pn_ID', '`pn_ID`', '`pn_ID`', 3, -1, FALSE, '`pn_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->pn_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pn_ID'] = &$this->pn_ID;

		// pn_Barcode
		$this->pn_Barcode = new cField('main_PartNum', 'main_PartNum', 'x_pn_Barcode', 'pn_Barcode', '`pn_Barcode`', '`pn_Barcode`', 200, -1, FALSE, '`pn_Barcode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['pn_Barcode'] = &$this->pn_Barcode;

		// v_ID
		$this->v_ID = new cField('main_PartNum', 'main_PartNum', 'x_v_ID', 'v_ID', '`v_ID`', '`v_ID`', 3, -1, FALSE, '`v_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->v_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['v_ID'] = &$this->v_ID;

		// b_ID
		$this->b_ID = new cField('main_PartNum', 'main_PartNum', 'x_b_ID', 'b_ID', '`b_ID`', '`b_ID`', 3, -1, FALSE, '`b_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->b_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['b_ID'] = &$this->b_ID;

		// pn_ProductName
		$this->pn_ProductName = new cField('main_PartNum', 'main_PartNum', 'x_pn_ProductName', 'pn_ProductName', '`pn_ProductName`', '`pn_ProductName`', 200, -1, FALSE, '`pn_ProductName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['pn_ProductName'] = &$this->pn_ProductName;

		// pn_Version
		$this->pn_Version = new cField('main_PartNum', 'main_PartNum', 'x_pn_Version', 'pn_Version', '`pn_Version`', '`pn_Version`', 200, -1, FALSE, '`pn_Version`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['pn_Version'] = &$this->pn_Version;

		// pn_Spec
		$this->pn_Spec = new cField('main_PartNum', 'main_PartNum', 'x_pn_Spec', 'pn_Spec', '`pn_Spec`', '`pn_Spec`', 201, -1, FALSE, '`pn_Spec`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['pn_Spec'] = &$this->pn_Spec;

		// pn_Manual
		$this->pn_Manual = new cField('main_PartNum', 'main_PartNum', 'x_pn_Manual', 'pn_Manual', '`pn_Manual`', '`pn_Manual`', 201, -1, TRUE, '`pn_Manual`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->pn_Manual->UploadAllowedFileExt = "pdf";
		$this->pn_Manual->UploadMultiple = TRUE;
		$this->pn_Manual->Upload->UploadMultiple = TRUE;
		$this->fields['pn_Manual'] = &$this->pn_Manual;

		// b_Created
		$this->b_Created = new cField('main_PartNum', 'main_PartNum', 'x_b_Created', 'b_Created', '`b_Created`', 'DATE_FORMAT(`b_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`b_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['b_Created'] = &$this->b_Created;

		// b_Updated
		$this->b_Updated = new cField('main_PartNum', 'main_PartNum', 'x_b_Updated', 'b_Updated', '`b_Updated`', 'DATE_FORMAT(`b_Updated`, \'%d/%m/%Y\')', 135, 7, FALSE, '`b_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->b_Updated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['b_Updated'] = &$this->b_Updated;

		// pn_PhotoCommercial
		$this->pn_PhotoCommercial = new cField('main_PartNum', 'main_PartNum', 'x_pn_PhotoCommercial', 'pn_PhotoCommercial', '`pn_PhotoCommercial`', '`pn_PhotoCommercial`', 201, -1, TRUE, '`pn_PhotoCommercial`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->pn_PhotoCommercial->UploadAllowedFileExt = "png,jpg,jpeg";
		$this->fields['pn_PhotoCommercial'] = &$this->pn_PhotoCommercial;

		// pn_PhotoTechnical
		$this->pn_PhotoTechnical = new cField('main_PartNum', 'main_PartNum', 'x_pn_PhotoTechnical', 'pn_PhotoTechnical', '`pn_PhotoTechnical`', '`pn_PhotoTechnical`', 201, -1, TRUE, '`pn_PhotoTechnical`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->pn_PhotoTechnical->UploadAllowedFileExt = "png,jpg,jpeg";
		$this->pn_PhotoTechnical->UploadMultiple = TRUE;
		$this->pn_PhotoTechnical->Upload->UploadMultiple = TRUE;
		$this->fields['pn_PhotoTechnical'] = &$this->pn_PhotoTechnical;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "main_Brand") {
			if ($this->b_ID->getSessionValue() <> "")
				$sMasterFilter .= "`b_ID`=" . ew_QuotedValue($this->b_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "main_Vendor") {
			if ($this->v_ID->getSessionValue() <> "")
				$sMasterFilter .= "`v_ID`=" . ew_QuotedValue($this->v_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "main_Brand") {
			if ($this->b_ID->getSessionValue() <> "")
				$sDetailFilter .= "`b_ID`=" . ew_QuotedValue($this->b_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "main_Vendor") {
			if ($this->v_ID->getSessionValue() <> "")
				$sDetailFilter .= "`v_ID`=" . ew_QuotedValue($this->v_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_main_Brand() {
		return "`b_ID`=@b_ID@";
	}

	// Detail filter
	function SqlDetailFilter_main_Brand() {
		return "`b_ID`=@b_ID@";
	}

	// Master filter
	function SqlMasterFilter_main_Vendor() {
		return "`v_ID`=@v_ID@";
	}

	// Detail filter
	function SqlDetailFilter_main_Vendor() {
		return "`v_ID`=@v_ID@";
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
		if ($this->getCurrentDetailTable() == "main_Product") {
			$sDetailUrl = $GLOBALS["main_Product"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_pn_ID=" . urlencode($this->pn_ID->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "StockCard") {
			$sDetailUrl = $GLOBALS["StockCard"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_pn_ID=" . urlencode($this->pn_ID->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "main_partnum_list.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`main_PartNum`";
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
			if (array_key_exists('pn_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('pn_ID', $this->DBID) . '=' . ew_QuotedValue($rs['pn_ID'], $this->pn_ID->FldDataType, $this->DBID));
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
		return "`pn_ID` = @pn_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->pn_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@pn_ID@", ew_AdjustSql($this->pn_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "main_partnum_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "main_partnum_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_partnum_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_partnum_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "main_partnum_add.php?" . $this->UrlParm($parm);
		else
			$url = "main_partnum_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_partnum_edit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_partnum_edit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("main_partnum_add.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_partnum_add.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("main_partnum_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "main_Brand" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_b_ID=" . urlencode($this->b_ID->CurrentValue);
		}
		if ($this->getCurrentMasterTable() == "main_Vendor" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_v_ID=" . urlencode($this->v_ID->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "pn_ID:" . ew_VarToJson($this->pn_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->pn_ID->CurrentValue)) {
			$sUrl .= "pn_ID=" . urlencode($this->pn_ID->CurrentValue);
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
			if ($isPost && isset($_POST["pn_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["pn_ID"]);
			elseif (isset($_GET["pn_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["pn_ID"]);
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
			$this->pn_ID->CurrentValue = $key;
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
		$this->pn_ID->setDbValue($rs->fields('pn_ID'));
		$this->pn_Barcode->setDbValue($rs->fields('pn_Barcode'));
		$this->v_ID->setDbValue($rs->fields('v_ID'));
		$this->b_ID->setDbValue($rs->fields('b_ID'));
		$this->pn_ProductName->setDbValue($rs->fields('pn_ProductName'));
		$this->pn_Version->setDbValue($rs->fields('pn_Version'));
		$this->pn_Spec->setDbValue($rs->fields('pn_Spec'));
		$this->pn_Manual->Upload->DbValue = $rs->fields('pn_Manual');
		$this->b_Created->setDbValue($rs->fields('b_Created'));
		$this->b_Updated->setDbValue($rs->fields('b_Updated'));
		$this->pn_PhotoCommercial->Upload->DbValue = $rs->fields('pn_PhotoCommercial');
		$this->pn_PhotoTechnical->Upload->DbValue = $rs->fields('pn_PhotoTechnical');
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// pn_ID
		// pn_Barcode
		// v_ID
		// b_ID
		// pn_ProductName
		// pn_Version
		// pn_Spec
		// pn_Manual
		// b_Created
		// b_Updated
		// pn_PhotoCommercial
		// pn_PhotoTechnical
		// pn_ID

		$this->pn_ID->ViewValue = $this->pn_ID->CurrentValue;
		$this->pn_ID->ViewCustomAttributes = "";

		// pn_Barcode
		$this->pn_Barcode->ViewValue = $this->pn_Barcode->CurrentValue;
		$this->pn_Barcode->ViewCustomAttributes = "";

		// v_ID
		if (strval($this->v_ID->CurrentValue) <> "") {
			$sFilterWrk = "`v_ID`" . ew_SearchString("=", $this->v_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `v_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_ID->ViewValue = $this->v_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_ID->ViewValue = $this->v_ID->CurrentValue;
			}
		} else {
			$this->v_ID->ViewValue = NULL;
		}
		$this->v_ID->ViewCustomAttributes = "";

		// b_ID
		if (strval($this->b_ID->CurrentValue) <> "") {
			$sFilterWrk = "`b_ID`" . ew_SearchString("=", $this->b_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->b_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `b_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->b_ID->ViewValue = $this->b_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->b_ID->ViewValue = $this->b_ID->CurrentValue;
			}
		} else {
			$this->b_ID->ViewValue = NULL;
		}
		$this->b_ID->ViewCustomAttributes = "";

		// pn_ProductName
		$this->pn_ProductName->ViewValue = $this->pn_ProductName->CurrentValue;
		$this->pn_ProductName->ViewCustomAttributes = "";

		// pn_Version
		$this->pn_Version->ViewValue = $this->pn_Version->CurrentValue;
		$this->pn_Version->ViewCustomAttributes = "";

		// pn_Spec
		$this->pn_Spec->ViewValue = $this->pn_Spec->CurrentValue;
		$this->pn_Spec->ViewCustomAttributes = "";

		// pn_Manual
		$this->pn_Manual->UploadPath = files/manual;
		if (!ew_Empty($this->pn_Manual->Upload->DbValue)) {
			$this->pn_Manual->ViewValue = $this->pn_Manual->Upload->DbValue;
		} else {
			$this->pn_Manual->ViewValue = "";
		}
		$this->pn_Manual->ViewCustomAttributes = "";

		// b_Created
		$this->b_Created->ViewValue = $this->b_Created->CurrentValue;
		$this->b_Created->ViewValue = ew_FormatDateTime($this->b_Created->ViewValue, 7);
		$this->b_Created->ViewCustomAttributes = "";

		// b_Updated
		$this->b_Updated->ViewValue = $this->b_Updated->CurrentValue;
		$this->b_Updated->ViewValue = ew_FormatDateTime($this->b_Updated->ViewValue, 7);
		$this->b_Updated->ViewCustomAttributes = "";

		// pn_PhotoCommercial
		$this->pn_PhotoCommercial->UploadPath = files/products;
		if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
			$this->pn_PhotoCommercial->ImageAlt = $this->pn_PhotoCommercial->FldAlt();
			$this->pn_PhotoCommercial->ViewValue = $this->pn_PhotoCommercial->Upload->DbValue;
		} else {
			$this->pn_PhotoCommercial->ViewValue = "";
		}
		$this->pn_PhotoCommercial->ViewCustomAttributes = "";

		// pn_PhotoTechnical
		$this->pn_PhotoTechnical->UploadPath = files/technical/images;
		if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
			$this->pn_PhotoTechnical->ImageAlt = $this->pn_PhotoTechnical->FldAlt();
			$this->pn_PhotoTechnical->ViewValue = $this->pn_PhotoTechnical->Upload->DbValue;
		} else {
			$this->pn_PhotoTechnical->ViewValue = "";
		}
		$this->pn_PhotoTechnical->ViewCustomAttributes = "";

		// pn_ID
		$this->pn_ID->LinkCustomAttributes = "";
		$this->pn_ID->HrefValue = "";
		$this->pn_ID->TooltipValue = "";

		// pn_Barcode
		$this->pn_Barcode->LinkCustomAttributes = "";
		$this->pn_Barcode->HrefValue = "";
		$this->pn_Barcode->TooltipValue = "";

		// v_ID
		$this->v_ID->LinkCustomAttributes = "";
		$this->v_ID->HrefValue = "";
		$this->v_ID->TooltipValue = "";

		// b_ID
		$this->b_ID->LinkCustomAttributes = "";
		$this->b_ID->HrefValue = "";
		$this->b_ID->TooltipValue = "";

		// pn_ProductName
		$this->pn_ProductName->LinkCustomAttributes = "";
		$this->pn_ProductName->HrefValue = "";
		$this->pn_ProductName->TooltipValue = "";

		// pn_Version
		$this->pn_Version->LinkCustomAttributes = "";
		$this->pn_Version->HrefValue = "";
		$this->pn_Version->TooltipValue = "";

		// pn_Spec
		$this->pn_Spec->LinkCustomAttributes = "";
		$this->pn_Spec->HrefValue = "";
		$this->pn_Spec->TooltipValue = "";

		// pn_Manual
		$this->pn_Manual->LinkCustomAttributes = "";
		$this->pn_Manual->HrefValue = "";
		$this->pn_Manual->HrefValue2 = $this->pn_Manual->UploadPath . $this->pn_Manual->Upload->DbValue;
		$this->pn_Manual->TooltipValue = "";

		// b_Created
		$this->b_Created->LinkCustomAttributes = "";
		$this->b_Created->HrefValue = "";
		$this->b_Created->TooltipValue = "";

		// b_Updated
		$this->b_Updated->LinkCustomAttributes = "";
		$this->b_Updated->HrefValue = "";
		$this->b_Updated->TooltipValue = "";

		// pn_PhotoCommercial
		$this->pn_PhotoCommercial->LinkCustomAttributes = "";
		$this->pn_PhotoCommercial->UploadPath = files/products;
		if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
			$this->pn_PhotoCommercial->HrefValue = ew_GetFileUploadUrl($this->pn_PhotoCommercial, $this->pn_PhotoCommercial->Upload->DbValue); // Add prefix/suffix
			$this->pn_PhotoCommercial->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->pn_PhotoCommercial->HrefValue = ew_ConvertFullUrl($this->pn_PhotoCommercial->HrefValue);
		} else {
			$this->pn_PhotoCommercial->HrefValue = "";
		}
		$this->pn_PhotoCommercial->HrefValue2 = $this->pn_PhotoCommercial->UploadPath . $this->pn_PhotoCommercial->Upload->DbValue;
		$this->pn_PhotoCommercial->TooltipValue = "";
		if ($this->pn_PhotoCommercial->UseColorbox) {
			if (ew_Empty($this->pn_PhotoCommercial->TooltipValue))
				$this->pn_PhotoCommercial->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->pn_PhotoCommercial->LinkAttrs["data-rel"] = "main_PartNum_x_pn_PhotoCommercial";
			ew_AppendClass($this->pn_PhotoCommercial->LinkAttrs["class"], "ewLightbox");
		}

		// pn_PhotoTechnical
		$this->pn_PhotoTechnical->LinkCustomAttributes = "";
		$this->pn_PhotoTechnical->UploadPath = files/technical/images;
		if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
			$this->pn_PhotoTechnical->HrefValue = "%u"; // Add prefix/suffix
			$this->pn_PhotoTechnical->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->pn_PhotoTechnical->HrefValue = ew_ConvertFullUrl($this->pn_PhotoTechnical->HrefValue);
		} else {
			$this->pn_PhotoTechnical->HrefValue = "";
		}
		$this->pn_PhotoTechnical->HrefValue2 = $this->pn_PhotoTechnical->UploadPath . $this->pn_PhotoTechnical->Upload->DbValue;
		$this->pn_PhotoTechnical->TooltipValue = "";
		if ($this->pn_PhotoTechnical->UseColorbox) {
			if (ew_Empty($this->pn_PhotoTechnical->TooltipValue))
				$this->pn_PhotoTechnical->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->pn_PhotoTechnical->LinkAttrs["data-rel"] = "main_PartNum_x_pn_PhotoTechnical";
			ew_AppendClass($this->pn_PhotoTechnical->LinkAttrs["class"], "ewLightbox");
		}

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// pn_ID
		$this->pn_ID->EditAttrs["class"] = "form-control";
		$this->pn_ID->EditCustomAttributes = "";
		$this->pn_ID->EditValue = $this->pn_ID->CurrentValue;
		$this->pn_ID->ViewCustomAttributes = "";

		// pn_Barcode
		$this->pn_Barcode->EditAttrs["class"] = "form-control";
		$this->pn_Barcode->EditCustomAttributes = "";
		$this->pn_Barcode->EditValue = $this->pn_Barcode->CurrentValue;
		$this->pn_Barcode->ViewCustomAttributes = "";

		// v_ID
		$this->v_ID->EditAttrs["class"] = "form-control";
		$this->v_ID->EditCustomAttributes = "";
		if (strval($this->v_ID->CurrentValue) <> "") {
			$sFilterWrk = "`v_ID`" . ew_SearchString("=", $this->v_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `v_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_ID->EditValue = $this->v_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_ID->EditValue = $this->v_ID->CurrentValue;
			}
		} else {
			$this->v_ID->EditValue = NULL;
		}
		$this->v_ID->ViewCustomAttributes = "";

		// b_ID
		$this->b_ID->EditAttrs["class"] = "form-control";
		$this->b_ID->EditCustomAttributes = "";
		if (strval($this->b_ID->CurrentValue) <> "") {
			$sFilterWrk = "`b_ID`" . ew_SearchString("=", $this->b_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->b_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `b_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->b_ID->EditValue = $this->b_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->b_ID->EditValue = $this->b_ID->CurrentValue;
			}
		} else {
			$this->b_ID->EditValue = NULL;
		}
		$this->b_ID->ViewCustomAttributes = "";

		// pn_ProductName
		$this->pn_ProductName->EditAttrs["class"] = "form-control";
		$this->pn_ProductName->EditCustomAttributes = "";
		$this->pn_ProductName->EditValue = $this->pn_ProductName->CurrentValue;
		$this->pn_ProductName->ViewCustomAttributes = "";

		// pn_Version
		$this->pn_Version->EditAttrs["class"] = "form-control";
		$this->pn_Version->EditCustomAttributes = "";
		$this->pn_Version->EditValue = $this->pn_Version->CurrentValue;
		$this->pn_Version->ViewCustomAttributes = "";

		// pn_Spec
		$this->pn_Spec->EditAttrs["class"] = "form-control";
		$this->pn_Spec->EditCustomAttributes = "";
		$this->pn_Spec->EditValue = $this->pn_Spec->CurrentValue;
		$this->pn_Spec->PlaceHolder = ew_RemoveHtml($this->pn_Spec->FldCaption());

		// pn_Manual
		$this->pn_Manual->EditAttrs["class"] = "form-control";
		$this->pn_Manual->EditCustomAttributes = "";
		$this->pn_Manual->UploadPath = files/manual;
		if (!ew_Empty($this->pn_Manual->Upload->DbValue)) {
			$this->pn_Manual->EditValue = $this->pn_Manual->Upload->DbValue;
		} else {
			$this->pn_Manual->EditValue = "";
		}
		if (!ew_Empty($this->pn_Manual->CurrentValue))
			$this->pn_Manual->Upload->FileName = $this->pn_Manual->CurrentValue;

		// b_Created
		$this->b_Created->EditAttrs["class"] = "form-control";
		$this->b_Created->EditCustomAttributes = "";
		$this->b_Created->EditValue = ew_FormatDateTime($this->b_Created->CurrentValue, 7);
		$this->b_Created->PlaceHolder = ew_RemoveHtml($this->b_Created->FldCaption());

		// b_Updated
		$this->b_Updated->EditAttrs["class"] = "form-control";
		$this->b_Updated->EditCustomAttributes = "";
		$this->b_Updated->EditValue = ew_FormatDateTime($this->b_Updated->CurrentValue, 7);
		$this->b_Updated->PlaceHolder = ew_RemoveHtml($this->b_Updated->FldCaption());

		// pn_PhotoCommercial
		$this->pn_PhotoCommercial->EditAttrs["class"] = "form-control";
		$this->pn_PhotoCommercial->EditCustomAttributes = "";
		$this->pn_PhotoCommercial->UploadPath = files/products;
		if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
			$this->pn_PhotoCommercial->ImageAlt = $this->pn_PhotoCommercial->FldAlt();
			$this->pn_PhotoCommercial->EditValue = $this->pn_PhotoCommercial->Upload->DbValue;
		} else {
			$this->pn_PhotoCommercial->EditValue = "";
		}
		if (!ew_Empty($this->pn_PhotoCommercial->CurrentValue))
			$this->pn_PhotoCommercial->Upload->FileName = $this->pn_PhotoCommercial->CurrentValue;

		// pn_PhotoTechnical
		$this->pn_PhotoTechnical->EditAttrs["class"] = "form-control";
		$this->pn_PhotoTechnical->EditCustomAttributes = "";
		$this->pn_PhotoTechnical->UploadPath = files/technical/images;
		if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
			$this->pn_PhotoTechnical->ImageAlt = $this->pn_PhotoTechnical->FldAlt();
			$this->pn_PhotoTechnical->EditValue = $this->pn_PhotoTechnical->Upload->DbValue;
		} else {
			$this->pn_PhotoTechnical->EditValue = "";
		}
		if (!ew_Empty($this->pn_PhotoTechnical->CurrentValue))
			$this->pn_PhotoTechnical->Upload->FileName = $this->pn_PhotoTechnical->CurrentValue;

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
					if ($this->pn_Barcode->Exportable) $Doc->ExportCaption($this->pn_Barcode);
					if ($this->v_ID->Exportable) $Doc->ExportCaption($this->v_ID);
					if ($this->b_ID->Exportable) $Doc->ExportCaption($this->b_ID);
					if ($this->pn_ProductName->Exportable) $Doc->ExportCaption($this->pn_ProductName);
					if ($this->pn_Version->Exportable) $Doc->ExportCaption($this->pn_Version);
					if ($this->pn_Spec->Exportable) $Doc->ExportCaption($this->pn_Spec);
					if ($this->pn_Manual->Exportable) $Doc->ExportCaption($this->pn_Manual);
					if ($this->pn_PhotoCommercial->Exportable) $Doc->ExportCaption($this->pn_PhotoCommercial);
					if ($this->pn_PhotoTechnical->Exportable) $Doc->ExportCaption($this->pn_PhotoTechnical);
				} else {
					if ($this->pn_Barcode->Exportable) $Doc->ExportCaption($this->pn_Barcode);
					if ($this->v_ID->Exportable) $Doc->ExportCaption($this->v_ID);
					if ($this->b_ID->Exportable) $Doc->ExportCaption($this->b_ID);
					if ($this->pn_ProductName->Exportable) $Doc->ExportCaption($this->pn_ProductName);
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
						if ($this->pn_Barcode->Exportable) $Doc->ExportField($this->pn_Barcode);
						if ($this->v_ID->Exportable) $Doc->ExportField($this->v_ID);
						if ($this->b_ID->Exportable) $Doc->ExportField($this->b_ID);
						if ($this->pn_ProductName->Exportable) $Doc->ExportField($this->pn_ProductName);
						if ($this->pn_Version->Exportable) $Doc->ExportField($this->pn_Version);
						if ($this->pn_Spec->Exportable) $Doc->ExportField($this->pn_Spec);
						if ($this->pn_Manual->Exportable) $Doc->ExportField($this->pn_Manual);
						if ($this->pn_PhotoCommercial->Exportable) $Doc->ExportField($this->pn_PhotoCommercial);
						if ($this->pn_PhotoTechnical->Exportable) $Doc->ExportField($this->pn_PhotoTechnical);
					} else {
						if ($this->pn_Barcode->Exportable) $Doc->ExportField($this->pn_Barcode);
						if ($this->v_ID->Exportable) $Doc->ExportField($this->v_ID);
						if ($this->b_ID->Exportable) $Doc->ExportField($this->b_ID);
						if ($this->pn_ProductName->Exportable) $Doc->ExportField($this->pn_ProductName);
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
