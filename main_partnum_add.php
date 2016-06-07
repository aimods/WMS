<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "main_partnum_info.php" ?>
<?php include_once "main_brand_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "main_vendor_info.php" ?>
<?php include_once "main_product_gridcls.php" ?>
<?php include_once "stockcard_gridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$main_PartNum_add = NULL; // Initialize page object first

class cmain_PartNum_add extends cmain_PartNum {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_PartNum';

	// Page object name
	var $PageObjName = 'main_PartNum_add';

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

		// Table object (main_PartNum)
		if (!isset($GLOBALS["main_PartNum"]) || get_class($GLOBALS["main_PartNum"]) == "cmain_PartNum") {
			$GLOBALS["main_PartNum"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_PartNum"];
		}

		// Table object (main_Brand)
		if (!isset($GLOBALS['main_Brand'])) $GLOBALS['main_Brand'] = new cmain_Brand();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Table object (main_Vendor)
		if (!isset($GLOBALS['main_Vendor'])) $GLOBALS['main_Vendor'] = new cmain_Vendor();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'main_PartNum', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("main_partnum_list.php"));
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

			// Process auto fill for detail table 'main_Product'
			if (@$_POST["grid"] == "fmain_Productgrid") {
				if (!isset($GLOBALS["main_Product_grid"])) $GLOBALS["main_Product_grid"] = new cmain_Product_grid;
				$GLOBALS["main_Product_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'StockCard'
			if (@$_POST["grid"] == "fStockCardgrid") {
				if (!isset($GLOBALS["StockCard_grid"])) $GLOBALS["StockCard_grid"] = new cStockCard_grid;
				$GLOBALS["StockCard_grid"]->Page_Init();
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
		global $EW_EXPORT, $main_PartNum;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($main_PartNum);
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
			if (@$_GET["pn_ID"] != "") {
				$this->pn_ID->setQueryStringValue($_GET["pn_ID"]);
				$this->setKey("pn_ID", $this->pn_ID->CurrentValue); // Set up key
			} else {
				$this->setKey("pn_ID", ""); // Clear key
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
					$this->Page_Terminate("main_partnum_list.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "main_partnum_list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "main_partnum_view.php")
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
		$this->pn_Manual->Upload->Index = $objForm->Index;
		$this->pn_Manual->Upload->UploadFile();
		$this->pn_Manual->CurrentValue = $this->pn_Manual->Upload->FileName;
		$this->pn_PhotoCommercial->Upload->Index = $objForm->Index;
		$this->pn_PhotoCommercial->Upload->UploadFile();
		$this->pn_PhotoCommercial->CurrentValue = $this->pn_PhotoCommercial->Upload->FileName;
		$this->pn_PhotoTechnical->Upload->Index = $objForm->Index;
		$this->pn_PhotoTechnical->Upload->UploadFile();
		$this->pn_PhotoTechnical->CurrentValue = $this->pn_PhotoTechnical->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->pn_Barcode->CurrentValue = NULL;
		$this->pn_Barcode->OldValue = $this->pn_Barcode->CurrentValue;
		$this->v_ID->CurrentValue = NULL;
		$this->v_ID->OldValue = $this->v_ID->CurrentValue;
		$this->b_ID->CurrentValue = NULL;
		$this->b_ID->OldValue = $this->b_ID->CurrentValue;
		$this->pn_ProductName->CurrentValue = NULL;
		$this->pn_ProductName->OldValue = $this->pn_ProductName->CurrentValue;
		$this->pn_Version->CurrentValue = NULL;
		$this->pn_Version->OldValue = $this->pn_Version->CurrentValue;
		$this->pn_Spec->CurrentValue = NULL;
		$this->pn_Spec->OldValue = $this->pn_Spec->CurrentValue;
		$this->pn_Manual->Upload->DbValue = NULL;
		$this->pn_Manual->OldValue = $this->pn_Manual->Upload->DbValue;
		$this->pn_Manual->CurrentValue = NULL; // Clear file related field
		$this->pn_PhotoCommercial->Upload->DbValue = NULL;
		$this->pn_PhotoCommercial->OldValue = $this->pn_PhotoCommercial->Upload->DbValue;
		$this->pn_PhotoCommercial->CurrentValue = NULL; // Clear file related field
		$this->pn_PhotoTechnical->Upload->DbValue = NULL;
		$this->pn_PhotoTechnical->OldValue = $this->pn_PhotoTechnical->Upload->DbValue;
		$this->pn_PhotoTechnical->CurrentValue = NULL; // Clear file related field
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->pn_Barcode->FldIsDetailKey) {
			$this->pn_Barcode->setFormValue($objForm->GetValue("x_pn_Barcode"));
		}
		if (!$this->v_ID->FldIsDetailKey) {
			$this->v_ID->setFormValue($objForm->GetValue("x_v_ID"));
		}
		if (!$this->b_ID->FldIsDetailKey) {
			$this->b_ID->setFormValue($objForm->GetValue("x_b_ID"));
		}
		if (!$this->pn_ProductName->FldIsDetailKey) {
			$this->pn_ProductName->setFormValue($objForm->GetValue("x_pn_ProductName"));
		}
		if (!$this->pn_Version->FldIsDetailKey) {
			$this->pn_Version->setFormValue($objForm->GetValue("x_pn_Version"));
		}
		if (!$this->pn_Spec->FldIsDetailKey) {
			$this->pn_Spec->setFormValue($objForm->GetValue("x_pn_Spec"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->pn_Barcode->CurrentValue = $this->pn_Barcode->FormValue;
		$this->v_ID->CurrentValue = $this->v_ID->FormValue;
		$this->b_ID->CurrentValue = $this->b_ID->FormValue;
		$this->pn_ProductName->CurrentValue = $this->pn_ProductName->FormValue;
		$this->pn_Version->CurrentValue = $this->pn_Version->FormValue;
		$this->pn_Spec->CurrentValue = $this->pn_Spec->FormValue;
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
		$this->pn_ID->setDbValue($rs->fields('pn_ID'));
		$this->pn_Barcode->setDbValue($rs->fields('pn_Barcode'));
		$this->v_ID->setDbValue($rs->fields('v_ID'));
		$this->b_ID->setDbValue($rs->fields('b_ID'));
		$this->pn_ProductName->setDbValue($rs->fields('pn_ProductName'));
		$this->pn_Version->setDbValue($rs->fields('pn_Version'));
		$this->pn_Spec->setDbValue($rs->fields('pn_Spec'));
		$this->pn_Manual->Upload->DbValue = $rs->fields('pn_Manual');
		$this->pn_Manual->CurrentValue = $this->pn_Manual->Upload->DbValue;
		$this->b_Created->setDbValue($rs->fields('b_Created'));
		$this->b_Updated->setDbValue($rs->fields('b_Updated'));
		$this->pn_PhotoCommercial->Upload->DbValue = $rs->fields('pn_PhotoCommercial');
		$this->pn_PhotoCommercial->CurrentValue = $this->pn_PhotoCommercial->Upload->DbValue;
		$this->pn_PhotoTechnical->Upload->DbValue = $rs->fields('pn_PhotoTechnical');
		$this->pn_PhotoTechnical->CurrentValue = $this->pn_PhotoTechnical->Upload->DbValue;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->pn_ID->DbValue = $row['pn_ID'];
		$this->pn_Barcode->DbValue = $row['pn_Barcode'];
		$this->v_ID->DbValue = $row['v_ID'];
		$this->b_ID->DbValue = $row['b_ID'];
		$this->pn_ProductName->DbValue = $row['pn_ProductName'];
		$this->pn_Version->DbValue = $row['pn_Version'];
		$this->pn_Spec->DbValue = $row['pn_Spec'];
		$this->pn_Manual->Upload->DbValue = $row['pn_Manual'];
		$this->b_Created->DbValue = $row['b_Created'];
		$this->b_Updated->DbValue = $row['b_Updated'];
		$this->pn_PhotoCommercial->Upload->DbValue = $row['pn_PhotoCommercial'];
		$this->pn_PhotoTechnical->Upload->DbValue = $row['pn_PhotoTechnical'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("pn_ID")) <> "")
			$this->pn_ID->CurrentValue = $this->getKey("pn_ID"); // pn_ID
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
		// pn_ID
		// pn_Barcode
		// v_ID
		// b_ID
		// pn_ProductName
		// pn_Version
		// pn_Spec
		// pn_Manual
		// b_Created
		// b_Updated
		// pn_PhotoCommercial
		// pn_PhotoTechnical

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// pn_Barcode
		$this->pn_Barcode->ViewValue = $this->pn_Barcode->CurrentValue;
		$this->pn_Barcode->ViewCustomAttributes = "";

		// v_ID
		if (strval($this->v_ID->CurrentValue) <> "") {
			$sFilterWrk = "`v_ID`" . ew_SearchString("=", $this->v_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->v_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `v_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->v_ID->ViewValue = $this->v_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->v_ID->ViewValue = $this->v_ID->CurrentValue;
			}
		} else {
			$this->v_ID->ViewValue = NULL;
		}
		$this->v_ID->ViewCustomAttributes = "";

		// b_ID
		if (strval($this->b_ID->CurrentValue) <> "") {
			$sFilterWrk = "`b_ID`" . ew_SearchString("=", $this->b_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->b_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `b_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->b_ID->ViewValue = $this->b_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->b_ID->ViewValue = $this->b_ID->CurrentValue;
			}
		} else {
			$this->b_ID->ViewValue = NULL;
		}
		$this->b_ID->ViewCustomAttributes = "";

		// pn_ProductName
		$this->pn_ProductName->ViewValue = $this->pn_ProductName->CurrentValue;
		$this->pn_ProductName->ViewCustomAttributes = "";

		// pn_Version
		$this->pn_Version->ViewValue = $this->pn_Version->CurrentValue;
		$this->pn_Version->ViewCustomAttributes = "";

		// pn_Spec
		$this->pn_Spec->ViewValue = $this->pn_Spec->CurrentValue;
		$this->pn_Spec->ViewCustomAttributes = "";

		// pn_Manual
		$this->pn_Manual->UploadPath = files/manual;
		if (!ew_Empty($this->pn_Manual->Upload->DbValue)) {
			$this->pn_Manual->ViewValue = $this->pn_Manual->Upload->DbValue;
		} else {
			$this->pn_Manual->ViewValue = "";
		}
		$this->pn_Manual->ViewCustomAttributes = "";

		// pn_PhotoCommercial
		$this->pn_PhotoCommercial->UploadPath = files/products;
		if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
			$this->pn_PhotoCommercial->ImageAlt = $this->pn_PhotoCommercial->FldAlt();
			$this->pn_PhotoCommercial->ViewValue = $this->pn_PhotoCommercial->Upload->DbValue;
		} else {
			$this->pn_PhotoCommercial->ViewValue = "";
		}
		$this->pn_PhotoCommercial->ViewCustomAttributes = "";

		// pn_PhotoTechnical
		$this->pn_PhotoTechnical->UploadPath = files/technical/images;
		if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
			$this->pn_PhotoTechnical->ImageAlt = $this->pn_PhotoTechnical->FldAlt();
			$this->pn_PhotoTechnical->ViewValue = $this->pn_PhotoTechnical->Upload->DbValue;
		} else {
			$this->pn_PhotoTechnical->ViewValue = "";
		}
		$this->pn_PhotoTechnical->ViewCustomAttributes = "";

			// pn_Barcode
			$this->pn_Barcode->LinkCustomAttributes = "";
			$this->pn_Barcode->HrefValue = "";
			$this->pn_Barcode->TooltipValue = "";

			// v_ID
			$this->v_ID->LinkCustomAttributes = "";
			$this->v_ID->HrefValue = "";
			$this->v_ID->TooltipValue = "";

			// b_ID
			$this->b_ID->LinkCustomAttributes = "";
			$this->b_ID->HrefValue = "";
			$this->b_ID->TooltipValue = "";

			// pn_ProductName
			$this->pn_ProductName->LinkCustomAttributes = "";
			$this->pn_ProductName->HrefValue = "";
			$this->pn_ProductName->TooltipValue = "";

			// pn_Version
			$this->pn_Version->LinkCustomAttributes = "";
			$this->pn_Version->HrefValue = "";
			$this->pn_Version->TooltipValue = "";

			// pn_Spec
			$this->pn_Spec->LinkCustomAttributes = "";
			$this->pn_Spec->HrefValue = "";
			$this->pn_Spec->TooltipValue = "";

			// pn_Manual
			$this->pn_Manual->LinkCustomAttributes = "";
			$this->pn_Manual->HrefValue = "";
			$this->pn_Manual->HrefValue2 = $this->pn_Manual->UploadPath . $this->pn_Manual->Upload->DbValue;
			$this->pn_Manual->TooltipValue = "";

			// pn_PhotoCommercial
			$this->pn_PhotoCommercial->LinkCustomAttributes = "";
			$this->pn_PhotoCommercial->UploadPath = files/products;
			if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
				$this->pn_PhotoCommercial->HrefValue = ew_GetFileUploadUrl($this->pn_PhotoCommercial, $this->pn_PhotoCommercial->Upload->DbValue); // Add prefix/suffix
				$this->pn_PhotoCommercial->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->pn_PhotoCommercial->HrefValue = ew_ConvertFullUrl($this->pn_PhotoCommercial->HrefValue);
			} else {
				$this->pn_PhotoCommercial->HrefValue = "";
			}
			$this->pn_PhotoCommercial->HrefValue2 = $this->pn_PhotoCommercial->UploadPath . $this->pn_PhotoCommercial->Upload->DbValue;
			$this->pn_PhotoCommercial->TooltipValue = "";
			if ($this->pn_PhotoCommercial->UseColorbox) {
				if (ew_Empty($this->pn_PhotoCommercial->TooltipValue))
					$this->pn_PhotoCommercial->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->pn_PhotoCommercial->LinkAttrs["data-rel"] = "main_PartNum_x_pn_PhotoCommercial";
				ew_AppendClass($this->pn_PhotoCommercial->LinkAttrs["class"], "ewLightbox");
			}

			// pn_PhotoTechnical
			$this->pn_PhotoTechnical->LinkCustomAttributes = "";
			$this->pn_PhotoTechnical->UploadPath = files/technical/images;
			if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
				$this->pn_PhotoTechnical->HrefValue = "%u"; // Add prefix/suffix
				$this->pn_PhotoTechnical->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->pn_PhotoTechnical->HrefValue = ew_ConvertFullUrl($this->pn_PhotoTechnical->HrefValue);
			} else {
				$this->pn_PhotoTechnical->HrefValue = "";
			}
			$this->pn_PhotoTechnical->HrefValue2 = $this->pn_PhotoTechnical->UploadPath . $this->pn_PhotoTechnical->Upload->DbValue;
			$this->pn_PhotoTechnical->TooltipValue = "";
			if ($this->pn_PhotoTechnical->UseColorbox) {
				if (ew_Empty($this->pn_PhotoTechnical->TooltipValue))
					$this->pn_PhotoTechnical->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->pn_PhotoTechnical->LinkAttrs["data-rel"] = "main_PartNum_x_pn_PhotoTechnical";
				ew_AppendClass($this->pn_PhotoTechnical->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pn_Barcode
			$this->pn_Barcode->EditAttrs["class"] = "form-control";
			$this->pn_Barcode->EditCustomAttributes = "";
			$this->pn_Barcode->EditValue = ew_HtmlEncode($this->pn_Barcode->CurrentValue);
			$this->pn_Barcode->PlaceHolder = ew_RemoveHtml($this->pn_Barcode->FldCaption());

			// v_ID
			$this->v_ID->EditCustomAttributes = "";
			if ($this->v_ID->getSessionValue() <> "") {
				$this->v_ID->CurrentValue = $this->v_ID->getSessionValue();
			if (strval($this->v_ID->CurrentValue) <> "") {
				$sFilterWrk = "`v_ID`" . ew_SearchString("=", $this->v_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->v_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `v_Name` ASC";
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->v_ID->ViewValue = $this->v_ID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->v_ID->ViewValue = $this->v_ID->CurrentValue;
				}
			} else {
				$this->v_ID->ViewValue = NULL;
			}
			$this->v_ID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->v_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`v_ID`" . ew_SearchString("=", $this->v_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_Vendor`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->v_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `v_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->v_ID->ViewValue = $this->v_ID->DisplayValue($arwrk);
			} else {
				$this->v_ID->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->v_ID->EditValue = $arwrk;
			}

			// b_ID
			$this->b_ID->EditCustomAttributes = "";
			if ($this->b_ID->getSessionValue() <> "") {
				$this->b_ID->CurrentValue = $this->b_ID->getSessionValue();
			if (strval($this->b_ID->CurrentValue) <> "") {
				$sFilterWrk = "`b_ID`" . ew_SearchString("=", $this->b_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->b_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `b_Name` ASC";
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->b_ID->ViewValue = $this->b_ID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->b_ID->ViewValue = $this->b_ID->CurrentValue;
				}
			} else {
				$this->b_ID->ViewValue = NULL;
			}
			$this->b_ID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->b_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`b_ID`" . ew_SearchString("=", $this->b_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `main_Brand`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->b_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `b_Name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->b_ID->ViewValue = $this->b_ID->DisplayValue($arwrk);
			} else {
				$this->b_ID->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->b_ID->EditValue = $arwrk;
			}

			// pn_ProductName
			$this->pn_ProductName->EditAttrs["class"] = "form-control";
			$this->pn_ProductName->EditCustomAttributes = "";
			$this->pn_ProductName->EditValue = ew_HtmlEncode($this->pn_ProductName->CurrentValue);
			$this->pn_ProductName->PlaceHolder = ew_RemoveHtml($this->pn_ProductName->FldCaption());

			// pn_Version
			$this->pn_Version->EditAttrs["class"] = "form-control";
			$this->pn_Version->EditCustomAttributes = "";
			$this->pn_Version->EditValue = ew_HtmlEncode($this->pn_Version->CurrentValue);
			$this->pn_Version->PlaceHolder = ew_RemoveHtml($this->pn_Version->FldCaption());

			// pn_Spec
			$this->pn_Spec->EditAttrs["class"] = "form-control";
			$this->pn_Spec->EditCustomAttributes = "";
			$this->pn_Spec->EditValue = ew_HtmlEncode($this->pn_Spec->CurrentValue);
			$this->pn_Spec->PlaceHolder = ew_RemoveHtml($this->pn_Spec->FldCaption());

			// pn_Manual
			$this->pn_Manual->EditAttrs["class"] = "form-control";
			$this->pn_Manual->EditCustomAttributes = "";
			$this->pn_Manual->UploadPath = files/manual;
			if (!ew_Empty($this->pn_Manual->Upload->DbValue)) {
				$this->pn_Manual->EditValue = $this->pn_Manual->Upload->DbValue;
			} else {
				$this->pn_Manual->EditValue = "";
			}
			if (!ew_Empty($this->pn_Manual->CurrentValue))
				$this->pn_Manual->Upload->FileName = $this->pn_Manual->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->pn_Manual);

			// pn_PhotoCommercial
			$this->pn_PhotoCommercial->EditAttrs["class"] = "form-control";
			$this->pn_PhotoCommercial->EditCustomAttributes = "";
			$this->pn_PhotoCommercial->UploadPath = files/products;
			if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
				$this->pn_PhotoCommercial->ImageAlt = $this->pn_PhotoCommercial->FldAlt();
				$this->pn_PhotoCommercial->EditValue = $this->pn_PhotoCommercial->Upload->DbValue;
			} else {
				$this->pn_PhotoCommercial->EditValue = "";
			}
			if (!ew_Empty($this->pn_PhotoCommercial->CurrentValue))
				$this->pn_PhotoCommercial->Upload->FileName = $this->pn_PhotoCommercial->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->pn_PhotoCommercial);

