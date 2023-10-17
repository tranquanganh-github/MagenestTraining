<?php

namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Rating extends Column
{
    /**
     * @inheirtDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!empty($item['rating'])) {
                $item['rating'] = $this->renderStarRating($item['rating']);
            }
        }

        return $dataSource;
    }

    /**
     * Rendering store visibility structure
     *
     * @param int $rating
     *
     * @return string
     * @since 100.1.0
     */
    protected function renderStarRating(int $rating)
    {
        $ratingStars = '';
        if ($rating) {
            $ratingStars .= '<div class="control review-control-vote" >';
            for ($x = 0; $x < 5; $x++) {
                if (($x + 1) <= (round(($rating * 0.05), 0))) {
                    $ratingStars .= '<span style="color: rgb(241,194,78);">★</span>';
                } else {
                    $ratingStars .= '<span style="color: rgb(204, 204, 204);">★</span>';
                }
            }
            $ratingStars .= '</div>';
        }

        return $ratingStars;
    }
}
