<?php

namespace Aaran\Neot\Services;

use Aaran\Neot\Models\ChatbotIntent;

class DynamicQueryHandler
{
    protected $connection;
    protected $intent;

    public function __construct($connection, ChatbotIntent $intent)
    {
        $this->connection = $connection;
        $this->intent = $intent;
    }

    public function handle()
    {
        $modelClass = $this->intent->model_class;
        $columns = json_decode($this->intent->columns, true) ?? ['*'];
        $whereConditions = json_decode($this->intent->where_conditions, true) ?? [];
        $viewTemplate = $this->intent->view_template;

        $query = $modelClass::on($this->connection)->select($columns);

        foreach ($whereConditions as $condition) {
            [$column, $operator, $value] = $condition;
            $query->where($column, $operator, $value);
        }

        $results = $query->get();

        return view($viewTemplate, ['results' => $results])->render();
    }
}
