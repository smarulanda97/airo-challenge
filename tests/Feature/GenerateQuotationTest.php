<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures\ValidQuotationFixture;
use Tests\TestCase;

class GenerateQuotationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array valid quotation fixture to use in the texts
     */
    private array $quotationFixture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->quotationFixture = ValidQuotationFixture::new();
    }

    #[Test]
    public function quotation_cannot_be_generated_without_authentication(): void
    {
        $this
            ->json('POST', route('api.v1.quotation.store'), [])
            ->assertUnauthorized();
    }

    #[Test]
    #[DataProvider('invalidQuotationPayloadProvider')]
    public function quotation_returns_validation_error_when_data_is_missing(string $attribute, mixed $value): void
    {
        $user = User::factory()->create();
        $payload = $this->quotationFixture;

        Arr::set($payload, $attribute, $value);

        $this
            ->actingAs($user)
            ->json('POST', route('api.v1.quotation.store'), $payload)
            ->assertUnprocessable()
            // To ensure the error message brings good information about the error
            ->assertSeeText(Str::replace('_', ' ', $attribute));
    }

    #[Test]
    public function quotation_happy_path_returns_successful_response(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->json('POST', route('api.v1.quotation.store'), $this->quotationFixture)
            ->assertSuccessful()
            ->assertJsonStructure([
                'total',
                'currency_id',
                'quotation_id',
            ]);
    }

    public static function invalidQuotationPayloadProvider(): array
    {
        return [
            ['age', null],
            ['currency_id', null],
            ['start_date', null],
            ['end_date', null],
            ['age', '-28'],
            ['currency_id', 'AAA'],
            ['start_date', '0000-00-00'],
            ['end_date', '0000-00-00'],
        ];
    }
}
