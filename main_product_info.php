<?php

// Global variable for table object
$main_Product = NULL;

//
// Table class for main_Product
//
class cmain_Product extends cTable {
	var $pr_ID;
	var $pn_ID;
	var $pr_Barcode;
	var $pr_Activated;
	var $pr_Status;
	var $pr_PO;
	var $pr_Cost;
	var $pr_intStatus;
	var $pr_Created;
	var $pr_Updated;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'main_Product';
		$this->TableName = 'main_Product';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`main_Product`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// pr_ID
		$this->pr_ID = new cField('main_Product', 'main_Product', 'x_pr_ID', 'pr_ID', '`pr_ID`', '`pr_ID`', 3, -1, FALSE, '`pr_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->pr_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pr_ID'] = &$this->pr_ID;

		// pn_ID
		$this->pn_ID = new cField('main_Product', 'main_Product', 'x_pn_ID', 'pn_ID', '`pn_ID`', '`pn_ID`', 3, -1, FALSE, '`pn_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pn_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pn_ID'] = &$this->pn_ID;

		// pr_Barcode
		$this->pr_Barcode = new cField('main_Product', 'main_Product', 'x_pr_Barcode', 'pr_Barcode', '`pr_Barcode`', '`pr_Barcode`', 200, -1, FALSE, '`pr_Barcode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['pr_Barcode'] = &$this->pr_Barcode;

		// pr_Activated
		$this->pr_Activated = new cField('main_Product', 'main_Product', 'x_pr_Activated', 'pr_Activated', '`pr_Activated`', 'DATE_FORMAT(`pr_Activated`, \'%d/%m/%Y\')', 133, 7, FALSE, '`pr_Activated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pr_Activated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['pr_Activated'] = &$this->pr_Activated;

		// pr_Status
		$this->pr_Status = new cField('main_Product', 'main_Product', 'x_pr_Status', 'pr_Status', '`pr_Status`', '`pr_Status`', 3, -1, FALSE, '`pr_Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pr_Status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pr_Status'] = &$this->pr_Status;

		// pr_PO
		$this->pr_PO = new cField('main_Product', 'main_Product', 'x_pr_PO', 'pr_PO', '`pr_PO`', '`pr_PO`', 200, -1, FALSE, '`pr_PO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['pr_PO'] = &$this->pr_PO;

		// pr_Cost
		$this->pr_Cost = new cField('main_Product', 'main_Product', 'x_pr_Cost', 'pr_Cost', '`pr_Cost`', '`pr_Cost`', 5, -1, FALSE, '`pr_Cost`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pr_Cost->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pr_Cost'] = &$this->pr_Cost;

		// pr_intStatus
		$this->pr_intStatus = new cField('main_Product', 'main_Product', 'x_pr_intStatus', 'pr_intStatus', '`pr_intStatus`', '`pr_intStatus`', 3, -1, FALSE, '`pr_intStatus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->pr_intStatus->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pr_intStatus'] = &$this->pr_intStatus;

		// pr_Created
		$this->pr_Created = new cField('main_Product', 'main_Product', 'x_pr_Created', 'pr_Created', '`pr_Created`', 'DATE_FORMAT(`pr_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`pr_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pr_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['pr_Created'] = &$this->pr_Created;

		// pr_Updated
		$this->pr_Updated = new cField('main_Product', 'main_Product', 'x_pr_Updated', 'pr_Updated', '`pr_Updated`', 'DATE_FORMAT(`pr_Updated`, \'%d/%m/%Y\')', 135, 7, FALSE, '`pr_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pr_Updated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['pr_Updated'] = &$this->pr_Updated;
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
		if ($this->getCurrentMasterTable() == "main_PartNum") {
			if ($this->pn_ID->getSessionValue() <> "")
				$sMasterFilter .= "`pn_ID`=" . ew_QuotedValue($this->pn_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "main_PartNum") {
			if ($this->pn_ID->getSessionValue() <> "")
				$sDetailFilter .= "`pn_ID`=" . ew_QuotedValue($this->pn_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_main_PartNum() {
		return "`pn_ID`=@pn_ID@";
	}

	// Detail filter
	function SqlDetailFilter_main_PartNum() {
		return "`pn_ID`=@pn_ID@";
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
		if ($this->getCurrentDetailTable() == "transaction_Movement") {
			$sDetailUrl = $GLOBALS["transaction_Movement"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_pr_ID=" . urlencode($this->pr_ID->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "main_product_list.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`main_Product`";
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
			if (array_key_exists('pr_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('pr_ID', $this->DBID) . '=' . ew_QuotedValue($rs['pr_ID'], $this->pr_ID->FldDataType, $this->DBID));
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
		return "`pr_ID` = @pr_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->pr_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@pr_ID@", ew_AdjustSql($this->pr_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "main_product_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "main_product_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_product_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_product_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "main_product_add.php?" . $this->UrlParm($parm);
		else
			$url = "main_product_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_product_edit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_product_edit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("main_product_add.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_product_add.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("main_product_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "main_PartNum" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_pn_ID=" . urlencode($this->pn_ID->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "pr_ID:" . ew_VarToJson($this->pr_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->pr_ID->CurrentValue)) {
			$sUrl .= "pr_ID=" . urlencode($this->pr_ID->CurrentValue);
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
			if ($isPost && isset($_POST["pr_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["pr_ID"]);
			elseif (isset($_GET["pr_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["pr_ID"]);
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
			$this->pr_ID->CurrentValue = $key;
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
		$this->pr_ID->setDbValue($rs->fields('pr_ID'));
		$this->pn_ID->setDbValue($rs->fields('pn_ID'));
		$this->pr_Barcode->setDbValue($rs->fields('pr_Barcode'));
		$this->pr_Activated->setDbValue($rs->fields('pr_Activated'));
		$this->pr_Status->setDbValue($rs->fields('pr_Status'));
		$this->pr_PO->setDbValue($rs->fields('pr_PO'));
		$this->pr_Cost->setDbValue($rs->fields('pr_Cost'));
		$this->pr_intStatus->setDbValue($rs->fields('pr_intStatus'));
		$this->pr_Created->setDbValue($rs->fields('pr_Created'));
		$this->pr_Updated->setDbValue($rs->fields('pr_Updated'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// pr_ID

		$this->pr_ID->CellCssStyle = "white-space: nowrap;";

		// pn_ID
		// pr_Barcode
		// pr_Activated
		// pr_Status
		// pr_PO
		// pr_Cost
		// pr_intStatus
		// pr_Created
		// pr_Updated
		// pr_ID

		$this->pr_ID->ViewValue = $this->pr_ID->CurrentValue;
		$this->pr_ID->ViewCustomAttributes = "";

		// pn_ID
		if (strval($this->pn_ID->CurrentValue) <> "") {
			$sFilterWrk = "`pn_ID`" . ew_SearchString("=", $this->pn_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `pn_ID`, `pn_ProductName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_PartNum`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pn_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pn_ID->ViewValue = $this->pn_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pn_ID->ViewValue = $this->pn_ID->CurrentValue;
			}
		} else {
			$this->pn_ID->ViewValue = NULL;
		}
		$this->pn_ID->ViewCustomAttributes = "";

		// pr_Barcode
		$this->pr_Barcode->ViewValue = $this->pr_Barcode->CurrentValue;
		$this->pr_Barcode->ViewCustomAttributes = "";

		// pr_Activated
		$this->pr_Activated->ViewValue = $this->pr_Activated->CurrentValue;
		$this->pr_Activated->ViewValue = ew_FormatDateTime($this->pr_Activated->ViewValue, 7);
		$this->pr_Activated->ViewCustomAttributes = "";

		// pr_Status
		if (strval($this->pr_Status->CurrentValue) <> "") {
			$sFilterWrk = "`ps_ID`" . ew_SearchString("=", $this->pr_Status->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pr_Status, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pr_Status->ViewValue = $this->pr_Status->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pr_Status->ViewValue = $this->pr_Status->CurrentValue;
			}
		} else {
			$this->pr_Status->ViewValue = NULL;
		}
		$this->pr_Status->ViewCustomAttributes = "";

		// pr_PO
		$this->pr_PO->ViewValue = $this->pr_PO->CurrentValue;
		$this->pr_PO->ViewCustomAttributes = "";

		// pr_Cost
		$this->pr_Cost->ViewValue = $this->pr_Cost->CurrentValue;
		$this->pr_Cost->ViewCustomAttributes = "";

		// pr_intStatus
		if (strval($this->pr_intStatus->CurrentValue) <> "") {
			$sFilterWrk = "`in_ID`" . ew_SearchString("=", $this->pr_intStatus->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_intStatus`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pr_intStatus, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pr_intStatus->ViewValue = $this->pr_intStatus->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pr_intStatus->ViewValue = $this->pr_intStatus->CurrentValue;
			}
		} else {
			$this->pr_intStatus->ViewValue = NULL;
		}
		$this->pr_intStatus->ViewCustomAttributes = "";

		// pr_Created
		$this->pr_Created->ViewValue = $this->pr_Created->CurrentValue;
		$this->pr_Created->ViewValue = ew_FormatDateTime($this->pr_Created->ViewValue, 7);
		$this->pr_Created->ViewCustomAttributes = "";

		// pr_Updated
		$this->pr_Updated->ViewValue = $this->pr_Updated->CurrentValue;
		$this->pr_Updated->ViewValue = ew_FormatDateTime($this->pr_Updated->ViewValue, 7);
		$this->pr_Updated->ViewCustomAttributes = "";

		// pr_ID
		$this->pr_ID->LinkCustomAttributes = "";
		$this->pr_ID->HrefValue = "";
		$this->pr_ID->TooltipValue = "";

		// pn_ID
		$this->pn_ID->LinkCustomAttributes = "";
		$this->pn_ID->HrefValue = "";
		$this->pn_ID->TooltipValue = "";

		// pr_Barcode
		$this->pr_Barcode->LinkCustomAttributes = "";
		$this->pr_Barcode->HrefValue = "";
		$this->pr_Barcode->TooltipValue = "";

		// pr_Activated
		$this->pr_Activated->LinkCustomAttributes = "";
		$this->pr_Activated->HrefValue = "";
		$this->pr_Activated->TooltipValue = "";

		// pr_Status
		$this->pr_Status->LinkCustomAttributes = "";
		$this->pr_Status->HrefValue = "";
		$this->pr_Status->TooltipValue = "";

		// pr_PO
		$this->pr_PO->LinkCustomAttributes = "";
		$this->pr_PO->HrefValue = "";
		$this->pr_PO->TooltipValue = "";

		// pr_Cost
		$this->pr_Cost->LinkCustomAttributes = "";
		$this->pr_Cost->HrefValue = "";
		$this->pr_Cost->TooltipValue = "";

		// pr_intStatus
		$this->pr_intStatus->LinkCustomAttributes = "";
		$this->pr_intStatus->HrefValue = "";
		$this->pr_intStatus->TooltipValue = "";

		// pr_Created
		$this->pr_Created->LinkCustomAttributes = "";
		$this->pr_Created->HrefValue = "";
		$this->pr_Created->TooltipValue = "";

		// pr_Updated
		$this->pr_Updated->LinkCustomAttributes = "";
		$this->pr_Updated->HrefValue = "";
		$this->pr_Updated->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// pr_ID
		$this->pr_ID->EditAttrs["class"] = "form-control";
		$this->pr_ID->EditCustomAttributes = "";
		$this->pr_ID->EditValue = $this->pr_ID->CurrentValue;
		$this->pr_ID->ViewCustomAttributes = "";

		// pn_ID
		$this->pn_ID->EditCustomAttributes = "";
		if ($this->pn_ID->getSessionValue() <> "") {
			$this->pn_ID->CurrentValue = $this->pn_ID->getSessionValue();
		if (strval($this->pn_ID->CurrentValue) <> "") {
			$sFilterWrk = "`pn_ID`" . ew_SearchString("=", $this->pn_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `pn_ID`, `pn_ProductName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_PartNum`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pn_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pn_ID->ViewValue = $this->pn_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pn_ID->ViewValue = $this->pn_ID->CurrentValue;
			}
		} else {
			$this->pn_ID->ViewValue = NULL;
		}
		$this->pn_ID->ViewCustomAttributes = "";
		} else {
		}

		// pr_Barcode
		$this->pr_Barcode->EditAttrs["class"] = "form-control";
		$this->pr_Barcode->EditCustomAttributes = "";
		$this->pr_Barcode->EditValue = $this->pr_Barcode->CurrentValue;
		$this->pr_Barcode->PlaceHolder = ew_RemoveHtml($this->pr_Barcode->FldCaption());

		// pr_Activated
		$this->pr_Activated->EditAttrs["class"] = "form-control";
		$this->pr_Activated->EditCustomAttributes = "";
		$this->pr_Activated->EditValue = $this->pr_Activated->CurrentValue;
		$this->pr_Activated->EditValue = ew_FormatDateTime($this->pr_Activated->EditValue, 7);
		$this->pr_Activated->ViewCustomAttributes = "";

		// pr_Status
		$this->pr_Status->EditAttrs["class"] = "form-control";
		$this->pr_Status->EditCustomAttributes = "";
		if (strval($this->pr_Status->CurrentValue) <> "") {
			$sFilterWrk = "`ps_ID`" . ew_SearchString("=", $this->pr_Status->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pr_Status, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pr_Status->EditValue = $this->pr_Status->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pr_Status->EditValue = $this->pr_Status->CurrentValue;
			}
		} else {
			$this->pr_Status->EditValue = NULL;
		}
		$this->pr_Status->ViewCustomAttributes = "";

		// pr_PO
		$this->pr_PO->EditAttrs["class"] = "form-control";
		$this->pr_PO->EditCustomAttributes = "";
		$this->pr_PO->EditValue = $this->pr_PO->CurrentValue;
		$this->pr_PO->ViewCustomAttributes = "";

		// pr_Cost
		$this->pr_Cost->EditAttrs["class"] = "form-control";
		$this->pr_Cost->EditCustomAttributes = "";
		$this->pr_Cost->EditValue = $this->pr_Cost->CurrentValue;
		$this->pr_Cost->PlaceHolder = ew_RemoveHtml($this->pr_Cost->FldCaption());
		if (strval($this->pr_Cost->EditValue) <> "" && is_numeric($this->pr_Cost->EditValue)) $this->pr_Cost->EditValue = ew_FormatNumber($this->pr_Cost->EditValue, -2, -1, -2, 0);

		// pr_intStatus
		$this->pr_intStatus->EditCustomAttributes = "";

		// pr_Created
		$this->pr_Created->EditAttrs["class"] = "form-control";
		$this->pr_Created->EditCustomAttributes = "";
		$this->pr_Created->EditValue = ew_FormatDateTime($this->pr_Created->CurrentValue, 7);
		$this->pr_Created->PlaceHolder = ew_RemoveHtml($this->pr_Created->FldCaption());

		// pr_Updated
		$this->pr_Updated->EditAttrs["class"] = "form-control";
		$this->pr_Updated->EditCustomAttributes = "";
		$this->pr_Updated->EditValue = ew_FormatDateTime($this->pr_Updated->CurrentValue, 7);
		$this->pr_Updated->PlaceHolder = ew_RemoveHtml($this->pr_Updated->FldCaption());

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
					if ($this->pn_ID->Exportable) $Doc->ExportCaption($this->pn_ID);
					if ($this->pr_Barcode->Exportable) $Doc->ExportCaption($this->pr_Barcode);
					if ($this->pr_Activated->Exportable) $Doc->ExportCaption($this->pr_Activated);
					if ($this->pr_Status->Exportable) $Doc->ExportCaption($this->pr_Status);
					if ($this->pr_PO->Exportable) $Doc->ExportCaption($this->pr_PO);
					if ($this->pr_Cost->Exportable) $Doc->ExportCaption($this->pr_Cost);
					if ($this->pr_intStatus->Exportable) $Doc->ExportCaption($this->pr_intStatus);
				} else {
					if ($this->pr_Barcode->Exportable) $Doc->ExportCaption($this->pr_Barcode);
					if ($this->pr_Activated->Exportable) $Doc->ExportCaption($this->pr_Activated);
					if ($this->pr_Status->Exportable) $Doc->ExportCaption($this->pr_Status);
					if ($this->pr_PO->Exportable) $Doc->ExportCaption($this->pr_PO);
					if ($this->pr_Cost->Exportable) $Doc->ExportCaption($this->pr_Cost);
					if ($this->pr_intStatus->Exportable) $Doc->ExportCaption($this->pr_intStatus);
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
						if ($this->pn_ID->Exportable) $Doc->ExportField($this->pn_ID);
						if ($this->pr_Barcode->Exportable) $Doc->ExportField($this->pr_Barcode);
						if ($this->pr_Activated->Exportable) $Doc->ExportField($this->pr_Activated);
						if ($this->pr_Status->Exportable) $Doc->ExportField($this->pr_Status);
						if ($this->pr_PO->Exportable) $Doc->ExportField($this->pr_PO);
						if ($this->pr_Cost->Exportable) $Doc->ExportField($this->pr_Cost);
						if ($this->pr_intStatus->Exportable) $Doc->ExportField($this->pr_intStatus);
					} else {
						if ($this->pr_Barcode->Exportable) $Doc->ExportField($this->pr_Barcode);
						if ($this->pr_Activated->Exportable) $Doc->ExportField($this->pr_Activated);
						if ($this->pr_Status->Exportable) $Doc->ExportField($this->pr_Status);
						if ($this->pr_PO->Exportable) $Doc->ExportField($this->pr_PO);
						if ($this->pr_Cost->Exportable) $Doc->ExportField($this->pr_Cost);
						if ($this->pr_intStatus->Exportable) $Doc->ExportField($this->pr_intStatus);
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
