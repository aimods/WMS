<?php

// Global variable for table object
$lov_amphur = NULL;

//
// Table class for lov_amphur
//
class clov_amphur extends cTable {
	var $AMPHUR_ID;
	var $AMPHUR_CODE;
	var $PROVINCE_ID;
	var $AMPHUR_NAME;
	var $AMPER_NAME_EN;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'lov_amphur';
		$this->TableName = 'lov_amphur';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`lov_amphur`";
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

		// AMPHUR_ID
		$this->AMPHUR_ID = new cField('lov_amphur', 'lov_amphur', 'x_AMPHUR_ID', 'AMPHUR_ID', '`AMPHUR_ID`', '`AMPHUR_ID`', 3, -1, FALSE, '`AMPHUR_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->AMPHUR_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['AMPHUR_ID'] = &$this->AMPHUR_ID;

		// AMPHUR_CODE
		$this->AMPHUR_CODE = new cField('lov_amphur', 'lov_amphur', 'x_AMPHUR_CODE', 'AMPHUR_CODE', '`AMPHUR_CODE`', '`AMPHUR_CODE`', 200, -1, FALSE, '`AMPHUR_CODE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['AMPHUR_CODE'] = &$this->AMPHUR_CODE;

		// PROVINCE_ID
		$this->PROVINCE_ID = new cField('lov_amphur', 'lov_amphur', 'x_PROVINCE_ID', 'PROVINCE_ID', '`PROVINCE_ID`', '`PROVINCE_ID`', 3, -1, FALSE, '`PROVINCE_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->PROVINCE_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['PROVINCE_ID'] = &$this->PROVINCE_ID;

		// AMPHUR_NAME
		$this->AMPHUR_NAME = new cField('lov_amphur', 'lov_amphur', 'x_AMPHUR_NAME', 'AMPHUR_NAME', '`AMPHUR_NAME`', '`AMPHUR_NAME`', 200, -1, FALSE, '`AMPHUR_NAME`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['AMPHUR_NAME'] = &$this->AMPHUR_NAME;

		// AMPER_NAME_EN
		$this->AMPER_NAME_EN = new cField('lov_amphur', 'lov_amphur', 'x_AMPER_NAME_EN', 'AMPER_NAME_EN', '`AMPER_NAME_EN`', '`AMPER_NAME_EN`', 200, -1, FALSE, '`AMPER_NAME_EN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['AMPER_NAME_EN'] = &$this->AMPER_NAME_EN;
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
		if ($this->getCurrentMasterTable() == "lov_province") {
			if ($this->PROVINCE_ID->getSessionValue() <> "")
				$sMasterFilter .= "`PROVINCE_ID`=" . ew_QuotedValue($this->PROVINCE_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "lov_province") {
			if ($this->PROVINCE_ID->getSessionValue() <> "")
				$sDetailFilter .= "`PROVINCE_ID`=" . ew_QuotedValue($this->PROVINCE_ID->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_lov_province() {
		return "`PROVINCE_ID`=@PROVINCE_ID@";
	}

	// Detail filter
	function SqlDetailFilter_lov_province() {
		return "`PROVINCE_ID`=@PROVINCE_ID@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`lov_amphur`";
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
			if (array_key_exists('AMPHUR_ID', $rs))
				ew_AddFilter($where, ew_QuotedName('AMPHUR_ID', $this->DBID) . '=' . ew_QuotedValue($rs['AMPHUR_ID'], $this->AMPHUR_ID->FldDataType, $this->DBID));
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
		return "`AMPHUR_ID` = @AMPHUR_ID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->AMPHUR_ID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@AMPHUR_ID@", ew_AdjustSql($this->AMPHUR_ID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "lov_amphur_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "lov_amphur_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("lov_amphur_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("lov_amphur_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "lov_amphur_add.php?" . $this->UrlParm($parm);
		else
			$url = "lov_amphur_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("lov_amphur_edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("lov_amphur_add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("lov_amphur_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "lov_province" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_PROVINCE_ID=" . urlencode($this->PROVINCE_ID->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "AMPHUR_ID:" . ew_VarToJson($this->AMPHUR_ID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->AMPHUR_ID->CurrentValue)) {
			$sUrl .= "AMPHUR_ID=" . urlencode($this->AMPHUR_ID->CurrentValue);
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
			if ($isPost && isset($_POST["AMPHUR_ID"]))
				$arKeys[] = ew_StripSlashes($_POST["AMPHUR_ID"]);
			elseif (isset($_GET["AMPHUR_ID"]))
				$arKeys[] = ew_StripSlashes($_GET["AMPHUR_ID"]);
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
			$this->AMPHUR_ID->CurrentValue = $key;
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
		$this->AMPHUR_ID->setDbValue($rs->fields('AMPHUR_ID'));
		$this->AMPHUR_CODE->setDbValue($rs->fields('AMPHUR_CODE'));
		$this->PROVINCE_ID->setDbValue($rs->fields('PROVINCE_ID'));
		$this->AMPHUR_NAME->setDbValue($rs->fields('AMPHUR_NAME'));
		$this->AMPER_NAME_EN->setDbValue($rs->fields('AMPER_NAME_EN'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// AMPHUR_ID
		// AMPHUR_CODE
		// PROVINCE_ID
		// AMPHUR_NAME
		// AMPER_NAME_EN
		// AMPHUR_ID

		$this->AMPHUR_ID->ViewValue = $this->AMPHUR_ID->CurrentValue;
		$this->AMPHUR_ID->ViewCustomAttributes = "";

		// AMPHUR_CODE
		$this->AMPHUR_CODE->ViewValue = $this->AMPHUR_CODE->CurrentValue;
		$this->AMPHUR_CODE->ViewCustomAttributes = "";

		// PROVINCE_ID
		if (strval($this->PROVINCE_ID->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->PROVINCE_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->CurrentValue;
			}
		} else {
			$this->PROVINCE_ID->ViewValue = NULL;
		}
		$this->PROVINCE_ID->ViewCustomAttributes = "";

		// AMPHUR_NAME
		$this->AMPHUR_NAME->ViewValue = $this->AMPHUR_NAME->CurrentValue;
		$this->AMPHUR_NAME->ViewCustomAttributes = "";

		// AMPER_NAME_EN
		$this->AMPER_NAME_EN->ViewValue = $this->AMPER_NAME_EN->CurrentValue;
		$this->AMPER_NAME_EN->ViewCustomAttributes = "";

		// AMPHUR_ID
		$this->AMPHUR_ID->LinkCustomAttributes = "";
		$this->AMPHUR_ID->HrefValue = "";
		$this->AMPHUR_ID->TooltipValue = "";

		// AMPHUR_CODE
		$this->AMPHUR_CODE->LinkCustomAttributes = "";
		$this->AMPHUR_CODE->HrefValue = "";
		$this->AMPHUR_CODE->TooltipValue = "";

		// PROVINCE_ID
		$this->PROVINCE_ID->LinkCustomAttributes = "";
		$this->PROVINCE_ID->HrefValue = "";
		$this->PROVINCE_ID->TooltipValue = "";

		// AMPHUR_NAME
		$this->AMPHUR_NAME->LinkCustomAttributes = "";
		$this->AMPHUR_NAME->HrefValue = "";
		$this->AMPHUR_NAME->TooltipValue = "";

		// AMPER_NAME_EN
		$this->AMPER_NAME_EN->LinkCustomAttributes = "";
		$this->AMPER_NAME_EN->HrefValue = "";
		$this->AMPER_NAME_EN->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// AMPHUR_ID
		$this->AMPHUR_ID->EditAttrs["class"] = "form-control";
		$this->AMPHUR_ID->EditCustomAttributes = "";
		$this->AMPHUR_ID->EditValue = $this->AMPHUR_ID->CurrentValue;
		$this->AMPHUR_ID->ViewCustomAttributes = "";

		// AMPHUR_CODE
		$this->AMPHUR_CODE->EditAttrs["class"] = "form-control";
		$this->AMPHUR_CODE->EditCustomAttributes = "";
		$this->AMPHUR_CODE->EditValue = $this->AMPHUR_CODE->CurrentValue;
		$this->AMPHUR_CODE->ViewCustomAttributes = "";

		// PROVINCE_ID
		$this->PROVINCE_ID->EditCustomAttributes = "";
		if ($this->PROVINCE_ID->getSessionValue() <> "") {
			$this->PROVINCE_ID->CurrentValue = $this->PROVINCE_ID->getSessionValue();
		if (strval($this->PROVINCE_ID->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->PROVINCE_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->CurrentValue;
			}
		} else {
			$this->PROVINCE_ID->ViewValue = NULL;
		}
		$this->PROVINCE_ID->ViewCustomAttributes = "";
		} else {
		}

		// AMPHUR_NAME
		$this->AMPHUR_NAME->EditAttrs["class"] = "form-control";
		$this->AMPHUR_NAME->EditCustomAttributes = "";
		$this->AMPHUR_NAME->EditValue = $this->AMPHUR_NAME->CurrentValue;
		$this->AMPHUR_NAME->PlaceHolder = ew_RemoveHtml($this->AMPHUR_NAME->FldCaption());

		// AMPER_NAME_EN
		$this->AMPER_NAME_EN->EditAttrs["class"] = "form-control";
		$this->AMPER_NAME_EN->EditCustomAttributes = "";
		$this->AMPER_NAME_EN->EditValue = $this->AMPER_NAME_EN->CurrentValue;
		$this->AMPER_NAME_EN->PlaceHolder = ew_RemoveHtml($this->AMPER_NAME_EN->FldCaption());

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
					if ($this->AMPHUR_ID->Exportable) $Doc->ExportCaption($this->AMPHUR_ID);
					if ($this->AMPHUR_CODE->Exportable) $Doc->ExportCaption($this->AMPHUR_CODE);
					if ($this->PROVINCE_ID->Exportable) $Doc->ExportCaption($this->PROVINCE_ID);
					if ($this->AMPHUR_NAME->Exportable) $Doc->ExportCaption($this->AMPHUR_NAME);
					if ($this->AMPER_NAME_EN->Exportable) $Doc->ExportCaption($this->AMPER_NAME_EN);
				} else {
					if ($this->AMPHUR_ID->Exportable) $Doc->ExportCaption($this->AMPHUR_ID);
					if ($this->AMPHUR_CODE->Exportable) $Doc->ExportCaption($this->AMPHUR_CODE);
					if ($this->PROVINCE_ID->Exportable) $Doc->ExportCaption($this->PROVINCE_ID);
					if ($this->AMPHUR_NAME->Exportable) $Doc->ExportCaption($this->AMPHUR_NAME);
					if ($this->AMPER_NAME_EN->Exportable) $Doc->ExportCaption($this->AMPER_NAME_EN);
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
						if ($this->AMPHUR_ID->Exportable) $Doc->ExportField($this->AMPHUR_ID);
						if ($this->AMPHUR_CODE->Exportable) $Doc->ExportField($this->AMPHUR_CODE);
						if ($this->PROVINCE_ID->Exportable) $Doc->ExportField($this->PROVINCE_ID);
						if ($this->AMPHUR_NAME->Exportable) $Doc->ExportField($this->AMPHUR_NAME);
						if ($this->AMPER_NAME_EN->Exportable) $Doc->ExportField($this->AMPER_NAME_EN);
					} else {
						if ($this->AMPHUR_ID->Exportable) $Doc->ExportField($this->AMPHUR_ID);
						if ($this->AMPHUR_CODE->Exportable) $Doc->ExportField($this->AMPHUR_CODE);
						if ($this->PROVINCE_ID->Exportable) $Doc->ExportField($this->PROVINCE_ID);
						if ($this->AMPHUR_NAME->Exportable) $Doc->ExportField($this->AMPHUR_NAME);
						if ($this->AMPER_NAME_EN->Exportable) $Doc->ExportField($this->AMPER_NAME_EN);
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
