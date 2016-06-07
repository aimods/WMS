<?php

// Global variable for table object
$pending_Msg = NULL;

//
// Table class for pending_Msg
//
class cpending_Msg extends cTable {
	var $sm_ID;
	var $u_ID;
	var $u_sendTo;
	var $u_TextType;
	var $u_sendText;
	var $u_sendSchedule;
	var $u_Status;
	var $u_Create;
	var $u_Sent;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pending_Msg';
		$this->TableName = 'pending_Msg';
		$this->TableType = 'CUSTOMVIEW';

		// Update Table
		$this->UpdateTable = "bot_SendMSG";
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

		// sm_ID
		$this->sm_ID = new cField('pending_Msg', 'pending_Msg', 'x_sm_ID', 'sm_ID', 'bot_SendMSG.sm_ID', 'bot_SendMSG.sm_ID', 3, -1, FALSE, 'bot_SendMSG.sm_ID', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->sm_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sm_ID'] = &$this->sm_ID;

		// u_ID
		$this->u_ID = new cField('pending_Msg', 'pending_Msg', 'x_u_ID', 'u_ID', 'bot_SendMSG.u_ID', 'bot_SendMSG.u_ID', 3, -1, FALSE, 'bot_SendMSG.u_ID', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_ID'] = &$this->u_ID;

		// u_sendTo
		$this->u_sendTo = new cField('pending_Msg', 'pending_Msg', 'x_u_sendTo', 'u_sendTo', 'bot_SendMSG.u_sendTo', 'bot_SendMSG.u_sendTo', 200, -1, FALSE, 'bot_SendMSG.u_sendTo', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['u_sendTo'] = &$this->u_sendTo;

		// u_TextType
		$this->u_TextType = new cField('pending_Msg', 'pending_Msg', 'x_u_TextType', 'u_TextType', 'bot_SendMSG.u_TextType', 'bot_SendMSG.u_TextType', 3, -1, FALSE, 'bot_SendMSG.u_TextType', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_TextType->OptionCount = 5;
		$this->u_TextType->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['u_TextType'] = &$this->u_TextType;

		// u_sendText
		$this->u_sendText = new cField('pending_Msg', 'pending_Msg', 'x_u_sendText', 'u_sendText', 'bot_SendMSG.u_sendText', 'bot_SendMSG.u_sendText', 201, -1, FALSE, 'bot_SendMSG.u_sendText', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['u_sendText'] = &$this->u_sendText;

		// u_sendSchedule
		$this->u_sendSchedule = new cField('pending_Msg', 'pending_Msg', 'x_u_sendSchedule', 'u_sendSchedule', 'bot_SendMSG.u_sendSchedule', 'DATE_FORMAT(bot_SendMSG.u_sendSchedule, \'%d/%m/%Y\')', 135, 7, FALSE, 'bot_SendMSG.u_sendSchedule', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_sendSchedule->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['u_sendSchedule'] = &$this->u_sendSchedule;

		// u_Status
		$this->u_Status = new cField('pending_Msg', 'pending_Msg', 'x_u_Status', 'u_Status', 'bot_SendMSG.u_Status', 'bot_SendMSG.u_Status', 3, -1, FALSE, 'bot_SendMSG.u_Status', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->u_Status->OptionCount = 4;
		$this->fields['u_Status'] = &$this->u_Status;

		// u_Create
		$this->u_Create = new cField('pending_Msg', 'pending_Msg', 'x_u_Create', 'u_Create', 'bot_SendMSG.u_Create', 'DATE_FORMAT(bot_SendMSG.u_Create, \'%d/%m/%Y\')', 135, 7, FALSE, 'bot_SendMSG.u_Create', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_Create->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['u_Create'] = &$this->u_Create;

		// u_Sent
		$this->u_Sent = new cField('pending_Msg', 'pending_Msg', 'x_u_Sent', 'u_Sent', 'bot_SendMSG.u_Sent', 'DATE_FORMAT(bot_SendMSG.u_Sent, \'%d/%m/%Y\')', 135, 7, FALSE, 'bot_SendMSG.u_Sent', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->u_Sent->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['u_Sent'] = &$this->u_Sent;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "bot_SendMSG";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT bot_SendMSG.sm_ID, bot_SendMSG.u_ID, bot_SendMSG.u_sendTo, bot_SendMSG.u_TextType, bot_SendMSG.u_sendText, bot_SendMSG.u_sendSchedule, bot_SendMSG.u_Status, bot_SendMSG.u_Create, bot_SendMSG.u_Sent FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "bot_SendMSG.u_Status <= 0";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "pending_msg_list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pending_msg_list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pending_msg_view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pending_msg_view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pending_msg_add.php?" . $this->UrlParm($parm);
		else
			$url = "pending_msg_add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pending_msg_edit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pending_msg_add.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pending_msg_delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->sm_ID->setDbValue($rs->fields('sm_ID'));
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->u_sendTo->setDbValue($rs->fields('u_sendTo'));
		$this->u_TextType->setDbValue($rs->fields('u_TextType'));
		$this->u_sendText->setDbValue($rs->fields('u_sendText'));
		$this->u_sendSchedule->setDbValue($rs->fields('u_sendSchedule'));
		$this->u_Status->setDbValue($rs->fields('u_Status'));
		$this->u_Create->setDbValue($rs->fields('u_Create'));
		$this->u_Sent->setDbValue($rs->fields('u_Sent'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// sm_ID
		// u_ID
		// u_sendTo
		// u_TextType
		// u_sendText
		// u_sendSchedule
		// u_Status
		// u_Create
		// u_Sent
		// sm_ID

		$this->sm_ID->ViewValue = $this->sm_ID->CurrentValue;
		$this->sm_ID->ViewCustomAttributes = "";

		// u_ID
		$this->u_ID->ViewValue = $this->u_ID->CurrentValue;
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

		// u_sendTo
		$this->u_sendTo->ViewValue = $this->u_sendTo->CurrentValue;
		if (strval($this->u_sendTo->CurrentValue) <> "") {
			$sFilterWrk = "`u_UUID`" . ew_SearchString("=", $this->u_sendTo->CurrentValue, EW_DATATYPE_OTHER, "");
		$sSqlWrk = "SELECT `u_UUID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_sendTo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_sendTo->ViewValue = $this->u_sendTo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_sendTo->ViewValue = $this->u_sendTo->CurrentValue;
			}
		} else {
			$this->u_sendTo->ViewValue = NULL;
		}
		$this->u_sendTo->ViewCustomAttributes = "";

		// u_TextType
		if (strval($this->u_TextType->CurrentValue) <> "") {
			$this->u_TextType->ViewValue = $this->u_TextType->OptionCaption($this->u_TextType->CurrentValue);
		} else {
			$this->u_TextType->ViewValue = NULL;
		}
		$this->u_TextType->ViewCustomAttributes = "";

		// u_sendText
		$this->u_sendText->ViewValue = $this->u_sendText->CurrentValue;
		$this->u_sendText->ViewCustomAttributes = "";

		// u_sendSchedule
		$this->u_sendSchedule->ViewValue = $this->u_sendSchedule->CurrentValue;
		$this->u_sendSchedule->ViewValue = ew_FormatDateTime($this->u_sendSchedule->ViewValue, 7);
		$this->u_sendSchedule->ViewCustomAttributes = "";

		// u_Status
		if (strval($this->u_Status->CurrentValue) <> "") {
			$this->u_Status->ViewValue = $this->u_Status->OptionCaption($this->u_Status->CurrentValue);
		} else {
			$this->u_Status->ViewValue = NULL;
		}
		$this->u_Status->ViewCustomAttributes = "";

		// u_Create
		$this->u_Create->ViewValue = $this->u_Create->CurrentValue;
		$this->u_Create->ViewValue = ew_FormatDateTime($this->u_Create->ViewValue, 7);
		$this->u_Create->ViewCustomAttributes = "";

		// u_Sent
		$this->u_Sent->ViewValue = $this->u_Sent->CurrentValue;
		$this->u_Sent->ViewValue = ew_FormatDateTime($this->u_Sent->ViewValue, 7);
		$this->u_Sent->ViewCustomAttributes = "";

		// sm_ID
		$this->sm_ID->LinkCustomAttributes = "";
		$this->sm_ID->HrefValue = "";
		$this->sm_ID->TooltipValue = "";

		// u_ID
		$this->u_ID->LinkCustomAttributes = "";
		$this->u_ID->HrefValue = "";
		$this->u_ID->TooltipValue = "";

		// u_sendTo
		$this->u_sendTo->LinkCustomAttributes = "";
		$this->u_sendTo->HrefValue = "";
		$this->u_sendTo->TooltipValue = "";

		// u_TextType
		$this->u_TextType->LinkCustomAttributes = "";
		$this->u_TextType->HrefValue = "";
		$this->u_TextType->TooltipValue = "";

		// u_sendText
		$this->u_sendText->LinkCustomAttributes = "";
		$this->u_sendText->HrefValue = "";
		$this->u_sendText->TooltipValue = "";

		// u_sendSchedule
		$this->u_sendSchedule->LinkCustomAttributes = "";
		$this->u_sendSchedule->HrefValue = "";
		$this->u_sendSchedule->TooltipValue = "";

		// u_Status
		$this->u_Status->LinkCustomAttributes = "";
		$this->u_Status->HrefValue = "";
		$this->u_Status->TooltipValue = "";

		// u_Create
		$this->u_Create->LinkCustomAttributes = "";
		$this->u_Create->HrefValue = "";
		$this->u_Create->TooltipValue = "";

		// u_Sent
		$this->u_Sent->LinkCustomAttributes = "";
		$this->u_Sent->HrefValue = "";
		$this->u_Sent->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// sm_ID
		$this->sm_ID->EditAttrs["class"] = "form-control";
		$this->sm_ID->EditCustomAttributes = "";
		$this->sm_ID->EditValue = $this->sm_ID->CurrentValue;
		$this->sm_ID->PlaceHolder = ew_RemoveHtml($this->sm_ID->FldCaption());

		// u_ID
		$this->u_ID->EditAttrs["class"] = "form-control";
		$this->u_ID->EditCustomAttributes = "";
		$this->u_ID->EditValue = $this->u_ID->CurrentValue;
		$this->u_ID->PlaceHolder = ew_RemoveHtml($this->u_ID->FldCaption());

		// u_sendTo
		$this->u_sendTo->EditAttrs["class"] = "form-control";
		$this->u_sendTo->EditCustomAttributes = "";
		$this->u_sendTo->EditValue = $this->u_sendTo->CurrentValue;
		$this->u_sendTo->PlaceHolder = ew_RemoveHtml($this->u_sendTo->FldCaption());

		// u_TextType
		$this->u_TextType->EditAttrs["class"] = "form-control";
		$this->u_TextType->EditCustomAttributes = "";
		$this->u_TextType->EditValue = $this->u_TextType->Options(TRUE);

		// u_sendText
		$this->u_sendText->EditAttrs["class"] = "form-control";
		$this->u_sendText->EditCustomAttributes = "";
		$this->u_sendText->EditValue = $this->u_sendText->CurrentValue;
		$this->u_sendText->PlaceHolder = ew_RemoveHtml($this->u_sendText->FldCaption());

		// u_sendSchedule
		$this->u_sendSchedule->EditAttrs["class"] = "form-control";
		$this->u_sendSchedule->EditCustomAttributes = "";
		$this->u_sendSchedule->EditValue = ew_FormatDateTime($this->u_sendSchedule->CurrentValue, 7);
		$this->u_sendSchedule->PlaceHolder = ew_RemoveHtml($this->u_sendSchedule->FldCaption());

		// u_Status
		$this->u_Status->EditAttrs["class"] = "form-control";
		$this->u_Status->EditCustomAttributes = "";
		$this->u_Status->EditValue = $this->u_Status->Options(TRUE);

		// u_Create
		$this->u_Create->EditAttrs["class"] = "form-control";
		$this->u_Create->EditCustomAttributes = "";
		$this->u_Create->EditValue = $this->u_Create->CurrentValue;
		$this->u_Create->EditValue = ew_FormatDateTime($this->u_Create->EditValue, 7);
		$this->u_Create->ViewCustomAttributes = "";

		// u_Sent
		$this->u_Sent->EditAttrs["class"] = "form-control";
		$this->u_Sent->EditCustomAttributes = "";
		$this->u_Sent->EditValue = $this->u_Sent->CurrentValue;
		$this->u_Sent->EditValue = ew_FormatDateTime($this->u_Sent->EditValue, 7);
		$this->u_Sent->ViewCustomAttributes = "";

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
					if ($this->u_ID->Exportable) $Doc->ExportCaption($this->u_ID);
					if ($this->u_sendTo->Exportable) $Doc->ExportCaption($this->u_sendTo);
					if ($this->u_TextType->Exportable) $Doc->ExportCaption($this->u_TextType);
					if ($this->u_sendText->Exportable) $Doc->ExportCaption($this->u_sendText);
					if ($this->u_sendSchedule->Exportable) $Doc->ExportCaption($this->u_sendSchedule);
					if ($this->u_Status->Exportable) $Doc->ExportCaption($this->u_Status);
					if ($this->u_Create->Exportable) $Doc->ExportCaption($this->u_Create);
				} else {
					if ($this->sm_ID->Exportable) $Doc->ExportCaption($this->sm_ID);
					if ($this->u_sendTo->Exportable) $Doc->ExportCaption($this->u_sendTo);
					if ($this->u_TextType->Exportable) $Doc->ExportCaption($this->u_TextType);
					if ($this->u_sendSchedule->Exportable) $Doc->ExportCaption($this->u_sendSchedule);
					if ($this->u_Status->Exportable) $Doc->ExportCaption($this->u_Status);
					if ($this->u_Sent->Exportable) $Doc->ExportCaption($this->u_Sent);
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
						if ($this->u_ID->Exportable) $Doc->ExportField($this->u_ID);
						if ($this->u_sendTo->Exportable) $Doc->ExportField($this->u_sendTo);
						if ($this->u_TextType->Exportable) $Doc->ExportField($this->u_TextType);
						if ($this->u_sendText->Exportable) $Doc->ExportField($this->u_sendText);
						if ($this->u_sendSchedule->Exportable) $Doc->ExportField($this->u_sendSchedule);
						if ($this->u_Status->Exportable) $Doc->ExportField($this->u_Status);
						if ($this->u_Create->Exportable) $Doc->ExportField($this->u_Create);
					} else {
						if ($this->sm_ID->Exportable) $Doc->ExportField($this->sm_ID);
						if ($this->u_sendTo->Exportable) $Doc->ExportField($this->u_sendTo);
						if ($this->u_TextType->Exportable) $Doc->ExportField($this->u_TextType);
						if ($this->u_sendSchedule->Exportable) $Doc->ExportField($this->u_sendSchedule);
						if ($this->u_Status->Exportable) $Doc->ExportField($this->u_Status);
						if ($this->u_Sent->Exportable) $Doc->ExportField($this->u_Sent);
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
