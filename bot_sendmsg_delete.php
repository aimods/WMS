<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "bot_sendmsg_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$bot_SendMSG_delete = NULL; // Initialize page object first

class cbot_SendMSG_delete extends cbot_SendMSG {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'bot_SendMSG';

	// Page object name
	var $PageObjName = 'bot_SendMSG_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (bot_SendMSG)
		if (!isset($GLOBALS["bot_SendMSG"]) || get_class($GLOBALS["bot_SendMSG"]) == "cbot_SendMSG") {
			$GLOBALS["bot_SendMSG"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["bot_SendMSG"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bot_SendMSG', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (main_User)
		if (!isset($UserTable)) {
			$UserTable = new cmain_User();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("bot_sendmsg_list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Update last accessed time
		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {
		} else {
			echo $Language->Phrase("UserProfileCorrupted");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $bot_SendMSG;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($bot_SendMSG);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("bot_sendmsg_list.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in bot_SendMSG class, bot_SendMSGinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("bot_sendmsg_list.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->sm_ID->setDbValue($rs->fields('sm_ID'));
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->u_sendTo->setDbValue($rs->fields('u_sendTo'));
		$this->u_TextType->setDbValue($rs->fields('u_TextType'));
		$this->u_sendText->setDbValue($rs->fields('u_sendText'));
		$this->u_sendSchedule->setDbValue($rs->fields('u_sendSchedule'));
		$this->u_Create->setDbValue($rs->fields('u_Create'));
		$this->u_Sent->setDbValue($rs->fields('u_Sent'));
		$this->u_Status->setDbValue($rs->fields('u_Status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->sm_ID->DbValue = $row['sm_ID'];
		$this->u_ID->DbValue = $row['u_ID'];
		$this->u_sendTo->DbValue = $row['u_sendTo'];
		$this->u_TextType->DbValue = $row['u_TextType'];
		$this->u_sendText->DbValue = $row['u_sendText'];
		$this->u_sendSchedule->DbValue = $row['u_sendSchedule'];
		$this->u_Create->DbValue = $row['u_Create'];
		$this->u_Sent->DbValue = $row['u_Sent'];
		$this->u_Status->DbValue = $row['u_Status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// sm_ID
		// u_ID
		// u_sendTo
		// u_TextType
		// u_sendText
		// u_sendSchedule
		// u_Create
		// u_Sent
		// u_Status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// sm_ID
		$this->sm_ID->ViewValue = $this->sm_ID->CurrentValue;
		$this->sm_ID->ViewCustomAttributes = "";

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

		// u_sendTo
		if (strval($this->u_sendTo->CurrentValue) <> "") {
			$sFilterWrk = "`u_UUID`" . ew_SearchString("=", $this->u_sendTo->CurrentValue, EW_DATATYPE_STRING, "");
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

		// u_sendSchedule
		$this->u_sendSchedule->ViewValue = $this->u_sendSchedule->CurrentValue;
		$this->u_sendSchedule->ViewValue = ew_FormatDateTime($this->u_sendSchedule->ViewValue, 11);
		$this->u_sendSchedule->ViewCustomAttributes = "";

		// u_Sent
		$this->u_Sent->ViewValue = $this->u_Sent->CurrentValue;
		$this->u_Sent->ViewValue = ew_FormatDateTime($this->u_Sent->ViewValue, 17);
		$this->u_Sent->ViewCustomAttributes = "";

		// u_Status
		$this->u_Status->ViewValue = $this->u_Status->CurrentValue;
		$this->u_Status->ViewCustomAttributes = "";

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

			// u_sendSchedule
			$this->u_sendSchedule->LinkCustomAttributes = "";
			$this->u_sendSchedule->HrefValue = "";
			$this->u_sendSchedule->TooltipValue = "";

			// u_Sent
			$this->u_Sent->LinkCustomAttributes = "";
			$this->u_Sent->HrefValue = "";
			$this->u_Sent->TooltipValue = "";

			// u_Status
			$this->u_Status->LinkCustomAttributes = "";
			$this->u_Status->HrefValue = "";
			$this->u_Status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['sm_ID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("bot_sendmsg_list.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($bot_SendMSG_delete)) $bot_SendMSG_delete = new cbot_SendMSG_delete();

// Page init
$bot_SendMSG_delete->Page_Init();

// Page main
$bot_SendMSG_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$bot_SendMSG_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fbot_SendMSGdelete = new ew_Form("fbot_SendMSGdelete", "delete");

// Form_CustomValidate event
fbot_SendMSGdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbot_SendMSGdelete.ValidateRequired = true;
<?php } else { ?>
fbot_SendMSGdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbot_SendMSGdelete.Lists["x_u_ID"] = {"LinkField":"x_u_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_BillName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbot_SendMSGdelete.Lists["x_u_sendTo"] = {"LinkField":"x_u_UUID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_BillName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbot_SendMSGdelete.Lists["x_u_TextType"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbot_SendMSGdelete.Lists["x_u_TextType"].Options = <?php echo json_encode($bot_SendMSG->u_TextType->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $bot_SendMSG_delete->ShowPageHeader(); ?>
<?php
$bot_SendMSG_delete->ShowMessage();
?>
<form name="fbot_SendMSGdelete" id="fbot_SendMSGdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($bot_SendMSG_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $bot_SendMSG_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="bot_SendMSG">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($bot_SendMSG_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $bot_SendMSG->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($bot_SendMSG->u_ID->Visible) { // u_ID ?>
		<th><span id="elh_bot_SendMSG_u_ID" class="bot_SendMSG_u_ID"><?php echo $bot_SendMSG->u_ID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($bot_SendMSG->u_sendTo->Visible) { // u_sendTo ?>
		<th><span id="elh_bot_SendMSG_u_sendTo" class="bot_SendMSG_u_sendTo"><?php echo $bot_SendMSG->u_sendTo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($bot_SendMSG->u_TextType->Visible) { // u_TextType ?>
		<th><span id="elh_bot_SendMSG_u_TextType" class="bot_SendMSG_u_TextType"><?php echo $bot_SendMSG->u_TextType->FldCaption() ?></span></th>
<?php } ?>
<?php if ($bot_SendMSG->u_sendSchedule->Visible) { // u_sendSchedule ?>
		<th><span id="elh_bot_SendMSG_u_sendSchedule" class="bot_SendMSG_u_sendSchedule"><?php echo $bot_SendMSG->u_sendSchedule->FldCaption() ?></span></th>
<?php } ?>
<?php if ($bot_SendMSG->u_Sent->Visible) { // u_Sent ?>
		<th><span id="elh_bot_SendMSG_u_Sent" class="bot_SendMSG_u_Sent"><?php echo $bot_SendMSG->u_Sent->FldCaption() ?></span></th>
<?php } ?>
<?php if ($bot_SendMSG->u_Status->Visible) { // u_Status ?>
		<th><span id="elh_bot_SendMSG_u_Status" class="bot_SendMSG_u_Status"><?php echo $bot_SendMSG->u_Status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$bot_SendMSG_delete->RecCnt = 0;
$i = 0;
while (!$bot_SendMSG_delete->Recordset->EOF) {
	$bot_SendMSG_delete->RecCnt++;
	$bot_SendMSG_delete->RowCnt++;

	// Set row properties
	$bot_SendMSG->ResetAttrs();
	$bot_SendMSG->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$bot_SendMSG_delete->LoadRowValues($bot_SendMSG_delete->Recordset);

	// Render row
	$bot_SendMSG_delete->RenderRow();
?>
	<tr<?php echo $bot_SendMSG->RowAttributes() ?>>
<?php if ($bot_SendMSG->u_ID->Visible) { // u_ID ?>
		<td<?php echo $bot_SendMSG->u_ID->CellAttributes() ?>>
<span id="el<?php echo $bot_SendMSG_delete->RowCnt ?>_bot_SendMSG_u_ID" class="bot_SendMSG_u_ID">
<span<?php echo $bot_SendMSG->u_ID->ViewAttributes() ?>>
<?php echo $bot_SendMSG->u_ID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($bot_SendMSG->u_sendTo->Visible) { // u_sendTo ?>
		<td<?php echo $bot_SendMSG->u_sendTo->CellAttributes() ?>>
<span id="el<?php echo $bot_SendMSG_delete->RowCnt ?>_bot_SendMSG_u_sendTo" class="bot_SendMSG_u_sendTo">
<span<?php echo $bot_SendMSG->u_sendTo->ViewAttributes() ?>>
<?php echo $bot_SendMSG->u_sendTo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($bot_SendMSG->u_TextType->Visible) { // u_TextType ?>
		<td<?php echo $bot_SendMSG->u_TextType->CellAttributes() ?>>
<span id="el<?php echo $bot_SendMSG_delete->RowCnt ?>_bot_SendMSG_u_TextType" class="bot_SendMSG_u_TextType">
<span<?php echo $bot_SendMSG->u_TextType->ViewAttributes() ?>>
<?php echo $bot_SendMSG->u_TextType->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($bot_SendMSG->u_sendSchedule->Visible) { // u_sendSchedule ?>
		<td<?php echo $bot_SendMSG->u_sendSchedule->CellAttributes() ?>>
<span id="el<?php echo $bot_SendMSG_delete->RowCnt ?>_bot_SendMSG_u_sendSchedule" class="bot_SendMSG_u_sendSchedule">
<span<?php echo $bot_SendMSG->u_sendSchedule->ViewAttributes() ?>>
<?php echo $bot_SendMSG->u_sendSchedule->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($bot_SendMSG->u_Sent->Visible) { // u_Sent ?>
		<td<?php echo $bot_SendMSG->u_Sent->CellAttributes() ?>>
<span id="el<?php echo $bot_SendMSG_delete->RowCnt ?>_bot_SendMSG_u_Sent" class="bot_SendMSG_u_Sent">
<span<?php echo $bot_SendMSG->u_Sent->ViewAttributes() ?>>
<?php echo $bot_SendMSG->u_Sent->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($bot_SendMSG->u_Status->Visible) { // u_Status ?>
		<td<?php echo $bot_SendMSG->u_Status->CellAttributes() ?>>
<span id="el<?php echo $bot_SendMSG_delete->RowCnt ?>_bot_SendMSG_u_Status" class="bot_SendMSG_u_Status">
<span<?php echo $bot_SendMSG->u_Status->ViewAttributes() ?>>
<?php echo $bot_SendMSG->u_Status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$bot_SendMSG_delete->Recordset->MoveNext();
}
$bot_SendMSG_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $bot_SendMSG_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fbot_SendMSGdelete.Init();
</script>
<?php
$bot_SendMSG_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$bot_SendMSG_delete->Page_Terminate();
?>
