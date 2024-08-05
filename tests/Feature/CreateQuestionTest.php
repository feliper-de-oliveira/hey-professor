<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to create a new question than 255 characters', function () {

    //Arrage :: preparar

    $user = User::factory()->create();

    actingAs($user);

    //Act :: agir

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260).'?',
    ]);

    //Assert :: verificar

    $request->assertRedirect(route('dashboard'));
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260).'?']);

});

it('should check if ends with questio mark?', function () {});

it('should have at least 10 characters', function () {

    //Arrage :: preparar

    $user = User::factory()->create();
    actingAs($user);

    //Act :: agir

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8).'?',
    ]);

    //Assert :: verificar

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);

});
