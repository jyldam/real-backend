<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\CallBack
 *
 * @property int $id
 * @property int $employee_id
 * @property string $phone
 * @property \Illuminate\Support\Collection $extra
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack query()
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallBack whereUpdatedAt($value)
 */
	class CallBack extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Characteristic
 *
 * @property int $id
 * @property int $characteristic_category_id
 * @property string $name
 * @property string $label
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CharacteristicCategory $characteristicCategory
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereCharacteristicCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Characteristic whereUpdatedAt($value)
 */
	class Characteristic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CharacteristicCategory
 *
 * @property int $id
 * @property string $name
 * @property int $housing_category_id
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Characteristic> $characteristics
 * @property-read int|null $characteristics_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CharacteristicCategory> $children
 * @property-read int|null $children_count
 * @property-read CharacteristicCategory|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory whereHousingCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CharacteristicCategory whereUpdatedAt($value)
 */
	class CharacteristicCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property int $user_id
 * @property string $avatar_url
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $avatar_file
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee admins()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GivingType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType query()
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GivingType whereUpdatedAt($value)
 */
	class GivingType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Housing
 *
 * @property int $id
 * @property int $housing_category_id
 * @property int $price
 * @property int $employee_id
 * @property int $region_id
 * @property string $address
 * @property int $giving_type
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Characteristic> $characteristics
 * @property-read int|null $characteristics_count
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\GivingType|null $givingTypeSlug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HousingAsset> $housingAssets
 * @property-read int|null $housing_assets_count
 * @property-read \App\Models\HousingCategory $housingCategory
 * @property-read \App\Models\Region $region
 * @method static \Illuminate\Database\Eloquent\Builder|Housing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Housing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Housing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereGivingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereHousingCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housing whereUpdatedAt($value)
 */
	class Housing extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HousingAsset
 *
 * @property int $id
 * @property int $housing_id
 * @property string $url
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset whereHousingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingAsset whereUrl($value)
 */
	class HousingAsset extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HousingCategory
 *
 * @property int $id
 * @property string $name
 * @property string $mesh_name
 * @property bool $disabled
 * @property int $sort
 * @property mixed $preview_characteristics
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CharacteristicCategory> $characteristicCategories
 * @property-read int|null $characteristic_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereMeshName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory wherePreviewCharacteristics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingCategory whereUpdatedAt($value)
 */
	class HousingCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HousingMetric
 *
 * @property int $id
 * @property int $housing_id
 * @property string $name
 * @property mixed $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric query()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric whereHousingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HousingMetric whereValue($value)
 */
	class HousingMetric extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $phone
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

