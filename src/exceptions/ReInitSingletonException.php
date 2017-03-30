<?php

namespace Webhooker\exceptions;

use Exception;

/**
 * Exception for trying re-init singleton instance
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class ReInitSingletonException extends Exception {}