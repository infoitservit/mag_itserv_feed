<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Destinazione_Trovaprezzi extends Itserv_Feed_Model_Destinazione_Abstract {                                           
    protected $_nomeNodoCatalogo = 'Products';
    protected $_nomeNodoProdotto = 'Offer';          
    
    protected function getProdotti() {
        $_productCollection = parent::getProdotti();
        //Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($_productCollection);
        return $_productCollection;
    }
            
    /**
    protected function getProdotti() {                       
        // Preparo la collection per i Prodotti Semplici con alcune accortezze:
        // -) I prodotti semplici estratti saranno soltanto quelli visibili individualmente
        //    Quelli non visibili individualmente fanno certamente parte di prodotti configurabili o bundle, che
        //    verranno estratti successivamente.
        // -) La dove il produttore non è stato specificato (obbligatorio secondo le linee guida google merchant) viene impostato
        //    in automatico un produttore "Non Definito". La speranza è che Google non respinga tale prodotto.        
            
            //$cache = Mage::app()->getCache();
            //if(!$cache->load('itserv_feed_collection')) {        
                $_productCollection = Mage::getModel('catalog/product')->getCollection();
                $_productCollection->addAttributeToSelect('*');                        
                $_productCollection->addAttributeToSelect('stock_status');        
                $_productCollection->addAttributeToSelect(Mage::getStoreConfig('feed_options/mappa_attributi/produttore'));
                $_productCollection->addAttributeToSelect(Mage::getStoreConfig('feed_options/mappa_attributi/ean'));
                $_productCollection->addAttributeToSelect(Mage::getStoreConfig('feed_options/mappa_attributi/mpn'));      
                $_productCollection->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);                                                                       
                Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($_productCollection);
            //    $cache->save(serialize($_productCollection), "itserv_feed_collection", array("itserv_feed_collection"), 120);                
            //}
            //else {                
            //    $_productCollection = unserialize($cache->load('itserv_feed_collection'));
            //}
            return $_productCollection;
    }  
     * 
     */ 
}