<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;
/** @var $installer Mage_Eav_Model_Entity_Setup */
$installer->startSetup();

//Aggiungo destinazione Shop Alike all'attributo itserv_feed

$aDestinazioni = array('Shop Alike');
$iProductEntityTypeId = Mage::getModel('catalog/product')->getResource()->getTypeId();
$aOption = array();
$aOption['attribute_id'] = $installer->getAttributeId($iProductEntityTypeId, 'itserv_feed');

for($iCount=0;$iCount<sizeof($aDestinazioni);$iCount++){
   $aOption['value']['option'.$iCount][0] = $aDestinazioni[$iCount];
}
$installer->addAttributeOption($aOption);

//Aggiungo attributo "escludi dal feed" alle categorie
$attribute  = array(
    'type' => 'int',
    'label'=> 'Escludi dal Feed',
    'input' => 'select',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'group' => "General Information",
    'source'   => 'eav/entity_attribute_source_boolean',
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'default'  => 0,
    'note' => 'Attenzione: se hai associato un prodotto a questa ED ALTRE categorie, il prodotto verrà comunque escluso in generale, anche se le altre categorie non risultano da escludere.'
);
$installer->addAttribute('catalog_category', 'itserv_feed_escludi', $attribute);

$installer->endSetup();