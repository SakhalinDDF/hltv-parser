<?php

declare(strict_types=1);

namespace common\rest;

use Yii;
use yii\web\Link;

class Serializer extends \yii\rest\Serializer
{
    public $methodDescriptionHeader = 'method';

    /**
     * @return array the names of the requested fields. The first element is an array
     * representing the list of default fields requested, while the second element is
     * an array of the extra fields requested in addition to the default fields.
     * @see Model::fields()
     * @see Model::extraFields()
     */
    protected function getRequestedFields()
    {
        $fields = $this->request->get($this->fieldsParam, '');
        $expand = $this->request->get($this->expandParam, '');

        if (\is_array($fields)) {
            $fields = \implode(',', $fields);
        }

        if (\is_array($expand)) {
            $expand = \implode(',', $expand);
        }

        return [
            \preg_split('/\s*,\s*/', $fields, -1, PREG_SPLIT_NO_EMPTY),
            \preg_split('/\s*,\s*/', $expand, -1, PREG_SPLIT_NO_EMPTY),
        ];
    }

    /**
     * Serializes a pagination into an array.
     *
     * @param \yii\data\Pagination $pagination
     *
     * @return array the array representation of the pagination
     * @see addPaginationHeaders()
     */
    protected function serializePagination($pagination)
    {
        return [
            $this->linksEnvelope => Link::serialize($pagination->getLinks(true)),
            $this->metaEnvelope  => [
                'count'      => $pagination->totalCount,
                'page_count' => $pagination->getPageCount(),
                'page_num'   => $pagination->getPage() + 1,
                'per_page'   => $pagination->getPageSize(),
            ],
        ];
    }

    /**
     * Adds HTTP headers about the pagination to the response.
     *
     * @param \yii\data\Pagination $pagination
     */
    protected function addPaginationHeaders($pagination)
    {
        $links = [];

        $pagination->route = Yii::$app->controller->action->uniqueId;

        foreach ($pagination->getLinks(true) as $rel => $url) {
            $links[] = "<$url>; rel=$rel";
        }

        $method_name = \strtr(Yii::$app->controller->action->uniqueId, ['/' => '-', '_' => '-']);
        $method_url  = Yii::$app->getUrlManager()->createAbsoluteUrl(['main/explain', 'name' => $method_name]);
        $links[]     = "<{$method_url}>; rel=method";

        $this->response->getHeaders()
            ->set($this->totalCountHeader, $pagination->totalCount)
            ->set($this->pageCountHeader, $pagination->getPageCount())
            ->set($this->currentPageHeader, $pagination->getPage() + 1)
            ->set($this->perPageHeader, $pagination->pageSize)
            ->set($this->methodDescriptionHeader)
            ->set('Link', \implode(', ', $links));
    }
}
