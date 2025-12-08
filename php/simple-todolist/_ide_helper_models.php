<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property bool $is_completed
 * @property string $priority
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Todo withoutTrashed()
 */
	class Todo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Todo> $todos
 * @property-read int|null $todos_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

