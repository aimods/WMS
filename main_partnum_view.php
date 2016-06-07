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

$main_PartNum_view = NULL; // Initialize page object first

class cmain_PartNum_view extends cmain_PartNum {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{B1D96CD0-2849-4DC1-8F87-20EC273F9356}";

	// Table name
	var $TableName = 'main_PartNum';

	// Page object name
	var $PageObjName = 'main_PartNum_view';

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

		// Table object (main_PartNum)
		if (!isset($GLOBALS["main_PartNum"]) || get_class($GLOBALS["main_PartNum"]) == "cmain_PartNum") {
			$GLOBALS["main_PartNum"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["main_PartNum"];
		}
		$KeyUrl = "";
		if (@$_GET["pn_ID"] <> "") {
			$this->RecKey["pn_ID"] = $_GET["pn_ID"];
			$KeyUrl .= "&amp;pn_ID=" . urlencode($this->RecKey["pn_ID"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (main_Brand)
		if (!isset($GLOBALS['main_Brand'])) $GLOBALS['main_Brand'] = new cmain_Brand();

		// Table object (main_User)
		if (!isset($GLOBALS['main_User'])) $GLOBALS['main_User'] = new cmain_User();

		// Table object (main_Vendor)
		if (!isset($GLOBALS['main_Vendor'])) $GLOBALS['main_Vendor'] = new cmain_Vendor();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
		if (@$_GET["pn_ID"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["pn_ID"]);
		}

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["pn_ID"] <> "") {
				$this->pn_ID->setQueryStringValue($_GET["pn_ID"]);
				$this->RecKey["pn_ID"] = $this->pn_ID->QueryStringValue;
			} elseif (@$_POST["pn_ID"] <> "") {
				$this->pn_ID->setFormValue($_POST["pn_ID"]);
				$this->RecKey["pn_ID"] = $this->pn_ID->FormValue;
			} else {
				$sReturnUrl = "main_partnum_list.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "main_partnum_list.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "main_partnum_list.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_main_Product"
		$item = &$option->Add("detail_main_Product");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("main_Product", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("main_product_list.php?" . EW_TABLE_SHOW_MASTER . "=main_PartNum&fk_pn_ID=" . urlencode(strval($this->pn_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["main_Product_grid"] && $GLOBALS["main_Product_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'main_Product')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=main_Product")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "main_Product";
		}
		if ($GLOBALS["main_Product_grid"] && $GLOBALS["main_Product_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'main_Product')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=main_Product")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "main_Product";
		}
		if ($GLOBALS["main_Product_grid"] && $GLOBALS["main_Product_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'main_Product')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=main_Product")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "main_Product";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'main_Product');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "main_Product";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_StockCard"
		$item = &$option->Add("detail_StockCard");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("StockCard", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("stockcard_list.php?" . EW_TABLE_SHOW_MASTER . "=main_PartNum&fk_pn_ID=" . urlencode(strval($this->pn_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["StockCard_grid"] && $GLOBALS["StockCard_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'StockCard')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=StockCard")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "StockCard";
		}
		if ($GLOBALS["StockCard_grid"] && $GLOBALS["StockCard_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'StockCard')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=StockCard")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "StockCard";
		}
		if ($GLOBALS["StockCard_grid"] && $GLOBALS["StockCard_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'StockCard')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=StockCard")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "StockCard";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'StockCard');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "StockCard";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
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
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_main_PartNum\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_main_PartNum',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fmain_PartNumview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

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
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");

		// Export detail records (main_Product)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("main_Product", explode(",", $this->getCurrentDetailTable()))) {
			global $main_Product;
			if (!isset($main_Product)) $main_Product = new cmain_Product;
			$rsdetail = $main_Product->LoadRs($main_Product->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$main_Product->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}

		// Export detail records (StockCard)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("StockCard", explode(",", $this->getCurrentDetailTable()))) {
			global $StockCard;
			if (!isset($StockCard)) $StockCard = new cStockCard;
			$rsdetail = $StockCard->LoadRs($StockCard->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$StockCard->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}
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
			$this->setSessionWhere($this->GetDetailFilter());

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
				if ($GLOBALS["main_Product_grid"]->DetailView) {
					$GLOBALS["main_Product_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["StockCard_grid"]->DetailView) {
					$GLOBALS["StockCard_grid"]->CurrentMode = "view";

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
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($main_PartNum_view)) $main_PartNum_view = new cmain_PartNum_view();

// Page init
$main_PartNum_view->Page_Init();

// Page main
$main_PartNum_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$main_PartNum_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($main_PartNum->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fmain_PartNumview = new ew_Form("fmain_PartNumview", "view");

// Form_CustomValidate event
fmain_PartNumview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmain_PartNumview.ValidateRequired = true;
<?php } else { ?>
fmain_PartNumview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmain_PartNumview.Lists["x_v_ID"] = {"LinkField":"x_v_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_v_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmain_PartNumview.Lists["x_b_ID"] = {"LinkField":"x_b_ID","Ajax":true,"AutoFill":false,"DisplayFields":["x_b_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($main_PartNum->Export == "") { ?>
<div class="ewToolbar">
<?php if ($main_PartNum->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $main_PartNum_view->ExportOptions->Render("body") ?>
<?php
	foreach ($main_PartNum_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($main_PartNum->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $main_PartNum_view->ShowPageHeader(); ?>
<?php
$main_PartNum_view->ShowMessage();
?>
<form name="fmain_PartNumview" id="fmain_PartNumview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($main_PartNum_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $main_PartNum_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="main_PartNum">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($main_PartNum->pn_Barcode->Visible) { // pn_Barcode ?>
	<tr id="r_pn_Barcode">
		<td><span id="elh_main_PartNum_pn_Barcode"><?php echo $main_PartNum->pn_Barcode->FldCaption() ?></span></td>
		<td data-name="pn_Barcode"<?php echo $main_PartNum->pn_Barcode->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Barcode">
<span<?php echo $main_PartNum->pn_Barcode->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_Barcode->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->v_ID->Visible) { // v_ID ?>
	<tr id="r_v_ID">
		<td><span id="elh_main_PartNum_v_ID"><?php echo $main_PartNum->v_ID->FldCaption() ?></span></td>
		<td data-name="v_ID"<?php echo $main_PartNum->v_ID->CellAttributes() ?>>
<span id="el_main_PartNum_v_ID">
<span<?php echo $main_PartNum->v_ID->ViewAttributes() ?>>
<?php echo $main_PartNum->v_ID->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->b_ID->Visible) { // b_ID ?>
	<tr id="r_b_ID">
		<td><span id="elh_main_PartNum_b_ID"><?php echo $main_PartNum->b_ID->FldCaption() ?></span></td>
		<td data-name="b_ID"<?php echo $main_PartNum->b_ID->CellAttributes() ?>>
<span id="el_main_PartNum_b_ID">
<span<?php echo $main_PartNum->b_ID->ViewAttributes() ?>>
<?php echo $main_PartNum->b_ID->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->pn_ProductName->Visible) { // pn_ProductName ?>
	<tr id="r_pn_ProductName">
		<td><span id="elh_main_PartNum_pn_ProductName"><?php echo $main_PartNum->pn_ProductName->FldCaption() ?></span></td>
		<td data-name="pn_ProductName"<?php echo $main_PartNum->pn_ProductName->CellAttributes() ?>>
<span id="el_main_PartNum_pn_ProductName">
<span<?php echo $main_PartNum->pn_ProductName->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_ProductName->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->pn_Version->Visible) { // pn_Version ?>
	<tr id="r_pn_Version">
		<td><span id="elh_main_PartNum_pn_Version"><?php echo $main_PartNum->pn_Version->FldCaption() ?></span></td>
		<td data-name="pn_Version"<?php echo $main_PartNum->pn_Version->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Version">
<span<?php echo $main_PartNum->pn_Version->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_Version->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->pn_Spec->Visible) { // pn_Spec ?>
	<tr id="r_pn_Spec">
		<td><span id="elh_main_PartNum_pn_Spec"><?php echo $main_PartNum->pn_Spec->FldCaption() ?></span></td>
		<td data-name="pn_Spec"<?php echo $main_PartNum->pn_Spec->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Spec">
<span<?php echo $main_PartNum->pn_Spec->ViewAttributes() ?>>
<?php echo $main_PartNum->pn_Spec->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->pn_Manual->Visible) { // pn_Manual ?>
	<tr id="r_pn_Manual">
		<td><span id="elh_main_PartNum_pn_Manual"><?php echo $main_PartNum->pn_Manual->FldCaption() ?></span></td>
		<td data-name="pn_Manual"<?php echo $main_PartNum->pn_Manual->CellAttributes() ?>>
<span id="el_main_PartNum_pn_Manual">
<span<?php echo $main_PartNum->pn_Manual->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($main_PartNum->pn_Manual, $main_PartNum->pn_Manual->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->pn_PhotoCommercial->Visible) { // pn_PhotoCommercial ?>
	<tr id="r_pn_PhotoCommercial">
		<td><span id="elh_main_PartNum_pn_PhotoCommercial"><?php echo $main_PartNum->pn_PhotoCommercial->FldCaption() ?></span></td>
		<td data-name="pn_PhotoCommercial"<?php echo $main_PartNum->pn_PhotoCommercial->CellAttributes() ?>>
<span id="el_main_PartNum_pn_PhotoCommercial">
<span>
<?php echo ew_GetFileViewTag($main_PartNum->pn_PhotoCommercial, $main_PartNum->pn_PhotoCommercial->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($main_PartNum->pn_PhotoTechnical->Visible) { // pn_PhotoTechnical ?>
	<tr id="r_pn_PhotoTechnical">
		<td><span id="elh_main_PartNum_pn_PhotoTechnical"><?php echo $main_PartNum->pn_PhotoTechnical->FldCaption() ?></span></td>
		<td data-name="pn_PhotoTechnical"<?php echo $main_PartNum->pn_PhotoTechnical->CellAttributes() ?>>
<span id="el_main_PartNum_pn_PhotoTechnical">
<span>
<?php echo ew_GetFileViewTag($main_PartNum->pn_PhotoTechnical, $main_PartNum->pn_PhotoTechnical->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("main_Product", explode(",", $main_PartNum->getCurrentDetailTable())) && $main_Product->DetailView) {
?>
<?php if ($main_PartNum->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("main_Product", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "main_product_grid.php" ?>
<?php } ?>
<?php
	if (in_array("StockCard", explode(",", $main_PartNum->getCurrentDetailTable())) && $StockCard->DetailView) {
?>
<?php if ($main_PartNum->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("StockCard", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "stockcard_grid.php" ?>
<?php } ?>
</form>
<?php if ($main_PartNum->Export == "") { ?>
<script type="text/javascript">
fmain_PartNumview.Init();
</script>
<?php } ?>
<?php
$main_PartNum_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($main_PartNum->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$main_PartNum_view->Page_Terminate();
?>
