<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Add the token to the request to allow call protected endpoint
     *
     * @return $this
     */
    public function withBearerToken(): self {
        $user = User::factory()->create();
        $this->withToken($user->createToken('Test Token')->plainTextToken);
        return $this;
    }
}
