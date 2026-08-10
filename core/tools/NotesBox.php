<?php

namespace spoova\mi\core\tools;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class NotesBox extends Filemanager
{
    protected array $lines = [];

    public function __construct(protected string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File does not exist: $filePath");
        }

        $this->lines = file($filePath, FILE_IGNORE_NEW_LINES);
    }

    // --- Core Methods ---

    public function getContent(): string
    {
        return implode("\n", $this->lines);
    }

    public function setContent(string $markdown): void
    {
        $this->lines = explode("\n", $markdown);
    }

    public function save(?string $toPath = null): void
    {
        file_put_contents($toPath ?? $this->filePath, implode("\n", $this->lines));
    }

    public function append(string $markdown): void
    {
        $this->lines[] = $markdown;
    }

    public function prepend(string $markdown): void
    {
        array_unshift($this->lines, $markdown);
    }

    // --- Section Manipulation ---

    public function replaceSection(string $heading, string $newContent): void
    {
        $start = $this->findHeadingIndex($heading);
        if ($start === -1) return;

        $end = $this->findNextHeadingIndex($start + 1);
        $newLines = array_merge([$this->lines[$start]], explode("\n", $newContent));

        array_splice($this->lines, $start, ($end - $start), $newLines);
    }

    public function removeSection(string $heading): void
    {
        $start = $this->findHeadingIndex($heading);
        if ($start === -1) return;

        $end = $this->findNextHeadingIndex($start + 1);
        array_splice($this->lines, $start, $end - $start);
    }

    public function insertAfterHeading(string $heading, string $content): void
    {
        $index = $this->findHeadingIndex($heading);
        if ($index !== -1) {
            array_splice($this->lines, $index + 1, 0, $content);
        }
    }

    public function insertBeforeHeading(string $heading, string $content): void
    {
        $index = $this->findHeadingIndex($heading);
        if ($index !== -1) {
            array_splice($this->lines, $index, 0, $content);
        }
    }

    public function updateHeading(string $oldHeading, string $newHeading): void
    {
        foreach ($this->lines as &$line) {
            if (trim($line) === $oldHeading) {
                $line = $newHeading;
            }
        }
    }

    public function replaceLine(string $search, string $replace): void
    {
        foreach ($this->lines as &$line) {
            if (str_contains($line, $search)) {
                $line = str_replace($search, $replace, $line);
            }
        }
    }

    // --- Checklists ---

    public function addChecklistItem(string $label, bool $checked = false, ?string $underHeading = null): void
    {
        $line = '- [' . ($checked ? 'x' : ' ') . '] ' . $label;

        if ($underHeading) {
            $index = $this->findHeadingIndex($underHeading);
            if ($index !== -1) {
                $insertAt = $index + 1;
                while ($insertAt < count($this->lines) && !preg_match('/^#{1,6} /', trim($this->lines[$insertAt]))) {
                    $insertAt++;
                }
                array_splice($this->lines, $insertAt, 0, $line);
                return;
            }
        }

        $this->append($line);
    }

    public function updateChecklistItem(string $label, bool $checked): void
    {
        foreach ($this->lines as &$line) {
            if (preg_match('/^- \[( |x)\] (.+)$/i', $line, $matches) && trim($matches[2]) === $label) {
                $line = '- [' . ($checked ? 'x' : ' ') . '] ' . $label;
            }
        }
    }

    public function toggleChecklistItem(string $label): void
    {
        foreach ($this->lines as &$line) {
            if (preg_match('/^- \[( |x)\] (.+)$/i', $line, $matches) && trim($matches[2]) === $label) {
                $line = '- [' . (strtolower($matches[1]) === 'x' ? ' ' : 'x') . '] ' . $label;
            }
        }
    }

    public function getChecklistItems(?string $underHeading = null): array
    {
        $items = [];
        $start = 0;
        $end = count($this->lines);

        if ($underHeading) {
            $start = $this->findHeadingIndex($underHeading);
            if ($start === -1) return [];
            $start++;
            $end = $this->findNextHeadingIndex($start);
        }

        for ($i = $start; $i < $end; $i++) {
            if (preg_match('/^- \[( |x)\] (.+)$/i', $this->lines[$i], $matches)) {
                $items[] = [
                    'label' => $matches[2],
                    'checked' => strtolower(trim($matches[1])) === 'x',
                    'line' => $i,
                ];
            }
        }

        return $items;
    }

    // --- Tables ---

    public function replaceTable(string $heading, array $headers, array $rows): void
    {
        $table = $this->buildMarkdownTable($headers, $rows);
        $this->replaceSection($heading, $table);
    }

    public function getTable(string $underHeading): ?array
    {
        $start = $this->findHeadingIndex($underHeading);
        if ($start === -1) return null;

        $start++;
        while ($start < count($this->lines) && trim($this->lines[$start]) === '') {
            $start++;
        }

        if (!isset($this->lines[$start]) || !preg_match('/^\|(.+)\|$/', $this->lines[$start])) return null;

        $headers = array_map('trim', explode('|', trim($this->lines[$start], '|')));
        $rows = [];

        for ($i = $start + 2; $i < count($this->lines); $i++) {
            if (!preg_match('/^\|(.+)\|$/', $this->lines[$i])) break;
            $row = array_map('trim', explode('|', trim($this->lines[$i], '|')));
            $rows[] = $row;
        }

        return [
            'headers' => $headers,
            'rows' => $rows,
        ];
    }

    public function updateTableCell(string $heading, int $rowIndex, string $columnName, string $newValue): void
    {
        $start = $this->findHeadingIndex($heading);
        if ($start === -1) return;

        $tableStart = $start + 1;
        while ($tableStart < count($this->lines) && !preg_match('/^\|(.+)\|$/', $this->lines[$tableStart])) {
            $tableStart++;
        }

        if (!isset($this->lines[$tableStart])) return;

        $headers = array_map('trim', explode('|', trim($this->lines[$tableStart], '|')));
        $colIndex = array_search($columnName, $headers);
        if ($colIndex === false) return;

        $rowLineIndex = $tableStart + 2 + $rowIndex;
        if (!isset($this->lines[$rowLineIndex])) return;

        $row = array_map('trim', explode('|', trim($this->lines[$rowLineIndex], '|')));
        if (!isset($row[$colIndex])) return;

        $row[$colIndex] = $newValue;
        $this->lines[$rowLineIndex] = '| ' . implode(' | ', $row) . ' |';
    }

    protected function buildMarkdownTable(array $headers, array $rows): string
    {
        $line1 = '| ' . implode(' | ', $headers) . ' |';
        $line2 = '| ' . implode(' | ', array_fill(0, count($headers), '---')) . ' |';
        $lineRows = array_map(fn($row) => '| ' . implode(' | ', $row) . ' |', $rows);
        return implode("\n", array_merge([$line1, $line2], $lineRows));
    }

    // --- Internal Helpers ---

    protected function findHeadingIndex(string $heading): int
    {
        foreach ($this->lines as $i => $line) {
            if (trim($line) === trim($heading)) {
                return $i;
            }
        }
        return -1;
    }

    protected function findNextHeadingIndex(int $start): int
    {
        for ($i = $start; $i < count($this->lines); $i++) {
            if (preg_match('/^#{1,6} /', trim($this->lines[$i]))) {
                return $i;
            }
        }
        return count($this->lines);
    }
}
