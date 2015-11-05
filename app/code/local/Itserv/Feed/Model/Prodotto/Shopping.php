<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Prodotto_Shopping extends Itserv_Feed_Model_Prodotto_Abstract {
    /**
     * Ritorna un array contenente esattamente i campi (con nomi specifici) che andranno a costituire la struttura
     * del feed
     * @return array
     */
    public function getArrayCaratteristiche() {        
        
        $array = array(
            'title' => $this->getTitle(),
            'link' => $this->getLink(),
            'description' => strip_tags($this->getShortDescription()),
            'g:product_type' => $this->getPathCategoria(),
            //'g:custom_label_0' => $this->getPathCategoria(),
            'g:id' => $this->getSku(),
            'g:image_link' => $this->getImageLink(),
            'g:condition' => $this->getCondition(),
            'g:price' => $this->getPrice(),
            'g:sale_price' => $this->getSpecialPrice(),
            'g:sale_price_effective_date' => $this->getDataInizioFineOfferta(),
            'g:availability' => $this->getAvailability() ? 'in stock' : 'out of stock',
            'g:brand' => ($this->getBrand() != false) ? $this->getBrand() : 'Non definito',
            'g:mpn' => $this->getMpn(),            
        );                                      
        
        if($this->getEan() != false) {
            $array["g:ean"] = $this->getEan();
        }
        
        return $array;
    }
}