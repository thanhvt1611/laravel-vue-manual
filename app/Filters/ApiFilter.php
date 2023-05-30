<?php

namespace App\Filters;
use Illuminate\Http\Request;

Class ApiFilter {
    protected $safeParams = [];

    protected $columnMap = [];
    
    private $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'like',
        'ne' => '!=',
    ];

    public function transform(Request $request) {
        $eloQuery = [];
        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);
            if(!$query) {
                continue;
            }
            $column = $this->columnMap[$param] ?? $param;
            foreach ($operators as $operator) {
                if(isset($query[$operator])) {
                    if($this->operatorMap[$operator] === 'like') {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], '%' . $query[$operator] . '%'];
                    } else {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                    }
                }
            }
        }

        return $eloQuery;
    }
}