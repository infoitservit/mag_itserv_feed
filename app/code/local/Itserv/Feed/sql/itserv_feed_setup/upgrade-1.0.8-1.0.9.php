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

$attr = array (
  'group' => 'Meta Information', //Aggiunge l'attributo nel gruppo Meta Information di tutti gli attribute sets
  'attribute_model' => NULL,
  'backend' => 'eav/entity_attribute_backend_array',
  'type' => 'varchar',
  'table' => '',
  'frontend' => '',
  'input' => 'multiselect',
  'label' => 'Escludi Destinazione/i',
  'frontend_class' => '',
  'source' => '',
  'required' => '0',
  'user_defined' => '1',
  'default' => '',
  'unique' => '0',
  'note' => '',
  'input_renderer' => NULL,
  'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
  'visible' => '1',
  'searchable' => '0',
  'filterable' => '0',
  'comparable' => '0',
  'visible_on_front' => '0',
  'is_html_allowed_on_front' => '0',
  'is_used_for_price_rules' => '0',
  'filterable_in_search' => '0',
  'used_in_product_listing' => '1',
  'used_for_sort_by' => '0',
  'is_configurable' => '0',
  'apply_to' => '',
  'visible_in_advanced_search' => '0',
  'position' => '0',
  'wysiwyg_enabled' => '0',
  'used_for_promo_rules' => '0',
  'option' => 
  array (
    'values' => 
    array (
      '0' => 'Google Shopping',
      '1' => 'Trovaprezzi',
      '2' => 'Kelkoo',
      '3' => 'Kirivo',
    ),
  ),
);
$this->addAttribute('catalog_product', 'itserv_feed', $attr);

$installer->endSetup();

