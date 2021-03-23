<?php

namespace App\Http\Controllers\Traits;

use Config;
use Input;
use Carbon\Carbon;
use App\Models\Category;
/**
 * 
 */
trait TableSortingAndFilteringTrait {

	//Default option for filtering type. 
	//Options: request | cookie
	private $defaultTableSortFilterType = 'request';
	protected $numFilteredParameters = 0;
	
	public function tableSort($query) {
		if (property_exists($this, 'tableSortables') && \Request::has('sort')) {
			//Sort by column
			if (array_key_exists(\Request::get('sort'), $this->tableSortables)) {
				$sortColumn = $this->tableSortables[\Request::get('sort')];
				$query->orderBy($sortColumn, \Request::get('order'));
			}
		} else {
			//Use default sorting - if available
			if (property_exists($this, 'tableSortDefault')) {
				$query->orderBy($this->tableSortDefault, 'ASC');
			}
		}

		return $query;
	}

	public function tableFilter($query) {
		if (!property_exists($this, 'tableFilters')) {
			return $query;
		}
		
		$this->numFilteredParameters = 0;
		
		\SortFilterHelper::setTag($this->tableSortFilterTag);
		$filters = \SortFilterHelper::getFilters();
		foreach ($this->tableFilters as $key => $filter) {
			

			if (key_exists($key, $filters)) {
				$val = $filters[$key];

					if (is_array($val)) {	
						$query->whereIn($filter, $val);
					    $this->numFilteredParameters++;
					} else if (is_numeric($val)) {
						$query->where($filter, '=', $val);
						$this->numFilteredParameters++;
					} else if ($this->isTableFilterValueDate($val)) {
						$query->where($filter, '=', Carbon::createFromFormat('d/m/Y', $val)->toDateString());
						$this->numFilteredParameters++;
					} else {
						$query->where($filter, 'LIKE', '%' . $val . '%');
						$this->numFilteredParameters++;
					}

			   
				
			}
		}
		
		return $query;
	}

	public function tableCustomFilter($query) {
		if (!property_exists($this, 'tableFilters')) {
			return $query;
		}
		
		$this->numFilteredParameters = 0;
		
		\SortFilterHelper::setTag($this->tableSortFilterTag);
		$filters = \SortFilterHelper::getFilters();
		foreach ($this->tableFilters as $key => $filter) {
			

			if (key_exists($key, $filters)) {
				$val = $filters[$key];

					if (is_array($val)) {
						
						if($val[0] != 'any'){
							
						 $query->whereIn($filter, $val);
					      $this->numFilteredParameters++;
						}else{
							$this->numFilteredParameters--;
						}
					
					} else if (is_numeric($val)) {
						$query->where($filter, '=', $val);
						$this->numFilteredParameters++;
					} else if ($this->isTableFilterValueDate($val)) {
						$query->where($filter, '=', Carbon::createFromFormat('d/m/Y', $val)->toDateString());
						$this->numFilteredParameters++;
					} else {
						$query->where($filter, 'LIKE', '%' . $val . '%');
						$this->numFilteredParameters++;
					}

			   
				
			}
		}
		
		return $query;
	}
	
	private function isTableFilterValueDate($val) {
		if (substr_count($val, '/') === 2) {
			return true;
		}
		return false;
	}

	public function tablePaginate($query) {
		$rpp = Config::get('storefronts-backoffice.pagination-default');
		if (\Request::has('rpp')) {
			$rpp = \Request::get('rpp');
		}

		return $query->paginate($rpp);
	}

}
