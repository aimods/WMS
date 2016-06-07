<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "main_vendor_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "main_partnum_gridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$main_Vendor_add = NULL; // Initialize page object first

class cmain_Vendor_add extends cmain_Vendor {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_Vendor';

	// Page object name
	var $PageObjName = 'main_Vendor_add';

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

		// Table object (main_Vendor)
		if (!isset($GLOBALS["main_Vendor"]) || get_class($GLOBALS["main_Vendor"]) == "cmain_Vendor") {
			$GLOBALS["main_Vendor"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_Vendor"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'main_Vendor', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("main_vendor_list.php"));
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

			// Process auto fill for detail table 'main_PartNum'
			if (@$_POST["grid"] == "fmain_PartNumgrid") {
				if (!isset($GLOBALS["main_PartNum_grid"])) $GLOBALS["main_PartNum_grid"] = new cmain_PartNum_grid;
				$GLOBALS["main_PartNum_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $main_Vendor;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($main_Vendor);
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
			if (@$_GET["v_ID"] != "") {
				$this->v_ID->setQueryStringValue($_GET["v_ID"]);
				$this->setKey("v_ID", $this->v_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("v_ID", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("main_vendor_list.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "main_vendor_list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "main_vendor_view.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->v_Name->CurrentValue = NULL;
		$this->v_Name->OldValue = $this->v_Name->CurrentValue;
		$this->v_TAX->CurrentValue = NULL;
		$this->v_TAX->OldValue = $this->v_TAX->CurrentValue;
		$this->v_Country->CurrentValue = NULL;
		$this->v_Country->OldValue = $this->v_Country->CurrentValue;
		$this->v_BillingAddress->CurrentValue = NULL;
		$this->v_BillingAddress->OldValue = $this->v_BillingAddress->CurrentValue;
		$this->v_Contact->CurrentValue = NULL;
		$this->v_Contact->OldValue = $this->v_Contact->CurrentValue;
		$this->v_Note->CurrentValue = NULL;
		$this->v_Note->OldValue = $this->v_Note->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->v_Name->FldIsDetailKey) {
			$this->v_Name->setFormValue($objForm->GetValue("x_v_Name"));
		}
		if (!$this->v_TAX->FldIsDetailKey) {
			$this->v_TAX->setFormValue($objForm->GetValue("x_v_TAX"));
		}
		if (!$this->v_Country->FldIsDetailKey) {
			$this->v_Country->setFormValue($objForm->GetValue("x_v_Country"));
		}
		if (!$this->v_BillingAddress->FldIsDetailKey) {
			$this->v_BillingAddress->setFormValue($objForm->GetValue("x_v_BillingAddress"));
		}
		if (!$this->v_Contact->FldIsDetailKey) {
			$this->v_Contact->setFormValue($objForm->GetValue("x_v_Contact"));
		}
		if (!$this->v_Note->FldIsDetailKey) {
			$this->v_Note->setFormValue($objForm->GetValue("x_v_Note"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->v_Name->CurrentValue = $this->v_Name->FormValue;
		$this->v_TAX->CurrentValue = $this->v_TAX->FormValue;
		$this->v_Country->CurrentValue = $this->v_Country->FormValue;
		$this->v_BillingAddress->CurrentValue = $this->v_BillingAddress->FormValue;
		$this->v_Contact->CurrentValue = $this->v_Contact->FormValue;
		$this->v_Note->CurrentValue = $this->v_Note->FormValue;
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
		$this->v_ID->setDbValue($rs->fields('v_ID'));
		$this->v_Name->setDbValue($rs->fields('v_Name'));
		$this->v_TAX->setDbValue($rs->fields('v_TAX'));
		$this->v_Country->setDbValue($rs->fields('v_Country'));
		$this->v_BillingAddress->setDbValue($rs->fields('v_BillingAddress'));
		$this->v_Contact->setDbValue($rs->fields('v_Contact'));
		$this->v_Created->setDbValue($rs->fields('v_Created'));
		$this->v_Updated->setDbValue($rs->fields('v_Updated'));
		$this->v_Note->setDbValue($rs->fields('v_Note'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->v_ID->DbValue = $row['v_ID'];
		$this->v_Name->DbValue = $row['v_Name'];
		$this->v_TAX->DbValue = $row['v_TAX'];
		$this->v_Country->DbValue = $row['v_Country'];
		$this->v_BillingAddress->DbValue = $row['v_BillingAddress'];
		$this->v_Contact->DbValue = $row['v_Contact'];
		$this->v_Created->DbValue = $row['v_Created'];
		$this->v_Updated->DbValue = $row['v_Updated'];
		$this->v_Note->DbValue = $row['v_Note'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("v_ID")) <> "")
			$this->v_ID->CurrentValue = $this->getKey("v_ID"); // v_ID
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
		// v_ID
		// v_Name
		// v_TAX
		// v_Country
		// v_BillingAddress
		// v_Contact
		// v_Created
		// v_Updated
		// v_Note

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// v_Name
		$this->v_Name->ViewValue = $this->v_Name->CurrentValue;
		$this->v_Name->ViewCustomAttributes = "";

		// v_TAX
		$this->v_TAX->ViewValue = $this->v_TAX->CurrentValue;
		$this->v_TAX->ViewCustomAttributes = "";

		// v_Country
		if (strval($this->v_Country->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->v_Country->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `countryName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_countries`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_Country, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `countryName`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_Country->ViewValue = $this->v_Country->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_Country->ViewValue = $this->v_Country->CurrentValue;
			}
		} else {
			$this->v_Country->ViewValue = NULL;
		}
		$this->v_Country->ViewCustomAttributes = "";

		// v_BillingAddress
		$this->v_BillingAddress->ViewValue = $this->v_BillingAddress->CurrentValue;
		$this->v_BillingAddress->ViewCustomAttributes = "";

		// v_Contact
		if (strval($this->v_Contact->CurrentValue) <> "") {
			$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->v_Contact->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_Contact, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_Contact->ViewValue = $this->v_Contact->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_Contact->ViewValue = $this->v_Contact->CurrentValue;
			}
		} else {
			$this->v_Contact->ViewValue = NULL;
		}
		$this->v_Contact->ViewCustomAttributes = "";

		// v_Note
		$this->v_Note->ViewValue = $this->v_Note->CurrentValue;
		$this->v_Note->ViewCustomAttributes = "";

			// v_Name
			$this->v_Name->LinkCustomAttributes = "";
			$this->v_Name->HrefValue = "";
			$this->v_Name->TooltipValue = "";

			// v_TAX
			$this->v_TAX->LinkCustomAttributes = "";
			$this->v_TAX->HrefValue = "";
			$this->v_TAX->TooltipValue = "";

			// v_Country
			$this->v_Country->LinkCustomAttributes = "";
			$this->v_Country->HrefValue = "";
			$this->v_Country->TooltipValue = "";

			// v_BillingAddress
			$this->v_BillingAddress->LinkCustomAttributes = "";
			$this->v_BillingAddress->HrefValue = "";
			$this->v_BillingAddress->TooltipValue = "";

			// v_Contact
			$this->v_Contact->LinkCustomAttributes = "";
			if (!ew_Empty($this->v_Contact->CurrentValue)) {
				$this->v_Contact->HrefValue = "main_user_view.php?showdetail=&u_ID=" . $this->v_Contact->CurrentValue; // Add prefix/suffix
				$this->v_Contact->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->v_Contact->HrefValue = ew_ConvertFullUrl($this->v_Contact->HrefValue);
			} else {
				$this->v_Contact->HrefValue = "";
			}
			$this->v_Contact->TooltipValue = "";

			// v_Note
			$this->v_Note->LinkCustomAttributes = "";
			$this->v_Note->HrefValue = "";
			$this->v_Note->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// v_Name
			$this->v_Name->EditAttrs["class"] = "form-control";
			$this->v_Name->EditCustomAttributes = "";
			$this->v_Name->EditValue = ew_HtmlEncode($this->v_Name->CurrentValue);
			$this->v_Name->PlaceHolder = ew_RemoveHtml($this->v_Name->FldCaption());

			// v_TAX
			$this->v_TAX->EditAttrs["class"] = "form-control";
			$this->v_TAX->EditCustomAttributes = "";
			$this->v_TAX->EditValue = ew_HtmlEncode($this->v_TAX->CurrentValue);
			$this->v_TAX->PlaceHolder = ew_RemoveHtml($this->v_TAX->FldCaption());

			// v_Country
			$this->v_Country->EditCustomAttributes = "";
			if (trim(strval($this->v_Country->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->v_Country->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `countryName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_countries`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->v_Country, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `countryName`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->v_Country->ViewValue = $this->v_Country->DisplayValue($arwrk);
			} else {
				$this->v_Country->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->v_Country->EditValue = $arwrk;

			// v_BillingAddress
			$this->v_BillingAddress->EditAttrs["class"] = "form-control";
			$this->v_BillingAddress->EditCustomAttributes = "";
			$this->v_BillingAddress->EditValue = ew_HtmlEncode($this->v_BillingAddress->CurrentValue);
			$this->v_BillingAddress->PlaceHolder = ew_RemoveHtml($this->v_BillingAddress->FldCaption());

			// v_Contact
			$this->v_Contact->EditCustomAttributes = "";
			if (trim(strval($this->v_Contact->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->v_Contact->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_User`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->v_Contact, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->v_Contact->ViewValue = $this->v_Contact->DisplayValue($arwrk);
			} else {
				$this->v_Contact->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->v_Contact->EditValue = $arwrk;

			// v_Note
			$this->v_Note->EditAttrs["class"] = "form-control";
			$this->v_Note->EditCustomAttributes = "";
			$this->v_Note->EditValue = ew_HtmlEncode($this->v_Note->CurrentValue);
			$this->v_Note->PlaceHolder = ew_RemoveHtml($this->v_Note->FldCaption());

			// Add refer script
			// v_Name

			$this->v_Name->LinkCustomAttributes = "";
			$this->v_Name->HrefValue = "";

			// v_TAX
			$this->v_TAX->LinkCustomAttributes = "";
			$this->v_TAX->HrefValue = "";

			// v_Country
			$this->v_Country->LinkCustomAttributes = "";
			$this->v_Country->HrefValue = "";

			// v_BillingAddress
			$this->v_BillingAddress->LinkCustomAttributes = "";
			$this->v_BillingAddress->HrefValue = "";

			// v_Contact
			$this->v_Contact->LinkCustomAttributes = "";
			if (!ew_Empty($this->v_Contact->CurrentValue)) {
				$this->v_Contact->HrefValue = "main_user_view.php?showdetail=&u_ID=" . $this->v_Contact->CurrentValue; // Add prefix/suffix
				$this->v_Contact->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->v_Contact->HrefValue = ew_ConvertFullUrl($this->v_Contact->HrefValue);
			} else {
				$this->v_Contact->HrefValue = "";
			}

			// v_Note
			$this->v_Note->LinkCustomAttributes = "";
			$this->v_Note->HrefValue = "";
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
		if (!$this->v_Name->FldIsDetailKey && !is_null($this->v_Name->FormValue) && $this->v_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->v_Name->FldCaption(), $this->v_Name->ReqErrMsg));
		}
		if (!$this->v_Country->FldIsDetailKey && !is_null($this->v_Country->FormValue) && $this->v_Country->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->v_Country->FldCaption(), $this->v_Country->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("main_PartNum", $DetailTblVar) && $GLOBALS["main_PartNum"]->DetailAdd) {
			if (!isset($GLOBALS["main_PartNum_grid"])) $GLOBALS["main_PartNum_grid"] = new cmain_PartNum_grid(); // get detail page object
			$GLOBALS["main_PartNum_grid"]->ValidateGridForm();
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
		if ($this->v_TAX->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(v_TAX = '" . ew_AdjustSql($this->v_TAX->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->v_TAX->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->v_TAX->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// v_Name
		$this->v_Name->SetDbValueDef($rsnew, $this->v_Name->CurrentValue, "", FALSE);

		// v_TAX
		$this->v_TAX->SetDbValueDef($rsnew, $this->v_TAX->CurrentValue, NULL, FALSE);

		// v_Country
		$this->v_Country->SetDbValueDef($rsnew, $this->v_Country->CurrentValue, 0, FALSE);

		// v_BillingAddress
		$this->v_BillingAddress->SetDbValueDef($rsnew, $this->v_BillingAddress->CurrentValue, NULL, FALSE);

		// v_Contact
		$this->v_Contact->SetDbValueDef($rsnew, $this->v_Contact->CurrentValue, NULL, FALSE);

		// v_Note
		$this->v_Note->SetDbValueDef($rsnew, $this->v_Note->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->v_ID->setDbValue($conn->Insert_ID());
				$rsnew['v_ID'] = $this->v_ID->DbValue;
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("main_PartNum", $DetailTblVar) && $GLOBALS["main_PartNum"]->DetailAdd) {
				$GLOBALS["main_PartNum"]->v_ID->setSessionValue($this->v_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["main_PartNum_grid"])) $GLOBALS["main_PartNum_grid"] = new cmain_PartNum_grid(); // Get detail page object
				$AddRow = $GLOBALS["main_PartNum_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["main_PartNum"]->v_ID->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("main_PartNum", $DetailTblVar)) {
				if (!isset($GLOBALS["main_PartNum_grid"]))
					$GLOBALS["main_PartNum_grid"] = new cmain_PartNum_grid;
				if ($GLOBALS["main_PartNum_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["main_PartNum_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["main_PartNum_grid"]->CurrentMode = "add";
					$GLOBALS["main_PartNum_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["main_PartNum_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["main_PartNum_grid"]->setStartRecordNumber(1);
					$GLOBALS["main_PartNum_grid"]->v_ID->FldIsDetailKey = TRUE;
					$GLOBALS["main_PartNum_grid"]->v_ID->CurrentValue = $this->v_ID->CurrentValue;
					$GLOBALS["main_PartNum_grid"]->v_ID->setSessionValue($GLOBALS["main_PartNum_grid"]->v_ID->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("main_vendor_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($main_Vendor_add)) $main_Vendor_add = new cmain_Vendor_add();

// Page init
$main_Vendor_add->Page_Init();

// Page main
$main_Vendor_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_Vendor_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmain_Vendoradd = new ew_Form("fmain_Vendoradd", "add");

// Validate form
fmain_Vendoradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_v_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Vendor->v_Name->FldCaption(), $main_Vendor->v_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_v_Country");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Vendor->v_Country->FldCaption(), $main_Vendor->v_Country->ReqErrMsg)) ?>");

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
fmain_Vendoradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Vendoradd.ValidateRequired = true;
<?php } else { ?>
fmain_Vendoradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Vendoradd.Lists["x_v_Country"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_countryName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Vendoradd.Lists["x_v_Contact"] = {"LinkField":"x_u_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_BillName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $main_Vendor_add->ShowPageHeader(); ?>
<?php
$main_Vendor_add->ShowMessage();
?>
<form name="fmain_Vendoradd" id="fmain_Vendoradd" class="<?php echo $main_Vendor_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_Vendor_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_Vendor_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_Vendor">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($main_Vendor->v_Name->Visible) { // v_Name ?>
	<div id="r_v_Name" class="form-group">
		<label id="elh_main_Vendor_v_Name" for="x_v_Name" class="col-sm-2 control-label ewLabel"><?php echo $main_Vendor->v_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Vendor->v_Name->CellAttributes() ?>>
<span id="el_main_Vendor_v_Name">
<input type="text" data-table="main_Vendor" data-field="x_v_Name" name="x_v_Name" id="x_v_Name" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($main_Vendor->v_Name->getPlaceHolder()) ?>" value="<?php echo $main_Vendor->v_Name->EditValue ?>"<?php echo $main_Vendor->v_Name->EditAttributes() ?>>
</span>
<?php echo $main_Vendor->v_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Vendor->v_TAX->Visible) { // v_TAX ?>
	<div id="r_v_TAX" class="form-group">
		<label id="elh_main_Vendor_v_TAX" for="x_v_TAX" class="col-sm-2 control-label ewLabel"><?php echo $main_Vendor->v_TAX->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Vendor->v_TAX->CellAttributes() ?>>
<span id="el_main_Vendor_v_TAX">
<input type="text" data-table="main_Vendor" data-field="x_v_TAX" name="x_v_TAX" id="x_v_TAX" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($main_Vendor->v_TAX->getPlaceHolder()) ?>" value="<?php echo $main_Vendor->v_TAX->EditValue ?>"<?php echo $main_Vendor->v_TAX->EditAttributes() ?>>
</span>
<?php echo $main_Vendor->v_TAX->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Vendor->v_Country->Visible) { // v_Country ?>
	<div id="r_v_Country" class="form-group">
		<label id="elh_main_Vendor_v_Country" for="x_v_Country" class="col-sm-2 control-label ewLabel"><?php echo $main_Vendor->v_Country->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Vendor->v_Country->CellAttributes() ?>>
<span id="el_main_Vendor_v_Country">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Vendor->v_Country->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_v_Country" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_Vendor->v_Country->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Vendor->v_Country->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Vendor" data-field="x_v_Country" name="x_v_Country" id="x_v_Country_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Vendor->v_Country->EditAttributes() ?>><?php echo $main_Vendor->v_Country->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Vendor->v_Country->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Vendor" data-field="x_v_Country" name="x_v_Country" id="x_v_Country_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Vendor->v_Country->CurrentValue) ?>" checked<?php echo $main_Vendor->v_Country->EditAttributes() ?>><?php echo $main_Vendor->v_Country->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_v_Country" class="ewTemplate"><input type="radio" data-table="main_Vendor" data-field="x_v_Country" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Vendor->v_Country->DisplayValueSeparator) ? json_encode($main_Vendor->v_Country->DisplayValueSeparator) : $main_Vendor->v_Country->DisplayValueSeparator) ?>" name="x_v_Country" id="x_v_Country" value="{value}"<?php echo $main_Vendor->v_Country->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `id`, `countryName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_countries`";
$sWhereWrk = "";
$main_Vendor->v_Country->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Vendor->v_Country->LookupFilters += array("f0" => "`id` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Vendor->Lookup_Selecting($main_Vendor->v_Country, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `countryName`";
if ($sSqlWrk <> "") $main_Vendor->v_Country->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_v_Country" id="s_x_v_Country" value="<?php echo $main_Vendor->v_Country->LookupFilterQuery() ?>">
</span>
<?php echo $main_Vendor->v_Country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Vendor->v_BillingAddress->Visible) { // v_BillingAddress ?>
	<div id="r_v_BillingAddress" class="form-group">
		<label id="elh_main_Vendor_v_BillingAddress" for="x_v_BillingAddress" class="col-sm-2 control-label ewLabel"><?php echo $main_Vendor->v_BillingAddress->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Vendor->v_BillingAddress->CellAttributes() ?>>
<span id="el_main_Vendor_v_BillingAddress">
<textarea data-table="main_Vendor" data-field="x_v_BillingAddress" name="x_v_BillingAddress" id="x_v_BillingAddress" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($main_Vendor->v_BillingAddress->getPlaceHolder()) ?>"<?php echo $main_Vendor->v_BillingAddress->EditAttributes() ?>><?php echo $main_Vendor->v_BillingAddress->EditValue ?></textarea>
</span>
<?php echo $main_Vendor->v_BillingAddress->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Vendor->v_Contact->Visible) { // v_Contact ?>
	<div id="r_v_Contact" class="form-group">
		<label id="elh_main_Vendor_v_Contact" for="x_v_Contact" class="col-sm-2 control-label ewLabel"><?php echo $main_Vendor->v_Contact->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Vendor->v_Contact->CellAttributes() ?>>
<span id="el_main_Vendor_v_Contact">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Vendor->v_Contact->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_v_Contact" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_Vendor->v_Contact->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Vendor->v_Contact->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Vendor" data-field="x_v_Contact" name="x_v_Contact" id="x_v_Contact_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Vendor->v_Contact->EditAttributes() ?>><?php echo $main_Vendor->v_Contact->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Vendor->v_Contact->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Vendor" data-field="x_v_Contact" name="x_v_Contact" id="x_v_Contact_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Vendor->v_Contact->CurrentValue) ?>" checked<?php echo $main_Vendor->v_Contact->EditAttributes() ?>><?php echo $main_Vendor->v_Contact->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_v_Contact" class="ewTemplate"><input type="radio" data-table="main_Vendor" data-field="x_v_Contact" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Vendor->v_Contact->DisplayValueSeparator) ? json_encode($main_Vendor->v_Contact->DisplayValueSeparator) : $main_Vendor->v_Contact->DisplayValueSeparator) ?>" name="x_v_Contact" id="x_v_Contact" value="{value}"<?php echo $main_Vendor->v_Contact->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
$sWhereWrk = "";
$main_Vendor->v_Contact->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Vendor->v_Contact->LookupFilters += array("f0" => "`u_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Vendor->Lookup_Selecting($main_Vendor->v_Contact, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Vendor->v_Contact->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_v_Contact" id="s_x_v_Contact" value="<?php echo $main_Vendor->v_Contact->LookupFilterQuery() ?>">
</span>
<?php echo $main_Vendor->v_Contact->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Vendor->v_Note->Visible) { // v_Note ?>
	<div id="r_v_Note" class="form-group">
		<label id="elh_main_Vendor_v_Note" class="col-sm-2 control-label ewLabel"><?php echo $main_Vendor->v_Note->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Vendor->v_Note->CellAttributes() ?>>
<span id="el_main_Vendor_v_Note">
<?php ew_AppendClass($main_Vendor->v_Note->EditAttrs["class"], "editor"); ?>
<textarea data-table="main_Vendor" data-field="x_v_Note" name="x_v_Note" id="x_v_Note" cols="35" rows="3" placeholder="<?php echo ew_HtmlEncode($main_Vendor->v_Note->getPlaceHolder()) ?>"<?php echo $main_Vendor->v_Note->EditAttributes() ?>><?php echo $main_Vendor->v_Note->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmain_Vendoradd", "x_v_Note", 35, 3, <?php echo ($main_Vendor->v_Note->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $main_Vendor->v_Note->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("main_PartNum", explode(",", $main_Vendor->getCurrentDetailTable())) && $main_PartNum->DetailAdd) {
?>
<?php if ($main_Vendor->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("main_PartNum", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "main_partnum_grid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $main_Vendor_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmain_Vendoradd.Init();
</script>
<?php
$main_Vendor_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$main_Vendor_add->Page_Terminate();
?>
