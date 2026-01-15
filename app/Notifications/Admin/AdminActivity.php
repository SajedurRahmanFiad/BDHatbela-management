<?php

namespace App\Notifications\Admin;

use App\Abstracts\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminActivity extends Notification
{
    public $actor;
    public $action;
    public $model;
    public $url;

    public function __construct($actor, string $action, $model = null, string $url = '')
    {
        parent::__construct();

        $this->actor = $actor;
        $this->action = $action;
        $this->model = $model;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        // Only store in database notifications for admin activity (no emails)
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $model_type = is_object($this->model) ? class_basename($this->model) : null;
        $model_id = is_object($this->model) && property_exists($this->model, 'id') ? $this->model->id : null;

        return [
            'title' => trans('notifications.admin.activity.title', ['actor' => $this->actor->name, 'action' => $this->action]),
            'description' => trans('notifications.admin.activity.description', ['actor' => $this->actor->name, 'action' => $this->action, 'model' => $model_type, 'id' => $model_id]),
            'actor_id' => $this->actor->id,
            'model_type' => $model_type,
            'model_id' => $model_id,
            'url' => $this->url,
        ];
    }
}
