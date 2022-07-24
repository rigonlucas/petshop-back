<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AppJsonResource extends JsonResource
{
    protected array $availableIncludes = [];

    protected array $defaultIncludes = [];

    protected Request $request;

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $this->request = $request;

        $requestIncludes = explode(',', $request->query('include'));
        $includes = array_merge(
            $this->defaultIncludes,
            array_intersect(
                $this->availableIncludes,
                $requestIncludes
            )
        );

        $resourceData = $this->resource($request);

        $resolvedIncludes = $this->resolveIncludes($includes);

        return array_merge($resourceData, $resolvedIncludes);
    }

    private function resolveIncludes(array $includes): array
    {
        $resolvedIncludes = [];
        foreach ($includes as $include) {
            $includeMethodName = "include{$include}";

            if (method_exists($this, $includeMethodName)) {
                $callable = [$this, $includeMethodName];

                $resolvedIncludes[$include] = $callable($this->request);
            }
        }

        return $resolvedIncludes;
    }

    abstract function resource($request);
}