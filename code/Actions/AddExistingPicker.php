<?php namespace Milkyway\SS\GridFieldUtils;

/**
 * Milkyway Multimedia
 * AddExistingPicker.php
 *
 * @package dispoze.com.au
 * @author Mellisa Hankins <mell@milkywaymultimedia.com.au>
 */

if (!class_exists('GridFieldAddExistingSearchButton')) {
    return;
}

use GridFieldAddExistingSearchButton as AddExistingSearchButton;
use GridFieldExtensions;
use Milkyway\SS\GridFieldUtils\Utilities;
use ArrayData;
use Milkyway\SS\GridFieldUtils\Controllers\AddExistingPicker as Controller;

class AddExistingPicker extends AddExistingSearchButton
{
    protected $searchHandlerFactory;
    protected $addHandler;

    /**
     * Sets a custom list to use to provide the searchable items.
     *
     * @param \Closure $searchHandlerFactory
     * @return self $this
     */
    public function setSearchHandlerFactory($searchHandlerFactory)
    {
        $this->searchHandlerFactory = $searchHandlerFactory;
        return $this;
    }

    /**
     * @return \Closure|null
     */
    public function getSearchHandlerFactory()
    {
        return $this->searchHandlerFactory;
    }

    /**
     * Sets a custom list to use to provide the searchable items.
     *
     * @param \Closure $addHandler
     * @return self $this
     */
    public function setAddHandler($addHandler)
    {
        $this->addHandler = $addHandler;
        return $this;
    }

    /**
     * @return \Closure|null
     */
    public function getAddHandler()
    {
        return $this->addHandler;
    }

    public function handleSearch($grid, $request)
    {
        if ($this->searchHandlerFactory) {
            return call_user_func($this->searchHandlerFactory, $grid, $this, $request);
        } else {
            return Controller::create(
                $grid,
                $this,
                $request
            );
        }
    }

    public function getHTMLFragments($grid)
    {
        GridFieldExtensions::include_requirements();
        Utilities::include_requirements();

        $data = ArrayData::create([
            'Title' => $this->getTitle(),
            'Link'  => $grid->Link('add-existing-search'),
        ]);

        return [
            $this->fragment => $data->renderWith([
                'GridField_AddExistingPicker',
                'GridFieldAddExistingSearchButton',
            ]),
        ];
    }
}