<?php

namespace Webhooker\wrappers;

/**
 * Wrapper for repository data.
 *
 * @property string     $uuid
 * @property string     $scm
 * @property string     $website
 * @property string     $name
 * @property string     $full_name
 * @property string     $type
 * @property bool       $is_private
 * @property User       $owner
 * @property LinkList   $links
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface Repository {}