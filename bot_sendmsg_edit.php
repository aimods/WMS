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

$bot_SendMSG_edit = NULL; // Initialize page object first

class cbot_SendMSG_edit extends cbot_SendMSG {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'bot_SendMSG';

	// Page object name
	var $PageObjName = 'bot_SendMSG_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->sm_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["sm_ID"] <> "") {
			$this->sm_ID->setQueryStringValue($_GET["sm_ID"]);
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
		if ($this->sm_ID->CurrentValue == "")
			$this->Page_Terminate("bot_sendmsg_list.php"); // Invalid key, return to list

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
					$this->Page_Terminate("bot_sendmsg_list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "bot_sendmsg_list.php")
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
		if (!$this->sm_ID->FldIsDetailKey)
			$this->sm_ID->setFormValue($objForm->GetValue("x_sm_ID"));
		if (!$this->u_ID->FldIsDetailKey) {
			$this->u_ID->setFormValue($objForm->GetValue("x_u_ID"));
		}
		if (!$this->u_sendTo->FldIsDetailKey) {
			$this->u_sendTo->setFormValue($objForm->GetValue("x_u_sendTo"));
		}
		if (!$this->u_TextType->FldIsDetailKey) {
			$this->u_TextType->setFormValue($objForm->GetValue("x_u_TextType"));
		}
		if (!$this->u_sendText->FldIsDetailKey) {
			$this->u_sendText->setFormValue($objForm->GetValue("x_u_sendText"));
		}
		if (!$this->u_sendSchedule->FldIsDetailKey) {
			$this->u_sendSchedule->setFormValue($objForm->GetValue("x_u_sendSchedule"));
			$this->u_sendSchedule->CurrentValue = ew_UnFormatDateTime($this->u_sendSchedule->CurrentValue, 7);
		}
		if (!$this->u_Status->FldIsDetailKey) {
			$this->u_Status->setFormValue($objForm->GetValue("x_u_Status"));
		}
		if (!$this->u_Create->FldIsDetailKey) {
			$this->u_Create->setFormValue($objForm->GetValue("x_u_Create"));
			$this->u_Create->CurrentValue = ew_UnFormatDateTime($this->u_Create->CurrentValue, 7);
		}
		if (!$this->u_Sent->FldIsDetailKey) {
			$this->u_Sent->setFormValue($objForm->GetValue("x_u_Sent"));
			$this->u_Sent->CurrentValue = ew_UnFormatDateTime($this->u_Sent->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->sm_ID->CurrentValue = $this->sm_ID->FormValue;
		$this->u_ID->CurrentValue = $this->u_ID->FormValue;
		$this->u_sendTo->CurrentValue = $this->u_sendTo->FormValue;
		$this->u_TextType->CurrentValue = $this->u_TextType->FormValue;
		$this->u_sendText->CurrentValue = $this->u_sendText->FormValue;
		$this->u_sendSchedule->CurrentValue = $this->u_sendSchedule->FormValue;
		$this->u_sendSchedule->CurrentValue = ew_UnFormatDateTime($this->u_sendSchedule->CurrentValue, 7);
		$this->u_Status->CurrentValue = $this->u_Status->FormValue;
		$this->u_Create->CurrentValue = $this->u_Create->FormValue;
		$this->u_Create->CurrentValue = ew_UnFormatDateTime($this->u_Create->CurrentValue, 7);
		$this->u_Sent->CurrentValue = $this->u_Sent->FormValue;
		$this->u_Sent->CurrentValue = ew_UnFormatDateTime($this->u_Sent->CurrentValue, 7);
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
		$this->u_Status->setDbValue($rs->fields('u_Status'));
		$this->u_Create->setDbValue($rs->fields('u_Create'));
		$this->u_Sent->setDbValue($rs->fields('u_Sent'));
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
		$this->u_Status->DbValue = $row['u_Status'];
		$this->u_Create->DbValue = $row['u_Create'];
		$this->u_Sent->DbValue = $row['u_Sent'];
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
		// u_Status
		// u_Create
		// u_Sent

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// sm_ID
		$this->sm_ID->ViewValue = $this->sm_ID->CurrentValue;
		$this->sm_ID->ViewCustomAttributes = "";

		// u_ID
		$this->u_ID->ViewValue = $this->u_ID->CurrentValue;
		$this->u_ID->ViewCustomAttributes = "";

		// u_sendTo
		$this->u_sendTo->ViewValue = $this->u_sendTo->CurrentValue;
		if (strval($this->u_sendTo->CurrentValue) <> "") {
			$sFilterWrk = "`u_UUID`" . ew_SearchString("=", $this->u_sendTo->CurrentValue, EW_DATATYPE_OTHER, "");
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

		// u_sendText
		$this->u_sendText->ViewValue = $this->u_sendText->CurrentValue;
		$this->u_sendText->ViewCustomAttributes = "";

		// u_sendSchedule
		$this->u_sendSchedule->ViewValue = $this->u_sendSchedule->CurrentValue;
		$this->u_sendSchedule->ViewValue = ew_FormatDateTime($this->u_sendSchedule->ViewValue, 7);
		$this->u_sendSchedule->ViewCustomAttributes = "";

		// u_Status
		if (strval($this->u_Status->CurrentValue) <> "") {
			$this->u_Status->ViewValue = $this->u_Status->OptionCaption($this->u_Status->CurrentValue);
		} else {
			$this->u_Status->ViewValue = NULL;
		}
		$this->u_Status->ViewCustomAttributes = "";

		// u_Create
		$this->u_Create->ViewValue = $this->u_Create->CurrentValue;
		$this->u_Create->ViewValue = ew_FormatDateTime($this->u_Create->ViewValue, 7);
		$this->u_Create->ViewCustomAttributes = "";

		// u_Sent
		$this->u_Sent->ViewValue = $this->u_Sent->CurrentValue;
		$this->u_Sent->ViewValue = ew_FormatDateTime($this->u_Sent->ViewValue, 7);
		$this->u_Sent->ViewCustomAttributes = "";

			// sm_ID
			$this->sm_ID->LinkCustomAttributes = "";
			$this->sm_ID->HrefValue = "";
			$this->sm_ID->TooltipValue = "";

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

			// u_sendText
			$this->u_sendText->LinkCustomAttributes = "";
			$this->u_sendText->HrefValue = "";
			$this->u_sendText->TooltipValue = "";

			// u_sendSchedule
			$this->u_sendSchedule->LinkCustomAttributes = "";
			$this->u_sendSchedule->HrefValue = "";
			$this->u_sendSchedule->TooltipValue = "";

			// u_Status
			$this->u_Status->LinkCustomAttributes = "";
			$this->u_Status->HrefValue = "";
			$this->u_Status->TooltipValue = "";

			// u_Create
			$this->u_Create->LinkCustomAttributes = "";
			$this->u_Create->HrefValue = "";
			$this->u_Create->TooltipValue = "";

			// u_Sent
			$this->u_Sent->LinkCustomAttributes = "";
			$this->u_Sent->HrefValue = "";
			$this->u_Sent->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// sm_ID
			$this->sm_ID->EditAttrs["class"] = "form-control";
			$this->sm_ID->EditCustomAttributes = "";
			$this->sm_ID->EditValue = $this->sm_ID->CurrentValue;
			$this->sm_ID->ViewCustomAttributes = "";

			// u_ID
			$this->u_ID->EditAttrs["class"] = "form-control";
			$this->u_ID->EditCustomAttributes = "";

			// u_sendTo
			$this->u_sendTo->EditAttrs["class"] = "form-control";
			$this->u_sendTo->EditCustomAttributes = "";
			$this->u_sendTo->EditValue = ew_HtmlEncode($this->u_sendTo->CurrentValue);
			if (strval($this->u_sendTo->CurrentValue) <> "") {
				$sFilterWrk = "`u_UUID`" . ew_SearchString("=", $this->u_sendTo->CurrentValue, EW_DATATYPE_OTHER, "");
			$sSqlWrk = "SELECT `u_UUID`, `u_BillName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->u_sendTo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->u_sendTo->EditValue = $this->u_sendTo->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->u_sendTo->EditValue = ew_HtmlEncode($this->u_sendTo->CurrentValue);
				}
			} else {
				$this->u_sendTo->EditValue = NULL;
			}
			$this->u_sendTo->PlaceHolder = ew_RemoveHtml($this->u_sendTo->FldCaption());

			// u_TextType
			$this->u_TextType->EditAttrs["class"] = "form-control";
			$this->u_TextType->EditCustomAttributes = "";
			$this->u_TextType->EditValue = $this->u_TextType->Options(TRUE);

			// u_sendText
			$this->u_sendText->EditAttrs["class"] = "form-control";
			$this->u_sendText->EditCustomAttributes = "";
			$this->u_sendText->EditValue = ew_HtmlEncode($this->u_sendText->CurrentValue);
			$this->u_sendText->PlaceHolder = ew_RemoveHtml($this->u_sendText->FldCaption());

			// u_sendSchedule
			$this->u_sendSchedule->EditAttrs["class"] = "form-control";
			$this->u_sendSchedule->EditCustomAttributes = "";
			$this->u_sendSchedule->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->u_sendSchedule->CurrentValue, 7));
			$this->u_sendSchedule->PlaceHolder = ew_RemoveHtml($this->u_sendSchedule->FldCaption());

			// u_Status
			$this->u_Status->EditAttrs["class"] = "form-control";
			$this->u_Status->EditCustomAttributes = "";
			$this->u_Status->EditValue = $this->u_Status->Options(TRUE);

			// u_Create
			$this->u_Create->EditAttrs["class"] = "form-control";
			$this->u_Create->EditCustomAttributes = "";
			$this->u_Create->EditValue = $this->u_Create->CurrentValue;
			$this->u_Create->EditValue = ew_FormatDateTime($this->u_Create->EditValue, 7);
			$this->u_Create->ViewCustomAttributes = "";

			// u_Sent
			$this->u_Sent->EditAttrs["class"] = "form-control";
			$this->u_Sent->EditCustomAttributes = "";
			$this->u_Sent->EditValue = $this->u_Sent->CurrentValue;
			$this->u_Sent->EditValue = ew_FormatDateTime($this->u_Sent->EditValue, 7);
			$this->u_Sent->ViewCustomAttributes = "";

			// Edit refer script
			// sm_ID

			$this->sm_ID->LinkCustomAttributes = "";
			$this->sm_ID->HrefValue = "";

			// u_ID
			$this->u_ID->LinkCustomAttributes = "";
			$this->u_ID->HrefValue = "";

			// u_sendTo
			$this->u_sendTo->LinkCustomAttributes = "";
			$this->u_sendTo->HrefValue = "";

			// u_TextType
			$this->u_TextType->LinkCustomAttributes = "";
			$this->u_TextType->HrefValue = "";

			// u_sendText
			$this->u_sendText->LinkCustomAttributes = "";
			$this->u_sendText->HrefValue = "";

			// u_sendSchedule
			$this->u_sendSchedule->LinkCustomAttributes = "";
			$this->u_sendSchedule->HrefValue = "";

			// u_Status
			$this->u_Status->LinkCustomAttributes = "";
			$this->u_Status->HrefValue = "";

			// u_Create
			$this->u_Create->LinkCustomAttributes = "";
			$this->u_Create->HrefValue = "";
			$this->u_Create->TooltipValue = "";

			// u_Sent
			$this->u_Sent->LinkCustomAttributes = "";
			$this->u_Sent->HrefValue = "";
			$this->u_Sent->TooltipValue = "";
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
		if (!$this->u_sendTo->FldIsDetailKey && !is_null($this->u_sendTo->FormValue) && $this->u_sendTo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_sendTo->FldCaption(), $this->u_sendTo->ReqErrMsg));
		}
		if (!$this->u_TextType->FldIsDetailKey && !is_null($this->u_TextType->FormValue) && $this->u_TextType->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_TextType->FldCaption(), $this->u_TextType->ReqErrMsg));
		}
		if (!$this->u_sendText->FldIsDetailKey && !is_null($this->u_sendText->FormValue) && $this->u_sendText->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->u_sendText->FldCaption(), $this->u_sendText->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->u_sendSchedule->FormValue)) {
			ew_AddMessage($gsFormError, $this->u_sendSchedule->FldErrMsg());
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

			// u_ID
			$this->u_ID->SetDbValueDef($rsnew, $this->u_ID->CurrentValue, 0, $this->u_ID->ReadOnly);

			// u_sendTo
			$this->u_sendTo->SetDbValueDef($rsnew, $this->u_sendTo->CurrentValue, "", $this->u_sendTo->ReadOnly);

			// u_TextType
			$this->u_TextType->SetDbValueDef($rsnew, $this->u_TextType->CurrentValue, 0, $this->u_TextType->ReadOnly);

			// u_sendText
			$this->u_sendText->SetDbValueDef($rsnew, $this->u_sendText->CurrentValue, "", $this->u_sendText->ReadOnly);

			// u_sendSchedule
			$this->u_sendSchedule->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->u_sendSchedule->CurrentValue, 7), NULL, $this->u_sendSchedule->ReadOnly);

			// u_Status
			$this->u_Status->SetDbValueDef($rsnew, $this->u_Status->CurrentValue, 0, $this->u_Status->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("bot_sendmsg_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($bot_SendMSG_edit)) $bot_SendMSG_edit = new cbot_SendMSG_edit();

// Page init
$bot_SendMSG_edit->Page_Init();

// Page main
$bot_SendMSG_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$bot_SendMSG_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fbot_SendMSGedit = new ew_Form("fbot_SendMSGedit", "edit");

// Validate form
fbot_SendMSGedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_u_sendTo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $bot_SendMSG->u_sendTo->FldCaption(), $bot_SendMSG->u_sendTo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_TextType");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $bot_SendMSG->u_TextType->FldCaption(), $bot_SendMSG->u_TextType->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_sendText");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $bot_SendMSG->u_sendText->FldCaption(), $bot_SendMSG->u_sendText->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_u_sendSchedule");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($bot_SendMSG->u_sendSchedule->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_u_Status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $bot_SendMSG->u_Status->FldCaption(), $bot_SendMSG->u_Status->ReqErrMsg)) ?>");

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
fbot_SendMSGedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbot_SendMSGedit.ValidateRequired = true;
<?php } else { ?>
fbot_SendMSGedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbot_SendMSGedit.Lists["x_u_sendTo"] = {"LinkField":"x_u_UUID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_BillName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbot_SendMSGedit.Lists["x_u_TextType"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbot_SendMSGedit.Lists["x_u_TextType"].Options = <?php echo json_encode($bot_SendMSG->u_TextType->Options()) ?>;
fbot_SendMSGedit.Lists["x_u_Status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbot_SendMSGedit.Lists["x_u_Status"].Options = <?php echo json_encode($bot_SendMSG->u_Status->Options()) ?>;

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
<?php $bot_SendMSG_edit->ShowPageHeader(); ?>
<?php
$bot_SendMSG_edit->ShowMessage();
?>
<form name="fbot_SendMSGedit" id="fbot_SendMSGedit" class="<?php echo $bot_SendMSG_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($bot_SendMSG_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $bot_SendMSG_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="bot_SendMSG">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($bot_SendMSG->sm_ID->Visible) { // sm_ID ?>
	<div id="r_sm_ID" class="form-group">
		<label id="elh_bot_SendMSG_sm_ID" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->sm_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->sm_ID->CellAttributes() ?>>
<span id="el_bot_SendMSG_sm_ID">
<span<?php echo $bot_SendMSG->sm_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bot_SendMSG->sm_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="bot_SendMSG" data-field="x_sm_ID" name="x_sm_ID" id="x_sm_ID" value="<?php echo ew_HtmlEncode($bot_SendMSG->sm_ID->CurrentValue) ?>">
<?php echo $bot_SendMSG->sm_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_sendTo->Visible) { // u_sendTo ?>
	<div id="r_u_sendTo" class="form-group">
		<label id="elh_bot_SendMSG_u_sendTo" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_sendTo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_sendTo->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_sendTo">
<?php
$wrkonchange = trim(" " . @$bot_SendMSG->u_sendTo->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$bot_SendMSG->u_sendTo->EditAttrs["onchange"] = "";
?>
<span id="as_x_u_sendTo" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_u_sendTo" id="sv_x_u_sendTo" value="<?php echo $bot_SendMSG->u_sendTo->EditValue ?>" size="30" maxlength="48" placeholder="<?php echo ew_HtmlEncode($bot_SendMSG->u_sendTo->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($bot_SendMSG->u_sendTo->getPlaceHolder()) ?>"<?php echo $bot_SendMSG->u_sendTo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="bot_SendMSG" data-field="x_u_sendTo" data-value-separator="<?php echo ew_HtmlEncode(is_array($bot_SendMSG->u_sendTo->DisplayValueSeparator) ? json_encode($bot_SendMSG->u_sendTo->DisplayValueSeparator) : $bot_SendMSG->u_sendTo->DisplayValueSeparator) ?>" name="x_u_sendTo" id="x_u_sendTo" value="<?php echo ew_HtmlEncode($bot_SendMSG->u_sendTo->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `u_UUID`, `u_BillName` AS `DispFld` FROM `main_User`";
$sWhereWrk = "`u_BillName` LIKE '%{query_value}%'";
$bot_SendMSG->Lookup_Selecting($bot_SendMSG->u_sendTo, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_u_sendTo" id="q_x_u_sendTo" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&d=">
<script type="text/javascript">
fbot_SendMSGedit.CreateAutoSuggest({"id":"x_u_sendTo","forceSelect":false});
</script>
</span>
<?php echo $bot_SendMSG->u_sendTo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_TextType->Visible) { // u_TextType ?>
	<div id="r_u_TextType" class="form-group">
		<label id="elh_bot_SendMSG_u_TextType" for="x_u_TextType" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_TextType->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_TextType->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_TextType">
<select data-table="bot_SendMSG" data-field="x_u_TextType" data-value-separator="<?php echo ew_HtmlEncode(is_array($bot_SendMSG->u_TextType->DisplayValueSeparator) ? json_encode($bot_SendMSG->u_TextType->DisplayValueSeparator) : $bot_SendMSG->u_TextType->DisplayValueSeparator) ?>" id="x_u_TextType" name="x_u_TextType"<?php echo $bot_SendMSG->u_TextType->EditAttributes() ?>>
<?php
if (is_array($bot_SendMSG->u_TextType->EditValue)) {
	$arwrk = $bot_SendMSG->u_TextType->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($bot_SendMSG->u_TextType->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $bot_SendMSG->u_TextType->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($bot_SendMSG->u_TextType->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($bot_SendMSG->u_TextType->CurrentValue) ?>" selected><?php echo $bot_SendMSG->u_TextType->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $bot_SendMSG->u_TextType->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_sendText->Visible) { // u_sendText ?>
	<div id="r_u_sendText" class="form-group">
		<label id="elh_bot_SendMSG_u_sendText" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_sendText->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_sendText->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_sendText">
<?php ew_AppendClass($bot_SendMSG->u_sendText->EditAttrs["class"], "editor"); ?>
<textarea data-table="bot_SendMSG" data-field="x_u_sendText" name="x_u_sendText" id="x_u_sendText" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($bot_SendMSG->u_sendText->getPlaceHolder()) ?>"<?php echo $bot_SendMSG->u_sendText->EditAttributes() ?>><?php echo $bot_SendMSG->u_sendText->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fbot_SendMSGedit", "x_u_sendText", 35, 4, <?php echo ($bot_SendMSG->u_sendText->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $bot_SendMSG->u_sendText->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_sendSchedule->Visible) { // u_sendSchedule ?>
	<div id="r_u_sendSchedule" class="form-group">
		<label id="elh_bot_SendMSG_u_sendSchedule" for="x_u_sendSchedule" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_sendSchedule->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_sendSchedule->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_sendSchedule">
<input type="text" data-table="bot_SendMSG" data-field="x_u_sendSchedule" data-format="7" name="x_u_sendSchedule" id="x_u_sendSchedule" placeholder="<?php echo ew_HtmlEncode($bot_SendMSG->u_sendSchedule->getPlaceHolder()) ?>" value="<?php echo $bot_SendMSG->u_sendSchedule->EditValue ?>"<?php echo $bot_SendMSG->u_sendSchedule->EditAttributes() ?>>
<?php if (!$bot_SendMSG->u_sendSchedule->ReadOnly && !$bot_SendMSG->u_sendSchedule->Disabled && !isset($bot_SendMSG->u_sendSchedule->EditAttrs["readonly"]) && !isset($bot_SendMSG->u_sendSchedule->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fbot_SendMSGedit", "x_u_sendSchedule", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $bot_SendMSG->u_sendSchedule->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_Status->Visible) { // u_Status ?>
	<div id="r_u_Status" class="form-group">
		<label id="elh_bot_SendMSG_u_Status" for="x_u_Status" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_Status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_Status->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_Status">
<select data-table="bot_SendMSG" data-field="x_u_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($bot_SendMSG->u_Status->DisplayValueSeparator) ? json_encode($bot_SendMSG->u_Status->DisplayValueSeparator) : $bot_SendMSG->u_Status->DisplayValueSeparator) ?>" id="x_u_Status" name="x_u_Status"<?php echo $bot_SendMSG->u_Status->EditAttributes() ?>>
<?php
if (is_array($bot_SendMSG->u_Status->EditValue)) {
	$arwrk = $bot_SendMSG->u_Status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($bot_SendMSG->u_Status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $bot_SendMSG->u_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($bot_SendMSG->u_Status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($bot_SendMSG->u_Status->CurrentValue) ?>" selected><?php echo $bot_SendMSG->u_Status->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $bot_SendMSG->u_Status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_Create->Visible) { // u_Create ?>
	<div id="r_u_Create" class="form-group">
		<label id="elh_bot_SendMSG_u_Create" for="x_u_Create" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_Create->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_Create->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_Create">
<span<?php echo $bot_SendMSG->u_Create->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bot_SendMSG->u_Create->EditValue ?></p></span>
</span>
<input type="hidden" data-table="bot_SendMSG" data-field="x_u_Create" name="x_u_Create" id="x_u_Create" value="<?php echo ew_HtmlEncode($bot_SendMSG->u_Create->CurrentValue) ?>">
<?php echo $bot_SendMSG->u_Create->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($bot_SendMSG->u_Sent->Visible) { // u_Sent ?>
	<div id="r_u_Sent" class="form-group">
		<label id="elh_bot_SendMSG_u_Sent" for="x_u_Sent" class="col-sm-2 control-label ewLabel"><?php echo $bot_SendMSG->u_Sent->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $bot_SendMSG->u_Sent->CellAttributes() ?>>
<span id="el_bot_SendMSG_u_Sent">
<span<?php echo $bot_SendMSG->u_Sent->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bot_SendMSG->u_Sent->EditValue ?></p></span>
</span>
<input type="hidden" data-table="bot_SendMSG" data-field="x_u_Sent" name="x_u_Sent" id="x_u_Sent" value="<?php echo ew_HtmlEncode($bot_SendMSG->u_Sent->CurrentValue) ?>">
<?php echo $bot_SendMSG->u_Sent->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<span id="el_bot_SendMSG_u_ID">
<input type="hidden" data-table="bot_SendMSG" data-field="x_u_ID" name="x_u_ID" id="x_u_ID" value="<?php echo ew_HtmlEncode($bot_SendMSG->u_ID->CurrentValue) ?>">
</span>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $bot_SendMSG_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fbot_SendMSGedit.Init();
</script>
<?php
$bot_SendMSG_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$bot_SendMSG_edit->Page_Terminate();
?>
