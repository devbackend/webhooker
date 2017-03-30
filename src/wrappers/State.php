<?php

namespace Webhooker\wrappers;

/**
 * @property-read string    $type
 * @property-read string    $name
 * @property-read LinkList  $links
 * @property-read Commit    $target
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface State {
	const TYPE_BRANCH   = 'branch';
	const TYPE_TAG      = 'tag';
}