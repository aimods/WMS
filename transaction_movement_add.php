<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "transaction_movement_info.php" ?>
<?php include_once "main_product_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$transaction_Movement_add = NULL; // Initialize page object first

class ctransaction_Movement_add extends ctransaction_Movement {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'transaction_Movement';

	// Page object name
	var $PageObjName = 'transaction_Movement_add';

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

		// Table object (transaction_Movement)
		if (!isset($GLOBALS["transaction_Movement"]) || get_class($GLOBALS["transaction_Movement"]) == "ctransaction_Movement") {
			$GLOBALS["transaction_Movement"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["transaction_Movement"];
		}

		// Table object (main_Product)
		if (!isset($GLOBALS['main_Product'])) $GLOBALS['main_Product'] = new cmain_Product();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'transaction_Movement', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("transaction_movement_list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Update last accessed time
		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {
		} else {
			echo $Language->Phrase("UserProfileCorrupted");
		}

		// Create form object
		$objForm = new cFormObj();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $transaction_Movement;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($transaction_Movement);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["tran_ID"] != "") {
				$this->tran_ID->setQueryStringValue($_GET["tran_ID"]);
				$this->setKey("tran_ID", $this->tran_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("tran_ID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("transaction_movement_list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "transaction_movement_list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "transaction_movement_view.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->tran_Created->CurrentValue = ew_CurrentDateTime();
		$this->u_ID->CurrentValue = CurrentUserID();
		$this->tr_type->CurrentValue = NULL;
		$this->tr_type->OldValue = $this->tr_type->CurrentValue;
		$this->tran_Detail->CurrentValue = NULL;
		$this->tran_Detail->OldValue = $this->tran_Detail->CurrentValue;
		$this->pr_ID->CurrentValue = NULL;
		$this->pr_ID->OldValue = $this->pr_ID->CurrentValue;
		$this->s_ID->CurrentValue = NULL;
		$this->s_ID->OldValue = $this->s_ID->CurrentValue;
		$this->tran_show->CurrentValue = NULL;
		$this->tran_show->OldValue = $this->tran_show->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->tran_Created->FldIsDetailKey) {
			$this->tran_Created->setFormValue($objForm->GetValue("x_tran_Created"));
			$this->tran_Created->CurrentValue = ew_UnFormatDateTime($this->tran_Created->CurrentValue, 17);
		}
		if (!$this->u_ID->FldIsDetailKey) {
			$this->u_ID->setFormValue($objForm->GetValue("x_u_ID"));
		}
		if (!$this->tr_type->FldIsDetailKey) {
			$this->tr_type->setFormValue($objForm->GetValue("x_tr_type"));
		}
		if (!$this->tran_Detail->FldIsDetailKey) {
			$this->tran_Detail->setFormValue($objForm->GetValue("x_tran_Detail"));
		}
		if (!$this->pr_ID->FldIsDetailKey) {
			$this->pr_ID->setFormValue($objForm->GetValue("x_pr_ID"));
		}
		if (!$this->s_ID->FldIsDetailKey) {
			$this->s_ID->setFormValue($objForm->GetValue("x_s_ID"));
		}
		if (!$this->tran_show->FldIsDetailKey) {
			$this->tran_show->setFormValue($objForm->GetValue("x_tran_show"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->tran_Created->CurrentValue = $this->tran_Created->FormValue;
		$this->tran_Created->CurrentValue = ew_UnFormatDateTime($this->tran_Created->CurrentValue, 17);
		$this->u_ID->CurrentValue = $this->u_ID->FormValue;
		$this->tr_type->CurrentValue = $this->tr_type->FormValue;
		$this->tran_Detail->CurrentValue = $this->tran_Detail->FormValue;
		$this->pr_ID->CurrentValue = $this->pr_ID->FormValue;
		$this->s_ID->CurrentValue = $this->s_ID->FormValue;
		$this->tran_show->CurrentValue = $this->tran_show->FormValue;
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
		$this->tran_Created->setDbValue($rs->fields('tran_Created'));
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->tr_type->setDbValue($rs->fields('tr_type'));
		$this->tran_Detail->setDbValue($rs->fields('tran_Detail'));
		$this->pr_ID->setDbValue($rs->fields('pr_ID'));
		$this->s_ID->setDbValue($rs->fields('s_ID'));
		$this->tran_ID->setDbValue($rs->fields('tran_ID'));
		$this->tran_show->setDbValue($rs->fields('tran_show'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->tran_Created->DbValue = $row['tran_Created'];
		$this->u_ID->DbValue = $row['u_ID'];
		$this->tr_type->DbValue = $row['tr_type'];
		$this->tran_Detail->DbValue = $row['tran_Detail'];
		$this->pr_ID->DbValue = $row['pr_ID'];
		$this->s_ID->DbValue = $row['s_ID'];
		$this->tran_ID->DbValue = $row['tran_ID'];
		$this->tran_show->DbValue = $row['tran_show'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("tran_ID")) <> "")
			$this->tran_ID->CurrentValue = $this->getKey("tran_ID"); // tran_ID
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// tran_Created
		// u_ID
		// tr_type
		// tran_Detail
		// pr_ID
		// s_ID
		// tran_ID
		// tran_show

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// tran_Created
		$this->tran_Created->ViewValue = $this->tran_Created->CurrentValue;
		$this->tran_Created->ViewValue = ew_FormatDateTime($this->tran_Created->ViewValue, 17);
		$this->tran_Created->ViewCustomAttributes = "";

		// u_ID
		$this->u_ID->ViewValue = $this->u_ID->CurrentValue;
		if (strval($this->u_ID->CurrentValue) <> "") {
			$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->u_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `u_ID`, `u_LoginName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
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

		// tr_type
		if (strval($this->tr_type->CurrentValue) <> "") {
			$sFilterWrk = "`tr_Type`" . ew_SearchString("=", $this->tr_type->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_Transaction`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tr_type, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tr_type->ViewValue = $this->tr_type->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tr_type->ViewValue = $this->tr_type->CurrentValue;
			}
		} else {
			$this->tr_type->ViewValue = NULL;
		}
		$this->tr_type->ViewCustomAttributes = "";

		// tran_Detail
		$this->tran_Detail->ViewValue = $this->tran_Detail->CurrentValue;
		$this->tran_Detail->ViewCustomAttributes = "";

		// pr_ID
		if (strval($this->pr_ID->CurrentValue) <> "") {
			$sFilterWrk = "`pr_ID`" . ew_SearchString("=", $this->pr_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `pr_ID`, `pr_Barcode` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Product`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pr_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pr_ID->ViewValue = $this->pr_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pr_ID->ViewValue = $this->pr_ID->CurrentValue;
			}
		} else {
			$this->pr_ID->ViewValue = NULL;
		}
		$this->pr_ID->ViewCustomAttributes = "";

		// s_ID
		if (strval($this->s_ID->CurrentValue) <> "") {
			$sFilterWrk = "`s_ID`" . ew_SearchString("=", $this->s_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Stock`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `s_Province`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_ID->ViewValue = $this->s_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_ID->ViewValue = $this->s_ID->CurrentValue;
			}
		} else {
			$this->s_ID->ViewValue = NULL;
		}
		$this->s_ID->ViewCustomAttributes = "";

		// tran_ID
		$this->tran_ID->ViewValue = $this->tran_ID->CurrentValue;
		$this->tran_ID->ViewCustomAttributes = "";

		// tran_show
		if (strval($this->tran_show->CurrentValue) <> "") {
			$this->tran_show->ViewValue = $this->tran_show->OptionCaption($this->tran_show->CurrentValue);
		} else {
			$this->tran_show->ViewValue = NULL;
		}
		$this->tran_show->ViewCustomAttributes = "";

			// tran_Created
			$this->tran_Created->LinkCustomAttributes = "";
			$this->tran_Created->HrefValue = "";
			$this->tran_Created->TooltipValue = "";

			// u_ID
			$this->u_ID->LinkCustomAttributes = "";
			$this->u_ID->HrefValue = "";
			$this->u_ID->TooltipValue = "";

			// tr_type
			$this->tr_type->LinkCustomAttributes = "";
			$this->tr_type->HrefValue = "";
			$this->tr_type->TooltipValue = "";

			// tran_Detail
			$this->tran_Detail->LinkCustomAttributes = "";
			$this->tran_Detail->HrefValue = "";
			$this->tran_Detail->TooltipValue = "";

			// pr_ID
			$this->pr_ID->LinkCustomAttributes = "";
			$this->pr_ID->HrefValue = "";
			$this->pr_ID->TooltipValue = "";

			// s_ID
			$this->s_ID->LinkCustomAttributes = "";
			$this->s_ID->HrefValue = "";
			$this->s_ID->TooltipValue = "";

			// tran_show
			$this->tran_show->LinkCustomAttributes = "";
			$this->tran_show->HrefValue = "";
			$this->tran_show->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// tran_Created
			// u_ID
			// tr_type

			$this->tr_type->EditAttrs["class"] = "form-control";
			$this->tr_type->EditCustomAttributes = "";
			if (trim(strval($this->tr_type->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`tr_Type`" . ew_SearchString("=", $this->tr_type->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_Transaction`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->tr_type, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->tr_type->EditValue = $arwrk;

			// tran_Detail
			$this->tran_Detail->EditAttrs["class"] = "form-control";
			$this->tran_Detail->EditCustomAttributes = "";
			$this->tran_Detail->EditValue = ew_HtmlEncode($this->tran_Detail->CurrentValue);
			$this->tran_Detail->PlaceHolder = ew_RemoveHtml($this->tran_Detail->FldCaption());

			// pr_ID
			$this->pr_ID->EditCustomAttributes = "";
			if ($this->pr_ID->getSessionValue() <> "") {
				$this->pr_ID->CurrentValue = $this->pr_ID->getSessionValue();
			if (strval($this->pr_ID->CurrentValue) <> "") {
				$sFilterWrk = "`pr_ID`" . ew_SearchString("=", $this->pr_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `pr_ID`, `pr_Barcode` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Product`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pr_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->pr_ID->ViewValue = $this->pr_ID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->pr_ID->ViewValue = $this->pr_ID->CurrentValue;
				}
			} else {
				$this->pr_ID->ViewValue = NULL;
			}
			$this->pr_ID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->pr_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`pr_ID`" . ew_SearchString("=", $this->pr_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `pr_ID`, `pr_Barcode` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_Product`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pr_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->pr_ID->ViewValue = $this->pr_ID->DisplayValue($arwrk);
			} else {
				$this->pr_ID->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pr_ID->EditValue = $arwrk;
			}

			// s_ID
			$this->s_ID->EditAttrs["class"] = "form-control";
			$this->s_ID->EditCustomAttributes = "";
			if (trim(strval($this->s_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`s_ID`" . ew_SearchString("=", $this->s_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_Stock`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->s_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `s_Province`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->s_ID->EditValue = $arwrk;

			// tran_show
			$this->tran_show->EditCustomAttributes = "";
			$this->tran_show->EditValue = $this->tran_show->Options(FALSE);

			// Add refer script
			// tran_Created

			$this->tran_Created->LinkCustomAttributes = "";
			$this->tran_Created->HrefValue = "";

			// u_ID
			$this->u_ID->LinkCustomAttributes = "";
			$this->u_ID->HrefValue = "";

			// tr_type
			$this->tr_type->LinkCustomAttributes = "";
			$this->tr_type->HrefValue = "";

			// tran_Detail
			$this->tran_Detail->LinkCustomAttributes = "";
			$this->tran_Detail->HrefValue = "";

			// pr_ID
			$this->pr_ID->LinkCustomAttributes = "";
			$this->pr_ID->HrefValue = "";

			// s_ID
			$this->s_ID->LinkCustomAttributes = "";
			$this->s_ID->HrefValue = "";

			// tran_show
			$this->tran_show->LinkCustomAttributes = "";
			$this->tran_show->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->tr_type->FldIsDetailKey && !is_null($this->tr_type->FormValue) && $this->tr_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tr_type->FldCaption(), $this->tr_type->ReqErrMsg));
		}
		if (!$this->tran_Detail->FldIsDetailKey && !is_null($this->tran_Detail->FormValue) && $this->tran_Detail->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tran_Detail->FldCaption(), $this->tran_Detail->ReqErrMsg));
		}
		if (!$this->pr_ID->FldIsDetailKey && !is_null($this->pr_ID->FormValue) && $this->pr_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_ID->FldCaption(), $this->pr_ID->ReqErrMsg));
		}
		if ($this->tran_show->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tran_show->FldCaption(), $this->tran_show->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// tran_Created
		$this->tran_Created->SetDbValueDef($rsnew, ew_CurrentDateTime(), ew_CurrentDate());
		$rsnew['tran_Created'] = &$this->tran_Created->DbValue;

		// u_ID
		$this->u_ID->SetDbValueDef($rsnew, CurrentUserID(), 0);
		$rsnew['u_ID'] = &$this->u_ID->DbValue;

		// tr_type
		$this->tr_type->SetDbValueDef($rsnew, $this->tr_type->CurrentValue, 0, FALSE);

		// tran_Detail
		$this->tran_Detail->SetDbValueDef($rsnew, $this->tran_Detail->CurrentValue, "", FALSE);

		// pr_ID
		$this->pr_ID->SetDbValueDef($rsnew, $this->pr_ID->CurrentValue, 0, FALSE);

		// s_ID
		$this->s_ID->SetDbValueDef($rsnew, $this->s_ID->CurrentValue, NULL, FALSE);

		// tran_show
		$this->tran_show->SetDbValueDef($rsnew, $this->tran_show->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->tran_ID->setDbValue($conn->Insert_ID());
				$rsnew['tran_ID'] = $this->tran_ID->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "main_Product") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_pr_ID"] <> "") {
					$GLOBALS["main_Product"]->pr_ID->setQueryStringValue($_GET["fk_pr_ID"]);
					$this->pr_ID->setQueryStringValue($GLOBALS["main_Product"]->pr_ID->QueryStringValue);
					$this->pr_ID->setSessionValue($this->pr_ID->QueryStringValue);
					if (!is_numeric($GLOBALS["main_Product"]->pr_ID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "main_Product") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_pr_ID"] <> "") {
					$GLOBALS["main_Product"]->pr_ID->setFormValue($_POST["fk_pr_ID"]);
					$this->pr_ID->setFormValue($GLOBALS["main_Product"]->pr_ID->FormValue);
					$this->pr_ID->setSessionValue($this->pr_ID->FormValue);
					if (!is_numeric($GLOBALS["main_Product"]->pr_ID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "main_Product") {
				if ($this->pr_ID->CurrentValue == "") $this->pr_ID->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("transaction_movement_list.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($transaction_Movement_add)) $transaction_Movement_add = new ctransaction_Movement_add();

// Page init
$transaction_Movement_add->Page_Init();

// Page main
$transaction_Movement_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$transaction_Movement_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftransaction_Movementadd = new ew_Form("ftransaction_Movementadd", "add");

// Validate form
ftransaction_Movementadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_tr_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->tr_type->FldCaption(), $transaction_Movement->tr_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tran_Detail");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->tran_Detail->FldCaption(), $transaction_Movement->tran_Detail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->pr_ID->FldCaption(), $transaction_Movement->pr_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tran_show");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transaction_Movement->tran_show->FldCaption(), $transaction_Movement->tran_show->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftransaction_Movementadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftransaction_Movementadd.ValidateRequired = true;
<?php } else { ?>
ftransaction_Movementadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftransaction_Movementadd.Lists["x_u_ID"] = {"LinkField":"x_u_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_LoginName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementadd.Lists["x_tr_type"] = {"LinkField":"x_tr_Type","Ajax":true,"AutoFill":false,"DisplayFields":["x_tr_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementadd.Lists["x_pr_ID"] = {"LinkField":"x_pr_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_pr_Barcode","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementadd.Lists["x_s_ID"] = {"LinkField":"x_s_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_s_LOC","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementadd.Lists["x_tran_show"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementadd.Lists["x_tran_show"].Options = <?php echo json_encode($transaction_Movement->tran_show->Options()) ?>;

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
<?php $transaction_Movement_add->ShowPageHeader(); ?>
<?php
$transaction_Movement_add->ShowMessage();
?>
<form name="ftransaction_Movementadd" id="ftransaction_Movementadd" class="<?php echo $transaction_Movement_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($transaction_Movement_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $transaction_Movement_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="transaction_Movement">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($transaction_Movement->getCurrentMasterTable() == "main_Product") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="main_Product">
<input type="hidden" name="fk_pr_ID" value="<?php echo $transaction_Movement->pr_ID->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($transaction_Movement->tr_type->Visible) { // tr_type ?>
	<div id="r_tr_type" class="form-group">
		<label id="elh_transaction_Movement_tr_type" for="x_tr_type" class="col-sm-2 control-label ewLabel"><?php echo $transaction_Movement->tr_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $transaction_Movement->tr_type->CellAttributes() ?>>
<span id="el_transaction_Movement_tr_type">
<select data-table="transaction_Movement" data-field="x_tr_type" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tr_type->DisplayValueSeparator) ? json_encode($transaction_Movement->tr_type->DisplayValueSeparator) : $transaction_Movement->tr_type->DisplayValueSeparator) ?>" id="x_tr_type" name="x_tr_type"<?php echo $transaction_Movement->tr_type->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->tr_type->EditValue)) {
	$arwrk = $transaction_Movement->tr_type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->tr_type->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->tr_type->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tr_type->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->tr_type->CurrentValue) ?>" selected><?php echo $transaction_Movement->tr_type->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_Transaction`";
$sWhereWrk = "";
$transaction_Movement->tr_type->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->tr_type->LookupFilters += array("f0" => "`tr_Type` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->tr_type, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $transaction_Movement->tr_type->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_tr_type" id="s_x_tr_type" value="<?php echo $transaction_Movement->tr_type->LookupFilterQuery() ?>">
</span>
<?php echo $transaction_Movement->tr_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($transaction_Movement->tran_Detail->Visible) { // tran_Detail ?>
	<div id="r_tran_Detail" class="form-group">
		<label id="elh_transaction_Movement_tran_Detail" class="col-sm-2 control-label ewLabel"><?php echo $transaction_Movement->tran_Detail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $transaction_Movement->tran_Detail->CellAttributes() ?>>
<span id="el_transaction_Movement_tran_Detail">
<?php ew_AppendClass($transaction_Movement->tran_Detail->EditAttrs["class"], "editor"); ?>
<textarea data-table="transaction_Movement" data-field="x_tran_Detail" name="x_tran_Detail" id="x_tran_Detail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($transaction_Movement->tran_Detail->getPlaceHolder()) ?>"<?php echo $transaction_Movement->tran_Detail->EditAttributes() ?>><?php echo $transaction_Movement->tran_Detail->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ftransaction_Movementadd", "x_tran_Detail", 0, 0, <?php echo ($transaction_Movement->tran_Detail->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $transaction_Movement->tran_Detail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($transaction_Movement->pr_ID->Visible) { // pr_ID ?>
	<div id="r_pr_ID" class="form-group">
		<label id="elh_transaction_Movement_pr_ID" for="x_pr_ID" class="col-sm-2 control-label ewLabel"><?php echo $transaction_Movement->pr_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $transaction_Movement->pr_ID->CellAttributes() ?>>
<?php if ($transaction_Movement->pr_ID->getSessionValue() <> "") { ?>
<span id="el_transaction_Movement_pr_ID">
<span<?php echo $transaction_Movement->pr_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transaction_Movement->pr_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_pr_ID" name="x_pr_ID" value="<?php echo ew_HtmlEncode($transaction_Movement->pr_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_transaction_Movement_pr_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $transaction_Movement->pr_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_pr_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $transaction_Movement->pr_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($transaction_Movement->pr_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="transaction_Movement" data-field="x_pr_ID" name="x_pr_ID" id="x_pr_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $transaction_Movement->pr_ID->EditAttributes() ?>><?php echo $transaction_Movement->pr_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($transaction_Movement->pr_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="transaction_Movement" data-field="x_pr_ID" name="x_pr_ID" id="x_pr_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($transaction_Movement->pr_ID->CurrentValue) ?>" checked<?php echo $transaction_Movement->pr_ID->EditAttributes() ?>><?php echo $transaction_Movement->pr_ID->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_pr_ID" class="ewTemplate"><input type="radio" data-table="transaction_Movement" data-field="x_pr_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->pr_ID->DisplayValueSeparator) ? json_encode($transaction_Movement->pr_ID->DisplayValueSeparator) : $transaction_Movement->pr_ID->DisplayValueSeparator) ?>" name="x_pr_ID" id="x_pr_ID" value="{value}"<?php echo $transaction_Movement->pr_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `pr_ID`, `pr_Barcode` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Product`";
$sWhereWrk = "";
$transaction_Movement->pr_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->pr_ID->LookupFilters += array("f0" => "`pr_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->pr_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $transaction_Movement->pr_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_pr_ID" id="s_x_pr_ID" value="<?php echo $transaction_Movement->pr_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $transaction_Movement->pr_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($transaction_Movement->s_ID->Visible) { // s_ID ?>
	<div id="r_s_ID" class="form-group">
		<label id="elh_transaction_Movement_s_ID" for="x_s_ID" class="col-sm-2 control-label ewLabel"><?php echo $transaction_Movement->s_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $transaction_Movement->s_ID->CellAttributes() ?>>
<span id="el_transaction_Movement_s_ID">
<select data-table="transaction_Movement" data-field="x_s_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->s_ID->DisplayValueSeparator) ? json_encode($transaction_Movement->s_ID->DisplayValueSeparator) : $transaction_Movement->s_ID->DisplayValueSeparator) ?>" id="x_s_ID" name="x_s_ID"<?php echo $transaction_Movement->s_ID->EditAttributes() ?>>
<?php
if (is_array($transaction_Movement->s_ID->EditValue)) {
	$arwrk = $transaction_Movement->s_ID->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($transaction_Movement->s_ID->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $transaction_Movement->s_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->s_ID->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($transaction_Movement->s_ID->CurrentValue) ?>" selected><?php echo $transaction_Movement->s_ID->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Stock`";
$sWhereWrk = "";
$transaction_Movement->s_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$transaction_Movement->s_ID->LookupFilters += array("f0" => "`s_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$transaction_Movement->Lookup_Selecting($transaction_Movement->s_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `s_Province`";
if ($sSqlWrk <> "") $transaction_Movement->s_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_s_ID" id="s_x_s_ID" value="<?php echo $transaction_Movement->s_ID->LookupFilterQuery() ?>">
</span>
<?php echo $transaction_Movement->s_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($transaction_Movement->tran_show->Visible) { // tran_show ?>
	<div id="r_tran_show" class="form-group">
		<label id="elh_transaction_Movement_tran_show" class="col-sm-2 control-label ewLabel"><?php echo $transaction_Movement->tran_show->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $transaction_Movement->tran_show->CellAttributes() ?>>
<span id="el_transaction_Movement_tran_show">
<div id="tp_x_tran_show" class="ewTemplate"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" data-value-separator="<?php echo ew_HtmlEncode(is_array($transaction_Movement->tran_show->DisplayValueSeparator) ? json_encode($transaction_Movement->tran_show->DisplayValueSeparator) : $transaction_Movement->tran_show->DisplayValueSeparator) ?>" name="x_tran_show" id="x_tran_show" value="{value}"<?php echo $transaction_Movement->tran_show->EditAttributes() ?>></div>
<div id="dsl_x_tran_show" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $transaction_Movement->tran_show->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($transaction_Movement->tran_show->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x_tran_show" id="x_tran_show_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($transaction_Movement->tran_show->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="transaction_Movement" data-field="x_tran_show" name="x_tran_show" id="x_tran_show_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($transaction_Movement->tran_show->CurrentValue) ?>" checked<?php echo $transaction_Movement->tran_show->EditAttributes() ?>><?php echo $transaction_Movement->tran_show->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $transaction_Movement->tran_show->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $transaction_Movement_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
ftransaction_Movementadd.Init();
</script>
<?php
$transaction_Movement_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$transaction_Movement_add->Page_Terminate();
?>
