<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.5                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2014                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2014
 * $Id$
 *
 */
class CRM_Case_XMLProcessor {

  /**
   * Relationship-types have four name fields (name_a_b, name_b_a, label_a_b,
   * label_b_a), but CiviCase XML refers to reltypes by a single name.
   * REL_TYPE_CNAME identifies the canonical name field as used by CiviCase XML.
   *
   * This appears to be "label_b_a", but IMHO "name_b_a" would be more
   * sensible.
   */
  const REL_TYPE_CNAME = 'label_b_a';

  /**
   * @param $caseType
   *
   * @return FALSE|SimpleXMLElement
   */
  public function retrieve($caseType) {
    return CRM_Case_XMLRepository::singleton()->retrieve($caseType);
  }

  /**
   * @param $caseType
   *
   * @return mixed|string
   */
  public static function mungeCaseType($caseType) {
    // trim all spaces from $caseType
    $caseType = str_replace('_', ' ', $caseType);
    $caseType = CRM_Utils_String::munge(ucwords($caseType), '', 0);
    return $caseType;
  }

  /**
   * @param bool $indexName
   * @param bool $all
   *
   * @return array
   */
  function &allActivityTypes($indexName = TRUE, $all = FALSE) {
    static $activityTypes = NULL;
    if (!$activityTypes) {
      $activityTypes = CRM_Case_PseudoConstant::caseActivityType($indexName, $all);
    }
    return $activityTypes;
  }

  /**
   * @return array
   */
  function &allRelationshipTypes() {
    static $relationshipTypes = array();

    if (!$relationshipTypes) {
      $relationshipInfo = CRM_Core_PseudoConstant::relationshipType();

      $relationshipTypes = array();
      foreach ($relationshipInfo as $id => $info) {
        $relationshipTypes[$id] = $info[CRM_Case_XMLProcessor::REL_TYPE_CNAME];
      }
    }

    return $relationshipTypes;
  }
}

