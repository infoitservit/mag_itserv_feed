<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_IndexController extends Mage_Core_Controller_Front_Action {
    public function shoppingAction() {        
        $model = Mage::getModel('itserv_feed/destinazione_shopping');                        
        $model->salvaFileXml();          
    }
    
    public function trovaprezziAction() {
        $model = Mage::getModel('itserv_feed/destinazione_trovaprezzi');               
        $model->salvaFileXml(); 
    }
    
    public function esportaAction() {        
        $esporta = Mage::getModel('itserv_feed/esporta')->run();
    }
}