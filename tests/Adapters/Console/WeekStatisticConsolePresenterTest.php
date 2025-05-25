<?php

namespace Bierrysept\TurboSchedule\Tests\Adapters\Console;

use Bierrysept\TurboSchedule\Adapters\Console\WeekStatisticConsolePresenter;
use PHPUnit\Framework\TestCase;

class WeekStatisticConsolePresenterTest extends TestCase
{
    public function testDefaultOutput ()
    {
        $input = [
            '19.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '20.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '21.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '22.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '23.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '24.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '25.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
        ];
        $output = <<<EOL
+---------------+----------+----------+----------+----------+----------+----------+----------+
|               |19.05.2025|20.05.2025|21.05.2025|22.05.2025|23.05.2025|24.05.2025|25.05.2025|
+---------------+----------+----------+----------+----------+----------+----------+----------+
|Procrastination| 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 |
+---------------+----------+----------+----------+----------+----------+----------+----------+
EOL;
        $presenter = new WeekStatisticConsolePresenter();
        $this->assertEquals($output, $presenter->presents($input));
    }
    public function testDefaultOutputWithOneTrack ()
    {
        $input = [
            '19.05.2025' => [
                'Sleep & rest' => '09:00:00',
                'Procrastination' => '15:00:00',
            ],
            '20.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '21.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '22.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '23.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '24.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
            '25.05.2025' => [
                'Procrastination' => '24:00:00',
            ],
        ];
        $output = <<<EOL
+---------------+----------+----------+----------+----------+----------+----------+----------+
|               |19.05.2025|20.05.2025|21.05.2025|22.05.2025|23.05.2025|24.05.2025|25.05.2025|
+---------------+----------+----------+----------+----------+----------+----------+----------+
|Sleep & rest   | 09:00:00 | --:--:-- | --:--:-- | --:--:-- | --:--:-- | --:--:-- | --:--:-- |
+---------------+----------+----------+----------+----------+----------+----------+----------+
|Procrastination| 15:00:00 | 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 | 24:00:00 |
+---------------+----------+----------+----------+----------+----------+----------+----------+
EOL;
        $presenter = new WeekStatisticConsolePresenter();
        $this->assertEquals($output, $presenter->presents($input));
    }
}