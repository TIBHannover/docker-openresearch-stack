<?php

//////////////////////////////////////////
// Search Extensions                    //
//////////////////////////////////////////

## -------- Elastica --------
wfLoadExtension("Elastica");
## ======== Elastica ========

## -------- CirrusSearch --------
wfLoadExtension("Cirrussearch");
$wgCirrusSearchServers = [$wgNetworkEnvironment['ELASTICSEARCH_HOST'] ?? "127.0.0.1"];
$wgSearchType = "CirrusSearch";
$wgCirrusSearchPrefixSearchStartsWithAnyWord = true;
## ======== CirrusSearch ========

//////////////////////////////////////////
// Visual Editor                        //
//////////////////////////////////////////

## -------- VisualEditor --------
wfLoadExtension("VisualEditor");

# Access Parsoid REST API via localhost; among others, this is bypassing an issue with
# self-signed certificates when accessing Parsoid via public URL
$wgVisualEditorParsoidAutoConfig = false;
wfLoadExtension('Parsoid', $IP . '/vendor/wikimedia/parsoid/extension.json');
$wgVirtualRestConfig['modules']['parsoid'] = [
    'url' => 'http://localhost' . $wgScriptPath . '/rest.php',
    'forwardCookies' => 'true',
];
## ======== VisualEditor ========

//////////////////////////////////////////
// Other Extensions                     //
//////////////////////////////////////////

## -------- Chameleon --------
# Chameleon included via Composer
wfLoadExtension( 'Bootstrap' );
wfLoadSkin( 'chameleon' );
$wgDefaultSkin="chameleon";
$egChameleonLayoutFile= $IP . "/skins/chameleon/layouts/fixedhead.xml";
## ======== Chameleon ========

## -------- AdminLinks --------
wfLoadExtension( "AdminLinks" );
## ======== AdminLinks ========

## -------- ApprovedRevs --------
wfLoadExtension( "ApprovedRevs" );
$egApprovedRevsAutomaticApprovals = false;
$egApprovedRevsShowNotApprovedMessage = true;
$wgGroupPermissions['approver']['approverevisions'] = true;
## ======== ApprovedRevs ========

## -------- Arrays --------
wfLoadExtension( "Arrays" );
## ======== Arrays ========

## -------- AutoCreatePage --------
wfLoadExtension( "AutoCreatePage" );
## ======== AutoCreatePage ========

## -------- CookieWarning --------
# wfLoadExtension( "CookieWarning" );
## ======== CookieWarning ========

## -------- ConfirmAccount --------
# wfLoadExtension( "ConfirmAccount" );
## ======== ConfirmAccount ========

## -------- ConfirmEdit --------
# wfLoadExtensions([ 'ConfirmEdit', 'ConfirmEdit/QuestyCaptcha' ]);
## ======== ConfirmEdit ========

## -------- CSS --------
wfLoadExtension( "CSS" );
## ======== CSS ========

## -------- DateDiff --------
wfLoadExtension( "DateDiff" );
## ======== DateDiff ========

## -------- DisplayTitle --------
wfLoadExtension( "DisplayTitle" );
## ======== DisplayTitle ========

## -------- Echo --------
wfLoadExtension( "Echo" );
$wgEchoUseJobQueue = true;
## ======== Echo ========

## -------- EditAccount --------
# wfLoadExtension( "EditAccount" );
# $wgGroupPermissions["sysop"]["editaccount"] = true;
# $wgGroupPermissions["bureaucrat"]["editaccount"] = true;
## ======== EditAccount ========

## -------- ExternalData --------
wfLoadExtension( "ExternalData" );
## ======== ExternalData ========

## -------- SyntaxHighlight_GeSHi --------
wfLoadExtension( "SyntaxHighlight_GeSHi" );
## ======== SyntaxHighlight_GeSHi ========

## -------- IDProvider --------
wfLoadExtension( "IDProvider" );
## ======== IDProvider ========

## -------- JSBreadCrumbs --------
# wfLoadExtension( "JSBreadCrumbs" );
## ======== JSBreadCrumbs ========

## -------- LegalLogin --------
wfLoadExtension( "LegalLogin" );
## ======== LegalLogin ========

## -------- Loops --------
wfLoadExtension( "Loops" );
$egLoopsCountLimit = 1000;
## ======== Loops ========

