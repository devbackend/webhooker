<?php

namespace Webhooker\wrappers;

/**
 * @property-read Commit[]  $commits
 * @property-read LinkList  $links
 * @property-read State     $new
 * @property-read State     $old
 * @property-read bool      $forced
 * @property-read bool      $created
 * @property-read bool      $truncated
 * @property-read bool      $closed
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
interface Change {}