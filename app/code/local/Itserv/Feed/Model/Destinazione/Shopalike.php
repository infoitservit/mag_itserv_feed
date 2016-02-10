<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Destinazione_Shopalike extends Itserv_Feed_Model_Destinazione_Abstract {                                           
    protected $_nomeNodoCatalogo = 'items';
    protected $_nomeNodoProdotto = 'item';          
    
    protected function getProdotti() {
        $_productCollection = parent::getProdotti();
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($_productCollection);
        return $_productCollection;
    }
}