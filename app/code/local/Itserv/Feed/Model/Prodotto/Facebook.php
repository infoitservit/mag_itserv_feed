<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Prodotto_Facebook extends Itserv_Feed_Model_Prodotto_Abstract {
    /**
     * Ritorna un array contenente esattamente i campi (con nomi specifici) che andranno a costituire la struttura
     * del feed
     * @return array
     */
    public function getArrayCaratteristiche() {        
        
        $array = array(
            'id' => $this->getSku(),
            'title' => $this->getTitle(),
            'link' => $this->getLink()."?utm_source=facebook&utm_medium=cpc&utm_term=".$this->getSku()."&utm_campaign=Facebook_Ads",
            'description' => strip_tags($this->getShortDescription()),
            'condition' => 'new',
            'product_type' => preg_replace('/\s+/', '', $this->getPathCategoria()),
            'image_link' => $this->getImageLink(),
            'price' => $this->getPrice()." EUR",
            'availability' => $this->getAvailability() ? 'in stock' : 'out of stock',
            'brand' => ($this->getBrand() != false) ? $this->getBrand() : '',            
        );                      
        
        if($this->getEan() != false) {
            $array["gtin"] = $this->getEan();
        }
        
        if($this->getSpecialPrice() && ($this->getSpecialPrice() < $this->getPrice())) {
            $array["sale_price"] = $this->getSpecialPrice() .' EUR';
            $array["sale_price_effective_date"] = $this->getDataInizioFineOfferta();
        }
        
        return $array;
    }
}