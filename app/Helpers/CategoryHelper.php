<?php

namespace App\Helpers;

use App\Models\Categories;

class CategoryHelper
{
    public static function buildNestedCategories($categories, $parentId = 0, $depth = 0)
    {
        $nestedCategories = [];

        foreach ($categories as $category) {
            if ($category->parent_category == $parentId) {
                $category->depth = $depth;
                $category->children = self::buildNestedCategories($categories, $category->id, $depth + 1);
                $nestedCategories[] = $category;
            }
        }

        return $nestedCategories;
    }

    // public static function generateDropdownOptions($categories, $selectedCategory, $indentation = '')
    // {
    //     $options = '';

    //     foreach ($categories as $category) {
    //         $options .= '<option value="' . $category->id . '"';
    //         if ($category->id == $selectedCategory) {
    //             $options .= ' selected';
    //         }
    //         $options .= '>' . $indentation . str_repeat('- ', $category->depth) . $category->name . '</option>';

    //         if ($category->children && count($category->children) > 0) {
    //             $options .= self::generateDropdownOptions($category->children, $selectedCategory, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation);
    //         }
    //     }

    //     return $options;
    // }

    public function generateDropdownOptions($categories, $selectedCategories, $indentation = '', $depth = 0)
    {
        $options = '';

        foreach ($categories as $category) {
            $options .= '<option value="' . $category->id . '"';

            if (in_array($category->id, $selectedCategories)) {
                $options .= ' selected';
            }

            $options .= '>' . str_repeat('- ', $depth) . $category->name . '</option>';

            if ($category->children && count($category->children) > 0) {
                $options .= $this->generateDropdownOptions($category->children, $selectedCategories, '&nbsp;&nbsp;&nbsp;&nbsp;' . $indentation, $depth + 1);
            }
        }

        return $options;
    }



}


