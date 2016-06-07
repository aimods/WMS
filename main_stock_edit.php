<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "main_stock_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$main_Stock_edit = NULL; // Initialize page object first

class cmain_Stock_edit extends cmain_Stock {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_Stock';

	// Page object name
	var $PageObjName = 'main_Stock_edit';

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

		// Table object (main_Stock)
		if (!isset($GLOBALS["main_Stock"]) || get_class($GLOBALS["main_Stock"]) == "cmain_Stock") {
			$GLOBALS["main_Stock"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_Stock"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'main_Stock', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("main_stock_list.php"));
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
		$this->s_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $main_Stock;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($main_Stock);
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
		if (@$_GET["s_ID"] <> "") {
			$this->s_ID->setQueryStringValue($_GET["s_ID"]);
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
		if ($this->s_ID->CurrentValue == "")
			$this->Page_Terminate("main_stock_list.php"); // Invalid key, return to list

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
					$this->Page_Terminate("main_stock_list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "main_stock_list.php")
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
		if (!$this->s_ID->FldIsDetailKey)
			$this->s_ID->setFormValue($objForm->GetValue("x_s_ID"));
		if (!$this->s_LOC->FldIsDetailKey) {
			$this->s_LOC->setFormValue($objForm->GetValue("x_s_LOC"));
		}
		if (!$this->s_Type->FldIsDetailKey) {
			$this->s_Type->setFormValue($objForm->GetValue("x_s_Type"));
		}
		if (!$this->s_Address->FldIsDetailKey) {
			$this->s_Address->setFormValue($objForm->GetValue("x_s_Address"));
		}
		if (!$this->s_Province->FldIsDetailKey) {
			$this->s_Province->setFormValue($objForm->GetValue("x_s_Province"));
		}
		if (!$this->s_City->FldIsDetailKey) {
			$this->s_City->setFormValue($objForm->GetValue("x_s_City"));
		}
		if (!$this->s_PostCode->FldIsDetailKey) {
			$this->s_PostCode->setFormValue($objForm->GetValue("x_s_PostCode"));
		}
		if (!$this->u_ID->FldIsDetailKey) {
			$this->u_ID->setFormValue($objForm->GetValue("x_u_ID"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->s_ID->CurrentValue = $this->s_ID->FormValue;
		$this->s_LOC->CurrentValue = $this->s_LOC->FormValue;
		$this->s_Type->CurrentValue = $this->s_Type->FormValue;
		$this->s_Address->CurrentValue = $this->s_Address->FormValue;
		$this->s_Province->CurrentValue = $this->s_Province->FormValue;
		$this->s_City->CurrentValue = $this->s_City->FormValue;
		$this->s_PostCode->CurrentValue = $this->s_PostCode->FormValue;
		$this->u_ID->CurrentValue = $this->u_ID->FormValue;
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
		$this->s_ID->setDbValue($rs->fields('s_ID'));
		$this->s_LOC->setDbValue($rs->fields('s_LOC'));
		$this->s_Type->setDbValue($rs->fields('s_Type'));
		$this->s_Address->setDbValue($rs->fields('s_Address'));
		$this->s_Province->setDbValue($rs->fields('s_Province'));
		$this->s_City->setDbValue($rs->fields('s_City'));
		$this->s_PostCode->setDbValue($rs->fields('s_PostCode'));
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->s_Created->setDbValue($rs->fields('s_Created'));
		$this->s_Update->setDbValue($rs->fields('s_Update'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->s_ID->DbValue = $row['s_ID'];
		$this->s_LOC->DbValue = $row['s_LOC'];
		$this->s_Type->DbValue = $row['s_Type'];
		$this->s_Address->DbValue = $row['s_Address'];
		$this->s_Province->DbValue = $row['s_Province'];
		$this->s_City->DbValue = $row['s_City'];
		$this->s_PostCode->DbValue = $row['s_PostCode'];
		$this->u_ID->DbValue = $row['u_ID'];
		$this->s_Created->DbValue = $row['s_Created'];
		$this->s_Update->DbValue = $row['s_Update'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// s_ID
		// s_LOC
		// s_Type
		// s_Address
		// s_Province
		// s_City
		// s_PostCode
		// u_ID
		// s_Created
		// s_Update

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// s_ID
		$this->s_ID->ViewValue = $this->s_ID->CurrentValue;
		$this->s_ID->ViewCustomAttributes = "";

		// s_LOC
		$this->s_LOC->ViewValue = $this->s_LOC->CurrentValue;
		$this->s_LOC->ViewCustomAttributes = "";

		// s_Type
		if (strval($this->s_Type->CurrentValue) <> "") {
			$sFilterWrk = "`wh_ID`" . ew_SearchString("=", $this->s_Type->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `wh_ID`, `wh_Type` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_WHType`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_Type, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_Type->ViewValue = $this->s_Type->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_Type->ViewValue = $this->s_Type->CurrentValue;
			}
		} else {
			$this->s_Type->ViewValue = NULL;
		}
		$this->s_Type->ViewCustomAttributes = "";

		// s_Address
		$this->s_Address->ViewValue = $this->s_Address->CurrentValue;
		$this->s_Address->ViewCustomAttributes = "";

		// s_Province
		if (strval($this->s_Province->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->s_Province->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_Province, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_Province->ViewValue = $this->s_Province->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_Province->ViewValue = $this->s_Province->CurrentValue;
			}
		} else {
			$this->s_Province->ViewValue = NULL;
		}
		$this->s_Province->ViewCustomAttributes = "";

		// s_City
		if (strval($this->s_City->CurrentValue) <> "") {
			$sFilterWrk = "`AMPHUR_ID`" . ew_SearchString("=", $this->s_City->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_amphur`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_City, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_City->ViewValue = $this->s_City->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_City->ViewValue = $this->s_City->CurrentValue;
			}
		} else {
			$this->s_City->ViewValue = NULL;
		}
		$this->s_City->ViewCustomAttributes = "";

		// s_PostCode
		$this->s_PostCode->ViewValue = $this->s_PostCode->CurrentValue;
		$this->s_PostCode->ViewCustomAttributes = "";

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

		// s_Created
		$this->s_Created->ViewValue = $this->s_Created->CurrentValue;
		$this->s_Created->ViewValue = ew_FormatDateTime($this->s_Created->ViewValue, 7);
		$this->s_Created->ViewCustomAttributes = "";

		// s_Update
		$this->s_Update->ViewValue = $this->s_Update->CurrentValue;
		$this->s_Update->ViewValue = ew_FormatDateTime($this->s_Update->ViewValue, 7);
		$this->s_Update->ViewCustomAttributes = "";

			// s_ID
			$this->s_ID->LinkCustomAttributes = "";
			$this->s_ID->HrefValue = "";
			$this->s_ID->TooltipValue = "";

			// s_LOC
			$this->s_LOC->LinkCustomAttributes = "";
			$this->s_LOC->HrefValue = "";
			$this->s_LOC->TooltipValue = "";

			// s_Type
			$this->s_Type->LinkCustomAttributes = "";
			$this->s_Type->HrefValue = "";
			$this->s_Type->TooltipValue = "";

			// s_Address
			$this->s_Address->LinkCustomAttributes = "";
			$this->s_Address->HrefValue = "";
			$this->s_Address->TooltipValue = "";

			// s_Province
			$this->s_Province->LinkCustomAttributes = "";
			$this->s_Province->HrefValue = "";
			$this->s_Province->TooltipValue = "";

			// s_City
			$this->s_City->LinkCustomAttributes = "";
			$this->s_City->HrefValue = "";
			$this->s_City->TooltipValue = "";

			// s_PostCode
			$this->s_PostCode->LinkCustomAttributes = "";
			$this->s_PostCode->HrefValue = "";
			$this->s_PostCode->TooltipValue = "";

			// u_ID
			$this->u_ID->LinkCustomAttributes = "";
			$this->u_ID->HrefValue = "";
			$this->u_ID->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// s_ID
			$this->s_ID->EditAttrs["class"] = "form-control";
			$this->s_ID->EditCustomAttributes = "";
			$this->s_ID->EditValue = $this->s_ID->CurrentValue;
			$this->s_ID->ViewCustomAttributes = "";

			// s_LOC
			$this->s_LOC->EditAttrs["class"] = "form-control";
			$this->s_LOC->EditCustomAttributes = "";
			$this->s_LOC->EditValue = $this->s_LOC->CurrentValue;
			$this->s_LOC->ViewCustomAttributes = "";

			// s_Type
			$this->s_Type->EditCustomAttributes = "";
			if (trim(strval($this->s_Type->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`wh_ID`" . ew_SearchString("=", $this->s_Type->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `wh_ID`, `wh_Type` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_WHType`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->s_Type, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->s_Type->ViewValue = $this->s_Type->DisplayValue($arwrk);
			} else {
				$this->s_Type->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->s_Type->EditValue = $arwrk;

			// s_Address
			$this->s_Address->EditAttrs["class"] = "form-control";
			$this->s_Address->EditCustomAttributes = "";
			$this->s_Address->EditValue = ew_HtmlEncode($this->s_Address->CurrentValue);
			$this->s_Address->PlaceHolder = ew_RemoveHtml($this->s_Address->FldCaption());

			// s_Province
			$this->s_Province->EditCustomAttributes = "";
			if (trim(strval($this->s_Province->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->s_Province->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_province`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->s_Province, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->s_Province->ViewValue = $this->s_Province->DisplayValue($arwrk);
			} else {
				$this->s_Province->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->s_Province->EditValue = $arwrk;

			// s_City
			$this->s_City->EditCustomAttributes = "";
			if (trim(strval($this->s_City->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`AMPHUR_ID`" . ew_SearchString("=", $this->s_City->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `PROVINCE_ID` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_amphur`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->s_City, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->s_City->ViewValue = $this->s_City->DisplayValue($arwrk);
			} else {
				$this->s_City->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->s_City->EditValue = $arwrk;

			// s_PostCode
			$this->s_PostCode->EditAttrs["class"] = "form-control";
			$this->s_PostCode->EditCustomAttributes = "";
			$this->s_PostCode->EditValue = ew_HtmlEncode($this->s_PostCode->CurrentValue);
			$this->s_PostCode->PlaceHolder = ew_RemoveHtml($this->s_PostCode->FldCaption());

			// u_ID
			$this->u_ID->EditCustomAttributes = "";
			if (trim(strval($this->u_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->u_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_User`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->u_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->u_ID->ViewValue = $this->u_ID->DisplayValue($arwrk);
			} else {
				$this->u_ID->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->u_ID->EditValue = $arwrk;

			// Edit refer script
			// s_ID

			$this->s_ID->LinkCustomAttributes = "";
			$this->s_ID->HrefValue = "";

			// s_LOC
			$this->s_LOC->LinkCustomAttributes = "";
			$this->s_LOC->HrefValue = "";
			$this->s_LOC->TooltipValue = "";

			// s_Type
			$this->s_Type->LinkCustomAttributes = "";
			$this->s_Type->HrefValue = "";

			// s_Address
			$this->s_Address->LinkCustomAttributes = "";
			$this->s_Address->HrefValue = "";

			// s_Province
			$this->s_Province->LinkCustomAttributes = "";
			$this->s_Province->HrefValue = "";

			// s_City
			$this->s_City->LinkCustomAttributes = "";
			$this->s_City->HrefValue = "";

			// s_PostCode
			$this->s_PostCode->LinkCustomAttributes = "";
			$this->s_PostCode->HrefValue = "";

			// u_ID
			$this->u_ID->LinkCustomAttributes = "";
			$this->u_ID->HrefValue = "";
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
		if (!ew_CheckInteger($this->s_ID->FormValue)) {
			ew_AddMessage($gsFormError, $this->s_ID->FldErrMsg());
		}
		if (!$this->s_Type->FldIsDetailKey && !is_null($this->s_Type->FormValue) && $this->s_Type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s_Type->FldCaption(), $this->s_Type->ReqErrMsg));
		}
		if (!$this->s_Address->FldIsDetailKey && !is_null($this->s_Address->FormValue) && $this->s_Address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s_Address->FldCaption(), $this->s_Address->ReqErrMsg));
		}
		if (!$this->s_Province->FldIsDetailKey && !is_null($this->s_Province->FormValue) && $this->s_Province->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s_Province->FldCaption(), $this->s_Province->ReqErrMsg));
		}
		if (!$this->s_City->FldIsDetailKey && !is_null($this->s_City->FormValue) && $this->s_City->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s_City->FldCaption(), $this->s_City->ReqErrMsg));
		}
		if (!$this->s_PostCode->FldIsDetailKey && !is_null($this->s_PostCode->FormValue) && $this->s_PostCode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s_PostCode->FldCaption(), $this->s_PostCode->ReqErrMsg));
		}
		if (!$this->u_ID->FldIsDetailKey && !is_null($this->u_ID->FormValue) && $this->u_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_ID->FldCaption(), $this->u_ID->ReqErrMsg));
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
		if ($this->s_LOC->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`s_LOC` = '" . ew_AdjustSql($this->s_LOC->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->s_LOC->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->s_LOC->CurrentValue, $sIdxErrMsg);
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

			// s_Type
			$this->s_Type->SetDbValueDef($rsnew, $this->s_Type->CurrentValue, 0, $this->s_Type->ReadOnly);

			// s_Address
			$this->s_Address->SetDbValueDef($rsnew, $this->s_Address->CurrentValue, "", $this->s_Address->ReadOnly);

			// s_Province
			$this->s_Province->SetDbValueDef($rsnew, $this->s_Province->CurrentValue, 0, $this->s_Province->ReadOnly);

			// s_City
			$this->s_City->SetDbValueDef($rsnew, $this->s_City->CurrentValue, 0, $this->s_City->ReadOnly);

			// s_PostCode
			$this->s_PostCode->SetDbValueDef($rsnew, $this->s_PostCode->CurrentValue, "", $this->s_PostCode->ReadOnly);

			// u_ID
			$this->u_ID->SetDbValueDef($rsnew, $this->u_ID->CurrentValue, 0, $this->u_ID->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("main_stock_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($main_Stock_edit)) $main_Stock_edit = new cmain_Stock_edit();

// Page init
$main_Stock_edit->Page_Init();

// Page main
$main_Stock_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_Stock_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fmain_Stockedit = new ew_Form("fmain_Stockedit", "edit");

// Validate form
fmain_Stockedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_s_ID");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($main_Stock->s_ID->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s_Type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Stock->s_Type->FldCaption(), $main_Stock->s_Type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s_Address");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Stock->s_Address->FldCaption(), $main_Stock->s_Address->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s_Province");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Stock->s_Province->FldCaption(), $main_Stock->s_Province->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s_City");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Stock->s_City->FldCaption(), $main_Stock->s_City->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s_PostCode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Stock->s_PostCode->FldCaption(), $main_Stock->s_PostCode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Stock->u_ID->FldCaption(), $main_Stock->u_ID->ReqErrMsg)) ?>");

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
fmain_Stockedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Stockedit.ValidateRequired = true;
<?php } else { ?>
fmain_Stockedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Stockedit.Lists["x_s_Type"] = {"LinkField":"x_wh_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_wh_Type","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Stockedit.Lists["x_s_Province"] = {"LinkField":"x_PROVINCE_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_PROVINCE_NAME","","",""],"ParentFields":[],"ChildFields":["x_s_City"],"FilterFields":[],"Options":[],"Template":""};
fmain_Stockedit.Lists["x_s_City"] = {"LinkField":"x_AMPHUR_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_AMPHUR_NAME","","",""],"ParentFields":["x_s_Province"],"ChildFields":[],"FilterFields":["x_PROVINCE_ID"],"Options":[],"Template":""};
fmain_Stockedit.Lists["x_u_ID"] = {"LinkField":"x_u_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_BillName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $main_Stock_edit->ShowPageHeader(); ?>
<?php
$main_Stock_edit->ShowMessage();
?>
<form name="fmain_Stockedit" id="fmain_Stockedit" class="<?php echo $main_Stock_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_Stock_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_Stock_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_Stock">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($main_Stock->s_ID->Visible) { // s_ID ?>
	<div id="r_s_ID" class="form-group">
		<label id="elh_main_Stock_s_ID" for="x_s_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_ID->CellAttributes() ?>>
<span id="el_main_Stock_s_ID">
<span<?php echo $main_Stock->s_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Stock->s_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Stock" data-field="x_s_ID" name="x_s_ID" id="x_s_ID" value="<?php echo ew_HtmlEncode($main_Stock->s_ID->CurrentValue) ?>">
<?php echo $main_Stock->s_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->s_LOC->Visible) { // s_LOC ?>
	<div id="r_s_LOC" class="form-group">
		<label id="elh_main_Stock_s_LOC" for="x_s_LOC" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_LOC->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_LOC->CellAttributes() ?>>
<span id="el_main_Stock_s_LOC">
<span<?php echo $main_Stock->s_LOC->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Stock->s_LOC->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Stock" data-field="x_s_LOC" name="x_s_LOC" id="x_s_LOC" value="<?php echo ew_HtmlEncode($main_Stock->s_LOC->CurrentValue) ?>">
<?php echo $main_Stock->s_LOC->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->s_Type->Visible) { // s_Type ?>
	<div id="r_s_Type" class="form-group">
		<label id="elh_main_Stock_s_Type" for="x_s_Type" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_Type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_Type->CellAttributes() ?>>
<span id="el_main_Stock_s_Type">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Stock->s_Type->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_s_Type" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Stock->s_Type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Stock->s_Type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Stock" data-field="x_s_Type" name="x_s_Type" id="x_s_Type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Stock->s_Type->EditAttributes() ?>><?php echo $main_Stock->s_Type->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Stock->s_Type->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Stock" data-field="x_s_Type" name="x_s_Type" id="x_s_Type_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Stock->s_Type->CurrentValue) ?>" checked<?php echo $main_Stock->s_Type->EditAttributes() ?>><?php echo $main_Stock->s_Type->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_s_Type" class="ewTemplate"><input type="radio" data-table="main_Stock" data-field="x_s_Type" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Stock->s_Type->DisplayValueSeparator) ? json_encode($main_Stock->s_Type->DisplayValueSeparator) : $main_Stock->s_Type->DisplayValueSeparator) ?>" name="x_s_Type" id="x_s_Type" value="{value}"<?php echo $main_Stock->s_Type->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `wh_ID`, `wh_Type` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_WHType`";
$sWhereWrk = "";
$main_Stock->s_Type->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Stock->s_Type->LookupFilters += array("f0" => "`wh_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Stock->Lookup_Selecting($main_Stock->s_Type, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Stock->s_Type->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_s_Type" id="s_x_s_Type" value="<?php echo $main_Stock->s_Type->LookupFilterQuery() ?>">
</span>
<?php echo $main_Stock->s_Type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->s_Address->Visible) { // s_Address ?>
	<div id="r_s_Address" class="form-group">
		<label id="elh_main_Stock_s_Address" for="x_s_Address" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_Address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_Address->CellAttributes() ?>>
<span id="el_main_Stock_s_Address">
<input type="text" data-table="main_Stock" data-field="x_s_Address" name="x_s_Address" id="x_s_Address" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($main_Stock->s_Address->getPlaceHolder()) ?>" value="<?php echo $main_Stock->s_Address->EditValue ?>"<?php echo $main_Stock->s_Address->EditAttributes() ?>>
</span>
<?php echo $main_Stock->s_Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->s_Province->Visible) { // s_Province ?>
	<div id="r_s_Province" class="form-group">
		<label id="elh_main_Stock_s_Province" for="x_s_Province" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_Province->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_Province->CellAttributes() ?>>
<span id="el_main_Stock_s_Province">
<?php $main_Stock->s_Province->EditAttrs["onclick"] = "ew_UpdateOpt.call(this); " . @$main_Stock->s_Province->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Stock->s_Province->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_s_Province" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_Stock->s_Province->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Stock->s_Province->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Stock" data-field="x_s_Province" name="x_s_Province" id="x_s_Province_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Stock->s_Province->EditAttributes() ?>><?php echo $main_Stock->s_Province->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Stock->s_Province->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Stock" data-field="x_s_Province" name="x_s_Province" id="x_s_Province_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Stock->s_Province->CurrentValue) ?>" checked<?php echo $main_Stock->s_Province->EditAttributes() ?>><?php echo $main_Stock->s_Province->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_s_Province" class="ewTemplate"><input type="radio" data-table="main_Stock" data-field="x_s_Province" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Stock->s_Province->DisplayValueSeparator) ? json_encode($main_Stock->s_Province->DisplayValueSeparator) : $main_Stock->s_Province->DisplayValueSeparator) ?>" name="x_s_Province" id="x_s_Province" value="{value}"<?php echo $main_Stock->s_Province->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
$sWhereWrk = "";
$main_Stock->s_Province->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Stock->s_Province->LookupFilters += array("f0" => "`PROVINCE_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Stock->Lookup_Selecting($main_Stock->s_Province, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
if ($sSqlWrk <> "") $main_Stock->s_Province->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_s_Province" id="s_x_s_Province" value="<?php echo $main_Stock->s_Province->LookupFilterQuery() ?>">
</span>
<?php echo $main_Stock->s_Province->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->s_City->Visible) { // s_City ?>
	<div id="r_s_City" class="form-group">
		<label id="elh_main_Stock_s_City" for="x_s_City" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_City->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_City->CellAttributes() ?>>
<span id="el_main_Stock_s_City">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Stock->s_City->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_s_City" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_Stock->s_City->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Stock->s_City->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Stock" data-field="x_s_City" name="x_s_City" id="x_s_City_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Stock->s_City->EditAttributes() ?>><?php echo $main_Stock->s_City->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Stock->s_City->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Stock" data-field="x_s_City" name="x_s_City" id="x_s_City_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Stock->s_City->CurrentValue) ?>" checked<?php echo $main_Stock->s_City->EditAttributes() ?>><?php echo $main_Stock->s_City->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_s_City" class="ewTemplate"><input type="radio" data-table="main_Stock" data-field="x_s_City" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Stock->s_City->DisplayValueSeparator) ? json_encode($main_Stock->s_City->DisplayValueSeparator) : $main_Stock->s_City->DisplayValueSeparator) ?>" name="x_s_City" id="x_s_City" value="{value}"<?php echo $main_Stock->s_City->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `AMPHUR_ID`, `AMPHUR_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_amphur`";
$sWhereWrk = "{filter}";
$main_Stock->s_City->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Stock->s_City->LookupFilters += array("f0" => "`AMPHUR_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$main_Stock->s_City->LookupFilters += array("f1" => "`PROVINCE_ID` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$main_Stock->Lookup_Selecting($main_Stock->s_City, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `AMPHUR_NAME` ASC";
if ($sSqlWrk <> "") $main_Stock->s_City->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_s_City" id="s_x_s_City" value="<?php echo $main_Stock->s_City->LookupFilterQuery() ?>">
</span>
<?php echo $main_Stock->s_City->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->s_PostCode->Visible) { // s_PostCode ?>
	<div id="r_s_PostCode" class="form-group">
		<label id="elh_main_Stock_s_PostCode" for="x_s_PostCode" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->s_PostCode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->s_PostCode->CellAttributes() ?>>
<span id="el_main_Stock_s_PostCode">
<input type="text" data-table="main_Stock" data-field="x_s_PostCode" name="x_s_PostCode" id="x_s_PostCode" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Stock->s_PostCode->getPlaceHolder()) ?>" value="<?php echo $main_Stock->s_PostCode->EditValue ?>"<?php echo $main_Stock->s_PostCode->EditAttributes() ?>>
</span>
<?php echo $main_Stock->s_PostCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Stock->u_ID->Visible) { // u_ID ?>
	<div id="r_u_ID" class="form-group">
		<label id="elh_main_Stock_u_ID" for="x_u_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_Stock->u_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Stock->u_ID->CellAttributes() ?>>
<span id="el_main_Stock_u_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Stock->u_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_u_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Stock->u_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Stock->u_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Stock" data-field="x_u_ID" name="x_u_ID" id="x_u_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Stock->u_ID->EditAttributes() ?>><?php echo $main_Stock->u_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Stock->u_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Stock" data-field="x_u_ID" name="x_u_ID" id="x_u_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Stock->u_ID->CurrentValue) ?>" checked<?php echo $main_Stock->u_ID->EditAttributes() ?>><?php echo $main_Stock->u_ID->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_u_ID" class="ewTemplate"><input type="radio" data-table="main_Stock" data-field="x_u_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Stock->u_ID->DisplayValueSeparator) ? json_encode($main_Stock->u_ID->DisplayValueSeparator) : $main_Stock->u_ID->DisplayValueSeparator) ?>" name="x_u_ID" id="x_u_ID" value="{value}"<?php echo $main_Stock->u_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `u_ID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
$sWhereWrk = "";
$main_Stock->u_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Stock->u_ID->LookupFilters += array("f0" => "`u_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Stock->Lookup_Selecting($main_Stock->u_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Stock->u_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_u_ID" id="s_x_u_ID" value="<?php echo $main_Stock->u_ID->LookupFilterQuery() ?>">
</span>
<?php echo $main_Stock->u_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $main_Stock_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmain_Stockedit.Init();
</script>
<?php
$main_Stock_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$main_Stock_edit->Page_Terminate();
?>
