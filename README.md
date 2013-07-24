mzentrale Cash On Delivery
==============================
This extension fixes a bug found in Magento Cash On Delivery payment method.

Facts
-----
- version: 1.0
- extension key: Mzentrale_Cashondelivery
- [extension on GitHub](https://github.com/mzentrale/Mzentrale_Cashondelivery)
- [direct download link](https://github.com/mzentrale/Mzentrale_Cashondelivery/archive/CE-1.8.zip)

Description
-----------
The default Magento Cash On Delivery payment method has a little bug. When checking if the payment method is available for a given quote, the billing address is used instead of the shipping address.

Now, let's consider an example. The shop I want to buy from is located in Austria, and is offering Cash on Delivery only for shipments in Austria. I live in Germany and I found out about this shop. A friend who is living in Austria is ordering the goods for me - let's pretend I don't have a computer :-) - but the shipment is to be delivered in Germany, with payment upon receipt. If I use the current implementation of Magento, no error is raised during checkout. The behaviour is obviously not correct.

This little extension overrides the standard CoD method, checking the availability of the payment method against the shipping address instead of the billing address, and making sure the payment method is displayed during checkout only when needed.

Requirements
------------
- PHP >= 5.2.0
- Mage_Payment

Compatibility
-------------
- Magento CE >= 1.8 or EE 1.13
- A version for CE < 1.7 might be available in the future. If you want to contribute, please open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests)

Installation Instructions
-------------------------
1. Copy all the files contained in `src` folder into your document root.
2. Alternatively, use [modman][modman] or [modgit][modgit] to install.
3. Clear Magento config cache.

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/mzentrale/Mzentrale_Cashondelivery/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Francesco Marangi  
[@fmarangi](https://twitter.com/fmarangi)

Licence
-------
[The MIT License](http://opensource.org/licenses/MIT)

Copyright
---------
(c) 2013 mzentrale | eCommerce - eBusiness
