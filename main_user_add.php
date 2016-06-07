<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$main_User_add = NULL; // Initialize page object first

class cmain_User_add extends cmain_User {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_User';

	// Page object name
	var $PageObjName = 'main_User_add';

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

		// Table object (main_User)
		if (!isset($GLOBALS["main_User"]) || get_class($GLOBALS["main_User"]) == "cmain_User") {
			$GLOBALS["main_User"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_User"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'main_User', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("main_user_list.php"));
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
		global $EW_EXPORT, $main_User;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($main_User);
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
			if (@$_GET["u_ID"] != "") {
				$this->u_ID->setQueryStringValue($_GET["u_ID"]);
				$this->setKey("u_ID", $this->u_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("u_ID", ""); // Clear key
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
					$this->Page_Terminate("main_user_list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "main_user_list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "main_user_view.php")
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
		$this->u_BillName->CurrentValue = NULL;
		$this->u_BillName->OldValue = $this->u_BillName->CurrentValue;
		$this->u_LoginName->CurrentValue = NULL;
		$this->u_LoginName->OldValue = $this->u_LoginName->CurrentValue;
		$this->u_Email->CurrentValue = NULL;
		$this->u_Email->OldValue = $this->u_Email->CurrentValue;
		$this->u_Passwd->CurrentValue = NULL;
		$this->u_Passwd->OldValue = $this->u_Passwd->CurrentValue;
		$this->u_Address->CurrentValue = NULL;
		$this->u_Address->OldValue = $this->u_Address->CurrentValue;
		$this->u_Provice->CurrentValue = NULL;
		$this->u_Provice->OldValue = $this->u_Provice->CurrentValue;
		$this->u_City->CurrentValue = NULL;
		$this->u_City->OldValue = $this->u_City->CurrentValue;
		$this->u_Postcode->CurrentValue = NULL;
		$this->u_Postcode->OldValue = $this->u_Postcode->CurrentValue;
		$this->u_Mobile->CurrentValue = NULL;
		$this->u_Mobile->OldValue = $this->u_Mobile->CurrentValue;
		$this->u_PID->CurrentValue = NULL;
		$this->u_PID->OldValue = $this->u_PID->CurrentValue;
		$this->u_Status->CurrentValue = -1;
		$this->u_level->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->u_BillName->FldIsDetailKey) {
			$this->u_BillName->setFormValue($objForm->GetValue("x_u_BillName"));
		}
		if (!$this->u_LoginName->FldIsDetailKey) {
			$this->u_LoginName->setFormValue($objForm->GetValue("x_u_LoginName"));
		}
		if (!$this->u_Email->FldIsDetailKey) {
			$this->u_Email->setFormValue($objForm->GetValue("x_u_Email"));
		}
		if (!$this->u_Passwd->FldIsDetailKey) {
			$this->u_Passwd->setFormValue($objForm->GetValue("x_u_Passwd"));
		}
		if (!$this->u_Address->FldIsDetailKey) {
			$this->u_Address->setFormValue($objForm->GetValue("x_u_Address"));
		}
		if (!$this->u_Provice->FldIsDetailKey) {
			$this->u_Provice->setFormValue($objForm->GetValue("x_u_Provice"));
		}
		if (!$this->u_City->FldIsDetailKey) {
			$this->u_City->setFormValue($objForm->GetValue("x_u_City"));
		}
		if (!$this->u_Postcode->FldIsDetailKey) {
			$this->u_Postcode->setFormValue($objForm->GetValue("x_u_Postcode"));
		}
		if (!$this->u_Mobile->FldIsDetailKey) {
			$this->u_Mobile->setFormValue($objForm->GetValue("x_u_Mobile"));
		}
		if (!$this->u_PID->FldIsDetailKey) {
			$this->u_PID->setFormValue($objForm->GetValue("x_u_PID"));
		}
		if (!$this->u_Status->FldIsDetailKey) {
			$this->u_Status->setFormValue($objForm->GetValue("x_u_Status"));
		}
		if (!$this->u_level->FldIsDetailKey) {
			$this->u_level->setFormValue($objForm->GetValue("x_u_level"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->u_BillName->CurrentValue = $this->u_BillName->FormValue;
		$this->u_LoginName->CurrentValue = $this->u_LoginName->FormValue;
		$this->u_Email->CurrentValue = $this->u_Email->FormValue;
		$this->u_Passwd->CurrentValue = $this->u_Passwd->FormValue;
		$this->u_Address->CurrentValue = $this->u_Address->FormValue;
		$this->u_Provice->CurrentValue = $this->u_Provice->FormValue;
		$this->u_City->CurrentValue = $this->u_City->FormValue;
		$this->u_Postcode->CurrentValue = $this->u_Postcode->FormValue;
		$this->u_Mobile->CurrentValue = $this->u_Mobile->FormValue;
		$this->u_PID->CurrentValue = $this->u_PID->FormValue;
		$this->u_Status->CurrentValue = $this->u_Status->FormValue;
		$this->u_level->CurrentValue = $this->u_level->FormValue;
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
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->u_BillName->setDbValue($rs->fields('u_BillName'));
		$this->u_LoginName->setDbValue($rs->fields('u_LoginName'));
		$this->u_Email->setDbValue($rs->fields('u_Email'));
		$this->u_Passwd->setDbValue($rs->fields('u_Passwd'));
		$this->u_Address->setDbValue($rs->fields('u_Address'));
		$this->u_Provice->setDbValue($rs->fields('u_Provice'));
		$this->u_City->setDbValue($rs->fields('u_City'));
		$this->u_Postcode->setDbValue($rs->fields('u_Postcode'));
		$this->u_Mobile->setDbValue($rs->fields('u_Mobile'));
		$this->u_PID->setDbValue($rs->fields('u_PID'));
		$this->u_Status->setDbValue($rs->fields('u_Status'));
		$this->u_Created->setDbValue($rs->fields('u_Created'));
		$this->u_LastUpdate->setDbValue($rs->fields('u_LastUpdate'));
		$this->u_Profile->setDbValue($rs->fields('u_Profile'));
		$this->u_level->setDbValue($rs->fields('u_level'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->u_ID->DbValue = $row['u_ID'];
		$this->u_BillName->DbValue = $row['u_BillName'];
		$this->u_LoginName->DbValue = $row['u_LoginName'];
		$this->u_Email->DbValue = $row['u_Email'];
		$this->u_Passwd->DbValue = $row['u_Passwd'];
		$this->u_Address->DbValue = $row['u_Address'];
		$this->u_Provice->DbValue = $row['u_Provice'];
		$this->u_City->DbValue = $row['u_City'];
		$this->u_Postcode->DbValue = $row['u_Postcode'];
		$this->u_Mobile->DbValue = $row['u_Mobile'];
		$this->u_PID->DbValue = $row['u_PID'];
		$this->u_Status->DbValue = $row['u_Status'];
		$this->u_Created->DbValue = $row['u_Created'];
		$this->u_LastUpdate->DbValue = $row['u_LastUpdate'];
		$this->u_Profile->DbValue = $row['u_Profile'];
		$this->u_level->DbValue = $row['u_level'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("u_ID")) <> "")
			$this->u_ID->CurrentValue = $this->getKey("u_ID"); // u_ID
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
		// u_ID
		// u_BillName
		// u_LoginName
		// u_Email
		// u_Passwd
		// u_Address
		// u_Provice
		// u_City
		// u_Postcode
		// u_Mobile
		// u_PID
		// u_Status
		// u_Created
		// u_LastUpdate
		// u_Profile
		// u_level

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// u_BillName
		$this->u_BillName->ViewValue = $this->u_BillName->CurrentValue;
		$this->u_BillName->ViewCustomAttributes = "";

		// u_LoginName
		$this->u_LoginName->ViewValue = $this->u_LoginName->CurrentValue;
		$this->u_LoginName->ViewCustomAttributes = "";

		// u_Email
		$this->u_Email->ViewValue = $this->u_Email->CurrentValue;
		$this->u_Email->ViewCustomAttributes = "";

		// u_Passwd
		$this->u_Passwd->ViewValue = $Language->Phrase("PasswordMask");
		$this->u_Passwd->ViewCustomAttributes = "";

		// u_Address
		$this->u_Address->ViewValue = $this->u_Address->CurrentValue;
		$this->u_Address->ViewCustomAttributes = "";

		// u_Provice
		if (strval($this->u_Provice->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->u_Provice->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_Provice, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_Provice->ViewValue = $this->u_Provice->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_Provice->ViewValue = $this->u_Provice->CurrentValue;
			}
		} else {
			$this->u_Provice->ViewValue = NULL;
		}
		$this->u_Provice->ViewCustomAttributes = "";

		// u_City
		if (strval($this->u_City->CurrentValue) <> "") {
			$sFilterWrk = "`AMPHUR_ID`" . ew_SearchString("=", $this->u_City->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_amphur`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_City, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_City->ViewValue = $this->u_City->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_City->ViewValue = $this->u_City->CurrentValue;
			}
		} else {
			$this->u_City->ViewValue = NULL;
		}
		$this->u_City->ViewCustomAttributes = "";

		// u_Postcode
		$this->u_Postcode->ViewValue = $this->u_Postcode->CurrentValue;
		$this->u_Postcode->ViewCustomAttributes = "";

		// u_Mobile
		$this->u_Mobile->ViewValue = $this->u_Mobile->CurrentValue;
		$this->u_Mobile->ViewCustomAttributes = "";

		// u_PID
		$this->u_PID->ViewValue = $this->u_PID->CurrentValue;
		$this->u_PID->ViewCustomAttributes = "";

		// u_Status
		if (strval($this->u_Status->CurrentValue) <> "") {
			$this->u_Status->ViewValue = $this->u_Status->OptionCaption($this->u_Status->CurrentValue);
		} else {
			$this->u_Status->ViewValue = NULL;
		}
		$this->u_Status->ViewCustomAttributes = "";

		// u_level
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->u_level->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->u_level->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->u_level, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->u_level->ViewValue = $this->u_level->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->u_level->ViewValue = $this->u_level->CurrentValue;
			}
		} else {
			$this->u_level->ViewValue = NULL;
		}
		} else {
			$this->u_level->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->u_level->ViewCustomAttributes = "";

			// u_BillName
			$this->u_BillName->LinkCustomAttributes = "";
			$this->u_BillName->HrefValue = "";
			$this->u_BillName->TooltipValue = "";

			// u_LoginName
			$this->u_LoginName->LinkCustomAttributes = "";
			$this->u_LoginName->HrefValue = "";
			$this->u_LoginName->TooltipValue = "";

			// u_Email
			$this->u_Email->LinkCustomAttributes = "";
			if (!ew_Empty($this->u_Email->CurrentValue)) {
				$this->u_Email->HrefValue = "mailto:" . $this->u_Email->CurrentValue; // Add prefix/suffix
				$this->u_Email->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->u_Email->HrefValue = ew_ConvertFullUrl($this->u_Email->HrefValue);
			} else {
				$this->u_Email->HrefValue = "";
			}
			$this->u_Email->TooltipValue = "";

			// u_Passwd
			$this->u_Passwd->LinkCustomAttributes = "";
			$this->u_Passwd->HrefValue = "";
			$this->u_Passwd->TooltipValue = "";

			// u_Address
			$this->u_Address->LinkCustomAttributes = "";
			$this->u_Address->HrefValue = "";
			$this->u_Address->TooltipValue = "";

			// u_Provice
			$this->u_Provice->LinkCustomAttributes = "";
			$this->u_Provice->HrefValue = "";
			$this->u_Provice->TooltipValue = "";

			// u_City
			$this->u_City->LinkCustomAttributes = "";
			$this->u_City->HrefValue = "";
			$this->u_City->TooltipValue = "";

			// u_Postcode
			$this->u_Postcode->LinkCustomAttributes = "";
			$this->u_Postcode->HrefValue = "";
			$this->u_Postcode->TooltipValue = "";

			// u_Mobile
			$this->u_Mobile->LinkCustomAttributes = "";
			if (!ew_Empty($this->u_Mobile->CurrentValue)) {
				$this->u_Mobile->HrefValue = "tel:" . $this->u_Mobile->CurrentValue; // Add prefix/suffix
				$this->u_Mobile->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->u_Mobile->HrefValue = ew_ConvertFullUrl($this->u_Mobile->HrefValue);
			} else {
				$this->u_Mobile->HrefValue = "";
			}
			$this->u_Mobile->TooltipValue = "";

			// u_PID
			$this->u_PID->LinkCustomAttributes = "";
			$this->u_PID->HrefValue = "";
			$this->u_PID->TooltipValue = "";

			// u_Status
			$this->u_Status->LinkCustomAttributes = "";
			$this->u_Status->HrefValue = "";
			$this->u_Status->TooltipValue = "";

			// u_level
			$this->u_level->LinkCustomAttributes = "";
			$this->u_level->HrefValue = "";
			$this->u_level->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// u_BillName
			$this->u_BillName->EditAttrs["class"] = "form-control";
			$this->u_BillName->EditCustomAttributes = "";
			$this->u_BillName->EditValue = ew_HtmlEncode($this->u_BillName->CurrentValue);
			$this->u_BillName->PlaceHolder = ew_RemoveHtml($this->u_BillName->FldCaption());

			// u_LoginName
			$this->u_LoginName->EditAttrs["class"] = "form-control";
			$this->u_LoginName->EditCustomAttributes = "";
			$this->u_LoginName->EditValue = ew_HtmlEncode($this->u_LoginName->CurrentValue);
			$this->u_LoginName->PlaceHolder = ew_RemoveHtml($this->u_LoginName->FldCaption());

			// u_Email
			$this->u_Email->EditAttrs["class"] = "form-control";
			$this->u_Email->EditCustomAttributes = "";
			$this->u_Email->EditValue = ew_HtmlEncode($this->u_Email->CurrentValue);
			$this->u_Email->PlaceHolder = ew_RemoveHtml($this->u_Email->FldCaption());

			// u_Passwd
			$this->u_Passwd->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->u_Passwd->EditCustomAttributes = "";
			$this->u_Passwd->EditValue = ew_HtmlEncode($this->u_Passwd->CurrentValue);
			$this->u_Passwd->PlaceHolder = ew_RemoveHtml($this->u_Passwd->FldCaption());

			// u_Address
			$this->u_Address->EditAttrs["class"] = "form-control";
			$this->u_Address->EditCustomAttributes = "";
			$this->u_Address->EditValue = ew_HtmlEncode($this->u_Address->CurrentValue);
			$this->u_Address->PlaceHolder = ew_RemoveHtml($this->u_Address->FldCaption());

			// u_Provice
			$this->u_Provice->EditCustomAttributes = "";
			if (trim(strval($this->u_Provice->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->u_Provice->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_province`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->u_Provice, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->u_Provice->ViewValue = $this->u_Provice->DisplayValue($arwrk);
			} else {
				$this->u_Provice->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->u_Provice->EditValue = $arwrk;

			// u_City
			$this->u_City->EditCustomAttributes = "";
			if (trim(strval($this->u_City->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`AMPHUR_ID`" . ew_SearchString("=", $this->u_City->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `PROVINCE_ID` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_amphur`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->u_City, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->u_City->ViewValue = $this->u_City->DisplayValue($arwrk);
			} else {
				$this->u_City->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->u_City->EditValue = $arwrk;

			// u_Postcode
			$this->u_Postcode->EditAttrs["class"] = "form-control";
			$this->u_Postcode->EditCustomAttributes = "";
			$this->u_Postcode->EditValue = ew_HtmlEncode($this->u_Postcode->CurrentValue);
			$this->u_Postcode->PlaceHolder = ew_RemoveHtml($this->u_Postcode->FldCaption());

			// u_Mobile
			$this->u_Mobile->EditAttrs["class"] = "form-control";
			$this->u_Mobile->EditCustomAttributes = "";
			$this->u_Mobile->EditValue = ew_HtmlEncode($this->u_Mobile->CurrentValue);
			$this->u_Mobile->PlaceHolder = ew_RemoveHtml($this->u_Mobile->FldCaption());

			// u_PID
			$this->u_PID->EditAttrs["class"] = "form-control";
			$this->u_PID->EditCustomAttributes = "";
			$this->u_PID->EditValue = ew_HtmlEncode($this->u_PID->CurrentValue);
			$this->u_PID->PlaceHolder = ew_RemoveHtml($this->u_PID->FldCaption());

			// u_Status
			$this->u_Status->EditAttrs["class"] = "form-control";
			$this->u_Status->EditCustomAttributes = "";
			$this->u_Status->EditValue = $this->u_Status->Options(TRUE);

			// u_level
			$this->u_level->EditAttrs["class"] = "form-control";
			$this->u_level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->u_level->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->u_level->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->u_level->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->u_level, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->u_level->EditValue = $arwrk;
			}

			// Add refer script
			// u_BillName

			$this->u_BillName->LinkCustomAttributes = "";
			$this->u_BillName->HrefValue = "";

			// u_LoginName
			$this->u_LoginName->LinkCustomAttributes = "";
			$this->u_LoginName->HrefValue = "";

			// u_Email
			$this->u_Email->LinkCustomAttributes = "";
			if (!ew_Empty($this->u_Email->CurrentValue)) {
				$this->u_Email->HrefValue = "mailto:" . $this->u_Email->CurrentValue; // Add prefix/suffix
				$this->u_Email->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->u_Email->HrefValue = ew_ConvertFullUrl($this->u_Email->HrefValue);
			} else {
				$this->u_Email->HrefValue = "";
			}

			// u_Passwd
			$this->u_Passwd->LinkCustomAttributes = "";
			$this->u_Passwd->HrefValue = "";

			// u_Address
			$this->u_Address->LinkCustomAttributes = "";
			$this->u_Address->HrefValue = "";

			// u_Provice
			$this->u_Provice->LinkCustomAttributes = "";
			$this->u_Provice->HrefValue = "";

			// u_City
			$this->u_City->LinkCustomAttributes = "";
			$this->u_City->HrefValue = "";

			// u_Postcode
			$this->u_Postcode->LinkCustomAttributes = "";
			$this->u_Postcode->HrefValue = "";

			// u_Mobile
			$this->u_Mobile->LinkCustomAttributes = "";
			if (!ew_Empty($this->u_Mobile->CurrentValue)) {
				$this->u_Mobile->HrefValue = "tel:" . $this->u_Mobile->CurrentValue; // Add prefix/suffix
				$this->u_Mobile->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->u_Mobile->HrefValue = ew_ConvertFullUrl($this->u_Mobile->HrefValue);
			} else {
				$this->u_Mobile->HrefValue = "";
			}

			// u_PID
			$this->u_PID->LinkCustomAttributes = "";
			$this->u_PID->HrefValue = "";

			// u_Status
			$this->u_Status->LinkCustomAttributes = "";
			$this->u_Status->HrefValue = "";

			// u_level
			$this->u_level->LinkCustomAttributes = "";
			$this->u_level->HrefValue = "";
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
		if (!$this->u_LoginName->FldIsDetailKey && !is_null($this->u_LoginName->FormValue) && $this->u_LoginName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_LoginName->FldCaption(), $this->u_LoginName->ReqErrMsg));
		}
		if (!$this->u_Email->FldIsDetailKey && !is_null($this->u_Email->FormValue) && $this->u_Email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_Email->FldCaption(), $this->u_Email->ReqErrMsg));
		}
		if (!$this->u_Passwd->FldIsDetailKey && !is_null($this->u_Passwd->FormValue) && $this->u_Passwd->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_Passwd->FldCaption(), $this->u_Passwd->ReqErrMsg));
		}
		if (!$this->u_Status->FldIsDetailKey && !is_null($this->u_Status->FormValue) && $this->u_Status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_Status->FldCaption(), $this->u_Status->ReqErrMsg));
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

		// u_BillName
		$this->u_BillName->SetDbValueDef($rsnew, $this->u_BillName->CurrentValue, NULL, FALSE);

		// u_LoginName
		$this->u_LoginName->SetDbValueDef($rsnew, $this->u_LoginName->CurrentValue, "", FALSE);

		// u_Email
		$this->u_Email->SetDbValueDef($rsnew, $this->u_Email->CurrentValue, "", FALSE);

		// u_Passwd
		$this->u_Passwd->SetDbValueDef($rsnew, $this->u_Passwd->CurrentValue, "", FALSE);

		// u_Address
		$this->u_Address->SetDbValueDef($rsnew, $this->u_Address->CurrentValue, NULL, FALSE);

		// u_Provice
		$this->u_Provice->SetDbValueDef($rsnew, $this->u_Provice->CurrentValue, NULL, FALSE);

		// u_City
		$this->u_City->SetDbValueDef($rsnew, $this->u_City->CurrentValue, NULL, FALSE);

		// u_Postcode
		$this->u_Postcode->SetDbValueDef($rsnew, $this->u_Postcode->CurrentValue, NULL, FALSE);

		// u_Mobile
		$this->u_Mobile->SetDbValueDef($rsnew, $this->u_Mobile->CurrentValue, NULL, FALSE);

		// u_PID
		$this->u_PID->SetDbValueDef($rsnew, $this->u_PID->CurrentValue, NULL, FALSE);

		// u_Status
		$this->u_Status->SetDbValueDef($rsnew, $this->u_Status->CurrentValue, 0, strval($this->u_Status->CurrentValue) == "");

		// u_level
		if ($Security->CanAdmin()) { // System admin
		$this->u_level->SetDbValueDef($rsnew, $this->u_level->CurrentValue, NULL, strval($this->u_level->CurrentValue) == "");
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->u_ID->setDbValue($conn->Insert_ID());
				$rsnew['u_ID'] = $this->u_ID->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("main_user_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($main_User_add)) $main_User_add = new cmain_User_add();

// Page init
$main_User_add->Page_Init();

// Page main
$main_User_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_User_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmain_Useradd = new ew_Form("fmain_Useradd", "add");

// Validate form
fmain_Useradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_u_LoginName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_User->u_LoginName->FldCaption(), $main_User->u_LoginName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_Email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_User->u_Email->FldCaption(), $main_User->u_Email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_Passwd");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_User->u_Passwd->FldCaption(), $main_User->u_Passwd->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_Passwd");
			if (elm && $(elm).hasClass("ewPasswordStrength") && !$(elm).data("validated"))
				return this.OnError(elm, ewLanguage.Phrase("PasswordTooSimple"));
			elm = this.GetElements("x" + infix + "_u_Status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_User->u_Status->FldCaption(), $main_User->u_Status->ReqErrMsg)) ?>");

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
fmain_Useradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Useradd.ValidateRequired = true;
<?php } else { ?>
fmain_Useradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Useradd.Lists["x_u_Provice"] = {"LinkField":"x_PROVINCE_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_PROVINCE_NAME","","",""],"ParentFields":[],"ChildFields":["x_u_City"],"FilterFields":[],"Options":[],"Template":""};
fmain_Useradd.Lists["x_u_City"] = {"LinkField":"x_AMPHUR_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_AMPHUR_NAME","","",""],"ParentFields":["x_u_Provice"],"ChildFields":[],"FilterFields":["x_PROVINCE_ID"],"Options":[],"Template":""};
fmain_Useradd.Lists["x_u_Status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Useradd.Lists["x_u_Status"].Options = <?php echo json_encode($main_User->u_Status->Options()) ?>;
fmain_Useradd.Lists["x_u_level"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $main_User_add->ShowPageHeader(); ?>
<?php
$main_User_add->ShowMessage();
?>
<form name="fmain_Useradd" id="fmain_Useradd" class="<?php echo $main_User_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_User_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_User_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_User">
<input type="hidden" name="a_add" id="a_add" value="A">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($main_User->u_BillName->Visible) { // u_BillName ?>
	<div id="r_u_BillName" class="form-group">
		<label id="elh_main_User_u_BillName" for="x_u_BillName" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_BillName->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_BillName->CellAttributes() ?>>
<span id="el_main_User_u_BillName">
<input type="text" data-table="main_User" data-field="x_u_BillName" name="x_u_BillName" id="x_u_BillName" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($main_User->u_BillName->getPlaceHolder()) ?>" value="<?php echo $main_User->u_BillName->EditValue ?>"<?php echo $main_User->u_BillName->EditAttributes() ?>>
</span>
<?php echo $main_User->u_BillName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_LoginName->Visible) { // u_LoginName ?>
	<div id="r_u_LoginName" class="form-group">
		<label id="elh_main_User_u_LoginName" for="x_u_LoginName" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_LoginName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_LoginName->CellAttributes() ?>>
<span id="el_main_User_u_LoginName">
<input type="text" data-table="main_User" data-field="x_u_LoginName" name="x_u_LoginName" id="x_u_LoginName" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($main_User->u_LoginName->getPlaceHolder()) ?>" value="<?php echo $main_User->u_LoginName->EditValue ?>"<?php echo $main_User->u_LoginName->EditAttributes() ?>>
</span>
<?php echo $main_User->u_LoginName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Email->Visible) { // u_Email ?>
	<div id="r_u_Email" class="form-group">
		<label id="elh_main_User_u_Email" for="x_u_Email" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Email->CellAttributes() ?>>
<span id="el_main_User_u_Email">
<input type="text" data-table="main_User" data-field="x_u_Email" name="x_u_Email" id="x_u_Email" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($main_User->u_Email->getPlaceHolder()) ?>" value="<?php echo $main_User->u_Email->EditValue ?>"<?php echo $main_User->u_Email->EditAttributes() ?>>
</span>
<?php echo $main_User->u_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Passwd->Visible) { // u_Passwd ?>
	<div id="r_u_Passwd" class="form-group">
		<label id="elh_main_User_u_Passwd" for="x_u_Passwd" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Passwd->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Passwd->CellAttributes() ?>>
<span id="el_main_User_u_Passwd">
<div class="input-group" id="ig_u_Passwd">
<input type="password" data-password-strength="pst_u_Passwd" data-password-generated="pgt_u_Passwd" data-table="main_User" data-field="x_u_Passwd" name="x_u_Passwd" id="x_u_Passwd" size="30" maxlength="128" placeholder="<?php echo ew_HtmlEncode($main_User->u_Passwd->getPlaceHolder()) ?>"<?php echo $main_User->u_Passwd->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_u_Passwd" data-password-confirm="c_u_Passwd" data-password-strength="pst_u_Passwd" data-password-generated="pgt_u_Passwd"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_u_Passwd" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_u_Passwd" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $main_User->u_Passwd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Address->Visible) { // u_Address ?>
	<div id="r_u_Address" class="form-group">
		<label id="elh_main_User_u_Address" for="x_u_Address" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Address->CellAttributes() ?>>
<span id="el_main_User_u_Address">
<input type="text" data-table="main_User" data-field="x_u_Address" name="x_u_Address" id="x_u_Address" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($main_User->u_Address->getPlaceHolder()) ?>" value="<?php echo $main_User->u_Address->EditValue ?>"<?php echo $main_User->u_Address->EditAttributes() ?>>
</span>
<?php echo $main_User->u_Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Provice->Visible) { // u_Provice ?>
	<div id="r_u_Provice" class="form-group">
		<label id="elh_main_User_u_Provice" for="x_u_Provice" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Provice->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Provice->CellAttributes() ?>>
<span id="el_main_User_u_Provice">
<?php $main_User->u_Provice->EditAttrs["onclick"] = "ew_UpdateOpt.call(this); " . @$main_User->u_Provice->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_User->u_Provice->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_u_Provice" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_User->u_Provice->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_User->u_Provice->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_User" data-field="x_u_Provice" name="x_u_Provice" id="x_u_Provice_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_User->u_Provice->EditAttributes() ?>><?php echo $main_User->u_Provice->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_User->u_Provice->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_User" data-field="x_u_Provice" name="x_u_Provice" id="x_u_Provice_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_User->u_Provice->CurrentValue) ?>" checked<?php echo $main_User->u_Provice->EditAttributes() ?>><?php echo $main_User->u_Provice->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_u_Provice" class="ewTemplate"><input type="radio" data-table="main_User" data-field="x_u_Provice" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_User->u_Provice->DisplayValueSeparator) ? json_encode($main_User->u_Provice->DisplayValueSeparator) : $main_User->u_Provice->DisplayValueSeparator) ?>" name="x_u_Provice" id="x_u_Provice" value="{value}"<?php echo $main_User->u_Provice->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
$sWhereWrk = "";
$main_User->u_Provice->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_User->u_Provice->LookupFilters += array("f0" => "`PROVINCE_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_User->Lookup_Selecting($main_User->u_Provice, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
if ($sSqlWrk <> "") $main_User->u_Provice->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_u_Provice" id="s_x_u_Provice" value="<?php echo $main_User->u_Provice->LookupFilterQuery() ?>">
</span>
<?php echo $main_User->u_Provice->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_City->Visible) { // u_City ?>
	<div id="r_u_City" class="form-group">
		<label id="elh_main_User_u_City" for="x_u_City" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_City->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_City->CellAttributes() ?>>
<span id="el_main_User_u_City">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_User->u_City->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_u_City" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_User->u_City->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_User->u_City->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_User" data-field="x_u_City" name="x_u_City" id="x_u_City_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_User->u_City->EditAttributes() ?>><?php echo $main_User->u_City->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_User->u_City->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_User" data-field="x_u_City" name="x_u_City" id="x_u_City_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_User->u_City->CurrentValue) ?>" checked<?php echo $main_User->u_City->EditAttributes() ?>><?php echo $main_User->u_City->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_u_City" class="ewTemplate"><input type="radio" data-table="main_User" data-field="x_u_City" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_User->u_City->DisplayValueSeparator) ? json_encode($main_User->u_City->DisplayValueSeparator) : $main_User->u_City->DisplayValueSeparator) ?>" name="x_u_City" id="x_u_City" value="{value}"<?php echo $main_User->u_City->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_amphur`";
$sWhereWrk = "{filter}";
$main_User->u_City->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_User->u_City->LookupFilters += array("f0" => "`AMPHUR_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$main_User->u_City->LookupFilters += array("f1" => "`PROVINCE_ID` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$main_User->Lookup_Selecting($main_User->u_City, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
if ($sSqlWrk <> "") $main_User->u_City->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_u_City" id="s_x_u_City" value="<?php echo $main_User->u_City->LookupFilterQuery() ?>">
</span>
<?php echo $main_User->u_City->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Postcode->Visible) { // u_Postcode ?>
	<div id="r_u_Postcode" class="form-group">
		<label id="elh_main_User_u_Postcode" for="x_u_Postcode" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Postcode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Postcode->CellAttributes() ?>>
<span id="el_main_User_u_Postcode">
<input type="text" data-table="main_User" data-field="x_u_Postcode" name="x_u_Postcode" id="x_u_Postcode" size="30" maxlength="13" placeholder="<?php echo ew_HtmlEncode($main_User->u_Postcode->getPlaceHolder()) ?>" value="<?php echo $main_User->u_Postcode->EditValue ?>"<?php echo $main_User->u_Postcode->EditAttributes() ?>>
</span>
<?php echo $main_User->u_Postcode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Mobile->Visible) { // u_Mobile ?>
	<div id="r_u_Mobile" class="form-group">
		<label id="elh_main_User_u_Mobile" for="x_u_Mobile" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Mobile->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Mobile->CellAttributes() ?>>
<span id="el_main_User_u_Mobile">
<input type="text" data-table="main_User" data-field="x_u_Mobile" name="x_u_Mobile" id="x_u_Mobile" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($main_User->u_Mobile->getPlaceHolder()) ?>" value="<?php echo $main_User->u_Mobile->EditValue ?>"<?php echo $main_User->u_Mobile->EditAttributes() ?>>
</span>
<?php echo $main_User->u_Mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_PID->Visible) { // u_PID ?>
	<div id="r_u_PID" class="form-group">
		<label id="elh_main_User_u_PID" for="x_u_PID" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_PID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_PID->CellAttributes() ?>>
<span id="el_main_User_u_PID">
<input type="text" data-table="main_User" data-field="x_u_PID" name="x_u_PID" id="x_u_PID" size="30" maxlength="13" placeholder="<?php echo ew_HtmlEncode($main_User->u_PID->getPlaceHolder()) ?>" value="<?php echo $main_User->u_PID->EditValue ?>"<?php echo $main_User->u_PID->EditAttributes() ?>>
</span>
<?php echo $main_User->u_PID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_Status->Visible) { // u_Status ?>
	<div id="r_u_Status" class="form-group">
		<label id="elh_main_User_u_Status" for="x_u_Status" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_Status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_Status->CellAttributes() ?>>
<span id="el_main_User_u_Status">
<select data-table="main_User" data-field="x_u_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_User->u_Status->DisplayValueSeparator) ? json_encode($main_User->u_Status->DisplayValueSeparator) : $main_User->u_Status->DisplayValueSeparator) ?>" id="x_u_Status" name="x_u_Status"<?php echo $main_User->u_Status->EditAttributes() ?>>
<?php
if (is_array($main_User->u_Status->EditValue)) {
	$arwrk = $main_User->u_Status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($main_User->u_Status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $main_User->u_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($main_User->u_Status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($main_User->u_Status->CurrentValue) ?>" selected><?php echo $main_User->u_Status->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $main_User->u_Status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_User->u_level->Visible) { // u_level ?>
	<div id="r_u_level" class="form-group">
		<label id="elh_main_User_u_level" for="x_u_level" class="col-sm-2 control-label ewLabel"><?php echo $main_User->u_level->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_User->u_level->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_main_User_u_level">
<p class="form-control-static"><?php echo $main_User->u_level->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_main_User_u_level">
<select data-table="main_User" data-field="x_u_level" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_User->u_level->DisplayValueSeparator) ? json_encode($main_User->u_level->DisplayValueSeparator) : $main_User->u_level->DisplayValueSeparator) ?>" id="x_u_level" name="x_u_level"<?php echo $main_User->u_level->EditAttributes() ?>>
<?php
if (is_array($main_User->u_level->EditValue)) {
	$arwrk = $main_User->u_level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($main_User->u_level->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $main_User->u_level->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($main_User->u_level->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($main_User->u_level->CurrentValue) ?>" selected><?php echo $main_User->u_level->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
$sWhereWrk = "";
$main_User->u_level->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_User->u_level->LookupFilters += array("f0" => "`userlevelid` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_User->Lookup_Selecting($main_User->u_level, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_User->u_level->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_u_level" id="s_x_u_level" value="<?php echo $main_User->u_level->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $main_User->u_level->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $main_User_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmain_Useradd.Init();
</script>
<?php
$main_User_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$main_User_add->Page_Terminate();
?>
