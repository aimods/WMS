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

$main_User_list = NULL; // Initialize page object first

class cmain_User_list extends cmain_User {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_User';

	// Page object name
	var $PageObjName = 'main_User_list';

	// Grid form hidden field names
	var $FormName = 'fmain_Userlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "main_user_add.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "main_user_delete.php";
		$this->MultiUpdateUrl = "main_user_update.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fmain_Userlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Update last accessed time
		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {
		} else {
			echo $Language->Phrase("UserProfileCorrupted");
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();

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

		// Setup other options
		$this->SetupOtherOptions();
		$this->ListActions->Add("resendregisteremail", $Language->Phrase("ResendRegisterEmailBtn"), IsAdmin(), EW_ACTION_AJAX, EW_ACTION_SINGLE);
		$this->ListActions->Add("resetconcurrentuser", $Language->Phrase("ResetConcurrentUserBtn"), IsAdmin(), EW_ACTION_AJAX, EW_ACTION_SINGLE);
		$this->ListActions->Add("resetloginretry", $Language->Phrase("ResetLoginRetryBtn"), IsAdmin(), EW_ACTION_AJAX, EW_ACTION_SINGLE);
		$this->ListActions->Add("setpasswordexpired", $Language->Phrase("SetPasswordExpiredBtn"), IsAdmin(), EW_ACTION_AJAX, EW_ACTION_SINGLE);

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore filter list
			$this->RestoreFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->u_ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->u_ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->u_ID->AdvancedSearch->ToJSON(), ","); // Field u_ID
		$sFilterList = ew_Concat($sFilterList, $this->u_BillName->AdvancedSearch->ToJSON(), ","); // Field u_BillName
		$sFilterList = ew_Concat($sFilterList, $this->u_LoginName->AdvancedSearch->ToJSON(), ","); // Field u_LoginName
		$sFilterList = ew_Concat($sFilterList, $this->u_Email->AdvancedSearch->ToJSON(), ","); // Field u_Email
		$sFilterList = ew_Concat($sFilterList, $this->u_Passwd->AdvancedSearch->ToJSON(), ","); // Field u_Passwd
		$sFilterList = ew_Concat($sFilterList, $this->u_Address->AdvancedSearch->ToJSON(), ","); // Field u_Address
		$sFilterList = ew_Concat($sFilterList, $this->u_Provice->AdvancedSearch->ToJSON(), ","); // Field u_Provice
		$sFilterList = ew_Concat($sFilterList, $this->u_City->AdvancedSearch->ToJSON(), ","); // Field u_City
		$sFilterList = ew_Concat($sFilterList, $this->u_Postcode->AdvancedSearch->ToJSON(), ","); // Field u_Postcode
		$sFilterList = ew_Concat($sFilterList, $this->u_Mobile->AdvancedSearch->ToJSON(), ","); // Field u_Mobile
		$sFilterList = ew_Concat($sFilterList, $this->u_PID->AdvancedSearch->ToJSON(), ","); // Field u_PID
		$sFilterList = ew_Concat($sFilterList, $this->u_Status->AdvancedSearch->ToJSON(), ","); // Field u_Status
		$sFilterList = ew_Concat($sFilterList, $this->u_Created->AdvancedSearch->ToJSON(), ","); // Field u_Created
		$sFilterList = ew_Concat($sFilterList, $this->u_LastUpdate->AdvancedSearch->ToJSON(), ","); // Field u_LastUpdate
		$sFilterList = ew_Concat($sFilterList, $this->u_Profile->AdvancedSearch->ToJSON(), ","); // Field u_Profile
		$sFilterList = ew_Concat($sFilterList, $this->u_level->AdvancedSearch->ToJSON(), ","); // Field u_level
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field u_ID
		$this->u_ID->AdvancedSearch->SearchValue = @$filter["x_u_ID"];
		$this->u_ID->AdvancedSearch->SearchOperator = @$filter["z_u_ID"];
		$this->u_ID->AdvancedSearch->SearchCondition = @$filter["v_u_ID"];
		$this->u_ID->AdvancedSearch->SearchValue2 = @$filter["y_u_ID"];
		$this->u_ID->AdvancedSearch->SearchOperator2 = @$filter["w_u_ID"];
		$this->u_ID->AdvancedSearch->Save();

