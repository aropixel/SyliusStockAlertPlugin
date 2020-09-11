<?php


declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;


final class TaxonTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stockTresholdAlert', IntegerType::class, [
                'label' => 'aropixel.admin.label_product_stock_treshold'
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [TaxonType::class];
    }
}
