<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Prodotto_Shopalike extends Itserv_Feed_Model_Prodotto_Abstract {
    /**
     * Ritorna un array contenente esattamente i campi (con nomi specifici) che andranno a costituire la struttura
     * del feed
     * @return array
     */
    public function getArrayCaratteristiche() {        
        
        $array = array(
            'itemId' => $this->getSku(),
            'name' => $this->getTitle(),            
            'description' => strip_tags($this->getShortDescription()),
            'price' => ($this->getSpecialPrice() == null) ? $this->getPrice() : $this->getSpecialPrice(),
            'oldPrice' => $this->getPrice(),
            'deepLink' => $this->getLink()."?utm_source=shopalike&utm_medium=cpc&utm_term=".$this->getSku()."&utm_campaign=shopalikeppc",
            'fullCategory' => $this->getTopCategory(),            
            'category' => $this->getPathCategoria(',',1),            
            'image' => $this->getImageLink(),                        
            'shippingCosts' => $this->costoSpedizione(),                       
            'availability' => $this->getShippingDays(),
            'CPC' => $this->getCPC(),
            'currency' => $this->getCodiceValuta()
        );                      
        
        if($this->getBrand() != false) {            
            $array["Brand"] = $this->getBrand();
        }
        
        return $array;
    }
    
    public function getShippingDays() {
        return Mage::getStoreConfig('feed_options/trovaprezzi/tempi_spedizione');
    }   
    
    public function getTopCategory() {
        return Mage::getStoreConfig('feed_options/shopalike/top_category');
    }
    
    public function getCPC() {
        return Mage::getStoreConfig('feed_options/shopalike/cpc');
    }
}