		// Field u_BillName
		$this->u_BillName->AdvancedSearch->SearchValue = @$filter["x_u_BillName"];
		$this->u_BillName->AdvancedSearch->SearchOperator = @$filter["z_u_BillName"];
		$this->u_BillName->AdvancedSearch->SearchCondition = @$filter["v_u_BillName"];
		$this->u_BillName->AdvancedSearch->SearchValue2 = @$filter["y_u_BillName"];
		$this->u_BillName->AdvancedSearch->SearchOperator2 = @$filter["w_u_BillName"];
		$this->u_BillName->AdvancedSearch->Save();

		// Field u_LoginName
		$this->u_LoginName->AdvancedSearch->SearchValue = @$filter["x_u_LoginName"];
		$this->u_LoginName->AdvancedSearch->SearchOperator = @$filter["z_u_LoginName"];
		$this->u_LoginName->AdvancedSearch->SearchCondition = @$filter["v_u_LoginName"];
		$this->u_LoginName->AdvancedSearch->SearchValue2 = @$filter["y_u_LoginName"];
		$this->u_LoginName->AdvancedSearch->SearchOperator2 = @$filter["w_u_LoginName"];
		$this->u_LoginName->AdvancedSearch->Save();

		// Field u_Email
		$this->u_Email->AdvancedSearch->SearchValue = @$filter["x_u_Email"];
		$this->u_Email->AdvancedSearch->SearchOperator = @$filter["z_u_Email"];
		$this->u_Email->AdvancedSearch->SearchCondition = @$filter["v_u_Email"];
		$this->u_Email->AdvancedSearch->SearchValue2 = @$filter["y_u_Email"];
		$this->u_Email->AdvancedSearch->SearchOperator2 = @$filter["w_u_Email"];
		$this->u_Email->AdvancedSearch->Save();

		// Field u_Passwd
		$this->u_Passwd->AdvancedSearch->SearchValue = @$filter["x_u_Passwd"];
		$this->u_Passwd->AdvancedSearch->SearchOperator = @$filter["z_u_Passwd"];
		$this->u_Passwd->AdvancedSearch->SearchCondition = @$filter["v_u_Passwd"];
		$this->u_Passwd->AdvancedSearch->SearchValue2 = @$filter["y_u_Passwd"];
		$this->u_Passwd->AdvancedSearch->SearchOperator2 = @$filter["w_u_Passwd"];
		$this->u_Passwd->AdvancedSearch->Save();

		// Field u_Address
		$this->u_Address->AdvancedSearch->SearchValue = @$filter["x_u_Address"];
		$this->u_Address->AdvancedSearch->SearchOperator = @$filter["z_u_Address"];
		$this->u_Address->AdvancedSearch->SearchCondition = @$filter["v_u_Address"];
		$this->u_Address->AdvancedSearch->SearchValue2 = @$filter["y_u_Address"];
		$this->u_Address->AdvancedSearch->SearchOperator2 = @$filter["w_u_Address"];
		$this->u_Address->AdvancedSearch->Save();

		// Field u_Provice
		$this->u_Provice->AdvancedSearch->SearchValue = @$filter["x_u_Provice"];
		$this->u_Provice->AdvancedSearch->SearchOperator = @$filter["z_u_Provice"];
		$this->u_Provice->AdvancedSearch->SearchCondition = @$filter["v_u_Provice"];
		$this->u_Provice->AdvancedSearch->SearchValue2 = @$filter["y_u_Provice"];
		$this->u_Provice->AdvancedSearch->SearchOperator2 = @$filter["w_u_Provice"];
		$this->u_Provice->AdvancedSearch->Save();

		// Field u_City
		$this->u_City->AdvancedSearch->SearchValue = @$filter["x_u_City"];
		$this->u_City->AdvancedSearch->SearchOperator = @$filter["z_u_City"];
		$this->u_City->AdvancedSearch->SearchCondition = @$filter["v_u_City"];
		$this->u_City->AdvancedSearch->SearchValue2 = @$filter["y_u_City"];
		$this->u_City->AdvancedSearch->SearchOperator2 = @$filter["w_u_City"];
		$this->u_City->AdvancedSearch->Save();

