<?php

namespace Webhooker;

use Webhooker\exceptions\EmptyWebhookBodyException;
use Webhooker\exceptions\InvalidWebhookException;
use Webhooker\exceptions\ReInitSingletonException;
use Webhooker\wrappers\webhooks\PushWebhook;

/**
 * Handler for bitbucket push webhook
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class PushWebhookHandler {
	/** @var self */
	private static $_instance;

	/** @var string Raw webhook body */
	protected $raw = '';

	/** @var PushWebhook Webhook object */
	protected $webhook;

	/**
	 * Init instance
	 *
	 * @throws ReInitSingletonException
	 * @throws EmptyWebhookBodyException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>\
	 */
	public static function init() {
		if (null !== static::$_instance) {
			throw new ReInitSingletonException();
		}

		$webhook = @file_get_contents('php://input');
		if ('' === $webhook) {
			throw new EmptyWebhookBodyException();
		}

		static::$_instance = new self($webhook);

		return static::$_instance;
	}

	/**
	 * @param string $webhook
	 *
	 * @throws InvalidWebhookException
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	private function __construct(string $webhook) {
		$this->raw = $webhook;

		$this->webhook = @json_decode($webhook);
		if (null === $this->webhook) {
			throw new InvalidWebhookException;
		}
	}

	/**
	 * Get raw webhook body.
	 *
	 * @return string
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getRaw(): string {
		return $this->raw;
	}

	/**
	 * Get webhook instance.
	 *
	 * @return PushWebhook
	 *
	 * @author Ivan Krivonos <devbackend@yandex.ru>
	 */
	public function getWebhook() {
		return $this->webhook;
	}
}