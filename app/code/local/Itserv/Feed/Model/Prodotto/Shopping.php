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
            'description' => (strlen(strip_tags($this->getShortDescription()) > 0))  ? strip_tags($this->getShortDescription()) : $this->getLongDescription(),
            'g:product_type' => $this->getPathCategoria(),
            //'g:custom_label_0' => $this->getPathCategoria(),
            'g:id' => $this->getSku(),
            'g:image_link' => $this->getImageLink(),
            'g:condition' => $this->getCondition(),
            'g:price' => $this->getPrice(),
            'g:availability' => $this->getAvailability() ? 'in stock' : 'out of stock',
            'g:brand' => ($this->getBrand() != false) ? $this->getBrand() : 'Non definito',
            'g:mpn' => $this->getMpn(),            
        );                                      
        
        if($this->getEan() != false) {
            $array["g:ean"] = $this->getEan();
        }

	if($this->getTaglia() != false) {
            $array["g:size"] = $this->getTaglia();
        }

	if($this->getColore() != false) {
            $array["g:color"] = $this->getColore();
        }
        
        if($this->getSpecialPrice() && ($this->getSpecialPrice() < $this->getPrice())) {
            $array["g:sale_price"] = $this->getSpecialPrice();
            $array["g:sale_price_effective_date"] = $this->getDataInizioFineOfferta();
        }
        
        return $array;
    }
}