		// Field u_Postcode
		$this->u_Postcode->AdvancedSearch->SearchValue = @$filter["x_u_Postcode"];
		$this->u_Postcode->AdvancedSearch->SearchOperator = @$filter["z_u_Postcode"];
		$this->u_Postcode->AdvancedSearch->SearchCondition = @$filter["v_u_Postcode"];
		$this->u_Postcode->AdvancedSearch->SearchValue2 = @$filter["y_u_Postcode"];
		$this->u_Postcode->AdvancedSearch->SearchOperator2 = @$filter["w_u_Postcode"];
		$this->u_Postcode->AdvancedSearch->Save();

		// Field u_Mobile
		$this->u_Mobile->AdvancedSearch->SearchValue = @$filter["x_u_Mobile"];
		$this->u_Mobile->AdvancedSearch->SearchOperator = @$filter["z_u_Mobile"];
		$this->u_Mobile->AdvancedSearch->SearchCondition = @$filter["v_u_Mobile"];
		$this->u_Mobile->AdvancedSearch->SearchValue2 = @$filter["y_u_Mobile"];
		$this->u_Mobile->AdvancedSearch->SearchOperator2 = @$filter["w_u_Mobile"];
		$this->u_Mobile->AdvancedSearch->Save();

		// Field u_PID
		$this->u_PID->AdvancedSearch->SearchValue = @$filter["x_u_PID"];
		$this->u_PID->AdvancedSearch->SearchOperator = @$filter["z_u_PID"];
		$this->u_PID->AdvancedSearch->SearchCondition = @$filter["v_u_PID"];
		$this->u_PID->AdvancedSearch->SearchValue2 = @$filter["y_u_PID"];
		$this->u_PID->AdvancedSearch->SearchOperator2 = @$filter["w_u_PID"];
		$this->u_PID->AdvancedSearch->Save();

		// Field u_Status
		$this->u_Status->AdvancedSearch->SearchValue = @$filter["x_u_Status"];
		$this->u_Status->AdvancedSearch->SearchOperator = @$filter["z_u_Status"];
		$this->u_Status->AdvancedSearch->SearchCondition = @$filter["v_u_Status"];
		$this->u_Status->AdvancedSearch->SearchValue2 = @$filter["y_u_Status"];
		$this->u_Status->AdvancedSearch->SearchOperator2 = @$filter["w_u_Status"];
		$this->u_Status->AdvancedSearch->Save();

		// Field u_Created
		$this->u_Created->AdvancedSearch->SearchValue = @$filter["x_u_Created"];
		$this->u_Created->AdvancedSearch->SearchOperator = @$filter["z_u_Created"];
		$this->u_Created->AdvancedSearch->SearchCondition = @$filter["v_u_Created"];
		$this->u_Created->AdvancedSearch->SearchValue2 = @$filter["y_u_Created"];
		$this->u_Created->AdvancedSearch->SearchOperator2 = @$filter["w_u_Created"];
		$this->u_Created->AdvancedSearch->Save();

		// Field u_LastUpdate
		$this->u_LastUpdate->AdvancedSearch->SearchValue = @$filter["x_u_LastUpdate"];
		$this->u_LastUpdate->AdvancedSearch->SearchOperator = @$filter["z_u_LastUpdate"];
		$this->u_LastUpdate->AdvancedSearch->SearchCondition = @$filter["v_u_LastUpdate"];
		$this->u_LastUpdate->AdvancedSearch->SearchValue2 = @$filter["y_u_LastUpdate"];
		$this->u_LastUpdate->AdvancedSearch->SearchOperator2 = @$filter["w_u_LastUpdate"];
		$this->u_LastUpdate->AdvancedSearch->Save();

