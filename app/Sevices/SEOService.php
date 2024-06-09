<?php

namespace App\Sevices;

use Illuminate\Http\Request;

class SEOService
{
    public function createOrUpdate(Request $request, $seoable)
    {
        $data = $request->validate([
            'meta_title.*' => 'nullable|string|max:255',
            'meta_description.*' => 'nullable|string|max:255',
            'meta_keywords.*' => 'nullable|string|max:255',
            'canonical.*' => 'nullable|string|max:255',
            'alt_image.*' => 'nullable|string|max:255',
        ]);

        $seo = $seoable->seo()->updateOrCreate(
            ['seoable_id' => $seoable->id, 'seoable_type' => get_class($seoable)],
            $data
        );

        return $seo;
    }

    public function delete($seoable)
    {
        $seoable->seo()->delete();
    }
}
