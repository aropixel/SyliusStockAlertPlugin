<?php

declare(strict_types=1);

namespace Aropixel\SyliusStockAlertPlugin\Controller;

use Aropixel\SyliusStockAlertPlugin\Repository\ProductVariantStockAlertRepository;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Dashboard\DashboardStatisticsProviderInterface;
use Sylius\Component\Core\Dashboard\SalesDataProviderInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

final class DashboardController
{
    /** @var DashboardStatisticsProviderInterface */
    private $statisticsProvider;

    /** @var ChannelRepositoryInterface */
    private $channelRepository;

    /** @var EngineInterface */
    private $templatingEngine;

    /** @var RouterInterface */
    private $router;

    /** @var SalesDataProviderInterface|null */
    private $salesDataProvider;
    /**
     * @var ProductVariantStockAlertRepository
     */
    private $productVariantStockAlertRepository;

    public function __construct(
        DashboardStatisticsProviderInterface $statisticsProvider,
        ChannelRepositoryInterface $channelRepository,
        EngineInterface $templatingEngine,
        RouterInterface $router,
        ProductVariantStockAlertRepository $productVariantStockAlertRepository,
        ?SalesDataProviderInterface $salesDataProvider = null
    ) {
        $this->statisticsProvider = $statisticsProvider;
        $this->channelRepository = $channelRepository;
        $this->templatingEngine = $templatingEngine;
        $this->router = $router;
        $this->productVariantStockAlertRepository = $productVariantStockAlertRepository;
        $this->salesDataProvider = $salesDataProvider;

        if ($this->salesDataProvider === null) {
            @trigger_error(
                sprintf('Not passing a $salesDataProvider to %s constructor is deprecated since Sylius 1.7 and will be removed in Sylius 2.0.', self::class),
                \E_USER_DEPRECATED
            );
        }
    }

    public function indexAction(Request $request): Response
    {
        $channelCode = $request->query->get('channel');

        /** @var ChannelInterface|null $channel */
        $channel = $this->findChannelByCodeOrFindFirst($channelCode);

        if (null === $channel) {
            return new RedirectResponse($this->router->generate('sylius_admin_channel_create'));
        }

        $statistics = $this->statisticsProvider->getStatisticsForChannel($channel);
        $data = ['statistics' => $statistics, 'channel' => $channel];

        if ($this->salesDataProvider !== null) {
            $data['sales_summary'] = $this->salesDataProvider->getLastYearSalesSummary($channel);
            $data['currency'] = $channel->getBaseCurrency()->getCode();
        }

        $data['productsBelowStockTreshold'] = $this->productVariantStockAlertRepository->findAllEnabled();

        return $this->templatingEngine->renderResponse('@SyliusAdmin/Dashboard/index.html.twig', $data);
    }

    private function findChannelByCodeOrFindFirst(?string $channelCode): ?ChannelInterface
    {
        $channel = null;
        if (null !== $channelCode) {
            $channel = $this->channelRepository->findOneByCode($channelCode);
        }

        if (null === $channel) {
            $channels = $this->channelRepository->findAll();

            $channel = current($channels) === false ? null : current($channels);
        }

        return $channel;
    }
}

