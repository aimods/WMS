<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(119, "mci_Home", $Language->MenuPhrase("119", "MenuText"), "instock_list.php", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(40, "mci_Product", $Language->MenuPhrase("40", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(26, "mi_main_PartNum", $Language->MenuPhrase("26", "MenuText"), "main_partnum_list.php?cmd=resetall", 40, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}main_PartNum'), FALSE);
$RootMenu->AddMenuItem(94, "mci_Stock_Card", $Language->MenuPhrase("94", "MenuText"), "", 40, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(67, "mi_StockCard", $Language->MenuPhrase("67", "MenuText"), "stockcard_list.php?cmd=resetall", 94, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}StockCard'), FALSE);
$RootMenu->AddMenuItem(68, "mi_inStock", $Language->MenuPhrase("68", "MenuText"), "instock_list.php", 94, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}inStock'), FALSE);
$RootMenu->AddMenuItem(66, "mi_InternalUse", $Language->MenuPhrase("66", "MenuText"), "internaluse_list.php", 94, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}InternalUse'), FALSE);
$RootMenu->AddMenuItem(25, "mi_main_Brand", $Language->MenuPhrase("25", "MenuText"), "main_brand_list.php", 40, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}main_Brand'), FALSE);
$RootMenu->AddMenuItem(23, "mi_main_Vendor", $Language->MenuPhrase("23", "MenuText"), "main_vendor_list.php", 40, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}main_Vendor'), FALSE);
$RootMenu->AddMenuItem(22, "mci_Messaging", $Language->MenuPhrase("22", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(21, "mci_New_Message", $Language->MenuPhrase("21", "MenuText"), "bot_sendmsg_add.php", 22, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(11, "mi_pending_Msg", $Language->MenuPhrase("11", "MenuText"), "pending_msg_list.php", 22, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}pending_Msg'), FALSE);
$RootMenu->AddMenuItem(10, "mi_bot_SendMSG", $Language->MenuPhrase("10", "MenuText"), "bot_sendmsg_list.php", 22, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}bot_SendMSG'), FALSE);
$RootMenu->AddMenuItem(1, "mi_main_Stock", $Language->MenuPhrase("1", "MenuText"), "main_stock_list.php", -1, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}main_Stock'), FALSE);
$RootMenu->AddMenuItem(9, "mci_Admin", $Language->MenuPhrase("9", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(58, "mci_User", $Language->MenuPhrase("58", "MenuText"), "", 9, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(2, "mi_main_User", $Language->MenuPhrase("2", "MenuText"), "main_user_list.php", 58, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}main_User'), FALSE);
$RootMenu->AddMenuItem(7, "mi_userlevels", $Language->MenuPhrase("7", "MenuText"), "userlevels_list.php", 58, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(8, "mci_LOV", $Language->MenuPhrase("8", "MenuText"), "", 9, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(3, "mi_lov_WHType", $Language->MenuPhrase("3", "MenuText"), "lov_whtype_list.php", 8, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}lov_WHType'), FALSE);
$RootMenu->AddMenuItem(61, "mci_Product", $Language->MenuPhrase("61", "MenuText"), "", 8, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(59, "mi_lov_ProductStatus", $Language->MenuPhrase("59", "MenuText"), "lov_productstatus_list.php", 61, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}lov_ProductStatus'), FALSE);
$RootMenu->AddMenuItem(62, "mi_lov_intStatus", $Language->MenuPhrase("62", "MenuText"), "lov_intstatus_list.php", 61, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}lov_intStatus'), FALSE);
$RootMenu->AddMenuItem(24, "mi_lov_countries", $Language->MenuPhrase("24", "MenuText"), "lov_countries_list.php", 8, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}lov_countries'), FALSE);
$RootMenu->AddMenuItem(5, "mi_lov_province", $Language->MenuPhrase("5", "MenuText"), "lov_province_list.php", 8, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}lov_province'), FALSE);
$RootMenu->AddMenuItem(64, "mi_lov_Transaction", $Language->MenuPhrase("64", "MenuText"), "lov_transaction_list.php", 9, "", AllowListMenu('{B1D96CD0-2849-4DC1-8F87-20EC273F9356}lov_Transaction'), FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
