<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $pagination;
    public $perPageOptions;
    public $perPage;

    /**
     * Create a new component instance.
     *
     * @param $pagination The paginated data object
     * @param array $perPageOptions Options for items per page
     * @param int $perPage The current per-page value
     */
    public function __construct($pagination, $perPage = 10, $perPageOptions = [5, 10, 25, 50])
    {
        $this->pagination = $pagination;
        $this->perPage = $perPage;
        $this->perPageOptions = $perPageOptions;
    }

    /**
     * Get the view for the component.
     */
    public function render()
    {
        return view('components.pagination');
    }
}
