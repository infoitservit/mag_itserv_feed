<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Prodotto_Twenga extends Itserv_Feed_Model_Prodotto_Abstract {
    /**
     * Ritorna un array contenente esattamente i campi (con nomi specifici) che andranno a costituire la struttura
     * del feed
     * @return array
     */
    public function getArrayCaratteristiche() {        
        
        $array = array(
            'Name' => $this->getTitle(),            
            'ShortDescription' => strip_tags($this->getShortDescription()),
            'LongDescription' => strip_tags($this->getLongDescription()),
            'Price' => ($this->getSpecialPrice() == null) ? $this->getPrice() : $this->getSpecialPrice(),
            'OriginalPrice' => $this->getPrice(),
            'Code' => $this->getSku(),
            'Link' => $this->getLink()."?utm_source=twenga&utm_medium=cpc&utm_term=".$this->getSku()."&utm_campaign=twengappc",
            'Stock' => $this->getAvailability() ? intval($this->getStockQty()) : 0,
            'Categories' => $this->getPathCategoria(','),            
            'Image' => $this->getImageLink(),                        
            'ShippingCost' => $this->costoSpedizione(),                       
            'EanCode' => $this->getEan(),
            'ShippingDays' => $this->getShippingDays(),
        );                      
        
        if($this->getBrand() != false) {            
            $array["Brand"] = $this->getBrand();
        }
        
        return $array;
    }
    
    public function getStockQty() {
        return Mage::getModel('cataloginventory/stock_item')->loadByProduct($this->_prodotto)->getQty();
    } 
    
    public function getShippingDays() {
        return Mage::getStoreConfig('feed_options/trovaprezzi/tempi_spedizione');
    }   
}