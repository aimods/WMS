<?php

// Global variable for table object
$main_Vendor = NULL;

//
// Table class for main_Vendor
//
class cmain_Vendor extends cTable {
	var $v_ID;
	var $v_Name;
	var $v_TAX;
	var $v_Country;
	var $v_BillingAddress;
	var $v_Contact;
	var $v_Created;
	var $v_Updated;
	var $v_Note;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'main_Vendor';
		$this->TableName = 'main_Vendor';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`main_Vendor`";
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

		// v_ID
		$this->v_ID = new cField('main_Vendor', 'main_Vendor', 'x_v_ID', 'v_ID', '`v_ID`', '`v_ID`', 3, -1, FALSE, '`v_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->v_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['v_ID'] = &$this->v_ID;

		// v_Name
		$this->v_Name = new cField('main_Vendor', 'main_Vendor', 'x_v_Name', 'v_Name', '`v_Name`', '`v_Name`', 200, -1, FALSE, '`v_Name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['v_Name'] = &$this->v_Name;

		// v_TAX
		$this->v_TAX = new cField('main_Vendor', 'main_Vendor', 'x_v_TAX', 'v_TAX', '`v_TAX`', '`v_TAX`', 200, -1, FALSE, '`v_TAX`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['v_TAX'] = &$this->v_TAX;

		// v_Country
		$this->v_Country = new cField('main_Vendor', 'main_Vendor', 'x_v_Country', 'v_Country', '`v_Country`', '`v_Country`', 3, -1, FALSE, '`v_Country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->v_Country->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['v_Country'] = &$this->v_Country;

		// v_BillingAddress
		$this->v_BillingAddress = new cField('main_Vendor', 'main_Vendor', 'x_v_BillingAddress', 'v_BillingAddress', '`v_BillingAddress`', '`v_BillingAddress`', 201, -1, FALSE, '`v_BillingAddress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['v_BillingAddress'] = &$this->v_BillingAddress;

		// v_Contact
		$this->v_Contact = new cField('main_Vendor', 'main_Vendor', 'x_v_Contact', 'v_Contact', '`v_Contact`', '`v_Contact`', 3, -1, FALSE, '`v_Contact`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->v_Contact->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['v_Contact'] = &$this->v_Contact;

		// v_Created
		$this->v_Created = new cField('main_Vendor', 'main_Vendor', 'x_v_Created', 'v_Created', '`v_Created`', 'DATE_FORMAT(`v_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`v_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['v_Created'] = &$this->v_Created;

		// v_Updated
		$this->v_Updated = new cField('main_Vendor', 'main_Vendor', 'x_v_Updated', 'v_Updated', '`v_Updated`', 'DATE_FORMAT(`v_Updated`, \'%d/%m/%Y\')', 135, 7, FALSE, '`v_Updated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_Updated->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['v_Updated'] = &$this->v_Updated;

		// v_Note
		$this->v_Note = new cField('main_Vendor', 'main_Vendor', 'x_v_Note', 'v_Note', '`v_Note`', '`v_Note`', 201, -1, FALSE, '`v_Note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['v_Note'] = &$this->v_Note;
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
			$sDetailUrl .= "&fk_v_ID=" . urlencode($this->v_ID->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "main_vendor_list.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`main_Vendor`";
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
			if (array_key_exists('v_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('v_ID', $this->DBID) . '=' . ew_QuotedValue($rs['v_ID'], $this->v_ID->FldDataType, $this->DBID));
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
		return "`v_ID` = @v_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->v_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@v_ID@", ew_AdjustSql($this->v_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "main_vendor_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "main_vendor_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_vendor_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_vendor_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "main_vendor_add.php?" . $this->UrlParm($parm);
		else
			$url = "main_vendor_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_vendor_edit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_vendor_edit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("main_vendor_add.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_vendor_add.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("main_vendor_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "v_ID:" . ew_VarToJson($this->v_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->v_ID->CurrentValue)) {
			$sUrl .= "v_ID=" . urlencode($this->v_ID->CurrentValue);
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
			if ($isPost && isset($_POST["v_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["v_ID"]);
			elseif (isset($_GET["v_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["v_ID"]);
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
			$this->v_ID->CurrentValue = $key;
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
		$this->v_ID->setDbValue($rs->fields('v_ID'));
		$this->v_Name->setDbValue($rs->fields('v_Name'));
		$this->v_TAX->setDbValue($rs->fields('v_TAX'));
		$this->v_Country->setDbValue($rs->fields('v_Country'));
		$this->v_BillingAddress->setDbValue($rs->fields('v_BillingAddress'));
		$this->v_Contact->setDbValue($rs->fields('v_Contact'));
		$this->v_Created->setDbValue($rs->fields('v_Created'));
		$this->v_Updated->setDbValue($rs->fields('v_Updated'));
		$this->v_Note->setDbValue($rs->fields('v_Note'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// v_ID
		// v_Name
		// v_TAX
		// v_Country
		// v_BillingAddress
		// v_Contact
		// v_Created
		// v_Updated
		// v_Note
		// v_ID

		$this->v_ID->ViewValue = $this->v_ID->CurrentValue;
		$this->v_ID->ViewCustomAttributes = "";

		// v_Name
		$this->v_Name->ViewValue = $this->v_Name->CurrentValue;
		$this->v_Name->ViewCustomAttributes = "";

		// v_TAX
		$this->v_TAX->ViewValue = $this->v_TAX->CurrentValue;
		$this->v_TAX->ViewCustomAttributes = "";

		// v_Country
		if (strval($this->v_Country->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->v_Country->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `countryName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_countries`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_Country, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `countryName`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_Country->ViewValue = $this->v_Country->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_Country->ViewValue = $this->v_Country->CurrentValue;
			}
		} else {
			$this->v_Country->ViewValue = NULL;
		}
		$this->v_Country->ViewCustomAttributes = "";

		// v_BillingAddress
		$this->v_BillingAddress->ViewValue = $this->v_BillingAddress->CurrentValue;
		$this->v_BillingAddress->ViewCustomAttributes = "";

		// v_Contact
		if (strval($this->v_Contact->CurrentValue) <> "") {
			$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->v_Contact->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_Contact, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_Contact->ViewValue = $this->v_Contact->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_Contact->ViewValue = $this->v_Contact->CurrentValue;
			}
		} else {
			$this->v_Contact->ViewValue = NULL;
		}
		$this->v_Contact->ViewCustomAttributes = "";

		// v_Created
		$this->v_Created->ViewValue = $this->v_Created->CurrentValue;
		$this->v_Created->ViewValue = ew_FormatDateTime($this->v_Created->ViewValue, 7);
		$this->v_Created->ViewCustomAttributes = "";

		// v_Updated
		$this->v_Updated->ViewValue = $this->v_Updated->CurrentValue;
		$this->v_Updated->ViewValue = ew_FormatDateTime($this->v_Updated->ViewValue, 7);
		$this->v_Updated->ViewCustomAttributes = "";

		// v_Note
		$this->v_Note->ViewValue = $this->v_Note->CurrentValue;
		$this->v_Note->ViewCustomAttributes = "";

		// v_ID
		$this->v_ID->LinkCustomAttributes = "";
		$this->v_ID->HrefValue = "";
		$this->v_ID->TooltipValue = "";

		// v_Name
		$this->v_Name->LinkCustomAttributes = "";
		$this->v_Name->HrefValue = "";
		$this->v_Name->TooltipValue = "";

		// v_TAX
		$this->v_TAX->LinkCustomAttributes = "";
		$this->v_TAX->HrefValue = "";
		$this->v_TAX->TooltipValue = "";

		// v_Country
		$this->v_Country->LinkCustomAttributes = "";
		$this->v_Country->HrefValue = "";
		$this->v_Country->TooltipValue = "";

		// v_BillingAddress
		$this->v_BillingAddress->LinkCustomAttributes = "";
		$this->v_BillingAddress->HrefValue = "";
		$this->v_BillingAddress->TooltipValue = "";

		// v_Contact
		$this->v_Contact->LinkCustomAttributes = "";
		if (!ew_Empty($this->v_Contact->CurrentValue)) {
			$this->v_Contact->HrefValue = "main_user_view.php?showdetail=&u_ID=" . $this->v_Contact->CurrentValue; // Add prefix/suffix
			$this->v_Contact->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->v_Contact->HrefValue = ew_ConvertFullUrl($this->v_Contact->HrefValue);
		} else {
			$this->v_Contact->HrefValue = "";
		}
		$this->v_Contact->TooltipValue = "";

		// v_Created
		$this->v_Created->LinkCustomAttributes = "";
		$this->v_Created->HrefValue = "";
		$this->v_Created->TooltipValue = "";

		// v_Updated
		$this->v_Updated->LinkCustomAttributes = "";
		$this->v_Updated->HrefValue = "";
		$this->v_Updated->TooltipValue = "";

		// v_Note
		$this->v_Note->LinkCustomAttributes = "";
		$this->v_Note->HrefValue = "";
		$this->v_Note->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// v_ID
		$this->v_ID->EditAttrs["class"] = "form-control";
		$this->v_ID->EditCustomAttributes = "";
		$this->v_ID->EditValue = $this->v_ID->CurrentValue;
		$this->v_ID->ViewCustomAttributes = "";

		// v_Name
		$this->v_Name->EditAttrs["class"] = "form-control";
		$this->v_Name->EditCustomAttributes = "";
		$this->v_Name->EditValue = $this->v_Name->CurrentValue;
		$this->v_Name->PlaceHolder = ew_RemoveHtml($this->v_Name->FldCaption());

		// v_TAX
		$this->v_TAX->EditAttrs["class"] = "form-control";
		$this->v_TAX->EditCustomAttributes = "";
		$this->v_TAX->EditValue = $this->v_TAX->CurrentValue;
		$this->v_TAX->PlaceHolder = ew_RemoveHtml($this->v_TAX->FldCaption());

		// v_Country
		$this->v_Country->EditCustomAttributes = "";

		// v_BillingAddress
		$this->v_BillingAddress->EditAttrs["class"] = "form-control";
		$this->v_BillingAddress->EditCustomAttributes = "";
		$this->v_BillingAddress->EditValue = $this->v_BillingAddress->CurrentValue;
		$this->v_BillingAddress->PlaceHolder = ew_RemoveHtml($this->v_BillingAddress->FldCaption());

		// v_Contact
		$this->v_Contact->EditCustomAttributes = "";

		// v_Created
		$this->v_Created->EditAttrs["class"] = "form-control";
		$this->v_Created->EditCustomAttributes = "";
		$this->v_Created->EditValue = ew_FormatDateTime($this->v_Created->CurrentValue, 7);
		$this->v_Created->PlaceHolder = ew_RemoveHtml($this->v_Created->FldCaption());

		// v_Updated
		$this->v_Updated->EditAttrs["class"] = "form-control";
		$this->v_Updated->EditCustomAttributes = "";
		$this->v_Updated->EditValue = ew_FormatDateTime($this->v_Updated->CurrentValue, 7);
		$this->v_Updated->PlaceHolder = ew_RemoveHtml($this->v_Updated->FldCaption());

		// v_Note
		$this->v_Note->EditAttrs["class"] = "form-control";
		$this->v_Note->EditCustomAttributes = "";
		$this->v_Note->EditValue = $this->v_Note->CurrentValue;
		$this->v_Note->PlaceHolder = ew_RemoveHtml($this->v_Note->FldCaption());

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
					if ($this->v_ID->Exportable) $Doc->ExportCaption($this->v_ID);
					if ($this->v_Name->Exportable) $Doc->ExportCaption($this->v_Name);
					if ($this->v_TAX->Exportable) $Doc->ExportCaption($this->v_TAX);
					if ($this->v_Country->Exportable) $Doc->ExportCaption($this->v_Country);
					if ($this->v_BillingAddress->Exportable) $Doc->ExportCaption($this->v_BillingAddress);
					if ($this->v_Contact->Exportable) $Doc->ExportCaption($this->v_Contact);
					if ($this->v_Note->Exportable) $Doc->ExportCaption($this->v_Note);
				} else {
					if ($this->v_Name->Exportable) $Doc->ExportCaption($this->v_Name);
					if ($this->v_TAX->Exportable) $Doc->ExportCaption($this->v_TAX);
					if ($this->v_Country->Exportable) $Doc->ExportCaption($this->v_Country);
					if ($this->v_Contact->Exportable) $Doc->ExportCaption($this->v_Contact);
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
						if ($this->v_ID->Exportable) $Doc->ExportField($this->v_ID);
						if ($this->v_Name->Exportable) $Doc->ExportField($this->v_Name);
						if ($this->v_TAX->Exportable) $Doc->ExportField($this->v_TAX);
						if ($this->v_Country->Exportable) $Doc->ExportField($this->v_Country);
						if ($this->v_BillingAddress->Exportable) $Doc->ExportField($this->v_BillingAddress);
						if ($this->v_Contact->Exportable) $Doc->ExportField($this->v_Contact);
						if ($this->v_Note->Exportable) $Doc->ExportField($this->v_Note);
					} else {
						if ($this->v_Name->Exportable) $Doc->ExportField($this->v_Name);
						if ($this->v_TAX->Exportable) $Doc->ExportField($this->v_TAX);
						if ($this->v_Country->Exportable) $Doc->ExportField($this->v_Country);
						if ($this->v_Contact->Exportable) $Doc->ExportField($this->v_Contact);
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
