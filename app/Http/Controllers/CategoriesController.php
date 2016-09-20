<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    const FILTER_DYNAMIC = 'dynamic';

    const FILTER_STATIC = 'static';

    /**
     * @var CategoryRepository
     */
    protected $categories;

    /**
     * @var TagRepository
     */
    protected $tags;

    /**
     * CategoriesController constructor.
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->categories = $categoryRepository;
        $this->tags = $tagRepository;
    }

    /**
     * Get list of unchanged/static filters.
     *
     * @return array
     */
    final static public function getStaticFilters()
    {
        return [ 'price_min', 'price_max' ];
    }

    /**
     * Show action for category.
     *
     * @param Request $request
     * @param Category $category
     *
     * @return $this
     */
    public function show(Request $request, $category)
    {
        $groups = $this->tags->getCategoryTagGroups($category);

        $filtered = $this->applyFilter($request, $category);

        return view(($request->ajax()) ? 'categories.partials.filter_result' : 'categories.index', [
            'category' => $category, 'products' => $filtered, 'groups' => $groups ]
        );
    }

    /**
     * Apply filters for category scope.
     *
     * @param Request $request
     * @param Category $category
     *
     * @return mixed
     */
    protected function applyFilter(Request $request, Category $category)
    {
        if($filters = $request->all() ? : false)
            list($static, $dynamic) = $this->separateFilters($filters);

        $query = $category->categoryables()
            ->elementType(Product::class)
            ->getQuery();

        if(isset($static) && $static = $this->clearStaticFilters($static))
            $query = $this->applyStaticFilter($query, $static);

        if(isset($dynamic) && $dynamic = $this->clearDynamicFilters($dynamic, $category))
            $query = $this->applyDynamicFilter($query, $dynamic);

        return $query->where('categoryable.active', 1)->get();
    }

    /**
     * Apply static filters.
     *
     * @param $query
     * @param array|null $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyStaticFilter($query, array $filters = null)
    {
        /** Price range static filter. */
        if(isset($filters['price_min']) && isset($filters['price_max']))
        {
            /* todo: find the better solution to perform price range filter. */

            $query
                /* In future possible Join `products` can be replaced above ..*/
                ->join('products', 'products.id', '=', 'categoryable.categoryable_id')
                ->whereBetween('products.price', array($filters['price_min'], $filters['price_max']));
        }

        return $query;
    }

    /**
     * Apply static filters.
     *
     * @param $query
     * @param array|null $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyDynamicFilter($query, array $filters = null)
    {
//        $tags = '';
//        $i = 0;
//        $dynamic_count = count($filters);
//        array_walk($dynamic, function($filter_val, $filter) use (&$query, &$tags, $dynamic, $dynamic_count, &$i){
//                list($group, $tag) = $this->parseDynamicFilter($filter);
//
//                $i == $dynamic_count ? $tags .= sprintf('%s,', $tag) : $tags .= $tag;
//
//                  $query->whereGroup($group);
//                $i++;
//            });
//
//        $query->withAllTags($tags);

        return $query;
    }

    /**
     * Clear static filters.
     *
     * @param $filters
     *
     * @return array|null
     */
    protected function clearStaticFilters($filters)
    {
        $available_filters = array_flip($this->getStaticFilters());

        $filters = array_filter($filters, function($filter_v, $filter_k) use ($available_filters){
            return isset($available_filters[$filter_k]);
        }, ARRAY_FILTER_USE_BOTH);

        return (!empty($filters)) ? $filters : null;
    }

    /**
     * Clean dynamic filters.
     *
     * @param $filters
     * @param \App\Category $category
     *
     * @return array|null
     */
    protected function clearDynamicFilters($filters, $category)
    {
        $available_filters = $this->tags->getAvailableDynamicFilters($category);

        $filters = array_filter($filters, function($filter) use ($available_filters){
            list($group, $tag) = $this->parseDynamicFilter($filter);

            $group = ucfirst($group);

            if(isset($available_filters[$group]))
                return in_array($tag, $available_filters[$group]);
        }, ARRAY_FILTER_USE_KEY);

        return (!empty($filters)) ? $filters : null;
    }

    /**
     * Separate filters.
     *
     * @param $filters
     *
     * @return array
     */
    protected function separateFilters($filters)
    {
        $static_filters = $this->getStaticFilters();

        $static = [];
        $dynamic = $filters;
        array_walk($static_filters, function($static_filter) use (&$static, &$dynamic){
            $static[$static_filter] = $dynamic[$static_filter];

            unset($dynamic[$static_filter]);
        });

        return [ $static, $dynamic ];
    }

    /**
     * Parse dynamic filter. First element must be an a group,
     * and the second is a tag.
     *
     * @param $filter
     * @param string $separator
     *
     * @return array
     */
    public function parseDynamicFilter($filter, $separator = '_')
    {
        list($group, $tag) = explode($separator, $filter);

        $group = ucfirst($group);

        return [ $group, $tag ];
    }
}