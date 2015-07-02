<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Esporta {
    public function run() {
        $_logFileName = "export_feed.log";
        $status = Mage::getStoreConfig('feed_options/configurazione_generale/status');                
        
        if($status) {
            $destinazioni = Mage::getStoreConfig('feed_options/configurazione_generale/destinazioni');        
            if($destinazioni) {
                $array_destinazioni = explode(',', $destinazioni);
                foreach ($array_destinazioni as $destinazione) {                    
                    $modello = Mage::getModel('itserv_feed/destinazione_'.$destinazione, $destinazione);                    
                    $modello->salvaFileXml();
                    Mage::log('Feed '.ucfirst($destinazione).' creato.');
                }                
            }            
        }
        else {            
            Mage::log("Il sistema è stato disattivato da pannello di controllo", null, $_logFileName);
        }                
    }
}