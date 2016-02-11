<?php

class Itserv_Feed_Helper_Data extends Mage_Core_Helper_Abstract {

    const attributeItServFeedName = 'itserv_feed';
    const XML_PATH_SPEDIZIONE_BASE = 'feed_options/spedizione/costo_spedizione';
    const XML_PATH_SPEDIZIONE_GRATUITA = 'feed_options/spedizione/spedizione_gratuita';

    public function calculateShippingCosts($productId, $country, $storeId = 1) {
        $product = Mage::getModel('catalog/product')->load($productId);
        $item = Mage::getModel('sales/quote_item')->setProduct($product)->setQty(1);
        $store = Mage::getModel('core/store')->load($storeId);

        $request = Mage::getModel('shipping/rate_request')
                ->setAllItems(array($item))
                ->setDestCountryId($country)
                ->setPackageValue($product->getFinalPrice())
                ->setPackageValueWithDiscount($product->getFinalPrice())
                ->setPackageWeight($product->getWeight())
                ->setPackageQty(1)
                ->setPackagePhysicalValue($product->getFinalPrice())
                ->setFreeMethodWeight(0)
                ->setStoreId($store->getId())
                ->setWebsiteId($store->getWebsiteId())
                ->setFreeShipping(0)
                ->setBaseCurrency($store->getBaseCurrency())
                ->setBaseSubtotalInclTax($product->getFinalPrice());

        $model = Mage::getModel('shipping/shipping')->collectRates($request);
        $costs = array();

        foreach ($model->getResult()->getAllRates() as $rate) {
            $costs[$rate->getCarrier()] = array(
                'title' => trim($rate->getCarrierTitle()),
                'price' => $rate->getPrice()
            );
        }

        return $costs;
    }

    public function getItservFeedAttributeName() {
        return self::attributeItServFeedName;
    }

    public function getSpedizioneBase() {
        if($this->checkIsStringaVariabileCustom(Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_BASE))) {
            $codiceVariabileCustom = $this->pulisciStringaVariabileCustom(Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_BASE));
            return $this->getValoreVariabileCustomByCodice($codiceVariabileCustom);
        }
        
        if(Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_BASE)) {
            return Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_BASE);
        }
        
        return '';
    }

    public function getSogliaSpedizioneGratuita() {
         if($this->checkIsStringaVariabileCustom(Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_GRATUITA))) {
            $codiceVariabileCustom = $this->pulisciStringaVariabileCustom(Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_GRATUITA));
            return $this->getValoreVariabileCustomByCodice($codiceVariabileCustom);
        }
        
        if(Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_GRATUITA)) {
            return Mage::getStoreConfig(self::XML_PATH_SPEDIZIONE_GRATUITA);
        }
        
        return '';
    }

    /*
     * Controlla se la stringa corrisponde al formato di una variabile custom (inizia con {{)
     */

    public function checkIsStringaVariabileCustom($stringaVariabile) {
        if (strstr($stringaVariabile, "{{")) {
            return true;
        }
        return false;
    }

    /**
     * Partendo dalla stringa che identifica la variabile custom contenente il codice ritorna il suo valore plain
     * La stringa da passare è comprensiva delle parentesi graffe. Verranno rimosse automaticamente
     * @param type $codice
     * @return type
     */
    public function getValoreVariabileCustomByCodice($codice) {
        if($codice) {
            return floatval(Mage::getModel('core/variable')->loadByCode($codice)->getValue('plain'));
        }
        return '';
    }
    
    public function pulisciStringaVariabileCustom($stringa) {
        if($stringa) {
            return str_replace(array('{{', '}}'), '', $stringa);
        }
        return '';
    }

}
