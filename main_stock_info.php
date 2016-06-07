<?php

// Global variable for table object
$main_Stock = NULL;

//
// Table class for main_Stock
//
class cmain_Stock extends cTable {
	var $s_ID;
	var $s_LOC;
	var $s_Type;
	var $s_Address;
	var $s_Province;
	var $s_City;
	var $s_PostCode;
	var $u_ID;
	var $s_Created;
	var $s_Update;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'main_Stock';
		$this->TableName = 'main_Stock';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`main_Stock`";
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

		// s_ID
		$this->s_ID = new cField('main_Stock', 'main_Stock', 'x_s_ID', 's_ID', '`s_ID`', '`s_ID`', 3, -1, FALSE, '`s_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s_ID'] = &$this->s_ID;

		// s_LOC
		$this->s_LOC = new cField('main_Stock', 'main_Stock', 'x_s_LOC', 's_LOC', '`s_LOC`', '`s_LOC`', 200, -1, FALSE, '`s_LOC`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['s_LOC'] = &$this->s_LOC;

		// s_Type
		$this->s_Type = new cField('main_Stock', 'main_Stock', 'x_s_Type', 's_Type', '`s_Type`', '`s_Type`', 3, -1, FALSE, '`s_Type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->s_Type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s_Type'] = &$this->s_Type;

		// s_Address
		$this->s_Address = new cField('main_Stock', 'main_Stock', 'x_s_Address', 's_Address', '`s_Address`', '`s_Address`', 200, -1, FALSE, '`s_Address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['s_Address'] = &$this->s_Address;

		// s_Province
		$this->s_Province = new cField('main_Stock', 'main_Stock', 'x_s_Province', 's_Province', '`s_Province`', '`s_Province`', 3, -1, FALSE, '`s_Province`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->s_Province->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s_Province'] = &$this->s_Province;

		// s_City
		$this->s_City = new cField('main_Stock', 'main_Stock', 'x_s_City', 's_City', '`s_City`', '`s_City`', 3, -1, FALSE, '`s_City`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->s_City->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s_City'] = &$this->s_City;

		// s_PostCode
		$this->s_PostCode = new cField('main_Stock', 'main_Stock', 'x_s_PostCode', 's_PostCode', '`s_PostCode`', '`s_PostCode`', 200, -1, FALSE, '`s_PostCode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['s_PostCode'] = &$this->s_PostCode;

		// u_ID
		$this->u_ID = new cField('main_Stock', 'main_Stock', 'x_u_ID', 'u_ID', '`u_ID`', '`u_ID`', 3, -1, FALSE, '`u_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_ID'] = &$this->u_ID;

		// s_Created
		$this->s_Created = new cField('main_Stock', 'main_Stock', 'x_s_Created', 's_Created', '`s_Created`', 'DATE_FORMAT(`s_Created`, \'%d/%m/%Y\')', 135, 7, FALSE, '`s_Created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s_Created->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['s_Created'] = &$this->s_Created;

		// s_Update
		$this->s_Update = new cField('main_Stock', 'main_Stock', 'x_s_Update', 's_Update', '`s_Update`', 'DATE_FORMAT(`s_Update`, \'%d/%m/%Y\')', 135, 7, FALSE, '`s_Update`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s_Update->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['s_Update'] = &$this->s_Update;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`main_Stock`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`s_Province` ASC,`s_City` ASC,`s_LOC` ASC";
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
			if (array_key_exists('s_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('s_ID', $this->DBID) . '=' . ew_QuotedValue($rs['s_ID'], $this->s_ID->FldDataType, $this->DBID));
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
		return "`s_ID` = @s_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->s_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@s_ID@", ew_AdjustSql($this->s_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "main_stock_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "main_stock_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("main_stock_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("main_stock_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "main_stock_add.php?" . $this->UrlParm($parm);
		else
			$url = "main_stock_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("main_stock_edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("main_stock_add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("main_stock_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "s_ID:" . ew_VarToJson($this->s_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->s_ID->CurrentValue)) {
			$sUrl .= "s_ID=" . urlencode($this->s_ID->CurrentValue);
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
			if ($isPost && isset($_POST["s_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["s_ID"]);
			elseif (isset($_GET["s_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["s_ID"]);
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
			$this->s_ID->CurrentValue = $key;
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
		$this->s_ID->setDbValue($rs->fields('s_ID'));
		$this->s_LOC->setDbValue($rs->fields('s_LOC'));
		$this->s_Type->setDbValue($rs->fields('s_Type'));
		$this->s_Address->setDbValue($rs->fields('s_Address'));
		$this->s_Province->setDbValue($rs->fields('s_Province'));
		$this->s_City->setDbValue($rs->fields('s_City'));
		$this->s_PostCode->setDbValue($rs->fields('s_PostCode'));
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->s_Created->setDbValue($rs->fields('s_Created'));
		$this->s_Update->setDbValue($rs->fields('s_Update'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// s_ID
		// s_LOC
		// s_Type
		// s_Address
		// s_Province
		// s_City
		// s_PostCode
		// u_ID
		// s_Created
		// s_Update
		// s_ID

		$this->s_ID->ViewValue = $this->s_ID->CurrentValue;
		$this->s_ID->ViewCustomAttributes = "";

		// s_LOC
		$this->s_LOC->ViewValue = $this->s_LOC->CurrentValue;
		$this->s_LOC->ViewCustomAttributes = "";

		// s_Type
		if (strval($this->s_Type->CurrentValue) <> "") {
			$sFilterWrk = "`wh_ID`" . ew_SearchString("=", $this->s_Type->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `wh_ID`, `wh_Type` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_WHType`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_Type, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_Type->ViewValue = $this->s_Type->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_Type->ViewValue = $this->s_Type->CurrentValue;
			}
		} else {
			$this->s_Type->ViewValue = NULL;
		}
		$this->s_Type->ViewCustomAttributes = "";

		// s_Address
		$this->s_Address->ViewValue = $this->s_Address->CurrentValue;
		$this->s_Address->ViewCustomAttributes = "";

		// s_Province
		if (strval($this->s_Province->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->s_Province->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_Province, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_Province->ViewValue = $this->s_Province->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_Province->ViewValue = $this->s_Province->CurrentValue;
			}
		} else {
			$this->s_Province->ViewValue = NULL;
		}
		$this->s_Province->ViewCustomAttributes = "";

		// s_City
		if (strval($this->s_City->CurrentValue) <> "") {
			$sFilterWrk = "`AMPHUR_ID`" . ew_SearchString("=", $this->s_City->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_amphur`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_City, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_City->ViewValue = $this->s_City->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_City->ViewValue = $this->s_City->CurrentValue;
			}
		} else {
			$this->s_City->ViewValue = NULL;
		}
		$this->s_City->ViewCustomAttributes = "";

		// s_PostCode
		$this->s_PostCode->ViewValue = $this->s_PostCode->CurrentValue;
		$this->s_PostCode->ViewCustomAttributes = "";

		// u_ID
		if (strval($this->u_ID->CurrentValue) <> "") {
			$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->u_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_ID->ViewValue = $this->u_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_ID->ViewValue = $this->u_ID->CurrentValue;
			}
		} else {
			$this->u_ID->ViewValue = NULL;
		}
		$this->u_ID->ViewCustomAttributes = "";

		// s_Created
		$this->s_Created->ViewValue = $this->s_Created->CurrentValue;
		$this->s_Created->ViewValue = ew_FormatDateTime($this->s_Created->ViewValue, 7);
		$this->s_Created->ViewCustomAttributes = "";

		// s_Update
		$this->s_Update->ViewValue = $this->s_Update->CurrentValue;
		$this->s_Update->ViewValue = ew_FormatDateTime($this->s_Update->ViewValue, 7);
		$this->s_Update->ViewCustomAttributes = "";

		// s_ID
		$this->s_ID->LinkCustomAttributes = "";
		$this->s_ID->HrefValue = "";
		$this->s_ID->TooltipValue = "";

		// s_LOC
		$this->s_LOC->LinkCustomAttributes = "";
		$this->s_LOC->HrefValue = "";
		$this->s_LOC->TooltipValue = "";

		// s_Type
		$this->s_Type->LinkCustomAttributes = "";
		$this->s_Type->HrefValue = "";
		$this->s_Type->TooltipValue = "";

		// s_Address
		$this->s_Address->LinkCustomAttributes = "";
		$this->s_Address->HrefValue = "";
		$this->s_Address->TooltipValue = "";

		// s_Province
		$this->s_Province->LinkCustomAttributes = "";
		$this->s_Province->HrefValue = "";
		$this->s_Province->TooltipValue = "";

		// s_City
		$this->s_City->LinkCustomAttributes = "";
		$this->s_City->HrefValue = "";
		$this->s_City->TooltipValue = "";

		// s_PostCode
		$this->s_PostCode->LinkCustomAttributes = "";
		$this->s_PostCode->HrefValue = "";
		$this->s_PostCode->TooltipValue = "";

		// u_ID
		$this->u_ID->LinkCustomAttributes = "";
		$this->u_ID->HrefValue = "";
		$this->u_ID->TooltipValue = "";

		// s_Created
		$this->s_Created->LinkCustomAttributes = "";
		$this->s_Created->HrefValue = "";
		$this->s_Created->TooltipValue = "";

		// s_Update
		$this->s_Update->LinkCustomAttributes = "";
		$this->s_Update->HrefValue = "";
		$this->s_Update->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// s_ID
		$this->s_ID->EditAttrs["class"] = "form-control";
		$this->s_ID->EditCustomAttributes = "";
		$this->s_ID->EditValue = $this->s_ID->CurrentValue;
		$this->s_ID->ViewCustomAttributes = "";

		// s_LOC
		$this->s_LOC->EditAttrs["class"] = "form-control";
		$this->s_LOC->EditCustomAttributes = "";
		$this->s_LOC->EditValue = $this->s_LOC->CurrentValue;
		$this->s_LOC->ViewCustomAttributes = "";

		// s_Type
		$this->s_Type->EditCustomAttributes = "";

		// s_Address
		$this->s_Address->EditAttrs["class"] = "form-control";
		$this->s_Address->EditCustomAttributes = "";
		$this->s_Address->EditValue = $this->s_Address->CurrentValue;
		$this->s_Address->PlaceHolder = ew_RemoveHtml($this->s_Address->FldCaption());

		// s_Province
		$this->s_Province->EditCustomAttributes = "";

		// s_City
		$this->s_City->EditCustomAttributes = "";

		// s_PostCode
		$this->s_PostCode->EditAttrs["class"] = "form-control";
		$this->s_PostCode->EditCustomAttributes = "";
		$this->s_PostCode->EditValue = $this->s_PostCode->CurrentValue;
		$this->s_PostCode->PlaceHolder = ew_RemoveHtml($this->s_PostCode->FldCaption());

		// u_ID
		$this->u_ID->EditCustomAttributes = "";

		// s_Created
		$this->s_Created->EditAttrs["class"] = "form-control";
		$this->s_Created->EditCustomAttributes = "";
		$this->s_Created->EditValue = ew_FormatDateTime($this->s_Created->CurrentValue, 7);
		$this->s_Created->PlaceHolder = ew_RemoveHtml($this->s_Created->FldCaption());

		// s_Update
		$this->s_Update->EditAttrs["class"] = "form-control";
		$this->s_Update->EditCustomAttributes = "";
		$this->s_Update->EditValue = ew_FormatDateTime($this->s_Update->CurrentValue, 7);
		$this->s_Update->PlaceHolder = ew_RemoveHtml($this->s_Update->FldCaption());

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
					if ($this->s_LOC->Exportable) $Doc->ExportCaption($this->s_LOC);
					if ($this->s_Type->Exportable) $Doc->ExportCaption($this->s_Type);
					if ($this->s_Address->Exportable) $Doc->ExportCaption($this->s_Address);
					if ($this->s_Province->Exportable) $Doc->ExportCaption($this->s_Province);
					if ($this->s_City->Exportable) $Doc->ExportCaption($this->s_City);
					if ($this->s_PostCode->Exportable) $Doc->ExportCaption($this->s_PostCode);
					if ($this->u_ID->Exportable) $Doc->ExportCaption($this->u_ID);
				} else {
					if ($this->s_LOC->Exportable) $Doc->ExportCaption($this->s_LOC);
					if ($this->s_Type->Exportable) $Doc->ExportCaption($this->s_Type);
					if ($this->s_Address->Exportable) $Doc->ExportCaption($this->s_Address);
					if ($this->s_Province->Exportable) $Doc->ExportCaption($this->s_Province);
					if ($this->s_City->Exportable) $Doc->ExportCaption($this->s_City);
					if ($this->s_PostCode->Exportable) $Doc->ExportCaption($this->s_PostCode);
					if ($this->u_ID->Exportable) $Doc->ExportCaption($this->u_ID);
					if ($this->s_Created->Exportable) $Doc->ExportCaption($this->s_Created);
					if ($this->s_Update->Exportable) $Doc->ExportCaption($this->s_Update);
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
						if ($this->s_LOC->Exportable) $Doc->ExportField($this->s_LOC);
						if ($this->s_Type->Exportable) $Doc->ExportField($this->s_Type);
						if ($this->s_Address->Exportable) $Doc->ExportField($this->s_Address);
						if ($this->s_Province->Exportable) $Doc->ExportField($this->s_Province);
						if ($this->s_City->Exportable) $Doc->ExportField($this->s_City);
						if ($this->s_PostCode->Exportable) $Doc->ExportField($this->s_PostCode);
						if ($this->u_ID->Exportable) $Doc->ExportField($this->u_ID);
					} else {
						if ($this->s_LOC->Exportable) $Doc->ExportField($this->s_LOC);
						if ($this->s_Type->Exportable) $Doc->ExportField($this->s_Type);
						if ($this->s_Address->Exportable) $Doc->ExportField($this->s_Address);
						if ($this->s_Province->Exportable) $Doc->ExportField($this->s_Province);
						if ($this->s_City->Exportable) $Doc->ExportField($this->s_City);
						if ($this->s_PostCode->Exportable) $Doc->ExportField($this->s_PostCode);
						if ($this->u_ID->Exportable) $Doc->ExportField($this->u_ID);
						if ($this->s_Created->Exportable) $Doc->ExportField($this->s_Created);
						if ($this->s_Update->Exportable) $Doc->ExportField($this->s_Update);
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
