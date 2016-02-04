# Modulo Itserv Feed 
Questo modulo permette di esportare feed xml per: google shopping, trovaprezzi, kelkoo e kirivo.
I feed saranno esportati nella root di Magento. I nomi dei files sono: feed_shopping.xml, feed_trovaprezzi.xml, feed_kelkoo.xml, feed_trovaprezzi_kirivo.xml

# Prerequisiti
Nel caso in cui si desideri utilizzare attributi come ean, brand/manufacturer/produttore ed mpn, è <b>necessario</b> :

<ul>
<li>Da pannello di controllo -> configurazione -> itserv feed, specificare il codice di questi attributi. Il sistema non ne terrà conto qualora non esistano</li>
<li>Impostare su SI la proprietà "Usato per la lista prodotti" dell'attributo</li>
</ul>

# Configurazione
Da pannello di controllo -> configurazione -> itserv feed è possibile impostare i costi di spedizione standard per trovaprezzi. 

# Installazione / Aggiornamento
<ul>
<li>Disattivare compilazione</li>
<li>Disattivare cache</li>
<li>Effettuare il logout dal pannello di controllo</li>
<li>Installare aggiornare il modulo tramite modgit</li>
<li>Aggiornare la compilazione</li>
<li>Aggiornare/Pulire la cache</li>
<li>Effettuare il login nel pannello di controllo</li>
<li>Verificare l'esistenza dell'attributo itserv_feed</li>
</ul>

Per ESCLUDERE i prodotti dai singoli feed utilizzare l'apposito attributo presente nella scheda meta information di ogni prodotto