		// Field u_Profile
		$this->u_Profile->AdvancedSearch->SearchValue = @$filter["x_u_Profile"];
		$this->u_Profile->AdvancedSearch->SearchOperator = @$filter["z_u_Profile"];
		$this->u_Profile->AdvancedSearch->SearchCondition = @$filter["v_u_Profile"];
		$this->u_Profile->AdvancedSearch->SearchValue2 = @$filter["y_u_Profile"];
		$this->u_Profile->AdvancedSearch->SearchOperator2 = @$filter["w_u_Profile"];
		$this->u_Profile->AdvancedSearch->Save();

		// Field u_level
		$this->u_level->AdvancedSearch->SearchValue = @$filter["x_u_level"];
		$this->u_level->AdvancedSearch->SearchOperator = @$filter["z_u_level"];
		$this->u_level->AdvancedSearch->SearchCondition = @$filter["v_u_level"];
		$this->u_level->AdvancedSearch->SearchValue2 = @$filter["y_u_level"];
		$this->u_level->AdvancedSearch->SearchOperator2 = @$filter["w_u_level"];
		$this->u_level->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->u_BillName, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_LoginName, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_Email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_Passwd, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_Address, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_Postcode, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_Mobile, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_PID, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->u_Profile, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->u_BillName); // u_BillName
			$this->UpdateSort($this->u_Email); // u_Email
			$this->UpdateSort($this->u_Mobile); // u_Mobile
			$this->UpdateSort($this->u_Status); // u_Status
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->u_BillName->setSort("");
				$this->u_Email->setSort("");
				$this->u_Mobile->setSort("");
				$this->u_Status->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->u_ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fmain_Userlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fmain_Userlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fmain_Userlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		global $UserProfile;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$user = $row['u_LoginName'];
					if ($userlist <> "") $userlist .= ",";
					$userlist .= $user;
					if ($UserAction == "resendregisteremail")
						$Processed = $this->SendRegisterEmail($row);
					elseif ($UserAction == "resetconcurrentuser")
						$Processed = $UserProfile->ResetConcurrentUser($user);
					elseif ($UserAction == "resetloginretry")
						$Processed = $UserProfile->ResetLoginRetry($user);
					elseif ($UserAction == "setpasswordexpired")
						$Processed = $UserProfile->SetPasswordExpired($user);
					else
						$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($UserAction == "resendregisteremail")
						$this->setSuccessMessage(str_replace('%u', $userlist, $Language->Phrase("ResendRegisterEmailSuccess")));
					if ($UserAction == "resetconcurrentuser")
						$this->setSuccessMessage(str_replace('%u', $userlist, $Language->Phrase("ResetConcurrentUserSuccess")));
					if ($UserAction == "resetloginretry")
						$this->setSuccessMessage(str_replace('%u', $userlist, $Language->Phrase("ResetLoginRetrySuccess")));
					if ($UserAction == "setpasswordexpired")
						$this->setSuccessMessage(str_replace('%u', $userlist, $Language->Phrase("SetPasswordExpiredSuccess")));
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes
					if ($UserAction == "resendregisteremail")
						$this->setFailureMessage(str_replace('%u', $userlist, $Language->Phrase("ResendRegisterEmailFailure")));
					if ($UserAction == "resetconcurrentuser")
						$this->setFailureMessage(str_replace('%u', $user, $Language->Phrase("ResetConcurrentUserFailure")));
					if ($UserAction == "resetloginretry")
						$this->setFailureMessage(str_replace('%u', $user, $Language->Phrase("ResetLoginRetryFailure")));
					if ($UserAction == "setpasswordexpired")
						$this->setFailureMessage(str_replace('%u', $user, $Language->Phrase("SetPasswordExpiredFailure")));

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fmain_Userlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;

		// Hide detail items for dropdown if necessary
		$this->ListOptions->HideDetailItemsForDropDown();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

		// u_Email
		$this->u_Email->ViewValue = $this->u_Email->CurrentValue;
		$this->u_Email->ViewCustomAttributes = "";

		// u_Mobile
		$this->u_Mobile->ViewValue = $this->u_Mobile->CurrentValue;
		$this->u_Mobile->ViewCustomAttributes = "";

		// u_Status
		if (strval($this->u_Status->CurrentValue) <> "") {
			$this->u_Status->ViewValue = $this->u_Status->OptionCaption($this->u_Status->CurrentValue);
		} else {
			$this->u_Status->ViewValue = NULL;
		}
		$this->u_Status->ViewCustomAttributes = "";

			// u_BillName
			$this->u_BillName->LinkCustomAttributes = "";
			$this->u_BillName->HrefValue = "";
			$this->u_BillName->TooltipValue = "";

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

			// u_Status
			$this->u_Status->LinkCustomAttributes = "";
			$this->u_Status->HrefValue = "";
			$this->u_Status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_main_User\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_main_User',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fmain_Userlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($main_User_list)) $main_User_list = new cmain_User_list();

