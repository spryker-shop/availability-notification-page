<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AvailabilityNotificationPage\Controller;

use Generated\Shared\Transfer\AvailabilitySubscriptionTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \SprykerShop\Yves\AvailabilityNotificationPage\AvailabilityNotificationPageFactory getFactory()
 */
class AvailabilityNotificationPageController extends AbstractController
{
    /**
     * @param string $subscriptionKey
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function unsubscribeByKeyAction(string $subscriptionKey)
    {
        $this->executeUnsubscribeByKeyAction($subscriptionKey);

        return $this->view([], [], '@AvailabilityNotificationPage/views/availability-notification/unsubscribe.twig');
    }

    /**
     * @param string $subscriptionKey
     *
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function executeUnsubscribeByKeyAction(string $subscriptionKey): void
    {
        $availabilitySubscriptionTransfer = (new AvailabilitySubscriptionTransfer())->setSubscriptionKey($subscriptionKey);

        $availabilitySubscriptionResponseTransfer = $this->getFactory()
            ->getAvailabilityNotificationClient()
            ->unsubscribe($availabilitySubscriptionTransfer);

        if ($availabilitySubscriptionResponseTransfer->getIsSuccess() === false) {
            throw new NotFoundHttpException($availabilitySubscriptionResponseTransfer->getErrorMessage());
        }

        $this->removeAvailabilitySubscriptionFromCustomer($availabilitySubscriptionResponseTransfer->getAvailabilitySubscription()->getSku());
    }

    /**
     * @param string $sku
     *
     * @return void
     */
    protected function removeAvailabilitySubscriptionFromCustomer(string $sku): void
    {
        $customerTransfer = $this->getFactory()->getCustomerClient()->getCustomer();
        $availabilitySubscriptions = $customerTransfer->getAvailabilitySubscriptions();

        foreach ($availabilitySubscriptions as $key => $availabilitySubscription) {
            if ($availabilitySubscription->getSku() === $sku) {
                unset($availabilitySubscriptions[$key]);

                break;
            }
        }

        $customerTransfer->setAvailabilitySubscriptions($availabilitySubscriptions);
    }
}
