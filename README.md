<p align="center">
  <a href="http://www.aropixel.com/">
    <img src="https://avatars1.githubusercontent.com/u/14820816?s=200&v=4" alt="Aropixel logo" width="75" height="75" style="border-radius:100px">
  </a>
</p>

<h1 align="center">Sylius Stock Alert Plugin</h1>
<h3 align="center">Get notifed when your product stock reaches a certain treshold</h3>


## Table of contents

- [Presentation](#presentation)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)


## Presentation


Once the plugin is installed and configured, you'll be able to define in the admin a stock treshold for each product and / or taxonomy.
When inventory levels fall below this threshold (wether with a new order, a stock modification in the admin or a stock treshold modification), notifications will be displayed in the admin dashboard and also sent by emails. 
Custom notifier can
also be implemented easily.


## Installation

In a sylius application :

- Install the plugin : 
`composer require aropixel/sylius-stock-alert-plugin`

If the plugin is not registered in the config/bundles.php file, register it by adding:
```
Aropixel\SyliusStockAlertPlugin\AropixelSyliusStockAlertPlugin::class => ['all' => true],
```

- Create a aropixel_sylius_stock_alert.yaml in the config folder and import the plugin configuration:

```
imports:
    - { resource: "@AropixelSyliusStockAlertPlugin/Resources/config/app/config.yml" }
```

- Make sure the sylius mailer plugin is configured (in your config/sylius_mailer.yaml file)

- If you need the emails stock alert, enable it and configure it in the aropixel_sylius_stock_alert.yaml (you can multiple recipients for the emails alerts): 

```
aropixel_sylius_stock_alert:
    mail_stock_notifier:
        enabled: true
        recipients: ['david@aropixel.com']
```

- Make your 'ProductVariant' entity (in your src/Entity/Product folder) extends the ProductVariant entity of the bundle:

```
use Aropixel\SyliusStockAlertPlugin\Entity\ProductVariant as BaseProductVariant;
...

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
class ProductVariant extends BaseProductVariant
{
...
}

```


- Make your 'Taxon' entity (in your src/Entity/Taxonomy folder) extends the ProductVariant entity of the bundle:

```
use Aropixel\SyliusStockAlertPlugin\Entity\Taxon as BaseTaxon;
...

**
 * @ORM\Entity
 * @ORM\Table(name="sylius_taxon")
 */
class Taxon extends BaseTaxon implements Comparable
{
...
}

```

- run the migrations

```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

- install the assets: 

```php bin/console assets:install```


## Usage

You can define stock treshold in the product admin ("stock" tab), but also in the taxonomies of the product. The stock treshold in the product have
the highest priority: if it's defined, it will not be overrided by the stock treshold of the taxonomy. If the stock
treshold of the product is not defined, the plugin will look in all the taxonomies of the product, compare them all and keep only the 
lowest (the most restrictive stock treshold of the taxonomies).

Everytime the stock or stock treshold changes, the plugin updates the dashboard notifications.

Everytime an order is completed, the plugin will look for all the notifiers implemented (by default only the email notifier), and send the
associated notification. The Email notifier is the only one implemented by default in the plugin. If you want to implements
other notifier (like SMS etc), you just need to create a class that extends the Aropixel\SyliusStockAlertPlugin\StockNotifier\StockNotifierInterface
and implement the sendNotification() method. Your method will be automatically called.
 
## License
Aropixel Blog Bundle is under the [MIT License](LICENSE)
