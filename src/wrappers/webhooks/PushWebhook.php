<?php

namespace Webhooker\wrappers\webhooks;

use Webhooker\wrappers\Push;
use Webhooker\wrappers\User;
use Webhooker\wrappers\Repository;

/**
 * Wrapper for bitbucket push webhook data.
 *
 * @property-read User          $actor
 * @property-read Repository    $repository
 * @property-read Push          $push
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface PushWebhook {}