<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Prodotto_Topnegozi extends Itserv_Feed_Model_Prodotto_Abstract {
    /**
     * Ritorna un array contenente esattamente i campi (con nomi specifici) che andranno a costituire la struttura
     * del feed
     * @return array
     */
    public function getArrayCaratteristiche() {        
        
        $array = array(
            'prod_name' => $this->getTitle(),            
            'prod_description' => strip_tags($this->getShortDescription()),
            'prod_full_price' => $this->getPrice(),
            'prod_price' => ($this->getSpecialPrice() == null) ? $this->getPrice() : $this->getSpecialPrice(),
            'prod_number' => $this->getSku(),
            'URL' => $this->getLink()."?utm_source=topnegozi&utm_medium=cpc&utm_term=".$this->getSku()."&utm_campaign=topnegozippc",
            'prod_availability' => $this->getAvailability() ? 1 : 0,
            'prod_category' => $this->getPathCategoria(';'),            
            'prod_imgs' => $this->getImageLink(),                        
            'prod_shipping_cost' => $this->costoSpedizione(),                       
            'prod_ean_upc' => $this->getEan(),
            'prod_delivery_time' => '24/48 ore',
            'prod_currency' => 'EUR',
        );                      
        
        if($this->getBrand() != false) {            
            $array["prod_brand"] = $this->getBrand();
        }
        
        return $array;
    }
    
    public function getShippingDays() {
        return Mage::getStoreConfig('feed_options/trovaprezzi/tempi_spedizione');
    }   
}