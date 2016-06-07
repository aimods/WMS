<?php

// Global variable for table object
$main_User = NULL;

//
// Table class for main_User
//
class cmain_User extends cTable {
	var $u_ID;
	var $u_BillName;
	var $u_LoginName;
	var $u_Email;
	var $u_Passwd;
	var $u_Address;
	var $u_Provice;
	var $u_City;
	var $u_Postcode;
	var $u_Mobile;
	var $u_PID;
	var $u_Status;
	var $u_Created;
	var $u_LastUpdate;
	var $u_Profile;
	var $u_level;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'main_User';
		$this->TableName = 'main_User';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`main_User`";
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

		// u_ID
		$this->u_ID = new cField('main_User', 'main_User', 'x_u_ID', 'u_ID', '`u_ID`', '`u_ID`', 3, -1, FALSE, '`u_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->u_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_ID'] = &$this->u_ID;

		// u_BillName
		$this->u_BillName = new cField('main_User', 'main_User', 'x_u_BillName', 'u_BillName', '`u_BillName`', '`u_BillName`', 200, -1, FALSE, '`u_BillName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_BillName'] = &$this->u_BillName;

		// u_LoginName
		$this->u_LoginName = new cField('main_User', 'main_User', 'x_u_LoginName', 'u_LoginName', '`u_LoginName`', '`u_LoginName`', 200, -1, FALSE, '`u_LoginName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_LoginName'] = &$this->u_LoginName;

		// u_Email
		$this->u_Email = new cField('main_User', 'main_User', 'x_u_Email', 'u_Email', '`u_Email`', '`u_Email`', 200, -1, FALSE, '`u_Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_Email'] = &$this->u_Email;