			// pn_PhotoTechnical
			$this->pn_PhotoTechnical->EditAttrs["class"] = "form-control";
			$this->pn_PhotoTechnical->EditCustomAttributes = "";
			$this->pn_PhotoTechnical->UploadPath = files/technical/images;
			if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
				$this->pn_PhotoTechnical->ImageAlt = $this->pn_PhotoTechnical->FldAlt();
				$this->pn_PhotoTechnical->EditValue = $this->pn_PhotoTechnical->Upload->DbValue;
			} else {
				$this->pn_PhotoTechnical->EditValue = "";
			}
			if (!ew_Empty($this->pn_PhotoTechnical->CurrentValue))
				$this->pn_PhotoTechnical->Upload->FileName = $this->pn_PhotoTechnical->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->pn_PhotoTechnical);

			// Add refer script
			// pn_Barcode

			$this->pn_Barcode->LinkCustomAttributes = "";
			$this->pn_Barcode->HrefValue = "";

			// v_ID
			$this->v_ID->LinkCustomAttributes = "";
			$this->v_ID->HrefValue = "";

			// b_ID
			$this->b_ID->LinkCustomAttributes = "";
			$this->b_ID->HrefValue = "";

			// pn_ProductName
			$this->pn_ProductName->LinkCustomAttributes = "";
			$this->pn_ProductName->HrefValue = "";

			// pn_Version
			$this->pn_Version->LinkCustomAttributes = "";
			$this->pn_Version->HrefValue = "";

			// pn_Spec
			$this->pn_Spec->LinkCustomAttributes = "";
			$this->pn_Spec->HrefValue = "";

			// pn_Manual
			$this->pn_Manual->LinkCustomAttributes = "";
			$this->pn_Manual->HrefValue = "";
			$this->pn_Manual->HrefValue2 = $this->pn_Manual->UploadPath . $this->pn_Manual->Upload->DbValue;

			// pn_PhotoCommercial
			$this->pn_PhotoCommercial->LinkCustomAttributes = "";
			$this->pn_PhotoCommercial->UploadPath = files/products;
			if (!ew_Empty($this->pn_PhotoCommercial->Upload->DbValue)) {
				$this->pn_PhotoCommercial->HrefValue = ew_GetFileUploadUrl($this->pn_PhotoCommercial, $this->pn_PhotoCommercial->Upload->DbValue); // Add prefix/suffix
				$this->pn_PhotoCommercial->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->pn_PhotoCommercial->HrefValue = ew_ConvertFullUrl($this->pn_PhotoCommercial->HrefValue);
			} else {
				$this->pn_PhotoCommercial->HrefValue = "";
			}
			$this->pn_PhotoCommercial->HrefValue2 = $this->pn_PhotoCommercial->UploadPath . $this->pn_PhotoCommercial->Upload->DbValue;

			// pn_PhotoTechnical
			$this->pn_PhotoTechnical->LinkCustomAttributes = "";
			$this->pn_PhotoTechnical->UploadPath = files/technical/images;
			if (!ew_Empty($this->pn_PhotoTechnical->Upload->DbValue)) {
				$this->pn_PhotoTechnical->HrefValue = "%u"; // Add prefix/suffix
				$this->pn_PhotoTechnical->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->pn_PhotoTechnical->HrefValue = ew_ConvertFullUrl($this->pn_PhotoTechnical->HrefValue);
			} else {
				$this->pn_PhotoTechnical->HrefValue = "";
			}
			$this->pn_PhotoTechnical->HrefValue2 = $this->pn_PhotoTechnical->UploadPath . $this->pn_PhotoTechnical->Upload->DbValue;
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
		if (!$this->pn_Barcode->FldIsDetailKey && !is_null($this->pn_Barcode->FormValue) && $this->pn_Barcode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pn_Barcode->FldCaption(), $this->pn_Barcode->ReqErrMsg));
		}
		if (!$this->v_ID->FldIsDetailKey && !is_null($this->v_ID->FormValue) && $this->v_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->v_ID->FldCaption(), $this->v_ID->ReqErrMsg));
		}
		if (!$this->pn_ProductName->FldIsDetailKey && !is_null($this->pn_ProductName->FormValue) && $this->pn_ProductName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pn_ProductName->FldCaption(), $this->pn_ProductName->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("main_Product", $DetailTblVar) && $GLOBALS["main_Product"]->DetailAdd) {
			if (!isset($GLOBALS["main_Product_grid"])) $GLOBALS["main_Product_grid"] = new cmain_Product_grid(); // get detail page object
			$GLOBALS["main_Product_grid"]->ValidateGridForm();
		}
		if (in_array("StockCard", $DetailTblVar) && $GLOBALS["StockCard"]->DetailAdd) {
			if (!isset($GLOBALS["StockCard_grid"])) $GLOBALS["StockCard_grid"] = new cStockCard_grid(); // get detail page object
			$GLOBALS["StockCard_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
			$this->pn_Manual->OldUploadPath = files/manual;
			$this->pn_Manual->UploadPath = $this->pn_Manual->OldUploadPath;
			$this->pn_PhotoCommercial->OldUploadPath = files/products;
			$this->pn_PhotoCommercial->UploadPath = $this->pn_PhotoCommercial->OldUploadPath;
			$this->pn_PhotoTechnical->OldUploadPath = files/technical/images;
			$this->pn_PhotoTechnical->UploadPath = $this->pn_PhotoTechnical->OldUploadPath;
		}
		$rsnew = array();

		// pn_Barcode
		$this->pn_Barcode->SetDbValueDef($rsnew, $this->pn_Barcode->CurrentValue, "", FALSE);

		// v_ID
		$this->v_ID->SetDbValueDef($rsnew, $this->v_ID->CurrentValue, 0, FALSE);

		// b_ID
		$this->b_ID->SetDbValueDef($rsnew, $this->b_ID->CurrentValue, NULL, FALSE);

		// pn_ProductName
		$this->pn_ProductName->SetDbValueDef($rsnew, $this->pn_ProductName->CurrentValue, "", FALSE);

		// pn_Version
		$this->pn_Version->SetDbValueDef($rsnew, $this->pn_Version->CurrentValue, NULL, FALSE);

		// pn_Spec
		$this->pn_Spec->SetDbValueDef($rsnew, $this->pn_Spec->CurrentValue, NULL, FALSE);

		// pn_Manual
		if ($this->pn_Manual->Visible && !$this->pn_Manual->Upload->KeepFile) {
			$this->pn_Manual->Upload->DbValue = ""; // No need to delete old file
			if ($this->pn_Manual->Upload->FileName == "") {
				$rsnew['pn_Manual'] = NULL;
			} else {
				if ($rsold && $rsold->fields['pn_Manual'] <> "" && $this->pn_Manual->Upload->FileName <> "") {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsold->fields['pn_Manual']);
					$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_Manual->Upload->FileName);
					$FileCount = count($NewFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						if ($NewFiles[$i] <> "" && in_array($NewFiles[$i], $OldFiles)) {
							$TempFile = ew_UniqueFilename($this->pn_Manual->UploadPath, $NewFiles[$i]);
							$fldvar = ($this->pn_Manual->Upload->Index < 0) ? $this->pn_Manual->FldVar : substr($this->pn_Manual->FldVar, 0, 1) . $this->pn_Manual->Upload->Index . substr($this->pn_Manual->FldVar, 1);
							rename(ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i], ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $TempFile);
							$NewFiles[$i] = $TempFile;
						}
					}
					$this->pn_Manual->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				}
				$rsnew['pn_Manual'] = $this->pn_Manual->Upload->FileName;
			}
		}

		// pn_PhotoCommercial
		if ($this->pn_PhotoCommercial->Visible && !$this->pn_PhotoCommercial->Upload->KeepFile) {
			$this->pn_PhotoCommercial->Upload->DbValue = ""; // No need to delete old file
			if ($this->pn_PhotoCommercial->Upload->FileName == "") {
				$rsnew['pn_PhotoCommercial'] = NULL;
			} else {
				if ($rsold && $rsold->fields['pn_PhotoCommercial'] == $this->pn_PhotoCommercial->Upload->FileName) {
					$this->pn_PhotoCommercial->Upload->FileName = ew_UniqueFilename($this->pn_PhotoCommercial->UploadPath, $rsold->fields['pn_PhotoCommercial']);
				}
				$rsnew['pn_PhotoCommercial'] = $this->pn_PhotoCommercial->Upload->FileName;
			}
		}

		// pn_PhotoTechnical
		if ($this->pn_PhotoTechnical->Visible && !$this->pn_PhotoTechnical->Upload->KeepFile) {
			$this->pn_PhotoTechnical->Upload->DbValue = ""; // No need to delete old file
			if ($this->pn_PhotoTechnical->Upload->FileName == "") {
				$rsnew['pn_PhotoTechnical'] = NULL;
			} else {
				if ($rsold && $rsold->fields['pn_PhotoTechnical'] <> "" && $this->pn_PhotoTechnical->Upload->FileName <> "") {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsold->fields['pn_PhotoTechnical']);
					$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_PhotoTechnical->Upload->FileName);
					$FileCount = count($NewFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						if ($NewFiles[$i] <> "" && in_array($NewFiles[$i], $OldFiles)) {
							$TempFile = ew_UniqueFilename($this->pn_PhotoTechnical->UploadPath, $NewFiles[$i]);
							$fldvar = ($this->pn_PhotoTechnical->Upload->Index < 0) ? $this->pn_PhotoTechnical->FldVar : substr($this->pn_PhotoTechnical->FldVar, 0, 1) . $this->pn_PhotoTechnical->Upload->Index . substr($this->pn_PhotoTechnical->FldVar, 1);
							rename(ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i], ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $TempFile);
							$NewFiles[$i] = $TempFile;
						}
					}
					$this->pn_PhotoTechnical->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				}
				$rsnew['pn_PhotoTechnical'] = $this->pn_PhotoTechnical->Upload->FileName;
			}
		}
		if ($this->pn_Manual->Visible && !$this->pn_Manual->Upload->KeepFile) {
			$this->pn_Manual->UploadPath = files/manual;
			$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_Manual->Upload->DbValue);
			if (!ew_Empty($this->pn_Manual->Upload->FileName)) {
				$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_Manual->Upload->FileName);
				$FileCount = count($NewFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					$fldvar = ($this->pn_Manual->Upload->Index < 0) ? $this->pn_Manual->FldVar : substr($this->pn_Manual->FldVar, 0, 1) . $this->pn_Manual->Upload->Index . substr($this->pn_Manual->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $file)) {
							if (!in_array($file, $OldFiles)) {
								$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->pn_Manual->UploadPath), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
										$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->pn_Manual->UploadPath), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
				}
				$this->pn_Manual->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$rsnew['pn_Manual'] = $this->pn_Manual->Upload->FileName;
			} else {
				$NewFiles = array();
			}
		}
		if ($this->pn_PhotoCommercial->Visible && !$this->pn_PhotoCommercial->Upload->KeepFile) {
			$this->pn_PhotoCommercial->UploadPath = files/products;
			if (!ew_Empty($this->pn_PhotoCommercial->Upload->Value)) {
				$rsnew['pn_PhotoCommercial'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->pn_PhotoCommercial->UploadPath), $rsnew['pn_PhotoCommercial']); // Get new file name
			}
		}
		if ($this->pn_PhotoTechnical->Visible && !$this->pn_PhotoTechnical->Upload->KeepFile) {
			$this->pn_PhotoTechnical->UploadPath = files/technical/images;
			$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_PhotoTechnical->Upload->DbValue);
			if (!ew_Empty($this->pn_PhotoTechnical->Upload->FileName)) {
				$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_PhotoTechnical->Upload->FileName);
				$FileCount = count($NewFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					$fldvar = ($this->pn_PhotoTechnical->Upload->Index < 0) ? $this->pn_PhotoTechnical->FldVar : substr($this->pn_PhotoTechnical->FldVar, 0, 1) . $this->pn_PhotoTechnical->Upload->Index . substr($this->pn_PhotoTechnical->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $file)) {
							if (!in_array($file, $OldFiles)) {
								$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->pn_PhotoTechnical->UploadPath), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
										$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->pn_PhotoTechnical->UploadPath), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
				}
				$this->pn_PhotoTechnical->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$rsnew['pn_PhotoTechnical'] = $this->pn_PhotoTechnical->Upload->FileName;
			} else {
				$NewFiles = array();
			}
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
				$this->pn_ID->setDbValue($conn->Insert_ID());
				$rsnew['pn_ID'] = $this->pn_ID->DbValue;
				if ($this->pn_Manual->Visible && !$this->pn_Manual->Upload->KeepFile) {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_Manual->Upload->DbValue);
					if (!ew_Empty($this->pn_Manual->Upload->FileName)) {
						$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_Manual->Upload->FileName);
						$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['pn_Manual']);
						$FileCount = count($NewFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							$fldvar = ($this->pn_Manual->Upload->Index < 0) ? $this->pn_Manual->FldVar : substr($this->pn_Manual->FldVar, 0, 1) . $this->pn_Manual->Upload->Index . substr($this->pn_Manual->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->pn_Manual->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
								if (file_exists($file)) {
									$this->pn_Manual->Upload->SaveToFile($this->pn_Manual->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
								}
							}
						}
					} else {
						$NewFiles = array();
					}
				}
				if ($this->pn_PhotoCommercial->Visible && !$this->pn_PhotoCommercial->Upload->KeepFile) {
					if (!ew_Empty($this->pn_PhotoCommercial->Upload->Value)) {
						$this->pn_PhotoCommercial->Upload->SaveToFile($this->pn_PhotoCommercial->UploadPath, $rsnew['pn_PhotoCommercial'], TRUE);
					}
				}
				if ($this->pn_PhotoTechnical->Visible && !$this->pn_PhotoTechnical->Upload->KeepFile) {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_PhotoTechnical->Upload->DbValue);
					if (!ew_Empty($this->pn_PhotoTechnical->Upload->FileName)) {
						$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->pn_PhotoTechnical->Upload->FileName);
						$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['pn_PhotoTechnical']);
						$FileCount = count($NewFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							$fldvar = ($this->pn_PhotoTechnical->Upload->Index < 0) ? $this->pn_PhotoTechnical->FldVar : substr($this->pn_PhotoTechnical->FldVar, 0, 1) . $this->pn_PhotoTechnical->Upload->Index . substr($this->pn_PhotoTechnical->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->pn_PhotoTechnical->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
								if (file_exists($file)) {
									$this->pn_PhotoTechnical->Upload->SaveToFile($this->pn_PhotoTechnical->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
								}
							}
						}
					} else {
						$NewFiles = array();
					}
				}
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
			if (in_array("main_Product", $DetailTblVar) && $GLOBALS["main_Product"]->DetailAdd) {
				$GLOBALS["main_Product"]->pn_ID->setSessionValue($this->pn_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["main_Product_grid"])) $GLOBALS["main_Product_grid"] = new cmain_Product_grid(); // Get detail page object
				$AddRow = $GLOBALS["main_Product_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["main_Product"]->pn_ID->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("StockCard", $DetailTblVar) && $GLOBALS["StockCard"]->DetailAdd) {
				$GLOBALS["StockCard"]->LinkedID->setSessionValue($this->pn_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["StockCard_grid"])) $GLOBALS["StockCard_grid"] = new cStockCard_grid(); // Get detail page object
				$AddRow = $GLOBALS["StockCard_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["StockCard"]->LinkedID->setSessionValue(""); // Clear master key if insert failed
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

		// pn_Manual
		ew_CleanUploadTempPath($this->pn_Manual, $this->pn_Manual->Upload->Index);

		// pn_PhotoCommercial
		ew_CleanUploadTempPath($this->pn_PhotoCommercial, $this->pn_PhotoCommercial->Upload->Index);

		// pn_PhotoTechnical
		ew_CleanUploadTempPath($this->pn_PhotoTechnical, $this->pn_PhotoTechnical->Upload->Index);
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
			if ($sMasterTblVar == "main_Brand") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_b_ID"] <> "") {
					$GLOBALS["main_Brand"]->b_ID->setQueryStringValue($_GET["fk_b_ID"]);
					$this->b_ID->setQueryStringValue($GLOBALS["main_Brand"]->b_ID->QueryStringValue);
					$this->b_ID->setSessionValue($this->b_ID->QueryStringValue);
					if (!is_numeric($GLOBALS["main_Brand"]->b_ID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "main_Vendor") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_v_ID"] <> "") {
					$GLOBALS["main_Vendor"]->v_ID->setQueryStringValue($_GET["fk_v_ID"]);
					$this->v_ID->setQueryStringValue($GLOBALS["main_Vendor"]->v_ID->QueryStringValue);
					$this->v_ID->setSessionValue($this->v_ID->QueryStringValue);
					if (!is_numeric($GLOBALS["main_Vendor"]->v_ID->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "main_Brand") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_b_ID"] <> "") {
					$GLOBALS["main_Brand"]->b_ID->setFormValue($_POST["fk_b_ID"]);
					$this->b_ID->setFormValue($GLOBALS["main_Brand"]->b_ID->FormValue);
					$this->b_ID->setSessionValue($this->b_ID->FormValue);
					if (!is_numeric($GLOBALS["main_Brand"]->b_ID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "main_Vendor") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_v_ID"] <> "") {
					$GLOBALS["main_Vendor"]->v_ID->setFormValue($_POST["fk_v_ID"]);
					$this->v_ID->setFormValue($GLOBALS["main_Vendor"]->v_ID->FormValue);
					$this->v_ID->setSessionValue($this->v_ID->FormValue);
					if (!is_numeric($GLOBALS["main_Vendor"]->v_ID->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "main_Brand") {
				if ($this->b_ID->CurrentValue == "") $this->b_ID->setSessionValue("");
			}
			if ($sMasterTblVar <> "main_Vendor") {
				if ($this->v_ID->CurrentValue == "") $this->v_ID->setSessionValue("");
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
			if (in_array("main_Product", $DetailTblVar)) {
				if (!isset($GLOBALS["main_Product_grid"]))
					$GLOBALS["main_Product_grid"] = new cmain_Product_grid;
				if ($GLOBALS["main_Product_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["main_Product_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["main_Product_grid"]->CurrentMode = "add";
					$GLOBALS["main_Product_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["main_Product_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["main_Product_grid"]->setStartRecordNumber(1);
					$GLOBALS["main_Product_grid"]->pn_ID->FldIsDetailKey = TRUE;
					$GLOBALS["main_Product_grid"]->pn_ID->CurrentValue = $this->pn_ID->CurrentValue;
					$GLOBALS["main_Product_grid"]->pn_ID->setSessionValue($GLOBALS["main_Product_grid"]->pn_ID->CurrentValue);
				}
			}
			if (in_array("StockCard", $DetailTblVar)) {
				if (!isset($GLOBALS["StockCard_grid"]))
					$GLOBALS["StockCard_grid"] = new cStockCard_grid;
				if ($GLOBALS["StockCard_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["StockCard_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["StockCard_grid"]->CurrentMode = "add";
					$GLOBALS["StockCard_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["StockCard_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["StockCard_grid"]->setStartRecordNumber(1);
					$GLOBALS["StockCard_grid"]->LinkedID->FldIsDetailKey = TRUE;
					$GLOBALS["StockCard_grid"]->LinkedID->CurrentValue = $this->pn_ID->CurrentValue;
					$GLOBALS["StockCard_grid"]->LinkedID->setSessionValue($GLOBALS["StockCard_grid"]->LinkedID->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("main_partnum_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($main_PartNum_add)) $main_PartNum_add = new cmain_PartNum_add();

// Page init
$main_PartNum_add->Page_Init();

// Page main
$main_PartNum_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_PartNum_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmain_PartNumadd = new ew_Form("fmain_PartNumadd", "add");

// Validate form
fmain_PartNumadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_pn_Barcode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_PartNum->pn_Barcode->FldCaption(), $main_PartNum->pn_Barcode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_v_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_PartNum->v_ID->FldCaption(), $main_PartNum->v_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pn_ProductName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_PartNum->pn_ProductName->FldCaption(), $main_PartNum->pn_ProductName->ReqErrMsg)) ?>");

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
fmain_PartNumadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_PartNumadd.ValidateRequired = true;
<?php } else { ?>
fmain_PartNumadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_PartNumadd.Lists["x_v_ID"] = {"LinkField":"x_v_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_v_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_PartNumadd.Lists["x_b_ID"] = {"LinkField":"x_b_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_b_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $main_PartNum_add->ShowPageHeader(); ?>
<?php
$main_PartNum_add->ShowMessage();
?>
<form name="fmain_PartNumadd" id="fmain_PartNumadd" class="<?php echo $main_PartNum_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_PartNum_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_PartNum_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_PartNum">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($main_PartNum->getCurrentMasterTable() == "main_Brand") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="main_Brand">
<input type="hidden" name="fk_b_ID" value="<?php echo $main_PartNum->b_ID->getSessionValue() ?>">
<?php } ?>
<?php if ($main_PartNum->getCurrentMasterTable() == "main_Vendor") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="main_Vendor">
<input type="hidden" name="fk_v_ID" value="<?php echo $main_PartNum->v_ID->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($main_PartNum->pn_Barcode->Visible) { // pn_Barcode ?>
	<div id="r_pn_Barcode" class="form-group">
		<label id="elh_main_PartNum_pn_Barcode" for="x_pn_Barcode" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_Barcode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_Barcode->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Barcode">
<input type="text" data-table="main_PartNum" data-field="x_pn_Barcode" name="x_pn_Barcode" id="x_pn_Barcode" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_Barcode->EditValue ?>"<?php echo $main_PartNum->pn_Barcode->EditAttributes() ?>>
</span>
<?php echo $main_PartNum->pn_Barcode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->v_ID->Visible) { // v_ID ?>
	<div id="r_v_ID" class="form-group">
		<label id="elh_main_PartNum_v_ID" for="x_v_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->v_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->v_ID->CellAttributes() ?>>
<?php if ($main_PartNum->v_ID->getSessionValue() <> "") { ?>
<span id="el_main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->v_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_v_ID" name="x_v_ID" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_main_PartNum_v_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_PartNum->v_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_v_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden; max-height: 300px; overflow-y: auto;">
<?php
$arwrk = $main_PartNum->v_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_PartNum->v_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_PartNum" data-field="x_v_ID" name="x_v_ID" id="x_v_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_PartNum->v_ID->EditAttributes() ?>><?php echo $main_PartNum->v_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_PartNum->v_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_PartNum" data-field="x_v_ID" name="x_v_ID" id="x_v_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_PartNum->v_ID->CurrentValue) ?>" checked<?php echo $main_PartNum->v_ID->EditAttributes() ?>><?php echo $main_PartNum->v_ID->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_v_ID" class="ewTemplate"><input type="radio" data-table="main_PartNum" data-field="x_v_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_PartNum->v_ID->DisplayValueSeparator) ? json_encode($main_PartNum->v_ID->DisplayValueSeparator) : $main_PartNum->v_ID->DisplayValueSeparator) ?>" name="x_v_ID" id="x_v_ID" value="{value}"<?php echo $main_PartNum->v_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `v_ID`, `v_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Vendor`";
$sWhereWrk = "";
$main_PartNum->v_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_PartNum->v_ID->LookupFilters += array("f0" => "`v_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_PartNum->Lookup_Selecting($main_PartNum->v_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `v_Name` ASC";
if ($sSqlWrk <> "") $main_PartNum->v_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_v_ID" id="s_x_v_ID" value="<?php echo $main_PartNum->v_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $main_PartNum->v_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->b_ID->Visible) { // b_ID ?>
	<div id="r_b_ID" class="form-group">
		<label id="elh_main_PartNum_b_ID" for="x_b_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->b_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->b_ID->CellAttributes() ?>>
<?php if ($main_PartNum->b_ID->getSessionValue() <> "") { ?>
<span id="el_main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_PartNum->b_ID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_b_ID" name="x_b_ID" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_main_PartNum_b_ID">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_PartNum->b_ID->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x_b_ID" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_PartNum->b_ID->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_PartNum->b_ID->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_PartNum" data-field="x_b_ID" name="x_b_ID" id="x_b_ID_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_PartNum->b_ID->EditAttributes() ?>><?php echo $main_PartNum->b_ID->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_PartNum->b_ID->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_PartNum" data-field="x_b_ID" name="x_b_ID" id="x_b_ID_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_PartNum->b_ID->CurrentValue) ?>" checked<?php echo $main_PartNum->b_ID->EditAttributes() ?>><?php echo $main_PartNum->b_ID->CurrentValue ?>
<?php
    }
}
?>
		</div>
	</div>
	<div id="tp_x_b_ID" class="ewTemplate"><input type="radio" data-table="main_PartNum" data-field="x_b_ID" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_PartNum->b_ID->DisplayValueSeparator) ? json_encode($main_PartNum->b_ID->DisplayValueSeparator) : $main_PartNum->b_ID->DisplayValueSeparator) ?>" name="x_b_ID" id="x_b_ID" value="{value}"<?php echo $main_PartNum->b_ID->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `b_ID`, `b_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Brand`";
$sWhereWrk = "";
$main_PartNum->b_ID->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_PartNum->b_ID->LookupFilters += array("f0" => "`b_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_PartNum->Lookup_Selecting($main_PartNum->b_ID, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `b_Name` ASC";
if ($sSqlWrk <> "") $main_PartNum->b_ID->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_b_ID" id="s_x_b_ID" value="<?php echo $main_PartNum->b_ID->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $main_PartNum->b_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->pn_ProductName->Visible) { // pn_ProductName ?>
	<div id="r_pn_ProductName" class="form-group">
		<label id="elh_main_PartNum_pn_ProductName" for="x_pn_ProductName" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_ProductName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_ProductName->CellAttributes() ?>>
<span id="el_main_PartNum_pn_ProductName">
<input type="text" data-table="main_PartNum" data-field="x_pn_ProductName" name="x_pn_ProductName" id="x_pn_ProductName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_ProductName->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_ProductName->EditValue ?>"<?php echo $main_PartNum->pn_ProductName->EditAttributes() ?>>
</span>
<?php echo $main_PartNum->pn_ProductName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->pn_Version->Visible) { // pn_Version ?>
	<div id="r_pn_Version" class="form-group">
		<label id="elh_main_PartNum_pn_Version" for="x_pn_Version" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_Version->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_Version->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Version">
<input type="text" data-table="main_PartNum" data-field="x_pn_Version" name="x_pn_Version" id="x_pn_Version" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_Version->getPlaceHolder()) ?>" value="<?php echo $main_PartNum->pn_Version->EditValue ?>"<?php echo $main_PartNum->pn_Version->EditAttributes() ?>>
</span>
<?php echo $main_PartNum->pn_Version->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->pn_Spec->Visible) { // pn_Spec ?>
	<div id="r_pn_Spec" class="form-group">
		<label id="elh_main_PartNum_pn_Spec" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_Spec->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_Spec->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Spec">
<?php ew_AppendClass($main_PartNum->pn_Spec->EditAttrs["class"], "editor"); ?>
<textarea data-table="main_PartNum" data-field="x_pn_Spec" name="x_pn_Spec" id="x_pn_Spec" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($main_PartNum->pn_Spec->getPlaceHolder()) ?>"<?php echo $main_PartNum->pn_Spec->EditAttributes() ?>><?php echo $main_PartNum->pn_Spec->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmain_PartNumadd", "x_pn_Spec", 35, 4, <?php echo ($main_PartNum->pn_Spec->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $main_PartNum->pn_Spec->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->pn_Manual->Visible) { // pn_Manual ?>
	<div id="r_pn_Manual" class="form-group">
		<label id="elh_main_PartNum_pn_Manual" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_Manual->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_Manual->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Manual">
<div id="fd_x_pn_Manual">
<span title="<?php echo $main_PartNum->pn_Manual->FldTitle() ? $main_PartNum->pn_Manual->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($main_PartNum->pn_Manual->ReadOnly || $main_PartNum->pn_Manual->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="main_PartNum" data-field="x_pn_Manual" name="x_pn_Manual" id="x_pn_Manual" multiple="multiple"<?php echo $main_PartNum->pn_Manual->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_pn_Manual" id= "fn_x_pn_Manual" value="<?php echo $main_PartNum->pn_Manual->Upload->FileName ?>">
<input type="hidden" name="fa_x_pn_Manual" id= "fa_x_pn_Manual" value="0">
<input type="hidden" name="fs_x_pn_Manual" id= "fs_x_pn_Manual" value="65535">
<input type="hidden" name="fx_x_pn_Manual" id= "fx_x_pn_Manual" value="<?php echo $main_PartNum->pn_Manual->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_pn_Manual" id= "fm_x_pn_Manual" value="<?php echo $main_PartNum->pn_Manual->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_pn_Manual" id= "fc_x_pn_Manual" value="<?php echo $main_PartNum->pn_Manual->UploadMaxFileCount ?>">
</div>
<table id="ft_x_pn_Manual" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $main_PartNum->pn_Manual->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->pn_PhotoCommercial->Visible) { // pn_PhotoCommercial ?>
	<div id="r_pn_PhotoCommercial" class="form-group">
		<label id="elh_main_PartNum_pn_PhotoCommercial" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_PhotoCommercial->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_PhotoCommercial->CellAttributes() ?>>
<span id="el_main_PartNum_pn_PhotoCommercial">
<div id="fd_x_pn_PhotoCommercial">
<span title="<?php echo $main_PartNum->pn_PhotoCommercial->FldTitle() ? $main_PartNum->pn_PhotoCommercial->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($main_PartNum->pn_PhotoCommercial->ReadOnly || $main_PartNum->pn_PhotoCommercial->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="main_PartNum" data-field="x_pn_PhotoCommercial" name="x_pn_PhotoCommercial" id="x_pn_PhotoCommercial"<?php echo $main_PartNum->pn_PhotoCommercial->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_pn_PhotoCommercial" id= "fn_x_pn_PhotoCommercial" value="<?php echo $main_PartNum->pn_PhotoCommercial->Upload->FileName ?>">
<input type="hidden" name="fa_x_pn_PhotoCommercial" id= "fa_x_pn_PhotoCommercial" value="0">
<input type="hidden" name="fs_x_pn_PhotoCommercial" id= "fs_x_pn_PhotoCommercial" value="65535">
<input type="hidden" name="fx_x_pn_PhotoCommercial" id= "fx_x_pn_PhotoCommercial" value="<?php echo $main_PartNum->pn_PhotoCommercial->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_pn_PhotoCommercial" id= "fm_x_pn_PhotoCommercial" value="<?php echo $main_PartNum->pn_PhotoCommercial->UploadMaxFileSize ?>">
</div>
<table id="ft_x_pn_PhotoCommercial" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $main_PartNum->pn_PhotoCommercial->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_PartNum->pn_PhotoTechnical->Visible) { // pn_PhotoTechnical ?>
	<div id="r_pn_PhotoTechnical" class="form-group">
		<label id="elh_main_PartNum_pn_PhotoTechnical" class="col-sm-2 control-label ewLabel"><?php echo $main_PartNum->pn_PhotoTechnical->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_PartNum->pn_PhotoTechnical->CellAttributes() ?>>
<span id="el_main_PartNum_pn_PhotoTechnical">
<div id="fd_x_pn_PhotoTechnical">
<span title="<?php echo $main_PartNum->pn_PhotoTechnical->FldTitle() ? $main_PartNum->pn_PhotoTechnical->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($main_PartNum->pn_PhotoTechnical->ReadOnly || $main_PartNum->pn_PhotoTechnical->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="main_PartNum" data-field="x_pn_PhotoTechnical" name="x_pn_PhotoTechnical" id="x_pn_PhotoTechnical" multiple="multiple"<?php echo $main_PartNum->pn_PhotoTechnical->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_pn_PhotoTechnical" id= "fn_x_pn_PhotoTechnical" value="<?php echo $main_PartNum->pn_PhotoTechnical->Upload->FileName ?>">
<input type="hidden" name="fa_x_pn_PhotoTechnical" id= "fa_x_pn_PhotoTechnical" value="0">
<input type="hidden" name="fs_x_pn_PhotoTechnical" id= "fs_x_pn_PhotoTechnical" value="65535">
<input type="hidden" name="fx_x_pn_PhotoTechnical" id= "fx_x_pn_PhotoTechnical" value="<?php echo $main_PartNum->pn_PhotoTechnical->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_pn_PhotoTechnical" id= "fm_x_pn_PhotoTechnical" value="<?php echo $main_PartNum->pn_PhotoTechnical->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_pn_PhotoTechnical" id= "fc_x_pn_PhotoTechnical" value="<?php echo $main_PartNum->pn_PhotoTechnical->UploadMaxFileCount ?>">
</div>
<table id="ft_x_pn_PhotoTechnical" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $main_PartNum->pn_PhotoTechnical->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("main_Product", explode(",", $main_PartNum->getCurrentDetailTable())) && $main_Product->DetailAdd) {
?>
<?php if ($main_PartNum->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("main_Product", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "main_product_grid.php" ?>
<?php } ?>
<?php
	if (in_array("StockCard", explode(",", $main_PartNum->getCurrentDetailTable())) && $StockCard->DetailAdd) {
?>
<?php if ($main_PartNum->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("StockCard", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "stockcard_grid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $main_PartNum_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmain_PartNumadd.Init();
</script>
<?php
$main_PartNum_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$main_PartNum_add->Page_Terminate();
?>
