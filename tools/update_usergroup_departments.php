<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("socialnetwork");

$defaultDepartments = [1];
$usergroupDepartments = [
    12 => 414, // DDB Employees
    13 => 414, // DDB Portal
    17 => 50, // STS Employees
    18 => 50, // STS Employees
    19 => 51, // ERA Employees
    20 => 51, // ERA Employees
    21 => 53, // MFA Employees
    22 => 53, // MFA Employees
    23 => 54, // BilOgCo Employees
    24 => 54, // BilOgCo Employees
    25 => 55, // NHE Employees
    26 => 55, // NHE Employees
    27 => 56, // Autohallen Employees
    28 => 56, // Autohallen Employees
    29 => 52, // SDK Employees
    30 => 52, // SDK Employees
];

// get list of all users
$query = 'select BU.*, BUU.UF_DEPARTMENT from b_user BU join b_uts_user BUU on BUU.VALUE_ID=BU.ID order by BU.ID asc ';
//$resUsers = CUser::GetList($by = 'ID', $order = 'ASC', [], ['*','UF_*']);
$result = $DB->Query($query);

$users = [];
while ($row = $result->Fetch()) {
    
    echo '<pre>$row is ';
    print_r($row);
    echo '</pre>';

    // get usergroups
    $usergroups = $USER->GetUserGroup($row['ID']);
    echo '<pre>$usergroups is ';
    print_r($usergroups);
    echo '</pre>';

    exit();

    
}


// pre-set departments