		// u_Passwd
		$this->u_Passwd = new cField('main_User', 'main_User', 'x_u_Passwd', 'u_Passwd', '`u_Passwd`', '`u_Passwd`', 200, -1, FALSE, '`u_Passwd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'PASSWORD');
		$this->fields['u_Passwd'] = &$this->u_Passwd;

		// u_Address
		$this->u_Address = new cField('main_User', 'main_User', 'x_u_Address', 'u_Address', '`u_Address`', '`u_Address`', 200, -1, FALSE, '`u_Address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_Address'] = &$this->u_Address;

		// u_Provice
		$this->u_Provice = new cField('main_User', 'main_User', 'x_u_Provice', 'u_Provice', '`u_Provice`', '`u_Provice`', 3, -1, FALSE, '`u_Provice`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_Provice->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_Provice'] = &$this->u_Provice;

		// u_City
		$this->u_City = new cField('main_User', 'main_User', 'x_u_City', 'u_City', '`u_City`', '`u_City`', 3, -1, FALSE, '`u_City`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_City->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_City'] = &$this->u_City;

		// u_Postcode
		$this->u_Postcode = new cField('main_User', 'main_User', 'x_u_Postcode', 'u_Postcode', '`u_Postcode`', '`u_Postcode`', 200, -1, FALSE, '`u_Postcode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_Postcode'] = &$this->u_Postcode;

		// u_Mobile
		$this->u_Mobile = new cField('main_User', 'main_User', 'x_u_Mobile', 'u_Mobile', '`u_Mobile`', '`u_Mobile`', 200, -1, FALSE, '`u_Mobile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_Mobile'] = &$this->u_Mobile;

		// u_PID
		$this->u_PID = new cField('main_User', 'main_User', 'x_u_PID', 'u_PID', '`u_PID`', '`u_PID`', 200, -1, FALSE, '`u_PID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_PID'] = &$this->u_PID;

		// u_Status
		$this->u_Status = new cField('main_User', 'main_User', 'x_u_Status', 'u_Status', '`u_Status`', '`u_Status`', 3, -1, FALSE, '`u_Status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_Status->OptionCount = 3;
		$this->u_Status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_Status'] = &$this->u_Status;

		// u_Created
		$this->u_Created = new cField('main_User', 'main_User', 'x_u_Created', 'u_Created', '`u_Created`', 'DATE_FORMAT(`u_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`u_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['u_Created'] = &$this->u_Created;

		// u_LastUpdate
		$this->u_LastUpdate = new cField('main_User', 'main_User', 'x_u_LastUpdate', 'u_LastUpdate', '`u_LastUpdate`', 'DATE_FORMAT(`u_LastUpdate`, \'%d/%m/%Y\')', 135, 7, FALSE, '`u_LastUpdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_LastUpdate->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['u_LastUpdate'] = &$this->u_LastUpdate;

		// u_Profile
		$this->u_Profile = new cField('main_User', 'main_User', 'x_u_Profile', 'u_Profile', '`u_Profile`', '`u_Profile`', 201, -1, FALSE, '`u_Profile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['u_Profile'] = &$this->u_Profile;

		// u_level
		$this->u_level = new cField('main_User', 'main_User', 'x_u_level', 'u_level', '`u_level`', '`u_level`', 3, -1, FALSE, '`u_level`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_level->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_level'] = &$this->u_level;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`main_User`";
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'u_Passwd')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'u_Passwd') {
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			if (array_key_exists('u_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('u_ID', $this->DBID) . '=' . ew_QuotedValue($rs['u_ID'], $this->u_ID->FldDataType, $this->DBID));
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
		return "`u_ID` = @u_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->u_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@u_ID@", ew_AdjustSql($this->u_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "main_user_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "main_user_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_user_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_user_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "main_user_add.php?" . $this->UrlParm($parm);
		else
			$url = "main_user_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("main_user_edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("main_user_add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("main_user_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "u_ID:" . ew_VarToJson($this->u_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->u_ID->CurrentValue)) {
			$sUrl .= "u_ID=" . urlencode($this->u_ID->CurrentValue);
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
			if ($isPost && isset($_POST["u_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["u_ID"]);
			elseif (isset($_GET["u_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["u_ID"]);
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
			$this->u_ID->CurrentValue = $key;
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
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->u_BillName->setDbValue($rs->fields('u_BillName'));
		$this->u_LoginName->setDbValue($rs->fields('u_LoginName'));
		$this->u_Email->setDbValue($rs->fields('u_Email'));
		$this->u_Passwd->setDbValue($rs->fields('u_Passwd'));
		$this->u_Address->setDbValue($rs->fields('u_Address'));
		$this->u_Provice->setDbValue($rs->fields('u_Provice'));
		$this->u_City->setDbValue($rs->fields('u_City'));
		$this->u_Postcode->setDbValue($rs->fields('u_Postcode'));
		$this->u_Mobile->setDbValue($rs->fields('u_Mobile'));
		$this->u_PID->setDbValue($rs->fields('u_PID'));
		$this->u_Status->setDbValue($rs->fields('u_Status'));
		$this->u_Created->setDbValue($rs->fields('u_Created'));
		$this->u_LastUpdate->setDbValue($rs->fields('u_LastUpdate'));
		$this->u_Profile->setDbValue($rs->fields('u_Profile'));
		$this->u_level->setDbValue($rs->fields('u_level'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// u_ID
		// u_BillName
		// u_LoginName
		// u_Email
		// u_Passwd
		// u_Address
		// u_Provice
		// u_City
		// u_Postcode
		// u_Mobile
		// u_PID
		// u_Status
		// u_Created
		// u_LastUpdate
		// u_Profile
		// u_level
		// u_ID

		$this->u_ID->ViewValue = $this->u_ID->CurrentValue;
		$this->u_ID->ViewCustomAttributes = "";

		// u_BillName
		$this->u_BillName->ViewValue = $this->u_BillName->CurrentValue;
		$this->u_BillName->ViewCustomAttributes = "";

		// u_LoginName
		$this->u_LoginName->ViewValue = $this->u_LoginName->CurrentValue;
		$this->u_LoginName->ViewCustomAttributes = "";

		// u_Email
		$this->u_Email->ViewValue = $this->u_Email->CurrentValue;
		$this->u_Email->ViewCustomAttributes = "";

		// u_Passwd
		$this->u_Passwd->ViewValue = $Language->Phrase("PasswordMask");
		$this->u_Passwd->ViewCustomAttributes = "";

		// u_Address
		$this->u_Address->ViewValue = $this->u_Address->CurrentValue;
		$this->u_Address->ViewCustomAttributes = "";

		// u_Provice
		if (strval($this->u_Provice->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->u_Provice->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_Provice, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_Provice->ViewValue = $this->u_Provice->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_Provice->ViewValue = $this->u_Provice->CurrentValue;
			}
		} else {
			$this->u_Provice->ViewValue = NULL;
		}
		$this->u_Provice->ViewCustomAttributes = "";

		// u_City
		if (strval($this->u_City->CurrentValue) <> "") {
			$sFilterWrk = "`AMPHUR_ID`" . ew_SearchString("=", $this->u_City->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_amphur`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_City, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_City->ViewValue = $this->u_City->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_City->ViewValue = $this->u_City->CurrentValue;
			}
		} else {
			$this->u_City->ViewValue = NULL;
		}
		$this->u_City->ViewCustomAttributes = "";

		// u_Postcode
		$this->u_Postcode->ViewValue = $this->u_Postcode->CurrentValue;
		$this->u_Postcode->ViewCustomAttributes = "";

		// u_Mobile
		$this->u_Mobile->ViewValue = $this->u_Mobile->CurrentValue;
		$this->u_Mobile->ViewCustomAttributes = "";

		// u_PID
		$this->u_PID->ViewValue = $this->u_PID->CurrentValue;
		$this->u_PID->ViewCustomAttributes = "";

		// u_Status
		if (strval($this->u_Status->CurrentValue) <> "") {
			$this->u_Status->ViewValue = $this->u_Status->OptionCaption($this->u_Status->CurrentValue);
		} else {
			$this->u_Status->ViewValue = NULL;
		}
		$this->u_Status->ViewCustomAttributes = "";

		// u_Created
		$this->u_Created->ViewValue = $this->u_Created->CurrentValue;
		$this->u_Created->ViewValue = ew_FormatDateTime($this->u_Created->ViewValue, 7);
		$this->u_Created->ViewCustomAttributes = "";

		// u_LastUpdate
		$this->u_LastUpdate->ViewValue = $this->u_LastUpdate->CurrentValue;
		$this->u_LastUpdate->ViewValue = ew_FormatDateTime($this->u_LastUpdate->ViewValue, 7);
		$this->u_LastUpdate->ViewCustomAttributes = "";

		// u_Profile
		$this->u_Profile->ViewValue = $this->u_Profile->CurrentValue;
		$this->u_Profile->ViewCustomAttributes = "";

		// u_level
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->u_level->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->u_level->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_level, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_level->ViewValue = $this->u_level->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_level->ViewValue = $this->u_level->CurrentValue;
			}
		} else {
			$this->u_level->ViewValue = NULL;
		}
		} else {
			$this->u_level->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->u_level->ViewCustomAttributes = "";

		// u_ID
		$this->u_ID->LinkCustomAttributes = "";
		$this->u_ID->HrefValue = "";
		$this->u_ID->TooltipValue = "";

		// u_BillName
		$this->u_BillName->LinkCustomAttributes = "";
		$this->u_BillName->HrefValue = "";
		$this->u_BillName->TooltipValue = "";

		// u_LoginName
		$this->u_LoginName->LinkCustomAttributes = "";
		$this->u_LoginName->HrefValue = "";
		$this->u_LoginName->TooltipValue = "";

		// u_Email
		$this->u_Email->LinkCustomAttributes = "";
		if (!ew_Empty($this->u_Email->CurrentValue)) {
			$this->u_Email->HrefValue = "mailto:" . $this->u_Email->CurrentValue; // Add prefix/suffix
			$this->u_Email->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->u_Email->HrefValue = ew_ConvertFullUrl($this->u_Email->HrefValue);
		} else {
			$this->u_Email->HrefValue = "";
		}
		$this->u_Email->TooltipValue = "";

		// u_Passwd
		$this->u_Passwd->LinkCustomAttributes = "";
		$this->u_Passwd->HrefValue = "";
		$this->u_Passwd->TooltipValue = "";

		// u_Address
		$this->u_Address->LinkCustomAttributes = "";
		$this->u_Address->HrefValue = "";
		$this->u_Address->TooltipValue = "";

		// u_Provice
		$this->u_Provice->LinkCustomAttributes = "";
		$this->u_Provice->HrefValue = "";
		$this->u_Provice->TooltipValue = "";

		// u_City
		$this->u_City->LinkCustomAttributes = "";
		$this->u_City->HrefValue = "";
		$this->u_City->TooltipValue = "";

		// u_Postcode
		$this->u_Postcode->LinkCustomAttributes = "";
		$this->u_Postcode->HrefValue = "";
		$this->u_Postcode->TooltipValue = "";

		// u_Mobile
		$this->u_Mobile->LinkCustomAttributes = "";
		if (!ew_Empty($this->u_Mobile->CurrentValue)) {
			$this->u_Mobile->HrefValue = "tel:" . $this->u_Mobile->CurrentValue; // Add prefix/suffix
			$this->u_Mobile->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->u_Mobile->HrefValue = ew_ConvertFullUrl($this->u_Mobile->HrefValue);
		} else {
			$this->u_Mobile->HrefValue = "";
		}
		$this->u_Mobile->TooltipValue = "";

		// u_PID
		$this->u_PID->LinkCustomAttributes = "";
		$this->u_PID->HrefValue = "";
		$this->u_PID->TooltipValue = "";

		// u_Status
		$this->u_Status->LinkCustomAttributes = "";
		$this->u_Status->HrefValue = "";
		$this->u_Status->TooltipValue = "";

		// u_Created
		$this->u_Created->LinkCustomAttributes = "";
		$this->u_Created->HrefValue = "";
		$this->u_Created->TooltipValue = "";

		// u_LastUpdate
		$this->u_LastUpdate->LinkCustomAttributes = "";
		$this->u_LastUpdate->HrefValue = "";
		$this->u_LastUpdate->TooltipValue = "";

		// u_Profile
		$this->u_Profile->LinkCustomAttributes = "";
		$this->u_Profile->HrefValue = "";
		$this->u_Profile->TooltipValue = "";

		// u_level
		$this->u_level->LinkCustomAttributes = "";
		$this->u_level->HrefValue = "";
		$this->u_level->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// u_ID
		$this->u_ID->EditAttrs["class"] = "form-control";
		$this->u_ID->EditCustomAttributes = "";
		$this->u_ID->EditValue = $this->u_ID->CurrentValue;
		$this->u_ID->ViewCustomAttributes = "";

		// u_BillName
		$this->u_BillName->EditAttrs["class"] = "form-control";
		$this->u_BillName->EditCustomAttributes = "";
		$this->u_BillName->EditValue = $this->u_BillName->CurrentValue;
		$this->u_BillName->PlaceHolder = ew_RemoveHtml($this->u_BillName->FldCaption());

		// u_LoginName
		$this->u_LoginName->EditAttrs["class"] = "form-control";
		$this->u_LoginName->EditCustomAttributes = "";
		$this->u_LoginName->EditValue = $this->u_LoginName->CurrentValue;
		$this->u_LoginName->ViewCustomAttributes = "";

		// u_Email
		$this->u_Email->EditAttrs["class"] = "form-control";
		$this->u_Email->EditCustomAttributes = "";
		$this->u_Email->EditValue = $this->u_Email->CurrentValue;
		$this->u_Email->ViewCustomAttributes = "";

		// u_Passwd
		$this->u_Passwd->EditAttrs["class"] = "form-control ewPasswordStrength";
		$this->u_Passwd->EditCustomAttributes = "";
		$this->u_Passwd->EditValue = $this->u_Passwd->CurrentValue;
		$this->u_Passwd->PlaceHolder = ew_RemoveHtml($this->u_Passwd->FldCaption());

		// u_Address
		$this->u_Address->EditAttrs["class"] = "form-control";
		$this->u_Address->EditCustomAttributes = "";
		$this->u_Address->EditValue = $this->u_Address->CurrentValue;
		$this->u_Address->PlaceHolder = ew_RemoveHtml($this->u_Address->FldCaption());

		// u_Provice
		$this->u_Provice->EditCustomAttributes = "";

		// u_City
		$this->u_City->EditCustomAttributes = "";

		// u_Postcode
		$this->u_Postcode->EditAttrs["class"] = "form-control";
		$this->u_Postcode->EditCustomAttributes = "";
		$this->u_Postcode->EditValue = $this->u_Postcode->CurrentValue;
		$this->u_Postcode->PlaceHolder = ew_RemoveHtml($this->u_Postcode->FldCaption());

		// u_Mobile
		$this->u_Mobile->EditAttrs["class"] = "form-control";
		$this->u_Mobile->EditCustomAttributes = "";
		$this->u_Mobile->EditValue = $this->u_Mobile->CurrentValue;
		$this->u_Mobile->PlaceHolder = ew_RemoveHtml($this->u_Mobile->FldCaption());

		// u_PID
		$this->u_PID->EditAttrs["class"] = "form-control";
		$this->u_PID->EditCustomAttributes = "";
		$this->u_PID->EditValue = $this->u_PID->CurrentValue;
		$this->u_PID->PlaceHolder = ew_RemoveHtml($this->u_PID->FldCaption());

		// u_Status
		$this->u_Status->EditAttrs["class"] = "form-control";
		$this->u_Status->EditCustomAttributes = "";
		$this->u_Status->EditValue = $this->u_Status->Options(TRUE);

		// u_Created
		$this->u_Created->EditAttrs["class"] = "form-control";
		$this->u_Created->EditCustomAttributes = "";
		$this->u_Created->EditValue = ew_FormatDateTime($this->u_Created->CurrentValue, 7);
		$this->u_Created->PlaceHolder = ew_RemoveHtml($this->u_Created->FldCaption());

		// u_LastUpdate
		$this->u_LastUpdate->EditAttrs["class"] = "form-control";
		$this->u_LastUpdate->EditCustomAttributes = "";
		$this->u_LastUpdate->EditValue = ew_FormatDateTime($this->u_LastUpdate->CurrentValue, 7);
		$this->u_LastUpdate->PlaceHolder = ew_RemoveHtml($this->u_LastUpdate->FldCaption());

		// u_Profile
		$this->u_Profile->EditAttrs["class"] = "form-control";
		$this->u_Profile->EditCustomAttributes = "";
		$this->u_Profile->EditValue = $this->u_Profile->CurrentValue;
		$this->u_Profile->PlaceHolder = ew_RemoveHtml($this->u_Profile->FldCaption());

		// u_level
		$this->u_level->EditAttrs["class"] = "form-control";
		$this->u_level->EditCustomAttributes = "";
		if (!$Security->CanAdmin()) { // System admin
			$this->u_level->EditValue = $Language->Phrase("PasswordMask");
		} else {
		}

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
					if ($this->u_BillName->Exportable) $Doc->ExportCaption($this->u_BillName);
					if ($this->u_Email->Exportable) $Doc->ExportCaption($this->u_Email);
					if ($this->u_Address->Exportable) $Doc->ExportCaption($this->u_Address);
					if ($this->u_Provice->Exportable) $Doc->ExportCaption($this->u_Provice);
					if ($this->u_City->Exportable) $Doc->ExportCaption($this->u_City);
					if ($this->u_Postcode->Exportable) $Doc->ExportCaption($this->u_Postcode);
					if ($this->u_Mobile->Exportable) $Doc->ExportCaption($this->u_Mobile);
				} else {
					if ($this->u_BillName->Exportable) $Doc->ExportCaption($this->u_BillName);
					if ($this->u_Email->Exportable) $Doc->ExportCaption($this->u_Email);
					if ($this->u_Mobile->Exportable) $Doc->ExportCaption($this->u_Mobile);
					if ($this->u_Status->Exportable) $Doc->ExportCaption($this->u_Status);
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
						if ($this->u_BillName->Exportable) $Doc->ExportField($this->u_BillName);
						if ($this->u_Email->Exportable) $Doc->ExportField($this->u_Email);
						if ($this->u_Address->Exportable) $Doc->ExportField($this->u_Address);
						if ($this->u_Provice->Exportable) $Doc->ExportField($this->u_Provice);
						if ($this->u_City->Exportable) $Doc->ExportField($this->u_City);
						if ($this->u_Postcode->Exportable) $Doc->ExportField($this->u_Postcode);
						if ($this->u_Mobile->Exportable) $Doc->ExportField($this->u_Mobile);
					} else {
						if ($this->u_BillName->Exportable) $Doc->ExportField($this->u_BillName);
						if ($this->u_Email->Exportable) $Doc->ExportField($this->u_Email);
						if ($this->u_Mobile->Exportable) $Doc->ExportField($this->u_Mobile);
						if ($this->u_Status->Exportable) $Doc->ExportField($this->u_Status);
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

	// Send register email
	function SendRegisterEmail($row) {
		$Email = $this->PrepareRegisterEmail($row);
		$Args = array();
		$Args["rs"] = $row;
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $Args)) // NOTE: use Email_Sending server event of user table
			$bEmailSent = $Email->Send();
		return $bEmailSent;
	}

	// Prepare register email
	function PrepareRegisterEmail($row = NULL, $langid = "") {
		$Email = new cEmail;
		$Email->Load(EW_EMAIL_REGISTER_TEMPLATE, $langid);
		$sReceiverEmail = ($row == NULL) ? $this->u_Email->CurrentValue : $row['u_Email'];
		if ($sReceiverEmail == "") { // Send to recipient directly
			$sReceiverEmail = EW_RECIPIENT_EMAIL;
			$sBccEmail = "";
		} else { // Bcc recipient
			$sBccEmail = EW_RECIPIENT_EMAIL;
		}
		$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
		$Email->ReplaceRecipient($sReceiverEmail); // Replace Recipient
		if ($sBccEmail <> "") $Email->AddBcc($sBccEmail); // Add Bcc
		$Email->ReplaceContent('<!--FieldCaption_u_BillName-->', $this->u_BillName->FldCaption());
		$Email->ReplaceContent('<!--u_BillName-->', ($row == NULL) ? strval($this->u_BillName->FormValue) : $row['u_BillName']);
		$Email->ReplaceContent('<!--FieldCaption_u_LoginName-->', $this->u_LoginName->FldCaption());
		$Email->ReplaceContent('<!--u_LoginName-->', ($row == NULL) ? strval($this->u_LoginName->FormValue) : $row['u_LoginName']);
		$Email->ReplaceContent('<!--FieldCaption_u_Email-->', $this->u_Email->FldCaption());
		$Email->ReplaceContent('<!--u_Email-->', ($row == NULL) ? strval($this->u_Email->FormValue) : $row['u_Email']);
		$Email->ReplaceContent('<!--FieldCaption_u_Passwd-->', $this->u_Passwd->FldCaption());
		$Email->ReplaceContent('<!--u_Passwd-->', ($row == NULL) ? strval($this->u_Passwd->FormValue) : $row['u_Passwd']);
		$Email->ReplaceContent('<!--FieldCaption_u_Address-->', $this->u_Address->FldCaption());
		$Email->ReplaceContent('<!--u_Address-->', ($row == NULL) ? strval($this->u_Address->FormValue) : $row['u_Address']);
		$Email->ReplaceContent('<!--FieldCaption_u_Provice-->', $this->u_Provice->FldCaption());
		$Email->ReplaceContent('<!--u_Provice-->', ($row == NULL) ? strval($this->u_Provice->FormValue) : $row['u_Provice']);
		$Email->ReplaceContent('<!--FieldCaption_u_City-->', $this->u_City->FldCaption());
		$Email->ReplaceContent('<!--u_City-->', ($row == NULL) ? strval($this->u_City->FormValue) : $row['u_City']);
		$Email->ReplaceContent('<!--FieldCaption_u_Postcode-->', $this->u_Postcode->FldCaption());
		$Email->ReplaceContent('<!--u_Postcode-->', ($row == NULL) ? strval($this->u_Postcode->FormValue) : $row['u_Postcode']);
		$Email->ReplaceContent('<!--FieldCaption_u_Mobile-->', $this->u_Mobile->FldCaption());
		$Email->ReplaceContent('<!--u_Mobile-->', ($row == NULL) ? strval($this->u_Mobile->FormValue) : $row['u_Mobile']);
		$Email->ReplaceContent('<!--FieldCaption_u_PID-->', $this->u_PID->FldCaption());
		$Email->ReplaceContent('<!--u_PID-->', ($row == NULL) ? strval($this->u_PID->FormValue) : $row['u_PID']);
		$sLoginID = ($row == NULL) ? $this->u_LoginName->CurrentValue : $row['u_LoginName'];
		$sPassword = ($row == NULL) ? $this->u_Passwd->CurrentValue : $row['u_Passwd'];
		$sActivateLink = ew_ConvertFullUrl("register.php") . "?action=confirm";
		$sActivateLink .= "&email=" . $sReceiverEmail;
		$sToken = ew_Encrypt($sReceiverEmail) . "," . ew_Encrypt($sLoginID) . "," . ew_Encrypt($sPassword);
		$sActivateLink .= "&token=" . $sToken;
		$Email->ReplaceContent("<!--ActivateLink-->", $sActivateLink);
		$Email->Content = preg_replace('/<!--\s*register_activate_link[\s\S]*?-->/i', '', $Email->Content); // Remove comments
		return $Email;
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
