<?php

/**
 * Paginator
 * 
 * Data for selecting a page of records
 */
class Paginator
{
    /**
     * Number of records to return
     * @var int
     */
    public int $limited;

    /**
     * Number of records to skip before the page 
     * @var int
     */
    public int $offset;

    /**
     * Number of previous page
     * @var int|null
     */
    public ?int $previous;

    /**
     * Number of next page
     * @var int|null
     */
    public ?int $next;

    /**
     * Constructor 
     * 
     * @param int|string $page Page number
     * @param int $records_per_page Number of records per page
     * @param int $total_records Total number of records
     * 
     * @return void
     */
    public function __construct(int|string $page, int $records_per_page, int $total_records)
    {
        $this->limited = $records_per_page;

        $page = filter_var($page, FILTER_VALIDATE_INT, [
            'options' => [
                'default' => 1,
                'min_range' => 1,
            ]
        ]);

        if ($page > 1) {
            $this->previous = $page - 1;
        } else {
            $this->previous = null;
        }

        $total_pages = ceil($total_records / $records_per_page);

        if ($page < $total_pages) {
            $this->next = $page + 1;
        } else {
            $this->next = null;
        }


        $this->offset = $records_per_page * ($page - 1);
    }
}
