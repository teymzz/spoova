<?php

namespace spoova\mi\core\classes\Sensor\ProcessHandler;

use spoova\mi\core\classes\Sensor\ProcessHandler\ProcessHandler;

/**
 * Fallback process handler for operating systems without a dedicated
 * implementation. Every operation is a safe no-op returning empty data, so the
 * process-metrics pipeline degrades gracefully instead of throwing.
 */
class NullProcessHandler extends ProcessHandler {

    public function getProcesses(?string $sortBy = null, string $order = 'desc'): array {
        return [];
    }

    public function getAppsGrouped(): array {
        return [];
    }

    public function getHighMemoryApps(?int $minKb = null, ?int $top = null, string $sortBy = 'memory', string $order = 'desc', bool $userApps = false): array {
        return [];
    }

    /** Memory trimming is not supported on this OS. */
    public function trimMemoryByPID(int $pid): array {
        return ['ok' => false, 'error_code' => -1, 'error_message' => $this->unsupported()];
    }

    /** Memory trimming is not supported on this OS. */
    public function trimMemoryByName(string $processName): array {
        return [];
    }

    public function getError(): ?array {
        return ['error' => $this->unsupported()];
    }

    private function unsupported(): string {
        return 'Process handling is not supported on this OS ('.PHP_OS_FAMILY.').';
    }
}
