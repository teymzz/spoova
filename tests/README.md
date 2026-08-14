# Tests

Unit tests for the Spoova framework, run with [PHPUnit 9.5+](https://phpunit.de/)
(already a dev dependency).

## Running

```bash
# all tests
php vendor/bin/phpunit

# a single suite / file / filter
php vendor/bin/phpunit tests/Unit/Routing
php vendor/bin/phpunit tests/Unit/Routing/RouterRelateTest.php
php vendor/bin/phpunit --filter test_map_returns_decoded_array
```

Configuration lives in [`phpunit.xml`](../phpunit.xml); the `Unit` suite maps to
`tests/Unit`.

## Bootstrap

[`bootstrap.php`](bootstrap.php) does the **minimum** wiring to test classes in
isolation — it loads the Composer autoloader, defines the core path constants
(`docroot`, `DS`, `WIN_ROUTES`), pulls in the global helper functions, and
`chdir()`s to the project root (so `Router::map()` can find `windows/Routes/.map`).

It intentionally does **not** boot the full framework (no session, DB, request
or output). If a test needs more, add narrowly-scoped setup to the bootstrap
rather than including the application entry point.

## Layout

```
tests/
├── bootstrap.php
└── Unit/
    ├── Routing/
    │   ├── RouterExtensionTest.php   # stripRexExtension() + rtrim-bug regression
    │   ├── RouterRelateTest.php      # relate(): map wildcard / prefix / override rules
    │   └── RouterMapTest.php         # map(): decoding, and maps that cannot be read
    ├── Classes/
    │   ├── ActivityTest.php          # activity log naming / writing
    │   ├── BenchmarkTest.php         # timing, the results table, baselines, export
    │   ├── CollectionTest.php        # Collection + Record: iteration, columns, protection
    │   ├── HasherTest.php            # credential signing, hash chain, random keys
    │   ├── JsonfyTest.php            # array/JSON editor: add, update, delete, read
    │   ├── LqipTest.php              # blur-up placeholder generation and caching
    │   └── TimeTest.php              # secondsTo() scales and rounding, "time ago"
    ├── Cli/
    │   └── CliArgsTest.php           # declarative CLI argument parser
    └── Commands/
        └── SanitizeAuditTest.php     # project sanitize: PSR-4 casing + credential rules
```

Test classes are namespaced under `spoova\mi\tests\...` to match the project's
PSR-4 autoload root (`spoova\mi\` → `./`).

## What's covered so far

The focus is the **pure / low-coupling** classes — the ones that can be exercised
without a request, a session or a database.

Routing ([`core/classes/Router.php`](../core/classes/Router.php)):

- `Router::stripRexExtension()` — exact-suffix stripping, with regression cases
  for the former `rtrim($path, '.php')` character-set bug (e.g. `/help` → `/hel`).
- `Router::relate()` — resolving a url against a `.map` entry.
- `Router::map()` — decoding the route map, and the missing / corrupt / scalar
  map cases that all have to flatten to an empty array.

Classes:

- `Hasher` — reproducibility of a signed digest, the effect of the key and of each
  credential, the advancing hash chain and its rewind, salting algorithms, and
  standalone random keys.
- `Jsonfy` — loading from JSON or an array, `add()` (which does not overwrite) vs
  `update()` (which does not create), nested edits, deletion, and the round trip.
- `Collection` / `Record` — row wrapping, repeat iteration, column reads, and the
  `**protected**` masking that keeps a column out of a response.
- `Time` — `secondsTo()` scales, spelling equivalence, rounding modes and the
  values that report `FALSE`; `distanceFrom()` "time ago" rendering.
- `Lqip` — placeholder generation (scaling, aspect ratio, alpha), the inline size
  budget, unreadable sources degrading to no placeholder, and mtime-keyed caching.
- `Benchmark` — timing accuracy, the results table, baselines and export.
- `Activity` — activity log naming and writing.

CLI:

- `CliArgs` ([core/commands/Root/Cli/CliArgs.php](../core/commands/Root/Cli/CliArgs.php)) — a
  declarative argument parser (positionals, flags, value-options, strict
  unknown-directive rejection) intended to replace hand-rolled `$args[n]` parsing in commands.
- `SanitizeAudit` ([core/commands/Support/Handlers/SanitizeAudit.php](../core/commands/Support/Handlers/SanitizeAudit.php)) —
  the rules behind `php mi project sanitize`: tokenizer-based class discovery, PSR-4
  path resolution, which naming faults count as findings (and which co-located
  declarations deliberately do not), and offline-credential detection. These rules
  cannot be verified by running the command on Windows — `is_file()` there is
  case-insensitive — so they are asserted against synthetic trees instead.

## Regressions these tests pin down

Bugs found while writing the suite, now fixed and covered:

- `Collection::get()` — the return type omitted `Record`, so fetching a whole row
  (the documented default) raised a `TypeError` on the way out.
- `Jsonfy::delete()` — deleting a sub-key of a key holding a scalar reached
  `unset()` on a non-array and fatalled, where an unknown key is a no-op.
- `Time::setTime()` — stored neither of the times it was given, so `difference()`
  compared NULL against NULL and every reading was `FALSE`.
- `Time::textFrom()` — returned the count rather than the singular noun, so one
  unit printed its number twice ("1 1 ago"). The years branch of `time_ago()`
  also never said "ago", and `time_diff()` pluralized every unit against the year
  while naming minutes and seconds "hour".
- `Record::__get()` — returned the same thing from both sides of its own guard, so
  an unknown column raised an undefined-key warning on its way to NULL. It now
  reports `FALSE`, matching `data()`, and a new `__isset()` makes `isset()` and
  `??` answer for the column rather than for the undeclared property.
- `Record::protect()` — pushed the column list in as a nested array, so nothing
  could ever match against it. The masked names are now readable via `protected()`.
- `Hasher` — signing without a hash key reached `md5(NULL)`, deprecated since
  PHP 8.1. No digest moved: NULL was being coerced to `''` there already.

## Not yet covered (candidates for a future pass)

Higher-coupling routing behaviour that needs a dispatch harness (faked
`$_SERVER`, request path and view files):

- Dynamic slug/param matching (`{param}`) and case-sensitivity / `!` inverse and `STRICT` modes.
- Middleware ordering (`ONCALL`, `INCALL`, `ONLOAD`) and shutdown hooks (`ONSHUT`).
- Route trunking / grouping and `ORIGIN` prefixing.
- `get()`/`post()` registration and duplicate-route detection (needs a `Request`/`Response`).

Other leaf classes that would take unit tests cheaply: `Url` (path segment
helpers), `Attribs`, `Enlist`, and the `DB/DBSchema/*` builders, which produce SQL
strings and need no connection.
