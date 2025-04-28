<?php

namespace Aaran\Neot\Services;

use Aaran\Neot\Models\ChatbotIntent;

class DynamicQueryHandler
{
    protected $connection;
    protected $intent;
    protected $user;

    public function __construct($connection, ChatbotIntent $intent, $user = null)
    {
        $this->connection = $connection;
        $this->intent = $intent;
        $this->user = $user;
    }

    public function handle()
    {
        // 1. If static_response exists, return it immediately
        if (!empty($this->intent->static_response)) {
            return $this->intent->static_response;
        }

        // 2. Otherwise, build dynamic query
        $modelClass = $this->intent->model_class;
        $columns = json_decode($this->intent->columns, true) ?? ['*'];
        $whereConditions = json_decode($this->intent->where_conditions, true) ?? [];
        $viewTemplate = $this->intent->view_template;

        $query = $modelClass::on($this->connection)->select($columns);

        foreach ($whereConditions as $condition) {
            [$column, $operator, $value] = $condition;

            // Replace dynamic placeholders like {{user_id}}
            $value = $this->replacePlaceholders($value);

            $query->where($column, $operator, $value);
        }

        $results = $query->get();

        return view($viewTemplate, ['results' => $results])->render();
    }

    protected function replacePlaceholders($value)
    {
        if (is_string($value)) {
            if (strpos($value, '{{user_id}}') !== false && $this->user) {
                $value = str_replace('{{user_id}}', $this->user->id, $value);
            }
            // You can add more placeholders here in future if needed
        }

        return $value;
    }
}
