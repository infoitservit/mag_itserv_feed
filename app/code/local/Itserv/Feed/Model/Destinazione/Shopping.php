<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Itserv_Feed_Model_Destinazione_Shopping extends Itserv_Feed_Model_Destinazione_Abstract {                                              
    protected $_nomeNodoProdotto = 'item';
    protected $_nomeNodoCatalogo = 'channel';
    
    /**
     * Prepara il file XML completo
     * @return type
     */
    public function preparaDocXml() {        
        $doc = $this->creaDocXml();
        
        $rss = $doc->createElement('rss');
        $rss = $doc->appendChild($rss);

        $rss_version = $doc->createAttribute('version');
        $rss->appendChild($rss_version);

        $rss_version_value = $doc->createTextNode('2.0');
        $rss_version->appendChild($rss_version_value);

        $rss_google = $doc->createAttribute('xmlns:g');
        $rss->appendChild($rss_google);

        $rss_google_value = $doc->createTextNode('http://base.google.com/ns/1.0');
        $rss_google->appendChild($rss_google_value);

        $channel = $doc->createElement($this->_nomeNodoCatalogo);
        $rss->appendChild($channel);

        $title = $doc->createElement('title');
        $title = $channel->appendChild($title);
        $title_value = $doc->createTextNode('Feed NoiHB.it');
        $title_value = $title->appendChild($title_value);

        $link = $doc->createElement('link');
        $link = $channel->appendChild($link);
        $link_value = $doc->createTextNode($this->_urlPath);
        $link_value = $link->appendChild($link_value);

        $description = $doc->createElement('description');
        $description = $channel->appendChild($description);
        $description_value = $doc->createTextNode('Feed del sito web Noihb.it');
        $description_value = $description->appendChild($description_value);
        
        return $doc;                
    }                     
}