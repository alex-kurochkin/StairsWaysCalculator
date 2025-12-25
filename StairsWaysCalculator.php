<?php
declare(strict_types=1);

/**
 * Class StairsWaysCalculator
 * Require PHP 8.2
 * In case you use PHP 8.1, remove "readonly" modifier
 */
readonly class StairsWaysCalculator
{
    /**
     * @param int $possibilities available step max size
     */
    public function __construct(private int $possibilities)
    {
        $possibilities > 0 || throw new \InvalidArgumentException(
            __CLASS__ . ': The constructor parameter must be greater than zero.'
        );
    }

    /**
     * @param int ...$stairsSet each param as number of stairs steps
     * @return int
     */
    public function calculateWaysTotal(int ...$stairsSet): int
    {
        if (!$stairsSet) {
            return 0;
        }

        $known = [];
        $ways = [];

        foreach ($stairsSet as $length) {
            if (!array_key_exists($length, $known)) {
                $known[$length] = $this->calculateWays($length);
            }

            $ways[] = $known[$length];
        }

        return array_product($ways);
    }

    /**
     * @param int $length length of stairs in steps
     * @param int $next
     * @param int $count
     * @return int
     */
    private function calculateWays(int $length, int $next = 0, int &$count = 0): int
    {
        if ($next < 0 || $next > $length) {
            return 0;
        }

        if ($next === $length) {
            $count++;
            return 0;
        }

        for ($i = 1; $i <= $this->possibilities; $i++) {
            $this->calculateWays($length, $next + $i, $count);
        }

        return $count;
    }
}

try {
    print (new StairsWaysCalculator(3))->calculateWaysTotal(5, 10, 10);
} catch (\Throwable $e) {
    print $e->getMessage();
}

print PHP_EOL;
