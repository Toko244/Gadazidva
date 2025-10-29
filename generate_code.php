<?php
/**
 * Code Generation Script for Gadazidva Platform
 * This script generates all remaining model files and basic infrastructure
 */

// Define all models and their properties
$models = [
    'HelperPost' => [
        'fillable' => ['driver_id', 'title', 'description', 'location_address', 'location_city', 'location_latitude', 'location_longitude', 'required_date', 'duration_hours', 'helpers_needed', 'offered_rate', 'contact_phone', 'requirements', 'status', 'is_published'],
        'casts' => ['required_date' => 'datetime', 'offered_rate' => 'decimal:2', 'location_latitude' => 'decimal:7', 'location_longitude' => 'decimal:7', 'is_published' => 'boolean'],
        'relationships' => [
            'driver' => ['BelongsTo', 'User', 'driver_id'],
        ],
        'traits' => ['SoftDeletes'],
    ],
    'AssistantProfile' => [
        'fillable' => ['user_id', 'bio', 'skills', 'years_of_experience', 'hourly_rate', 'rating', 'total_jobs', 'has_own_tools', 'is_verified', 'is_active'],
        'casts' => ['hourly_rate' => 'decimal:2', 'rating' => 'decimal:2', 'has_own_tools' => 'boolean', 'is_verified' => 'boolean', 'is_active' => 'boolean'],
        'relationships' => [
            'user' => ['BelongsTo', 'User'],
        ],
        'traits' => ['SoftDeletes'],
    ],
    'VehicleType' => [
        'fillable' => ['name', 'slug', 'description', 'is_active'],
        'casts' => ['is_active' => 'boolean'],
        'relationships' => [
            'driverProfiles' => ['HasMany', 'DriverProfile'],
        ],
        'traits' => ['SoftDeletes'],
    ],
    'CargoType' => [
        'fillable' => ['name', 'slug', 'description', 'is_active'],
        'casts' => ['is_active' => 'boolean'],
        'relationships' => [
            'servicePosts' => ['HasMany', 'ServicePost'],
        ],
        'traits' => ['SoftDeletes'],
    ],
    'ServicePostImage' => [
        'fillable' => ['service_post_id', 'image_path', 'image_name', 'order', 'is_primary'],
        'casts' => ['is_primary' => 'boolean'],
        'relationships' => [
            'servicePost' => ['BelongsTo', 'ServicePost'],
        ],
        'traits' => [],
    ],
    'DriverProfileImage' => [
        'fillable' => ['driver_profile_id', 'image_path', 'image_name', 'type', 'order', 'is_primary'],
        'casts' => ['is_primary' => 'boolean'],
        'relationships' => [
            'driverProfile' => ['BelongsTo', 'DriverProfile'],
        ],
        'traits' => [],
    ],
];

// Generate model content
function generateModel($modelName, $config) {
    $traits = ['HasFactory'];
    if (isset($config['traits'])) {
        $traits = array_merge($traits, $config['traits']);
    }

    $traitsString = implode(', ', $traits);
    $fillable = "'" . implode("', '", $config['fillable']) . "'";

    $castsArray = [];
    foreach ($config['casts'] as $key => $value) {
        $castsArray[] = "'$key' => '$value'";
    }
    $casts = implode(",\n            ", $castsArray);

    $relationships = '';
    if (isset($config['relationships'])) {
        foreach ($config['relationships'] as $name => $relConfig) {
            $type = $relConfig[0];
            $model = $relConfig[1];
            $foreignKey = isset($relConfig[2]) ? ", '{$relConfig[2]}'" : '';
            $relationships .= "\n    public function $name(): $type\n    {\n        return \$this->".lcfirst($type)."($model::class$foreignKey);\n    }\n";
        }
    }

    $useStatements = "use Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Model;";
    if (in_array('SoftDeletes', $traits)) {
        $useStatements .= "\nuse Illuminate\Database\Eloquent\SoftDeletes;";
    }
    if (isset($config['relationships'])) {
        $relationTypes = array_unique(array_column($config['relationships'], 0));
        foreach ($relationTypes as $relType) {
            $useStatements .= "\nuse Illuminate\Database\Eloquent\Relations\\$relType;";
        }
    }

    return "<?php

namespace App\Models;

$useStatements

class $modelName extends Model
{
    use $traitsString;

    protected \$fillable = [$fillable];

    protected function casts(): array
    {
        return [
            $casts
        ];
    }
$relationships
}
";
}

// Output instructions
echo "===========================================\n";
echo "Gadazidva Code Generation Script\n";
echo "===========================================\n\n";

echo "This script contains model definitions for:\n";
foreach (array_keys($models) as $model) {
    echo "- $model\n";
}

echo "\nTo use this script, copy the generateModel() function and model definitions\n";
echo "into your Laravel application and generate the models programmatically.\n\n";

echo "Alternatively, the models have already been created via artisan commands.\n";
echo "You can now update them manually using the definitions above.\n";
