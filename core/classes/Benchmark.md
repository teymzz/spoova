# Benchmark

Measures how long pieces of code take, and prints the results as a table — a plain
text table on the terminal, and a styled HTML table on a web page.

```php
use spoova\mi\core\classes\Benchmark;
```

---

## Quick start

Give it a list of functions. The key is the name shown in the table, the value is
the code to time.

```php
Benchmark::fn([
    'str_replace' => fn() => str_replace('quick', 'slow', $text),
    'strtr'       => fn() => strtr($text, ['quick' => 'slow']),
]);
```

That runs each one once and prints the table. On the terminal:

```
--------------------------------------------------------------------
| Benchmark    |    Time |  Ops/s | Memory |   Rel |            |
--------------------------------------------------------------------
| str_replace  | 24.95µs | 40,076 | 13.1KB | x1.14 | ████████░░ |
| strtr        | 21.86µs | 45,736 | 12.8KB | x1.00 | ███████░░░ |
--------------------------------------------------------------------
```

---

## Running each test more than once

A single run is unreliable — the machine is busy doing other things. Run each test
many times and the average settles down.

```php
Benchmark::repeat(500);   // run every test 500 times, report the average
Benchmark::warmup();      // run each one once first, untimed, and throw it away
```

`warmup()` matters when the first call to something is slower than the rest —
loading a class, filling a cache, opening a connection. Without it, whichever test
runs first gets charged for work the others don't pay for.

With `repeat()` above 1, two extra columns appear: **Min** and **Max**, the fastest
and slowest single run. A large gap between them means the number is noisy.

A **Min of `0ns`** means the test finished quicker than the system clock can
measure. The average is still meaningful, because it is spread over every run — but
the individual figures are not. Raise `repeat()`, or give the test more work to do.

---

## Reading the table

| Column | Meaning |
|---|---|
| **Benchmark** | the name you gave the test |
| **Runs** | how many times it was executed |
| **Time** | average time per run, in the unit that fits (ns, µs, ms, s) |
| **Min** / **Max** | fastest and slowest single run |
| **Ops/s** | how many times it could run per second |
| **Memory** | memory the test used |
| **Rel** | how many times slower than the fastest test. The fastest is always `x1.00` |
| *(bar)* | the same thing, drawn — longest bar is the slowest test |
| **Base** | change since the recorded baseline (only when one exists) |

A test that throws an exception shows `-` in every column, with the error printed
underneath the table. It is left out of the comparison entirely, so a test that
crashes instantly is never reported as "the fastest".

### Sorting

By default rows appear in the order you declared them. To list them fastest first:

```php
Benchmark::sort();
```

---

## Comparing against a previous run

`baseline()` records a run to a file, then compares every later run against it.

```php
Benchmark::baseline(__DIR__.'/bench.json', 0.30);
```

The first time you run it, the file does not exist — so the current results are
written to it and no comparison is shown. Every run after that compares against
that file and adds a **Base** column:

```
|   Rel |            |     Base |
| x1.00 | ██████░░░░ |  -20.1% ▼ |    faster than before
| x1.07 | ███████░░░ |  +33.8% ▲ |    slower than before
```

The second argument is the **tolerance** — how far a test must move before it is
reported as changed at all. `0.30` means 30%.

> **Set this higher than you think.** Timings naturally wobble 20–50% between runs
> on a normal machine even when nothing changed. A tight tolerance like `0.05` will
> flag changes constantly and you will stop believing it. Start at `0.30`, and raise
> `repeat()` if you want to tighten it later.

To start a fresh baseline, delete the file.

---

## Saving the results

```php
Benchmark::export(__DIR__.'/results.json');   // format taken from the extension
Benchmark::export(__DIR__.'/results.csv');
Benchmark::export($path, 'csv');              // or state it explicitly
```

JSON keeps the full detail. CSV gives one row per test, for a spreadsheet.

---

## Getting the numbers instead of a table

Pass `false` as the second argument to `fn()` and nothing is printed — you get the
raw array back:

```php
$results = Benchmark::fn([...], false);
```

Or read them afterwards with `info()`:

```php
Benchmark::info();                  // every test
Benchmark::info('strtr');           // one test, or false if the name is unknown
Benchmark::info(['strtr', 'trim']); // several, keyed by name
```

Each test holds:

| Key | |
|---|---|
| `start` `stop` | when it began and ended |
| `diff` | average seconds per run — the main number |
| `time` | the same, formatted for reading (`"21.86µs"`) |
| `runs` `total` | how many runs, and their total time |
| `min` `max` | fastest and slowest run, in seconds |
| `ops` | runs per second |
| `memory` `peak` | memory used, and peak memory at that point |
| `error` | the exception message, or an empty string |

To print later, or to capture the output as a string:

```php
Benchmark::render();       // print it
$html = Benchmark::render(true);  // return it instead
```

---

## Starting over

Results build up across calls to `fn()`, so two calls produce one combined table.
To keep them separate, clear between them:

```php
Benchmark::fn([...]);   // first table
Benchmark::reset();
Benchmark::fn([...]);   // second table, on its own
```

---

## Method reference

| Method | |
|---|---|
| `fn(array $items, bool $output = true)` | run the tests. `$output = false` returns the array instead of printing |
| `info(string\|int\|array\|null $key = null)` | read the results — all, one, or a list |
| `repeat(int $times)` | how many times to run each test. Default `1` |
| `warmup(bool $enabled = true)` | run each test once, untimed, before measuring |
| `sort(bool $enabled = true)` | list results fastest first |
| `baseline(string $file, float $tolerance = 0.10)` | record or compare against a previous run |
| `export(string $file, string $format = '')` | write results as json or csv |
| `render(bool $return = false)` | print the table, or return it |
| `reset()` | clear all recorded results |

---

## Two things worth knowing

**Compare like with like.** The bar is drawn relative to the slowest test in the
table. Put a 15ms database call next to a 40µs string function and the database
call fills the bar while everything else collapses to one block — even where one is
three times faster than another. Keep one table to one question, and use `reset()`
between unrelated groups. The **Rel** column stays exact whatever the spread.

**Anything callable works**, not just arrow functions:

```php
Benchmark::fn([
    'builtin' => memory_get_usage(...),
    'method'  => [$object, 'method'],
    'closure' => function(){ /* ... */ },
]);
```

Tests are called **with no arguments**. So anything that needs arguments has to be
wrapped, otherwise it will throw:

```php
'strlen' => strlen(...),                  // ✘ ArgumentCountError
'strlen' => fn() => strlen($text),        // ✔
```

A test that throws is caught and reported — one broken test will not stop the rest
from running.
