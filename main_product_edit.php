<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "main_product_info.php" ?>
<?php include_once "main_partnum_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "transaction_movement_gridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$main_Product_edit = NULL; // Initialize page object first

class cmain_Product_edit extends cmain_Product {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_Product';

	// Page object name
	var $PageObjName = 'main_Product_edit';

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

		// Table object (main_Product)
		if (!isset($GLOBALS["main_Product"]) || get_class($GLOBALS["main_Product"]) == "cmain_Product") {
			$GLOBALS["main_Product"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_Product"];
		}

		// Table object (main_PartNum)
		if (!isset($GLOBALS['main_PartNum'])) $GLOBALS['main_PartNum'] = new cmain_PartNum();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'main_Product', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("main_product_list.php"));
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
		$this->pr_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

			// Process auto fill for detail table 'transaction_Movement'
			if (@$_POST["grid"] == "ftransaction_Movementgrid") {
				if (!isset($GLOBALS["transaction_Movement_grid"])) $GLOBALS["transaction_Movement_grid"] = new ctransaction_Movement_grid;
				$GLOBALS["transaction_Movement_grid"]->Page_Init();
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
		global $EW_EXPORT, $main_Product;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($main_Product);
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
		if (@$_GET["pr_ID"] <> "") {
			$this->pr_ID->setQueryStringValue($_GET["pr_ID"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->pr_ID->CurrentValue == "")
			$this->Page_Terminate("main_product_list.php"); // Invalid key, return to list

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
					$this->Page_Terminate("main_product_list.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "main_product_list.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->pr_ID->FldIsDetailKey)
			$this->pr_ID->setFormValue($objForm->GetValue("x_pr_ID"));
		if (!$this->pn_ID->FldIsDetailKey) {
			$this->pn_ID->setFormValue($objForm->GetValue("x_pn_ID"));
		}
		if (!$this->pr_Barcode->FldIsDetailKey) {
			$this->pr_Barcode->setFormValue($objForm->GetValue("x_pr_Barcode"));
		}
		if (!$this->pr_Activated->FldIsDetailKey) {
			$this->pr_Activated->setFormValue($objForm->GetValue("x_pr_Activated"));
			$this->pr_Activated->CurrentValue = ew_UnFormatDateTime($this->pr_Activated->CurrentValue, 7);
		}
		if (!$this->pr_Status->FldIsDetailKey) {
			$this->pr_Status->setFormValue($objForm->GetValue("x_pr_Status"));
		}
		if (!$this->pr_PO->FldIsDetailKey) {
			$this->pr_PO->setFormValue($objForm->GetValue("x_pr_PO"));
		}
		if (!$this->pr_Cost->FldIsDetailKey) {
			$this->pr_Cost->setFormValue($objForm->GetValue("x_pr_Cost"));
		}
		if (!$this->pr_intStatus->FldIsDetailKey) {
			$this->pr_intStatus->setFormValue($objForm->GetValue("x_pr_intStatus"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->pr_ID->CurrentValue = $this->pr_ID->FormValue;
		$this->pn_ID->CurrentValue = $this->pn_ID->FormValue;
		$this->pr_Barcode->CurrentValue = $this->pr_Barcode->FormValue;
		$this->pr_Activated->CurrentValue = $this->pr_Activated->FormValue;
		$this->pr_Activated->CurrentValue = ew_UnFormatDateTime($this->pr_Activated->CurrentValue, 7);
		$this->pr_Status->CurrentValue = $this->pr_Status->FormValue;
		$this->pr_PO->CurrentValue = $this->pr_PO->FormValue;
		$this->pr_Cost->CurrentValue = $this->pr_Cost->FormValue;
		$this->pr_intStatus->CurrentValue = $this->pr_intStatus->FormValue;
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
		$this->pr_ID->setDbValue($rs->fields('pr_ID'));
		$this->pn_ID->setDbValue($rs->fields('pn_ID'));
		$this->pr_Barcode->setDbValue($rs->fields('pr_Barcode'));
		$this->pr_Activated->setDbValue($rs->fields('pr_Activated'));
		$this->pr_Status->setDbValue($rs->fields('pr_Status'));
		$this->pr_PO->setDbValue($rs->fields('pr_PO'));
		$this->pr_Cost->setDbValue($rs->fields('pr_Cost'));
		$this->pr_intStatus->setDbValue($rs->fields('pr_intStatus'));
		$this->pr_Created->setDbValue($rs->fields('pr_Created'));
		$this->pr_Updated->setDbValue($rs->fields('pr_Updated'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->pr_ID->DbValue = $row['pr_ID'];
		$this->pn_ID->DbValue = $row['pn_ID'];
		$this->pr_Barcode->DbValue = $row['pr_Barcode'];
		$this->pr_Activated->DbValue = $row['pr_Activated'];
		$this->pr_Status->DbValue = $row['pr_Status'];
		$this->pr_PO->DbValue = $row['pr_PO'];
		$this->pr_Cost->DbValue = $row['pr_Cost'];
		$this->pr_intStatus->DbValue = $row['pr_intStatus'];
		$this->pr_Created->DbValue = $row['pr_Created'];
		$this->pr_Updated->DbValue = $row['pr_Updated'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->pr_Cost->FormValue == $this->pr_Cost->CurrentValue && is_numeric(ew_StrToFloat($this->pr_Cost->CurrentValue)))
			$this->pr_Cost->CurrentValue = ew_StrToFloat($this->pr_Cost->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// pr_ID
		// pn_ID
		// pr_Barcode
		// pr_Activated
		// pr_Status
		// pr_PO
		// pr_Cost
		// pr_intStatus
		// pr_Created
		// pr_Updated

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// pr_ID
		$this->pr_ID->ViewValue = $this->pr_ID->CurrentValue;
		$this->pr_ID->ViewCustomAttributes = "";

		// pn_ID
		if (strval($this->pn_ID->CurrentValue) <> "") {
			$sFilterWrk = "`pn_ID`" . ew_SearchString("=", $this->pn_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `pn_ID`, `pn_ProductName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_PartNum`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pn_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pn_ID->ViewValue = $this->pn_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pn_ID->ViewValue = $this->pn_ID->CurrentValue;
			}
		} else {
			$this->pn_ID->ViewValue = NULL;
		}
		$this->pn_ID->ViewCustomAttributes = "";

		// pr_Barcode
		$this->pr_Barcode->ViewValue = $this->pr_Barcode->CurrentValue;
		$this->pr_Barcode->ViewCustomAttributes = "";

		// pr_Activated
		$this->pr_Activated->ViewValue = $this->pr_Activated->CurrentValue;
		$this->pr_Activated->ViewValue = ew_FormatDateTime($this->pr_Activated->ViewValue, 7);
		$this->pr_Activated->ViewCustomAttributes = "";

		// pr_Status
		if (strval($this->pr_Status->CurrentValue) <> "") {
			$sFilterWrk = "`ps_ID`" . ew_SearchString("=", $this->pr_Status->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pr_Status, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pr_Status->ViewValue = $this->pr_Status->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pr_Status->ViewValue = $this->pr_Status->CurrentValue;
			}
		} else {
			$this->pr_Status->ViewValue = NULL;
		}
		$this->pr_Status->ViewCustomAttributes = "";

		// pr_PO
		$this->pr_PO->ViewValue = $this->pr_PO->CurrentValue;
		$this->pr_PO->ViewCustomAttributes = "";

		// pr_Cost
		$this->pr_Cost->ViewValue = $this->pr_Cost->CurrentValue;
		$this->pr_Cost->ViewCustomAttributes = "";

		// pr_intStatus
		if (strval($this->pr_intStatus->CurrentValue) <> "") {
			$sFilterWrk = "`in_ID`" . ew_SearchString("=", $this->pr_intStatus->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_intStatus`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pr_intStatus, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pr_intStatus->ViewValue = $this->pr_intStatus->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pr_intStatus->ViewValue = $this->pr_intStatus->CurrentValue;
			}
		} else {
			$this->pr_intStatus->ViewValue = NULL;
		}
		$this->pr_intStatus->ViewCustomAttributes = "";

			// pr_ID
			$this->pr_ID->LinkCustomAttributes = "";
			$this->pr_ID->HrefValue = "";
			$this->pr_ID->TooltipValue = "";

			// pn_ID
			$this->pn_ID->LinkCustomAttributes = "";
			$this->pn_ID->HrefValue = "";
			$this->pn_ID->TooltipValue = "";

			// pr_Barcode
			$this->pr_Barcode->LinkCustomAttributes = "";
			$this->pr_Barcode->HrefValue = "";
			$this->pr_Barcode->TooltipValue = "";

			// pr_Activated
			$this->pr_Activated->LinkCustomAttributes = "";
			$this->pr_Activated->HrefValue = "";
			$this->pr_Activated->TooltipValue = "";

			// pr_Status
			$this->pr_Status->LinkCustomAttributes = "";
			$this->pr_Status->HrefValue = "";
			$this->pr_Status->TooltipValue = "";

			// pr_PO
			$this->pr_PO->LinkCustomAttributes = "";
			$this->pr_PO->HrefValue = "";
			$this->pr_PO->TooltipValue = "";

			// pr_Cost
			$this->pr_Cost->LinkCustomAttributes = "";
			$this->pr_Cost->HrefValue = "";
			$this->pr_Cost->TooltipValue = "";

			// pr_intStatus
			$this->pr_intStatus->LinkCustomAttributes = "";
			$this->pr_intStatus->HrefValue = "";
			$this->pr_intStatus->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// pr_ID
			$this->pr_ID->EditAttrs["class"] = "form-control";
			$this->pr_ID->EditCustomAttributes = "";
			$this->pr_ID->EditValue = $this->pr_ID->CurrentValue;
			$this->pr_ID->ViewCustomAttributes = "";

			// pn_ID
			$this->pn_ID->EditCustomAttributes = "";
			if ($this->pn_ID->getSessionValue() <> "") {
				$this->pn_ID->CurrentValue = $this->pn_ID->getSessionValue();
			if (strval($this->pn_ID->CurrentValue) <> "") {
				$sFilterWrk = "`pn_ID`" . ew_SearchString("=", $this->pn_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `pn_ID`, `pn_ProductName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_PartNum`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pn_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->pn_ID->ViewValue = $this->pn_ID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->pn_ID->ViewValue = $this->pn_ID->CurrentValue;
				}
			} else {
				$this->pn_ID->ViewValue = NULL;
			}
			$this->pn_ID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->pn_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`pn_ID`" . ew_SearchString("=", $this->pn_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `pn_ID`, `pn_ProductName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_PartNum`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pn_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->pn_ID->ViewValue = $this->pn_ID->DisplayValue($arwrk);
			} else {
				$this->pn_ID->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pn_ID->EditValue = $arwrk;
			}

			// pr_Barcode
			$this->pr_Barcode->EditAttrs["class"] = "form-control";
			$this->pr_Barcode->EditCustomAttributes = "";
			$this->pr_Barcode->EditValue = ew_HtmlEncode($this->pr_Barcode->CurrentValue);
			$this->pr_Barcode->PlaceHolder = ew_RemoveHtml($this->pr_Barcode->FldCaption());

			// pr_Activated
			$this->pr_Activated->EditAttrs["class"] = "form-control";
			$this->pr_Activated->EditCustomAttributes = "";
			$this->pr_Activated->EditValue = $this->pr_Activated->CurrentValue;
			$this->pr_Activated->EditValue = ew_FormatDateTime($this->pr_Activated->EditValue, 7);
			$this->pr_Activated->ViewCustomAttributes = "";

			// pr_Status
			$this->pr_Status->EditAttrs["class"] = "form-control";
			$this->pr_Status->EditCustomAttributes = "";
			if (strval($this->pr_Status->CurrentValue) <> "") {
				$sFilterWrk = "`ps_ID`" . ew_SearchString("=", $this->pr_Status->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pr_Status, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->pr_Status->EditValue = $this->pr_Status->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->pr_Status->EditValue = $this->pr_Status->CurrentValue;
				}
			} else {
				$this->pr_Status->EditValue = NULL;
			}
			$this->pr_Status->ViewCustomAttributes = "";

			// pr_PO
			$this->pr_PO->EditAttrs["class"] = "form-control";
			$this->pr_PO->EditCustomAttributes = "";
			$this->pr_PO->EditValue = $this->pr_PO->CurrentValue;
			$this->pr_PO->ViewCustomAttributes = "";

			// pr_Cost
			$this->pr_Cost->EditAttrs["class"] = "form-control";
			$this->pr_Cost->EditCustomAttributes = "";
			$this->pr_Cost->EditValue = ew_HtmlEncode($this->pr_Cost->CurrentValue);
			$this->pr_Cost->PlaceHolder = ew_RemoveHtml($this->pr_Cost->FldCaption());
			if (strval($this->pr_Cost->EditValue) <> "" && is_numeric($this->pr_Cost->EditValue)) $this->pr_Cost->EditValue = ew_FormatNumber($this->pr_Cost->EditValue, -2, -1, -2, 0);

			// pr_intStatus
			$this->pr_intStatus->EditCustomAttributes = "";
			if (trim(strval($this->pr_intStatus->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`in_ID`" . ew_SearchString("=", $this->pr_intStatus->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_intStatus`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pr_intStatus, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->pr_intStatus->ViewValue = $this->pr_intStatus->DisplayValue($arwrk);
			} else {
				$this->pr_intStatus->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pr_intStatus->EditValue = $arwrk;

			// Edit refer script
			// pr_ID

			$this->pr_ID->LinkCustomAttributes = "";
			$this->pr_ID->HrefValue = "";

			// pn_ID
			$this->pn_ID->LinkCustomAttributes = "";
			$this->pn_ID->HrefValue = "";

			// pr_Barcode
			$this->pr_Barcode->LinkCustomAttributes = "";
			$this->pr_Barcode->HrefValue = "";

			// pr_Activated
			$this->pr_Activated->LinkCustomAttributes = "";
			$this->pr_Activated->HrefValue = "";
			$this->pr_Activated->TooltipValue = "";

			// pr_Status
			$this->pr_Status->LinkCustomAttributes = "";
			$this->pr_Status->HrefValue = "";
			$this->pr_Status->TooltipValue = "";

			// pr_PO
			$this->pr_PO->LinkCustomAttributes = "";
			$this->pr_PO->HrefValue = "";
			$this->pr_PO->TooltipValue = "";

			// pr_Cost
			$this->pr_Cost->LinkCustomAttributes = "";
			$this->pr_Cost->HrefValue = "";

			// pr_intStatus
			$this->pr_intStatus->LinkCustomAttributes = "";
			$this->pr_intStatus->HrefValue = "";
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
		if (!$this->pn_ID->FldIsDetailKey && !is_null($this->pn_ID->FormValue) && $this->pn_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pn_ID->FldCaption(), $this->pn_ID->ReqErrMsg));
		}
		if (!$this->pr_Barcode->FldIsDetailKey && !is_null($this->pr_Barcode->FormValue) && $this->pr_Barcode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_Barcode->FldCaption(), $this->pr_Barcode->ReqErrMsg));
		}
		if (!$this->pr_Cost->FldIsDetailKey && !is_null($this->pr_Cost->FormValue) && $this->pr_Cost->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_Cost->FldCaption(), $this->pr_Cost->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->pr_Cost->FormValue)) {
			ew_AddMessage($gsFormError, $this->pr_Cost->FldErrMsg());
		}
		if (!$this->pr_intStatus->FldIsDetailKey && !is_null($this->pr_intStatus->FormValue) && $this->pr_intStatus->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_intStatus->FldCaption(), $this->pr_intStatus->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("transaction_Movement", $DetailTblVar) && $GLOBALS["transaction_Movement"]->DetailEdit) {
			if (!isset($GLOBALS["transaction_Movement_grid"])) $GLOBALS["transaction_Movement_grid"] = new ctransaction_Movement_grid(); // get detail page object
			$GLOBALS["transaction_Movement_grid"]->ValidateGridForm();
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
		if ($this->pr_Barcode->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`pr_Barcode` = '" . ew_AdjustSql($this->pr_Barcode->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->pr_Barcode->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->pr_Barcode->CurrentValue, $sIdxErrMsg);
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// pn_ID
			$this->pn_ID->SetDbValueDef($rsnew, $this->pn_ID->CurrentValue, 0, $this->pn_ID->ReadOnly);

			// pr_Barcode
			$this->pr_Barcode->SetDbValueDef($rsnew, $this->pr_Barcode->CurrentValue, "", $this->pr_Barcode->ReadOnly);

			// pr_Cost
			$this->pr_Cost->SetDbValueDef($rsnew, $this->pr_Cost->CurrentValue, 0, $this->pr_Cost->ReadOnly);

			// pr_intStatus
			$this->pr_intStatus->SetDbValueDef($rsnew, $this->pr_intStatus->CurrentValue, 0, $this->pr_intStatus->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("transaction_Movement", $DetailTblVar) && $GLOBALS["transaction_Movement"]->DetailEdit) {
						if (!isset($GLOBALS["transaction_Movement_grid"])) $GLOBALS["transaction_Movement_grid"] = new ctransaction_Movement_grid(); // Get detail page object
						$EditRow = $GLOBALS["transaction_Movement_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if ($sMasterTblVar == "main_PartNum") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_pn_ID"] <> "") {
					$GLOBALS["main_PartNum"]->pn_ID->setQueryStringValue($_GET["fk_pn_ID"]);
					$this->pn_ID->setQueryStringValue($GLOBALS["main_PartNum"]->pn_ID->QueryStringValue);
					$this->pn_ID->setSessionValue($this->pn_ID->QueryStringValue);
					if (!is_numeric($GLOBALS["main_PartNum"]->pn_ID->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "main_PartNum") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_pn_ID"] <> "") {
					$GLOBALS["main_PartNum"]->pn_ID->setFormValue($_POST["fk_pn_ID"]);
					$this->pn_ID->setFormValue($GLOBALS["main_PartNum"]->pn_ID->FormValue);
					$this->pn_ID->setSessionValue($this->pn_ID->FormValue);
					if (!is_numeric($GLOBALS["main_PartNum"]->pn_ID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "main_PartNum") {
				if ($this->pn_ID->CurrentValue == "") $this->pn_ID->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
			if (in_array("transaction_Movement", $DetailTblVar)) {
				if (!isset($GLOBALS["transaction_Movement_grid"]))
					$GLOBALS["transaction_Movement_grid"] = new ctransaction_Movement_grid;
				if ($GLOBALS["transaction_Movement_grid"]->DetailEdit) {
					$GLOBALS["transaction_Movement_grid"]->CurrentMode = "edit";
					$GLOBALS["transaction_Movement_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["transaction_Movement_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["transaction_Movement_grid"]->setStartRecordNumber(1);
					$GLOBALS["transaction_Movement_grid"]->pr_ID->FldIsDetailKey = TRUE;
					$GLOBALS["transaction_Movement_grid"]->pr_ID->CurrentValue = $this->pr_ID->CurrentValue;
					$GLOBALS["transaction_Movement_grid"]->pr_ID->setSessionValue($GLOBALS["transaction_Movement_grid"]->pr_ID->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("main_product_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($main_Product_edit)) $main_Product_edit = new cmain_Product_edit();

// Page init
$main_Product_edit->Page_Init();

// Page main
$main_Product_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_Product_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fmain_Productedit = new ew_Form("fmain_Productedit", "edit");

// Validate form
fmain_Productedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pn_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pn_ID->FldCaption(), $main_Product->pn_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Barcode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Barcode->FldCaption(), $main_Product->pr_Barcode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Cost");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Cost->FldCaption(), $main_Product->pr_Cost->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Cost");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($main_Product->pr_Cost->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pr_intStatus");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_intStatus->FldCaption(), $main_Product->pr_intStatus->ReqErrMsg)) ?>");

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
fmain_Productedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Productedit.ValidateRequired = true;
<?php } else { ?>
fmain_Productedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Productedit.Lists["x_pn_ID"] = {"LinkField":"x_pn_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_pn_ProductName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Productedit.Lists["x_pr_Status"] = {"LinkField":"x_ps_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_ps_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Productedit.Lists["x_pr_intStatus"] = {"LinkField":"x_in_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_in_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $main_Product_edit->ShowPageHeader(); ?>
<?php
$main_Product_edit->ShowMessage();
?>
<form name="fmain_Productedit" id="fmain_Productedit" class="<?php echo $main_Product_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_Product_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_Product_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_Product">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($main_Product->getCurrentMasterTable() == "main_PartNum") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="main_PartNum">
<input type="hidden" name="fk_pn_ID" value="<?php echo $main_Product->pn_ID->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($main_Product->pr_ID->Visible) { // pr_ID ?>
	<div id="r_pr_ID" class="form-group">
		<label id="elh_main_Product_pr_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_ID->CellAttributes() ?>>
<span id="el_main_Product_pr_ID">
<span<?php echo $main_Product->pr_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="x_pr_ID" id="x_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->CurrentValue) ?>">
<?php echo $main_Product->pr_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pn_ID->Visible) { // pn_ID ?>
	<div id="r_pn_ID" class="form-group">
		<label id="elh_main_Product_pn_ID" for="x_pn_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pn_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pn_ID->CellAttributes() ?>>
<?php if ($main_Product->pn_ID->getSessionValue() <> "") { ?>
<span id="el_main_Product_pn_ID">
<span<?php echo $main_Product->pn_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pn_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_pn_ID" name="x_pn_ID" value="<?php echo ew_HtmlEncode($main_Product->pn_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_main_Product_pn_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pn_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_pn_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_Product->pn_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pn_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pn_ID" name="x_pn_ID" id="x_pn_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pn_ID->EditAttributes() ?>><?php echo $main_Product->pn_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pn_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pn_ID" name="x_pn_ID" id="x_pn_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pn_ID->CurrentValue) ?>" checked<?php echo $main_Product->pn_ID->EditAttributes() ?>><?php echo $main_Product->pn_ID->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_pn_ID" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pn_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pn_ID->DisplayValueSeparator) ? json_encode($main_Product->pn_ID->DisplayValueSeparator) : $main_Product->pn_ID->DisplayValueSeparator) ?>" name="x_pn_ID" id="x_pn_ID" value="{value}"<?php echo $main_Product->pn_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `pn_ID`, `pn_ProductName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_PartNum`";
$sWhereWrk = "";
$main_Product->pn_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pn_ID->LookupFilters += array("f0" => "`pn_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pn_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pn_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_pn_ID" id="s_x_pn_ID" value="<?php echo $main_Product->pn_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $main_Product->pn_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
	<div id="r_pr_Barcode" class="form-group">
		<label id="elh_main_Product_pr_Barcode" for="x_pr_Barcode" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_Barcode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_Barcode->CellAttributes() ?>>
<span id="el_main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x_pr_Barcode" id="x_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<?php echo $main_Product->pr_Barcode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
	<div id="r_pr_Activated" class="form-group">
		<label id="elh_main_Product_pr_Activated" for="x_pr_Activated" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_Activated->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_Activated->CellAttributes() ?>>
<span id="el_main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Activated->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="x_pr_Activated" id="x_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->CurrentValue) ?>">
<?php echo $main_Product->pr_Activated->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
	<div id="r_pr_Status" class="form-group">
		<label id="elh_main_Product_pr_Status" for="x_pr_Status" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_Status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_Status->CellAttributes() ?>>
<span id="el_main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Status->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="x_pr_Status" id="x_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>">
<?php echo $main_Product->pr_Status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
	<div id="r_pr_PO" class="form-group">
		<label id="elh_main_Product_pr_PO" for="x_pr_PO" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_PO->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_PO->CellAttributes() ?>>
<span id="el_main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_PO->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="x_pr_PO" id="x_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->CurrentValue) ?>">
<?php echo $main_Product->pr_PO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
	<div id="r_pr_Cost" class="form-group">
		<label id="elh_main_Product_pr_Cost" for="x_pr_Cost" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_Cost->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_Cost->CellAttributes() ?>>
<span id="el_main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x_pr_Cost" id="x_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<?php echo $main_Product->pr_Cost->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
	<div id="r_pr_intStatus" class="form-group">
		<label id="elh_main_Product_pr_intStatus" for="x_pr_intStatus" class="col-sm-2 control-label ewLabel"><?php echo $main_Product->pr_intStatus->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Product->pr_intStatus->CellAttributes() ?>>
<span id="el_main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_intStatus->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_intStatus->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x_pr_intStatus" id="x_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x_pr_intStatus" id="x_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x_pr_intStatus" id="x_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `in_ID`, `in_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_intStatus`";
$sWhereWrk = "";
$main_Product->pr_intStatus->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_intStatus->LookupFilters += array("f0" => "`in_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_intStatus, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_intStatus->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_pr_intStatus" id="s_x_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<?php echo $main_Product->pr_intStatus->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("transaction_Movement", explode(",", $main_Product->getCurrentDetailTable())) && $transaction_Movement->DetailEdit) {
?>
<?php if ($main_Product->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("transaction_Movement", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "transaction_movement_grid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $main_Product_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmain_Productedit.Init();
</script>
<?php
$main_Product_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$main_Product_edit->Page_Terminate();
?>
