<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Services\MediaSyncService;
use Mockery\MockInterface;

class SettingTest extends TestCase
{
    /** @var MockInterface */
    private $mediaSyncService;

    public function setUp(): void
    {
        parent::setUp();
        $this->mediaSyncService = static::mockIocDependency(MediaSyncService::class);
    }

    public function testSaveSettings(): void
    {
        $this->mediaSyncService->shouldReceive('sync')->once();

        $user = factory(User::class, 'admin')->create();
        file_put_contents('log', $this->postAsUser('/api/settings', ['media_path' => __DIR__], $user)
            ->response->content());

        self::assertEquals(__DIR__, Setting::get('media_path'));
    }
}
