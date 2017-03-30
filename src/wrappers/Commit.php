<?php

namespace Webhooker\wrappers;

/**
 * @property-read string   $hash
 * @property-read string   $date
 * @property-read string   $message
 * @property-read string   $type
 * @property-read Commit[] $parents
 * @property-read Author   $author
 * @property-read LinkList $links
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface Commit {}