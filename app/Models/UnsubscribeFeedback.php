<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UnsubscribeFeedback
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $feedback
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\UnsubscribeFeedback whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UnsubscribeFeedback whereUserId($value) 
 * @method static \Illuminate\Database\Query\Builder|\UnsubscribeFeedback whereFeedback($value) 
 * @method static \Illuminate\Database\Query\Builder|\UnsubscribeFeedback whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\UnsubscribeFeedback whereUpdatedAt($value) 
 */
class UnsubscribeFeedback extends Model
{
    protected $table = 'unsubscribe_feedback';
}
