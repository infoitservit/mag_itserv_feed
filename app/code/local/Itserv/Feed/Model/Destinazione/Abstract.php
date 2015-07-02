<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Itserv_Feed_Model_Destinazione_Abstract {        
    protected $_magentoPath = false;
    protected $_urlPath = false;
    protected $_imagePath = false;
    protected $_xmlPath = false; 
    
    //Identifica la destinazione e deve essere uguale alla radice della classe che gestisce la destinazione
    protected $_codiceDestinazione;
        
    //Ogni feed può avere un diverso modo di "nominare" l'elemento xml relativo al catalogo e quello dei singoli prodotti
    //Le sottoclassi dovranno definire tali elementi
    protected $_nomeNodoCatalogo;
    protected $_nomeNodoProdotto;
    
    /**
     * 
     * @param type $destinazione Il nome della classe (solo la parte finale) che istanzia i diversi tipi di prodotti (es. shopping, trovaprezzi ecc...)
     */
    public function __construct($codice_destinazione) {        
        $this->_codiceDestinazione = $codice_destinazione;
        $this->_magentoPath = Mage::getBaseDir();        
        $this->_urlPath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $this->_imagePath = $this->_urlPath . "media";
        $this->_xmlPath = $this->_magentoPath;             
    }           
    
    /**
     * Ritorna il codice della destinazione
     * @return type
     */
    public function getCodiceDestinazione() {        
        return $this->_codiceDestinazione;
    }        
    
    protected function getProdotti() {                       
        // Preparo la collection per i Prodotti Semplici con alcune accortezze:
        // -) I prodotti semplici estratti saranno soltanto quelli visibili individualmente
        //    Quelli non visibili individualmente fanno certamente parte di prodotti configurabili o bundle, che
        //    verranno estratti successivamente.
        // -) La dove il produttore non è stato specificato (obbligatorio secondo le linee guida google merchant) viene impostato
        //    in automatico un produttore "Non Definito". La speranza è che Google non respinga tale prodotto.        
            
            //$cache = Mage::app()->getCache();
            //if(!$cache->load('itserv_feed_collection')) {
                $_productCollection = Mage::getModel('catalog/product')->getCollection();
                $_productCollection->addAttributeToSelect('*');                        
                $_productCollection->addAttributeToSelect('stock_status');        
                $_productCollection->addAttributeToSelect(Mage::getStoreConfig('feed_options/mappa_attributi/produttore'));
                $_productCollection->addAttributeToSelect(Mage::getStoreConfig('feed_options/mappa_attributi/ean'));
                $_productCollection->addAttributeToSelect(Mage::getStoreConfig('feed_options/mappa_attributi/mpn'));      
                $_productCollection->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE);                                                                       
            //    $cache->save(serialize($_productCollection), "itserv_feed_collection", array("itserv_feed_collection"), 120);                
            //}
            //else {                
            //    $_productCollection = unserialize($cache->load('itserv_feed_collection'));
            //}
            return $_productCollection;
    }                   
    
    /**
     * Estrae il catalogo, parsa i singoli prodotti tramite l'apposito oggetto e crea un array del catalogo
     * da passare alla funzione che si occupa di implementarne l'output in un determinato formato
     */
    public function preparaCatalogo() {
        $catalogo = $this->getProdotti();        
        $array_prodotti_parsati = array();
        foreach($catalogo as $_product) {             
            $prodotto_destinazione = Mage::getModel("itserv_feed/prodotto_".$this->getCodiceDestinazione()."", $_product);   
            
            if ($_product->isVisibleInSiteVisibility() && ($_product->getSmallImage() != "" && $_product->getSmallImage() != 'no_selection' && $_product->getSmallImage() != null)) {                            
                $array_prodotti_parsati[] = $prodotto_destinazione->getArrayCaratteristiche();
            }            
        }                
        return $array_prodotti_parsati;
    }        
    
    /**
     * Inizializzazione del documento XML.
     * @return \DomDocument
     */
    public function creaDocXml() {
        $doc = new DomDocument('1.0', 'UTF-8');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        
        return $doc;
    }
    
    /**
     * Il metodo può essere usato per decorare ulterioriormente il file xml
     * @return \DomDocument
     */
    public function preparaDocXml() {
        return $this->creaDocXml();        
    }
   
    /**
     * Elabora i prodotti e li struttura in modalità xml.
     * Questa parte va utilizzata all'interno di un file xml appositamente costruito in base
     * alla destinazione
     * 
     * @param array $v
     * @param DOMDocument $doc
     * @param type $nomeNodoProdotto     
     * @return \DOMDocument
     */
    public function preparaFileXml() {
        //Prepara il file doc XML creandolo e decorandolo qualora la sotto classe lo abbia richiesto
        $doc = $this->preparaDocXml();                
        
        //Prepara il catalogo
        $v = $this->preparaCatalogo();                                       
        
        //Recupera, se esiste, il nodo generale del catalogo, oppure crealo. Poi...
            $nodoCatalogo = $doc->getElementsByTagName($this->_nomeNodoCatalogo)->item(0);
            if(is_null($nodoCatalogo)) {
                $nodoCatalogo = $doc->createElement($this->_nomeNodoCatalogo);
                $doc->appendChild($nodoCatalogo);
            }  
        
        foreach ($v as $i) {
            //Inserisce un elemento per contenere le info del prodotto
            $item = $doc->createElement($this->_nomeNodoProdotto);                        
            
            //...aggancia il nuovo elemento ad esso
            $item = $nodoCatalogo->appendChild($item);            

            foreach ($i as $fieldName => $fieldValue) {
                $child = $doc->createElement($fieldName);
                $child = $item->appendChild($child);

                /*
                 * DA RIVEDERE
                 * if (is_array($fieldValue)) {
                    $value = $doc->createTextNode(implode("|", $fieldValue[$_product->getSku()]));
                    $value = $child->appendChild($value);
                } else {
                    $value = $doc->createTextNode($fieldValue);
                    $value = $child->appendChild($value);
                }*/
                
                $value = $doc->createTextNode($fieldValue);
                $value = $child->appendChild($value);
            }
        }
        return $doc;
    }
    
    public function salvaFileXml() {
        $doc = $this->preparaFileXml();
        // Prepare XML file to save                        
        $xmlFile = $this->_xmlPath . "/feed_".$this->_codiceDestinazione.".xml";
        if (file_exists($xmlFile)) {
            //Mage::log("Eliminazione file precedente", null, $_logFileName);
            unlink($xmlFile);
        }       
        $doc->save($xmlFile);        
    }  
}
