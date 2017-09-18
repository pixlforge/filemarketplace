<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\File
 *
 * @property int $id
 * @property string $identifier
 * @property int $user_id
 * @property string $title
 * @property string $overview_short
 * @property string $overview
 * @property float $price
 * @property bool $live
 * @property bool $approved
 * @property int $finished
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FileApproval[] $approvals
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sale[] $sales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File finished()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\File onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File unapproved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFinished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereOverviewShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\File withoutTrashed()
 */
	class File extends \Eloquent {}
}

namespace App{
/**
 * App\FileApproval
 *
 * @property int $id
 * @property int $file_id
 * @property string $title
 * @property string $overview_short
 * @property string $overview
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\File $file
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\FileApproval onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereOverviewShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileApproval whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FileApproval withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\FileApproval withoutTrashed()
 */
	class FileApproval extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Sale
 *
 * @property int $id
 * @property string $identifier
 * @property int|null $user_id
 * @property int|null $file_id
 * @property string $buyer_email
 * @property float $sale_price
 * @property float $sale_commission
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\File|null $file
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereBuyerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereSaleCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereUserId($value)
 */
	class Sale extends \Eloquent {}
}

namespace App{
/**
 * App\Upload
 *
 * @property int $id
 * @property int $user_id
 * @property int $file_id
 * @property string $filename
 * @property int $size
 * @property int $approved
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\File $file
 * @property-read mixed $path
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload approved()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload unapproved()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Upload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Upload withoutTrashed()
 */
	class Upload extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $stripe_key
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sale[] $sales
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStripeKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

