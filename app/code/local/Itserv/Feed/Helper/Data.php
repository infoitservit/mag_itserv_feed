<?php

class Itserv_Feed_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function calculateShippingCosts($productId, $country, $storeId = 1)
    {
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
 
        foreach($model->getResult()->getAllRates() as $rate) {
            $costs[$rate->getCarrier()] = array(
                'title' => trim($rate->getCarrierTitle()),
                'price' => $rate->getPrice()
            );
        }
 
        return $costs;
    }
}
