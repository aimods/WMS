<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "lov_countries_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$lov_countries_add = NULL; // Initialize page object first

class clov_countries_add extends clov_countries {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'lov_countries';

	// Page object name
	var $PageObjName = 'lov_countries_add';

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

		// Table object (lov_countries)
		if (!isset($GLOBALS["lov_countries"]) || get_class($GLOBALS["lov_countries"]) == "clov_countries") {
			$GLOBALS["lov_countries"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lov_countries"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lov_countries', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("lov_countries_list.php"));
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
		global $EW_EXPORT, $lov_countries;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lov_countries);
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("lov_countries_list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "lov_countries_list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "lov_countries_view.php")
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
		$this->countryCode->CurrentValue = NULL;
		$this->countryCode->OldValue = $this->countryCode->CurrentValue;
		$this->countryName->CurrentValue = NULL;
		$this->countryName->OldValue = $this->countryName->CurrentValue;
		$this->currencyCode->CurrentValue = NULL;
		$this->currencyCode->OldValue = $this->currencyCode->CurrentValue;
		$this->isoNumeric->CurrentValue = NULL;
		$this->isoNumeric->OldValue = $this->isoNumeric->CurrentValue;
		$this->isoAlpha3->CurrentValue = NULL;
		$this->isoAlpha3->OldValue = $this->isoAlpha3->CurrentValue;
		$this->geonameId->CurrentValue = NULL;
		$this->geonameId->OldValue = $this->geonameId->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->countryCode->FldIsDetailKey) {
			$this->countryCode->setFormValue($objForm->GetValue("x_countryCode"));
		}
		if (!$this->countryName->FldIsDetailKey) {
			$this->countryName->setFormValue($objForm->GetValue("x_countryName"));
		}
		if (!$this->currencyCode->FldIsDetailKey) {
			$this->currencyCode->setFormValue($objForm->GetValue("x_currencyCode"));
		}
		if (!$this->isoNumeric->FldIsDetailKey) {
			$this->isoNumeric->setFormValue($objForm->GetValue("x_isoNumeric"));
		}
		if (!$this->isoAlpha3->FldIsDetailKey) {
			$this->isoAlpha3->setFormValue($objForm->GetValue("x_isoAlpha3"));
		}
		if (!$this->geonameId->FldIsDetailKey) {
			$this->geonameId->setFormValue($objForm->GetValue("x_geonameId"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->countryCode->CurrentValue = $this->countryCode->FormValue;
		$this->countryName->CurrentValue = $this->countryName->FormValue;
		$this->currencyCode->CurrentValue = $this->currencyCode->FormValue;
		$this->isoNumeric->CurrentValue = $this->isoNumeric->FormValue;
		$this->isoAlpha3->CurrentValue = $this->isoAlpha3->FormValue;
		$this->geonameId->CurrentValue = $this->geonameId->FormValue;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->countryCode->setDbValue($rs->fields('countryCode'));
		$this->countryName->setDbValue($rs->fields('countryName'));
		$this->currencyCode->setDbValue($rs->fields('currencyCode'));
		$this->isoNumeric->setDbValue($rs->fields('isoNumeric'));
		$this->isoAlpha3->setDbValue($rs->fields('isoAlpha3'));
		$this->geonameId->setDbValue($rs->fields('geonameId'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->countryCode->DbValue = $row['countryCode'];
		$this->countryName->DbValue = $row['countryName'];
		$this->currencyCode->DbValue = $row['currencyCode'];
		$this->isoNumeric->DbValue = $row['isoNumeric'];
		$this->isoAlpha3->DbValue = $row['isoAlpha3'];
		$this->geonameId->DbValue = $row['geonameId'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// countryCode
		// countryName
		// currencyCode
		// isoNumeric
		// isoAlpha3
		// geonameId

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// countryCode
		$this->countryCode->ViewValue = $this->countryCode->CurrentValue;
		$this->countryCode->ViewCustomAttributes = "";

		// countryName
		$this->countryName->ViewValue = $this->countryName->CurrentValue;
		$this->countryName->ViewCustomAttributes = "";

		// currencyCode
		$this->currencyCode->ViewValue = $this->currencyCode->CurrentValue;
		$this->currencyCode->ViewCustomAttributes = "";

		// isoNumeric
		$this->isoNumeric->ViewValue = $this->isoNumeric->CurrentValue;
		$this->isoNumeric->ViewCustomAttributes = "";

		// isoAlpha3
		$this->isoAlpha3->ViewValue = $this->isoAlpha3->CurrentValue;
		$this->isoAlpha3->ViewCustomAttributes = "";

		// geonameId
		$this->geonameId->ViewValue = $this->geonameId->CurrentValue;
		$this->geonameId->ViewCustomAttributes = "";

			// countryCode
			$this->countryCode->LinkCustomAttributes = "";
			$this->countryCode->HrefValue = "";
			$this->countryCode->TooltipValue = "";

			// countryName
			$this->countryName->LinkCustomAttributes = "";
			$this->countryName->HrefValue = "";
			$this->countryName->TooltipValue = "";

			// currencyCode
			$this->currencyCode->LinkCustomAttributes = "";
			$this->currencyCode->HrefValue = "";
			$this->currencyCode->TooltipValue = "";

			// isoNumeric
			$this->isoNumeric->LinkCustomAttributes = "";
			$this->isoNumeric->HrefValue = "";
			$this->isoNumeric->TooltipValue = "";

			// isoAlpha3
			$this->isoAlpha3->LinkCustomAttributes = "";
			$this->isoAlpha3->HrefValue = "";
			$this->isoAlpha3->TooltipValue = "";

			// geonameId
			$this->geonameId->LinkCustomAttributes = "";
			$this->geonameId->HrefValue = "";
			$this->geonameId->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// countryCode
			$this->countryCode->EditAttrs["class"] = "form-control";
			$this->countryCode->EditCustomAttributes = "";
			$this->countryCode->EditValue = ew_HtmlEncode($this->countryCode->CurrentValue);
			$this->countryCode->PlaceHolder = ew_RemoveHtml($this->countryCode->FldCaption());

			// countryName
			$this->countryName->EditAttrs["class"] = "form-control";
			$this->countryName->EditCustomAttributes = "";
			$this->countryName->EditValue = ew_HtmlEncode($this->countryName->CurrentValue);
			$this->countryName->PlaceHolder = ew_RemoveHtml($this->countryName->FldCaption());

			// currencyCode
			$this->currencyCode->EditAttrs["class"] = "form-control";
			$this->currencyCode->EditCustomAttributes = "";
			$this->currencyCode->EditValue = ew_HtmlEncode($this->currencyCode->CurrentValue);
			$this->currencyCode->PlaceHolder = ew_RemoveHtml($this->currencyCode->FldCaption());

			// isoNumeric
			$this->isoNumeric->EditAttrs["class"] = "form-control";
			$this->isoNumeric->EditCustomAttributes = "";
			$this->isoNumeric->EditValue = ew_HtmlEncode($this->isoNumeric->CurrentValue);
			$this->isoNumeric->PlaceHolder = ew_RemoveHtml($this->isoNumeric->FldCaption());

			// isoAlpha3
			$this->isoAlpha3->EditAttrs["class"] = "form-control";
			$this->isoAlpha3->EditCustomAttributes = "";
			$this->isoAlpha3->EditValue = ew_HtmlEncode($this->isoAlpha3->CurrentValue);
			$this->isoAlpha3->PlaceHolder = ew_RemoveHtml($this->isoAlpha3->FldCaption());

			// geonameId
			$this->geonameId->EditAttrs["class"] = "form-control";
			$this->geonameId->EditCustomAttributes = "";
			$this->geonameId->EditValue = ew_HtmlEncode($this->geonameId->CurrentValue);
			$this->geonameId->PlaceHolder = ew_RemoveHtml($this->geonameId->FldCaption());

			// Add refer script
			// countryCode

			$this->countryCode->LinkCustomAttributes = "";
			$this->countryCode->HrefValue = "";

			// countryName
			$this->countryName->LinkCustomAttributes = "";
			$this->countryName->HrefValue = "";

			// currencyCode
			$this->currencyCode->LinkCustomAttributes = "";
			$this->currencyCode->HrefValue = "";

			// isoNumeric
			$this->isoNumeric->LinkCustomAttributes = "";
			$this->isoNumeric->HrefValue = "";

			// isoAlpha3
			$this->isoAlpha3->LinkCustomAttributes = "";
			$this->isoAlpha3->HrefValue = "";

			// geonameId
			$this->geonameId->LinkCustomAttributes = "";
			$this->geonameId->HrefValue = "";
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
		if (!$this->countryCode->FldIsDetailKey && !is_null($this->countryCode->FormValue) && $this->countryCode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->countryCode->FldCaption(), $this->countryCode->ReqErrMsg));
		}
		if (!$this->countryName->FldIsDetailKey && !is_null($this->countryName->FormValue) && $this->countryName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->countryName->FldCaption(), $this->countryName->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->geonameId->FormValue)) {
			ew_AddMessage($gsFormError, $this->geonameId->FldErrMsg());
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

		// countryCode
		$this->countryCode->SetDbValueDef($rsnew, $this->countryCode->CurrentValue, "", FALSE);

		// countryName
		$this->countryName->SetDbValueDef($rsnew, $this->countryName->CurrentValue, "", FALSE);

		// currencyCode
		$this->currencyCode->SetDbValueDef($rsnew, $this->currencyCode->CurrentValue, NULL, FALSE);

		// isoNumeric
		$this->isoNumeric->SetDbValueDef($rsnew, $this->isoNumeric->CurrentValue, NULL, FALSE);

		// isoAlpha3
		$this->isoAlpha3->SetDbValueDef($rsnew, $this->isoAlpha3->CurrentValue, NULL, FALSE);

		// geonameId
		$this->geonameId->SetDbValueDef($rsnew, $this->geonameId->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id->setDbValue($conn->Insert_ID());
				$rsnew['id'] = $this->id->DbValue;
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("lov_countries_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($lov_countries_add)) $lov_countries_add = new clov_countries_add();

// Page init
$lov_countries_add->Page_Init();

// Page main
$lov_countries_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_countries_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = flov_countriesadd = new ew_Form("flov_countriesadd", "add");

// Validate form
flov_countriesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_countryCode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_countries->countryCode->FldCaption(), $lov_countries->countryCode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_countryName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_countries->countryName->FldCaption(), $lov_countries->countryName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_geonameId");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lov_countries->geonameId->FldErrMsg()) ?>");

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
flov_countriesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_countriesadd.ValidateRequired = true;
<?php } else { ?>
flov_countriesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $lov_countries_add->ShowPageHeader(); ?>
<?php
$lov_countries_add->ShowMessage();
?>
<form name="flov_countriesadd" id="flov_countriesadd" class="<?php echo $lov_countries_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lov_countries_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lov_countries_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lov_countries">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($lov_countries->countryCode->Visible) { // countryCode ?>
	<div id="r_countryCode" class="form-group">
		<label id="elh_lov_countries_countryCode" for="x_countryCode" class="col-sm-2 control-label ewLabel"><?php echo $lov_countries->countryCode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_countries->countryCode->CellAttributes() ?>>
<span id="el_lov_countries_countryCode">
<input type="text" data-table="lov_countries" data-field="x_countryCode" name="x_countryCode" id="x_countryCode" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($lov_countries->countryCode->getPlaceHolder()) ?>" value="<?php echo $lov_countries->countryCode->EditValue ?>"<?php echo $lov_countries->countryCode->EditAttributes() ?>>
</span>
<?php echo $lov_countries->countryCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_countries->countryName->Visible) { // countryName ?>
	<div id="r_countryName" class="form-group">
		<label id="elh_lov_countries_countryName" for="x_countryName" class="col-sm-2 control-label ewLabel"><?php echo $lov_countries->countryName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_countries->countryName->CellAttributes() ?>>
<span id="el_lov_countries_countryName">
<input type="text" data-table="lov_countries" data-field="x_countryName" name="x_countryName" id="x_countryName" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($lov_countries->countryName->getPlaceHolder()) ?>" value="<?php echo $lov_countries->countryName->EditValue ?>"<?php echo $lov_countries->countryName->EditAttributes() ?>>
</span>
<?php echo $lov_countries->countryName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_countries->currencyCode->Visible) { // currencyCode ?>
	<div id="r_currencyCode" class="form-group">
		<label id="elh_lov_countries_currencyCode" for="x_currencyCode" class="col-sm-2 control-label ewLabel"><?php echo $lov_countries->currencyCode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_countries->currencyCode->CellAttributes() ?>>
<span id="el_lov_countries_currencyCode">
<input type="text" data-table="lov_countries" data-field="x_currencyCode" name="x_currencyCode" id="x_currencyCode" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($lov_countries->currencyCode->getPlaceHolder()) ?>" value="<?php echo $lov_countries->currencyCode->EditValue ?>"<?php echo $lov_countries->currencyCode->EditAttributes() ?>>
</span>
<?php echo $lov_countries->currencyCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_countries->isoNumeric->Visible) { // isoNumeric ?>
	<div id="r_isoNumeric" class="form-group">
		<label id="elh_lov_countries_isoNumeric" for="x_isoNumeric" class="col-sm-2 control-label ewLabel"><?php echo $lov_countries->isoNumeric->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_countries->isoNumeric->CellAttributes() ?>>
<span id="el_lov_countries_isoNumeric">
<input type="text" data-table="lov_countries" data-field="x_isoNumeric" name="x_isoNumeric" id="x_isoNumeric" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($lov_countries->isoNumeric->getPlaceHolder()) ?>" value="<?php echo $lov_countries->isoNumeric->EditValue ?>"<?php echo $lov_countries->isoNumeric->EditAttributes() ?>>
</span>
<?php echo $lov_countries->isoNumeric->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_countries->isoAlpha3->Visible) { // isoAlpha3 ?>
	<div id="r_isoAlpha3" class="form-group">
		<label id="elh_lov_countries_isoAlpha3" for="x_isoAlpha3" class="col-sm-2 control-label ewLabel"><?php echo $lov_countries->isoAlpha3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_countries->isoAlpha3->CellAttributes() ?>>
<span id="el_lov_countries_isoAlpha3">
<input type="text" data-table="lov_countries" data-field="x_isoAlpha3" name="x_isoAlpha3" id="x_isoAlpha3" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($lov_countries->isoAlpha3->getPlaceHolder()) ?>" value="<?php echo $lov_countries->isoAlpha3->EditValue ?>"<?php echo $lov_countries->isoAlpha3->EditAttributes() ?>>
</span>
<?php echo $lov_countries->isoAlpha3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_countries->geonameId->Visible) { // geonameId ?>
	<div id="r_geonameId" class="form-group">
		<label id="elh_lov_countries_geonameId" for="x_geonameId" class="col-sm-2 control-label ewLabel"><?php echo $lov_countries->geonameId->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_countries->geonameId->CellAttributes() ?>>
<span id="el_lov_countries_geonameId">
<input type="text" data-table="lov_countries" data-field="x_geonameId" name="x_geonameId" id="x_geonameId" size="30" placeholder="<?php echo ew_HtmlEncode($lov_countries->geonameId->getPlaceHolder()) ?>" value="<?php echo $lov_countries->geonameId->EditValue ?>"<?php echo $lov_countries->geonameId->EditAttributes() ?>>
</span>
<?php echo $lov_countries->geonameId->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $lov_countries_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
flov_countriesadd.Init();
</script>
<?php
$lov_countries_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lov_countries_add->Page_Terminate();
?>
