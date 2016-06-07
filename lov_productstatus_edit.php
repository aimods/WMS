<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "lov_productstatus_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$lov_ProductStatus_edit = NULL; // Initialize page object first

class clov_ProductStatus_edit extends clov_ProductStatus {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'lov_ProductStatus';

	// Page object name
	var $PageObjName = 'lov_ProductStatus_edit';

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

		// Table object (lov_ProductStatus)
		if (!isset($GLOBALS["lov_ProductStatus"]) || get_class($GLOBALS["lov_ProductStatus"]) == "clov_ProductStatus") {
			$GLOBALS["lov_ProductStatus"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lov_ProductStatus"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lov_ProductStatus', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("lov_productstatus_list.php"));
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
		$this->ps_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $lov_ProductStatus;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lov_ProductStatus);
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
		if (@$_GET["ps_ID"] <> "") {
			$this->ps_ID->setQueryStringValue($_GET["ps_ID"]);
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
		if ($this->ps_ID->CurrentValue == "")
			$this->Page_Terminate("lov_productstatus_list.php"); // Invalid key, return to list

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
					$this->Page_Terminate("lov_productstatus_list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "lov_productstatus_list.php")
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
		if (!$this->ps_ID->FldIsDetailKey)
			$this->ps_ID->setFormValue($objForm->GetValue("x_ps_ID"));
		if (!$this->ps_Name->FldIsDetailKey) {
			$this->ps_Name->setFormValue($objForm->GetValue("x_ps_Name"));
		}
		if (!$this->ps_inWarranty->FldIsDetailKey) {
			$this->ps_inWarranty->setFormValue($objForm->GetValue("x_ps_inWarranty"));
		}
		if (!$this->ps_DayofWarranty->FldIsDetailKey) {
			$this->ps_DayofWarranty->setFormValue($objForm->GetValue("x_ps_DayofWarranty"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ps_ID->CurrentValue = $this->ps_ID->FormValue;
		$this->ps_Name->CurrentValue = $this->ps_Name->FormValue;
		$this->ps_inWarranty->CurrentValue = $this->ps_inWarranty->FormValue;
		$this->ps_DayofWarranty->CurrentValue = $this->ps_DayofWarranty->FormValue;
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
		$this->ps_ID->setDbValue($rs->fields('ps_ID'));
		$this->ps_Name->setDbValue($rs->fields('ps_Name'));
		$this->ps_inWarranty->setDbValue($rs->fields('ps_inWarranty'));
		$this->ps_DayofWarranty->setDbValue($rs->fields('ps_DayofWarranty'));
		$this->ps_Created->setDbValue($rs->fields('ps_Created'));
		$this->ps_Updated->setDbValue($rs->fields('ps_Updated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ps_ID->DbValue = $row['ps_ID'];
		$this->ps_Name->DbValue = $row['ps_Name'];
		$this->ps_inWarranty->DbValue = $row['ps_inWarranty'];
		$this->ps_DayofWarranty->DbValue = $row['ps_DayofWarranty'];
		$this->ps_Created->DbValue = $row['ps_Created'];
		$this->ps_Updated->DbValue = $row['ps_Updated'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// ps_ID
		// ps_Name
		// ps_inWarranty
		// ps_DayofWarranty
		// ps_Created
		// ps_Updated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// ps_ID
		$this->ps_ID->ViewValue = $this->ps_ID->CurrentValue;
		$this->ps_ID->ViewCustomAttributes = "";

		// ps_Name
		$this->ps_Name->ViewValue = $this->ps_Name->CurrentValue;
		$this->ps_Name->ViewCustomAttributes = "";

		// ps_inWarranty
		if (strval($this->ps_inWarranty->CurrentValue) <> "") {
			$this->ps_inWarranty->ViewValue = $this->ps_inWarranty->OptionCaption($this->ps_inWarranty->CurrentValue);
		} else {
			$this->ps_inWarranty->ViewValue = NULL;
		}
		$this->ps_inWarranty->ViewCustomAttributes = "";

		// ps_DayofWarranty
		$this->ps_DayofWarranty->ViewValue = $this->ps_DayofWarranty->CurrentValue;
		$this->ps_DayofWarranty->ViewCustomAttributes = "";

		// ps_Created
		$this->ps_Created->ViewValue = $this->ps_Created->CurrentValue;
		$this->ps_Created->ViewValue = ew_FormatDateTime($this->ps_Created->ViewValue, 7);
		$this->ps_Created->ViewCustomAttributes = "";

		// ps_Updated
		$this->ps_Updated->ViewValue = $this->ps_Updated->CurrentValue;
		$this->ps_Updated->ViewValue = ew_FormatDateTime($this->ps_Updated->ViewValue, 7);
		$this->ps_Updated->ViewCustomAttributes = "";

			// ps_ID
			$this->ps_ID->LinkCustomAttributes = "";
			$this->ps_ID->HrefValue = "";
			$this->ps_ID->TooltipValue = "";

			// ps_Name
			$this->ps_Name->LinkCustomAttributes = "";
			$this->ps_Name->HrefValue = "";
			$this->ps_Name->TooltipValue = "";

			// ps_inWarranty
			$this->ps_inWarranty->LinkCustomAttributes = "";
			$this->ps_inWarranty->HrefValue = "";
			$this->ps_inWarranty->TooltipValue = "";

			// ps_DayofWarranty
			$this->ps_DayofWarranty->LinkCustomAttributes = "";
			$this->ps_DayofWarranty->HrefValue = "";
			$this->ps_DayofWarranty->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// ps_ID
			$this->ps_ID->EditAttrs["class"] = "form-control";
			$this->ps_ID->EditCustomAttributes = "";
			$this->ps_ID->EditValue = $this->ps_ID->CurrentValue;
			$this->ps_ID->ViewCustomAttributes = "";

			// ps_Name
			$this->ps_Name->EditAttrs["class"] = "form-control";
			$this->ps_Name->EditCustomAttributes = "";
			$this->ps_Name->EditValue = ew_HtmlEncode($this->ps_Name->CurrentValue);
			$this->ps_Name->PlaceHolder = ew_RemoveHtml($this->ps_Name->FldCaption());

			// ps_inWarranty
			$this->ps_inWarranty->EditCustomAttributes = "";
			$this->ps_inWarranty->EditValue = $this->ps_inWarranty->Options(FALSE);

			// ps_DayofWarranty
			$this->ps_DayofWarranty->EditAttrs["class"] = "form-control";
			$this->ps_DayofWarranty->EditCustomAttributes = "";
			$this->ps_DayofWarranty->EditValue = ew_HtmlEncode($this->ps_DayofWarranty->CurrentValue);
			$this->ps_DayofWarranty->PlaceHolder = ew_RemoveHtml($this->ps_DayofWarranty->FldCaption());

			// Edit refer script
			// ps_ID

			$this->ps_ID->LinkCustomAttributes = "";
			$this->ps_ID->HrefValue = "";

			// ps_Name
			$this->ps_Name->LinkCustomAttributes = "";
			$this->ps_Name->HrefValue = "";

			// ps_inWarranty
			$this->ps_inWarranty->LinkCustomAttributes = "";
			$this->ps_inWarranty->HrefValue = "";

			// ps_DayofWarranty
			$this->ps_DayofWarranty->LinkCustomAttributes = "";
			$this->ps_DayofWarranty->HrefValue = "";
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
		if (!$this->ps_Name->FldIsDetailKey && !is_null($this->ps_Name->FormValue) && $this->ps_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ps_Name->FldCaption(), $this->ps_Name->ReqErrMsg));
		}
		if ($this->ps_inWarranty->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ps_inWarranty->FldCaption(), $this->ps_inWarranty->ReqErrMsg));
		}
		if (!$this->ps_DayofWarranty->FldIsDetailKey && !is_null($this->ps_DayofWarranty->FormValue) && $this->ps_DayofWarranty->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ps_DayofWarranty->FldCaption(), $this->ps_DayofWarranty->ReqErrMsg));
		}
		if (!ew_CheckRange($this->ps_DayofWarranty->FormValue, 0, 2000)) {
			ew_AddMessage($gsFormError, $this->ps_DayofWarranty->FldErrMsg());
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
		if ($this->ps_Name->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`ps_Name` = '" . ew_AdjustSql($this->ps_Name->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->ps_Name->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->ps_Name->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// ps_Name
			$this->ps_Name->SetDbValueDef($rsnew, $this->ps_Name->CurrentValue, "", $this->ps_Name->ReadOnly);

			// ps_inWarranty
			$this->ps_inWarranty->SetDbValueDef($rsnew, $this->ps_inWarranty->CurrentValue, 0, $this->ps_inWarranty->ReadOnly);

			// ps_DayofWarranty
			$this->ps_DayofWarranty->SetDbValueDef($rsnew, $this->ps_DayofWarranty->CurrentValue, 0, $this->ps_DayofWarranty->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("lov_productstatus_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($lov_ProductStatus_edit)) $lov_ProductStatus_edit = new clov_ProductStatus_edit();

// Page init
$lov_ProductStatus_edit->Page_Init();

// Page main
$lov_ProductStatus_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_ProductStatus_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = flov_ProductStatusedit = new ew_Form("flov_ProductStatusedit", "edit");

// Validate form
flov_ProductStatusedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_ps_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_ProductStatus->ps_Name->FldCaption(), $lov_ProductStatus->ps_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ps_inWarranty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_ProductStatus->ps_inWarranty->FldCaption(), $lov_ProductStatus->ps_inWarranty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ps_DayofWarranty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_ProductStatus->ps_DayofWarranty->FldCaption(), $lov_ProductStatus->ps_DayofWarranty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ps_DayofWarranty");
			if (elm && !ew_CheckRange(elm.value, 0, 2000))
				return this.OnError(elm, "<?php echo ew_JsEncode2($lov_ProductStatus->ps_DayofWarranty->FldErrMsg()) ?>");

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
flov_ProductStatusedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_ProductStatusedit.ValidateRequired = true;
<?php } else { ?>
flov_ProductStatusedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flov_ProductStatusedit.Lists["x_ps_inWarranty"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_ProductStatusedit.Lists["x_ps_inWarranty"].Options = <?php echo json_encode($lov_ProductStatus->ps_inWarranty->Options()) ?>;

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
<?php $lov_ProductStatus_edit->ShowPageHeader(); ?>
<?php
$lov_ProductStatus_edit->ShowMessage();
?>
<form name="flov_ProductStatusedit" id="flov_ProductStatusedit" class="<?php echo $lov_ProductStatus_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lov_ProductStatus_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lov_ProductStatus_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lov_ProductStatus">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($lov_ProductStatus->ps_ID->Visible) { // ps_ID ?>
	<div id="r_ps_ID" class="form-group">
		<label id="elh_lov_ProductStatus_ps_ID" class="col-sm-2 control-label ewLabel"><?php echo $lov_ProductStatus->ps_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_ProductStatus->ps_ID->CellAttributes() ?>>
<span id="el_lov_ProductStatus_ps_ID">
<span<?php echo $lov_ProductStatus->ps_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_ProductStatus->ps_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="lov_ProductStatus" data-field="x_ps_ID" name="x_ps_ID" id="x_ps_ID" value="<?php echo ew_HtmlEncode($lov_ProductStatus->ps_ID->CurrentValue) ?>">
<?php echo $lov_ProductStatus->ps_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_ProductStatus->ps_Name->Visible) { // ps_Name ?>
	<div id="r_ps_Name" class="form-group">
		<label id="elh_lov_ProductStatus_ps_Name" for="x_ps_Name" class="col-sm-2 control-label ewLabel"><?php echo $lov_ProductStatus->ps_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_ProductStatus->ps_Name->CellAttributes() ?>>
<span id="el_lov_ProductStatus_ps_Name">
<input type="text" data-table="lov_ProductStatus" data-field="x_ps_Name" name="x_ps_Name" id="x_ps_Name" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($lov_ProductStatus->ps_Name->getPlaceHolder()) ?>" value="<?php echo $lov_ProductStatus->ps_Name->EditValue ?>"<?php echo $lov_ProductStatus->ps_Name->EditAttributes() ?>>
</span>
<?php echo $lov_ProductStatus->ps_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_ProductStatus->ps_inWarranty->Visible) { // ps_inWarranty ?>
	<div id="r_ps_inWarranty" class="form-group">
		<label id="elh_lov_ProductStatus_ps_inWarranty" class="col-sm-2 control-label ewLabel"><?php echo $lov_ProductStatus->ps_inWarranty->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_ProductStatus->ps_inWarranty->CellAttributes() ?>>
<span id="el_lov_ProductStatus_ps_inWarranty">
<div id="tp_x_ps_inWarranty" class="ewTemplate"><input type="radio" data-table="lov_ProductStatus" data-field="x_ps_inWarranty" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_ProductStatus->ps_inWarranty->DisplayValueSeparator) ? json_encode($lov_ProductStatus->ps_inWarranty->DisplayValueSeparator) : $lov_ProductStatus->ps_inWarranty->DisplayValueSeparator) ?>" name="x_ps_inWarranty" id="x_ps_inWarranty" value="{value}"<?php echo $lov_ProductStatus->ps_inWarranty->EditAttributes() ?>></div>
<div id="dsl_x_ps_inWarranty" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $lov_ProductStatus->ps_inWarranty->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lov_ProductStatus->ps_inWarranty->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="lov_ProductStatus" data-field="x_ps_inWarranty" name="x_ps_inWarranty" id="x_ps_inWarranty_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $lov_ProductStatus->ps_inWarranty->EditAttributes() ?>><?php echo $lov_ProductStatus->ps_inWarranty->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($lov_ProductStatus->ps_inWarranty->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="lov_ProductStatus" data-field="x_ps_inWarranty" name="x_ps_inWarranty" id="x_ps_inWarranty_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($lov_ProductStatus->ps_inWarranty->CurrentValue) ?>" checked<?php echo $lov_ProductStatus->ps_inWarranty->EditAttributes() ?>><?php echo $lov_ProductStatus->ps_inWarranty->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $lov_ProductStatus->ps_inWarranty->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_ProductStatus->ps_DayofWarranty->Visible) { // ps_DayofWarranty ?>
	<div id="r_ps_DayofWarranty" class="form-group">
		<label id="elh_lov_ProductStatus_ps_DayofWarranty" for="x_ps_DayofWarranty" class="col-sm-2 control-label ewLabel"><?php echo $lov_ProductStatus->ps_DayofWarranty->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_ProductStatus->ps_DayofWarranty->CellAttributes() ?>>
<span id="el_lov_ProductStatus_ps_DayofWarranty">
<input type="text" data-table="lov_ProductStatus" data-field="x_ps_DayofWarranty" name="x_ps_DayofWarranty" id="x_ps_DayofWarranty" size="30" placeholder="<?php echo ew_HtmlEncode($lov_ProductStatus->ps_DayofWarranty->getPlaceHolder()) ?>" value="<?php echo $lov_ProductStatus->ps_DayofWarranty->EditValue ?>"<?php echo $lov_ProductStatus->ps_DayofWarranty->EditAttributes() ?>>
</span>
<?php echo $lov_ProductStatus->ps_DayofWarranty->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $lov_ProductStatus_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
flov_ProductStatusedit.Init();
</script>
<?php
$lov_ProductStatus_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lov_ProductStatus_edit->Page_Terminate();
?>
