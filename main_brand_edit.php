<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "main_brand_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "main_partnum_gridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$main_Brand_edit = NULL; // Initialize page object first

class cmain_Brand_edit extends cmain_Brand {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_Brand';

	// Page object name
	var $PageObjName = 'main_Brand_edit';

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

		// Table object (main_Brand)
		if (!isset($GLOBALS["main_Brand"]) || get_class($GLOBALS["main_Brand"]) == "cmain_Brand") {
			$GLOBALS["main_Brand"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_Brand"];
		}

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'main_Brand', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("main_brand_list.php"));
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
		$this->b_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $main_Brand;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($main_Brand);
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
		if (@$_GET["b_ID"] <> "") {
			$this->b_ID->setQueryStringValue($_GET["b_ID"]);
		}

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
		if ($this->b_ID->CurrentValue == "")
			$this->Page_Terminate("main_brand_list.php"); // Invalid key, return to list

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
					$this->Page_Terminate("main_brand_list.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "main_brand_list.php")
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
		$this->logo->Upload->Index = $objForm->Index;
		$this->logo->Upload->UploadFile();
		$this->logo->CurrentValue = $this->logo->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->b_ID->FldIsDetailKey)
			$this->b_ID->setFormValue($objForm->GetValue("x_b_ID"));
		if (!$this->b_Name->FldIsDetailKey) {
			$this->b_Name->setFormValue($objForm->GetValue("x_b_Name"));
		}
		if (!$this->b_Note->FldIsDetailKey) {
			$this->b_Note->setFormValue($objForm->GetValue("x_b_Note"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->b_ID->CurrentValue = $this->b_ID->FormValue;
		$this->b_Name->CurrentValue = $this->b_Name->FormValue;
		$this->b_Note->CurrentValue = $this->b_Note->FormValue;
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
		$this->b_ID->setDbValue($rs->fields('b_ID'));
		$this->logo->Upload->DbValue = $rs->fields('logo');
		$this->logo->CurrentValue = $this->logo->Upload->DbValue;
		$this->b_Name->setDbValue($rs->fields('b_Name'));
		$this->b_Note->setDbValue($rs->fields('b_Note'));
		$this->b_LastUpdate->setDbValue($rs->fields('b_LastUpdate'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->b_ID->DbValue = $row['b_ID'];
		$this->logo->Upload->DbValue = $row['logo'];
		$this->b_Name->DbValue = $row['b_Name'];
		$this->b_Note->DbValue = $row['b_Note'];
		$this->b_LastUpdate->DbValue = $row['b_LastUpdate'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// b_ID
		// logo
		// b_Name
		// b_Note
		// b_LastUpdate

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// b_ID
		$this->b_ID->ViewValue = $this->b_ID->CurrentValue;
		$this->b_ID->ViewCustomAttributes = "";

		// logo
		$this->logo->UploadPath = files/technica/logo;
		if (!ew_Empty($this->logo->Upload->DbValue)) {
			$this->logo->ImageWidth = 150;
			$this->logo->ImageHeight = 0;
			$this->logo->ImageAlt = $this->logo->FldAlt();
			$this->logo->ViewValue = $this->logo->Upload->DbValue;
		} else {
			$this->logo->ViewValue = "";
		}
		$this->logo->ViewCustomAttributes = "";

		// b_Name
		$this->b_Name->ViewValue = $this->b_Name->CurrentValue;
		$this->b_Name->ViewCustomAttributes = "";

		// b_Note
		$this->b_Note->ViewValue = $this->b_Note->CurrentValue;
		$this->b_Note->ViewCustomAttributes = "";

			// b_ID
			$this->b_ID->LinkCustomAttributes = "";
			$this->b_ID->HrefValue = "";
			$this->b_ID->TooltipValue = "";

			// logo
			$this->logo->LinkCustomAttributes = "";
			$this->logo->UploadPath = files/technica/logo;
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->HrefValue = ew_GetFileUploadUrl($this->logo, $this->logo->Upload->DbValue); // Add prefix/suffix
				$this->logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->logo->HrefValue = ew_ConvertFullUrl($this->logo->HrefValue);
			} else {
				$this->logo->HrefValue = "";
			}
			$this->logo->HrefValue2 = $this->logo->UploadPath . $this->logo->Upload->DbValue;
			if ($this->Export == "") {
				$this->logo->TooltipValue = ($this->b_Name->ViewValue <> "") ? $this->b_Name->ViewValue : $this->b_Name->CurrentValue;
				$this->logo->TooltipWidth = 300;
				if ($this->logo->HrefValue == "") $this->logo->HrefValue = "javascript:void(0);";
				ew_AppendClass($this->logo->LinkAttrs["class"], "ewTooltipLink");
				$this->logo->LinkAttrs["data-tooltip-id"] = "tt_main_Brand_x_logo";
				$this->logo->LinkAttrs["data-tooltip-width"] = $this->logo->TooltipWidth;
				$this->logo->LinkAttrs["data-placement"] = $GLOBALS["EW_CSS_FLIP"] ? "left" : "right";
			}
			if ($this->logo->UseColorbox) {
				if (ew_Empty($this->logo->TooltipValue))
					$this->logo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->logo->LinkAttrs["data-rel"] = "main_Brand_x_logo";
				ew_AppendClass($this->logo->LinkAttrs["class"], "ewLightbox");
			}

			// b_Name
			$this->b_Name->LinkCustomAttributes = "";
			$this->b_Name->HrefValue = "";
			$this->b_Name->TooltipValue = "";

			// b_Note
			$this->b_Note->LinkCustomAttributes = "";
			$this->b_Note->HrefValue = "";
			$this->b_Note->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// b_ID
			$this->b_ID->EditAttrs["class"] = "form-control";
			$this->b_ID->EditCustomAttributes = "";
			$this->b_ID->EditValue = $this->b_ID->CurrentValue;
			$this->b_ID->ViewCustomAttributes = "";

			// logo
			$this->logo->EditAttrs["class"] = "form-control";
			$this->logo->EditCustomAttributes = "";
			$this->logo->UploadPath = files/technica/logo;
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->ImageWidth = 150;
				$this->logo->ImageHeight = 0;
				$this->logo->ImageAlt = $this->logo->FldAlt();
				$this->logo->EditValue = $this->logo->Upload->DbValue;
			} else {
				$this->logo->EditValue = "";
			}
			if (!ew_Empty($this->logo->CurrentValue))
				$this->logo->Upload->FileName = $this->logo->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->logo);

			// b_Name
			$this->b_Name->EditAttrs["class"] = "form-control";
			$this->b_Name->EditCustomAttributes = "";
			$this->b_Name->EditValue = ew_HtmlEncode($this->b_Name->CurrentValue);
			$this->b_Name->PlaceHolder = ew_RemoveHtml($this->b_Name->FldCaption());

			// b_Note
			$this->b_Note->EditAttrs["class"] = "form-control";
			$this->b_Note->EditCustomAttributes = "";
			$this->b_Note->EditValue = ew_HtmlEncode($this->b_Note->CurrentValue);
			$this->b_Note->PlaceHolder = ew_RemoveHtml($this->b_Note->FldCaption());

			// Edit refer script
			// b_ID

			$this->b_ID->LinkCustomAttributes = "";
			$this->b_ID->HrefValue = "";

			// logo
			$this->logo->LinkCustomAttributes = "";
			$this->logo->UploadPath = files/technica/logo;
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->HrefValue = ew_GetFileUploadUrl($this->logo, $this->logo->Upload->DbValue); // Add prefix/suffix
				$this->logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->logo->HrefValue = ew_ConvertFullUrl($this->logo->HrefValue);
			} else {
				$this->logo->HrefValue = "";
			}
			$this->logo->HrefValue2 = $this->logo->UploadPath . $this->logo->Upload->DbValue;

			// b_Name
			$this->b_Name->LinkCustomAttributes = "";
			$this->b_Name->HrefValue = "";

			// b_Note
			$this->b_Note->LinkCustomAttributes = "";
			$this->b_Note->HrefValue = "";
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
		if (!$this->b_Name->FldIsDetailKey && !is_null($this->b_Name->FormValue) && $this->b_Name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_Name->FldCaption(), $this->b_Name->ReqErrMsg));
		}
		if (!$this->b_Note->FldIsDetailKey && !is_null($this->b_Note->FormValue) && $this->b_Note->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->b_Note->FldCaption(), $this->b_Note->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("main_PartNum", $DetailTblVar) && $GLOBALS["main_PartNum"]->DetailEdit) {
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->logo->OldUploadPath = files/technica/logo;
			$this->logo->UploadPath = $this->logo->OldUploadPath;
			$rsnew = array();

			// logo
			if ($this->logo->Visible && !$this->logo->ReadOnly && !$this->logo->Upload->KeepFile) {
				$this->logo->Upload->DbValue = $rsold['logo']; // Get original value
				if ($this->logo->Upload->FileName == "") {
					$rsnew['logo'] = NULL;
				} else {
					$rsnew['logo'] = $this->logo->Upload->FileName;
				}
				$this->logo->ImageWidth = 150; // Resize width
				$this->logo->ImageHeight = 0; // Resize height
			}

			// b_Name
			$this->b_Name->SetDbValueDef($rsnew, $this->b_Name->CurrentValue, "", $this->b_Name->ReadOnly);

			// b_Note
			$this->b_Note->SetDbValueDef($rsnew, $this->b_Note->CurrentValue, "", $this->b_Note->ReadOnly);
			if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
				$this->logo->UploadPath = files/technica/logo;
				if (!ew_Empty($this->logo->Upload->Value)) {
					$rsnew['logo'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->logo->UploadPath), $rsnew['logo']); // Get new file name
				}
			}

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
					if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
						if (!ew_Empty($this->logo->Upload->Value)) {
							$this->logo->Upload->Resize($this->logo->ImageWidth, $this->logo->ImageHeight);
							$this->logo->Upload->SaveToFile($this->logo->UploadPath, $rsnew['logo'], TRUE);
						}
					}
				}

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("main_PartNum", $DetailTblVar) && $GLOBALS["main_PartNum"]->DetailEdit) {
						if (!isset($GLOBALS["main_PartNum_grid"])) $GLOBALS["main_PartNum_grid"] = new cmain_PartNum_grid(); // Get detail page object
						$EditRow = $GLOBALS["main_PartNum_grid"]->GridUpdate();
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

		// logo
		ew_CleanUploadTempPath($this->logo, $this->logo->Upload->Index);
		return $EditRow;
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
				if ($GLOBALS["main_PartNum_grid"]->DetailEdit) {
					$GLOBALS["main_PartNum_grid"]->CurrentMode = "edit";
					$GLOBALS["main_PartNum_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["main_PartNum_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["main_PartNum_grid"]->setStartRecordNumber(1);
					$GLOBALS["main_PartNum_grid"]->b_ID->FldIsDetailKey = TRUE;
					$GLOBALS["main_PartNum_grid"]->b_ID->CurrentValue = $this->b_ID->CurrentValue;
					$GLOBALS["main_PartNum_grid"]->b_ID->setSessionValue($GLOBALS["main_PartNum_grid"]->b_ID->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("main_brand_list.php"), "", $this->TableVar, TRUE);
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
if (!isset($main_Brand_edit)) $main_Brand_edit = new cmain_Brand_edit();

// Page init
$main_Brand_edit->Page_Init();

// Page main
$main_Brand_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_Brand_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fmain_Brandedit = new ew_Form("fmain_Brandedit", "edit");

// Validate form
fmain_Brandedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_b_Name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Brand->b_Name->FldCaption(), $main_Brand->b_Name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_b_Note");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Brand->b_Note->FldCaption(), $main_Brand->b_Note->ReqErrMsg)) ?>");

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
fmain_Brandedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Brandedit.ValidateRequired = true;
<?php } else { ?>
fmain_Brandedit.ValidateRequired = false; 
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
<?php $main_Brand_edit->ShowPageHeader(); ?>
<?php
$main_Brand_edit->ShowMessage();
?>
<form name="fmain_Brandedit" id="fmain_Brandedit" class="<?php echo $main_Brand_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_Brand_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_Brand_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_Brand">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($main_Brand->b_ID->Visible) { // b_ID ?>
	<div id="r_b_ID" class="form-group">
		<label id="elh_main_Brand_b_ID" class="col-sm-2 control-label ewLabel"><?php echo $main_Brand->b_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Brand->b_ID->CellAttributes() ?>>
<span id="el_main_Brand_b_ID">
<span<?php echo $main_Brand->b_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Brand->b_ID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Brand" data-field="x_b_ID" name="x_b_ID" id="x_b_ID" value="<?php echo ew_HtmlEncode($main_Brand->b_ID->CurrentValue) ?>">
<?php echo $main_Brand->b_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Brand->logo->Visible) { // logo ?>
	<div id="r_logo" class="form-group">
		<label id="elh_main_Brand_logo" class="col-sm-2 control-label ewLabel"><?php echo $main_Brand->logo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $main_Brand->logo->CellAttributes() ?>>
<span id="el_main_Brand_logo">
<div id="fd_x_logo">
<span title="<?php echo $main_Brand->logo->FldTitle() ? $main_Brand->logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($main_Brand->logo->ReadOnly || $main_Brand->logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="main_Brand" data-field="x_logo" name="x_logo" id="x_logo"<?php echo $main_Brand->logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_logo" id= "fn_x_logo" value="<?php echo $main_Brand->logo->Upload->FileName ?>">
<?php if (@$_POST["fa_x_logo"] == "0") { ?>
<input type="hidden" name="fa_x_logo" id= "fa_x_logo" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_logo" id= "fa_x_logo" value="1">
<?php } ?>
<input type="hidden" name="fs_x_logo" id= "fs_x_logo" value="65535">
<input type="hidden" name="fx_x_logo" id= "fx_x_logo" value="<?php echo $main_Brand->logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_logo" id= "fm_x_logo" value="<?php echo $main_Brand->logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $main_Brand->logo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Brand->b_Name->Visible) { // b_Name ?>
	<div id="r_b_Name" class="form-group">
		<label id="elh_main_Brand_b_Name" for="x_b_Name" class="col-sm-2 control-label ewLabel"><?php echo $main_Brand->b_Name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Brand->b_Name->CellAttributes() ?>>
<span id="el_main_Brand_b_Name">
<input type="text" data-table="main_Brand" data-field="x_b_Name" name="x_b_Name" id="x_b_Name" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Brand->b_Name->getPlaceHolder()) ?>" value="<?php echo $main_Brand->b_Name->EditValue ?>"<?php echo $main_Brand->b_Name->EditAttributes() ?>>
</span>
<?php echo $main_Brand->b_Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($main_Brand->b_Note->Visible) { // b_Note ?>
	<div id="r_b_Note" class="form-group">
		<label id="elh_main_Brand_b_Note" class="col-sm-2 control-label ewLabel"><?php echo $main_Brand->b_Note->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $main_Brand->b_Note->CellAttributes() ?>>
<span id="el_main_Brand_b_Note">
<?php ew_AppendClass($main_Brand->b_Note->EditAttrs["class"], "editor"); ?>
<textarea data-table="main_Brand" data-field="x_b_Note" name="x_b_Note" id="x_b_Note" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($main_Brand->b_Note->getPlaceHolder()) ?>"<?php echo $main_Brand->b_Note->EditAttributes() ?>><?php echo $main_Brand->b_Note->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmain_Brandedit", "x_b_Note", 35, 4, <?php echo ($main_Brand->b_Note->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $main_Brand->b_Note->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("main_PartNum", explode(",", $main_Brand->getCurrentDetailTable())) && $main_PartNum->DetailEdit) {
?>
<?php if ($main_Brand->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("main_PartNum", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "main_partnum_grid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $main_Brand_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmain_Brandedit.Init();
</script>
<?php
$main_Brand_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$main_Brand_edit->Page_Terminate();
?>
