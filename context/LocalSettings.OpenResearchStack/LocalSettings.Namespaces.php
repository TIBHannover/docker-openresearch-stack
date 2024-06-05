<?php

############################################################################
##    NAMESPACES                                                          ##
############################################################################

$customNamespaces = [
	// Add the namespace for the Test App. $customNamespaces might be overwritten later
	4012 => 'Test',
];

// Apply Namespaces
foreach ( $customNamespaces as $number => $name ) {

	$id = 'NS_' . strtoupper( $name );

	define( $id, $number );                   // Define namespace
	define( $id . '_TALK', ( $number + 1 ) );   // Define talk namespace

	if ( isset( $wgExtraNamespaces[$number] ) ) {
		die( 'Cannot declare namespace number twice: ' . $number . ' for ' . $name );
	}

	$wgExtraNamespaces[$number] = $name;
	$wgExtraNamespaces[( $number + 1 )] = $name . '_Talk';


	// MediaWiki -------------------------------------------------------------------------------------------------------
	// https://www.mediawiki.org/wiki/Manual:$wgContentNamespaces
	$wgContentNamespaces[] = $number;

	// https://www.mediawiki.org/wiki/Manual:$wgNamespacesWithSubpages
	$wgNamespacesWithSubpages[$number] = true;

	// https://www.mediawiki.org/wiki/Manual:$wgNamespacesToBeSearchedDefault
	$wgNamespacesToBeSearchedDefault[$number] = true;

	// don't enable VE for semantic:apps namespaces since edit via from is preferred
	$wgVisualEditorAvailableNamespaces[$number] = false;

	// Page Forms ------------------------------------------------------------------------------------------------------
	// https://www.mediawiki.org/wiki/Extension:Page_Forms/Linking_to_forms#For_additional_namespaces
	$wgPageFormsAutoeditNamespaces[$number] = true;

	// Semantic MediaWiki ----------------------------------------------------------------------------------------------
	// https://www.semantic-mediawiki.org/wiki/Help:$smwgNamespacesWithSemanticLinks
	$smwgNamespacesWithSemanticLinks[$number] = true;

	// User Functions --------------------------------------------------------------------------------------------------
	// https://www.mediawiki.org/wiki/Extension:UserFunctions#Allowing_namespaces
	$wgUFAllowedNamespaces[$number] = true;

}

// Declare common namespaces as semantic
$smwgNamespacesWithSemanticLinks[2] = true; // USER
$smwgNamespacesWithSemanticLinks[4] = true; // PROJECT
$wgContentNamespaces[] = 4;
$wgUFAllowedNamespaces[4] = true;
$smwgNamespacesWithSemanticLinks[6] = true; // FILE
$wgContentNamespaces[] = 6;
$wgUFAllowedNamespaces[6] = true;
$smwgNamespacesWithSemanticLinks[10] = true; // TEMPLATE
$wgUFAllowedNamespaces[10] = true;
$smwgNamespacesWithSemanticLinks[12] = true; // HELP
$wgContentNamespaces[] = 12;
$smwgNamespacesWithSemanticLinks[14] = true; // CATEGORY

$smwgNamespacesWithSemanticLinks[102] = true; // PROPERTY
$smwgNamespacesWithSemanticLinks[106] = true; // FORM
$smwgNamespacesWithSemanticLinks[108] = true; // CONCEPT
