<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "transaction_movement_info.php" ?>
<?php include_once "main_product_info.php" ?>
<?php include_once "main_user_info.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$transaction_Movement_list = NULL; // Initialize page object first

class ctransaction_Movement_list extends ctransaction_Movement {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'transaction_Movement';

	// Page object name
	var $PageObjName = 'transaction_Movement_list';

	// Grid form hidden field names
	var $FormName = 'ftransaction_Movementlist';
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

		// Table object (transaction_Movement)
		if (!isset($GLOBALS["transaction_Movement"]) || get_class($GLOBALS["transaction_Movement"]) == "ctransaction_Movement") {
			$GLOBALS["transaction_Movement"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["transaction_Movement"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "transaction_movement_add.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "transaction_movement_delete.php";
		$this->MultiUpdateUrl = "transaction_movement_update.php";

		// Table object (main_Product)
		if (!isset($GLOBALS['main_Product'])) $GLOBALS['main_Product'] = new cmain_Product();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'transaction_Movement', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftransaction_Movementlistsrch";

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
		$this->tran_Created->Visible = !$this->IsAddOrEdit();
		$this->u_ID->Visible = !$this->IsAddOrEdit();
		$this->tran_ID->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $transaction_Movement;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($transaction_Movement);
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

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "main_Product") {
			global $main_Product;
			$rsmaster = $main_Product->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("main_product_list.php"); // Return to master page
			} else {
				$main_Product->LoadListRowValues($rsmaster);
				$main_Product->RowType = EW_ROWTYPE_MASTER; // Master row
				$main_Product->RenderListRow();
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
			$this->tran_ID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->tran_ID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->tran_Created); // tran_Created
			$this->UpdateSort($this->u_ID); // u_ID
			$this->UpdateSort($this->tr_type); // tr_type
			$this->UpdateSort($this->tran_Detail); // tran_Detail
			$this->UpdateSort($this->s_ID); // s_ID
			$this->UpdateSort($this->tran_ID); // tran_ID
			$this->UpdateSort($this->tran_show); // tran_show
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
				$this->tran_Created->setSort("DESC");
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->pr_ID->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->tran_Created->setSort("");
				$this->u_ID->setSort("");
				$this->tr_type->setSort("");
				$this->tran_Detail->setSort("");
				$this->s_ID->setSort("");
				$this->tran_ID->setSort("");
				$this->tran_show->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->tran_ID->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftransaction_Movementlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftransaction_Movementlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftransaction_Movementlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->tran_Created->setDbValue($rs->fields('tran_Created'));
		$this->u_ID->setDbValue($rs->fields('u_ID'));
		$this->tr_type->setDbValue($rs->fields('tr_type'));
		$this->tran_Detail->setDbValue($rs->fields('tran_Detail'));
		$this->pr_ID->setDbValue($rs->fields('pr_ID'));
		$this->s_ID->setDbValue($rs->fields('s_ID'));
		$this->tran_ID->setDbValue($rs->fields('tran_ID'));
		$this->tran_show->setDbValue($rs->fields('tran_show'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->tran_Created->DbValue = $row['tran_Created'];
		$this->u_ID->DbValue = $row['u_ID'];
		$this->tr_type->DbValue = $row['tr_type'];
		$this->tran_Detail->DbValue = $row['tran_Detail'];
		$this->pr_ID->DbValue = $row['pr_ID'];
		$this->s_ID->DbValue = $row['s_ID'];
		$this->tran_ID->DbValue = $row['tran_ID'];
		$this->tran_show->DbValue = $row['tran_show'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("tran_ID")) <> "")
			$this->tran_ID->CurrentValue = $this->getKey("tran_ID"); // tran_ID
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
		// tran_Created
		// u_ID
		// tr_type
		// tran_Detail
		// pr_ID
		// s_ID
		// tran_ID
		// tran_show

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// tran_Created
		$this->tran_Created->ViewValue = $this->tran_Created->CurrentValue;
		$this->tran_Created->ViewValue = ew_FormatDateTime($this->tran_Created->ViewValue, 17);
		$this->tran_Created->ViewCustomAttributes = "";

		// u_ID
		$this->u_ID->ViewValue = $this->u_ID->CurrentValue;
		if (strval($this->u_ID->CurrentValue) <> "") {
			$sFilterWrk = "`u_ID`" . ew_SearchString("=", $this->u_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `u_ID`, `u_LoginName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_User`";
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

		// tr_type
		if (strval($this->tr_type->CurrentValue) <> "") {
			$sFilterWrk = "`tr_Type`" . ew_SearchString("=", $this->tr_type->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `tr_Type`, `tr_Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lov_Transaction`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tr_type, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tr_type->ViewValue = $this->tr_type->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tr_type->ViewValue = $this->tr_type->CurrentValue;
			}
		} else {
			$this->tr_type->ViewValue = NULL;
		}
		$this->tr_type->ViewCustomAttributes = "";

		// tran_Detail
		$this->tran_Detail->ViewValue = $this->tran_Detail->CurrentValue;
		$this->tran_Detail->ViewCustomAttributes = "";

		// s_ID
		if (strval($this->s_ID->CurrentValue) <> "") {
			$sFilterWrk = "`s_ID`" . ew_SearchString("=", $this->s_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `s_ID`, `s_LOC` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `main_Stock`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->s_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `s_Province`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->s_ID->ViewValue = $this->s_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->s_ID->ViewValue = $this->s_ID->CurrentValue;
			}
		} else {
			$this->s_ID->ViewValue = NULL;
		}
		$this->s_ID->ViewCustomAttributes = "";

		// tran_ID
		$this->tran_ID->ViewValue = $this->tran_ID->CurrentValue;
		$this->tran_ID->ViewCustomAttributes = "";

		// tran_show
		if (strval($this->tran_show->CurrentValue) <> "") {
			$this->tran_show->ViewValue = $this->tran_show->OptionCaption($this->tran_show->CurrentValue);
		} else {
			$this->tran_show->ViewValue = NULL;
		}
		$this->tran_show->ViewCustomAttributes = "";

			// tran_Created
			$this->tran_Created->LinkCustomAttributes = "";
			$this->tran_Created->HrefValue = "";
			$this->tran_Created->TooltipValue = "";

			// u_ID
			$this->u_ID->LinkCustomAttributes = "";
			$this->u_ID->HrefValue = "";
			$this->u_ID->TooltipValue = "";

			// tr_type
			$this->tr_type->LinkCustomAttributes = "";
			$this->tr_type->HrefValue = "";
			$this->tr_type->TooltipValue = "";

			// tran_Detail
			$this->tran_Detail->LinkCustomAttributes = "";
			$this->tran_Detail->HrefValue = "";
			$this->tran_Detail->TooltipValue = "";

			// s_ID
			$this->s_ID->LinkCustomAttributes = "";
			$this->s_ID->HrefValue = "";
			$this->s_ID->TooltipValue = "";

			// tran_ID
			$this->tran_ID->LinkCustomAttributes = "";
			$this->tran_ID->HrefValue = "";
			$this->tran_ID->TooltipValue = "";

			// tran_show
			$this->tran_show->LinkCustomAttributes = "";
			$this->tran_show->HrefValue = "";
			$this->tran_show->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_transaction_Movement\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_transaction_Movement',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftransaction_Movementlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "main_Product") {
			global $main_Product;
			if (!isset($main_Product)) $main_Product = new cmain_Product;
			$rsmaster = $main_Product->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$main_Product;
					$main_Product->ExportDocument($Doc, $rsmaster, 1, 1);
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
			if ($sMasterTblVar == "main_Product") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_pr_ID"] <> "") {
					$GLOBALS["main_Product"]->pr_ID->setQueryStringValue($_GET["fk_pr_ID"]);
					$this->pr_ID->setQueryStringValue($GLOBALS["main_Product"]->pr_ID->QueryStringValue);
					$this->pr_ID->setSessionValue($this->pr_ID->QueryStringValue);
					if (!is_numeric($GLOBALS["main_Product"]->pr_ID->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "main_Product") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_pr_ID"] <> "") {
					$GLOBALS["main_Product"]->pr_ID->setFormValue($_POST["fk_pr_ID"]);
					$this->pr_ID->setFormValue($GLOBALS["main_Product"]->pr_ID->FormValue);
					$this->pr_ID->setSessionValue($this->pr_ID->FormValue);
					if (!is_numeric($GLOBALS["main_Product"]->pr_ID->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "main_Product") {
				if ($this->pr_ID->CurrentValue == "") $this->pr_ID->setSessionValue("");
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
if (!isset($transaction_Movement_list)) $transaction_Movement_list = new ctransaction_Movement_list();

// Page init
$transaction_Movement_list->Page_Init();

// Page main
$transaction_Movement_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$transaction_Movement_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($transaction_Movement->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftransaction_Movementlist = new ew_Form("ftransaction_Movementlist", "list");
ftransaction_Movementlist.FormKeyCountName = '<?php echo $transaction_Movement_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftransaction_Movementlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftransaction_Movementlist.ValidateRequired = true;
<?php } else { ?>
ftransaction_Movementlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftransaction_Movementlist.Lists["x_u_ID"] = {"LinkField":"x_u_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_u_LoginName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementlist.Lists["x_tr_type"] = {"LinkField":"x_tr_Type","Ajax":true,"AutoFill":false,"DisplayFields":["x_tr_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementlist.Lists["x_s_ID"] = {"LinkField":"x_s_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_s_LOC","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementlist.Lists["x_tran_show"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransaction_Movementlist.Lists["x_tran_show"].Options = <?php echo json_encode($transaction_Movement->tran_show->Options()) ?>;

// Form object for search
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
<?php if ($transaction_Movement->Export == "") { ?>
<div class="ewToolbar">
<?php if ($transaction_Movement->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($transaction_Movement_list->TotalRecs > 0 && $transaction_Movement_list->ExportOptions->Visible()) { ?>
<?php $transaction_Movement_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($transaction_Movement->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($transaction_Movement->Export == "") || (EW_EXPORT_MASTER_RECORD && $transaction_Movement->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "main_product_list.php";
if ($transaction_Movement_list->DbMasterFilter <> "" && $transaction_Movement->getCurrentMasterTable() == "main_Product") {
	if ($transaction_Movement_list->MasterRecordExists) {
		if ($transaction_Movement->getCurrentMasterTable() == $transaction_Movement->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "main_product_master.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $transaction_Movement_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($transaction_Movement_list->TotalRecs <= 0)
			$transaction_Movement_list->TotalRecs = $transaction_Movement->SelectRecordCount();
	} else {
		if (!$transaction_Movement_list->Recordset && ($transaction_Movement_list->Recordset = $transaction_Movement_list->LoadRecordset()))
			$transaction_Movement_list->TotalRecs = $transaction_Movement_list->Recordset->RecordCount();
	}
	$transaction_Movement_list->StartRec = 1;
	if ($transaction_Movement_list->DisplayRecs <= 0 || ($transaction_Movement->Export <> "" && $transaction_Movement->ExportAll)) // Display all records
		$transaction_Movement_list->DisplayRecs = $transaction_Movement_list->TotalRecs;
	if (!($transaction_Movement->Export <> "" && $transaction_Movement->ExportAll))
		$transaction_Movement_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$transaction_Movement_list->Recordset = $transaction_Movement_list->LoadRecordset($transaction_Movement_list->StartRec-1, $transaction_Movement_list->DisplayRecs);

	// Set no record found message
	if ($transaction_Movement->CurrentAction == "" && $transaction_Movement_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$transaction_Movement_list->setWarningMessage(ew_DeniedMsg());
		if ($transaction_Movement_list->SearchWhere == "0=101")
			$transaction_Movement_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$transaction_Movement_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$transaction_Movement_list->RenderOtherOptions();
?>
<?php $transaction_Movement_list->ShowPageHeader(); ?>
<?php
$transaction_Movement_list->ShowMessage();
?>
<?php if ($transaction_Movement_list->TotalRecs > 0 || $transaction_Movement->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($transaction_Movement->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($transaction_Movement->CurrentAction <> "gridadd" && $transaction_Movement->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($transaction_Movement_list->Pager)) $transaction_Movement_list->Pager = new cPrevNextPager($transaction_Movement_list->StartRec, $transaction_Movement_list->DisplayRecs, $transaction_Movement_list->TotalRecs) ?>
<?php if ($transaction_Movement_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($transaction_Movement_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $transaction_Movement_list->PageUrl() ?>start=<?php echo $transaction_Movement_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($transaction_Movement_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $transaction_Movement_list->PageUrl() ?>start=<?php echo $transaction_Movement_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $transaction_Movement_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($transaction_Movement_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $transaction_Movement_list->PageUrl() ?>start=<?php echo $transaction_Movement_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($transaction_Movement_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $transaction_Movement_list->PageUrl() ?>start=<?php echo $transaction_Movement_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $transaction_Movement_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $transaction_Movement_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $transaction_Movement_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $transaction_Movement_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($transaction_Movement_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftransaction_Movementlist" id="ftransaction_Movementlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($transaction_Movement_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $transaction_Movement_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="transaction_Movement">
<?php if ($transaction_Movement->getCurrentMasterTable() == "main_Product" && $transaction_Movement->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="main_Product">
<input type="hidden" name="fk_pr_ID" value="<?php echo $transaction_Movement->pr_ID->getSessionValue() ?>">
<?php } ?>
<div id="gmp_transaction_Movement" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($transaction_Movement_list->TotalRecs > 0) { ?>
<table id="tbl_transaction_Movementlist" class="table ewTable">
<?php echo $transaction_Movement->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$transaction_Movement_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$transaction_Movement_list->RenderListOptions();

// Render list options (header, left)
$transaction_Movement_list->ListOptions->Render("header", "left");
?>
<?php if ($transaction_Movement->tran_Created->Visible) { // tran_Created ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_Created) == "") { ?>
		<th data-name="tran_Created"><div id="elh_transaction_Movement_tran_Created" class="transaction_Movement_tran_Created"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Created->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_Created"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->tran_Created) ?>',1);"><div id="elh_transaction_Movement_tran_Created" class="transaction_Movement_tran_Created">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Created->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_Created->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_Created->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->u_ID->Visible) { // u_ID ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->u_ID) == "") { ?>
		<th data-name="u_ID"><div id="elh_transaction_Movement_u_ID" class="transaction_Movement_u_ID"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->u_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="u_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->u_ID) ?>',1);"><div id="elh_transaction_Movement_u_ID" class="transaction_Movement_u_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->u_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->u_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->u_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tr_type->Visible) { // tr_type ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tr_type) == "") { ?>
		<th data-name="tr_type"><div id="elh_transaction_Movement_tr_type" class="transaction_Movement_tr_type"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tr_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tr_type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->tr_type) ?>',1);"><div id="elh_transaction_Movement_tr_type" class="transaction_Movement_tr_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tr_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tr_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tr_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tran_Detail->Visible) { // tran_Detail ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_Detail) == "") { ?>
		<th data-name="tran_Detail"><div id="elh_transaction_Movement_tran_Detail" class="transaction_Movement_tran_Detail"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Detail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_Detail"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->tran_Detail) ?>',1);"><div id="elh_transaction_Movement_tran_Detail" class="transaction_Movement_tran_Detail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_Detail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_Detail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_Detail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->s_ID->Visible) { // s_ID ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->s_ID) == "") { ?>
		<th data-name="s_ID"><div id="elh_transaction_Movement_s_ID" class="transaction_Movement_s_ID"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->s_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="s_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->s_ID) ?>',1);"><div id="elh_transaction_Movement_s_ID" class="transaction_Movement_s_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->s_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->s_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->s_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tran_ID->Visible) { // tran_ID ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_ID) == "") { ?>
		<th data-name="tran_ID"><div id="elh_transaction_Movement_tran_ID" class="transaction_Movement_tran_ID"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->tran_ID) ?>',1);"><div id="elh_transaction_Movement_tran_ID" class="transaction_Movement_tran_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($transaction_Movement->tran_show->Visible) { // tran_show ?>
	<?php if ($transaction_Movement->SortUrl($transaction_Movement->tran_show) == "") { ?>
		<th data-name="tran_show"><div id="elh_transaction_Movement_tran_show" class="transaction_Movement_tran_show"><div class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_show->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tran_show"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $transaction_Movement->SortUrl($transaction_Movement->tran_show) ?>',1);"><div id="elh_transaction_Movement_tran_show" class="transaction_Movement_tran_show">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transaction_Movement->tran_show->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transaction_Movement->tran_show->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transaction_Movement->tran_show->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$transaction_Movement_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($transaction_Movement->ExportAll && $transaction_Movement->Export <> "") {
	$transaction_Movement_list->StopRec = $transaction_Movement_list->TotalRecs;
} else {

	// Set the last record to display
	if ($transaction_Movement_list->TotalRecs > $transaction_Movement_list->StartRec + $transaction_Movement_list->DisplayRecs - 1)
		$transaction_Movement_list->StopRec = $transaction_Movement_list->StartRec + $transaction_Movement_list->DisplayRecs - 1;
	else
		$transaction_Movement_list->StopRec = $transaction_Movement_list->TotalRecs;
}
$transaction_Movement_list->RecCnt = $transaction_Movement_list->StartRec - 1;
if ($transaction_Movement_list->Recordset && !$transaction_Movement_list->Recordset->EOF) {
	$transaction_Movement_list->Recordset->MoveFirst();
	$bSelectLimit = $transaction_Movement_list->UseSelectLimit;
	if (!$bSelectLimit && $transaction_Movement_list->StartRec > 1)
		$transaction_Movement_list->Recordset->Move($transaction_Movement_list->StartRec - 1);
} elseif (!$transaction_Movement->AllowAddDeleteRow && $transaction_Movement_list->StopRec == 0) {
	$transaction_Movement_list->StopRec = $transaction_Movement->GridAddRowCount;
}

// Initialize aggregate
$transaction_Movement->RowType = EW_ROWTYPE_AGGREGATEINIT;
$transaction_Movement->ResetAttrs();
$transaction_Movement_list->RenderRow();
while ($transaction_Movement_list->RecCnt < $transaction_Movement_list->StopRec) {
	$transaction_Movement_list->RecCnt++;
	if (intval($transaction_Movement_list->RecCnt) >= intval($transaction_Movement_list->StartRec)) {
		$transaction_Movement_list->RowCnt++;

		// Set up key count
		$transaction_Movement_list->KeyCount = $transaction_Movement_list->RowIndex;

		// Init row class and style
		$transaction_Movement->ResetAttrs();
		$transaction_Movement->CssClass = "";
		if ($transaction_Movement->CurrentAction == "gridadd") {
		} else {
			$transaction_Movement_list->LoadRowValues($transaction_Movement_list->Recordset); // Load row values
		}
		$transaction_Movement->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$transaction_Movement->RowAttrs = array_merge($transaction_Movement->RowAttrs, array('data-rowindex'=>$transaction_Movement_list->RowCnt, 'id'=>'r' . $transaction_Movement_list->RowCnt . '_transaction_Movement', 'data-rowtype'=>$transaction_Movement->RowType));

		// Render row
		$transaction_Movement_list->RenderRow();

		// Render list options
		$transaction_Movement_list->RenderListOptions();
?>
	<tr<?php echo $transaction_Movement->RowAttributes() ?>>
<?php

// Render list options (body, left)
$transaction_Movement_list->ListOptions->Render("body", "left", $transaction_Movement_list->RowCnt);
?>
	<?php if ($transaction_Movement->tran_Created->Visible) { // tran_Created ?>
		<td data-name="tran_Created"<?php echo $transaction_Movement->tran_Created->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_tran_Created" class="transaction_Movement_tran_Created">
<span<?php echo $transaction_Movement->tran_Created->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_Created->ListViewValue() ?></span>
</span>
<a id="<?php echo $transaction_Movement_list->PageObjName . "_row_" . $transaction_Movement_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($transaction_Movement->u_ID->Visible) { // u_ID ?>
		<td data-name="u_ID"<?php echo $transaction_Movement->u_ID->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_u_ID" class="transaction_Movement_u_ID">
<span<?php echo $transaction_Movement->u_ID->ViewAttributes() ?>>
<?php echo $transaction_Movement->u_ID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tr_type->Visible) { // tr_type ?>
		<td data-name="tr_type"<?php echo $transaction_Movement->tr_type->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_tr_type" class="transaction_Movement_tr_type">
<span<?php echo $transaction_Movement->tr_type->ViewAttributes() ?>>
<?php echo $transaction_Movement->tr_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_Detail->Visible) { // tran_Detail ?>
		<td data-name="tran_Detail"<?php echo $transaction_Movement->tran_Detail->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_tran_Detail" class="transaction_Movement_tran_Detail">
<span<?php echo $transaction_Movement->tran_Detail->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_Detail->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->s_ID->Visible) { // s_ID ?>
		<td data-name="s_ID"<?php echo $transaction_Movement->s_ID->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_s_ID" class="transaction_Movement_s_ID">
<span<?php echo $transaction_Movement->s_ID->ViewAttributes() ?>>
<?php echo $transaction_Movement->s_ID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_ID->Visible) { // tran_ID ?>
		<td data-name="tran_ID"<?php echo $transaction_Movement->tran_ID->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_tran_ID" class="transaction_Movement_tran_ID">
<span<?php echo $transaction_Movement->tran_ID->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_ID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($transaction_Movement->tran_show->Visible) { // tran_show ?>
		<td data-name="tran_show"<?php echo $transaction_Movement->tran_show->CellAttributes() ?>>
<span id="el<?php echo $transaction_Movement_list->RowCnt ?>_transaction_Movement_tran_show" class="transaction_Movement_tran_show">
<span<?php echo $transaction_Movement->tran_show->ViewAttributes() ?>>
<?php echo $transaction_Movement->tran_show->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$transaction_Movement_list->ListOptions->Render("body", "right", $transaction_Movement_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($transaction_Movement->CurrentAction <> "gridadd")
		$transaction_Movement_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($transaction_Movement->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($transaction_Movement_list->Recordset)
	$transaction_Movement_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($transaction_Movement_list->TotalRecs == 0 && $transaction_Movement->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($transaction_Movement_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($transaction_Movement->Export == "") { ?>
<script type="text/javascript">
ftransaction_Movementlist.Init();
</script>
<?php } ?>
<?php
$transaction_Movement_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($transaction_Movement->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$transaction_Movement_list->Page_Terminate();
?>
