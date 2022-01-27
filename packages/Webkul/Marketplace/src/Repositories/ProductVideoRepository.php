<?php

namespace Webkul\Marketplace\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Webkul\Core\Eloquent\Repository;

class ProductVideoRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Marketplace\Contracts\ProductVideo';
    }

    /**
     * @param  array  $data
     * @param  \Webkul\Marketplace\Contracts\Product  $product
     * @return void
     */
    public function uploadVideos($data, $product)
    {
        $previousVideoIds = $product->assignVideos()->pluck('id');

        if (isset($data['videos'])) {
            foreach ($data['videos'] as $videoId => $video) {
                $file = 'videos.' . $videoId;
                $dir = 'product/assign/' . $product->id;

                if ($video instanceof UploadedFile) {
                    if (request()->hasFile($file)) {
                        $this->create([
                            'path'       => request()->file($file)->store($dir),
                            'marketplace_product_id' => $product->id,
                            'type'       => 'video'
                        ]);
                    }
                } else {
                    if (is_numeric($index = $previousVideoIds->search($videoId))) {
                        $previousVideoIds->forget($index);
                    }
                }
            }
        }

        foreach ($previousVideoIds as $videoId) {
            if ($videoModel = $this->find($videoId)) {
                Storage::delete($videoModel->path);

                $this->delete($videoId);
            }
        }
    }
}