<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_templates';

    public function tenantTemplate() {
        return $this->hasOne(EmailTemplate::class, 'slug', 'slug')->whereNotNull('tenant_id');
    }
}