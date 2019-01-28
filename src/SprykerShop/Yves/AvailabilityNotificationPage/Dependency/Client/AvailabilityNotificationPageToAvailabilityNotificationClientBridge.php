<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AvailabilityNotificationPage\Dependency\Client;

use Generated\Shared\Transfer\FindAvailabilitySubscriptionRequestTransfer;
use Generated\Shared\Transfer\FindAvailabilitySubscriptionResponseTransfer;
use Generated\Shared\Transfer\AvailabilitySubscriptionResponseTransfer;
use Generated\Shared\Transfer\AvailabilitySubscriptionTransfer;

class AvailabilityNotificationPageToAvailabilityNotificationClientBridge implements AvailabilityNotificationPageToAvailabilityNotificationClientInterface
{
    /**
     * @var \Spryker\Client\AvailabilityNotification\AvailabilityNotificationClientInterface
     */
    protected $availabilityNotificationClient;

    /**
     * @param \Spryker\Client\AvailabilityNotification\AvailabilityNotificationClientInterface $availabilityNotificationClient
     */
    public function __construct($availabilityNotificationClient)
    {
        $this->availabilityNotificationClient = $availabilityNotificationClient;
    }

    /**
     * @param \Generated\Shared\Transfer\AvailabilitySubscriptionTransfer $availabilityNotificationSubscriptionRequest
     *
     * @return \Generated\Shared\Transfer\AvailabilitySubscriptionResponseTransfer
     */
    public function unsubscribe(AvailabilitySubscriptionTransfer $availabilityNotificationSubscriptionRequest): AvailabilitySubscriptionResponseTransfer
    {
        return $this->availabilityNotificationClient->unsubscribe($availabilityNotificationSubscriptionRequest);
    }

    /**
     * @param \Generated\Shared\Transfer\FindAvailabilitySubscriptionRequestTransfer $availabilitySubscriptionExistenceRequestTransfer
     *
     * @return \Generated\Shared\Transfer\FindAvailabilitySubscriptionResponseTransfer
     */
    public function findAvailabilitySubscription(FindAvailabilitySubscriptionRequestTransfer $availabilitySubscriptionExistenceRequestTransfer): FindAvailabilitySubscriptionResponseTransfer
    {
        return $this->availabilityNotificationClient->findAvailabilitySubscription($availabilitySubscriptionExistenceRequestTransfer);
    }
}
