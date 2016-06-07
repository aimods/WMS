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

$lov_intStatus_edit = NULL; // Initialize page object first

class clov_intStatus_edit extends clov_intStatus {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'lov_intStatus';

	// Page object name
	var $PageObjName = 'lov_intStatus_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->in_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["in_ID"] <> "") {
			$this->in_ID->setQueryStringValue($_GET["in_ID"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->in_ID->CurrentValue == "")
			$this->Page_Terminate("lov_intstatus_list.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("lov_intstatus_list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "lov_intstatus_list.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->in_ID->FldIsDetailKey)
			$this->in_ID->setFormValue($objForm->GetValue("x_in_ID"));
		if (!$this->in_Name->FldIsDetailKey) {
			$this->in_Name->setFormValue($objForm->GetValue("x_in_Name"));
		}
		if (!$this->in_isDeath->FldIsDetailKey) {
			$this->in_isDeath->setFormValue($objForm->GetValue("x_in_isDeath"));
		}
		if (!$this->in_isSale->FldIsDetailKey) {
			$this->in_isSale->setFormValue($objForm->GetValue("x_in_isSale"));
		}
		if (!$this->is_InternalUse->FldIsDetailKey) {
			$this->is_InternalUse->setFormValue($objForm->GetValue("x_is_InternalUse"));
		}
		if (!$this->in_Note->FldIsDetailKey) {
			$this->in_Note->setFormValue($objForm->GetValue("x_in_Note"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->in_ID->CurrentValue = $this->in_ID->FormValue;
		$this->in_Name->CurrentValue = $this->in_Name->FormValue;
		$this->in_isDeath->CurrentValue = $this->in_isDeath->FormValue;
		$this->in_isSale->CurrentValue = $this->in_isSale->FormValue;
		$this->is_InternalUse->CurrentValue = $this->is_InternalUse->FormValue;
		$this->in_Note->CurrentValue = $this->in_Note->FormValue;
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
		// in_Name
		// in_isDeath
		// in_isSale
		// is_InternalUse
		// in_Created
		// in_Updated
		// in_Note

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// in_ID
		$this->in_ID->ViewValue = $this->in_ID->CurrentValue;
		$this->in_ID->ViewCustomAttributes = "";

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

		// in_Note
		$this->in_Note->ViewValue = $this->in_Note->CurrentValue;
		$this->in_Note->ViewCustomAttributes = "";

			// in_ID
			$this->in_ID->LinkCustomAttributes = "";
			$this->in_ID->HrefValue = "";
			$this->in_ID->TooltipValue = "";

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

			// in_Note
			$this->in_Note->LinkCustomAttributes = "";
			$this->in_Note->HrefValue = "";
			$this->in_Note->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// in_ID
			$this->in_ID->EditAttrs["class"] = "form-control";
			$this->in_ID->EditCustomAttributes = "";
			$this->in_ID->EditValue = $this->in_ID->CurrentValue;
			$this->in_ID->ViewCustomAttributes = "";

			// in_Name
			$this->in_Name->EditAttrs["class"] = "form-control";
			$this->in_Name->EditCustomAttributes = "";
			$this->in_Name->EditValue = ew_HtmlEncode($this->in_Name->CurrentValue);
			$this->in_Name->PlaceHolder = ew_RemoveHtml($this->in_Name->FldCaption());

			// in_isDeath
			$this->in_isDeath->EditAttrs["class"] = "form-control";
			$this->in_isDeath->EditCustomAttributes = "";
			$this->in_isDeath->EditValue = $this->in_isDeath->Options(TRUE);

			// in_isSale
			$this->in_isSale->EditAttrs["class"] = "form-control";
			$this->in_isSale->EditCustomAttributes = "";
			$this->in_isSale->EditValue = $this->in_isSale->Options(TRUE);

			// is_InternalUse
			$this->is_InternalUse->EditAttrs["class"] = "form-control";
			$this->is_InternalUse->EditCustomAttributes = "";
			$this->is_InternalUse->EditValue = ew_HtmlEncode($this->is_InternalUse->CurrentValue);
			$this->is_InternalUse->PlaceHolder = ew_RemoveHtml($this->is_InternalUse->FldCaption());

			// in_Note
			$this->in_Note->EditAttrs["class"] = "form-control";
			$this->in_Note->EditCustomAttributes = "";
			$this->in_Note->EditValue = ew_HtmlEncode($this->in_Note->CurrentValue);
			$this->in_Note->PlaceHolder = ew_RemoveHtml($this->in_Note->FldCaption());

			// Edit refer script
			// in_ID

			$this->in_ID->LinkCustomAttributes = "";
			$this->in_ID->HrefValue = "";

			// in_Name
			$this->in_Name->LinkCustomAttributes = "";
			$this->in_Name->HrefValue = "";

			// in_isDeath
			$this->in_isDeath->LinkCustomAttributes = "";
			$this->in_isDeath->HrefValue = "";

			// in_isSale
			$this->in_isSale->LinkCustomAttributes = "";
			$this->in_isSale->HrefValue = "";

			// is_InternalUse
			$this->is_InternalUse->LinkCustomAttributes = "";
			$this->is_InternalUse->HrefValue = "";

			// in_Note
			$this->in_Note->LinkCustomAttributes = "";
			$this->in_Note->HrefValue = "";
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
		if (!$this->in_Name->FldIsDetailKey && !is_null($this->in_Name->FormValue) && $this->in_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->in_Name->FldCaption(), $this->in_Name->ReqErrMsg));
		}
		if (!$this->in_isDeath->FldIsDetailKey && !is_null($this->in_isDeath->FormValue) && $this->in_isDeath->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->in_isDeath->FldCaption(), $this->in_isDeath->ReqErrMsg));
		}
		if (!$this->in_isSale->FldIsDetailKey && !is_null($this->in_isSale->FormValue) && $this->in_isSale->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->in_isSale->FldCaption(), $this->in_isSale->ReqErrMsg));
		}
		if (!$this->is_InternalUse->FldIsDetailKey && !is_null($this->is_InternalUse->FormValue) && $this->is_InternalUse->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_InternalUse->FldCaption(), $this->is_InternalUse->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->is_InternalUse->FormValue)) {
			ew_AddMessage($gsFormError, $this->is_InternalUse->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// in_Name
			$this->in_Name->SetDbValueDef($rsnew, $this->in_Name->CurrentValue, "", $this->in_Name->ReadOnly);

			// in_isDeath
			$this->in_isDeath->SetDbValueDef($rsnew, $this->in_isDeath->CurrentValue, 0, $this->in_isDeath->ReadOnly);

			// in_isSale
			$this->in_isSale->SetDbValueDef($rsnew, $this->in_isSale->CurrentValue, 0, $this->in_isSale->ReadOnly);

			// is_InternalUse
			$this->is_InternalUse->SetDbValueDef($rsnew, $this->is_InternalUse->CurrentValue, 0, $this->is_InternalUse->ReadOnly);

			// in_Note
			$this->in_Note->SetDbValueDef($rsnew, $this->in_Note->CurrentValue, NULL, $this->in_Note->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("lov_intstatus_list.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($lov_intStatus_edit)) $lov_intStatus_edit = new clov_intStatus_edit();

// Page init
$lov_intStatus_edit->Page_Init();

// Page main
$lov_intStatus_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_intStatus_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = flov_intStatusedit = new ew_Form("flov_intStatusedit", "edit");

// Validate form
flov_intStatusedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_in_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_intStatus->in_Name->FldCaption(), $lov_intStatus->in_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_in_isDeath");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_intStatus->in_isDeath->FldCaption(), $lov_intStatus->in_isDeath->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_in_isSale");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_intStatus->in_isSale->FldCaption(), $lov_intStatus->in_isSale->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_InternalUse");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_intStatus->is_InternalUse->FldCaption(), $lov_intStatus->is_InternalUse->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_InternalUse");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lov_intStatus->is_InternalUse->FldErrMsg()) ?>");

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
flov_intStatusedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_intStatusedit.ValidateRequired = true;
<?php } else { ?>
flov_intStatusedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flov_intStatusedit.Lists["x_in_isDeath"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_intStatusedit.Lists["x_in_isDeath"].Options = <?php echo json_encode($lov_intStatus->in_isDeath->Options()) ?>;
flov_intStatusedit.Lists["x_in_isSale"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_intStatusedit.Lists["x_in_isSale"].Options = <?php echo json_encode($lov_intStatus->in_isSale->Options()) ?>;

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
<?php $lov_intStatus_edit->ShowPageHeader(); ?>
<?php
$lov_intStatus_edit->ShowMessage();
?>
<form name="flov_intStatusedit" id="flov_intStatusedit" class="<?php echo $lov_intStatus_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lov_intStatus_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lov_intStatus_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lov_intStatus">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($lov_intStatus->in_ID->Visible) { // in_ID ?>
	<div id="r_in_ID" class="form-group">
		<label id="elh_lov_intStatus_in_ID" class="col-sm-2 control-label ewLabel"><?php echo $lov_intStatus->in_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_intStatus->in_ID->CellAttributes() ?>>
<span id="el_lov_intStatus_in_ID">
<span<?php echo $lov_intStatus->in_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_intStatus->in_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="lov_intStatus" data-field="x_in_ID" name="x_in_ID" id="x_in_ID" value="<?php echo ew_HtmlEncode($lov_intStatus->in_ID->CurrentValue) ?>">
<?php echo $lov_intStatus->in_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_intStatus->in_Name->Visible) { // in_Name ?>
	<div id="r_in_Name" class="form-group">
		<label id="elh_lov_intStatus_in_Name" for="x_in_Name" class="col-sm-2 control-label ewLabel"><?php echo $lov_intStatus->in_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_intStatus->in_Name->CellAttributes() ?>>
<span id="el_lov_intStatus_in_Name">
<input type="text" data-table="lov_intStatus" data-field="x_in_Name" name="x_in_Name" id="x_in_Name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($lov_intStatus->in_Name->getPlaceHolder()) ?>" value="<?php echo $lov_intStatus->in_Name->EditValue ?>"<?php echo $lov_intStatus->in_Name->EditAttributes() ?>>
</span>
<?php echo $lov_intStatus->in_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_intStatus->in_isDeath->Visible) { // in_isDeath ?>
	<div id="r_in_isDeath" class="form-group">
		<label id="elh_lov_intStatus_in_isDeath" for="x_in_isDeath" class="col-sm-2 control-label ewLabel"><?php echo $lov_intStatus->in_isDeath->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_intStatus->in_isDeath->CellAttributes() ?>>
<span id="el_lov_intStatus_in_isDeath">
<select data-table="lov_intStatus" data-field="x_in_isDeath" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_intStatus->in_isDeath->DisplayValueSeparator) ? json_encode($lov_intStatus->in_isDeath->DisplayValueSeparator) : $lov_intStatus->in_isDeath->DisplayValueSeparator) ?>" id="x_in_isDeath" name="x_in_isDeath"<?php echo $lov_intStatus->in_isDeath->EditAttributes() ?>>
<?php
if (is_array($lov_intStatus->in_isDeath->EditValue)) {
	$arwrk = $lov_intStatus->in_isDeath->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($lov_intStatus->in_isDeath->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $lov_intStatus->in_isDeath->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($lov_intStatus->in_isDeath->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($lov_intStatus->in_isDeath->CurrentValue) ?>" selected><?php echo $lov_intStatus->in_isDeath->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $lov_intStatus->in_isDeath->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_intStatus->in_isSale->Visible) { // in_isSale ?>
	<div id="r_in_isSale" class="form-group">
		<label id="elh_lov_intStatus_in_isSale" for="x_in_isSale" class="col-sm-2 control-label ewLabel"><?php echo $lov_intStatus->in_isSale->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_intStatus->in_isSale->CellAttributes() ?>>
<span id="el_lov_intStatus_in_isSale">
<select data-table="lov_intStatus" data-field="x_in_isSale" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_intStatus->in_isSale->DisplayValueSeparator) ? json_encode($lov_intStatus->in_isSale->DisplayValueSeparator) : $lov_intStatus->in_isSale->DisplayValueSeparator) ?>" id="x_in_isSale" name="x_in_isSale"<?php echo $lov_intStatus->in_isSale->EditAttributes() ?>>
<?php
if (is_array($lov_intStatus->in_isSale->EditValue)) {
	$arwrk = $lov_intStatus->in_isSale->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($lov_intStatus->in_isSale->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $lov_intStatus->in_isSale->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($lov_intStatus->in_isSale->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($lov_intStatus->in_isSale->CurrentValue) ?>" selected><?php echo $lov_intStatus->in_isSale->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $lov_intStatus->in_isSale->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_intStatus->is_InternalUse->Visible) { // is_InternalUse ?>
	<div id="r_is_InternalUse" class="form-group">
		<label id="elh_lov_intStatus_is_InternalUse" for="x_is_InternalUse" class="col-sm-2 control-label ewLabel"><?php echo $lov_intStatus->is_InternalUse->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_intStatus->is_InternalUse->CellAttributes() ?>>
<span id="el_lov_intStatus_is_InternalUse">
<input type="text" data-table="lov_intStatus" data-field="x_is_InternalUse" name="x_is_InternalUse" id="x_is_InternalUse" size="30" placeholder="<?php echo ew_HtmlEncode($lov_intStatus->is_InternalUse->getPlaceHolder()) ?>" value="<?php echo $lov_intStatus->is_InternalUse->EditValue ?>"<?php echo $lov_intStatus->is_InternalUse->EditAttributes() ?>>
</span>
<?php echo $lov_intStatus->is_InternalUse->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_intStatus->in_Note->Visible) { // in_Note ?>
	<div id="r_in_Note" class="form-group">
		<label id="elh_lov_intStatus_in_Note" class="col-sm-2 control-label ewLabel"><?php echo $lov_intStatus->in_Note->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_intStatus->in_Note->CellAttributes() ?>>
<span id="el_lov_intStatus_in_Note">
<?php ew_AppendClass($lov_intStatus->in_Note->EditAttrs["class"], "editor"); ?>
<textarea data-table="lov_intStatus" data-field="x_in_Note" name="x_in_Note" id="x_in_Note" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($lov_intStatus->in_Note->getPlaceHolder()) ?>"<?php echo $lov_intStatus->in_Note->EditAttributes() ?>><?php echo $lov_intStatus->in_Note->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("flov_intStatusedit", "x_in_Note", 35, 4, <?php echo ($lov_intStatus->in_Note->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $lov_intStatus->in_Note->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $lov_intStatus_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
flov_intStatusedit.Init();
</script>
<?php
$lov_intStatus_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lov_intStatus_edit->Page_Terminate();
?>
