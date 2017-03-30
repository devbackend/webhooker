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

		//$webhook = @file_get_contents('php://input');
		$webhook = '{
  "push": {
    "changes": [
      {
        "forced": false,
        "old": {
          "type": "branch",
          "target": {
            "hash": "2de3c732c50612d21a0b753195cb094f93aa3fae",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/2de3c732c50612d21a0b753195cb094f93aa3fae"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/2de3c732c50612d21a0b753195cb094f93aa3fae"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "a4319c2dbab529cb842b1d7ba9cdebf9ac989648",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/a4319c2dbab529cb842b1d7ba9cdebf9ac989648"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/a4319c2dbab529cb842b1d7ba9cdebf9ac989648"
                  }
                }
              }
            ],
            "date": "2017-03-18T12:43:16+00:00",
            "message": "+ доработана мобильная версия\n+ доработаны стили для кнопки авторизации\n",
            "type": "commit"
          },
          "links": {
            "commits": {
              "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commits/staging"
            },
            "self": {
              "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/refs/branches/staging"
            },
            "html": {
              "href": "https://bitbucket.org/ivan-krivonos/authorisator/branch/staging"
            }
          },
          "name": "staging"
        },
        "links": {
          "commits": {
            "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commits?include=9023b4d9da51e6d4b6355a8f483e1e503ece27f0&exclude=2de3c732c50612d21a0b753195cb094f93aa3fae"
          },
          "html": {
            "href": "https://bitbucket.org/ivan-krivonos/authorisator/branches/compare/9023b4d9da51e6d4b6355a8f483e1e503ece27f0..2de3c732c50612d21a0b753195cb094f93aa3fae"
          },
          "diff": {
            "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/diff/9023b4d9da51e6d4b6355a8f483e1e503ece27f0..2de3c732c50612d21a0b753195cb094f93aa3fae"
          }
        },
        "created": false,
        "commits": [
          {
            "hash": "9023b4d9da51e6d4b6355a8f483e1e503ece27f0",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/9023b4d9da51e6d4b6355a8f483e1e503ece27f0"
              },
              "comments": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/9023b4d9da51e6d4b6355a8f483e1e503ece27f0/comments"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/9023b4d9da51e6d4b6355a8f483e1e503ece27f0"
              },
              "diff": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/diff/9023b4d9da51e6d4b6355a8f483e1e503ece27f0"
              },
              "approve": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/9023b4d9da51e6d4b6355a8f483e1e503ece27f0/approve"
              },
              "statuses": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/9023b4d9da51e6d4b6355a8f483e1e503ece27f0/statuses"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "2de3c732c50612d21a0b753195cb094f93aa3fae",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/2de3c732c50612d21a0b753195cb094f93aa3fae"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/2de3c732c50612d21a0b753195cb094f93aa3fae"
                  }
                }
              },
              {
                "hash": "5566e0b4538f9dde266ef48911ceda327679b3c3",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/5566e0b4538f9dde266ef48911ceda327679b3c3"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/5566e0b4538f9dde266ef48911ceda327679b3c3"
                  }
                }
              }
            ],
            "date": "2017-03-19T03:48:16+00:00",
            "message": "Merged in hotfix (pull request #23)\n\nДобавлен счётчик Яндекс.Метрики\n",
            "type": "commit"
          },
          {
            "hash": "5566e0b4538f9dde266ef48911ceda327679b3c3",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/5566e0b4538f9dde266ef48911ceda327679b3c3"
              },
              "comments": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/5566e0b4538f9dde266ef48911ceda327679b3c3/comments"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/5566e0b4538f9dde266ef48911ceda327679b3c3"
              },
              "diff": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/diff/5566e0b4538f9dde266ef48911ceda327679b3c3"
              },
              "approve": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/5566e0b4538f9dde266ef48911ceda327679b3c3/approve"
              },
              "statuses": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/5566e0b4538f9dde266ef48911ceda327679b3c3/statuses"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "41675eb8ffa79a0c0df2ae4391b52e5da79b290c",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/41675eb8ffa79a0c0df2ae4391b52e5da79b290c"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/41675eb8ffa79a0c0df2ae4391b52e5da79b290c"
                  }
                }
              },
              {
                "hash": "8e0a5c17414c1e88ba105d1cce9b0913ae12490e",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/8e0a5c17414c1e88ba105d1cce9b0913ae12490e"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/8e0a5c17414c1e88ba105d1cce9b0913ae12490e"
                  }
                }
              }
            ],
            "date": "2017-03-19T03:47:32+00:00",
            "message": "Merge branch \'hotfix\' of bitbucket.org:ivan-krivonos/authorisator into hotfix\n",
            "type": "commit"
          },
          {
            "hash": "41675eb8ffa79a0c0df2ae4391b52e5da79b290c",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/41675eb8ffa79a0c0df2ae4391b52e5da79b290c"
              },
              "comments": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/41675eb8ffa79a0c0df2ae4391b52e5da79b290c/comments"
              },
              "patch": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/patch/41675eb8ffa79a0c0df2ae4391b52e5da79b290c"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/41675eb8ffa79a0c0df2ae4391b52e5da79b290c"
              },
              "diff": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/diff/41675eb8ffa79a0c0df2ae4391b52e5da79b290c"
              },
              "approve": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/41675eb8ffa79a0c0df2ae4391b52e5da79b290c/approve"
              },
              "statuses": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/41675eb8ffa79a0c0df2ae4391b52e5da79b290c/statuses"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "4002ff69ead6b429cc6149bbb7d3340b7870a948",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/4002ff69ead6b429cc6149bbb7d3340b7870a948"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/4002ff69ead6b429cc6149bbb7d3340b7870a948"
                  }
                }
              }
            ],
            "date": "2017-03-19T03:47:22+00:00",
            "message": "Добавлен счётчик Яндекс.Метрики\n",
            "type": "commit"
          },
          {
            "hash": "8e0a5c17414c1e88ba105d1cce9b0913ae12490e",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/8e0a5c17414c1e88ba105d1cce9b0913ae12490e"
              },
              "comments": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/8e0a5c17414c1e88ba105d1cce9b0913ae12490e/comments"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/8e0a5c17414c1e88ba105d1cce9b0913ae12490e"
              },
              "diff": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/diff/8e0a5c17414c1e88ba105d1cce9b0913ae12490e"
              },
              "approve": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/8e0a5c17414c1e88ba105d1cce9b0913ae12490e/approve"
              },
              "statuses": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/8e0a5c17414c1e88ba105d1cce9b0913ae12490e/statuses"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "4002ff69ead6b429cc6149bbb7d3340b7870a948",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/4002ff69ead6b429cc6149bbb7d3340b7870a948"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/4002ff69ead6b429cc6149bbb7d3340b7870a948"
                  }
                }
              },
              {
                "hash": "b898075b5e0407033b59f242d5ea5ec6b37b3a9f",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/b898075b5e0407033b59f242d5ea5ec6b37b3a9f"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/b898075b5e0407033b59f242d5ea5ec6b37b3a9f"
                  }
                }
              }
            ],
            "date": "2017-03-19T03:29:13+00:00",
            "message": "Merged in master (pull request #21)\n\nMaster\n\nApproved-by: Ivan Krivonos <devbackend@yandex.ru>\n",
            "type": "commit"
          },
          {
            "hash": "b898075b5e0407033b59f242d5ea5ec6b37b3a9f",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/b898075b5e0407033b59f242d5ea5ec6b37b3a9f"
              },
              "comments": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/b898075b5e0407033b59f242d5ea5ec6b37b3a9f/comments"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/b898075b5e0407033b59f242d5ea5ec6b37b3a9f"
              },
              "diff": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/diff/b898075b5e0407033b59f242d5ea5ec6b37b3a9f"
              },
              "approve": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/b898075b5e0407033b59f242d5ea5ec6b37b3a9f/approve"
              },
              "statuses": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/b898075b5e0407033b59f242d5ea5ec6b37b3a9f/statuses"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "a9cdf42049fd2680cda0a3d869d7d16d33c8beb1",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/a9cdf42049fd2680cda0a3d869d7d16d33c8beb1"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/a9cdf42049fd2680cda0a3d869d7d16d33c8beb1"
                  }
                }
              },
              {
                "hash": "2de3c732c50612d21a0b753195cb094f93aa3fae",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/2de3c732c50612d21a0b753195cb094f93aa3fae"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/2de3c732c50612d21a0b753195cb094f93aa3fae"
                  }
                }
              }
            ],
            "date": "2017-03-19T03:24:33+00:00",
            "message": "Merged in staging (pull request #20)\n\nStaging\n\nApproved-by: Ivan Krivonos <devbackend@yandex.ru>\n",
            "type": "commit"
          }
        ],
        "truncated": true,
        "closed": false,
        "new": {
          "type": "branch",
          "target": {
            "hash": "9023b4d9da51e6d4b6355a8f483e1e503ece27f0",
            "links": {
              "self": {
                "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/9023b4d9da51e6d4b6355a8f483e1e503ece27f0"
              },
              "html": {
                "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/9023b4d9da51e6d4b6355a8f483e1e503ece27f0"
              }
            },
            "author": {
              "raw": "Ivan Krivonos <devbackend@yandex.ru>",
              "user": {
                "username": "ivan-krivonos",
                "display_name": "Ivan Krivonos",
                "type": "user",
                "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/"
                  },
                  "avatar": {
                    "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
                  }
                }
              }
            },
            "parents": [
              {
                "hash": "2de3c732c50612d21a0b753195cb094f93aa3fae",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/2de3c732c50612d21a0b753195cb094f93aa3fae"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/2de3c732c50612d21a0b753195cb094f93aa3fae"
                  }
                }
              },
              {
                "hash": "5566e0b4538f9dde266ef48911ceda327679b3c3",
                "type": "commit",
                "links": {
                  "self": {
                    "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commit/5566e0b4538f9dde266ef48911ceda327679b3c3"
                  },
                  "html": {
                    "href": "https://bitbucket.org/ivan-krivonos/authorisator/commits/5566e0b4538f9dde266ef48911ceda327679b3c3"
                  }
                }
              }
            ],
            "date": "2017-03-19T03:48:16+00:00",
            "message": "Merged in hotfix (pull request #23)\n\nДобавлен счётчик Яндекс.Метрики\n",
            "type": "commit"
          },
          "links": {
            "commits": {
              "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/commits/staging"
            },
            "self": {
              "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator/refs/branches/staging"
            },
            "html": {
              "href": "https://bitbucket.org/ivan-krivonos/authorisator/branch/staging"
            }
          },
          "name": "staging"
        }
      }
    ]
  },
  "repository": {
    "website": "",
    "scm": "git",
    "name": "Authorisator",
    "links": {
      "self": {
        "href": "https://api.bitbucket.org/2.0/repositories/ivan-krivonos/authorisator"
      },
      "html": {
        "href": "https://bitbucket.org/ivan-krivonos/authorisator"
      },
      "avatar": {
        "href": "https://bitbucket.org/ivan-krivonos/authorisator/avatar/32/"
      }
    },
    "full_name": "ivan-krivonos/authorisator",
    "owner": {
      "username": "ivan-krivonos",
      "display_name": "Ivan Krivonos",
      "type": "user",
      "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
      "links": {
        "self": {
          "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
        },
        "html": {
          "href": "https://bitbucket.org/ivan-krivonos/"
        },
        "avatar": {
          "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
        }
      }
    },
    "type": "repository",
    "is_private": true,
    "uuid": "{23e711cf-df20-4bd0-830e-0634283b3e41}"
  },
  "actor": {
    "username": "ivan-krivonos",
    "display_name": "Ivan Krivonos",
    "type": "user",
    "uuid": "{2b785743-bdf6-4787-bae6-3b334a0f21ea}",
    "links": {
      "self": {
        "href": "https://api.bitbucket.org/2.0/users/ivan-krivonos"
      },
      "html": {
        "href": "https://bitbucket.org/ivan-krivonos/"
      },
      "avatar": {
        "href": "https://bitbucket.org/account/ivan-krivonos/avatar/32/"
      }
    }
  }
}';
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