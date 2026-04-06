<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\SpacedRepetitionService;
use PHPUnit\Framework\Attributes\Test;

class SpacedRepetitionServiceTest extends TestCase
{
    private SpacedRepetitionService $srs;

    protected function setUp(): void
    {
        parent::setUp();
        $this->srs = new SpacedRepetitionService();
    }

    #[Test]
    public function it_resets_when_rating_is_again()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 10, repetitions: 5, rating: 'again');

        $this->assertEquals(0, $result['repetitions']);
        $this->assertEquals(1, $result['interval_days']);
        $this->assertEquals('learning', $result['status']);
    }

    #[Test]
    public function it_sets_interval_to_1_on_first_good_review()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 1, repetitions: 0, rating: 'good');

        $this->assertEquals(1, $result['repetitions']);
        $this->assertEquals(1, $result['interval_days']);
    }

    #[Test]
    public function it_sets_interval_to_6_on_second_good_review()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 1, repetitions: 1, rating: 'good');

        $this->assertEquals(2, $result['repetitions']);
        $this->assertEquals(6, $result['interval_days']);
    }

    #[Test]
    public function it_increases_interval_using_ease_factor_for_subsequent_reviews()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 6, repetitions: 2, rating: 'good');

        $this->assertEquals(3, $result['repetitions']);
        $this->assertEquals(15, $result['interval_days']);
    }

    #[Test]
    public function ease_factor_never_goes_below_1_3()
    {
        $result = $this->srs->calculate(easeFactor: 1.3, intervalDays: 1, repetitions: 1, rating: 'hard');

        $this->assertGreaterThanOrEqual(1.3, $result['ease_factor']);
    }

    #[Test]
    public function it_marks_word_as_mastered_after_long_interval()
    {
        $result = $this->srs->calculate(easeFactor: 2.5, intervalDays: 21, repetitions: 5, rating: 'easy');

        $this->assertEquals('mastered', $result['status']);
    }
}
