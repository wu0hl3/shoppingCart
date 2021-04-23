<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $order_no
 * @property string $receive_name
 * @property string $receive_phone
 * @property string $receive_mobile
 * @property string $receive_address
 * @property string $receive_email
 * @property string $receipt
 * @property string $time_to_send
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 * @property OrderItem[] $orderItems
 */
class Order extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['order_no', 'receive_name', 'receive_phone', 'receive_mobile', 'receive_address', 'receive_email', 'receipt', 'time_to_send', 'remark', 'status','total_price', 'created_at', 'updated_at','deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany('App\OrderItems')->with('product');
    }
}