// Page init
$main_User_list->Page_Init();

// Page main
$main_User_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_User_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($main_User->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fmain_Userlist = new ew_Form("fmain_Userlist", "list");
fmain_Userlist.FormKeyCountName = '<?php echo $main_User_list->FormKeyCountName ?>';

// Form_CustomValidate event
fmain_Userlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Userlist.ValidateRequired = true;
<?php } else { ?>
fmain_Userlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Userlist.Lists["x_u_Status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Userlist.Lists["x_u_Status"].Options = <?php echo json_encode($main_User->u_Status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fmain_Userlistsrch = new ew_Form("fmain_Userlistsrch");
</script>
<style type="text/css">
.ewTablePreviewRow { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ewTablePreviewRow .ewGrid {
	display: table;
}
.ewTablePreviewRow .ewGrid .ewTable {
	width: auto;
}
</style>
<div id="ewPreview" class="hide"><ul class="nav nav-tabs"></ul><div class="tab-content"><div class="tab-pane fade"></div></div></div>
<script type="text/javascript" src="phpjs/ewpreview.min.js"></script>
<script type="text/javascript">
var EW_PREVIEW_PLACEMENT = EW_CSS_FLIP ? "right" : "left";
var EW_PREVIEW_SINGLE_ROW = false;
var EW_PREVIEW_OVERLAY = false;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($main_User->Export == "") { ?>
<div class="ewToolbar">
<?php if ($main_User->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($main_User_list->TotalRecs > 0 && $main_User_list->ExportOptions->Visible()) { ?>
<?php $main_User_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($main_User_list->SearchOptions->Visible()) { ?>
<?php $main_User_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($main_User_list->FilterOptions->Visible()) { ?>
<?php $main_User_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($main_User->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $main_User_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($main_User_list->TotalRecs <= 0)
			$main_User_list->TotalRecs = $main_User->SelectRecordCount();
	} else {
		if (!$main_User_list->Recordset && ($main_User_list->Recordset = $main_User_list->LoadRecordset()))
			$main_User_list->TotalRecs = $main_User_list->Recordset->RecordCount();
	}
	$main_User_list->StartRec = 1;
	if ($main_User_list->DisplayRecs <= 0 || ($main_User->Export <> "" && $main_User->ExportAll)) // Display all records
		$main_User_list->DisplayRecs = $main_User_list->TotalRecs;
	if (!($main_User->Export <> "" && $main_User->ExportAll))
		$main_User_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$main_User_list->Recordset = $main_User_list->LoadRecordset($main_User_list->StartRec-1, $main_User_list->DisplayRecs);

	// Set no record found message
	if ($main_User->CurrentAction == "" && $main_User_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$main_User_list->setWarningMessage(ew_DeniedMsg());
		if ($main_User_list->SearchWhere == "0=101")
			$main_User_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$main_User_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$main_User_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($main_User->Export == "" && $main_User->CurrentAction == "") { ?>
<form name="fmain_Userlistsrch" id="fmain_Userlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($main_User_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fmain_Userlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_User">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($main_User_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($main_User_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $main_User_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($main_User_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($main_User_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($main_User_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($main_User_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $main_User_list->ShowPageHeader(); ?>
<?php
$main_User_list->ShowMessage();
?>
<?php if ($main_User_list->TotalRecs > 0 || $main_User->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($main_User->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($main_User->CurrentAction <> "gridadd" && $main_User->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($main_User_list->Pager)) $main_User_list->Pager = new cPrevNextPager($main_User_list->StartRec, $main_User_list->DisplayRecs, $main_User_list->TotalRecs) ?>
<?php if ($main_User_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($main_User_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $main_User_list->PageUrl() ?>start=<?php echo $main_User_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($main_User_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $main_User_list->PageUrl() ?>start=<?php echo $main_User_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $main_User_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($main_User_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $main_User_list->PageUrl() ?>start=<?php echo $main_User_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($main_User_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $main_User_list->PageUrl() ?>start=<?php echo $main_User_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $main_User_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $main_User_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $main_User_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $main_User_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($main_User_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmain_Userlist" id="fmain_Userlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_User_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_User_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_User">
<div id="gmp_main_User" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($main_User_list->TotalRecs > 0) { ?>
<table id="tbl_main_Userlist" class="table ewTable">
<?php echo $main_User->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$main_User_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$main_User_list->RenderListOptions();

// Render list options (header, left)
$main_User_list->ListOptions->Render("header", "left");
?>
<?php if ($main_User->u_BillName->Visible) { // u_BillName ?>
	<?php if ($main_User->SortUrl($main_User->u_BillName) == "") { ?>
		<th data-name="u_BillName"><div id="elh_main_User_u_BillName" class="main_User_u_BillName"><div class="ewTableHeaderCaption"><?php echo $main_User->u_BillName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="u_BillName"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_User->SortUrl($main_User->u_BillName) ?>',1);"><div id="elh_main_User_u_BillName" class="main_User_u_BillName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_User->u_BillName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($main_User->u_BillName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_User->u_BillName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_User->u_Email->Visible) { // u_Email ?>
	<?php if ($main_User->SortUrl($main_User->u_Email) == "") { ?>
		<th data-name="u_Email"><div id="elh_main_User_u_Email" class="main_User_u_Email"><div class="ewTableHeaderCaption"><?php echo $main_User->u_Email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="u_Email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_User->SortUrl($main_User->u_Email) ?>',1);"><div id="elh_main_User_u_Email" class="main_User_u_Email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_User->u_Email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($main_User->u_Email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_User->u_Email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_User->u_Mobile->Visible) { // u_Mobile ?>
	<?php if ($main_User->SortUrl($main_User->u_Mobile) == "") { ?>
		<th data-name="u_Mobile"><div id="elh_main_User_u_Mobile" class="main_User_u_Mobile"><div class="ewTableHeaderCaption"><?php echo $main_User->u_Mobile->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="u_Mobile"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_User->SortUrl($main_User->u_Mobile) ?>',1);"><div id="elh_main_User_u_Mobile" class="main_User_u_Mobile">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_User->u_Mobile->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($main_User->u_Mobile->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_User->u_Mobile->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_User->u_Status->Visible) { // u_Status ?>
	<?php if ($main_User->SortUrl($main_User->u_Status) == "") { ?>
		<th data-name="u_Status"><div id="elh_main_User_u_Status" class="main_User_u_Status"><div class="ewTableHeaderCaption"><?php echo $main_User->u_Status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="u_Status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_User->SortUrl($main_User->u_Status) ?>',1);"><div id="elh_main_User_u_Status" class="main_User_u_Status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_User->u_Status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_User->u_Status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_User->u_Status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$main_User_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($main_User->ExportAll && $main_User->Export <> "") {
	$main_User_list->StopRec = $main_User_list->TotalRecs;
} else {

	// Set the last record to display
	if ($main_User_list->TotalRecs > $main_User_list->StartRec + $main_User_list->DisplayRecs - 1)
		$main_User_list->StopRec = $main_User_list->StartRec + $main_User_list->DisplayRecs - 1;
	else
		$main_User_list->StopRec = $main_User_list->TotalRecs;
}
$main_User_list->RecCnt = $main_User_list->StartRec - 1;
if ($main_User_list->Recordset && !$main_User_list->Recordset->EOF) {
	$main_User_list->Recordset->MoveFirst();
	$bSelectLimit = $main_User_list->UseSelectLimit;
	if (!$bSelectLimit && $main_User_list->StartRec > 1)
		$main_User_list->Recordset->Move($main_User_list->StartRec - 1);
} elseif (!$main_User->AllowAddDeleteRow && $main_User_list->StopRec == 0) {
	$main_User_list->StopRec = $main_User->GridAddRowCount;
}

// Initialize aggregate
$main_User->RowType = EW_ROWTYPE_AGGREGATEINIT;
$main_User->ResetAttrs();
$main_User_list->RenderRow();
while ($main_User_list->RecCnt < $main_User_list->StopRec) {
	$main_User_list->RecCnt++;
	if (intval($main_User_list->RecCnt) >= intval($main_User_list->StartRec)) {
		$main_User_list->RowCnt++;

		// Set up key count
		$main_User_list->KeyCount = $main_User_list->RowIndex;

		// Init row class and style
		$main_User->ResetAttrs();
		$main_User->CssClass = "";
		if ($main_User->CurrentAction == "gridadd") {
		} else {
			$main_User_list->LoadRowValues($main_User_list->Recordset); // Load row values
		}
		$main_User->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$main_User->RowAttrs = array_merge($main_User->RowAttrs, array('data-rowindex'=>$main_User_list->RowCnt, 'id'=>'r' . $main_User_list->RowCnt . '_main_User', 'data-rowtype'=>$main_User->RowType));

		// Render row
		$main_User_list->RenderRow();

		// Render list options
		$main_User_list->RenderListOptions();
?>
	<tr<?php echo $main_User->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_User_list->ListOptions->Render("body", "left", $main_User_list->RowCnt);
?>
	<?php if ($main_User->u_BillName->Visible) { // u_BillName ?>
		<td data-name="u_BillName"<?php echo $main_User->u_BillName->CellAttributes() ?>>
<span id="el<?php echo $main_User_list->RowCnt ?>_main_User_u_BillName" class="main_User_u_BillName">
<span<?php echo $main_User->u_BillName->ViewAttributes() ?>>
<?php echo $main_User->u_BillName->ListViewValue() ?></span>
</span>
<a id="<?php echo $main_User_list->PageObjName . "_row_" . $main_User_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($main_User->u_Email->Visible) { // u_Email ?>
		<td data-name="u_Email"<?php echo $main_User->u_Email->CellAttributes() ?>>
<span id="el<?php echo $main_User_list->RowCnt ?>_main_User_u_Email" class="main_User_u_Email">
<span<?php echo $main_User->u_Email->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($main_User->u_Email->ListViewValue())) && $main_User->u_Email->LinkAttributes() <> "") { ?>
<a<?php echo $main_User->u_Email->LinkAttributes() ?>><?php echo $main_User->u_Email->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $main_User->u_Email->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($main_User->u_Mobile->Visible) { // u_Mobile ?>
		<td data-name="u_Mobile"<?php echo $main_User->u_Mobile->CellAttributes() ?>>
<span id="el<?php echo $main_User_list->RowCnt ?>_main_User_u_Mobile" class="main_User_u_Mobile">
<span<?php echo $main_User->u_Mobile->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($main_User->u_Mobile->ListViewValue())) && $main_User->u_Mobile->LinkAttributes() <> "") { ?>
<a<?php echo $main_User->u_Mobile->LinkAttributes() ?>><?php echo $main_User->u_Mobile->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $main_User->u_Mobile->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($main_User->u_Status->Visible) { // u_Status ?>
		<td data-name="u_Status"<?php echo $main_User->u_Status->CellAttributes() ?>>
<span id="el<?php echo $main_User_list->RowCnt ?>_main_User_u_Status" class="main_User_u_Status">
<span<?php echo $main_User->u_Status->ViewAttributes() ?>>
<?php echo $main_User->u_Status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_User_list->ListOptions->Render("body", "right", $main_User_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($main_User->CurrentAction <> "gridadd")
		$main_User_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($main_User->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($main_User_list->Recordset)
	$main_User_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($main_User_list->TotalRecs == 0 && $main_User->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($main_User_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($main_User->Export == "") { ?>
<script type="text/javascript">
fmain_Userlistsrch.Init();
fmain_Userlistsrch.FilterList = <?php echo $main_User_list->GetFilterList() ?>;
fmain_Userlist.Init();
</script>
<?php } ?>
<?php
$main_User_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($main_User->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$main_User_list->Page_Terminate();
?>
