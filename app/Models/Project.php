<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Project'
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $content
 * @property string $site_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ProjectUpdate[] $updates
 * @property-read \Illuminate\Database\Eloquent\Collection|\ProjectManager[] $managers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Subscription[] $subscribers
 * @property integer $owner_id
 * @property string $owner_type
 * @property-read mixed $href
 * @property-read \ $owner
 * @method static \Illuminate\Database\Query\Builder|\Project whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereSiteUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereOwnerType($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Project whereDeletedAt($value)
 */
class Project extends Model
{

    public static $rules = array(
        'name' => 'required',
        'slug' => 'required|unique:projects',
        'site_url' => 'required|url',
        'description' => 'required',
    );

    public function getHrefAttribute()
    {
        return action('Projects\\ProjectController@show', array($this->owner->slug, $this->slug));
    }

    public function share($provider)
    {
        $url = '';

        switch($provider) {
            case 'google':
                $url = "https://plus.google.com/share?url=" . urlencode($this->href);
                break;
            case 'twitter':
                $message = "Subscribe to " . e($this->name) . " on PatchNotes";

                $url = "https://twitter.com/intent/tweet?text=" . urlencode($message) . "&url=" . urlencode($this->href);
                break;
        }

        return $url;
    }

    /**
     * @param string $participant
     * @return bool|User|Organization
     * @throws Exception
     */
    public static function resolveParticipant($participant)
    {
        $user = User::where('username', $participant)->first();
        $organization = Organization::where('slug', $participant)->first();

        if ($user && $organization) {
            throw new \Exception("Found user and org record for {$participant}.");
        } elseif ($user && !$organization) {
            return $user;
        } elseif (!$user && $organization) {
            return $organization;
        }

        return false;
    }

    /**
     * Register a users subscription to a project.
     *
     * @param User $user
     * @param $levels
     * @return bool
     */
    public function subscribe(User $user, $levels = array())
    {
        if (empty($levels)) $levels = $user->getDefaultLevels();
        foreach ($levels as $level) {

            $projectUpdateLevel = ProjectUpdateLevel::where('level', $level['project_update_level'])->firstOrFail();
            $notificationLevel = NotificationLevel::where('level', $level['notification_level'])->firstOrFail();


            try {
                $subscription = new Subscription();

                $subscription->project_id = $this->id;
                $subscription->user_id = $user->id;
                $subscription->project_update_level_id = $projectUpdateLevel->id;
                $subscription->notification_level_id = $notificationLevel->id;

                $subscription->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }

        }

        return true;
    }

    public function unsubscribe(User $user)
    {
        $subscriptions = Subscription::where('user_id', $user->id)->where('project_id', $this->id)->get();

        foreach ($subscriptions as $subscription) {
            $subscription->delete();
        }

        return true;
    }

    public function isSubscriber(User $user)
    {
        return (boolean)Subscription::where('user_id', $user->id)->where('project_id', $this->id)->first();
    }

    /**
     * Get a unique count of subscribers
     *
     * @return integer
     */
    public function subscriberCount()
    {
        return count($this->subscribers()->distinct()->get(array('user_id')));
    }

    public function subscribers()
    {
        return $this->hasMany('PatchNotes\Models\Subscription');
    }

    public function updates()
    {
        return $this->hasMany('PatchNotes\Models\ProjectUpdate');
    }

    public function owner()
    {
        return $this->morphTo();
    }

}
