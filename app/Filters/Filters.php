<?php
namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * Request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new ThreadFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->getFilters() as $filter => $value)
        {
            if (method_exists($this, $filter))
            {
                $this->$filter($value);
            }
        }

        return $this->query;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
