<?php

use Faker\Generator as Faker;

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return [
        'id'              => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type'            => 'App\Notifications\ThreadWasUpdated',
        'notifiable_type' => 'App\User',
        'notifiable_id'   => function () {
            return auth()->id() ?: factory(\App\User::class)->create()->id;
        },
        'data'            => ['foo' => 'bar']
    ];
});
