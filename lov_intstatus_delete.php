<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "lov_intstatus_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$lov_intStatus_delete = NULL; // Initialize page object first

class clov_intStatus_delete extends clov_intStatus {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'lov_intStatus';

	// Page object name
	var $PageObjName = 'lov_intStatus_delete';

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

		// Table object (lov_intStatus)
		if (!isset($GLOBALS["lov_intStatus"]) || get_class($GLOBALS["lov_intStatus"]) == "clov_intStatus") {
			$GLOBALS["lov_intStatus"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lov_intStatus"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lov_intStatus', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("lov_intstatus_list.php"));
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
		global $EW_EXPORT, $lov_intStatus;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lov_intStatus);
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
			$this->Page_Terminate("lov_intstatus_list.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in lov_intStatus class, lov_intStatusinfo.php

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
				$this->Page_Terminate("lov_intstatus_list.php"); // Return to list
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
		$this->in_ID->setDbValue($rs->fields('in_ID'));
		$this->in_Name->setDbValue($rs->fields('in_Name'));
		$this->in_isDeath->setDbValue($rs->fields('in_isDeath'));
		$this->in_isSale->setDbValue($rs->fields('in_isSale'));
		$this->is_InternalUse->setDbValue($rs->fields('is_InternalUse'));
		$this->in_Created->setDbValue($rs->fields('in_Created'));
		$this->in_Updated->setDbValue($rs->fields('in_Updated'));
		$this->in_Note->setDbValue($rs->fields('in_Note'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->in_ID->DbValue = $row['in_ID'];
		$this->in_Name->DbValue = $row['in_Name'];
		$this->in_isDeath->DbValue = $row['in_isDeath'];
		$this->in_isSale->DbValue = $row['in_isSale'];
		$this->is_InternalUse->DbValue = $row['is_InternalUse'];
		$this->in_Created->DbValue = $row['in_Created'];
		$this->in_Updated->DbValue = $row['in_Updated'];
		$this->in_Note->DbValue = $row['in_Note'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// in_ID

		$this->in_ID->CellCssStyle = "white-space: nowrap;";

		// in_Name
		// in_isDeath
		// in_isSale
		// is_InternalUse
		// in_Created
		// in_Updated
		// in_Note

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
				$sThisKey .= $row['in_ID'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("lov_intstatus_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($lov_intStatus_delete)) $lov_intStatus_delete = new clov_intStatus_delete();

// Page init
$lov_intStatus_delete->Page_Init();

// Page main
$lov_intStatus_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_intStatus_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = flov_intStatusdelete = new ew_Form("flov_intStatusdelete", "delete");

// Form_CustomValidate event
flov_intStatusdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_intStatusdelete.ValidateRequired = true;
<?php } else { ?>
flov_intStatusdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flov_intStatusdelete.Lists["x_in_isDeath"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_intStatusdelete.Lists["x_in_isDeath"].Options = <?php echo json_encode($lov_intStatus->in_isDeath->Options()) ?>;
flov_intStatusdelete.Lists["x_in_isSale"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_intStatusdelete.Lists["x_in_isSale"].Options = <?php echo json_encode($lov_intStatus->in_isSale->Options()) ?>;

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
<?php $lov_intStatus_delete->ShowPageHeader(); ?>
<?php
$lov_intStatus_delete->ShowMessage();
?>
<form name="flov_intStatusdelete" id="flov_intStatusdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lov_intStatus_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lov_intStatus_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lov_intStatus">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($lov_intStatus_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $lov_intStatus->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($lov_intStatus->in_Name->Visible) { // in_Name ?>
		<th><span id="elh_lov_intStatus_in_Name" class="lov_intStatus_in_Name"><?php echo $lov_intStatus->in_Name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($lov_intStatus->in_isDeath->Visible) { // in_isDeath ?>
		<th><span id="elh_lov_intStatus_in_isDeath" class="lov_intStatus_in_isDeath"><?php echo $lov_intStatus->in_isDeath->FldCaption() ?></span></th>
<?php } ?>
<?php if ($lov_intStatus->in_isSale->Visible) { // in_isSale ?>
		<th><span id="elh_lov_intStatus_in_isSale" class="lov_intStatus_in_isSale"><?php echo $lov_intStatus->in_isSale->FldCaption() ?></span></th>
<?php } ?>
<?php if ($lov_intStatus->is_InternalUse->Visible) { // is_InternalUse ?>
		<th><span id="elh_lov_intStatus_is_InternalUse" class="lov_intStatus_is_InternalUse"><?php echo $lov_intStatus->is_InternalUse->FldCaption() ?></span></th>
<?php } ?>
<?php if ($lov_intStatus->in_Created->Visible) { // in_Created ?>
		<th><span id="elh_lov_intStatus_in_Created" class="lov_intStatus_in_Created"><?php echo $lov_intStatus->in_Created->FldCaption() ?></span></th>
<?php } ?>
<?php if ($lov_intStatus->in_Updated->Visible) { // in_Updated ?>
		<th><span id="elh_lov_intStatus_in_Updated" class="lov_intStatus_in_Updated"><?php echo $lov_intStatus->in_Updated->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lov_intStatus_delete->RecCnt = 0;
$i = 0;
while (!$lov_intStatus_delete->Recordset->EOF) {
	$lov_intStatus_delete->RecCnt++;
	$lov_intStatus_delete->RowCnt++;

	// Set row properties
	$lov_intStatus->ResetAttrs();
	$lov_intStatus->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$lov_intStatus_delete->LoadRowValues($lov_intStatus_delete->Recordset);

	// Render row
	$lov_intStatus_delete->RenderRow();
?>
	<tr<?php echo $lov_intStatus->RowAttributes() ?>>
<?php if ($lov_intStatus->in_Name->Visible) { // in_Name ?>
		<td<?php echo $lov_intStatus->in_Name->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_delete->RowCnt ?>_lov_intStatus_in_Name" class="lov_intStatus_in_Name">
<span<?php echo $lov_intStatus->in_Name->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lov_intStatus->in_isDeath->Visible) { // in_isDeath ?>
		<td<?php echo $lov_intStatus->in_isDeath->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_delete->RowCnt ?>_lov_intStatus_in_isDeath" class="lov_intStatus_in_isDeath">
<span<?php echo $lov_intStatus->in_isDeath->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_isDeath->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lov_intStatus->in_isSale->Visible) { // in_isSale ?>
		<td<?php echo $lov_intStatus->in_isSale->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_delete->RowCnt ?>_lov_intStatus_in_isSale" class="lov_intStatus_in_isSale">
<span<?php echo $lov_intStatus->in_isSale->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_isSale->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lov_intStatus->is_InternalUse->Visible) { // is_InternalUse ?>
		<td<?php echo $lov_intStatus->is_InternalUse->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_delete->RowCnt ?>_lov_intStatus_is_InternalUse" class="lov_intStatus_is_InternalUse">
<span<?php echo $lov_intStatus->is_InternalUse->ViewAttributes() ?>>
<?php echo $lov_intStatus->is_InternalUse->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lov_intStatus->in_Created->Visible) { // in_Created ?>
		<td<?php echo $lov_intStatus->in_Created->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_delete->RowCnt ?>_lov_intStatus_in_Created" class="lov_intStatus_in_Created">
<span<?php echo $lov_intStatus->in_Created->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_Created->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lov_intStatus->in_Updated->Visible) { // in_Updated ?>
		<td<?php echo $lov_intStatus->in_Updated->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_delete->RowCnt ?>_lov_intStatus_in_Updated" class="lov_intStatus_in_Updated">
<span<?php echo $lov_intStatus->in_Updated->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_Updated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lov_intStatus_delete->Recordset->MoveNext();
}
$lov_intStatus_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $lov_intStatus_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
flov_intStatusdelete.Init();
</script>
<?php
$lov_intStatus_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lov_intStatus_delete->Page_Terminate();
?>
