<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ItServ_Feed_Model_System_Config_Source_Destinazioni
{
    //Ad ogni costante è associato il codice della destinazione, sul quale si basa la Factory
    const GoogleShopping = 'shopping';
    const Kelkoo = 'kelkoo';
    const Trovaprezzi = 'trovaprezzi';
    const Kirivo = 'trovaprezzi_kirivo';
    const Topnegozi = 'topnegozi';
    const Twenga = 'twenga';
    const ShopAlike = 'shopalike';
    const Facebook = 'facebook';
    
    const labelGoogleShopping = "Google Shopping";
    const labelTrovaprezzi = "Trovaprezzi";
    const labelKirivo = "Kirivo";
    const labelKelkoo = "Kelkoo";
    const labelTopnegozi = "Topnegozi";
    const labelTwenga = "Twenga";
    const labelShopAlike = "Shop Alike";
    const labelFacebook = "Facebook";
    
    public function toOptionArray()
    {
        return array(
            array('value'=>self::GoogleShopping, 'label'=>self::labelGoogleShopping),
            array('value'=>self::Trovaprezzi, 'label'=>self::labelTrovaprezzi),
            array('value'=>self::Kirivo, 'label'=>self::labelKirivo),                        
            array('value'=>self::Kelkoo, 'label'=>self::labelKelkoo),
            array('value'=>self::Topnegozi, 'label'=>self::labelTopnegozi),
            array('value'=>self::Twenga, 'label'=>self::labelTwenga),
            array('value'=>self::ShopAlike, 'label'=>self::labelShopAlike),
            array('value'=>self::Facebook, 'label'=>self::labelFacebook),
        );
    }
    
    public function getValueOpzioneByLabel($label) {
        $attributeItservFeedName = Mage::helper('itserv_feed')->getItServFeedAttributeName();
        $attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', $attributeItservFeedName);
        $collection =Mage::getResourceModel('eav/entity_attribute_option_collection')
        ->setPositionOrder('asc')
        ->setAttributeFilter($attributeId)
        ->setStoreFilter(Mage::app()->getStore()->getId())
        ->load();
        
        foreach($collection->toOptionArray() as $array_opzione) {
            if($label === $array_opzione['label']) {
                return $array_opzione['value'];
            }
        }
        
        return '';
    }
    
    public function getValueOpzioneByCodice($codice) {
        foreach($this->toOptionArray() as $arrayDestinazione) {
            if($arrayDestinazione['value'] == $codice){
                return $this->getValueOpzioneByLabel($arrayDestinazione['label']);
            }
        }
        return false;
    }
}