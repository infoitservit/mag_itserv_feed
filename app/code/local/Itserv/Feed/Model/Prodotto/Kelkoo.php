<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Prodotto_Kelkoo extends Itserv_Feed_Model_Prodotto_Abstract {
    /**
     * Ritorna un array contenente esattamente i campi (con nomi specifici) che andranno a costituire la struttura
     * del feed
     * @return array
     */
    public function getArrayCaratteristiche() {        
        
        $array = array(
            'title' => $this->getTitle(),
            'product-url' => $this->getLink()."?utm_source=kelkoo&utm_medium=cpc&utm_term=".$this->getSku()."&utm_campaign=kelkooppc",
            'description' => strip_tags($this->getShortDescription()),
            'merchant-category' => preg_replace('/\s+/', '', $this->getPathCategoria('#')),
            'delivery-cost' => $this->costoSpedizione(),                                
            'image-url' => $this->getImageLink(),
            'price' => ($this->getSpecialPrice() == null) ? $this->getPrice() : $this->getSpecialPrice(),
            'availability' => $this->getAvailability() ? 'disponibile' : 'non disponibile',
            'brand' => ($this->getBrand() != false) ? $this->getBrand() : 'Non definito',            
        );                      
        
        if($this->getEan() != false) {
            $array["ean"] = $this->getEan();
        }
        
        return $array;
    }
}