## -------- Maps --------
# Maps included via Composer
wfLoadExtension( "Maps" );
## ======== Maps ========

## -------- Matomo --------
# wfLoadExtension( "Matomo" );
## ======== Matomo ========

## -------- Mermaid --------
# Mermaid included via Composer
wfLoadExtension( "Mermaid" );
## ======== Mermaid ========

## -------- Modern Timeline --------
# Modern Timeline included via Composer
wfLoadExtension( "ModernTimeline" );
## ======== Mermaid ========

## -------- MultimediaViewer --------
wfLoadExtension( "MultimediaViewer" );
## ======== MultimediaViewer ========

## -------- NativeSvgHandler --------
wfLoadExtension( "NativeSvgHandler" );
## ======== NativeSvgHandler ========

## -------- NumberFormat --------
wfLoadExtension( "NumberFormat" );
## ======== NumberFormat ========

## -------- OpenLayers --------
wfLoadExtension( "OpenLayers" );
## ======== OpenLayers ========

## -------- ParserFunctions --------
wfLoadExtension( "ParserFunctions" );
$wgPFEnableStringFunctions = true;
## ======== ParserFunctions ========

## -------- PageForms --------
wfLoadExtension( "PageForms" );
## ======== PageForms ========

## -------- TextExtracts --------
## required by Popups
wfLoadExtension( "TextExtracts" );
## ======== TextExtracts ========

## -------- PageImages --------
## required by Popups
wfLoadExtension( "PageImages" );
## ======== PageImages ========

## -------- Popups --------
# wfLoadExtension( "Popups" );
## ======== Popups ========

## -------- RegexFunctions --------
wfLoadExtension( "RegexFunctions" );
## ======== RegexFunctions ========

## -------- ReplaceText --------
wfLoadExtension( "ReplaceText" );
$wgReplaceTextResultsLimit = 1000;
## ======== ReplaceText ========

## -------- SemanticMediaWiki --------
# SemanticMediaWiki included via Composer
wfLoadExtension( "SemanticMediaWiki" );
enableSemantics( $wgServer );
# required if caching is used; otherwise dependent inline queries are not updated
# (see https://www.semantic-mediawiki.org/wiki/Help:Embedded_query_update)
$smwgEnabledQueryDependencyLinksStore = true;
## ======== SemanticMediaWiki ========

## -------- SemanticCompoundQueries --------
# SemanticCompoundQueries included via Composer
wfLoadExtension( "SemanticCompoundQueries" );
## ======== SemanticCompoundQueries ========

## -------- SemanticDependencyUpdater --------
wfLoadExtension( "SemanticDependencyUpdater" );
$wgSDUUseJobQueue = true;
## ======== SemanticDependencyUpdater ========

## -------- SemanticExtraSpecialProperties --------
# SemanticExtraSpecialProperties included via Composer
wfLoadExtension("SemanticExtraSpecialProperties");
$sespgEnabledPropertyList[] = "_CUSER";
$sespgEnabledPropertyList[] = "_REVID";
$sespgEnabledPropertyList[] = "_SUBP";
$sespgEnabledPropertyList[] = "_APPROVED";
$sespgEnabledPropertyList[] = "_APPROVEDBY";
$sespgEnabledPropertyList[] = "_APPROVEDDATE";
$sespgEnabledPropertyList[] = "_APPROVEDSTATUS";
## ======== SemanticExtraSpecialProperties ========

## -------- SemanticResultFormats --------
# SemanticResultFormats included via Composer
wfLoadExtension( "SemanticResultFormats" );
## ======== SemanticResultFormats ========

## -------- SimpleTooltip --------
# require_once( "$IP/extensions/SimpleTooltip/SimpleTooltip.php" );
## ======== SimpleTooltip ========

## -------- TitleIcon --------
wfLoadExtension( "TitleIcon" );
## ======== TitleIcon ========

## -------- UrlGetParameters --------
wfLoadExtension( "UrlGetParameters" );
## ======== UrlGetParameters ======

## -------- UserFunctions --------
wfLoadExtension( "UserFunctions" );
## ======== UserFunctions ========

## -------- UserMerge --------
wfLoadExtension( "UserMerge" );
## ======== UserMerge ========

## -------- Variables --------
wfLoadExtension( "Variables" );
## ======== Variables ========

## -------- VEForAll --------
wfLoadExtension( "VEForAll" );
## ======== VEForAll ========
