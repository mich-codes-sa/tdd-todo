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
    public function test_habits_view_can_be_rendered(): void
    {
        // Arrange
        $habits = Habit::factory(3)->create();

        // Act
        $response = $this->withoutExceptionHandling()->get('/habits');

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('habits', $habits);
    }

    public function test_habits_can_be_created(): void
    {
        // Arrange
        $habit = Habit::factory()->make();

        // Act
        $response = $this->withoutExceptionHandling()->post('/habits', $habit->toArray());

        // Assert
        $response->assertRedirect('/habits');
        $this->assertDatabaseHas('habits', $habit->toArray());
    }

    public function test_habits_can_be_updated(): void
    {
        // Arrange
        $habit = Habit::factory()->create();
        $updatedHabit = [
            'name' => 'update test',
            'times_per_day' => 5
        ];

        // Act
        $response = $this->withoutExceptionHandling()->put("/habits/{$habit->id}", $updatedHabit);

        // Assert
        $response->assertRedirect('/habits');
        $this->assertDatabaseHas('habits', ['id' => $habit->id, ...$updatedHabit]);
    }

    /**
     * @dataProvider provideBadHabitData
     */

    public function test_create_habits_validation($missing, $habit): void
    {
        $response = $this->post('/habits', $habit);
        $response->assertSessionHasErrors([$missing]);
    }

    /**
     * @dataProvider provideBadHabitData
     */

    public function test_update_habits_validation($missing, $updatedHabit)
    {
        $habitId = Habit::factory()->create()->id;

        $response = $this->put("/habits/{$habitId}", $updatedHabit);
        $response->assertSessionHasErrors([$missing]);
    }

    public function test_habits_can_be_deleted()
    {
        // Arrange
        $habitId = Habit::factory()->create()->id;

        // Act
        $response = $this->withoutExceptionHandling()->delete("/habits/{$habitId}");

        // Assert
        $response->assertRedirect('/habits');
        $this->assertDatabaseMissing('habits', ['id' => $habitId]);
    }

    public function provideBadHabitData()
    {
        $habit = Habit::factory()->make();
        return [
            'missing name' => [
                'name', [
                    ...$habit->toArray(),
                    'name' => null,
                ]
            ],
            'invalid name' => [
                'name', [
                    ...$habit->toArray(),
                    'name' => true,
                ]
            ],
            'missing times_per_day' => [
                'times_per_day', [
                    ...$habit->toArray(),
                    'times_per_day' => null
                ]
            ],
            'invalid times_per_day' => [
                'times_per_day', [
                    ...$habit->toArray(),
                    'times_per_day' => "invalid - should be an integer"
                ]
            ],
        ];
    }
}
