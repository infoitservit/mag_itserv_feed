<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ItServ_Feed_Model_System_Config_Source_Destinazioni
{
    //Ad ogni costante è associato il codice della destinazione, sul quale si basa la Factory
    const GoogleShopping = 'shopping';
    const Kelkoo = 'kelkoo';
    const Trovaprezzi = 'trovaprezzi';
    const Kirivo = 'trovaprezzi_kirivo';
    
    public function toOptionArray()
    {
        return array(
            array('value'=>self::GoogleShopping, 'label'=>'Google Shopping'),
            array('value'=>self::Trovaprezzi, 'label'=>'Trovaprezzi'),
            array('value'=>self::Kirivo, 'label'=>'Kirivo'),                        
            array('value'=>self::Kelkoo, 'label'=>'Kelkoo'),
        );
    }
}