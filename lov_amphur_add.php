<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "lov_amphur_info.php" ?>
<?php include_once "lov_province_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$lov_amphur_add = NULL; // Initialize page object first

class clov_amphur_add extends clov_amphur {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'lov_amphur';

	// Page object name
	var $PageObjName = 'lov_amphur_add';

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

		// Table object (lov_amphur)
		if (!isset($GLOBALS["lov_amphur"]) || get_class($GLOBALS["lov_amphur"]) == "clov_amphur") {
			$GLOBALS["lov_amphur"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lov_amphur"];
		}

		// Table object (lov_province)
		if (!isset($GLOBALS['lov_province'])) $GLOBALS['lov_province'] = new clov_province();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lov_amphur', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("lov_amphur_list.php"));
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
		global $EW_EXPORT, $lov_amphur;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lov_amphur);
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
			if (@$_GET["AMPHUR_ID"] != "") {
				$this->AMPHUR_ID->setQueryStringValue($_GET["AMPHUR_ID"]);
				$this->setKey("AMPHUR_ID", $this->AMPHUR_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("AMPHUR_ID", ""); // Clear key
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
					$this->Page_Terminate("lov_amphur_list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "lov_amphur_list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "lov_amphur_view.php")
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
		$this->AMPHUR_CODE->CurrentValue = NULL;
		$this->AMPHUR_CODE->OldValue = $this->AMPHUR_CODE->CurrentValue;
		$this->PROVINCE_ID->CurrentValue = 0;
		$this->AMPHUR_NAME->CurrentValue = NULL;
		$this->AMPHUR_NAME->OldValue = $this->AMPHUR_NAME->CurrentValue;
		$this->AMPER_NAME_EN->CurrentValue = NULL;
		$this->AMPER_NAME_EN->OldValue = $this->AMPER_NAME_EN->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->AMPHUR_CODE->FldIsDetailKey) {
			$this->AMPHUR_CODE->setFormValue($objForm->GetValue("x_AMPHUR_CODE"));
		}
		if (!$this->PROVINCE_ID->FldIsDetailKey) {
			$this->PROVINCE_ID->setFormValue($objForm->GetValue("x_PROVINCE_ID"));
		}
		if (!$this->AMPHUR_NAME->FldIsDetailKey) {
			$this->AMPHUR_NAME->setFormValue($objForm->GetValue("x_AMPHUR_NAME"));
		}
		if (!$this->AMPER_NAME_EN->FldIsDetailKey) {
			$this->AMPER_NAME_EN->setFormValue($objForm->GetValue("x_AMPER_NAME_EN"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->AMPHUR_CODE->CurrentValue = $this->AMPHUR_CODE->FormValue;
		$this->PROVINCE_ID->CurrentValue = $this->PROVINCE_ID->FormValue;
		$this->AMPHUR_NAME->CurrentValue = $this->AMPHUR_NAME->FormValue;
		$this->AMPER_NAME_EN->CurrentValue = $this->AMPER_NAME_EN->FormValue;
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
		$this->AMPHUR_ID->setDbValue($rs->fields('AMPHUR_ID'));
		$this->AMPHUR_CODE->setDbValue($rs->fields('AMPHUR_CODE'));
		$this->PROVINCE_ID->setDbValue($rs->fields('PROVINCE_ID'));
		$this->AMPHUR_NAME->setDbValue($rs->fields('AMPHUR_NAME'));
		$this->AMPER_NAME_EN->setDbValue($rs->fields('AMPER_NAME_EN'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->AMPHUR_ID->DbValue = $row['AMPHUR_ID'];
		$this->AMPHUR_CODE->DbValue = $row['AMPHUR_CODE'];
		$this->PROVINCE_ID->DbValue = $row['PROVINCE_ID'];
		$this->AMPHUR_NAME->DbValue = $row['AMPHUR_NAME'];
		$this->AMPER_NAME_EN->DbValue = $row['AMPER_NAME_EN'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("AMPHUR_ID")) <> "")
			$this->AMPHUR_ID->CurrentValue = $this->getKey("AMPHUR_ID"); // AMPHUR_ID
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
		// AMPHUR_ID
		// AMPHUR_CODE
		// PROVINCE_ID
		// AMPHUR_NAME
		// AMPER_NAME_EN

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// AMPHUR_ID
		$this->AMPHUR_ID->ViewValue = $this->AMPHUR_ID->CurrentValue;
		$this->AMPHUR_ID->ViewCustomAttributes = "";

		// AMPHUR_CODE
		$this->AMPHUR_CODE->ViewValue = $this->AMPHUR_CODE->CurrentValue;
		$this->AMPHUR_CODE->ViewCustomAttributes = "";

		// PROVINCE_ID
		if (strval($this->PROVINCE_ID->CurrentValue) <> "") {
			$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->PROVINCE_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->CurrentValue;
			}
		} else {
			$this->PROVINCE_ID->ViewValue = NULL;
		}
		$this->PROVINCE_ID->ViewCustomAttributes = "";

		// AMPHUR_NAME
		$this->AMPHUR_NAME->ViewValue = $this->AMPHUR_NAME->CurrentValue;
		$this->AMPHUR_NAME->ViewCustomAttributes = "";

		// AMPER_NAME_EN
		$this->AMPER_NAME_EN->ViewValue = $this->AMPER_NAME_EN->CurrentValue;
		$this->AMPER_NAME_EN->ViewCustomAttributes = "";

			// AMPHUR_CODE
			$this->AMPHUR_CODE->LinkCustomAttributes = "";
			$this->AMPHUR_CODE->HrefValue = "";
			$this->AMPHUR_CODE->TooltipValue = "";

			// PROVINCE_ID
			$this->PROVINCE_ID->LinkCustomAttributes = "";
			$this->PROVINCE_ID->HrefValue = "";
			$this->PROVINCE_ID->TooltipValue = "";

			// AMPHUR_NAME
			$this->AMPHUR_NAME->LinkCustomAttributes = "";
			$this->AMPHUR_NAME->HrefValue = "";
			$this->AMPHUR_NAME->TooltipValue = "";

			// AMPER_NAME_EN
			$this->AMPER_NAME_EN->LinkCustomAttributes = "";
			$this->AMPER_NAME_EN->HrefValue = "";
			$this->AMPER_NAME_EN->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// AMPHUR_CODE
			$this->AMPHUR_CODE->EditAttrs["class"] = "form-control";
			$this->AMPHUR_CODE->EditCustomAttributes = "";
			$this->AMPHUR_CODE->EditValue = ew_HtmlEncode($this->AMPHUR_CODE->CurrentValue);
			$this->AMPHUR_CODE->PlaceHolder = ew_RemoveHtml($this->AMPHUR_CODE->FldCaption());

			// PROVINCE_ID
			$this->PROVINCE_ID->EditCustomAttributes = "";
			if ($this->PROVINCE_ID->getSessionValue() <> "") {
				$this->PROVINCE_ID->CurrentValue = $this->PROVINCE_ID->getSessionValue();
			if (strval($this->PROVINCE_ID->CurrentValue) <> "") {
				$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->PROVINCE_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->CurrentValue;
				}
			} else {
				$this->PROVINCE_ID->ViewValue = NULL;
			}
			$this->PROVINCE_ID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->PROVINCE_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`PROVINCE_ID`" . ew_SearchString("=", $this->PROVINCE_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_province`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->PROVINCE_ID->ViewValue = $this->PROVINCE_ID->DisplayValue($arwrk);
			} else {
				$this->PROVINCE_ID->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->PROVINCE_ID->EditValue = $arwrk;
			}

			// AMPHUR_NAME
			$this->AMPHUR_NAME->EditAttrs["class"] = "form-control";
			$this->AMPHUR_NAME->EditCustomAttributes = "";
			$this->AMPHUR_NAME->EditValue = ew_HtmlEncode($this->AMPHUR_NAME->CurrentValue);
			$this->AMPHUR_NAME->PlaceHolder = ew_RemoveHtml($this->AMPHUR_NAME->FldCaption());

			// AMPER_NAME_EN
			$this->AMPER_NAME_EN->EditAttrs["class"] = "form-control";
			$this->AMPER_NAME_EN->EditCustomAttributes = "";
			$this->AMPER_NAME_EN->EditValue = ew_HtmlEncode($this->AMPER_NAME_EN->CurrentValue);
			$this->AMPER_NAME_EN->PlaceHolder = ew_RemoveHtml($this->AMPER_NAME_EN->FldCaption());

			// Add refer script
			// AMPHUR_CODE

			$this->AMPHUR_CODE->LinkCustomAttributes = "";
			$this->AMPHUR_CODE->HrefValue = "";

			// PROVINCE_ID
			$this->PROVINCE_ID->LinkCustomAttributes = "";
			$this->PROVINCE_ID->HrefValue = "";

			// AMPHUR_NAME
			$this->AMPHUR_NAME->LinkCustomAttributes = "";
			$this->AMPHUR_NAME->HrefValue = "";

			// AMPER_NAME_EN
			$this->AMPER_NAME_EN->LinkCustomAttributes = "";
			$this->AMPER_NAME_EN->HrefValue = "";
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
		if (!$this->AMPHUR_CODE->FldIsDetailKey && !is_null($this->AMPHUR_CODE->FormValue) && $this->AMPHUR_CODE->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AMPHUR_CODE->FldCaption(), $this->AMPHUR_CODE->ReqErrMsg));
		}
		if (!$this->PROVINCE_ID->FldIsDetailKey && !is_null($this->PROVINCE_ID->FormValue) && $this->PROVINCE_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PROVINCE_ID->FldCaption(), $this->PROVINCE_ID->ReqErrMsg));
		}
		if (!$this->AMPHUR_NAME->FldIsDetailKey && !is_null($this->AMPHUR_NAME->FormValue) && $this->AMPHUR_NAME->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AMPHUR_NAME->FldCaption(), $this->AMPHUR_NAME->ReqErrMsg));
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

		// AMPHUR_CODE
		$this->AMPHUR_CODE->SetDbValueDef($rsnew, $this->AMPHUR_CODE->CurrentValue, "", FALSE);

		// PROVINCE_ID
		$this->PROVINCE_ID->SetDbValueDef($rsnew, $this->PROVINCE_ID->CurrentValue, 0, strval($this->PROVINCE_ID->CurrentValue) == "");

		// AMPHUR_NAME
		$this->AMPHUR_NAME->SetDbValueDef($rsnew, $this->AMPHUR_NAME->CurrentValue, "", FALSE);

		// AMPER_NAME_EN
		$this->AMPER_NAME_EN->SetDbValueDef($rsnew, $this->AMPER_NAME_EN->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->AMPHUR_ID->setDbValue($conn->Insert_ID());
				$rsnew['AMPHUR_ID'] = $this->AMPHUR_ID->DbValue;
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
			if ($sMasterTblVar == "lov_province") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_PROVINCE_ID"] <> "") {
					$GLOBALS["lov_province"]->PROVINCE_ID->setQueryStringValue($_GET["fk_PROVINCE_ID"]);
					$this->PROVINCE_ID->setQueryStringValue($GLOBALS["lov_province"]->PROVINCE_ID->QueryStringValue);
					$this->PROVINCE_ID->setSessionValue($this->PROVINCE_ID->QueryStringValue);
					if (!is_numeric($GLOBALS["lov_province"]->PROVINCE_ID->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "lov_province") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_PROVINCE_ID"] <> "") {
					$GLOBALS["lov_province"]->PROVINCE_ID->setFormValue($_POST["fk_PROVINCE_ID"]);
					$this->PROVINCE_ID->setFormValue($GLOBALS["lov_province"]->PROVINCE_ID->FormValue);
					$this->PROVINCE_ID->setSessionValue($this->PROVINCE_ID->FormValue);
					if (!is_numeric($GLOBALS["lov_province"]->PROVINCE_ID->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "lov_province") {
				if ($this->PROVINCE_ID->CurrentValue == "") $this->PROVINCE_ID->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("lov_amphur_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($lov_amphur_add)) $lov_amphur_add = new clov_amphur_add();

// Page init
$lov_amphur_add->Page_Init();

// Page main
$lov_amphur_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_amphur_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = flov_amphuradd = new ew_Form("flov_amphuradd", "add");

// Validate form
flov_amphuradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_AMPHUR_CODE");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_amphur->AMPHUR_CODE->FldCaption(), $lov_amphur->AMPHUR_CODE->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PROVINCE_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_amphur->PROVINCE_ID->FldCaption(), $lov_amphur->PROVINCE_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AMPHUR_NAME");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $lov_amphur->AMPHUR_NAME->FldCaption(), $lov_amphur->AMPHUR_NAME->ReqErrMsg)) ?>");

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
flov_amphuradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_amphuradd.ValidateRequired = true;
<?php } else { ?>
flov_amphuradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flov_amphuradd.Lists["x_PROVINCE_ID"] = {"LinkField":"x_PROVINCE_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_PROVINCE_NAME","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $lov_amphur_add->ShowPageHeader(); ?>
<?php
$lov_amphur_add->ShowMessage();
?>
<form name="flov_amphuradd" id="flov_amphuradd" class="<?php echo $lov_amphur_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lov_amphur_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lov_amphur_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lov_amphur">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($lov_amphur->getCurrentMasterTable() == "lov_province") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="lov_province">
<input type="hidden" name="fk_PROVINCE_ID" value="<?php echo $lov_amphur->PROVINCE_ID->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($lov_amphur->AMPHUR_CODE->Visible) { // AMPHUR_CODE ?>
	<div id="r_AMPHUR_CODE" class="form-group">
		<label id="elh_lov_amphur_AMPHUR_CODE" for="x_AMPHUR_CODE" class="col-sm-2 control-label ewLabel"><?php echo $lov_amphur->AMPHUR_CODE->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_amphur->AMPHUR_CODE->CellAttributes() ?>>
<span id="el_lov_amphur_AMPHUR_CODE">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_CODE" name="x_AMPHUR_CODE" id="x_AMPHUR_CODE" size="30" maxlength="4" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_CODE->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_CODE->EditValue ?>"<?php echo $lov_amphur->AMPHUR_CODE->EditAttributes() ?>>
</span>
<?php echo $lov_amphur->AMPHUR_CODE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_amphur->PROVINCE_ID->Visible) { // PROVINCE_ID ?>
	<div id="r_PROVINCE_ID" class="form-group">
		<label id="elh_lov_amphur_PROVINCE_ID" for="x_PROVINCE_ID" class="col-sm-2 control-label ewLabel"><?php echo $lov_amphur->PROVINCE_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_amphur->PROVINCE_ID->CellAttributes() ?>>
<?php if ($lov_amphur->PROVINCE_ID->getSessionValue() <> "") { ?>
<span id="el_lov_amphur_PROVINCE_ID">
<span<?php echo $lov_amphur->PROVINCE_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $lov_amphur->PROVINCE_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_PROVINCE_ID" name="x_PROVINCE_ID" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_lov_amphur_PROVINCE_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $lov_amphur->PROVINCE_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_PROVINCE_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $lov_amphur->PROVINCE_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lov_amphur->PROVINCE_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x_PROVINCE_ID" id="x_PROVINCE_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($lov_amphur->PROVINCE_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" name="x_PROVINCE_ID" id="x_PROVINCE_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($lov_amphur->PROVINCE_ID->CurrentValue) ?>" checked<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>><?php echo $lov_amphur->PROVINCE_ID->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_PROVINCE_ID" class="ewTemplate"><input type="radio" data-table="lov_amphur" data-field="x_PROVINCE_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($lov_amphur->PROVINCE_ID->DisplayValueSeparator) ? json_encode($lov_amphur->PROVINCE_ID->DisplayValueSeparator) : $lov_amphur->PROVINCE_ID->DisplayValueSeparator) ?>" name="x_PROVINCE_ID" id="x_PROVINCE_ID" value="{value}"<?php echo $lov_amphur->PROVINCE_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `PROVINCE_ID`, `PROVINCE_NAME` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_province`";
$sWhereWrk = "";
$lov_amphur->PROVINCE_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$lov_amphur->PROVINCE_ID->LookupFilters += array("f0" => "`PROVINCE_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$lov_amphur->Lookup_Selecting($lov_amphur->PROVINCE_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `PROVINCE_NAME` ASC";
if ($sSqlWrk <> "") $lov_amphur->PROVINCE_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_PROVINCE_ID" id="s_x_PROVINCE_ID" value="<?php echo $lov_amphur->PROVINCE_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $lov_amphur->PROVINCE_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_amphur->AMPHUR_NAME->Visible) { // AMPHUR_NAME ?>
	<div id="r_AMPHUR_NAME" class="form-group">
		<label id="elh_lov_amphur_AMPHUR_NAME" for="x_AMPHUR_NAME" class="col-sm-2 control-label ewLabel"><?php echo $lov_amphur->AMPHUR_NAME->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $lov_amphur->AMPHUR_NAME->CellAttributes() ?>>
<span id="el_lov_amphur_AMPHUR_NAME">
<input type="text" data-table="lov_amphur" data-field="x_AMPHUR_NAME" name="x_AMPHUR_NAME" id="x_AMPHUR_NAME" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPHUR_NAME->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPHUR_NAME->EditValue ?>"<?php echo $lov_amphur->AMPHUR_NAME->EditAttributes() ?>>
</span>
<?php echo $lov_amphur->AMPHUR_NAME->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($lov_amphur->AMPER_NAME_EN->Visible) { // AMPER_NAME_EN ?>
	<div id="r_AMPER_NAME_EN" class="form-group">
		<label id="elh_lov_amphur_AMPER_NAME_EN" for="x_AMPER_NAME_EN" class="col-sm-2 control-label ewLabel"><?php echo $lov_amphur->AMPER_NAME_EN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $lov_amphur->AMPER_NAME_EN->CellAttributes() ?>>
<span id="el_lov_amphur_AMPER_NAME_EN">
<input type="text" data-table="lov_amphur" data-field="x_AMPER_NAME_EN" name="x_AMPER_NAME_EN" id="x_AMPER_NAME_EN" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($lov_amphur->AMPER_NAME_EN->getPlaceHolder()) ?>" value="<?php echo $lov_amphur->AMPER_NAME_EN->EditValue ?>"<?php echo $lov_amphur->AMPER_NAME_EN->EditAttributes() ?>>
</span>
<?php echo $lov_amphur->AMPER_NAME_EN->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $lov_amphur_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
flov_amphuradd.Init();
</script>
<?php
$lov_amphur_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lov_amphur_add->Page_Terminate();
?>
