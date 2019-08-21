<?
$aMenuLinks = Array(
	Array(
		"CRM", 
		"/sts/crm/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('crm') && CModule::IncludeModule('crm') && CCrmPerms::IsAccessEnabled()" 
	)
);
?>