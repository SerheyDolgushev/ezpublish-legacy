<?php
//
// Created on: <23-Jul-2002 17:11:13 bf>
//
// Copyright (C) 1999-2002 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE.GPL included in
// the packaging of this file.
//
// Licencees holding valid "eZ publish professional licences" may use this
// file in accordance with the "eZ publish professional licence" Agreement
// provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" is available at
// http://ez.no/home/licences/professional/. For pricing of this licence
// please contact us via e-mail to licence@ez.no. Further contact
// information is available at http://ez.no/home/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

include_once( "lib/ezutils/classes/ezhttptool.php" );

include_once( "kernel/common/template.php" );

include_once( "kernel/classes/ezsearch.php" );
include_once( "kernel/classes/ezcontentclass.php" );

include_once( "kernel/classes/ezsearchlog.php" );

$http =& eZHTTPTool::instance();

$Module =& $Params["Module"];

$tpl =& templateInit();

$searchText = "";

if ( $http->hasVariable( "PhraseSearchText" ) and trim( $http->variable( "PhraseSearchText" ) ) != "" )
{
    $searchText = "\"" . $http->variable( "PhraseSearchText" ) . "\"";
    $phraseSearchText = $http->variable( "PhraseSearchText" );
}

$fullSearchText = "";
if ( $http->hasVariable( "SearchText" ) )
{
    if ( $searchText != "" )
        $searchText .= " ";
    $searchText .= $http->variable( "SearchText" );
    $fullSearchText = $http->variable( "SearchText" );
}

$searchContentClassID = -1;
$searchContentClassAttributes = 0;
if ( $http->hasVariable( "SearchContentClassID" ) and
     $http->variable( "SearchContentClassID" ) != -1 )
{
    $searchContentClassID = $http->variable( "SearchContentClassID" );
    $searchContentClass =& eZContentClass::fetch( $searchContentClassID );
    $searchContentClassAttributeArray =& $searchContentClass->fetchAttributes();
}

$searchContentClassAttributeID = -1;
if ( $http->hasVariable( "SearchContentClassAttributeID" ) and
     $http->variable( "SearchContentClassAttributeID" ) != -1 )
{
    $searchContentClassAttributeID = $http->variable( "SearchContentClassAttributeID" );
}

$Module->setTitle( "Search for: $searchText" );

$classArray =& eZContentClass::fetchList();

$searchResult =& eZSearch::search( $searchText, array( "SearchContentClassID" => $searchContentClassID,
                                                       "SearchContentClassAttributeID" => $searchContentClassAttributeID ) );

$tpl->setVariable( "search_contentclass_id", $searchContentClassID );

$tpl->setVariable( "search_result", $searchResult["SearchResult"] );
$tpl->setVariable( "search_count", $searchResult["SearchCount"] );
$tpl->setVariable( "search_text", $searchText );
$tpl->setVariable( "full_search_text", $fullSearchText );
$tpl->setVariable( "phrase_search_text", $phraseSearchText );
$tpl->setVariable( "content_class_array", $classArray );
$tpl->setVariable( "search_content_class_attribute_array", $searchContentClassAttributeArray );

$Result =& $tpl->fetch( "design:search/advancedsearch.tpl" );

eZSearchLog::addPhrase( $searchText, $searchResult["SearchCount"] );

?>
