<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "lov_intstatus_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$lov_intStatus_list = NULL; // Initialize page object first

class clov_intStatus_list extends clov_intStatus {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'lov_intStatus';

	// Page object name
	var $PageObjName = 'lov_intStatus_list';

	// Grid form hidden field names
	var $FormName = 'flov_intStatuslist';
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

		// Table object (lov_intStatus)
		if (!isset($GLOBALS["lov_intStatus"]) || get_class($GLOBALS["lov_intStatus"]) == "clov_intStatus") {
			$GLOBALS["lov_intStatus"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lov_intStatus"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "lov_intstatus_add.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "lov_intstatus_delete.php";
		$this->MultiUpdateUrl = "lov_intstatus_update.php";

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lov_intStatus', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption flov_intStatuslistsrch";

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
		global $EW_EXPORT, $lov_intStatus;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($lov_intStatus);
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
			$this->in_ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->in_ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->in_ID->AdvancedSearch->ToJSON(), ","); // Field in_ID
		$sFilterList = ew_Concat($sFilterList, $this->in_Name->AdvancedSearch->ToJSON(), ","); // Field in_Name
		$sFilterList = ew_Concat($sFilterList, $this->in_isDeath->AdvancedSearch->ToJSON(), ","); // Field in_isDeath
		$sFilterList = ew_Concat($sFilterList, $this->in_isSale->AdvancedSearch->ToJSON(), ","); // Field in_isSale
		$sFilterList = ew_Concat($sFilterList, $this->is_InternalUse->AdvancedSearch->ToJSON(), ","); // Field is_InternalUse
		$sFilterList = ew_Concat($sFilterList, $this->in_Created->AdvancedSearch->ToJSON(), ","); // Field in_Created
		$sFilterList = ew_Concat($sFilterList, $this->in_Updated->AdvancedSearch->ToJSON(), ","); // Field in_Updated
		$sFilterList = ew_Concat($sFilterList, $this->in_Note->AdvancedSearch->ToJSON(), ","); // Field in_Note
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

		// Field in_ID
		$this->in_ID->AdvancedSearch->SearchValue = @$filter["x_in_ID"];
		$this->in_ID->AdvancedSearch->SearchOperator = @$filter["z_in_ID"];
		$this->in_ID->AdvancedSearch->SearchCondition = @$filter["v_in_ID"];
		$this->in_ID->AdvancedSearch->SearchValue2 = @$filter["y_in_ID"];
		$this->in_ID->AdvancedSearch->SearchOperator2 = @$filter["w_in_ID"];
		$this->in_ID->AdvancedSearch->Save();

		// Field in_Name
		$this->in_Name->AdvancedSearch->SearchValue = @$filter["x_in_Name"];
		$this->in_Name->AdvancedSearch->SearchOperator = @$filter["z_in_Name"];
		$this->in_Name->AdvancedSearch->SearchCondition = @$filter["v_in_Name"];
		$this->in_Name->AdvancedSearch->SearchValue2 = @$filter["y_in_Name"];
		$this->in_Name->AdvancedSearch->SearchOperator2 = @$filter["w_in_Name"];
		$this->in_Name->AdvancedSearch->Save();

		// Field in_isDeath
		$this->in_isDeath->AdvancedSearch->SearchValue = @$filter["x_in_isDeath"];
		$this->in_isDeath->AdvancedSearch->SearchOperator = @$filter["z_in_isDeath"];
		$this->in_isDeath->AdvancedSearch->SearchCondition = @$filter["v_in_isDeath"];
		$this->in_isDeath->AdvancedSearch->SearchValue2 = @$filter["y_in_isDeath"];
		$this->in_isDeath->AdvancedSearch->SearchOperator2 = @$filter["w_in_isDeath"];
		$this->in_isDeath->AdvancedSearch->Save();

		// Field in_isSale
		$this->in_isSale->AdvancedSearch->SearchValue = @$filter["x_in_isSale"];
		$this->in_isSale->AdvancedSearch->SearchOperator = @$filter["z_in_isSale"];
		$this->in_isSale->AdvancedSearch->SearchCondition = @$filter["v_in_isSale"];
		$this->in_isSale->AdvancedSearch->SearchValue2 = @$filter["y_in_isSale"];
		$this->in_isSale->AdvancedSearch->SearchOperator2 = @$filter["w_in_isSale"];
		$this->in_isSale->AdvancedSearch->Save();

		// Field is_InternalUse
		$this->is_InternalUse->AdvancedSearch->SearchValue = @$filter["x_is_InternalUse"];
		$this->is_InternalUse->AdvancedSearch->SearchOperator = @$filter["z_is_InternalUse"];
		$this->is_InternalUse->AdvancedSearch->SearchCondition = @$filter["v_is_InternalUse"];
		$this->is_InternalUse->AdvancedSearch->SearchValue2 = @$filter["y_is_InternalUse"];
		$this->is_InternalUse->AdvancedSearch->SearchOperator2 = @$filter["w_is_InternalUse"];
		$this->is_InternalUse->AdvancedSearch->Save();

		// Field in_Created
		$this->in_Created->AdvancedSearch->SearchValue = @$filter["x_in_Created"];
		$this->in_Created->AdvancedSearch->SearchOperator = @$filter["z_in_Created"];
		$this->in_Created->AdvancedSearch->SearchCondition = @$filter["v_in_Created"];
		$this->in_Created->AdvancedSearch->SearchValue2 = @$filter["y_in_Created"];
		$this->in_Created->AdvancedSearch->SearchOperator2 = @$filter["w_in_Created"];
		$this->in_Created->AdvancedSearch->Save();

		// Field in_Updated
		$this->in_Updated->AdvancedSearch->SearchValue = @$filter["x_in_Updated"];
		$this->in_Updated->AdvancedSearch->SearchOperator = @$filter["z_in_Updated"];
		$this->in_Updated->AdvancedSearch->SearchCondition = @$filter["v_in_Updated"];
		$this->in_Updated->AdvancedSearch->SearchValue2 = @$filter["y_in_Updated"];
		$this->in_Updated->AdvancedSearch->SearchOperator2 = @$filter["w_in_Updated"];
		$this->in_Updated->AdvancedSearch->Save();

		// Field in_Note
		$this->in_Note->AdvancedSearch->SearchValue = @$filter["x_in_Note"];
		$this->in_Note->AdvancedSearch->SearchOperator = @$filter["z_in_Note"];
		$this->in_Note->AdvancedSearch->SearchCondition = @$filter["v_in_Note"];
		$this->in_Note->AdvancedSearch->SearchValue2 = @$filter["y_in_Note"];
		$this->in_Note->AdvancedSearch->SearchOperator2 = @$filter["w_in_Note"];
		$this->in_Note->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->in_Name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->in_Note, $arKeywords, $type);
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
			$this->UpdateSort($this->in_Name); // in_Name
			$this->UpdateSort($this->in_isDeath); // in_isDeath
			$this->UpdateSort($this->in_isSale); // in_isSale
			$this->UpdateSort($this->is_InternalUse); // is_InternalUse
			$this->UpdateSort($this->in_Created); // in_Created
			$this->UpdateSort($this->in_Updated); // in_Updated
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
				$this->in_Name->setSort("");
				$this->in_isDeath->setSort("");
				$this->in_isSale->setSort("");
				$this->is_InternalUse->setSort("");
				$this->in_Created->setSort("");
				$this->in_Updated->setSort("");
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

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
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

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->in_ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"flov_intStatuslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"flov_intStatuslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.flov_intStatuslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"flov_intStatuslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->in_ID->setDbValue($rs->fields('in_ID'));
		$this->in_Name->setDbValue($rs->fields('in_Name'));
		$this->in_isDeath->setDbValue($rs->fields('in_isDeath'));
		$this->in_isSale->setDbValue($rs->fields('in_isSale'));
		$this->is_InternalUse->setDbValue($rs->fields('is_InternalUse'));
		$this->in_Created->setDbValue($rs->fields('in_Created'));
		$this->in_Updated->setDbValue($rs->fields('in_Updated'));
		$this->in_Note->setDbValue($rs->fields('in_Note'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->in_ID->DbValue = $row['in_ID'];
		$this->in_Name->DbValue = $row['in_Name'];
		$this->in_isDeath->DbValue = $row['in_isDeath'];
		$this->in_isSale->DbValue = $row['in_isSale'];
		$this->is_InternalUse->DbValue = $row['is_InternalUse'];
		$this->in_Created->DbValue = $row['in_Created'];
		$this->in_Updated->DbValue = $row['in_Updated'];
		$this->in_Note->DbValue = $row['in_Note'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("in_ID")) <> "")
			$this->in_ID->CurrentValue = $this->getKey("in_ID"); // in_ID
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
		// in_ID

		$this->in_ID->CellCssStyle = "white-space: nowrap;";

		// in_Name
		// in_isDeath
		// in_isSale
		// is_InternalUse
		// in_Created
		// in_Updated
		// in_Note

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// in_Name
		$this->in_Name->ViewValue = $this->in_Name->CurrentValue;
		$this->in_Name->ViewCustomAttributes = "";

		// in_isDeath
		if (strval($this->in_isDeath->CurrentValue) <> "") {
			$this->in_isDeath->ViewValue = $this->in_isDeath->OptionCaption($this->in_isDeath->CurrentValue);
		} else {
			$this->in_isDeath->ViewValue = NULL;
		}
		$this->in_isDeath->ViewCustomAttributes = "";

		// in_isSale
		if (strval($this->in_isSale->CurrentValue) <> "") {
			$this->in_isSale->ViewValue = $this->in_isSale->OptionCaption($this->in_isSale->CurrentValue);
		} else {
			$this->in_isSale->ViewValue = NULL;
		}
		$this->in_isSale->ViewCustomAttributes = "";

		// is_InternalUse
		$this->is_InternalUse->ViewValue = $this->is_InternalUse->CurrentValue;
		$this->is_InternalUse->ViewCustomAttributes = "";

		// in_Created
		$this->in_Created->ViewValue = $this->in_Created->CurrentValue;
		$this->in_Created->ViewValue = ew_FormatDateTime($this->in_Created->ViewValue, 7);
		$this->in_Created->ViewCustomAttributes = "";

		// in_Updated
		$this->in_Updated->ViewValue = $this->in_Updated->CurrentValue;
		$this->in_Updated->ViewValue = ew_FormatDateTime($this->in_Updated->ViewValue, 7);
		$this->in_Updated->ViewCustomAttributes = "";

			// in_Name
			$this->in_Name->LinkCustomAttributes = "";
			$this->in_Name->HrefValue = "";
			$this->in_Name->TooltipValue = "";

			// in_isDeath
			$this->in_isDeath->LinkCustomAttributes = "";
			$this->in_isDeath->HrefValue = "";
			$this->in_isDeath->TooltipValue = "";

			// in_isSale
			$this->in_isSale->LinkCustomAttributes = "";
			$this->in_isSale->HrefValue = "";
			$this->in_isSale->TooltipValue = "";

			// is_InternalUse
			$this->is_InternalUse->LinkCustomAttributes = "";
			$this->is_InternalUse->HrefValue = "";
			$this->is_InternalUse->TooltipValue = "";

			// in_Created
			$this->in_Created->LinkCustomAttributes = "";
			$this->in_Created->HrefValue = "";
			$this->in_Created->TooltipValue = "";

			// in_Updated
			$this->in_Updated->LinkCustomAttributes = "";
			$this->in_Updated->HrefValue = "";
			$this->in_Updated->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_lov_intStatus\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_lov_intStatus',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.flov_intStatuslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($lov_intStatus_list)) $lov_intStatus_list = new clov_intStatus_list();

// Page init
$lov_intStatus_list->Page_Init();

// Page main
$lov_intStatus_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lov_intStatus_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($lov_intStatus->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = flov_intStatuslist = new ew_Form("flov_intStatuslist", "list");
flov_intStatuslist.FormKeyCountName = '<?php echo $lov_intStatus_list->FormKeyCountName ?>';

// Form_CustomValidate event
flov_intStatuslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flov_intStatuslist.ValidateRequired = true;
<?php } else { ?>
flov_intStatuslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flov_intStatuslist.Lists["x_in_isDeath"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_intStatuslist.Lists["x_in_isDeath"].Options = <?php echo json_encode($lov_intStatus->in_isDeath->Options()) ?>;
flov_intStatuslist.Lists["x_in_isSale"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
flov_intStatuslist.Lists["x_in_isSale"].Options = <?php echo json_encode($lov_intStatus->in_isSale->Options()) ?>;

// Form object for search
var CurrentSearchForm = flov_intStatuslistsrch = new ew_Form("flov_intStatuslistsrch");
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
<?php if ($lov_intStatus->Export == "") { ?>
<div class="ewToolbar">
<?php if ($lov_intStatus->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($lov_intStatus_list->TotalRecs > 0 && $lov_intStatus_list->ExportOptions->Visible()) { ?>
<?php $lov_intStatus_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($lov_intStatus_list->SearchOptions->Visible()) { ?>
<?php $lov_intStatus_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($lov_intStatus_list->FilterOptions->Visible()) { ?>
<?php $lov_intStatus_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($lov_intStatus->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $lov_intStatus_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($lov_intStatus_list->TotalRecs <= 0)
			$lov_intStatus_list->TotalRecs = $lov_intStatus->SelectRecordCount();
	} else {
		if (!$lov_intStatus_list->Recordset && ($lov_intStatus_list->Recordset = $lov_intStatus_list->LoadRecordset()))
			$lov_intStatus_list->TotalRecs = $lov_intStatus_list->Recordset->RecordCount();
	}
	$lov_intStatus_list->StartRec = 1;
	if ($lov_intStatus_list->DisplayRecs <= 0 || ($lov_intStatus->Export <> "" && $lov_intStatus->ExportAll)) // Display all records
		$lov_intStatus_list->DisplayRecs = $lov_intStatus_list->TotalRecs;
	if (!($lov_intStatus->Export <> "" && $lov_intStatus->ExportAll))
		$lov_intStatus_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$lov_intStatus_list->Recordset = $lov_intStatus_list->LoadRecordset($lov_intStatus_list->StartRec-1, $lov_intStatus_list->DisplayRecs);

	// Set no record found message
	if ($lov_intStatus->CurrentAction == "" && $lov_intStatus_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$lov_intStatus_list->setWarningMessage(ew_DeniedMsg());
		if ($lov_intStatus_list->SearchWhere == "0=101")
			$lov_intStatus_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$lov_intStatus_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$lov_intStatus_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($lov_intStatus->Export == "" && $lov_intStatus->CurrentAction == "") { ?>
<form name="flov_intStatuslistsrch" id="flov_intStatuslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($lov_intStatus_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="flov_intStatuslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lov_intStatus">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($lov_intStatus_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($lov_intStatus_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $lov_intStatus_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($lov_intStatus_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($lov_intStatus_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($lov_intStatus_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($lov_intStatus_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $lov_intStatus_list->ShowPageHeader(); ?>
<?php
$lov_intStatus_list->ShowMessage();
?>
<?php if ($lov_intStatus_list->TotalRecs > 0 || $lov_intStatus->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($lov_intStatus->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($lov_intStatus->CurrentAction <> "gridadd" && $lov_intStatus->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($lov_intStatus_list->Pager)) $lov_intStatus_list->Pager = new cPrevNextPager($lov_intStatus_list->StartRec, $lov_intStatus_list->DisplayRecs, $lov_intStatus_list->TotalRecs) ?>
<?php if ($lov_intStatus_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($lov_intStatus_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $lov_intStatus_list->PageUrl() ?>start=<?php echo $lov_intStatus_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($lov_intStatus_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $lov_intStatus_list->PageUrl() ?>start=<?php echo $lov_intStatus_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $lov_intStatus_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($lov_intStatus_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $lov_intStatus_list->PageUrl() ?>start=<?php echo $lov_intStatus_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($lov_intStatus_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $lov_intStatus_list->PageUrl() ?>start=<?php echo $lov_intStatus_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lov_intStatus_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lov_intStatus_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lov_intStatus_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lov_intStatus_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($lov_intStatus_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flov_intStatuslist" id="flov_intStatuslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($lov_intStatus_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $lov_intStatus_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lov_intStatus">
<div id="gmp_lov_intStatus" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($lov_intStatus_list->TotalRecs > 0) { ?>
<table id="tbl_lov_intStatuslist" class="table ewTable">
<?php echo $lov_intStatus->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$lov_intStatus_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$lov_intStatus_list->RenderListOptions();

// Render list options (header, left)
$lov_intStatus_list->ListOptions->Render("header", "left");
?>
<?php if ($lov_intStatus->in_Name->Visible) { // in_Name ?>
	<?php if ($lov_intStatus->SortUrl($lov_intStatus->in_Name) == "") { ?>
		<th data-name="in_Name"><div id="elh_lov_intStatus_in_Name" class="lov_intStatus_in_Name"><div class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_Name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="in_Name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $lov_intStatus->SortUrl($lov_intStatus->in_Name) ?>',1);"><div id="elh_lov_intStatus_in_Name" class="lov_intStatus_in_Name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_Name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($lov_intStatus->in_Name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_intStatus->in_Name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_intStatus->in_isDeath->Visible) { // in_isDeath ?>
	<?php if ($lov_intStatus->SortUrl($lov_intStatus->in_isDeath) == "") { ?>
		<th data-name="in_isDeath"><div id="elh_lov_intStatus_in_isDeath" class="lov_intStatus_in_isDeath"><div class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_isDeath->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="in_isDeath"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $lov_intStatus->SortUrl($lov_intStatus->in_isDeath) ?>',1);"><div id="elh_lov_intStatus_in_isDeath" class="lov_intStatus_in_isDeath">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_isDeath->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_intStatus->in_isDeath->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_intStatus->in_isDeath->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_intStatus->in_isSale->Visible) { // in_isSale ?>
	<?php if ($lov_intStatus->SortUrl($lov_intStatus->in_isSale) == "") { ?>
		<th data-name="in_isSale"><div id="elh_lov_intStatus_in_isSale" class="lov_intStatus_in_isSale"><div class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_isSale->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="in_isSale"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $lov_intStatus->SortUrl($lov_intStatus->in_isSale) ?>',1);"><div id="elh_lov_intStatus_in_isSale" class="lov_intStatus_in_isSale">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_isSale->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_intStatus->in_isSale->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_intStatus->in_isSale->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_intStatus->is_InternalUse->Visible) { // is_InternalUse ?>
	<?php if ($lov_intStatus->SortUrl($lov_intStatus->is_InternalUse) == "") { ?>
		<th data-name="is_InternalUse"><div id="elh_lov_intStatus_is_InternalUse" class="lov_intStatus_is_InternalUse"><div class="ewTableHeaderCaption"><?php echo $lov_intStatus->is_InternalUse->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_InternalUse"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $lov_intStatus->SortUrl($lov_intStatus->is_InternalUse) ?>',1);"><div id="elh_lov_intStatus_is_InternalUse" class="lov_intStatus_is_InternalUse">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_intStatus->is_InternalUse->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_intStatus->is_InternalUse->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_intStatus->is_InternalUse->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_intStatus->in_Created->Visible) { // in_Created ?>
	<?php if ($lov_intStatus->SortUrl($lov_intStatus->in_Created) == "") { ?>
		<th data-name="in_Created"><div id="elh_lov_intStatus_in_Created" class="lov_intStatus_in_Created"><div class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_Created->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="in_Created"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $lov_intStatus->SortUrl($lov_intStatus->in_Created) ?>',1);"><div id="elh_lov_intStatus_in_Created" class="lov_intStatus_in_Created">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_Created->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_intStatus->in_Created->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_intStatus->in_Created->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($lov_intStatus->in_Updated->Visible) { // in_Updated ?>
	<?php if ($lov_intStatus->SortUrl($lov_intStatus->in_Updated) == "") { ?>
		<th data-name="in_Updated"><div id="elh_lov_intStatus_in_Updated" class="lov_intStatus_in_Updated"><div class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_Updated->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="in_Updated"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $lov_intStatus->SortUrl($lov_intStatus->in_Updated) ?>',1);"><div id="elh_lov_intStatus_in_Updated" class="lov_intStatus_in_Updated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $lov_intStatus->in_Updated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($lov_intStatus->in_Updated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($lov_intStatus->in_Updated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$lov_intStatus_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lov_intStatus->ExportAll && $lov_intStatus->Export <> "") {
	$lov_intStatus_list->StopRec = $lov_intStatus_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lov_intStatus_list->TotalRecs > $lov_intStatus_list->StartRec + $lov_intStatus_list->DisplayRecs - 1)
		$lov_intStatus_list->StopRec = $lov_intStatus_list->StartRec + $lov_intStatus_list->DisplayRecs - 1;
	else
		$lov_intStatus_list->StopRec = $lov_intStatus_list->TotalRecs;
}
$lov_intStatus_list->RecCnt = $lov_intStatus_list->StartRec - 1;
if ($lov_intStatus_list->Recordset && !$lov_intStatus_list->Recordset->EOF) {
	$lov_intStatus_list->Recordset->MoveFirst();
	$bSelectLimit = $lov_intStatus_list->UseSelectLimit;
	if (!$bSelectLimit && $lov_intStatus_list->StartRec > 1)
		$lov_intStatus_list->Recordset->Move($lov_intStatus_list->StartRec - 1);
} elseif (!$lov_intStatus->AllowAddDeleteRow && $lov_intStatus_list->StopRec == 0) {
	$lov_intStatus_list->StopRec = $lov_intStatus->GridAddRowCount;
}

// Initialize aggregate
$lov_intStatus->RowType = EW_ROWTYPE_AGGREGATEINIT;
$lov_intStatus->ResetAttrs();
$lov_intStatus_list->RenderRow();
while ($lov_intStatus_list->RecCnt < $lov_intStatus_list->StopRec) {
	$lov_intStatus_list->RecCnt++;
	if (intval($lov_intStatus_list->RecCnt) >= intval($lov_intStatus_list->StartRec)) {
		$lov_intStatus_list->RowCnt++;

		// Set up key count
		$lov_intStatus_list->KeyCount = $lov_intStatus_list->RowIndex;

		// Init row class and style
		$lov_intStatus->ResetAttrs();
		$lov_intStatus->CssClass = "";
		if ($lov_intStatus->CurrentAction == "gridadd") {
		} else {
			$lov_intStatus_list->LoadRowValues($lov_intStatus_list->Recordset); // Load row values
		}
		$lov_intStatus->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lov_intStatus->RowAttrs = array_merge($lov_intStatus->RowAttrs, array('data-rowindex'=>$lov_intStatus_list->RowCnt, 'id'=>'r' . $lov_intStatus_list->RowCnt . '_lov_intStatus', 'data-rowtype'=>$lov_intStatus->RowType));

		// Render row
		$lov_intStatus_list->RenderRow();

		// Render list options
		$lov_intStatus_list->RenderListOptions();
?>
	<tr<?php echo $lov_intStatus->RowAttributes() ?>>
<?php

// Render list options (body, left)
$lov_intStatus_list->ListOptions->Render("body", "left", $lov_intStatus_list->RowCnt);
?>
	<?php if ($lov_intStatus->in_Name->Visible) { // in_Name ?>
		<td data-name="in_Name"<?php echo $lov_intStatus->in_Name->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_list->RowCnt ?>_lov_intStatus_in_Name" class="lov_intStatus_in_Name">
<span<?php echo $lov_intStatus->in_Name->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_Name->ListViewValue() ?></span>
</span>
<a id="<?php echo $lov_intStatus_list->PageObjName . "_row_" . $lov_intStatus_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($lov_intStatus->in_isDeath->Visible) { // in_isDeath ?>
		<td data-name="in_isDeath"<?php echo $lov_intStatus->in_isDeath->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_list->RowCnt ?>_lov_intStatus_in_isDeath" class="lov_intStatus_in_isDeath">
<span<?php echo $lov_intStatus->in_isDeath->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_isDeath->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lov_intStatus->in_isSale->Visible) { // in_isSale ?>
		<td data-name="in_isSale"<?php echo $lov_intStatus->in_isSale->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_list->RowCnt ?>_lov_intStatus_in_isSale" class="lov_intStatus_in_isSale">
<span<?php echo $lov_intStatus->in_isSale->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_isSale->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lov_intStatus->is_InternalUse->Visible) { // is_InternalUse ?>
		<td data-name="is_InternalUse"<?php echo $lov_intStatus->is_InternalUse->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_list->RowCnt ?>_lov_intStatus_is_InternalUse" class="lov_intStatus_is_InternalUse">
<span<?php echo $lov_intStatus->is_InternalUse->ViewAttributes() ?>>
<?php echo $lov_intStatus->is_InternalUse->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lov_intStatus->in_Created->Visible) { // in_Created ?>
		<td data-name="in_Created"<?php echo $lov_intStatus->in_Created->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_list->RowCnt ?>_lov_intStatus_in_Created" class="lov_intStatus_in_Created">
<span<?php echo $lov_intStatus->in_Created->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_Created->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lov_intStatus->in_Updated->Visible) { // in_Updated ?>
		<td data-name="in_Updated"<?php echo $lov_intStatus->in_Updated->CellAttributes() ?>>
<span id="el<?php echo $lov_intStatus_list->RowCnt ?>_lov_intStatus_in_Updated" class="lov_intStatus_in_Updated">
<span<?php echo $lov_intStatus->in_Updated->ViewAttributes() ?>>
<?php echo $lov_intStatus->in_Updated->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lov_intStatus_list->ListOptions->Render("body", "right", $lov_intStatus_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($lov_intStatus->CurrentAction <> "gridadd")
		$lov_intStatus_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($lov_intStatus->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($lov_intStatus_list->Recordset)
	$lov_intStatus_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($lov_intStatus_list->TotalRecs == 0 && $lov_intStatus->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($lov_intStatus_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($lov_intStatus->Export == "") { ?>
<script type="text/javascript">
flov_intStatuslistsrch.Init();
flov_intStatuslistsrch.FilterList = <?php echo $lov_intStatus_list->GetFilterList() ?>;
flov_intStatuslist.Init();
</script>
<?php } ?>
<?php
$lov_intStatus_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($lov_intStatus->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lov_intStatus_list->Page_Terminate();
?>
