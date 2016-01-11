# Modulo Itserv Feed 
Questo modulo permette di esportare feed xml per: google shopping, trovaprezzi, kelkoo e twenga.
I feed saranno esportati nella root di Magento. I nomi dei files sono: feed_shopping.xml, feed_trovaprezzi.xml, feed_kelkoo.xml, feed_twenga.xml

# Prerequisiti
Nel caso in cui si desideri utilizzare attributi come ean, brand/manufacturer/produttore ed mpn, è <b>necessario</b> :

<ul>
<li>Da pannello di controllo -> configurazione -> itserv feed, specificare il codice di questi attributi. Il sistema non ne terrà conto qualora non esistano</li>
<li>Impostare su SI la proprietà "Usato per la lista prodotti" dell'attributo</li>
</ul>

# Configurazione
Da pannello di controllo -> configurazione -> itserv feed è possibile impostare i costi di spedizione standard per trovaprezzi. 

# Installazione
Utilizzare modgit
