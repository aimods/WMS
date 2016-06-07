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

$main_Product_list = NULL; // Initialize page object first

class cmain_Product_list extends cmain_Product {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_Product';

	// Page object name
	var $PageObjName = 'main_Product_list';

	// Grid form hidden field names
	var $FormName = 'fmain_Productlist';
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

		// Table object (main_Product)
		if (!isset($GLOBALS["main_Product"]) || get_class($GLOBALS["main_Product"]) == "cmain_Product") {
			$GLOBALS["main_Product"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_Product"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "main_product_add.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "main_product_delete.php";
		$this->MultiUpdateUrl = "main_product_update.php";

		// Table object (main_PartNum)
		if (!isset($GLOBALS['main_PartNum'])) $GLOBALS['main_PartNum'] = new cmain_PartNum();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fmain_Productlistsrch";

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

		// Create form object
		$objForm = new cFormObj();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "main_PartNum") {
			global $main_PartNum;
			$rsmaster = $main_PartNum->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("main_partnum_list.php"); // Return to master page
			} else {
				$main_PartNum->LoadListRowValues($rsmaster);
				$main_PartNum->RowType = EW_ROWTYPE_MASTER; // Master row
				$main_PartNum->RenderListRow();
				$rsmaster->Close();
			}
		}

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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("pr_ID", ""); // Clear inline edit key
		$this->pr_Cost->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["pr_ID"] <> "") {
			$this->pr_ID->setQueryStringValue($_GET["pr_ID"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("pr_ID", $this->pr_ID->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("pr_ID")) <> strval($this->pr_ID->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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
			$this->pr_ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->pr_ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->pr_ID->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_pr_Barcode") && $objForm->HasValue("o_pr_Barcode") && $this->pr_Barcode->CurrentValue <> $this->pr_Barcode->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pr_Activated") && $objForm->HasValue("o_pr_Activated") && $this->pr_Activated->CurrentValue <> $this->pr_Activated->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pr_Status") && $objForm->HasValue("o_pr_Status") && $this->pr_Status->CurrentValue <> $this->pr_Status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pr_PO") && $objForm->HasValue("o_pr_PO") && $this->pr_PO->CurrentValue <> $this->pr_PO->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pr_Cost") && $objForm->HasValue("o_pr_Cost") && $this->pr_Cost->CurrentValue <> $this->pr_Cost->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_pr_intStatus") && $objForm->HasValue("o_pr_intStatus") && $this->pr_intStatus->CurrentValue <> $this->pr_intStatus->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->pr_Barcode->AdvancedSearch->ToJSON(), ","); // Field pr_Barcode
		$sFilterList = ew_Concat($sFilterList, $this->pr_PO->AdvancedSearch->ToJSON(), ","); // Field pr_PO
		$sFilterList = ew_Concat($sFilterList, $this->pr_intStatus->AdvancedSearch->ToJSON(), ","); // Field pr_intStatus
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

		// Field pr_Barcode
		$this->pr_Barcode->AdvancedSearch->SearchValue = @$filter["x_pr_Barcode"];
		$this->pr_Barcode->AdvancedSearch->SearchOperator = @$filter["z_pr_Barcode"];
		$this->pr_Barcode->AdvancedSearch->SearchCondition = @$filter["v_pr_Barcode"];
		$this->pr_Barcode->AdvancedSearch->SearchValue2 = @$filter["y_pr_Barcode"];
		$this->pr_Barcode->AdvancedSearch->SearchOperator2 = @$filter["w_pr_Barcode"];
		$this->pr_Barcode->AdvancedSearch->Save();

		// Field pr_PO
		$this->pr_PO->AdvancedSearch->SearchValue = @$filter["x_pr_PO"];
		$this->pr_PO->AdvancedSearch->SearchOperator = @$filter["z_pr_PO"];
		$this->pr_PO->AdvancedSearch->SearchCondition = @$filter["v_pr_PO"];
		$this->pr_PO->AdvancedSearch->SearchValue2 = @$filter["y_pr_PO"];
		$this->pr_PO->AdvancedSearch->SearchOperator2 = @$filter["w_pr_PO"];
		$this->pr_PO->AdvancedSearch->Save();

		// Field pr_intStatus
		$this->pr_intStatus->AdvancedSearch->SearchValue = @$filter["x_pr_intStatus"];
		$this->pr_intStatus->AdvancedSearch->SearchOperator = @$filter["z_pr_intStatus"];
		$this->pr_intStatus->AdvancedSearch->SearchCondition = @$filter["v_pr_intStatus"];
		$this->pr_intStatus->AdvancedSearch->SearchValue2 = @$filter["y_pr_intStatus"];
		$this->pr_intStatus->AdvancedSearch->SearchOperator2 = @$filter["w_pr_intStatus"];
		$this->pr_intStatus->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->pr_Barcode, $Default, FALSE); // pr_Barcode
		$this->BuildSearchSql($sWhere, $this->pr_PO, $Default, FALSE); // pr_PO
		$this->BuildSearchSql($sWhere, $this->pr_intStatus, $Default, FALSE); // pr_intStatus

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->pr_Barcode->AdvancedSearch->Save(); // pr_Barcode
			$this->pr_PO->AdvancedSearch->Save(); // pr_PO
			$this->pr_intStatus->AdvancedSearch->Save(); // pr_intStatus
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->pr_Barcode, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pr_PO, $arKeywords, $type);
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
		if ($this->pr_Barcode->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pr_PO->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pr_intStatus->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->pr_Barcode->AdvancedSearch->UnsetSession();
		$this->pr_PO->AdvancedSearch->UnsetSession();
		$this->pr_intStatus->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->pr_Barcode->AdvancedSearch->Load();
		$this->pr_PO->AdvancedSearch->Load();
		$this->pr_intStatus->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->pr_Barcode); // pr_Barcode
			$this->UpdateSort($this->pr_Activated); // pr_Activated
			$this->UpdateSort($this->pr_Status); // pr_Status
			$this->UpdateSort($this->pr_PO); // pr_PO
			$this->UpdateSort($this->pr_Cost); // pr_Cost
			$this->UpdateSort($this->pr_intStatus); // pr_intStatus
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->pn_ID->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->pr_Barcode->setSort("");
				$this->pr_Activated->setSort("");
				$this->pr_Status->setSort("");
				$this->pr_PO->setSort("");
				$this->pr_Cost->setSort("");
				$this->pr_intStatus->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "detail_transaction_Movement"
		$item = &$this->ListOptions->Add("detail_transaction_Movement");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'transaction_Movement') && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["transaction_Movement_grid"])) $GLOBALS["transaction_Movement_grid"] = new ctransaction_Movement_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("transaction_Movement");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanEdit();
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->pr_ID->CurrentValue) . "\">";
			return;
		}

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
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_transaction_Movement"
		$oListOpt = &$this->ListOptions->Items["detail_transaction_Movement"];
		if ($Security->AllowList(CurrentProjectID() . 'transaction_Movement')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("transaction_Movement", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("transaction_movement_list.php?" . EW_TABLE_SHOW_MASTER . "=main_Product&fk_pr_ID=" . urlencode(strval($this->pr_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["transaction_Movement_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'transaction_Movement')) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=transaction_Movement")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "transaction_Movement";
			}
			if ($GLOBALS["transaction_Movement_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'transaction_Movement')) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=transaction_Movement")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "transaction_Movement";
			}
			if ($GLOBALS["transaction_Movement_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'transaction_Movement')) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=transaction_Movement")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "transaction_Movement";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->pr_ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->pr_ID->CurrentValue . "\">";
		}
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

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_transaction_Movement");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=transaction_Movement");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["transaction_Movement"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["transaction_Movement"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'transaction_Movement') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "transaction_Movement";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fmain_Productlist,url:'" . $this->MultiUpdateUrl . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
		$item->Visible = ($Security->CanEdit());

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fmain_Productlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fmain_Productlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fmain_Productlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fmain_Productlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		if (ew_IsMobile())
			$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"main_product_srch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<button type=\"button\" class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" onclick=\"ew_SearchDialogShow({lnk:this,url:'main_product_srch.php'});\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

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
		$links = "";
		$btngrps = "";
		$sSqlWrk = "`pr_ID`=" . ew_AdjustSql($this->pr_ID->CurrentValue, $this->DBID) . "";

		// Column "detail_transaction_Movement"
		if ($this->DetailPages->Items["transaction_Movement"]->Visible) {
			$link = "";
			$option = &$this->ListOptions->Items["detail_transaction_Movement"];
			$url = "transaction_movement_preview.php?t=main_Product&f=" . ew_Encrypt($sSqlWrk);
			$btngrp = "<div data-table=\"transaction_Movement\" data-url=\"" . $url . "\" class=\"btn-group\">";
			if ($Security->AllowList(CurrentProjectID() . 'transaction_Movement')) {			
				$label = $Language->TablePhrase("transaction_Movement", "TblCaption");
				$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"transaction_Movement\" data-url=\"" . $url . "\">" . $label . "</a></li>";			
				$links .= $link;
				$detaillnk = ew_JsEncode3("transaction_movement_list.php?" . EW_TABLE_SHOW_MASTER . "=main_Product&fk_pr_ID=" . urlencode(strval($this->pr_ID->CurrentValue)) . "");
				$btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . $Language->TablePhrase("transaction_Movement", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->Phrase("MasterDetailListLink") . "</button>";
			}
			if ($GLOBALS["transaction_Movement_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'transaction_Movement'))
				$btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" onclick=\"window.location='" . $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=transaction_Movement") . "'\">" . $Language->Phrase("MasterDetailViewLink") . "</button>";
			if ($GLOBALS["transaction_Movement_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'transaction_Movement'))
				$btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" onclick=\"window.location='" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=transaction_Movement") . "'\">" . $Language->Phrase("MasterDetailEditLink") . "</button>";
			$btngrp .= "</div>";
			if ($link <> "") {
				$btngrps .= $btngrp;
				$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
			}
		}

		// Hide detail items if necessary
		$this->ListOptions->HideDetailItemsForDropDown();

		// Column "preview"
		$option = &$this->ListOptions->GetItem("preview");
		if (!$option) { // Add preview column
			$option = &$this->ListOptions->Add("preview");
			$option->OnLeft = FALSE;
			if ($option->OnLeft) {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox") + 1);
			} else {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox"));
			}
			$option->Visible = !($this->Export <> "" || $this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit");
			$option->ShowInDropDown = FALSE;
			$option->ShowInButtonGroup = FALSE;
		}
		if ($option) {
			$option->Body = "<span class=\"ewPreviewRowBtn icon-expand\"></span>";
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}

		// Column "details" (Multiple details)
		$option = &$this->ListOptions->GetItem("details");
		if ($option) {
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}
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

	// Load default values
	function LoadDefaultValues() {
		$this->pr_Barcode->CurrentValue = NULL;
		$this->pr_Barcode->OldValue = $this->pr_Barcode->CurrentValue;
		$this->pr_Activated->CurrentValue = NULL;
		$this->pr_Activated->OldValue = $this->pr_Activated->CurrentValue;
		$this->pr_Status->CurrentValue = NULL;
		$this->pr_Status->OldValue = $this->pr_Status->CurrentValue;
		$this->pr_PO->CurrentValue = NULL;
		$this->pr_PO->OldValue = $this->pr_PO->CurrentValue;
		$this->pr_Cost->CurrentValue = NULL;
		$this->pr_Cost->OldValue = $this->pr_Cost->CurrentValue;
		$this->pr_intStatus->CurrentValue = NULL;
		$this->pr_intStatus->OldValue = $this->pr_intStatus->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// pr_Barcode

		$this->pr_Barcode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_pr_Barcode"]);
		if ($this->pr_Barcode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->pr_Barcode->AdvancedSearch->SearchOperator = @$_GET["z_pr_Barcode"];

		// pr_PO
		$this->pr_PO->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_pr_PO"]);
		if ($this->pr_PO->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->pr_PO->AdvancedSearch->SearchOperator = @$_GET["z_pr_PO"];

		// pr_intStatus
		$this->pr_intStatus->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_pr_intStatus"]);
		if ($this->pr_intStatus->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->pr_intStatus->AdvancedSearch->SearchOperator = @$_GET["z_pr_intStatus"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->pr_Barcode->FldIsDetailKey) {
			$this->pr_Barcode->setFormValue($objForm->GetValue("x_pr_Barcode"));
		}
		$this->pr_Barcode->setOldValue($objForm->GetValue("o_pr_Barcode"));
		if (!$this->pr_Activated->FldIsDetailKey) {
			$this->pr_Activated->setFormValue($objForm->GetValue("x_pr_Activated"));
			$this->pr_Activated->CurrentValue = ew_UnFormatDateTime($this->pr_Activated->CurrentValue, 7);
		}
		$this->pr_Activated->setOldValue($objForm->GetValue("o_pr_Activated"));
		if (!$this->pr_Status->FldIsDetailKey) {
			$this->pr_Status->setFormValue($objForm->GetValue("x_pr_Status"));
		}
		$this->pr_Status->setOldValue($objForm->GetValue("o_pr_Status"));
		if (!$this->pr_PO->FldIsDetailKey) {
			$this->pr_PO->setFormValue($objForm->GetValue("x_pr_PO"));
		}
		$this->pr_PO->setOldValue($objForm->GetValue("o_pr_PO"));
		if (!$this->pr_Cost->FldIsDetailKey) {
			$this->pr_Cost->setFormValue($objForm->GetValue("x_pr_Cost"));
		}
		$this->pr_Cost->setOldValue($objForm->GetValue("o_pr_Cost"));
		if (!$this->pr_intStatus->FldIsDetailKey) {
			$this->pr_intStatus->setFormValue($objForm->GetValue("x_pr_intStatus"));
		}
		$this->pr_intStatus->setOldValue($objForm->GetValue("o_pr_intStatus"));
		if (!$this->pr_ID->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->pr_ID->setFormValue($objForm->GetValue("x_pr_ID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->pr_ID->CurrentValue = $this->pr_ID->FormValue;
		$this->pr_Barcode->CurrentValue = $this->pr_Barcode->FormValue;
		$this->pr_Activated->CurrentValue = $this->pr_Activated->FormValue;
		$this->pr_Activated->CurrentValue = ew_UnFormatDateTime($this->pr_Activated->CurrentValue, 7);
		$this->pr_Status->CurrentValue = $this->pr_Status->FormValue;
		$this->pr_PO->CurrentValue = $this->pr_PO->FormValue;
		$this->pr_Cost->CurrentValue = $this->pr_Cost->FormValue;
		$this->pr_intStatus->CurrentValue = $this->pr_intStatus->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("pr_ID")) <> "")
			$this->pr_ID->CurrentValue = $this->getKey("pr_ID"); // pr_ID
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

		// Convert decimal values if posted back
		if ($this->pr_Cost->FormValue == $this->pr_Cost->CurrentValue && is_numeric(ew_StrToFloat($this->pr_Cost->CurrentValue)))
			$this->pr_Cost->CurrentValue = ew_StrToFloat($this->pr_Cost->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// pr_ID

		$this->pr_ID->CellCssStyle = "white-space: nowrap;";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pr_Barcode
			$this->pr_Barcode->EditAttrs["class"] = "form-control";
			$this->pr_Barcode->EditCustomAttributes = "";
			$this->pr_Barcode->EditValue = ew_HtmlEncode($this->pr_Barcode->CurrentValue);
			$this->pr_Barcode->PlaceHolder = ew_RemoveHtml($this->pr_Barcode->FldCaption());

			// pr_Activated
			$this->pr_Activated->EditAttrs["class"] = "form-control";
			$this->pr_Activated->EditCustomAttributes = "";
			$this->pr_Activated->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->pr_Activated->CurrentValue, 7));
			$this->pr_Activated->PlaceHolder = ew_RemoveHtml($this->pr_Activated->FldCaption());

			// pr_Status
			$this->pr_Status->EditCustomAttributes = "";
			if (trim(strval($this->pr_Status->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`ps_ID`" . ew_SearchString("=", $this->pr_Status->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lov_ProductStatus`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pr_Status, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->pr_Status->ViewValue = $this->pr_Status->DisplayValue($arwrk);
			} else {
				$this->pr_Status->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pr_Status->EditValue = $arwrk;

			// pr_PO
			$this->pr_PO->EditAttrs["class"] = "form-control";
			$this->pr_PO->EditCustomAttributes = "";
			$this->pr_PO->EditValue = ew_HtmlEncode($this->pr_PO->CurrentValue);
			$this->pr_PO->PlaceHolder = ew_RemoveHtml($this->pr_PO->FldCaption());

			// pr_Cost
			$this->pr_Cost->EditAttrs["class"] = "form-control";
			$this->pr_Cost->EditCustomAttributes = "";
			$this->pr_Cost->EditValue = ew_HtmlEncode($this->pr_Cost->CurrentValue);
			$this->pr_Cost->PlaceHolder = ew_RemoveHtml($this->pr_Cost->FldCaption());
			if (strval($this->pr_Cost->EditValue) <> "" && is_numeric($this->pr_Cost->EditValue)) {
			$this->pr_Cost->EditValue = ew_FormatNumber($this->pr_Cost->EditValue, -2, -1, -2, 0);
			$this->pr_Cost->OldValue = $this->pr_Cost->EditValue;
			}

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

			// Add refer script
			// pr_Barcode

			$this->pr_Barcode->LinkCustomAttributes = "";
			$this->pr_Barcode->HrefValue = "";

			// pr_Activated
			$this->pr_Activated->LinkCustomAttributes = "";
			$this->pr_Activated->HrefValue = "";

			// pr_Status
			$this->pr_Status->LinkCustomAttributes = "";
			$this->pr_Status->HrefValue = "";

			// pr_PO
			$this->pr_PO->LinkCustomAttributes = "";
			$this->pr_PO->HrefValue = "";

			// pr_Cost
			$this->pr_Cost->LinkCustomAttributes = "";
			$this->pr_Cost->HrefValue = "";

			// pr_intStatus
			$this->pr_intStatus->LinkCustomAttributes = "";
			$this->pr_intStatus->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			if (strval($this->pr_Cost->EditValue) <> "" && is_numeric($this->pr_Cost->EditValue)) {
			$this->pr_Cost->EditValue = ew_FormatNumber($this->pr_Cost->EditValue, -2, -1, -2, 0);
			$this->pr_Cost->OldValue = $this->pr_Cost->EditValue;
			}

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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->pr_Barcode->FldIsDetailKey && !is_null($this->pr_Barcode->FormValue) && $this->pr_Barcode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_Barcode->FldCaption(), $this->pr_Barcode->ReqErrMsg));
		}
		if (!$this->pr_Activated->FldIsDetailKey && !is_null($this->pr_Activated->FormValue) && $this->pr_Activated->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_Activated->FldCaption(), $this->pr_Activated->ReqErrMsg));
		}
		if (!$this->pr_Status->FldIsDetailKey && !is_null($this->pr_Status->FormValue) && $this->pr_Status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_Status->FldCaption(), $this->pr_Status->ReqErrMsg));
		}
		if (!$this->pr_PO->FldIsDetailKey && !is_null($this->pr_PO->FormValue) && $this->pr_PO->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pr_PO->FldCaption(), $this->pr_PO->ReqErrMsg));
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['pr_ID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		if ($this->pr_Barcode->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(pr_Barcode = '" . ew_AdjustSql($this->pr_Barcode->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->pr_Barcode->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->pr_Barcode->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// pr_Barcode
		$this->pr_Barcode->SetDbValueDef($rsnew, $this->pr_Barcode->CurrentValue, "", FALSE);

		// pr_Activated
		$this->pr_Activated->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->pr_Activated->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// pr_Status
		$this->pr_Status->SetDbValueDef($rsnew, $this->pr_Status->CurrentValue, 0, FALSE);

		// pr_PO
		$this->pr_PO->SetDbValueDef($rsnew, $this->pr_PO->CurrentValue, "", FALSE);

		// pr_Cost
		$this->pr_Cost->SetDbValueDef($rsnew, $this->pr_Cost->CurrentValue, 0, FALSE);

		// pr_intStatus
		$this->pr_intStatus->SetDbValueDef($rsnew, $this->pr_intStatus->CurrentValue, 0, FALSE);

		// pn_ID
		if ($this->pn_ID->getSessionValue() <> "") {
			$rsnew['pn_ID'] = $this->pn_ID->getSessionValue();
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
				$this->pr_ID->setDbValue($conn->Insert_ID());
				$rsnew['pr_ID'] = $this->pr_ID->DbValue;
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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->pr_Barcode->AdvancedSearch->Load();
		$this->pr_PO->AdvancedSearch->Load();
		$this->pr_intStatus->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_main_Product\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_main_Product',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fmain_Productlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "main_PartNum") {
			global $main_PartNum;
			if (!isset($main_PartNum)) $main_PartNum = new cmain_PartNum;
			$rsmaster = $main_PartNum->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$main_PartNum;
					$main_PartNum->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

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
if (!isset($main_Product_list)) $main_Product_list = new cmain_Product_list();

// Page init
$main_Product_list->Page_Init();

// Page main
$main_Product_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_Product_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($main_Product->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fmain_Productlist = new ew_Form("fmain_Productlist", "list");
fmain_Productlist.FormKeyCountName = '<?php echo $main_Product_list->FormKeyCountName ?>';

// Validate form
fmain_Productlist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_pr_Barcode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Barcode->FldCaption(), $main_Product->pr_Barcode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Activated");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Activated->FldCaption(), $main_Product->pr_Activated->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_Status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_Status->FldCaption(), $main_Product->pr_Status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pr_PO");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $main_Product->pr_PO->FldCaption(), $main_Product->pr_PO->ReqErrMsg)) ?>");
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fmain_Productlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "pr_Barcode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_Activated", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_Status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_PO", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_Cost", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pr_intStatus", false)) return false;
	return true;
}

// Form_CustomValidate event
fmain_Productlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_Productlist.ValidateRequired = true;
<?php } else { ?>
fmain_Productlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_Productlist.Lists["x_pr_Status"] = {"LinkField":"x_ps_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_ps_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_Productlist.Lists["x_pr_intStatus"] = {"LinkField":"x_in_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_in_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
var CurrentSearchForm = fmain_Productlistsrch = new ew_Form("fmain_Productlistsrch");
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
<?php if ($main_Product->Export == "") { ?>
<div class="ewToolbar">
<?php if ($main_Product->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($main_Product_list->TotalRecs > 0 && $main_Product_list->ExportOptions->Visible()) { ?>
<?php $main_Product_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($main_Product_list->SearchOptions->Visible()) { ?>
<?php $main_Product_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($main_Product_list->FilterOptions->Visible()) { ?>
<?php $main_Product_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($main_Product->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($main_Product->Export == "") || (EW_EXPORT_MASTER_RECORD && $main_Product->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "main_partnum_list.php";
if ($main_Product_list->DbMasterFilter <> "" && $main_Product->getCurrentMasterTable() == "main_PartNum") {
	if ($main_Product_list->MasterRecordExists) {
		if ($main_Product->getCurrentMasterTable() == $main_Product->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "main_partnum_master.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($main_Product->CurrentAction == "gridadd") {
	$main_Product->CurrentFilter = "0=1";
	$main_Product_list->StartRec = 1;
	$main_Product_list->DisplayRecs = $main_Product->GridAddRowCount;
	$main_Product_list->TotalRecs = $main_Product_list->DisplayRecs;
	$main_Product_list->StopRec = $main_Product_list->DisplayRecs;
} else {
	$bSelectLimit = $main_Product_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($main_Product_list->TotalRecs <= 0)
			$main_Product_list->TotalRecs = $main_Product->SelectRecordCount();
	} else {
		if (!$main_Product_list->Recordset && ($main_Product_list->Recordset = $main_Product_list->LoadRecordset()))
			$main_Product_list->TotalRecs = $main_Product_list->Recordset->RecordCount();
	}
	$main_Product_list->StartRec = 1;
	if ($main_Product_list->DisplayRecs <= 0 || ($main_Product->Export <> "" && $main_Product->ExportAll)) // Display all records
		$main_Product_list->DisplayRecs = $main_Product_list->TotalRecs;
	if (!($main_Product->Export <> "" && $main_Product->ExportAll))
		$main_Product_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$main_Product_list->Recordset = $main_Product_list->LoadRecordset($main_Product_list->StartRec-1, $main_Product_list->DisplayRecs);

	// Set no record found message
	if ($main_Product->CurrentAction == "" && $main_Product_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$main_Product_list->setWarningMessage(ew_DeniedMsg());
		if ($main_Product_list->SearchWhere == "0=101")
			$main_Product_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$main_Product_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$main_Product_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($main_Product->Export == "" && $main_Product->CurrentAction == "") { ?>
<form name="fmain_Productlistsrch" id="fmain_Productlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($main_Product_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fmain_Productlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="main_Product">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($main_Product_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($main_Product_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $main_Product_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($main_Product_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($main_Product_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($main_Product_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($main_Product_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $main_Product_list->ShowPageHeader(); ?>
<?php
$main_Product_list->ShowMessage();
?>
<?php if ($main_Product_list->TotalRecs > 0 || $main_Product->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($main_Product->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($main_Product->CurrentAction <> "gridadd" && $main_Product->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($main_Product_list->Pager)) $main_Product_list->Pager = new cPrevNextPager($main_Product_list->StartRec, $main_Product_list->DisplayRecs, $main_Product_list->TotalRecs) ?>
<?php if ($main_Product_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($main_Product_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $main_Product_list->PageUrl() ?>start=<?php echo $main_Product_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($main_Product_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $main_Product_list->PageUrl() ?>start=<?php echo $main_Product_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $main_Product_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($main_Product_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $main_Product_list->PageUrl() ?>start=<?php echo $main_Product_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($main_Product_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $main_Product_list->PageUrl() ?>start=<?php echo $main_Product_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $main_Product_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $main_Product_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $main_Product_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $main_Product_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($main_Product_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmain_Productlist" id="fmain_Productlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_Product_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_Product_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_Product">
<?php if ($main_Product->getCurrentMasterTable() == "main_PartNum" && $main_Product->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="main_PartNum">
<input type="hidden" name="fk_pn_ID" value="<?php echo $main_Product->pn_ID->getSessionValue() ?>">
<?php } ?>
<div id="gmp_main_Product" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($main_Product_list->TotalRecs > 0 || $main_Product->CurrentAction == "add" || $main_Product->CurrentAction == "copy") { ?>
<table id="tbl_main_Productlist" class="table ewTable">
<?php echo $main_Product->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$main_Product_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$main_Product_list->RenderListOptions();

// Render list options (header, left)
$main_Product_list->ListOptions->Render("header", "left");
?>
<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Barcode) == "") { ?>
		<th data-name="pr_Barcode"><div id="elh_main_Product_pr_Barcode" class="main_Product_pr_Barcode"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Barcode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Barcode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_Product->SortUrl($main_Product->pr_Barcode) ?>',1);"><div id="elh_main_Product_pr_Barcode" class="main_Product_pr_Barcode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Barcode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Barcode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Barcode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Activated) == "") { ?>
		<th data-name="pr_Activated"><div id="elh_main_Product_pr_Activated" class="main_Product_pr_Activated"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Activated->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Activated"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_Product->SortUrl($main_Product->pr_Activated) ?>',1);"><div id="elh_main_Product_pr_Activated" class="main_Product_pr_Activated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Activated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Activated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Activated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Status) == "") { ?>
		<th data-name="pr_Status"><div id="elh_main_Product_pr_Status" class="main_Product_pr_Status"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_Product->SortUrl($main_Product->pr_Status) ?>',1);"><div id="elh_main_Product_pr_Status" class="main_Product_pr_Status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_PO) == "") { ?>
		<th data-name="pr_PO"><div id="elh_main_Product_pr_PO" class="main_Product_pr_PO"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_PO->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_PO"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_Product->SortUrl($main_Product->pr_PO) ?>',1);"><div id="elh_main_Product_pr_PO" class="main_Product_pr_PO">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_PO->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_PO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_PO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_Cost) == "") { ?>
		<th data-name="pr_Cost"><div id="elh_main_Product_pr_Cost" class="main_Product_pr_Cost"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_Cost->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_Cost"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_Product->SortUrl($main_Product->pr_Cost) ?>',1);"><div id="elh_main_Product_pr_Cost" class="main_Product_pr_Cost">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_Cost->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_Cost->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_Cost->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
	<?php if ($main_Product->SortUrl($main_Product->pr_intStatus) == "") { ?>
		<th data-name="pr_intStatus"><div id="elh_main_Product_pr_intStatus" class="main_Product_pr_intStatus"><div class="ewTableHeaderCaption"><?php echo $main_Product->pr_intStatus->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pr_intStatus"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $main_Product->SortUrl($main_Product->pr_intStatus) ?>',1);"><div id="elh_main_Product_pr_intStatus" class="main_Product_pr_intStatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $main_Product->pr_intStatus->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($main_Product->pr_intStatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($main_Product->pr_intStatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$main_Product_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($main_Product->CurrentAction == "add" || $main_Product->CurrentAction == "copy") {
		$main_Product_list->RowIndex = 0;
		$main_Product_list->KeyCount = $main_Product_list->RowIndex;
		if ($main_Product->CurrentAction == "add")
			$main_Product_list->LoadDefaultValues();
		if ($main_Product->EventCancelled) // Insert failed
			$main_Product_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$main_Product->ResetAttrs();
		$main_Product->RowAttrs = array_merge($main_Product->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_main_Product', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$main_Product->RowType = EW_ROWTYPE_ADD;

		// Render row
		$main_Product_list->RenderRow();

		// Render list options
		$main_Product_list->RenderListOptions();
		$main_Product_list->StartRowCnt = 0;
?>
	<tr<?php echo $main_Product->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_Product_list->ListOptions->Render("body", "left", $main_Product_list->RowCnt);
?>
	<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
		<td data-name="pr_Barcode">
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
		<td data-name="pr_Activated">
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<input type="text" data-table="main_Product" data-field="x_pr_Activated" data-format="7" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Activated->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Activated->EditValue ?>"<?php echo $main_Product->pr_Activated->EditAttributes() ?>>
<?php if (!$main_Product->pr_Activated->ReadOnly && !$main_Product->pr_Activated->Disabled && !isset($main_Product->pr_Activated->EditAttrs["readonly"]) && !isset($main_Product->pr_Activated->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fmain_Productlist", "x<?php echo $main_Product_list->RowIndex ?>_pr_Activated", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
		<td data-name="pr_Status">
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_Status->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_Status->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>" checked<?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_Status->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_Status->DisplayValueSeparator) ? json_encode($main_Product->pr_Status->DisplayValueSeparator) : $main_Product->pr_Status->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="{value}"<?php echo $main_Product->pr_Status->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
$sWhereWrk = "";
$main_Product->pr_Status->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_Status->LookupFilters += array("f0" => "`ps_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_Status, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_Status->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo $main_Product->pr_Status->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
		<td data-name="pr_PO">
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<input type="text" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_PO->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_PO->EditValue ?>"<?php echo $main_Product->pr_PO->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="o<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="o<?php echo $main_Product_list->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
		<td data-name="pr_Cost">
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
		<td data-name="pr_intStatus">
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
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
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
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
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="o<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="o<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_Product_list->ListOptions->Render("body", "right", $main_Product_list->RowCnt);
?>
<script type="text/javascript">
fmain_Productlist.UpdateOpts(<?php echo $main_Product_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($main_Product->ExportAll && $main_Product->Export <> "") {
	$main_Product_list->StopRec = $main_Product_list->TotalRecs;
} else {

	// Set the last record to display
	if ($main_Product_list->TotalRecs > $main_Product_list->StartRec + $main_Product_list->DisplayRecs - 1)
		$main_Product_list->StopRec = $main_Product_list->StartRec + $main_Product_list->DisplayRecs - 1;
	else
		$main_Product_list->StopRec = $main_Product_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($main_Product_list->FormKeyCountName) && ($main_Product->CurrentAction == "gridadd" || $main_Product->CurrentAction == "gridedit" || $main_Product->CurrentAction == "F")) {
		$main_Product_list->KeyCount = $objForm->GetValue($main_Product_list->FormKeyCountName);
		$main_Product_list->StopRec = $main_Product_list->StartRec + $main_Product_list->KeyCount - 1;
	}
}
$main_Product_list->RecCnt = $main_Product_list->StartRec - 1;
if ($main_Product_list->Recordset && !$main_Product_list->Recordset->EOF) {
	$main_Product_list->Recordset->MoveFirst();
	$bSelectLimit = $main_Product_list->UseSelectLimit;
	if (!$bSelectLimit && $main_Product_list->StartRec > 1)
		$main_Product_list->Recordset->Move($main_Product_list->StartRec - 1);
} elseif (!$main_Product->AllowAddDeleteRow && $main_Product_list->StopRec == 0) {
	$main_Product_list->StopRec = $main_Product->GridAddRowCount;
}

// Initialize aggregate
$main_Product->RowType = EW_ROWTYPE_AGGREGATEINIT;
$main_Product->ResetAttrs();
$main_Product_list->RenderRow();
$main_Product_list->EditRowCnt = 0;
if ($main_Product->CurrentAction == "edit")
	$main_Product_list->RowIndex = 1;
if ($main_Product->CurrentAction == "gridadd")
	$main_Product_list->RowIndex = 0;
if ($main_Product->CurrentAction == "gridedit")
	$main_Product_list->RowIndex = 0;
while ($main_Product_list->RecCnt < $main_Product_list->StopRec) {
	$main_Product_list->RecCnt++;
	if (intval($main_Product_list->RecCnt) >= intval($main_Product_list->StartRec)) {
		$main_Product_list->RowCnt++;
		if ($main_Product->CurrentAction == "gridadd" || $main_Product->CurrentAction == "gridedit" || $main_Product->CurrentAction == "F") {
			$main_Product_list->RowIndex++;
			$objForm->Index = $main_Product_list->RowIndex;
			if ($objForm->HasValue($main_Product_list->FormActionName))
				$main_Product_list->RowAction = strval($objForm->GetValue($main_Product_list->FormActionName));
			elseif ($main_Product->CurrentAction == "gridadd")
				$main_Product_list->RowAction = "insert";
			else
				$main_Product_list->RowAction = "";
		}

		// Set up key count
		$main_Product_list->KeyCount = $main_Product_list->RowIndex;

		// Init row class and style
		$main_Product->ResetAttrs();
		$main_Product->CssClass = "";
		if ($main_Product->CurrentAction == "gridadd") {
			$main_Product_list->LoadDefaultValues(); // Load default values
		} else {
			$main_Product_list->LoadRowValues($main_Product_list->Recordset); // Load row values
		}
		$main_Product->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($main_Product->CurrentAction == "gridadd") // Grid add
			$main_Product->RowType = EW_ROWTYPE_ADD; // Render add
		if ($main_Product->CurrentAction == "gridadd" && $main_Product->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$main_Product_list->RestoreCurrentRowFormValues($main_Product_list->RowIndex); // Restore form values
		if ($main_Product->CurrentAction == "edit") {
			if ($main_Product_list->CheckInlineEditKey() && $main_Product_list->EditRowCnt == 0) { // Inline edit
				$main_Product->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($main_Product->CurrentAction == "gridedit") { // Grid edit
			if ($main_Product->EventCancelled) {
				$main_Product_list->RestoreCurrentRowFormValues($main_Product_list->RowIndex); // Restore form values
			}
			if ($main_Product_list->RowAction == "insert")
				$main_Product->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$main_Product->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($main_Product->CurrentAction == "edit" && $main_Product->RowType == EW_ROWTYPE_EDIT && $main_Product->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$main_Product_list->RestoreFormValues(); // Restore form values
		}
		if ($main_Product->CurrentAction == "gridedit" && ($main_Product->RowType == EW_ROWTYPE_EDIT || $main_Product->RowType == EW_ROWTYPE_ADD) && $main_Product->EventCancelled) // Update failed
			$main_Product_list->RestoreCurrentRowFormValues($main_Product_list->RowIndex); // Restore form values
		if ($main_Product->RowType == EW_ROWTYPE_EDIT) // Edit row
			$main_Product_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$main_Product->RowAttrs = array_merge($main_Product->RowAttrs, array('data-rowindex'=>$main_Product_list->RowCnt, 'id'=>'r' . $main_Product_list->RowCnt . '_main_Product', 'data-rowtype'=>$main_Product->RowType));

		// Render row
		$main_Product_list->RenderRow();

		// Render list options
		$main_Product_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($main_Product_list->RowAction <> "delete" && $main_Product_list->RowAction <> "insertdelete" && !($main_Product_list->RowAction == "insert" && $main_Product->CurrentAction == "F" && $main_Product_list->EmptyRow())) {
?>
	<tr<?php echo $main_Product->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_Product_list->ListOptions->Render("body", "left", $main_Product_list->RowCnt);
?>
	<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
		<td data-name="pr_Barcode"<?php echo $main_Product->pr_Barcode->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Barcode" class="main_Product_pr_Barcode">
<span<?php echo $main_Product->pr_Barcode->ViewAttributes() ?>>
<?php echo $main_Product->pr_Barcode->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $main_Product_list->PageObjName . "_row_" . $main_Product_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="x<?php echo $main_Product_list->RowIndex ?>_pr_ID" id="x<?php echo $main_Product_list->RowIndex ?>_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->CurrentValue) ?>">
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="o<?php echo $main_Product_list->RowIndex ?>_pr_ID" id="o<?php echo $main_Product_list->RowIndex ?>_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT || $main_Product->CurrentMode == "edit") { ?>
<input type="hidden" data-table="main_Product" data-field="x_pr_ID" name="x<?php echo $main_Product_list->RowIndex ?>_pr_ID" id="x<?php echo $main_Product_list->RowIndex ?>_pr_ID" value="<?php echo ew_HtmlEncode($main_Product->pr_ID->CurrentValue) ?>">
<?php } ?>
	<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
		<td data-name="pr_Activated"<?php echo $main_Product->pr_Activated->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<input type="text" data-table="main_Product" data-field="x_pr_Activated" data-format="7" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Activated->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Activated->EditValue ?>"<?php echo $main_Product->pr_Activated->EditAttributes() ?>>
<?php if (!$main_Product->pr_Activated->ReadOnly && !$main_Product->pr_Activated->Disabled && !isset($main_Product->pr_Activated->EditAttrs["readonly"]) && !isset($main_Product->pr_Activated->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fmain_Productlist", "x<?php echo $main_Product_list->RowIndex ?>_pr_Activated", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Activated->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->CurrentValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Activated" class="main_Product_pr_Activated">
<span<?php echo $main_Product->pr_Activated->ViewAttributes() ?>>
<?php echo $main_Product->pr_Activated->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
		<td data-name="pr_Status"<?php echo $main_Product->pr_Status->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_Status->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_Status->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>" checked<?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_Status->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_Status->DisplayValueSeparator) ? json_encode($main_Product->pr_Status->DisplayValueSeparator) : $main_Product->pr_Status->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="{value}"<?php echo $main_Product->pr_Status->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
$sWhereWrk = "";
$main_Product->pr_Status->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_Status->LookupFilters += array("f0" => "`ps_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_Status, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_Status->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo $main_Product->pr_Status->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_Status->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Status" class="main_Product_pr_Status">
<span<?php echo $main_Product->pr_Status->ViewAttributes() ?>>
<?php echo $main_Product->pr_Status->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
		<td data-name="pr_PO"<?php echo $main_Product->pr_PO->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<input type="text" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_PO->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_PO->EditValue ?>"<?php echo $main_Product->pr_PO->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="o<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="o<?php echo $main_Product_list->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $main_Product->pr_PO->EditValue ?></p></span>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->CurrentValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_PO" class="main_Product_pr_PO">
<span<?php echo $main_Product->pr_PO->ViewAttributes() ?>>
<?php echo $main_Product->pr_PO->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
		<td data-name="pr_Cost"<?php echo $main_Product->pr_Cost->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_Cost" class="main_Product_pr_Cost">
<span<?php echo $main_Product->pr_Cost->ViewAttributes() ?>>
<?php echo $main_Product->pr_Cost->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
		<td data-name="pr_intStatus"<?php echo $main_Product->pr_intStatus->CellAttributes() ?>>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
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
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
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
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="o<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="o<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->OldValue) ?>">
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
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
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
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
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($main_Product->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $main_Product_list->RowCnt ?>_main_Product_pr_intStatus" class="main_Product_pr_intStatus">
<span<?php echo $main_Product->pr_intStatus->ViewAttributes() ?>>
<?php echo $main_Product->pr_intStatus->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_Product_list->ListOptions->Render("body", "right", $main_Product_list->RowCnt);
?>
	</tr>
<?php if ($main_Product->RowType == EW_ROWTYPE_ADD || $main_Product->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmain_Productlist.UpdateOpts(<?php echo $main_Product_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($main_Product->CurrentAction <> "gridadd")
		if (!$main_Product_list->Recordset->EOF) $main_Product_list->Recordset->MoveNext();
}
?>
<?php
	if ($main_Product->CurrentAction == "gridadd" || $main_Product->CurrentAction == "gridedit") {
		$main_Product_list->RowIndex = '$rowindex$';
		$main_Product_list->LoadDefaultValues();

		// Set row properties
		$main_Product->ResetAttrs();
		$main_Product->RowAttrs = array_merge($main_Product->RowAttrs, array('data-rowindex'=>$main_Product_list->RowIndex, 'id'=>'r0_main_Product', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($main_Product->RowAttrs["class"], "ewTemplate");
		$main_Product->RowType = EW_ROWTYPE_ADD;

		// Render row
		$main_Product_list->RenderRow();

		// Render list options
		$main_Product_list->RenderListOptions();
		$main_Product_list->StartRowCnt = 0;
?>
	<tr<?php echo $main_Product->RowAttributes() ?>>
<?php

// Render list options (body, left)
$main_Product_list->ListOptions->Render("body", "left", $main_Product_list->RowIndex);
?>
	<?php if ($main_Product->pr_Barcode->Visible) { // pr_Barcode ?>
		<td data-name="pr_Barcode">
<span id="el$rowindex$_main_Product_pr_Barcode" class="form-group main_Product_pr_Barcode">
<input type="text" data-table="main_Product" data-field="x_pr_Barcode" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" size="25" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Barcode->EditValue ?>"<?php echo $main_Product->pr_Barcode->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Barcode" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Barcode" value="<?php echo ew_HtmlEncode($main_Product->pr_Barcode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Activated->Visible) { // pr_Activated ?>
		<td data-name="pr_Activated">
<span id="el$rowindex$_main_Product_pr_Activated" class="form-group main_Product_pr_Activated">
<input type="text" data-table="main_Product" data-field="x_pr_Activated" data-format="7" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Activated" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Activated->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Activated->EditValue ?>"<?php echo $main_Product->pr_Activated->EditAttributes() ?>>
<?php if (!$main_Product->pr_Activated->ReadOnly && !$main_Product->pr_Activated->Disabled && !isset($main_Product->pr_Activated->EditAttrs["readonly"]) && !isset($main_Product->pr_Activated->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fmain_Productlist", "x<?php echo $main_Product_list->RowIndex ?>_pr_Activated", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Activated" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Activated" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Activated" value="<?php echo ew_HtmlEncode($main_Product->pr_Activated->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Status->Visible) { // pr_Status ?>
		<td data-name="pr_Status">
<span id="el$rowindex$_main_Product_pr_Status" class="form-group main_Product_pr_Status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_Status->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $main_Product->pr_Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($main_Product->pr_Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_Status->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_Status" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->CurrentValue) ?>" checked<?php echo $main_Product->pr_Status->EditAttributes() ?>><?php echo $main_Product->pr_Status->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_Status->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_Status" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_Status->DisplayValueSeparator) ? json_encode($main_Product->pr_Status->DisplayValueSeparator) : $main_Product->pr_Status->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="{value}"<?php echo $main_Product->pr_Status->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `ps_ID`, `ps_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_ProductStatus`";
$sWhereWrk = "";
$main_Product->pr_Status->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$main_Product->pr_Status->LookupFilters += array("f0" => "`ps_ID` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$main_Product->Lookup_Selecting($main_Product->pr_Status, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $main_Product->pr_Status->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo $main_Product->pr_Status->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Status" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Status" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Status" value="<?php echo ew_HtmlEncode($main_Product->pr_Status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_PO->Visible) { // pr_PO ?>
		<td data-name="pr_PO">
<span id="el$rowindex$_main_Product_pr_PO" class="form-group main_Product_pr_PO">
<input type="text" data-table="main_Product" data-field="x_pr_PO" name="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="x<?php echo $main_Product_list->RowIndex ?>_pr_PO" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_PO->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_PO->EditValue ?>"<?php echo $main_Product->pr_PO->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_PO" name="o<?php echo $main_Product_list->RowIndex ?>_pr_PO" id="o<?php echo $main_Product_list->RowIndex ?>_pr_PO" value="<?php echo ew_HtmlEncode($main_Product->pr_PO->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_Cost->Visible) { // pr_Cost ?>
		<td data-name="pr_Cost">
<span id="el$rowindex$_main_Product_pr_Cost" class="form-group main_Product_pr_Cost">
<input type="text" data-table="main_Product" data-field="x_pr_Cost" name="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="x<?php echo $main_Product_list->RowIndex ?>_pr_Cost" size="30" placeholder="<?php echo ew_HtmlEncode($main_Product->pr_Cost->getPlaceHolder()) ?>" value="<?php echo $main_Product->pr_Cost->EditValue ?>"<?php echo $main_Product->pr_Cost->EditAttributes() ?>>
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_Cost" name="o<?php echo $main_Product_list->RowIndex ?>_pr_Cost" id="o<?php echo $main_Product_list->RowIndex ?>_pr_Cost" value="<?php echo ew_HtmlEncode($main_Product->pr_Cost->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($main_Product->pr_intStatus->Visible) { // pr_intStatus ?>
		<td data-name="pr_intStatus">
<span id="el$rowindex$_main_Product_pr_intStatus" class="form-group main_Product_pr_intStatus">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $main_Product->pr_intStatus->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" data-repeatcolumn="1" class="dropdown-menu">
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
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($main_Product->pr_intStatus->CurrentValue) <> "") {
?>
<input type="radio" data-table="main_Product" data-field="x_pr_intStatus" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->CurrentValue) ?>" checked<?php echo $main_Product->pr_intStatus->EditAttributes() ?>><?php echo $main_Product->pr_intStatus->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $main_Product->pr_intStatus->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" class="ewTemplate"><input type="radio" data-table="main_Product" data-field="x_pr_intStatus" data-value-separator="<?php echo ew_HtmlEncode(is_array($main_Product->pr_intStatus->DisplayValueSeparator) ? json_encode($main_Product->pr_intStatus->DisplayValueSeparator) : $main_Product->pr_intStatus->DisplayValueSeparator) ?>" name="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="{value}"<?php echo $main_Product->pr_intStatus->EditAttributes() ?>></div>
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
<input type="hidden" name="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="s_x<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo $main_Product->pr_intStatus->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="main_Product" data-field="x_pr_intStatus" name="o<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" id="o<?php echo $main_Product_list->RowIndex ?>_pr_intStatus" value="<?php echo ew_HtmlEncode($main_Product->pr_intStatus->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$main_Product_list->ListOptions->Render("body", "right", $main_Product_list->RowCnt);
?>
<script type="text/javascript">
fmain_Productlist.UpdateOpts(<?php echo $main_Product_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($main_Product->CurrentAction == "add" || $main_Product->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $main_Product_list->FormKeyCountName ?>" id="<?php echo $main_Product_list->FormKeyCountName ?>" value="<?php echo $main_Product_list->KeyCount ?>">
<?php } ?>
<?php if ($main_Product->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $main_Product_list->FormKeyCountName ?>" id="<?php echo $main_Product_list->FormKeyCountName ?>" value="<?php echo $main_Product_list->KeyCount ?>">
<?php echo $main_Product_list->MultiSelectKey ?>
<?php } ?>
<?php if ($main_Product->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $main_Product_list->FormKeyCountName ?>" id="<?php echo $main_Product_list->FormKeyCountName ?>" value="<?php echo $main_Product_list->KeyCount ?>">
<?php } ?>
<?php if ($main_Product->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $main_Product_list->FormKeyCountName ?>" id="<?php echo $main_Product_list->FormKeyCountName ?>" value="<?php echo $main_Product_list->KeyCount ?>">
<?php echo $main_Product_list->MultiSelectKey ?>
<?php } ?>
<?php if ($main_Product->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($main_Product_list->Recordset)
	$main_Product_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($main_Product_list->TotalRecs == 0 && $main_Product->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($main_Product_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($main_Product->Export == "") { ?>
<script type="text/javascript">
fmain_Productlistsrch.Init();
fmain_Productlistsrch.FilterList = <?php echo $main_Product_list->GetFilterList() ?>;
fmain_Productlist.Init();
</script>
<?php } ?>
<?php
$main_Product_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($main_Product->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$main_Product_list->Page_Terminate();
?>
