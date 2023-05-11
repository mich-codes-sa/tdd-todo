<?php

namespace Tests\Feature;

use App\Models\Habit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HabitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_that_the_habits_view_can_be_rendered(): void
    {
        // Arrange
        $habits = Habit::factory(3)->create();

        // Act
        $response = $this->withoutExceptionHandling()->get('/habits');

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('habits', $habits);
    }
}
