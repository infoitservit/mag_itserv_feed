<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Itserv_Feed_Model_Prodotto_Abstract {

    protected $_prodotto = false;
    protected $_availability = false;
    protected $_brand = false;
    protected $_condition  = false;
    protected $_categoria = false;
    protected $_ean = false;
    protected $_imageLink = false;
    protected $_link = false;
    protected $_longDescription = false;
    protected $_mpn = false;
    protected $_price = false;
    protected $_shortDescription = false;
    protected $_sku = false;
    protected $_specialPrice = false;
    protected $_title = false;
    protected $_dataInizioFineOfferta = false;     

    public function __construct(Mage_Catalog_Model_Product $prodotto) {                        
        $this->_prodotto = $prodotto;        
    }

    protected function getTitle() {
        $this->_title = $this->_prodotto->getName();
        return $this->_title;
    }

    protected function getLink() {
        $this->_link = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . $this->_prodotto->geturlpath();
        return $this->_link;
    }

    protected function getShortDescription() {
        $this->_shortDescription = strip_tags($this->_prodotto->getShortDescription());        
        return $this->_shortDescription;
    }

    protected function getLongDescription() {
        $this->_longDescription = strip_tags($this->_prodotto->getDescription());
        return $this->_longDescription;
    }

    protected function getSku() {
        $this->_sku = $this->_prodotto->getSku();
        return $this->_sku;
    }

    protected function getImageLink() {
        $this->_imageLink = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product' . $this->_prodotto->getSmallImage();
        return $this->_imageLink;
    }

    protected function getPrice() {
        $this->_price = $this->_prodotto->getPrice();
        return $this->_price;
    }

    protected function getSpecialPrice() {
        $this->_specialPrice = $this->_prodotto->getSpecialPrice();
        return $this->_specialPrice;
    }
    
    /**
     * Di default 'new'
     */
    protected function getCondition() {
        $this->_condition = 'new';
        return $this->_condition;
    }

    protected function getDataInizioFineOfferta() {
        if ($this->_prodotto->getSpecialFromDate() != NULL) {
            $data_inizio_offerta = new DateTime($this->_prodotto->getSpecialFromDate());
            $data_inizio_offerta = $data_inizio_offerta->format('c');
        } //...se non esiste, setta la data odierna.
        else {
            $data_inizio_offerta = new DateTime(date('Y-m-d'));
            $data_inizio_offerta = $data_inizio_offerta->format('c');
        }

        //Se la data di fine offerta esiste...
        if ($this->_prodotto->getSpecialToDate() != NULL) {
            $data_fine_offerta = new DateTime($this->_prodotto->getSpecialToDate());
            $data_fine_offerta = $data_fine_offerta->format('c');
        } //...se non esiste, setta una data fittizia che consenta di mantenere attiva l'offerta (oggi + 3 mesi)
        else {
            $data_fine_offerta = new DateTime(date('Y-m-d'));
            $data_fine_offerta = $data_fine_offerta->add(new DateInterval('P3M'));
            $data_fine_offerta = $data_fine_offerta->format('c');
        }
        
        $this->_dataInizioFineOfferta = $data_inizio_offerta . '/' . $data_fine_offerta;
        return $this->_dataInizioFineOfferta;
    }

    /**
     * Controlla se il prodotto è disponibile
     * @return bool
     */
    protected function getAvailability() {
        $stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($this->_prodotto);
        $this->_availability = $stock->getIsInStock();
        return $this->_availability;
    }

    protected function getBrand() {
        $this->_brand = ($this->_prodotto->getAttributeText('manufacturer') != "") ? $this->_prodotto->getAttributeText('manufacturer') : false;        
        return $this->_brand;
    }

    protected function getMpn() {
        $this->_mpn = $this->getSku();
        if($this->_prodotto->offsetExists('mpn')) {
            $this->_mpn = ($this->_prodotto->getAttributeText('mpn') != "") ? $this->_prodotto->getAttributeText('mpn') : "Non Definito";            
        }           
        return $this->_mpn;
    }

    protected function getEan() {
        $this->_ean = false;
        if($this->_prodotto->offsetExists('ean')) {
            $this->_ean = ($this->_prodotto->getData('ean') != "") ? $this->_prodotto->getData('ean') : "Non Definito";            
        }        
        return $this->_ean;
    }

    protected function getPathCategoria($separatore = '&gt;') {
        $product_categories = $this->_prodotto->getCategoryIds();
        $path = "";
        if (count($product_categories != 0)) {
            foreach ($product_categories as $category_id) {
                //Bypasso la categoria delle offerte
                if ($category_id != 100) {
                    $cat_obj = Mage::getModel('catalog/category')->load($category_id);
                    //Evita nomi duplicati
                    if (!strpos($path, $cat_obj->getName())) {
                        $path .= $cat_obj->getName();
                        if ($category_id != end($product_categories)) {
                            $path .= " ".$separatore." ";
                        }
                    }
                }
            }
        }
        $this->_categoria = $path;
        return $this->_categoria;
    }
    
    /**
     * Funzione che ritorna il costo della spedizione. Il valore dipende dalle
     * impostazioni di configurazione.
     * #FUNZIONE DA COMPLETARE#
     * @return type
     */
    protected function costoSpedizione() {
        if((Mage::getStoreConfig('feed_options/spedizione/set_costo_spedizione'))) {
            //PARTE DA COMPLETARE. Dovrebbe ritornare un valore calcolato in automatico, preso magari
            //dal flat rate.
            return Mage::getStoreConfig('feed_options/spedizione/costo_spedizione');
        }
        else {
            return Mage::getStoreConfig('feed_options/spedizione/costo_spedizione');
        }
    }

    abstract protected function getArrayCaratteristiche();
}